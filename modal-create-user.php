<div class="modal fade" id="CreateUser" tabindex="-1" aria-labelledby="CreateUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="CreateUserLabel">Create User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?php
                    if (isset($_GET['message']) && $_GET['modal']   === 'user') {
                        $alert_class = $_GET['status'] === 'success' ? 'alert-success' : 'alert-danger';
                        echo "<div class='alert $alert_class mx-5 mt-2'>" . htmlspecialchars($_GET['message']) . "</div>";
                    }
                    ?>
                    <form action="admin-create-user.php" method="POST">
                        <div class="modal-body">
                            <div class="row-4">
                                <div class="col">
                                    <label for="" class="form-label">Username :</label>
                                    <input type="text" class="form-control" name="new_username" required>

                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Password :</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-success " name="btn-createuser">Create New User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>