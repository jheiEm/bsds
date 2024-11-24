<!DOCTYPE html>
<html>
<head>
    <title>FullCalendar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <!-- Include Bootstrap CSS and JS -->
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
<div class="container">
    <form action="#save_disbursement.php" method="POST">
        <div class="form-group">
            <label for="schedule_date">Disbursement Date</label>
            <input type="datetime-local" class="form-control" name="schedule_date" id="schedule_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Set Disbursement Schedule</button>
    </form>
</div>


