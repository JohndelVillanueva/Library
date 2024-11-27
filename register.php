<?php
include 'includes/session.php';
require_once 'includes/conn.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $user_id = $_POST['user_id'] ?? null;
    $firstname = $_POST['firstname'] ?? null;
    $lastname = $_POST['lastname'] ?? null;

    if ($user_id && $firstname && $lastname) {
        try {
            $sql = "INSERT INTO users (user_id, firstname, lastname) 
                    VALUES (?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('sss', $user_id, $firstname, $lastname);

                if ($stmt->execute()) {
                    echo "<script>alert('User added successfully');</script>";
                } else {
                    echo "<script>alert('Failed to add User');</script>";
                }

                $stmt->close();
            } else {
                throw new Exception("Error preparing the query: " . $conn->error);
            }
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            echo "<script>alert('An error occurred. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Registration</title>
    <link rel="stylesheet" href="register.css">
    <script src="library.js"></script>
</head>
<body>
    <div class="container">
        <img src="Westfields Badge.png" alt="logo" class="logo">
        <div class="form-container">
            <h2>Register</h2>

            <form action="register.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="firstname" placeholder="First Name" required>
                <input type="text" name="lastname" placeholder="Last Name" required>
                <input type="text" name="user_id" placeholder="User ID" required>

                <div class="button-group">
                    <button type="submit" name="add">Submit</button>
                    <button type="button" class="back-btn" onclick="goBack()">Go Back</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
