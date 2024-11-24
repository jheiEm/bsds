<?php require('../config.php') ?>


<?php


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $motherFullname = $_POST["mother_fullname"];
    $fatherFullname = $_POST["father_fullname"];
    $firstname = $_POST["firstname"];
    $middlename = $_POST["middlename"];
    $lastname = $_POST["lastname"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $age = $_POST["age"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];
	$email = $_POST["email"];

    // Generate a unique tracking code
    $code = '';
    while (true) {
        $code = mt_rand(1, 999999999999999);
        $code = sprintf("%'.015d", $code);
        $check = $conn->query("SELECT * FROM `individual_list` WHERE tracking_code = '{$code}'")->num_rows;
        if ($check <= 0) {
            break;
        }
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO individual_list (tracking_code,mother_fullname, father_fullname, firstname, middlename, lastname, gender, dob, age, contact, address,email) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and their data types
    $stmt->bind_param("sssssssssss", $code, $motherFullname, $fatherFullname, $firstname, $middlename, $lastname, $gender, $dob, $age, $contact, $address,$email );

    // Execute the statement
    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement

}

// Close the connection

?>
