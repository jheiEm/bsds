<!DOCTYPE html>
<html>
<head>
    <title>FullCalendar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.5.0/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.5.0/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .modal{
            color: white;
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
<h3 style="text-align:center;">Disbursement Schedules</h3>
<div id="calendar"></div>

<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 id="eventTitle"></h6>
                <p id="eventDescription"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'bsds';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $conn->query("SELECT *, concat(lastname,', ', firstname, ' ', middlename) as name FROM individual_list where schedule != 0");
?>

<script>
    $(document).ready(function() {
        var calendar = $('#calendar').fullCalendar({
            editable: false,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: <?php
            $event_data = [];
            while ($row = $query->fetch_object()) {
                if (isset($row->schedule)) {
                    $event_data[] = [
                        'id' => $row->id,
                        'title' => $row->name . " - Schedule of Disbursement",
                        'start' => $row->schedule,
                        'end' => $row->schedule
                    ];
                }
            }
            echo json_encode($event_data);
            ?>,

            eventClick: function(calEvent, jsEvent, view) {
                // Set the modal content
                $('#eventTitle').text(calEvent.title);
                $('#eventDescription').text("This is the detailed description of the disbursement schedule.");

                // Show the modal
                $('#eventModal').modal('show');
            }
        });

        // Debugging: log the events data
        console.log("Events Data:", <?php echo json_encode($event_data); ?>);
    });
</script>
