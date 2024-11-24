<?php
include('db.php');
if (!$conn) {
    die("Database connection failed");
}
// Fetch filter values
$schemeId = isset($_GET['schemeId']) ? $_GET['schemeId'] : '';
$districtId = isset($_GET['districtId']) ? $_GET['districtId'] : '';
$schoolLevel = isset($_GET['schoolLevel']) ? $_GET['schoolLevel'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Construct filter query
$query = "SELECT * FROM individual_list WHERE 1";

if ($schemeId) $query .= " AND scheme_id = '$schemeId'";
if ($districtId) $query .= " AND district_name = '$districtId'";
if ($schoolLevel) $query .= " AND school_level = '$schoolLevel'";
if ($status !== '') $query .= " AND status = '$status'";

$result = $conn->query($query);

$output = '';
while ($row = $result->fetch_assoc()) {
    $output .= "
        <tr>
            <td><input type='checkbox' class='individualCheck' data-id='{$row['id']}'></td>
            <td>{$row['id']}</td>
            <td>{$row['tracking_code']}</td>
            <td>{$row['firstname']} {$row['lastname']}</td>
            <td>{$row['district_name']}</td>
            <td>{$row['school_level']}</td>
            <td>" . ($row['status'] == 1 ? 'Partially Disbursed' : ($row['status'] == 2 ? 'Fully Disbursed' : 'Pending')) . "</td>
            <td>" . date("Y-m-d H:i:s", strtotime($row['date_created'])) . "</td> <!-- Display date_created -->
            <td>" . ($row['enrollment_date'] ? date("Y-m-d", strtotime($row['enrollment_date'])) : 'Not Available') . "</td> <!-- Display enrollment_date -->
            <td>
                <button class='btn btn-warning btn-sm editBtn' data-id='{$row['id']}'>Edit</button>
                <button class='btn btn-danger btn-sm deleteBtn' data-id='{$row['id']}'>Delete</button>
            </td>
        </tr>
    ";
}

echo $output;
?>