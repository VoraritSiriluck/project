<div class="modal fade" id="EditRoom" tabindex="-1" aria-labelledby="EditRoomLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="EditRoomLabel">Edit Room</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?php 
                    ?>
                    <form action="admin-update-room.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="room_id" id="editRoomId">
                            <div class="row">
                                <div class="col">
                                    <label for="" class="form-label">Room Name :</label>
                                    <input type="text" class="form-control" name="room_name" id="editRoomName">

                                </div>
                                

                            </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="submit" class="btn btn-success " name="btn-updateroom">Update Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>