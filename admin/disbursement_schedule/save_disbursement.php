<?php
// Enable error reporting (for debugging purposes)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once('../../config.php');

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate the input data
    $schedule_date = $_POST['schedule_date'];

    if (empty($schedule_date)) {
        echo "Error: Please provide a valid schedule date.";
        exit;
    }

    // Prepare the SQL query to insert the schedule into the database
    $sql = "INSERT INTO `disbursement_schedule` (schedule_date) VALUES ('$schedule_date')";

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        echo "Disbursement schedule set successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
