<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
		$stmt->bind_param('i', $id); // 'i' for integer

		if($stmt->execute()){
			$_SESSION['success'] = 'User deleted successfully';
		}
		else{
			$_SESSION['error'] = $stmt->error;
		}
	} else {
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: student.php');
?>
	