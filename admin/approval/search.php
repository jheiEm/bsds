<?php
//include('db.php');

// Get the search term
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Query for searching by name, contact, or tracking code
$query = "SELECT * FROM individual_list WHERE firstname LIKE '%$searchTerm%' OR lastname LIKE '%$searchTerm%' OR contact LIKE '%$searchTerm%' OR tracking_code LIKE '%$searchTerm%' OR district_name LIKE '%$searchTerm%' OR scheme_id LIKE '%$searchTerm%'";

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
            <td>{$row['scheme_id']}</td>
            <td>" . date("Y-m-d H:i:s", strtotime($row['date_created'])) . "</td> <!-- Display date_created -->
            <td>" . date("Y-m-d", strtotime($row['schedule_date'])) . "</td> <!-- Display requested_schedule_date -->
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
