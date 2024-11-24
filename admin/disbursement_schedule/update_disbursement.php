<?php
require_once('../../config.php');  // Include the config file for DB connection

// Get the current date and time
$current_datetime = date('Y-m-d H:i:s');

// Fetch the active disbursement schedules that are not yet completed
$query = "SELECT * FROM `disbursement_schedule` WHERE `schedule_date` <= '$current_datetime' AND `status` = 'active'";
$schedules = $conn->query($query);

if ($schedules->num_rows > 0) {
    // Loop through each schedule and update student records
    while ($schedule = $schedules->fetch_assoc()) {
        // Update students whose disbursement status is 'Pending'
        $update_query = "UPDATE `student_list` 
                         SET `status` = 'Partially Disbursed', `disbursement_schedule_id` = {$schedule['id']}
                         WHERE `status` = 'Pending'";

        if ($conn->query($update_query) === TRUE) {
            echo "Disbursement status updated successfully for schedule: " . $schedule['id'];
        } else {
            echo "Error updating disbursement status: " . $conn->error;
        }
    }
} else {
    echo "No active disbursement schedules found.";
}
?>
