<?php
// Log incoming data for debugging
error_log(print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture incoming data
    $disbursement_status = $_POST['disbursement_status']; // Get the selected status
    $individual_id = $_POST['individual_id']; // Assuming you also pass the individual ID
    $reviewed_by = $_POST['reviewed_by']; // The person who disbursed the scholarship
    $remarks = $_POST['remarks']; // Remarks about the disbursement

    // Log the captured data to the error log
    error_log("Disbursement Status: $disbursement_status");
    error_log("Individual ID: $individual_id");
    error_log("Reviewed By: $reviewed_by");
    error_log("Remarks: $remarks");

    // Query to update the disbursement status, reviewed_by, and remarks
    $update_disbursement_query = "UPDATE scholar_history_list SET 
                                    status = '$disbursement_status', 
                                    reviewed_by = '$reviewed_by',
                                    remarks = '$remarks'
                                  WHERE individual_id = '$individual_id'";

    if ($conn->query($update_disbursement_query) === TRUE) {
        // Log success message
        error_log("Disbursement updated successfully.");

        // If the status is 'Approved for Disbursement)'
        if ($disbursement_status == 'Approved for Disbursement') {
            // Deduct from the budget
            $budget_deductions = [
                'BPEAP' => [3000, 4000, 5000],  // Deducting 3K, 4K, and 5K for BPEAP
                'SCHEME 1' => 25000,             // 25K for SCHEME 1
                'SCHEME 2' => 10000              // 10K for SCHEME 2
            ];

            foreach ($budget_deductions as $budget_name => $amounts) {
                if (is_array($amounts)) {
                    foreach ($amounts as $amount) {
                        $update_budget_query = "UPDATE budget SET 
                                                amount = amount - $amount
                                                WHERE budget_name = '$budget_name'";

                        if ($conn->query($update_budget_query) !== TRUE) {
                            error_log("Error updating budget for $budget_name: " . $conn->error);
                        } else {
                            error_log("Budget for $budget_name updated by $amount");
                        }
                    }
                } else {
                    $update_budget_query = "UPDATE budget SET 
                                            amount = amount - $amounts
                                            WHERE budget_name = '$budget_name'";

                    if ($conn->query($update_budget_query) !== TRUE) {
                        error_log("Error updating budget for $budget_name: " . $conn->error);
                    } else {
                        error_log("Budget for $budget_name updated by $amounts");
                    }
                }
            }

            echo json_encode(["status" => "success", "msg" => "Disbursement schedule set and budgets updated successfully!"]);
        } else {
            echo json_encode(["status" => "success", "msg" => "Disbursement status updated, but no deduction is made."]);
        }
    } else {
        echo json_encode(["status" => "failed", "msg" => "Error: " . $conn->error]);
    }
}
?>
