<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Return Books
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
          <li>Transaction</li>
          <li class="active">Return</li>
        </ol>
      </section>
      <section class="content">
        <?php
          // unset($_SESSION['error']);


        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
        ?>
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Returns</a>
              </div>
              <div class="box-body">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th class="hidden"></th>
                    <th>Date</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Book ID</th>
                    <th>Title</th>
                  </thead>
                  <tbody>
                    <?php
                      $sql = "SELECT  
                                  r.*, 
                                  u.firstname, 
                                  u.lastname, 
                                  u.user_id AS ID, 
                                  b.title, 
                                  b.status as stats,
                                  b.book_id
                              FROM 
                                  returns r
                              LEFT JOIN 
                                  users u ON u.id = r.user_id 
                              LEFT JOIN 
                                  books b ON b.id = r.book_id 
                              ORDER BY 
                                  r.date_return DESC";
                      $query = $conn->query($sql);

                      if ($query->num_rows > 0) {
                          while ($row = $query->fetch_assoc()) {
                              // Determine status label
                              $status = $row['stats'] ? 
                                        '<span class="label label-danger">borrowed</span>' : 
                                        '<span class="label label-success">returned</span>';
                              
                              // Output table row
                              echo "
                                  <tr>
                                      <td class='hidden'></td>
                                      <td>" . date('M d, Y', strtotime($row['date_return'])) . "</td>
                                      <td>" . htmlspecialchars($row['ID']) . "</td>
                                      <td>" . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . "</td>
                                      <td>" . htmlspecialchars($row['book_id']) . "</td>
                                      <td>" . htmlspecialchars($row['title']) . "</td>
                                      <td>$status</td>
                                  </tr>
                              ";
                          }
                      } else {
                          echo "
                              <tr>
                                  <td colspan='7'>No records found.</td>
                              </tr>
                          ";
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/return_modal.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function() {
      $(document).on('click', '#append', function(e) {
        e.preventDefault();
        $('#append-div').append(
          '<div class="form-group"><label for="" class="col-sm-3 control-label">Book ID</label><div class="col-sm-9"><input type="text" class="form-control" name="book_id[]"></div></div>'
        );
      });
    });
  </script>
</body>

</html>