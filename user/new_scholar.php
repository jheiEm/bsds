<?php require_once('../config.php') ?>

<?php
if (isset($_SESSION['email'])) {
    // Display the welcome message with the user's email
    $email = $_SESSION['email'];
}

?>

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
    $emailadd = $_POST["email"];
    $district_name = $_POST["district_name"];
    $enrollment_date = $_POST["enrollment_date"];
    $school_name = $_POST["school_name"];
    $school_level = $_POST["school_level"];
    $requested_schedule = $_POST["requested_schedule"]; // Capture the requested schedule date
    $scheme_name = $_POST["scheme_name"]; // Capture the requested schedule date
    $successMessage = "";

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
    $sql = "INSERT INTO individual_list 
    (tracking_code, mother_fullname, father_fullname, firstname, middlename, lastname, gender, dob, age, contact, address, email, district_name, enrollment_date, school_name, school_level, scheme_id, schedule_date, date_created, date_updated) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

// Create a prepared statement
    $stmt = $conn->prepare($sql);

// Check for preparation failure
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

// Bind parameters and their data types
    $stmt->bind_param("ssssssssssssssssis", $code, $motherFullname, $fatherFullname, $firstname, $middlename, $lastname, $gender, $dob, $age, $contact, $address, $emailadd, $district_name, $enrollment_date, $school_name, $school_level, $scheme_name, $requested_schedule);

// Execute the statement
    if ($stmt->execute()) {
        $successMessage = "Information was Successfully submitted";
        require "mail.php";
        $requested_schedule = new DateTime($requested_schedule);  // Example: Current date and time

// Format the date using the 'l, F j, Y' format (e.g., "Monday, October 1, 2024")
        $formatted_schedule = $requested_schedule->format('l, F j, Y');

// Call the send_mail function with the formatted date

        $recipients = [''];
        $bccRecipients = ['merujeshua@gmail.com']; // BCC email

        // Define the subject and message
        $subject = 'Confirmation Schedule';
        $message = "Your requested schedule " . $formatted_schedule . ", is for approval. If you wish to reschedule, please have you or your coordinator file using the portal - reschedule.";
        send_mail($email, $subject, $message, $bccRecipients);
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Student Details</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<style>
    body {
        background-color: #f4f6f9;
        background-image: url('gradient_bg.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        padding-top: 50px;
    }

    .card {
        border-radius: 20px; /* More rounded corners for the card */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 20px; /* Match card corner radius */
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 12px; /* Rounded inputs */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 12px 20px;
        width: 100%;
        border-radius: 12px; /* Rounded button corners */
        transition: all 0.3s ease-in-out; /* Smooth transition */
        font-size: 16px;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Darker blue on hover */
        border-color: #0056b3;
        transform: translateY(-5px); /* Button lifts up slightly on hover */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Add subtle shadow on hover */
    }

    label {
        font-weight: 600;
    }

    .input-group-text {
        background-color: transparent;
        border: none;
    }

    /* Updated gender section */
    .radio-group {
        display: flex;
        justify-content: flex-start; /* Align radio buttons without excessive space */
        gap: 15px; /* Small gap between the buttons */
        margin-top: 10px;
    }

    .radio-group label {
        margin-right: 0;
        font-size: 16px;
        cursor: pointer;
    }

    .radio-group input[type="radio"] {
        margin-right: 5px;
    }

    /* Align radio buttons vertically on small screens */
    @media (max-width: 576px) {
        .radio-group {
            flex-direction: column; /* Stack vertically on small screens */
            gap: 10px; /* Reduce gap when stacked */
        }
        .radio-group label {
            margin-bottom: 5px; /* Add space below each label when stacked */
        }
    }

</style>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center mb-4">Apply for New Scholarship</h3>

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <?php if (!empty($successMessage)): ?>
                            <div class="alert alert-success text-center">
                                <?php echo $successMessage; ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <input type="text" name="mother_fullname" id="mother_fullname" class="form-control" required placeholder="Mother's Fullname">
                        </div>

                        <div class="form-group">
                            <input type="text" name="father_fullname" id="father_fullname" class="form-control" required placeholder="Father's Fullname">
                        </div>

                        <div class="form-group">
                            <input type="text" name="firstname" id="firstname" class="form-control" required placeholder="First Name">
                        </div>

                        <div class="form-group">
                            <input type="text" name="middlename" id="middlename" class="form-control" placeholder="Middle Name">
                        </div>

                        <div class="form-group">
                            <input type="text" name="lastname" id="lastname" class="form-control" required placeholder="Last Name">
                        </div>

                        <div class="form-group">
                            <label>Gender</label>
                            <div class="radio-group">
                                <div class="form-check">
                                    <input type="radio" name="gender" id="gender_male" value="Male" class="form-check-input" required>
                                    <label class="form-check-label" for="gender_male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="gender" id="gender_female" value="Female" class="form-check-input" required>
                                    <label class="form-check-label" for="gender_female">Female</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="dob" id="dob" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="age" id="age" class="form-control" placeholder="Age" readonly required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="contact" id="contact" class="form-control" required placeholder="Contact">
                        </div>

                        <div class="form-group">
                            <input type="text" name="address" id="address" class="form-control" required placeholder="Address">
                        </div>
                        <div class="form-group">
                            <label for="scheme_name">Applying for Scheme</label>
                            <a href="show_scheme.php" target="_blank"> <span id="districtTooltip" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Check for the requirements for every scholarship grant."> ? </span>
                            </a>
                            <select name="scheme_name" class="form-control" id="scheme_name" required>
                                <option value="">Select Scheme</option>
                                <?php
                                $schemeResult = $conn->query("SELECT * FROM scheme_list WHERE status = 1");
                                while ($scheme = $schemeResult->fetch_assoc()) {
                                    echo "<option value='{$scheme['id']}'>{$scheme['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" name="school_name" id="school_name" class="form-control" required placeholder="School Name">
                        </div>

                        <div class="form-group">
                            <label for="district_name">School Level</label>
                            <select name="school_level" class="form-control" id="school_level" required>
                                <option value="Junior High School">Select School Level</option>
                                <option value="Junior High School">Junior High School</option>
                                <option value="Senior High School">Senior High School</option>
                                <option value="Tertiary">Tertiary</option>
                                <option value="Vocational">Vocational</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="enrollment_date">Start of School Date</label>
                            <input type="date" name="enrollment_date" id="enrollment_date" class="form-control" required>
                        </div>
                        <!-- Check Availability of requested date -->
                        <div class="form-group">
                            <label for="requested_schedule">Requested Schedule Date</label>
                            <input type="date" id="requested_schedule" name="requested_schedule" class="form-control" required>
                        </div>

                        <button type="button" class="btn btn-primary" id="checkAvailabilityBtn" style=" background-color: #34b17a; border-color: #a3f813; color:white">Check Availability</button>

                        <!-- Placeholder for the result -->
                        <div id="availabilityResult" style="margin-top: 20px; font-weight: bold;"></div>
                        <br/>
                        <div class="form-group">
                            <label for="district_name">District</label>
                            <a href="show_district.php" target="_blank"> <span id="districtTooltip" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Select a district to view cities/municipalities."> ? </span>
                            </a>
                            <select name="district_name" class="form-control" id="district_name" required>
                                <option value="">Select District</option>
                                <?php
                                $districtResult = $conn->query("SELECT * FROM scholar_location_list WHERE status = 1");
                                while ($district = $districtResult->fetch_assoc()) {
                                    echo "<option value='{$district['location']}'>{$district['location']}</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <input type="hidden" name="date_created" value="<?php echo date('Y-m-d'); ?>">
                        <input type="hidden" name="date_updated" value="<?php echo date('Y-m-d'); ?>">
                        <input type="hidden" name="email" value="<?php echo $email; ?>">

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        <div class="form-group">
                            <a href="javascript:void(0);" onclick="window.history.back();">
                            <button class="btn btn-primary" style=" background-color: #6C757C; border-color: #6c757d;">Cancel</button>
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery, Bootstrap 4 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // JavaScript to calculate age dynamically
    document.getElementById('dob').addEventListener('change', function() {
        var dob = new Date(this.value);
        var today = new Date();
        var age = today.getFullYear() - dob.getFullYear();

        var monthDifference = today.getMonth() - dob.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        document.getElementById('age').value = age;
    });

    // Set the 'min' date to the current date, so users can't pick a previous year
    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date();
        var year = today.getFullYear();
        var minDate = year + "-01-01"; // Set the min date to January 1st of the current year
        document.getElementById("enrollment_date").setAttribute("min", minDate);
    });

    // Set the 'min' date to the current date, so users can't pick a previous 5months later upto next year
    document.addEventListener("DOMContentLoaded", function() {
        // Get today's date
        var today = new Date();

        // Calculate the date 5 months ago
        var minDate = new Date(today);
        minDate.setMonth(today.getMonth() - 5);  // Subtract 5 months
        minDate = minDate.toISOString().split('T')[0];  // Format as YYYY-MM-DD

        // Set the 'min' date to 5 months ago
        document.getElementById("enrollment_date").setAttribute("min", minDate);

        // Calculate the end of next year (December 31st of next year)
        var nextYear = new Date();
        nextYear.setFullYear(today.getFullYear() + 1);  // Set year to next year
        nextYear.setMonth(11);  // Set month to December (11 = December)
        nextYear.setDate(31);  // Set date to 31st
        var maxDate = nextYear.toISOString().split('T')[0];  // Format as YYYY-MM-DD

        // Set the 'max' date to December 31st of next year
        document.getElementById("enrollment_date").setAttribute("max", maxDate);
    });

    // When the user clicks the "Check Availability" button
    // Check availability via AJAX
    document.getElementById('checkAvailabilityBtn').addEventListener('click', function() {
        var requestedSchedule = document.getElementById('requested_schedule').value;

        // Check if the schedule date is selected
        if (!requestedSchedule) {
            alert("Please select a schedule date.");
            return;
        }

        // Make an AJAX request to check the availability
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "check_availability.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Display the result from the server
                document.getElementById('availabilityResult').innerHTML = xhr.responseText;
            }
        };

        // Send the schedule date as data
        xhr.send("schedule_date=" + encodeURIComponent(requestedSchedule));
    });

</script>
</body>
</html>
