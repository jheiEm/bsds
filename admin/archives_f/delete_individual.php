<?php
include('db.php');
if (!$conn) {
    die("Database connection failed");
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Delete individual record
    $sql = "DELETE FROM individual_list WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Individual deleted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Could not prepare statement.";
    }
}
?>
