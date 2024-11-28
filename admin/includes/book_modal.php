<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add New Book</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="book_add.php">
              <!-- <input type="hidden" name="id" class="id" id="id" value=""> -->
          		  <div class="form-group">
                  	<label for="book_id" class="col-sm-3 control-label">Book ID</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="book_id" name="book_id" required>
                  	</div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-3 control-label">Title</label>

                    <div class="col-sm-9">
                      <textarea class="form-control" name="title" id="title" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="category" class="col-sm-3 control-label">Category</label>
                    <div class="col-sm-9">
                    <select class="form-control" name="category" id="category" required>
                      <?php
                        $sql = "SELECT * FROM category";
                        $query = $conn->query($sql);
                        $categories = $query->fetch_all(MYSQLI_ASSOC); // Fetch all results as an associative array

                        foreach ($categories as $crow) {
                          echo "
                            <option value='".$crow['id']."'>".$crow['name']."</option>
                          ";
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                    <label for="author" class="col-sm-3 control-label">Author</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="author" name="author">
                    </div>
                </div>
                <div class="form-group">
                    <label for="donate" class="col-sm-3 control-label">Donated By: </label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="donate" name="donate">
                    </div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Edit Book</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="book_edit.php">
              <input type="hidden" class="book_id" name="id" id="id" value="<?php echo isset($row['book']) ? $row['book'] : ''; ?>">
                    <div class="form-group">
                        <label for="edit_isbn" class="col-sm-3 control-label">Book ID</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="edit_isbn" name="book_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_title" class="col-sm-3 control-label">Title</label>

                        <div class="col-sm-9">
                          <textarea class="form-control" name="title" id="edit_title"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-sm-3 control-label">Category</label>

                        <div class="col-sm-9">
                        <select class="form-control" name="category" id="category">
                          <option value="" selected id="catselect"></option>
                          <?php
                            $sql = "SELECT * FROM category";
                            $query = $conn->query($sql);
                            while($crow = $query->fetch_assoc()){
                              echo "<option value='".$crow['id']."'>".$crow['name']."</option>";
                            }
                          ?>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_author" class="col-sm-3 control-label">Author</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="edit_author" name="author">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_donate" class="col-sm-3 control-label">Donated By:</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="edit_donate" name="donate">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                  <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
          	</div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Are you sure you want to delete?</b></h4>
            </div>
            <form method="POST" action="book_delete.php">
                <div class="modal-body">
                    <input type="hidden" name="id" id="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>


     