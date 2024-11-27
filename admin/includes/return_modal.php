<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Return Books</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="return_add.php">
                    <div class="form-group">
                        <label for="user" class="col-sm-3 control-label">User ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="user" name="user" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="book_id" class="col-sm-3 control-label">Book ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="book_id" name="book_id[]" required>
                        </div>
                    </div>
                    <div id="append-div"></div>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="button" class="btn btn-primary btn-xs btn-flat" id="append">
                                <i class="fa fa-plus"></i> Add Book Field
                            </button>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
                <button type="submit" class="btn btn-primary btn-flat" name="add">
                    <i class="fa fa-save"></i> Save
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Add additional book fields dynamically
    document.getElementById('append').addEventListener('click', function (e) {
        e.preventDefault();
        const appendDiv = document.getElementById('append-div');
        const newField = `
            <div class="form-group">
                <label for="book_id" class="col-sm-3 control-label">Book ID</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="book_id[]" required>
                </div>
            </div>`;
        appendDiv.insertAdjacentHTML('beforeend', newField);
    });
</script>