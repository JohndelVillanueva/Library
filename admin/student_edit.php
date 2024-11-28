<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];

		// Sanitize input (optional but recommended)
		$firstname = mysqli_real_escape_string($conn, $firstname);
		$lastname = mysqli_real_escape_string($conn, $lastname);

		// Use prepared statements to avoid SQL injection
		$sql = "UPDATE users SET firstname = ?, lastname = ? WHERE id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('ssi', $firstname, $lastname, $id); // 'ssi' means string, string, integer

		if($stmt->execute()){
			$_SESSION['success'] = 'User updated successfully';
		} else {
			$_SESSION['error'] = $stmt->error;
		}
	} else {
		$_SESSION['error'] = 'Fill up edit form first';
	}
	var_dump([
		'id' => $id,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'success' => $_SESSION['success']
	]);
	die();

	header('location: student.php');
?>
