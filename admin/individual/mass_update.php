<?php
// Ensure error reporting is on for debugging
include('db.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);
error_log("An error occurred: " . print_r($_POST, true));
error_log("Incoming POST Data: " . print_r($_POST, true));  // Log all POST data
ini_set('error_log', 'error_log.txt');


// Example logic for mass update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the necessary parameters are set
    if (isset($_POST['ids'], $_POST['status'])) {
        $ids = $_POST['ids'];
        $status = $_POST['status'];
        $disbursement_date = isset($_POST['disbursement_date']) ? $_POST['disbursement_date'] : null;
        $reviewed_by = isset($_POST['reviewed_by']) ? $_POST['reviewed_by'] : null;

        // Example: Just print the incoming data for now
        echo json_encode([
            'ids' => $ids,
            'status' => $status,
            'disbursement_date' => $disbursement_date,
            'reviewed_by' => $reviewed_by
        ]);

        // Your database update logic here...
        // Example:
        // $conn->query("UPDATE individual_list SET status = '$status' WHERE id IN (" . implode(',', $ids) . ")");

    } else {
        // Handle missing parameters
        echo json_encode(['error' => 'Missing required parameters']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if IDs and new status, disbursement_date and are provided
if (isset($_POST['ids']) && isset($_POST['status']) && isset($_POST['disbursement_date'])) {
    $ids = $_POST['ids']; // This is already an array
    $status = $_POST['status'];
    $disbursement_date = $_POST['disbursement_date'];
    $reviewed_by = $_POST['reviewed_by'];

    // Convert the array of IDs to a safe string for the SQL IN clause
    $idList = implode(',', array_map('intval', $ids)); // Convert IDs to integers for safety

    // SQL query to update the status of selected individuals
    $sql = "UPDATE individual_list SET status = ?, status_client = 1 WHERE id IN ($idList)";


    // Prepare and execute the update query
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $status); // Bind status as integer
        if ($stmt->execute()) {
            // Mass update successful, now proceed with processing individual updates
            $resp = process_individuals($ids, $status, $disbursement_date, $reviewed_by);
            echo json_encode($resp); // Return JSON response to client
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Could not prepare the statement.";
    }
} else {
    echo "Invalid request.";
}

// Function to handle individual processing and budget deductions
function process_individuals($ids, $status, $disbursement_date, $reviewed_by)
{
    global $conn; // Access the global DB connection

    $resp = ['status' => 'success', 'msg' => 'All selected individuals updated successfully and budget updated if necessary.'];

    // Step 1: Define the deduction amounts for each scheme
    $scheme_deductions = [
        'BPEAP - 3K' => 3000,
        'BPEAP - 4K' => 4000,
        'BPEAP - 5K' => 5000,
        'SCHEME 1 - 25K' => 25000,
        'SCHEME 2 - 10K' => 10000,
    ];

    // Step 2: Loop through each selected individual ID and apply the logic
    foreach ($ids as $id) {
        // Step 3: Retrieve the scheme_name from scheme_list based on scheme_id in individual_list
        $scheme_query = $conn->query("SELECT s.name, s.id FROM `scheme_list` s
                                      JOIN `individual_list` i ON s.id = i.scheme_id
                                      WHERE i.id = {$id} LIMIT 1");

        if ($scheme_query->num_rows > 0) {
            $scheme_row = $scheme_query->fetch_assoc();
            $scheme_name = $scheme_row['name'];  // Retrieve the scheme name
            $scheme_id = $scheme_row['id'];  // Scheme ID

            // Fetch district name from individual_list (optimized)
            $district_query = $conn->query("SELECT district_name FROM `individual_list` WHERE id = {$id} LIMIT 1");
            if ($district_query->num_rows > 0) {
                $district_row = $district_query->fetch_assoc();
                $district_name = $district_row['district_name'];  // Location (district_name)
            }
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = "Individual with ID {$id} has no scheme or scheme not found.";
            return $resp; // Early return if scheme not found
        }

        // Step 4: Check if scheme exists in the deduction array
        if (!array_key_exists($scheme_name, $scheme_deductions)) {
            $resp['status'] = 'failed';
            $resp['msg'] = "Scheme '{$scheme_name}' not recognized for deduction.";
            return $resp;
        }

        // Step 5: Calculate the deduction amount based on the scheme
        $deduction_amount = $scheme_deductions[$scheme_name];

        // Step 6: Proceed with budget deduction if status is 2 (Disbursement Completed)
        if ($status == 2) {
            // Fetch the oldest budget record with status 1 (disbursement completed)
            $budget_query = $conn->query("SELECT * FROM `budget` WHERE `status` = 1 ORDER BY `date_created` ASC LIMIT 1");

            if ($budget_query->num_rows > 0) {
                $budget = $budget_query->fetch_assoc();

                // Check if there is enough remaining amount to deduct
                if ($budget['amount'] >= $deduction_amount) {
                    // Calculate the new remaining amount and issued amount
                    $new_remaining_amount = $budget['amount'] - $budget['issued_amount'] - $deduction_amount;
                    $new_issued_amount = $budget['issued_amount'] + $deduction_amount;

                    // Update the budget table with the new remaining and issued amounts
                    $update_budget_query = "UPDATE `budget` SET `remaining_amount` = ?, `issued_amount` = ? WHERE `id` = ?";
                    if ($update_stmt = $conn->prepare($update_budget_query)) {
                        $update_stmt->bind_param("ddi", $new_remaining_amount, $new_issued_amount, $budget['id']);
                        if (!$update_stmt->execute()) {
                            $resp['status'] = 'failed';
                            $resp['msg'] = 'Error updating budget: ' . $update_stmt->error;
                            return $resp;
                        }
                    } else {
                        $resp['status'] = 'failed';
                        $resp['msg'] = 'Error preparing update query for budget: ' . $conn->error;
                        return $resp;
                    }
                    // Optionally, update the status of the budget to fully disbursed if remaining amount is 0
                    if ($new_remaining_amount <= 0) {
                        $conn->query("UPDATE `budget` SET `status` = 2 WHERE `id` = '{$budget['id']}'");  // Fully Disbursed
                    }
                } else {
                    // Not enough budget available
                    $resp['status'] = 'failed';
                    $resp['msg'] = 'Insufficient budget to deduct the specified amount.';
                    return $resp;
                }
            } else {
                // No budget found with status 1
                $resp['status'] = 'failed';
                $resp['msg'] = 'No valid budget found to deduct from.';
                return $resp;
            }
        }

        // Step 7: Insert into scholar_history_list after successfully updating the budget
        $disbursement_status = ($status == 2) ? 'Disbursed' : 'Pending';  // Example of setting disbursement status

        $insert_query = "INSERT INTO scholar_history_list 
                        (individual_id, scheme_id, district_name, date_disbursed, disbursement_status, reviewed_by) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        error_log("Incoming POST Data: " . print_r($insert_query));  // Log inserted data
        if ($insert_stmt = $conn->prepare($insert_query)) {
            $insert_stmt->bind_param("iissss", $id, $scheme_id, $district_name, $disbursement_date, $disbursement_status, $reviewed_by);
            if (!$insert_stmt->execute()) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Error inserting into scholar_history_list: ' . $insert_stmt->error;
                return $resp;
            }
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = 'Error preparing insert query for scholar_history_list: ' . $conn->error;
            return $resp;
        }
    }

    return $resp;
}

?>
