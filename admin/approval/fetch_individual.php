<?php
//include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch individual data
    $sql = "SELECT * FROM individual_list WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $individual = $result->fetch_assoc();
            echo json_encode(['success' => true, 'individual' => $individual]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Individual not found']);
        }
        $stmt->close();
    }
}
?>
