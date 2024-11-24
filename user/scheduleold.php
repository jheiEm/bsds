<?php require('../config.php') ?>
<?php
if (isset($_SESSION['email'])) {
    // Display the welcome message with the user's email
    $email = $_SESSION['email'];
    

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Schedule</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
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
    <h3 style="color:black;text-align:center;">Disbursement Schedules</h3>
    <div id="calendar"></div>
    <?php
#$host = 'sql312.infinityfree.com';
#$user = 'epiz_34236139';
#$pass = 'kMZRcKg8wN';
#$db   = 'epiz_34236139_hcpms';
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'bsds';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

    <?php



$query = $conn->query("SELECT *,concat(lastname,', ', firstname, ' ', middlename ) as name FROM individual_list where email = '$email' ");
?>
   <script>
    $(document).ready(function() {
     var calendar = $('#calendar').fullCalendar({
      editable:true,
      header:{
       left:'prev,next today',
       center:'title',
       right:'month,agendaWeek,agendaDay'
      },
      events: [
  <?php while ($row = $query->fetch_object()) { ?>
    <?php if (isset($row->schedule)) { ?>
      
        id: '<?php echo $row->id; ?>_1',
        title: '<?php echo "First Disbursement-" . $row->name  ?>',
        start: '<?php echo $row->schedule; ?>',
        end: '<?php echo $row->schedule; ?>'
      
    <?php } ?>
    <?php if (isset($row->schedule_2)) { ?>
      
        id: '<?php echo $row->id; ?>_2',
        title: '<?php echo "Second Disbursement-" . $row->name  ?>',
        start: '<?php echo $row->schedule_2; ?>',
        end: '<?php echo $row->schedule_2; ?>'
      
    <?php } ?>
    <?php if (isset($row->schedule_3)) { ?>
      
        id: '<?php echo $row->id; ?>_3',
        title: '<?php echo "Third Disbursement-" . $row->name  ?>',
        start: '<?php echo $row->schedule_3; ?>',
        end: '<?php echo $row->schedule_3; ?>'
      
    <?php } ?>
    <?php if ($query->num_rows > 1) { ?>
      ,
    <?php } ?>
  <?php } ?>
],




      selectable:true,
      selectHelper:true,
      select: function(start, end, allDay)
      {
      
      }
    });
  });
</script>
</body>
</html>