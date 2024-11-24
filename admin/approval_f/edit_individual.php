<?php
include('db.php');
include('mail.php');
if (!$conn) {
    die("Database connection failed");
}
// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $tracking_code = $_POST['tracking_code'];
    $status = $_POST['status'];
    $scheme_id = $_POST['scheme_id'];
    $schedule = $_POST['scheduleId'];
    $email = $_POST['email'];


    // Update the individual record
    $sql = "UPDATE individual_list SET tracking_code = ?, firstname = ?, lastname = ?, status = ?, scheme_id = ?, schedule = ?, email = ? WHERE id = ?";

    $nameParts = explode(" ", $name, 2);
    $firstname = $nameParts[0];
    $lastname = isset($nameParts[1]) ? $nameParts[1] : '';

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssiissi", $tracking_code, $firstname, $lastname, $status, $scheme_id, $schedule, $email, $id);
        if ($stmt->execute()) {
            echo "Individual updated successfully!";
            // Check if the status is updated to 1, and send an email
            if ($status == 1) {
                // Fetch the individual's email (if needed for email content)
                $query = "SELECT email FROM individual_list WHERE id = ?";
                $stmtEmail = $conn->prepare($query);
                $stmtEmail->bind_param("i", $id);
                $stmtEmail->execute();
                $stmtEmail->bind_result($email);
                $stmtEmail->fetch();
                $stmtEmail->close();

                // Prepare the email content
//                $subject = "Status Update Notification";
//                $message = "Hello $firstname $lastname,\n\nYour status has been updated to 'Approved'.";
                //                require "admin/mail.php"; // Include the mail function
                $requested_schedule = new DateTime($schedule);  // Use the provided disbursement date
                $formatted_schedule = $requested_schedule->format('l, F j, Y'); // Format the date

                // Define subject and message
                $subject = 'Confirmation Schedule';
                $message = "Your disbursement schedule is on " . $formatted_schedule . ". Please make sure to attend to avoid inconvenience.";

                // Send the email using mail.php function (you should define this function in mail.php)
                if (send_mail($email, $subject, $message)) {
                    echo " Email sent successfully!";
                } else {
                    echo "Failed to send email.";
                }
            }

        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Could not prepare statement.";
    }
}
?>
