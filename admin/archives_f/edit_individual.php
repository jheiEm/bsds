<?php
include('db.php');
if (!$conn) {
    die("Database connection failed");
}
// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $tracking_code = $_POST['tracking_code'];
    $status = $_POST['status'];

    // Update the individual record
    $sql = "UPDATE individual_list SET tracking_code = ?, firstname = ?, lastname = ?, status = ? WHERE id = ?";

    $nameParts = explode(" ", $name, 2);
    $firstname = $nameParts[0];
    $lastname = isset($nameParts[1]) ? $nameParts[1] : '';

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssii", $tracking_code, $firstname, $lastname, $status, $id);
        if ($stmt->execute()) {
            echo "Individual updated successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Could not prepare statement.";
    }
}
?>