<?php
// include('db.php');

$perPageOptions = [10, 25, 50, 100];
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['perPage']) && in_array($_GET['perPage'], $perPageOptions) ? (int)$_GET['perPage'] : 10;
$offset = ($page - 1) * $perPage;

// Filters and search terms
$schemeId = isset($_GET['schemeId']) ? $_GET['schemeId'] : '';
$districtId = isset($_GET['districtId']) ? $_GET['districtId'] : '';
$schoolLevel = isset($_GET['schoolLevel']) ? $_GET['schoolLevel'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build the SQL query with filters
$query = "SELECT * FROM individual_list WHERE 1";

// Apply filters
if ($schemeId) {
    $query .= " AND scheme_id = '$schemeId'";
}
if ($districtId) {
    $query .= " AND district_id = '$districtId'";
}
if ($schoolLevel) {
    $query .= " AND school_level = '$schoolLevel'";
}
if ($status !== '') {
    $query .= " AND status = '$status'";
}
if ($search) {
    $query .= " AND (firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR tracking_code LIKE '%$search%')";
}

// Add ordering and pagination
$query .= " ORDER BY date_created ASC";
if ($perPage != 'all') {
    $query .= " LIMIT $perPage OFFSET $offset";
}

// Execute query
$result = $conn->query($query);

// Fetch total count for pagination calculation
$countQuery = "SELECT COUNT(*) as total FROM individual_list WHERE 1";
$totalResult = $conn->query($countQuery)->fetch_assoc();
$totalRecords = $totalResult['total'];
$totalPages = ceil($totalRecords / $perPage);

$output = '';
while ($row = $result->fetch_assoc()) {
    $output .= "
    <tr>
        <td><input type='checkbox' class='individualCheck' data-id='{$row['id']}'></td>
        <td hidden='hidden'>{$row['id']}</td>
        <td>{$row['tracking_code']}</td>
        <td>{$row['firstname']} {$row['lastname']}</td>
        <td>{$row['district_name']}</td>
        <td>{$row['school_level']}</td>
        <td>" . ($row['status'] == 1 ? 'Partially Disbursed' : ($row['status'] == 2 ? 'Fully Disbursed' : 'Pending')) . "</td>
        <td>" . date("Y-m-d H:i:s", strtotime($row['date_created'])) . "</td>
        <td>" . ($row['enrollment_date'] ? date("Y-m-d", strtotime($row['enrollment_date'])) : 'Not Available') . "</td>
        <td>
            <button class='btn btn-warning btn-sm editBtn' data-id='{$row['id']}'>Edit</button>
            <button class='btn btn-danger btn-sm deleteBtn' data-id='{$row['id']}'>Delete</button>
        </td>
    </tr>";
}

// Return data as JSON
echo json_encode(['tableData' => $output, 'totalPages' => $totalPages]);
?>