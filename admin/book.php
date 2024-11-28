<?php include 'includes/session.php'; 
?>
<?php
  $catid = 0;
  $where = '';
  if(isset($_GET['category'])){
    $catid = $_GET['category'];
    $where = 'WHERE books.category_id = '.$catid;
  }

?>
<?php include 'includes/header.php'; ?>
<style>
  #container {
    background-image: url('image/logomalino.png');
    background-color: rgba(0, 0, 0, 0.5); /* semi-transparent black overlay */
    background-position: center;
    background-size: cover;

}
</style>

<body id='container' class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Book List
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
        <li>Books</li>
        <li class="active">Book List</li>
      </ol>
    </section>
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
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
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
              <div class="box-tools pull-right">
                <form class="form-inline">
                  <div class="form-group">
                    <label>Category: </label>
                    <select class="form-control input-sm" id="select_category">
                      <option value="0">ALL</option>
                      <?php
                        $sql = "SELECT * FROM category";
                        $query = $conn->query($sql);
                        while($catrow = $query->fetch_assoc()){
                          $selected = ($catid == $catrow['id']) ? " selected" : "";
                          echo "
                            <option value='".$catrow['id']."' ".$selected.">".$catrow['name']."</option>
                          ";
                        }
                      ?>
                    </select>
                  </div>
                </form>
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Category</th>
                  <th>Book ID</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Donated By</th>
                  <th>Status</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT *, books.id AS book FROM books LEFT JOIN category ON category.id=books.category_id $where";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      if($row['status']){
                        $status = '<span class="label label-danger">borrowed</span>';
                      }
                      else{
                        $status = '<span class="label label-success">available</span>';
                      }
                      echo "
                      <tr>
                        <td>".$row['name']."</td>
                        <td>".$row['book_id']."</td>
                        <td>".$row['title']."</td>
                        <td>".$row['author']."</td>
                        <td>".$row['donate']."</td>
                        <td>".$status."</td>
                        <td>
                          <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['book']."' id='editBtn'>
                            <i class='fa fa-edit'></i> Edit
                          </button>
                          <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['book']."'>
                            <i class='fa fa-trash'></i> Delete
                          </button>
                        </td>
                      </tr>";
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
  <?php include 'includes/book_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(document).on('click', '.edit', function(e) {
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    console.log('Fetching book data for ID:', id); // Log the ID
    getRow(id);
});

$(document).ready(function() {
    $('.delete').click(function() {
        var id = $(this).data('id');
        $('#delete_id').val(id); // Set the hidden input's value
        $('#delete').modal('show'); // Show the modal
    });
});

function getRow(id) {
  $.ajax({
    type: 'POST',
    url: 'book_row.php',
    data: { id: id },
    dataType: 'json',
    success: function(response) {
      if (response && response.id) {
        // Log the response for debugging
        console.log(response); // Check the response in the browser console

        // Fill in the modal fields with the response data
        $('#id').val(response.id);  // Make sure 'id' is populated here
        $('#edit_isbn').val(response.book_id);
        $('#edit_title').val(response.title);
        $('#category').val(response.category_id).change();
        $('#edit_author').val(response.author);
        $('#edit_donate').val(response.donate);
      } else {
        console.error("No data received or invalid response.");
      }
    },
    error: function(xhr, status, error) {
      console.error("AJAX request failed: " + status + ", " + error);
    }
  });
}
</script>
</body>
</html>
