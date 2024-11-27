<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    $user = trim($_POST['user']);
    $book_ids = isset($_POST['book_id']) ? array_filter($_POST['book_id']) : [];

    // Initialize error session
    $_SESSION['error'] = [];
    $return_count = 0;

    // Check if User ID is provided
    if (empty($user)) {
        $_SESSION['error'][] = 'User ID is required';
        header('Location: return.php');
        exit();
    }

    // Fetch user details
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows < 1) {
        $_SESSION['error'][] = 'User not found';
        header('Location: return_page.php');
        exit();
    }

    $user_data = $user_result->fetch_assoc();
    $user_id = $user_data['id'];

    if (empty($book_ids)) {
        $_SESSION['error'][] = 'No books selected for return';
        header('Location: return_page.php');
        exit();
    }

    // Process each book
    foreach ($book_ids as $book_id) {
        $book_id = trim($book_id);
        if (empty($book_id)) continue;

        // Check if book exists
        $stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
        $stmt->bind_param("s", $book_id);
        $stmt->execute();
        $book_result = $stmt->get_result();

        if ($book_result->num_rows > 0) {
            $book_data = $book_result->fetch_assoc();
            $book_db_id = $book_data['id'];

            // Check if the book is borrowed by the user
            $stmt = $conn->prepare("SELECT * FROM borrow WHERE user_id = ? AND book_id = ? AND status = 0");
            $stmt->bind_param("ii", $user_id, $book_db_id);
            $stmt->execute();
            $borrow_result = $stmt->get_result();

            if ($borrow_result->num_rows > 0) {
                $borrow_data = $borrow_result->fetch_assoc();
                $borrow_id = $borrow_data['id'];

                // Begin transaction
                $conn->begin_transaction();
                try {
                    // Insert into returns table
                    $stmt = $conn->prepare("INSERT INTO returns (user_id, book_id, date_return) VALUES (?, ?, NOW())");
                    $stmt->bind_param("ii", $user_id, $book_db_id);
                    $stmt->execute();

                    // Update book status
                    $stmt = $conn->prepare("UPDATE books SET status = 0 WHERE id = ?");
                    $stmt->bind_param("i", $book_db_id);
                    $stmt->execute();

                    // Update borrow status
                    $stmt = $conn->prepare("UPDATE borrow SET status = 1 WHERE id = ?");
                    $stmt->bind_param("i", $borrow_id);
                    $stmt->execute();

                    $conn->commit();
                    $return_count++;
                } catch (Exception $e) {
                    $conn->rollback();
                    $_SESSION['error'][] = "Failed to return book (ID: $book_id): " . $e->getMessage();
                }
            } else {
                $_SESSION['error'][] = "Borrow record not found for Book ID: $book_id";
            }
        } else {
            $_SESSION['error'][] = "Book not found: Book ID - $book_id";
        }
    }

    if ($return_count > 0) {
        $_SESSION['success'] = "$return_count book(s) successfully returned";
    }
} else {
    $_SESSION['error'][] = 'Fill up the return form first';
}

header('Location: return.php');
exit();
?>
