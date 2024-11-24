<?php
// Include the database connection
require_once('../config.php');

// Get the requested schedule date from the POST data
if (isset($_POST['schedule_date'])) {
    $scheduleDate = $_POST['schedule_date'];
    $requestedDate = new DateTime($scheduleDate);

    // Determine the start of the week (Sunday) and the end (Saturday) for the requested date
    $startOfWeek = $requestedDate->modify('Sunday last week')->format('Y-m-d');
    $endOfWeek = $requestedDate->modify('Saturday next week')->format('Y-m-d');

    // Check if there is a schedule within this week (Sunday to Saturday)
    $stmt = $conn->prepare("SELECT * FROM disbursement_schedule WHERE schedule_date BETWEEN ? AND ?");
    $stmt->bind_param("ss", $startOfWeek, $endOfWeek);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there's a budget available (remaining_amount >= 100000 and status = 1)
    $stmtBudget = $conn->prepare("SELECT * FROM budget WHERE remaining_amount >= 100000 AND status = 1");
    $stmtBudget->execute();
    $budgetResult = $stmtBudget->get_result();

    if ($result->num_rows > 0) {
        // If a schedule exists within this week, check for available budget
        if ($budgetResult->num_rows > 0) {
            // Both schedule and budget are available, display Confirming of Schedule
            while ($row = $result->fetch_assoc()) {
                $scheduleDate = new DateTime($row['schedule_date']);
                echo '<span style="color: green;">Confirming of Schedule: ' . $scheduleDate->format('l, F j, Y') . '</span>'; // Green text
            }
        } else {
            // Schedule exists but no budget, show Pending of Schedule
            while ($row = $result->fetch_assoc()) {
                echo '<span style="color: orange;">Pending of Budget</span>'; // Orange text (Pending)
            }
        }
    } else {
        // If no schedule exists for this week, but budget is available
        if ($budgetResult->num_rows > 0) {
            // No schedule, but budget available, show Pending of Schedule
            echo '<span style="color: orange;">Pending of Schedule</span>'; // Orange text (Pending)
        } else {
            // No schedule and no budget, inform the user
            echo '<span style="color: red;">Sorry, there is no available budget for this schedule. Please check later.</span>'; // Red text
        }
    }

    // Close the database connections
    $stmt->close();
    $stmtBudget->close();
}
?>
