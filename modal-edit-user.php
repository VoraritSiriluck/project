<div class="modal fade" id="EditUser" tabindex="-1" aria-labelledby="EditUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="EditUserLabel">Edit User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?php
                    ?>
                    <form action="admin-update-user.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="user_id" id="editUserId">
                            <div class="row-4">
                                <div class="col">
                                    <label for="" class="form-label">Username :</label>
                                    <input type="text" class="form-control" name="new_username" id="editUsername" required>

                                </div>
                                <div class="col">
                                    <label for="" class="form-label">New Password :</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="submit" class="btn btn-success " name="btn-updateuser">Update Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>