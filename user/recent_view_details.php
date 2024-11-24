<?php require('../config.php') ?>

<?php
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    header('Location: login.php');
    exit();
}

// Database connection check
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Secure query using prepared statements to prevent SQL injection
$query = $conn->prepare("SELECT * FROM individual_list WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

// Fetch data
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// No need to explicitly close the connection if handled by DBConnection destructor
$query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholar Details</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include DataTables CSS with Bootstrap 5 integration -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background-color: #f0f0f0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }
        table {
            background-color: #343A40;
            color: white;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
        }
        .badge-primary {
            background-color: #007bff;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-light {
            background-color: #f8f9fa;
            color: #343a40;
        }
        .btn-back {
            background-color: #1d7ecb;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-back:hover {
            background-color: #145a99;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row mb-3">
        <div class="col text-start">
            <a href="<?php echo base_url ?>user/dashboard.php" class="btn-back">Back to Site</a>
        </div>
    </div>
    <h1>Scholar Details</h1>
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <!-- Add table-responsive for Bootstrap responsiveness -->
            <div class="table-responsive">
                <table id="myTable" class="table table-dark table-hover table-striped">
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
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['tracking_code']) ?></td>
                            <td><?= htmlspecialchars($row['firstname']) ?></td>
                            <td><?= htmlspecialchars($row['lastname']) ?></td>
                            <td><?= htmlspecialchars($row['gender']) ?></td>
                            <td><?= htmlspecialchars($row['dob']) ?></td>
                            <td><?= htmlspecialchars($row['age']) ?></td>
                            <td><?= htmlspecialchars($row['address']) ?></td>
                            <td>
                                <?php
                                switch ($row['status']) {
                                    case 1:
                                        echo '<span class="badge badge-primary">1st Disbursement Completed (Partially Disbursed)</span>';
                                        break;
                                    case 2:
                                        echo '<span class="badge badge-success">2nd Disbursement Completed (Partially Disbursed)</span>';
                                        break;
                                    case 4:
                                        echo '<span class="badge badge-success">3rd Disbursement Completed (Fully Disbursed)</span>';
                                        break;
                                    default:
                                        echo '<span class="badge badge-light">Pending</span>';
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($row['district_name']) ?></td>
                            <td>
                                <?php
                                // Check for the first valid disbursement schedule and display only one
                                if ($row['schedule'] != "0000-00-00" && !empty($row['schedule'])) {
                                    echo 'First Disbursement: ' . date('F-d-Y h:i a', strtotime($row['schedule'])) . '<br>';
                                } elseif ($row['schedule_2'] != "0000-00-00" && !empty($row['schedule_2'])) {
                                    echo 'Second Disbursement: ' . date('F-d-Y h:i a', strtotime($row['schedule_2'])) . '<br>';
                                } elseif ($row['schedule_3'] != "0000-00-00" && !empty($row['schedule_3'])) {
                                    echo 'Third Disbursement: ' . date('F-d-Y h:i a', strtotime($row['schedule_3'])) . '<br>';
                                } else {
                                    echo 'All Disbursement Schedules Pending.';
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($row['contact']) ?></td>
                            <td><?= htmlspecialchars($row['mother_fullname']) ?></td>
                            <td><?= htmlspecialchars($row['father_fullname']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Include DataTables JS with Bootstrap 5 integration -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<!-- Initialize DataTable -->
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            // Optional: enable Bootstrap style for pagination and search filter
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "autoWidth": false
        });
    });
</script>
</body>
</html>
