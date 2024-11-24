<?php
require('../config.php');
session_start();

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
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #calendar {
            max-width: 900px;
            margin: 40px auto;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="col-8">
    <a href="<?php echo base_url ?>user/dashboard.php">Back to Site</a>
</div>
<h3 style="color:black;text-align:center;">Disbursement Schedules</h3>
<div id="calendar"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        // Fetch events from the server
        var events = [];

        <?php while ($row = $query->fetch_object()) { ?>
        <?php if (isset($row->schedule)) { ?>
        events.push({
            id: '<?php echo $row->id; ?>_1',
            title: '<?php echo "First Disbursement - " . $row->name; ?>',
            start: '<?php echo $row->schedule; ?>',
            end: '<?php echo $row->schedule; ?>'
        });
        <?php } ?>
        <?php if (isset($row->schedule_2)) { ?>
        events.push({
            id: '<?php echo $row->id; ?>_2',
            title: '<?php echo "Second Disbursement - " . $row->name; ?>',
            start: '<?php echo $row->schedule_2; ?>',
            end: '<?php echo $row->schedule_2; ?>'
        });
        <?php } ?>
        <?php if (isset($row->schedule_3)) { ?>
        events.push({
            id: '<?php echo $row->id; ?>_3',
            title: '<?php echo "Third Disbursement - " . $row->name; ?>',
            start: '<?php echo $row->schedule_3; ?>',
            end: '<?php echo $row->schedule_3; ?>'
        });
        <?php } ?>
        <?php } ?>

        // Initialize FullCalendar
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // Set the default view
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            editable: true,
            selectable: true,
            events: events, // Use the events array populated from PHP
            select: function(info) {
                // Add your event handling logic here
            }
        });

        calendar.render(); // Render the calendar
    });
</script>
</body>
</html>
