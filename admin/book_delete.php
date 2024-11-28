<?php
include 'includes/session.php'; // Include your session and DB connection

if (isset($_POST['delete'])) {
	
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Book deleted successfully';
    } else {
        $_SESSION['error'] = $stmt->error;
    }
    $stmt->close();
} else {
    $_SESSION['error'] = 'Select item to delete first';
}

header('location: book.php');
exit;