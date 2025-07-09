<?php


require_once('connection.php');


if (isset($_GET['check_id'])) {


    try {
        $id = $_GET['check_id'];
        if (!is_numeric($id)) {
            die("Invalid ID");
        }
        $select_stmt = $db->prepare("SELECT * FROM clean_report WHERE id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $path = "upload/";
        $newname = $path . $image_name;

        $original_date = $report_date;
        $timestamp = strtotime($original_date);
        $thai_time = date("d/m/", $timestamp) . (date("Y", $timestamp) + 543);
    } catch (PDOException $e) {
        echo "error" . $e->getMessage();
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php") ?>
    <title>inspect</title>

</head>


<body class="bg-secondary">
    <!-- Side Bar -->
    <div class="d-flex">
        <nav class="bg-dark text-light p-3 vh-100" style="width: 280px; position:fixed;">
            <a href="inspect.php?check_id=<?php echo $row["id"]; ?>" class="d-flex align-items-center mb-4 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" aria-hidden="true">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4"><b>Check </b></span>
            </a>


            <hr>

            <button type="button" class="btn btn-warning w-100 mb-2" data-bs-toggle="modal" data-bs-target="#CreateUser">
                Create User
            </button>
            <button type="button" class="btn btn-light w-100 mb-2" data-bs-toggle="modal" data-bs-target="#CreateRoom">
                Create Room
            </button>



            <a href="chart.php" class="btn btn-primary w-100 mb-2">Chart</a>
             <button type="button" class="btn btn-danger w-100 mb-2" data-bs-toggle="modal" data-bs-target="#Logout">
                Logout
            </button>
            <!-- <a href="admin.php?logout='1'" class="btn btn-danger w-100">Logout</a> -->
            <!-- <hr>
            <center>
                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn btn-success">Left</button>
                    <button type="button" class="btn btn-warning">Middle</button>
                    <button type="button" class="btn btn-danger">Right</button>
                </div>
            </center> -->

            <hr>
            <!-- Status -->
            <form action="update-status.php" method="POST">
                <input type="hidden" name="reporter_id" value="<?php echo $id; ?>">
                <div class="bg-secondary p-3 rounded-3">
                    <span class=" fs-4 "><b>Status : </b></span>
                    <div class="text-center">
                        <div class="form-check mt-2 my-2">
                            <input class="form-check-input" type="radio" name="status" id="radiowaiting" value="waiting" <?php if ($status == 'waiting') echo 'checked'; ?>>
                            <label class="form-check-label bg-dark w-100 rounded text-light" for="radiowaiting">
                                รอตรวจสอบ
                            </label>
                        </div>
                        <div class="form-check my-2">
                            <input class="form-check-input" type="radio" name="status" id="radioProgress" value="in_progress" <?php if ($status == 'in_progress') echo 'checked'; ?>>
                            <label class="form-check-label bg-warning w-100 rounded text-dark" for="radioProgress">
                                อยู่ระหว่างดำเนินการ
                            </label>
                        </div>
                        <div class="form-check my-2">
                            <input class="form-check-input" type="radio" name="status" id="radioDone" value="done" <?php if ($status == 'done') echo 'checked'; ?>>
                            <label class="form-check-label bg-success w-100  rounded" for="radioDone">
                                ดำเนินการแล้วเสร็จ
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="radioCancel" value="cancel" <?php if ($status == 'cancel') echo 'checked'; ?>>
                            <label class="form-check-label bg-danger w-100 rounded " for="radioCancel">
                                ยกเลิก
                            </label>
                        </div>
                    </div>


                    <div class="mt-3" id="cancelReasonWrapper" style="display: <?php echo ($status == 'cancel') ? 'block' : 'none'; ?>;">
                        <label for="cancel_reason" class="form-label text-light">เหตุผลการยกเลิก :</label>
                        <textarea name="cancel_reason" id="cancel_reason" rows="3" class="form-control"><?php echo htmlspecialchars($cancel_reason ?? ''); ?></textarea>
                    </div>


                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-light">Update Status</button>
                    </div>
                </div>
            </form>

            <script>
                const radioCancel = document.getElementById('radioCancel');
                const radios = document.querySelectorAll('input[name="status"]');
                const radioReasoncancel = document.getElementById('cancelReasonWrapper');


                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (radioCancel.checked) {
                            cancelReasonWrapper.style.display = 'block';
                        } else {
                            cancelReasonWrapper.style.display = 'none';
                        }
                    });
                });
            </script>



        </nav>

        <!-- Modal User-->

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
        <!-- Modal Room-->
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

        <!-- Modal logout -->
        <div class="modal fade" id="Logout" tabindex="-1" aria-labelledby="LogoutLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="LogoutLabel">Logout</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?php
                    if (isset($_GET['message']) && $_GET['modal'] === 'room') {
                        $alert_class = $_GET['status'] === 'success' ? 'alert-success' : 'alert-danger';
                        echo "<div class='alert $alert_class mx-5 mt-2'>" . htmlspecialchars($_GET['message']) . "</div>";
                    }
                    ?>
                     <form action="admin.php" method="POST">
                        <div class="modal-body">
                            <div class="row-4">
                                <div class="col">
                                    <h6>คุณต้องการจะออกจากระบบใช่หรือไม่</h6>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <a href="admin.php?logout='1'" class="btn btn-danger " name="btn-logout-logout">Logout</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="container bg-secondary px-5 pb-3" style="height:100%; margin-left:280px;">
            <header class="row d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                <div class="col d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                    <svg
                        class="bi me-2" width="40" height="32" aria-hidden="true">
                        <use xlink:href="#bootstrap"></use>
                    </svg> <span class="fs-4 text-light"></span>
                </div>
                <a href="admin.php" class="col-md-1 me-5   align-items-end btn btn-light  "><b>Back</b></a>
            </header>

            <div class="row pb-5 pt-2 mb-1 bg-light rounded-4">
                <!--LEFT -->
                <div class="col ">
                    <div class="bg-dark text-white mb-2 rounded-3 ">
                        <h1 class="ms-3 mt-4">Data : </h1>
                    </div>

                    <div class="row">
                        <!--LLLLL-->
                        <div class="col my-1 ">
                            <div class="text-black my-2  text-start fs-5"><b>ชื่อผู้รายงาน : </b></div>
                            <div class="bg-white border border-black   my-2 ps-1 fs-5 text-black rounded-2"><?php echo $reporter_fullname ?></div>
                            <div class="text-black my-2 text-start fs-5"><b>ตำแหน่งผู้รายงาน : </b></div>
                            <div class="bg-white border border-black   my-2 ps-1 fs-5 text-black rounded-2"><?php echo $position ?></div>
                            <div class="row">
                                <div class="col text-black text-start fs-5"><b>วันที่รายงาน(ว/ด/ป) : </b></div>
                                <div class="col text-black text-start fs-5"><b>ปีงบประมาณ : </b></div>
                            </div>
                            <div class="row mx-1 ">
                                <div class="col bg-white border border-black  me-3 my-2 ps-1 fs-5 text-black rounded-2"><?php echo $thai_time ?></div>
                                <div class="col bg-white border border-black   my-2 ps-1 fs-5 text-black rounded-2"><?php echo $number ?></div>
                            </div>

                            <div class="text-black text-start fs-5"><b>ห้องที่รายงาน :</b></div>
                            <div class="bg-white border border-black   my-2 ps-1 fs-5 text-black rounded-2"><?php echo $room ?></div>

                        </div>
                        <!--RRRRR-->
                        <!-- <div class="col ps-2 my-1 ">
                        <div class="bg-white border border-black   my-2 ps-1 fs-5 text-black"><?php echo $reporter_fullname ?></div>
                        <div class="bg-white border border-black   my-2 ps-1 fs-5 text-black"><?php echo $position ?></div>
                        <div class="bg-white border border-black   my-2 ps-1 fs-5 text-black"><?php echo $thai_time ?></div>
                        <div class="bg-white border border-black   my-2 ps-1 fs-5 text-black"><?php echo $room ?></div>
                    </div>-->

                    </div>
                    <div>


                    </div>
                </div>
                <!--Right-->
                <div class="col ">
                    <div class="bg-warning text-white text-start mb-2 rounded-3">
                        <h1 class="ms-3 mt-4"> Picture : </h1>
                    </div>
                    <img src="<?php echo $newname; ?>" class=" img-thumbnail rounded mx-auto d-block " style="width:100%; object-fit:cover;" alt="...">
                </div>
                <hr>

                <div class="row ms-2 me-3">
                    <div class="text-black fs-5"><b>รายละเอียด :</b></div>
                    <!--<div class="bg-white border border-black ps-1 fs-5 "><?php //echo $detail 
                                                                                ?></div>-->
                    <textarea readonly class="fs-5 rounded-3 w-100" rows="4"><?php echo htmlspecialchars($detail) ?></textarea>

                </div>


            </div>




        </div>
        <?php include("script.php") ?>


</body>

</html>