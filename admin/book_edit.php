<?php
include 'includes/session.php'; 

if (isset($_POST['edit'])) {

    $bookId = $_POST['id'];
    $books = $_POST['book_id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $donate = $_POST['donate'];

    // Check if bookId is provided and valid
    // if (empty($bookId)) {
    //     echo "Invalid book ID.";
    //     exit();
    // }

    // Query to update the book details
    $sql = "UPDATE books b  SET b.book_id = ?, b.title = ?, b.category_id = ?, b.author = ?, b.donate = ? WHERE b.id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Log error and exit
        error_log("Error preparing statement: " . $conn->error);
        echo "An error occurred. Please try again.";
        exit();
    }
    // Bind parameters with the correct types
    $stmt->bind_param('sssssi', $books, $title, $category, $author, $donate, $bookId);

    // Execute the query and handle the result
    if ($stmt->execute()) {
        // echo "Book ID: " . $bookId . "<br>";
        // echo "Books: " . $books . "<br>";
        // echo "Title: " . $title . "<br>";
        // echo "Category: " . $category . "<br>";
        // echo "Author: " . $author . "<br>";
        // echo "Donate: " . $donate . "<br>";
        // die();
        // Redirect to the book listing page after a successful update
        header("Location: book.php");
        exit();
    } else {
        // Log the error and notify the user
        error_log("Error updating book: " . $stmt->error);
        echo "An error occurred while updating the book. Please try again.";
    }

    // Close the statement
    $stmt->close();
}


?>
