
<?php
// ...


// Establish database connection
if(isset($_GET['id']) && $_GET['id']){
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

    // Fetch the event ID from the AJAX request
    $eventId = $_GET['id'];

    // Perform a database query to retrieve individual details based on the event ID
    $sql = "SELECT * FROM individual_list WHERE id = '$eventId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Check if there are any rows returned
        if (mysqli_num_rows($result) > 0) {
            // Loop through each row
            while ($event = mysqli_fetch_assoc($result)) {
                // Access the individual data for each row
                echo '<label style="color: black;">Requested Scholarship Scheme: ' . $event['scheme_id'] .  '</label><br>';
                $status = $event['status'];

                // Display the status label
                if ($status == 1) {
                    echo '<label style="color: black;">Status: </label><span class="badge badge-primary rounded-pill">  1st Disbursement Completed (Partially Disbursed)</span>';
                } elseif ($status == 2) {
                    echo '<label style="color: black;">Status: </label><span class="badge badge-success rounded-pill">  2nd Disbursement Completed (Partially Disbursed)</span>';
                } elseif ($status == 4) {
                    echo '<label style="color: black;">Status: </label><span class="badge badge-success rounded-pill">  3rd Disbursement Completed (Fully Disbursed)</span>';
                } elseif ($status == 3) {
                    echo '<label style="color: black;">Status: </label><span class="badge badge-error rounded-pill">  Cancelled</span>';
                } else {
                    echo '<label style="color: black;">Status: </label> <span class="badge badge-light text-dark rounded-pill"> Pending</span>';
                }

                echo '<br>';
                echo '<label style="color: black;">Name: ' . $event['firstname'] . $event['lastname'] . '</label><br>';
                echo '<label style="color: black;">Mother: ' . $event['mother_fullname'] .  '</label><br>';
                echo '<label style="color: black;">Father: ' . $event['father_fullname'] .  '</label><br>';
                echo '<label style="color: black;">Gender: ' . $event['gender'] .  '</label><br>';
                echo '<label style="color: black;">Age: ' . $event['age'] .  '</label><br>';
                echo '<label style="color: black;">Birthday: ' . $event['dob'] .  '</label><br>';
                echo '<label style="color: black;">Contact No: ' . $event['contact'] .  '</label><br>';
                echo '<label style="color: black  ;">Email: ' . $event['email'] .  '</label><br>';



                // Add more fields as needed

            }
        } else {
            // No individuals found with the provided ID
            echo 'No individual found.';
        }
    } else {
        // Error handling
        echo 'Error retrieving individual data.';
    }


}
// ...
?>
