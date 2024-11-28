<?php
include 'includes/session.php'; // Ensure this file sets up $conn

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = intval($_POST['id']); // Sanitize input
    error_log("Received ID: " . $id); // Log the received ID for debugging

    // Prepare the SQL query using a prepared statement
    $sql = "SELECT * FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the parameter
        $stmt->bind_param("i", $id); // Assuming 'id' is an integer

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Log the fetched data for debugging
            error_log("Fetched book data: " . print_r($row, true));

            // Return the book data as JSON
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Book not found.']);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Database query preparation failed.']);
    }
} else {
    echo json_encode(['error' => 'Invalid or missing ID.']);
}
?>