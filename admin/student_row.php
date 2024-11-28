<?php 
    include 'includes/session.php';

    if(isset($_POST['id'])){
        $id = $_POST['id'];

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id); // Assuming user_id is an integer
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
    }
?>
