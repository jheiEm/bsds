<?php
require('../config.php');
$successMessage = null;
$errorMessage = null;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];  // Ensure the session email is captured correctly
} else {
    die("Access denied. Please log in.");
}

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'bsds';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $conn->query("SELECT *, CONCAT(lastname, ', ', firstname, ' ', middlename) AS name FROM individual_list WHERE email = '$email'");

// Debugging: Check if email is being set properly in the session
error_log("Session email: " . $email);  // Logs the email to the server logs

// Handle form submission for rescheduling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from_date = $_POST['from_date'];  // Auto-populated from the calendar event
    $to_date = $_POST['to_date'];      // User-selected date
    $remarks = $_POST['remarks'];
    $email = $_SESSION['email'];       // Ensure the session email is passed correctly

    // Server-side validation: check if to_date is later than from_date
    if (strtotime($to_date) < strtotime($from_date)) {
        $errorMessage = "The 'To Date' cannot be earlier than the 'From Date'.";
    } else {
        // Prepare the insert query
        $stmt = $conn->prepare("INSERT INTO reschedule_list (id, email, from_date, to_date, remarks, status) VALUES (?, ?, ?, ?, ?, 0)");

        // Check if the statement preparation is successful
        if ($stmt === false) {
            die('Error preparing the statement: ' . htmlspecialchars($conn->error));
        }

        // Bind parameters (email, from_date, to_date, remarks)
        $stmt->bind_param("issss", $id,$_SESSION['email'], $from_date, $to_date, $remarks);
        //var_dump($email, $from_date, $to_date, $remarks);
        // Execute the query
        //if ($stmt->execute()) {
        //    $successMessage = "Reschedule request submitted successfully.";
        //} else {
        //    $errorMessage = "Error submitting reschedule request: " . $stmt->error;
        //}
        // Inside your POST handling, after the successful execution:
        if ($stmt->execute()) {
            $successMessage = "Reschedule request submitted successfully.";
            // Optionally, set a success flag for JavaScript
            echo '<script>var submissionSuccessful = true;</script>';
        } else {
            $errorMessage = "Error submitting reschedule request: " . $stmt->error;
        }

        $stmt->close();
    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px;
        }

        #calendar {
            max-width: 900px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .calendar-title {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 30px;
            font-size: 1.8rem;
            color: #333;
        }

        .btn-back {
            background-color: #1d7ecb;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-back:hover {
            background-color: #145a99;
        }
    </style>
</head>
<body>

<!-- Back to Site Button -->
<div class="container">
    <div class="row mb-3">
        <div class="col text-start">
            <a href="<?php echo base_url ?>user/dashboard.php" class="btn-back">Back to Site</a>
        </div>
    </div>

    <!-- Calendar Title -->
    <h3 class="calendar-title">Reschedule Disbursement</h3>

    <!-- FullCalendar Container -->
    <div id="calendar"></div>
</div>

<!-- Modal for Event Details and Reschedule -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Disbursement Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display success or error messages -->
                <?php if (isset($successMessage)): ?>
                    <div class="alert alert-success"><?php echo $successMessage; ?></div>
                <?php elseif (isset($errorMessage)): ?>
                    <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <!-- Display session email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="eventTitle" class="form-label">Disbursement</label>
                        <input type="text" class="form-control" id="eventTitle" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="from_date" class="form-label">From Date</label>
                        <!-- This will be auto-populated from the event's scheduled date -->
                        <input type="date" class="form-control" id="from_date" name="from_date" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="to_date" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="to_date" name="to_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Reschedule Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var events = [];

        <?php while ($row = $query->fetch_object()) { ?>
        <?php if (isset($row->schedule)) { ?>
        events.push({
            id: '<?php echo $row->id; ?>_1',
            title: '<?php echo "Schedule of Disbursement - " . $row->name; ?>',
            start: '<?php echo $row->schedule; ?>',
            end: '<?php echo $row->schedule; ?>'
        });
        <?php } ?>
        <?php } ?>

        // Initialize FullCalendar
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            editable: true,
            selectable: true,
            events: events,
            eventClick: function(info) {
                // Set the event details in the modal
                document.getElementById('eventTitle').value = info.event.title;
                document.getElementById('from_date').value = info.event.start.toISOString().split('T')[0];

                // Disable invalid to_date selection by setting min date
                document.getElementById('to_date').setAttribute('min', info.event.start.toISOString().split('T')[0]);

                // Open the modal
                var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                eventModal.show();
            }
        });

        calendar.render();

        // Check if submission was successful
        if (typeof submissionSuccessful !== 'undefined' && submissionSuccessful) {
            // Close the modal after a successful submission
            var eventModal = bootstrap.Modal.getInstance(document.getElementById('eventModal'));
            if (eventModal) {
                eventModal.hide();  // Close the modal
            }
            // Optionally, show a success alert
            alert("<?php echo addslashes($successMessage); ?>");  // Show the success message
        }
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
