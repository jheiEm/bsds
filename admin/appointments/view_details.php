<?php
// Establish database connection
if (isset($_GET['id']) && $_GET['id']) {
    // Database connection parameters
    #$host = 'localhost';
    #$user = 'u754731260_root';
    #$pass = 'Test2024!';
    #$db   = 'u754731260_bsds';

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'bsds';

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the event ID from the AJAX request
    $eventId = $_GET['id'];

    // Perform a database query to retrieve individual details along with the scheme name
    $sql = "
        SELECT i.*, s.name AS scheme_name 
        FROM individual_list i 
        LEFT JOIN scheme_list s ON i.scheme_id = s.id 
        WHERE i.id = '$eventId'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Check if there are any rows returned
        if (mysqli_num_rows($result) > 0) {
            // Loop through each row
            while ($event = mysqli_fetch_assoc($result)) {
                // Access the individual data for each row
                echo '<label style="color: black;">Requested Scholarship Scheme: ' . htmlspecialchars($event['scheme_name']) . '</label><br>';
                $status = $event['status'];

                // Display the status label
                switch ($status) {
                    case 1:
                        echo '<label style="color: black;">Status: </label><span class="badge badge-primary rounded-pill">  1st Disbursement Completed (Partially Disbursed)</span>';
                        break;
                    case 3:
                        echo '<label style="color: black;">Status: </label><span class="badge badge-error rounded-pill">  Cancelled</span>';
                        break;
                    default:
                        echo '<label style="color: black;">Status: </label><span class="badge badge-light text-dark rounded-pill"> Pending</span>';
                        break;
                }

                echo '<br>';
                echo '<label style="color: black;">Name: ' . htmlspecialchars($event['firstname']) . ' ' . htmlspecialchars($event['lastname']) . '</label><br>';
                echo '<label style="color: black;">Mother: ' . htmlspecialchars($event['mother_fullname']) . '</label><br>';
                echo '<label style="color: black;">Father: ' . htmlspecialchars($event['father_fullname']) . '</label><br>';
                echo '<label style="color: black;">Gender: ' . htmlspecialchars($event['gender']) . '</label><br>';
                echo '<label style="color: black;">Age: ' . htmlspecialchars($event['age']) . '</label><br>';
                echo '<label style="color: black;">Birthday: ' . htmlspecialchars($event['dob']) . '</label><br>';
                echo '<label style="color: black;">Contact No: ' . htmlspecialchars($event['contact']) . '</label><br>';
                echo '<label style="color: black;">Email: ' . htmlspecialchars($event['email']) . '</label><br>';

                // Add more fields as needed
            }
        } else {
            // No individuals found with the provided ID
            echo 'No individual found.';
        }
    } else {
        // Error handling
        echo 'Error retrieving individual data.';
    }
}
?>
