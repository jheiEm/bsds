<?php
include('db.php');
if (!$conn) {
    die("Database connection failed");
}
// Check if IDs and new status are provided
if (isset($_POST['ids']) && isset($_POST['status'])) {
    $ids = implode(',', $_POST['ids']); // Convert array to comma-separated string
    $status = $_POST['status'];

    // SQL query to update the status of selected individuals
    $sql = "UPDATE individual_list SET status = ? WHERE id IN ($ids)";
    if ($status === '1') {

    }
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $status); // Bind status as integer
        if ($stmt->execute()) {
            echo "Mass update successful!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Could not prepare the statement.";
    }
} else {
    echo "Invalid request.";
}
?>
