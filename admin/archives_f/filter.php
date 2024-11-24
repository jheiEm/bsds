<?php
include('db.php');
if (!$conn) {
    die("Database connection failed");
}
// Fetch filter values from GET, use empty string or default value if not set
$schemeId = isset($_GET['schemeId']) ? $_GET['schemeId'] : '';   // Default to an empty string if not set
$districtId = isset($_GET['districtId']) ? $_GET['districtId'] : ''; // Default to an empty string if not set
$schoolLevel = isset($_GET['schoolLevel']) ? $_GET['schoolLevel'] : '';  // Default to an empty string if not set
$status = isset($_GET['status']) ? $_GET['status'] : '';    // Default to an empty string if not set

// Construct filter query using JOIN to include district information
$query = "SELECT i.* 
          FROM individual_list i
          LEFT JOIN scholar_location_list sl ON i.district_name = sl.location
          WHERE 1 and status_client = 1";  // Start with a base WHERE condition (true)

// Apply filters conditionally
if ($schemeId) {
    $query .= " AND i.scheme_id = '$schemeId'"; // Filter by scheme ID
}

if ($districtId) {
    $query .= " AND sl.id = '$districtId'"; // Filter by district ID (from scholar_location_list)
}

if ($schoolLevel) {
    $query .= " AND i.school_level = '$schoolLevel'"; // Filter by school level
}

if ($status !== '') {
    $query .= " AND i.status = '$status'"; // Filter by status
}
// Add ORDER BY clause
$query .= " ORDER BY date_created ASC";  // Order by date_created in ascending order (oldest first)

// Execute the query
$result = $conn->query($query);

if (!$result) {
    die("Error: " . $conn->error);  // Handle potential query errors
}

// Prepare output
$output = '';
while ($row = $result->fetch_assoc()) {
    $output .= "
        <tr>
            <td><input type='checkbox' class='individualCheck' data-id='{$row['id']}'></td>
            <td hidden='hidden'>{$row['id']}</td>
            <td>{$row['tracking_code']}</td>
            <td>{$row['firstname']} {$row['lastname']}</td>
            <td>{$row['district_name']}</td> <!-- This is now fetched from individual_list -->
            <td>{$row['school_level']}</td>
            <td>" . ($row['status'] == 1 ? 'Fully Disbursed' : ($row['status'] == 2 ? 'Fully Disbursed' : 'Fully Disbursed')) . "</td>
            <td>" . date("Y-m-d H:i:s", strtotime($row['date_created'])) . "</td>
            <td>" . ($row['enrollment_date'] ? date("Y-m-d", strtotime($row['enrollment_date'])) : 'Not Available') . "</td>
            <td hidden='hidden'>
                <button class='btn btn-warning btn-sm editBtn' data-id='{$row['id']}'>Edit</button>
                <button class='btn btn-danger btn-sm deleteBtn' data-id='{$row['id']}'>Delete</button>
            </td>
        </tr>
    ";
}

// Output the result
echo $output;

?>

