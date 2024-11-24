<?php
include('db.php');
if (!$conn) {
    die("Database connection failed");
}

// Fetch filter values from GET
$schemeId = isset($_GET['schemeId']) ? $_GET['schemeId'] : '';
$districtId = isset($_GET['districtId']) ? $_GET['districtId'] : '';  // Get district filter
$schoolLevel = isset($_GET['schoolLevel']) ? $_GET['schoolLevel'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';  // Get status filter

// Construct query with JOINs to get the necessary information, including scheme name
$query = "
    SELECT i.*, sl.id as district_id, sl.location, s.name as scheme_name
    FROM individual_list i
    LEFT JOIN scholar_location_list sl ON i.district_name = sl.location
    LEFT JOIN scheme_list s ON i.scheme_id = s.id
    WHERE 1";  // Basic query with no filters initially

// Apply filters conditionally
if ($schemeId) {
    $query .= " AND i.scheme_id = '$schemeId'";
}

if ($districtId) {
    $query .= " AND sl.id = '$districtId'";  // Filter by district
}

if ($schoolLevel) {
    $query .= " AND i.school_level = '$schoolLevel'";
}

if ($status !== '') {
    $query .= " AND i.status = '$status'";  // Filter by status (e.g., 1 for partially disbursed)
}

// Add ORDER BY clause
$query .= " ORDER BY date_created ASC";

// Execute the query
$result = $conn->query($query);

if (!$result) {
    die("Error: " . $conn->error);
}

// Prepare output
$output = '';
while ($row = $result->fetch_assoc()) {
    $scheme_name = $row['scheme_name'] ? $row['scheme_name'] : 'No Scheme';
    $statusText = $row['status'] == 1 ? 'Partially Disbursed' : ($row['status'] == 2 ? 'Fully Disbursed' : 'Pending');
    $dateCreated = date("Y-m-d H:i:s", strtotime($row['date_created']));
    $requested_date = date("Y-m-d", strtotime($row['schedule_date']));
    $enrollmentDate = $row['enrollment_date'] ? date("Y-m-d", strtotime($row['enrollment_date'])) : 'Not Available';

    $output .= "
        <tr>
            <td><input type='checkbox' class='individualCheck' data-id='{$row['id']}'></td>
            <td hidden='hidden'>{$row['id']}</td>
            <td>{$row['tracking_code']}</td>
            <td>{$row['firstname']} {$row['lastname']}</td>
            <td>{$row['district_name']}</td>
            <td>{$row['school_level']}</td>
            <td>{$statusText}</td>
            <td>{$scheme_name}</td>
            <td>{$requested_date}</td>
            <td>{$dateCreated}</td>
            <td>{$enrollmentDate}</td>
            <td>
                <button class='btn btn-warning btn-sm editBtn' data-id='{$row['id']}'>Edit</button>
                <button class='btn btn-danger btn-sm deleteBtn' data-id='{$row['id']}'>Delete</button>
            </td>
        </tr>
    ";
}

// Output the result
echo $output;

?>
