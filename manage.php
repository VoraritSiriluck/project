<?php
require_once('connection.php');

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php") ?>
    <title>Manage User</title>
</head>

<body>
    <div class="d-flex">
        <nav class="bg-primary text-light p-3 vh-100 shadow border-end border-info" style="width: 280px; position:fixed;">
            <a href="admin.php" class="d-flex align-items-center mb-4 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" aria-hidden="true">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4"><b>แบบฟอร์มคำร้องขอทำความสะอาดพื้นที่</b></span>
            </a>
            <hr>

            <div class="btn-group bg-light w-100 mb-2 shadow rounded" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="btnradioUser" autocomplete="off" checked>
                <label class="btn btn-outline-success" for="btnradioUser"><i class="fa-solid fa-users"></i> <b> User</b></label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradioRoom" autocomplete="off">
                <label class="btn btn-outline-success" for="btnradioRoom"><i class="fa-solid fa-tents"></i> <b> Room</b></label>

            </div>
            <a href="admin.php" class="btn btn-outline-light w-100 mb-2 shadow rounded"><b><i class="fa-solid fa-house"></i> Dash Board</b></a>
            <button type="button" class="btn btn-outline-light w-100 mb-2 shadow rounded" data-bs-toggle="modal" data-bs-target="#CreateUser">
                <b><i class="fa-solid fa-user-plus"></i> Create User</b>
            </button>
            <button type="button" class="btn btn-outline-light w-100 mb-2 shadow rounded" data-bs-toggle="modal" data-bs-target="#CreateRoom">
                <b><i class="fa-solid fa-house-medical"></i> Create Room</b>
            </button>
            
            <a href="chart.php" class="btn btn-outline-light w-100 mb-2 shadow rounded"><b><i class="fa-solid fa-chart-line"></i> Chart</b></a>
            <a href="index.php" class="btn btn-outline-light w-100 mb-2 shadow rounded"> <b><i class="fa-solid fa-file-invoice"></i> Back to Form</b></a>
            <button type="button" class="btn btn-outline-danger w-100 mb-2 shadow rounded" data-bs-toggle="modal" data-bs-target="#Logout">
                <b><i class="fa-solid fa-right-from-bracket"></i> Logout</b>
            </button>

        </nav>

        <?php include('./modal-create-user.php') ?>
        <?php include('./modal-create-room.php') ?>
        <?php include('./modal-logout.php') ?>

        <div class="flex-grow-1 p-4" style="margin-left: 280px;">

            <span class="text-primary fs-3">
                <div class="row">
                    <h1 class="col"><b>Manage User & Room</b></h1>
                    <a href="admin.php" class="col-md-1 me-2 mt-3 align-item-end btn btn-primary shadow rounded">
                        <b>Back</b>
                    </a>
                </div>


                <h5 class="text-secondary">เพิ่ม แก้ไขและลบข้อมูล ผู้เข้าใช้งานและห้อง</h5>

            </span>
            <div class="table-responsive" id="wrapperUser">

                <h2>User</h2>

                <?php
                if (isset($_GET['messageUP'])) {
                    $UpdateUserMsg = $_GET['messageUP']
                ?>
                    <div class="alert alert-success w-50">
                        <strong><?php echo htmlspecialchars($UpdateUserMsg) ?></strong>
                    </div>
                <?php } ?>

                <?php
                if (isset($_GET['messageER'])) {
                    $UpdateUserMsg = $_GET['messageER']
                ?>
                    <div class="alert alert-danger w-50">
                        <strong><?php echo htmlspecialchars($UpdateUserMsg) ?></strong>
                    </div>
                <?php } ?>

                <table class="table table-striped table-bordered table-hover text-light w-100" id="tableUser">
                    <thead class="shadow p-3 mb-5 bg-body-tertiary rounded">
                        <tr>
                            <th>No.</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="shadow p-3 mb-5 bg-body-tertiary rounded">
                        <?php
                        $sqlU = "SELECT * FROM user ";
                        $select_stmt = $db->prepare($sqlU);
                        $select_stmt->execute();
                        $count = 1;
                        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row["username"] ?></td>
                                <td>********</td>
                                <td><button type="button"
                                        class="btn btn-outline-warning mb-2 shadow rounded open-EditUserModal"
                                        data-bs-toggle="modal"
                                        data-bs-target="#EditUser"
                                        data-user-id="<?php echo $row['id']; ?>"
                                        data-username="<?php echo htmlspecialchars($row['username']); ?>">
                                        <i class="fa-solid fa-pen"></i><b> Edit</b>
                                    </button></td>
                                <td><a href="admin-delete.php?deleteuser_id=<?php echo $row['id']; ?>" class="btn btn-outline-danger" onclick="return confirm('คุณต้องการจะลบข้อมูลนี้ใช่หรือไม่?')"><i class="fa-solid fa-trash"></i><b> Delete</b></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php include('./modal-edit-user.php') ?>

            <div class="table-responsive " id="wrapperRoom">
                <h2>Room</h2>
                <?php
                if (isset($_GET['messageUP'])) {
                    $UpdateRoomMsg = $_GET['messageUP']
                ?>
                    <div class="alert alert-success w-50">
                        <strong><?php echo htmlspecialchars($UpdateRoomMsg) ?></strong>
                    </div>
                <?php } ?>

                <?php
                if (isset($_GET['messageER'])) {
                    $UpdateRoomMsg = $_GET['messageER']
                ?>
                    <div class="alert alert-danger w-50">
                        <strong><?php echo htmlspecialchars($UpdateRoomMsg) ?></strong>
                    </div>
                <?php } ?>

                <table class="table table-striped table-bordered table-hover text-dark w-100" id="tableRoom">
                    <thead class="shadow p-3 mb-5 bg-body-tertiary rounded">
                        <tr>
                            <th>No.</th>
                            <th>Room Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody class="shadow p-3 mb-5 bg-body-tertiary rounded">

                        <?php

                        $sqlR = "SELECT * FROM room ";
                        $select_stmt = $db->prepare($sqlR);
                        $select_stmt->execute();

                        $count = 1;

                        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row["room_name"] ?></td>
                                <td><button type="button"
                                        class="btn btn-outline-warning mb-2 shadow rounded open-EditRoomModal"
                                        data-bs-toggle="modal"
                                        data-bs-target="#EditRoom"
                                        data-room-id="<?php echo $row['id']; ?>"
                                        data-roomname="<?php echo htmlspecialchars($row['room_name']); ?>">
                                        <i class="fa-solid fa-pen"></i> <b>Edit</b>
                                    </button></td>
                                <td><a href="admin-delete.php?deleteroom_id=<?php echo $row['id']; ?>" class="btn btn-outline-danger" onclick="return confirm('คุณต้องการจะลบข้อมูลนี้ใช่หรือไม่?')"><i class="fa-solid fa-trash"></i><b> Delete</b></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php include('./modal-edit-room.php') ?>
        </div>

        <?php include("script.php") ?>
        <script>
            //Manage Switch 

            let tableUser = null;
            let tableRoom = null;

            // $(document).ready(function() {
            //     $('#wrapperRoom').show(); // Force โชว์ Room ทันที
            //     tableRoom = $('#tableRoom').DataTable({
            //         "order": [
            //             [0, "desc"]
            //         ],
            //         responsive: true
            //     });
            // });

            $(document).ready(function() {
                $('#wrapperRoom').hide();

                tableUser = $('#tableUser').DataTable({
                    "order": [
                        [0, "desc"]
                    ],
                    responsive: true
                });

                tableRoom = $('#tableRoom').DataTable({
                    "order": [
                        [0, "desc"]
                    ],
                    responsive: true
                });

                $('#btnradioUser').on('change', function() {
                    if (this.checked) {
                        $('#wrapperUser').show();
                        $('#wrapperRoom').hide();
                        tableUser.columns.adjust().draw();
                    }
                });

                $('#btnradioRoom').on('change', function() {
                    if (this.checked) {
                        $('#wrapperUser').hide();
                        $('#wrapperRoom').show();
                        tableRoom.columns.adjust().draw();
                    }
                });

            });
            //-------------------------------------------------------------------------------------------
            // document.getElementById('btnradioUser').addEventListener('change', function() {
            //     if (this. checked) {
            //         document.querySelector('#tableUser').parentElement.style.display = 'block';
            //         document.querySelector('#tableRoom').parentElement.style.display = 'none';

            //         if (tableRoom) {
            //             tableRoom.destroy();
            //             tableRoom = null;
            //         }

            //         if (!tableUser) {
            //             tableUser = $('#tableUser').DataTable({
            //                 "order": [
            //                     [0, "desc"]
            //                 ],responsive: true
            //             });
            //         }
            //     }
            // });

            // document.getElementById('btnradioRoom').addEventListener('change', function(){
            //     if (this. checked) {
            //         document.querySelector('#tableUser').parentElement.style.display = 'none';
            //         document.querySelector('#tableRoom').parentElement.style.display = 'block';

            //         if (tableUser) {
            //             tableUser.destroy();
            //             tableUser = null;
            //         }

            //         if (!tableRoom) {
            //             tableRoom = $('#tableRoom').DataTable({
            //                 "order": [[0,"desc"]],
            //                 responsive: true
            //             })
            //         }
            //     }
            // });
            //-------------------------------------------------------------------------------------------------------------------


            // Modal
            const urlParam = new URLSearchParams(window.location.search);
            const showModal = urlParam.get('show_modal');
            const modalType = urlParam.get('modal');



            if (showModal === '1' && modalType) {

                if (modalType === "user") {
                    new bootstrap.Modal(document.getElementById('CreateUser')).show();
                } else if (modalType === "room") {
                    new bootstrap.Modal(document.getElementById("CreateRoom")).show();
                } else if (modalType === "logout") {
                    new bootstrap.Modal(document.getElementById('Logout')).show();
                }
                window.history.replaceState({}, document.title, window.location.pathname);


                // const status = urlParam.get('status');
                // const message = urlParam.get('message');



                // if (message && status && document.getElementById('CreateUser')){
                //     new bootstrap.Modal(document.getElementById('CreateUser')).show();
                // }

                // if (message && status && document.getElementById('CreateRoom')) {
                //     new bootstrap.Modal(document.getElementById('CreateRoom')).show();
                // }

                // const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                // modal.show();
            }


            $(document).ready(function() {
                $('.open-EditUserModal').on('click', function() {
                    const userId = $(this).data('user-id');
                    const username = $(this).data('username');


                    $('#editUserId').val(userId);
                    $('#editUsername').val(username);
                })
            })

            $(document).ready(function() {
                $('.open-EditRoomModal').on('click', function() {
                    const roomId = $(this).data('room-id');
                    const roomname = $(this).data('roomname');


                    $('#editRoomId').val(roomId);
                    $('#editRoomName').val(roomname);
                })
            })
        </script>
</body>

</html>