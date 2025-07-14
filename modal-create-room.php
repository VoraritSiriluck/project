<div class="modal fade" id="CreateRoom" tabindex="-1" aria-labelledby="CreateRoomLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="CreateRoomLabel">Create Room</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?php
                    if (isset($_GET['message']) && $_GET['modal'] === 'room') {
                        $alert_class = $_GET['status'] === 'success' ? 'alert-success' : 'alert-danger';
                        echo "<div class='alert $alert_class mx-5 mt-2'>" . htmlspecialchars($_GET['message']) . "</div>";
                    }
                    ?>
                    <form action="admin-create-room.php" method="POST">
                        <div class="modal-body">
                            <div class="row-4">
                                <div class="col">
                                    <label for="" class="form-label">New Room :</label>
                                    <input type="text" class="form-control" name="new_room" required>

                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-success " name="btn-createroom">Create New Room</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>