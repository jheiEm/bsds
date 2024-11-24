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
    $schol_name = $_POST["schol_name"];
    $school_level = $_POST["school_level"];
    $school_year = $_POST["school_year"];
    $successMessage="";
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
    $sql = "INSERT INTO individual_list (tracking_code, mother_fullname, father_fullname, firstname, middlename, lastname, gender, dob, age, contact, address,email,district_name, enrollment_date, school_name, school_level ) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?,? )";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and their data types
    $stmt->bind_param("sssssssssssss",$code, $motherFullname, $fatherFullname, $firstname, $middlename, $lastname, $gender, $dob, $age, $contact, $address, $emailadd,$district_name, $enrollment_date, $school_name, $school_level,);

    // Execute the statement
    if ($stmt->execute()) {
        $successMessage= "Information was Successfully submitted";

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
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<style>
    body{
        background-color: whitesmoke;
        background-image: url('gradient_bg.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

    }

    .card .card-body {
        background-color: #1D7ECB;
        padding: 20px;
        border-radius: 8px;
        color: white;
    }
    .card {
        width: 500px;
        margin: 0 auto;
        padding: 20px;
        background-color: #A2E2F8;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card {
        text-align: center;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .cardinput[type="text"],
    .card input[type="email"],
    .card input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .card button {
        width: 100%;
        padding: 10px;
        background-color:#d81b60;;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .card button:hover {
        background-color: white;
        color: black;
    }

    .card .error-message {
        color: red;
        margin-bottom: 10px;
    }



    /* General styling for the input group */
    .input-group {
    //margin-bottom: 20px;  /* Space between fields */
        /*font-family: Arial, sans-serif;*/
        align-content: flex-start;
    }

    /* Styling for the "Gender" label */
    .input-group label {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;  /* Space between "Gender" label and radio button group */
        display: block;
    }

    /* Style for each radio button group */
    .radio-group {
        display: inline-flex;    /* Use inline-flex to align items horizontally */
        align-items: center;     /* Vertically align the radio button and label */
        margin-right: 20px;      /* Space between radio button options */
        font-size: 14px;
        margin-bottom: 10px;     /* Add space after the radio button group */
    }

    /* Styling for the radio input element */
    .radio-group input[type="radio"] {
        margin-right: 8px;        /* Space between the radio button and label */
        vertical-align: middle;   /* Ensure the radio button is vertically aligned */
        height: 20px;             /* Adjust size of radio button */
        width: 20px;              /* Adjust size of radio button */
    }

    /* Styling for the label element */
    .radio-group label {
        font-size: 14px;
        cursor: pointer;
        line-height: 20px;       /* Set a line-height equal to radio button height */
        margin: 0;               /* Remove any extra margins */
        vertical-align: middle;  /* Ensure label is vertically aligned with radio button */
    }

    /* Optional: Styling when radio is selected */
    .radio-group input[type="radio"]:checked + label {
        font-weight: 700;  /* Bold the label of the selected option */
        color: #007bff;    /* Change color for the selected option */
    }

    /* Add hover effect for better UX */
    .radio-group label:hover {
        color: #007bff;
        cursor: pointer;
    }
    #lblspc{
        margin-right: 1rem;
    }
    /* Styling for the select dropdown */
    .form-select {
        width: 100%;          /* Ensures the dropdown takes up full width */
        padding: 10px 15px;   /* Adds padding inside the select box */
        font-size: 14px;      /* Sets a consistent font size */
        border: 1px solid #ccc;  /* Light border around the dropdown */
        border-radius: 8px;   /* Rounded corners */
        background-color: #f9f9f9; /* Soft background color */
        transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Smooth transition on hover/focus */
    }

    /* Hover and focus effects */
    .form-select:hover, .form-select:focus {
        border-color: #007bff;  /* Change border color on hover/focus */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add a soft shadow */
    }

    /* Optional: Styling for the select options */
    .form-select option {
        padding: 10px;
        font-size: 14px;
    }

</style>
<body >
<div class="d-flex align-items-center justify-content-center h-150">
    <div class="d-flex h-100 justify-content-center align-items-center col-lg-7 ">


        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Apply for New Scholarship</p>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                    <?php if (!empty($successMessage)): ?>
                        <p style="color:green;text-align:center"><?php echo $successMessage; ?></p>
                    <?php endif; ?>

                    <div class="input-group mb-3">

                        <input type="text" name="mother_fullname" id="mother_fullname" class="form-control" required placeholder="Mother's Fullname">
                        <div class="input-group-append">
                            <div class="input-group-text">

                            </div>
                        </div>
                    </div>


                    <div class="input-group mb-3">

                        <input type="text" name="father_fullname" id="father_fullname" class="form-control" required placeholder="Father's Fullname">
                        <div class="input-group-append">
                            <div class="input-group-text">

                            </div>
                        </div>
                    </div>


                    <div class="input-group mb-3">

                        <input type="text" name="firstname" id="firstname" class="form-control" required placeholder="First Name">
                        <div class="input-group-append">
                            <div class="input-group-text">

                            </div>
                        </div>
                    </div>



                    <div class="input-group mb-3">
                        <input type="text" name="middlename" id="middlename"  class="form-control" required placeholder="Middle Name">
                        <div class="input-group-append">
                            <div class="input-group-text">

                            </div>
                        </div>
                    </div>



                    <div class="input-group mb-3">
                        <input type="text" name="lastname" id="lastname" class="form-control" required placeholder="Last Name">
                        <div class="input-group-append">
                            <div class="input-group-text">

                            </div>
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="input-group">
                        <label for="gender" id="lblspc">Gender</label>
                        <div class="radio-group">
                            <input type="radio" name="gender" id="gender_male" value="Male" required>
                            <label for="gender_male">Male</label>
                        </div>
                        <div class="radio-group">
                            <input type="radio" name="gender" id="gender_female" value="Female" required>
                            <label for="gender_female">Female</label>
                        </div>
                    </div>




                    <!-- Date of Birth -->

                    <label for="dob" class="control-label">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="form-control" placeholder="Date of Birth" value="<?php echo isset($dob) ? date('Y-m-d', strtotime($dob)) : ''; ?>" required>


                    <!-- Age -->
                    <script>
                        // JavaScript to calculate age dynamically
                        document.getElementById('dob').addEventListener('change', function() {
                            var dob = new Date(this.value); // Get the DOB date
                            var today = new Date(); // Get today's date
                            var age = today.getFullYear() - dob.getFullYear(); // Basic age calculation

                            // Check if the birthday has already occurred this year
                            var monthDifference = today.getMonth() - dob.getMonth();
                            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
                                age--; // If birthday hasn't occurred yet, subtract 1 year
                            }

                            // Set the calculated age into the input field
                            document.getElementById('age').value = age;
                        });
                    </script>
                    <?php

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        // Assume $_POST['dob'] is the user's selected Date of Birth from the form
                        if (!empty($_POST['dob'])) {
                            $dob = $_POST['dob'];

                            // Calculate age from Date of Birth
                            $dobDate = new DateTime($dob);
                            $today = new DateTime();
                            $age = $today->diff($dobDate)->y; // Calculate the difference in years

                            // Now you can use $age for further processing or saving into the database
                        }
                    }
                    ?>
                    <br/>
                    <div class="input-group mb-3">
                        <input type="text" name="age" id="age" class="form-control" placeholder="Age" value="<?php echo isset($age) ? $age : ''; ?>" readonly required>
                        <div class="input-group-append">
                            <div class="input-group-text">

                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" name="contact" id="contact"  class="form-control" required placeholder="Contact">
                        <div class="input-group-append">
                            <div class="input-group-text">

                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" name="address" id="address"  class="form-control" required placeholder="Address">
                        <div class="input-group-append">
                            <div class="input-group-text">

                            </div>
                        </div>
                    </div>

                    <!-- School Info -->
                    <div class="input-group mb-3">
                        <input type="text" name="school_name" id="school_name"  class="form-control" required placeholder="School Name">
                        <div class="input-group-append">
                            <div class="input-group-text">

                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" name="schoo_level" id="schoo_level"  class="form-control" required placeholder="School Level">
                        <div class="input-group-append">
                            <div class="input-group-text">

                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select class="input-group mb-3 form-control" id="school_level" name="school_level" placeholder="School Level">
                            <option value="Junior High School">Select School Level</option>
                            <option value="Junior High School">Junior High School</option>
                            <option value="Senior High School">Senior High School</option>
                            <option value="Tertiary">Tertiary</option>
                            <option value="Vocational">Vocational</option>
                            <div class="input-group-append">
                                <div class="input-group-text">

                                </div>
                            </div>
                        </select>
                    </div>
                    <label for="enrollment_date" class="control-label">Start of School Date</label>
                    <div class="input-group mb-3">
                        <input type="date" name="enrollment_date" id="enrollment_date"  class="form-control" required placeholder="Start of School Date">
                        <div class="input-group-append">
                            <div class="input-group-text">

                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select class="input-group mb-3 form-control" id="district_name" name="district_name" >
                            <option value="">Select District</option>
                            <option value="District 1">District 1</option>
                            <option value="District 2">District 2</option>
                            <option value="District 3">District 3</option>
                            <option value="District 4">District 4</option>
                            <option value="District 5">District 5</option>
                            <option value="District 6">District 6</option>
                        </select>
                    </div>


                    <input type="hidden" name="date_created" value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" name="date_updated" value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">

                    <!-- /.col -->
                    <div class="col-lg-12 col-md-12 col-12">
                        <button type="submit" class="btn btn-primary btn-block">Save</button>
                    </div>
                    <!-- /.col -->
            </div>
            </form>



        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->
</body>
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
