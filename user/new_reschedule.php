<?php
require('../config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
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

<!-- Modal for Event Details -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Disbursement Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="eventTitle"></p>
                <p id="eventDate"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="reschedule.php" class="btn btn-primary">Reschedule</a>
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
                // Display the event details in the modal
                document.getElementById('eventTitle').textContent = info.event.title;
                document.getElementById('eventDate').textContent = "Date: " + info.event.start.toISOString().split('T')[0];

                // Open the modal
                var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                eventModal.show();
            }
        });

        calendar.render();
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
