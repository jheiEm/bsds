<?php require('../config.php') ?>
<?php
if (isset($_POST['button'])) {
    $_SESSION['email'] = '$email';
}

// Check if the email session variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Prepare the query using a parameterized statement
    $query = "SELECT * FROM client_list WHERE email = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Process the fetched records
        while ($row = $result->fetch_assoc()) {
            $first_name = $row["firstname"];
            $first_name = ucfirst(strtolower($first_name)); // Capitalize the first letter and lowercase the rest
        }
    }
} else {
    // Redirect to the login page or display an error message
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url('gradient_bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .dashboard {
            max-width: 500px;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9); /* Blue background with 20% opacity */
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #1D7ECB;
        }
        .dashboard p {
            font-size: 1.2rem;
            color: #333;
        }
        .dashboard__options {
            margin-top: 30px;
        }
        .dashboard__options button {
            width: 100%;
            margin-bottom: 15px;
            padding: 12px;
            font-size: 1rem;
            border-radius: 8px;
        }
        .dashboard__options button.btn-primary {
            background-color: #1D7ECB;
            border: none;
        }
        .dashboard__options button.btn-primary:hover {
            background-color: #105a87;
        }
    </style>
</head>
<body>

<div class="overlay"></div>

<div class="container">
    <div class="dashboard">
        <h1>Student Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($first_name); ?>!</p>

        <div class="dashboard__options">
            <button class="btn btn-primary" onclick="location.href='new_scholar.php'">Apply for Scholarship</button>
            <button class="btn btn-primary" onclick="location.href='view_details.php'">Student Details</button>
            <button class="btn btn-primary" onclick="location.href='schedule.php'">Disbursement Schedule Reminder</button>
            <button class="btn btn-primary" onclick="location.href='<?php echo base_url . '/user/'; ?>reschedule.php'">Request for Reschedule</button>
            <button class="btn btn-danger" onclick="location.href='logout.php'">Logout</button>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
