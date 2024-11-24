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

    // Now check if there is a schedule within this week (Sunday to Saturday)
    $stmt = $conn->prepare("SELECT * FROM disbursement_schedule WHERE schedule_date BETWEEN ? AND ?");
    $stmt->bind_param("ss", $startOfWeek, $endOfWeek);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt = $conn->prepare("SELECT * FROM budget WHERE remaining_amount >= 100000 AND status = 1");
    $stmt->execute();
    $budgetResult = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If a schedule exists within this week, return the exact schedule date as "Confirming of Schedule"
        while ($row = $result->fetch_assoc()) {
            if ($budgetResult->num_rows > 0) {
                // Budget is available, show "Pending of Schedule"
                //echo "Pending of Schedule";
                echo '<span style="color: orange;">Pending of Schedule</span>';
                $stmt->close();
                exit();
                // Yellow text
            } else {
                // If no budget is available, inform the user
                //echo "Sorry, there is no available budget for this schedule. Please check later.";
                echo '<span style="color: orange;">Sorry, there is no available budget for this schedule. Please check later.</span>';
                $stmt->close();
                exit();// Red text
            }
            $scheduleDate = new DateTime($row['schedule_date']);
            echo '<span style="color: green;">Confirming of Schedule: ' . $scheduleDate->format('l, F j, Y') . '</span>'; // Green text
        }

//        if ($budgetResult->num_rows > 0) {
//            // Budget is available, show "Pending of Schedule"
//            //echo "Pending of Schedule";
//            echo '<span style="color: orange;">Pending of Schedule</span>'; // Yellow text
//        } else {
//            // If no budget is available, inform the user
//            //echo "Sorry, there is no available budget for this schedule. Please check later.";
//            echo '<span style="color: orange;">Sorry, there is no available budget for this schedule. Please check later.</span>'; // Red text
//        }
    } else {
        // If no schedule exists, check if the budget is available
        $stmt = $conn->prepare("SELECT * FROM budget WHERE remaining_amount >= 100000 AND status = 1");
        $stmt->execute();
        $budgetResult = $stmt->get_result();

        if ($budgetResult->num_rows > 0) {
            // Budget is available, show "Pending of Schedule"
            //echo "Pending of Schedule";
            echo '<span style="color: orange;">Pending of Schedule</span>'; // Yellow text
        } else {
            // If no budget is available, inform the user
            //echo "Sorry, there is no available budget for this schedule. Please check later.";
            echo '<span style="color: orange;">Sorry, there is no available budget for this schedule. Please check later.</span>'; // Red text
        }
    }

    // Close the database connection
    $stmt->close();
}
?>
