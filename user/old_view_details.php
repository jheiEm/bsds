<?php require('../config.php') ?>
<?php
if (isset($_SESSION['email'])) {
    // Display the welcome message with the user's email
    $email = $_SESSION['email'];


}
?>

<?php
// Your code to connect to the database


// Check the connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Fetch data from the database
$query = "SELECT * FROM individual_list where email='$email'";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // If data exists, format and pass it to the DataTable
    if (mysqli_num_rows($result) > 0) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = array(
                $row['tracking_code'],
                $row['firstname'],
                $row['lastname'],
                $row['gender'],
                $row['dob'],
                $row['age'],
                $row['address'],
                $row['status'],
                $row['district_name'],
                $row['schedule'],
                $row['schedule_2'],
                $row['schedule_3'],
                $row['contact'],
                $row['mother_fullname'],
                $row['father_fullname']
            );
        }
    } else {
        $data = array(); // Empty array if no data found
    }
} else {
    echo 'Error fetching data.';
    exit();
}

// Close the database connection

?>

<!DOCTYPE html>
<html>
<head>
    <!-- Include DataTables CSS -->



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.2/css/uikit.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.uikit.min.css">




</head>
<body>
<h1 style="text-align:center">Scholar Details</h1>
<table id="myTable" style="background-color:#343A40;color:white;">
    <thead>
    <tr>
        <th>Tracking Code</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Date of Birth</th>
        <th>Age</th>
        <th>Address</th>
        <th>Status</th>
        <th>District Name</th>
        <th>Disbursement Schedule</th>
        <th>Contact #</th>
        <th>Mother's Name</th>
        <th>Father's Name</th>

    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data as $row) {
        echo '<tr>';
        echo '<td>' . $row[0] . '</td>';
        echo '<td>' . $row[1] . '</td>';
        echo '<td>' . $row[2] . '</td>';
        echo '<td>' . $row[3] . '</td>';
        echo '<td>' . $row[4] . '</td>';
        echo '<td>' . $row[5] . '</td>';
        echo '<td>' . $row[6] . '</td>';



        echo '<td>';


        if ($row['7'] == 1) {
            echo '<span class="badge badge-primary rounded-pill">1st Disbursement Completed (Partially Disbursed)</span>';
        }

        else if ($row['7'] == 2 ) {

            echo ' <span class="badge badge-success rounded-pill">2nd Disbursement Completed (Partially Disbursed)</span>';
        }

        else if ($row['7'] == 4 ) {

            echo ' <span class="badge badge-success rounded-pill">3rd Disbursement Completed (Fully Disbursed)</span>';
        }
        else {

            echo '<span class="badge badge-light text-dark rounded-pill">Pending</span>';
        }





        // echo 'First Vaccine: ' . date('F-d-Y h:i a', strtotime($row[9]))  . '<br>';
        // echo 'Second Vaccine: ' .date('F-d-Y h:i a', strtotime($row[10]))  . '<br>';
        // echo 'Third Vaccine: ' . date('F-d-Y h:i a', strtotime($row[11]))  . '<br>';
        // echo '</td>';
        // echo '</tr>';






        '</td>';
        echo '<td>' . $row[8] . '</td>';
        echo '<td>';


        if ($row['9'] == "0000-00-00" || $row['9'] == "0000-00-00 00:00:00" ) {
            echo '<span style="text-align:center" >First Disbursement Schedule Pending.</span>';
        }

        else if ($row['10'] == "0000-00-00" || $row['10'] == "0000-00-00 00:00:00" ) {
            $schedule = date('F-d-Y h:i a', strtotime($row['9']));
            echo 'First Disbursement Schedule: ' . $schedule . '<br>';
            echo '<span style="text-align:center" > Second Disbursement Schedule Pending. </span>';
        }

        else if ($row['11'] == "0000-00-00" || $row['11'] == "0000-00-00 00:00:00" ) {
            $schedule = date('F-d-Y h:i a', strtotime($row['9']));
            echo 'First Disbursement Schedule: ' . $schedule . '<br>';
            $schedule_2 = date('F-d-Y h:i a', strtotime($row['10']));
            echo 'Second Disbursement Schedule: ' . $schedule_2 . '<br>';
            $schedule_3 = date('F-d-Y h:i a', strtotime($row['11']));
            echo '<span style="text-align:center"> Third Disbursement Schedule Pending </span>';
        }
        else {
            $schedule = date('F-d-Y h:i a', strtotime($row['9']));
            echo 'First Disbursement Schedule: ' . $schedule . '<br>';
            $schedule_2 = date('F-d-Y h:i a', strtotime($row['10']));
            echo 'Second Disbursement Schedule: ' . $schedule_2 . '<br>';
            $schedule_3 = date('F-d-Y h:i a', strtotime($row['11']));
            echo 'Third Disbursement Schedule: ' . $schedule_3 . '<br>';
        }

        echo '<td>' . $row[12] . '</td>';
        echo '<td>' . $row[13] . '</td>';
        echo '<td>' . $row[14] . '</td>';



        // echo 'First Vaccine: ' . date('F-d-Y h:i a', strtotime($row[9]))  . '<br>';
        // echo 'Second Vaccine: ' .date('F-d-Y h:i a', strtotime($row[10]))  . '<br>';
        // echo 'Third Vaccine: ' . date('F-d-Y h:i a', strtotime($row[11]))  . '<br>';
        // echo '</td>';
        // echo '</tr>';
    }
    ?>
    </tbody>
</table>

<!-- Include jQuery and DataTables JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<!-- Initialize DataTable -->
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
</body>
</html>






