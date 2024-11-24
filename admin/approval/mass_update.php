<?php
//include('db.php');

// Check if IDs and new status are provided
if (isset($_POST['ids']) && isset($_POST['status'])) {
    $ids = implode(',', $_POST['ids']); // Convert array to comma-separated string
    $status = $_POST['status'];
    $disbursement_date = $_POST['disbursement_date'];
    $email = $_POST['email'];

    // SQL query to update the status of selected individuals
    $sql = "UPDATE individual_list SET status = ?, schedule = ? WHERE id IN ($ids)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $status, $disbursement_date); // Bind status as integer
        if ($stmt->execute()) {
            echo "Mass update successful!";
            // Now fetch emails of the updated individuals
            $emailSql = "SELECT email FROM individual_list WHERE id IN ($ids)";
            $emailResult = $conn->query($emailSql);

            if ($emailResult->num_rows > 0) {
                // Collect the email addresses
                $recipients = [];
                while ($row = $emailResult->fetch_assoc()) {
                    $recipients[] = $row['email'];
                }
                // Prepare the email details
                require "admin/mail.php"; // Include the mail function
                $requested_schedule = new DateTime($disbursement_date);  // Use the provided disbursement date
                $formatted_schedule = $requested_schedule->format('l, F j, Y'); // Format the date

                // Define subject and message
                $subject = 'Confirmation Schedule';
                $message = "Your disbursement schedule is on " . $formatted_schedule . ". Please make sure to attend to avoid inconvenience.";

                // Send the email to each recipient
                foreach ($recipients as $email) {
                    $bccRecipients = ['merujeshua@gmail.com']; // BCC email
                    send_mail($email, $subject, $message, $bccRecipients);
                }

                echo "Emails sent successfully!";
            } else {
                echo "No emails found for the selected individuals.";
            }

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
?>
