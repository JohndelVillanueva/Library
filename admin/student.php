<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <div class="content-wrapper">
      <section class="content-header">
        <h1>Users List</h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
          <li>User</li>
          <li class="active">User List</li>
        </ol>
      </section>

      <section class="content">
        <?php
          if (isset($_SESSION['error'])) {
            echo "
              <div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-warning'></i> Error!</h4>
                ".$_SESSION['error']."
              </div>
            ";
            unset($_SESSION['error']);
          }

          if (isset($_SESSION['success'])) {
            echo "
              <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-check'></i> Success!</h4>
                ".$_SESSION['success']."
              </div>
            ";
            unset($_SESSION['success']);
          }
        ?>

        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
              </div>
              <div class="box-body">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th>User ID</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                    <?php
                      $sql = "SELECT * FROM users";
                      $query = $conn->query($sql);
                      while ($row = $query->fetch_assoc()) {
                        echo "
                          <tr>
                            <td>".$row['user_id']."</td>
                            <td>".$row['firstname']."</td>
                            <td>".$row['lastname']."</td>
                            <td>
                              <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
                              <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Delete</button>
                            </td>
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
    <?php include 'includes/student_modal.php'; ?>
  </div>

  <?php include 'includes/scripts.php'; ?>

  <script>
    $(function(){
      $(document).on('click', '.edit', function(e){
        e.preventDefault();
        $('#edit').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.delete', function(e){
        var id = $(this).data('id');
        $('#delete_id').val(id);
        $('#delete').modal('show');
        getRow(id);
      });
    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'student_row.php',
        data: {id: id},
        dataType: 'json',
        success: function(response) {
      if (response && response.id) {
        // Log the response for debugging
        console.log(response); // Check the response in the browser console

        
          $('#id').val(response.id);
          $('#edit_firstname').val(response.firstname);
          $('#edit_lastname').val(response.lastname);
          $('.del_stu').html(response.firstname + ' ' + response.lastname);
      }else{

      }
      } ,
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
    });
  }
  </script>

</body>
</html>
