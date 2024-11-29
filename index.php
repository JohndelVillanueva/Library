<?php include 'includes/session.php'; 
?>
<?php
    $where = '';
    $catid = 0; 
    if (isset($_GET['category'])) {
        $catid = $_GET['category'];
        $where = 'WHERE category_id = ?';
    }
?>

<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="LMS.css">
</head>
<body>
    <div class="container">
        <img src="Westfields Badge.png" alt="logo">
        <h1>Westfields International School</h1>
        <?php
            if (isset($_SESSION['error'])) {
                echo "
                    <div class='alert alert-danger'>
                        " . $_SESSION['error'] . "
                    </div>
                ";
                unset($_SESSION['error']);
            }
        ?>
        <div class="box-header with-border">
            <div class="input-group">
                <input type="text" class="form-control input-lg" id="searchBox" placeholder="Search Book">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-flat btn-lg"><i class="fa fa-search"></i> </button>
                </span>
            </div>
        </div>

        <div class="input-group col-sm-5">
            <span class="input-group-addon">Category:</span>
            <select class="form-control" id="catlist">
                <option value=0>ALL</option>
                <?php
                    $sql = "SELECT * FROM category";
                    $result = $conn->query($sql);

                    while ($catrow = $result->fetch_assoc()) {
                        $selected = ($catid == $catrow['id']) ? " selected" : "";
                        echo "
                            <option value='" . $catrow['id'] . "' " . $selected . ">" . $catrow['name'] . "</option>
                        ";
                    }
                ?>
            </select>
        </div>
        <table class="table table-bordered table-striped" id="booklist">
            <thead>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM books $where";
                    if ($stmt = $conn->prepare($sql)) {
                        if (!empty($where)) {
                            $stmt->bind_param('i', $catid); // Bind the category ID as an integer
                        }

                        $stmt->execute();

                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            $status = ($row['status'] == 0) ? '<span class="label label-success">available</span>' : '<span class="label label-danger">not available</span>';
                            echo "
                                <tr>
                                    <td>" . $row['book_id'] . "</td>
                                    <td>" . $row['title'] . "</td>
                                    <td>" . $row['author'] . "</td>
                                    <td>" . $status . "</td>
                                </tr>
                            ";
                        }

                        $stmt->close();
                    }
                ?>
            </tbody>
        </table>

        <h2>Register to have access to books</h2>

        <div class="button-group">
            <a href="register.php" class="btn-secondary">Register Here</a>
        </div>
    </div>
    <?php include 'includes/scripts.php'; ?>
    <script>
        $(function(){
            $('#catlist').on('change', function(){
                if ($(this).val() == 0) {
                    window.location = 'index.php';
                } else {
                    window.location = 'index.php?category=' + $(this).val();
                }
            });
        });
    </script>
</body>
</html>
