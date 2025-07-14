<?php
require_once('connection.php');

//
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location: login.php');
}

if (isset($_GET['deleteat_id'])) {
    $row = $_GET['deleteat_id'];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php") ?>
    <title>Report</title>

</head>

<style>
    #myTable thead th {
        color: black !important;
    }
</style>

<body class="bg-secondary">
    <!-- Side Bar -->
    <div class="d-flex">
        <nav class="bg-dark text-light p-3 vh-100" style="width: 280px; position:fixed;">
            <a href="admin.php" class="d-flex align-items-center mb-4 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" aria-hidden="true">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4"><b>แบบฟอร์มคำร้องขอทำความสะอาดพื้นที่</b></span>
            </a>
            <hr>
            <form action="" method="POST" id="search" class="mb-4">
                <div class="mb-2">
                    <select name="search_category" id="searchCategory" class="form-select" required>
                        <option value="">เลือกหมวดหมู่ค้นหา</option>
                        <option value="report_date">ค้นหาตามวันที่</option>
                        <option value="reporter_name">ค้นหาตามชื่อ</option>
                        <option value="position">ค้นหาตามตำแหน่ง</option>
                        <option value="room">ค้นหาตามห้อง</option>
                    </select>
                </div>
                <div class="mb-2" id="textWrapper" style="display: none;">
                    <input type="text" name="search_input_text" class="form-control">
                </div>
                <div class="mb-2" id="dateWrapper" style="display: none;">
                    <input type="date" name="search_input_date" class="form-control">
                </div>
                <input type="submit" name="search" class="btn btn-success w-100" value="Search">
            </form>
            <hr>
            <button type="button" class="btn btn-warning w-100 mb-2 " data-bs-toggle="modal" data-bs-target="#CreateUser">
                Create User
            </button>
            <button type="button" class="btn btn-light w-100 mb-2" data-bs-toggle="modal" data-bs-target="#CreateRoom">
                Create Room
            </button>

            <a href="chart.php" class="btn btn-primary w-100 mb-2">Chart</a>

            <button type="button" class="btn btn-danger w-100 mb-2" data-bs-toggle="modal" data-bs-target="#Logout">
                Logout
            </button>
            
            <!-- <button class="btn btn=danger w-100" onclick="logoutconfirm()">Logout</button>
            <script>
                function logoutconfirm() {
                    if(confirm('คุณต้องการจะออกจากระบบใช่หรือไม่')) {
                        window.location.href = "admin.php?logout='1'"
                    }
                }
            </script>

             <a href="admin.php?logout='1'" 
            class="btn btn-danger w-100"
            onclick="return confirm('คุณต้องการจะออกจากระบบใช่หรือไม่')"
            >
            Logout</a> -->
        </nav>
       



        <?php include('./modal-create-user.php')?>
        <?php include('./modal-create-room.php')?>
        <?php include('./modal-logout.php')?>

        <div class="flex-grow-1 p-4" style="margin-left: 280px;">

            <span class="text-light fs-3"><b>ประวัติการรายงาน</b></span>
            <table class="table table-striped table-bordered table-hover text-light" id="myTable">
                <thead>
                    <tr>
                        <th>Fiscal Year</th>
                        <th>Date (D/M/Y)</th>
                        <th>Reporter Name</th>
                        <th>Department</th>
                        <th>Room</th>
                        <th>Status</th>
                        <th>Check</th>
                        <th>Delete</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $select_stmt = null;

                    if (isset($_POST['search'])) {
                        $category = $_POST['search_category'];

                        if ($category == 'report_date') {
                            $value = $_POST['search_input_date'];
                            $sql = "SELECT * FROM clean_report WHERE report_date = :value ORDER BY report_date DESC";
                            $select_stmt = $db->prepare($sql);
                            $select_stmt->bindParam(':value', $value);
                        } else {
                            $value = "%" . $_POST['search_input_text'] . "%";
                            $sql = "SELECT * FROM clean_report WHERE $category LIKE :value ORDER BY report_date DESC";
                            $select_stmt = $db->prepare($sql);
                            $select_stmt->bindParam(':value', $value);
                        }
                    } else {
                        $sql = "SELECT * FROM clean_report ORDER BY report_date DESC";
                        $select_stmt = $db->prepare($sql);
                    }
                    $select_stmt->execute();

                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $original_date = $row['report_date'];
                        $timestamp = strtotime($original_date);
                        $thai_time = date("d/m/", $timestamp) . (date("Y", $timestamp) + 543);
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $row["number"] ?></td>
                            <td data-order="<?php echo $row["report_date"]; ?>">
                                <?php echo $thai_time ?></td>
                            
                            <td><?php echo $row["reporter_fullname"] ?></td>
                            <td><?php echo $row["position"] ?></td>
                            <td><?php echo $row["room"] ?></td>
                            <td>
                                <?php
                                $status = $row['status'];
                                $badge_status = "";
                                $status_text = "";

                                switch ($status) {
                                    case "waiting":
                                        $badge_status = "badge text-bg-dark";
                                        $status_text = "รอตรวจสอบ";
                                        break;
                                    case "in_progress":
                                        $badge_status = "badge text-bg-warning";
                                        $status_text = "กำลังดำเนินการ";
                                        break;
                                    case "done";
                                        $badge_status = "badge text-bg-success";
                                        $status_text = "ดำเนินการเสร็จสิ้น";
                                        break;
                                    case "cancel":
                                        $badge_status = "badge text-bg-danger";
                                        $status_text = "ยกเลิก";
                                        break;
                                    default:
                                        $badge_status = "badge text-bg-dark";
                                        $status_text = "รอตรวจสอบ";
                                        break;
                                }
                                ?>
                                <span class="<?php echo $badge_status; ?>"><?php echo $status_text ?></span>
                            </td>
                            <td><a href="inspect.php?check_id=<?php echo $row["id"]; ?>" class="btn btn-success">Check</a></td>
                            <td><a href="admin-delete.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('คุณต้องการจะลบข้อมูลนี้ใช่หรือไม่?')">Delete</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php include("script.php") ?>
        <script>

            // searchCategory
            const category = document.getElementById("searchCategory");
            const textInput = document.getElementById("textWrapper");
            const dateInput = document.getElementById("dateWrapper");
            // serach select
            category.addEventListener('change', function() {
                const value = this.value;
                if (value === 'report_date') {
                    dateInput.style.display = 'block';
                    textInput.style.display = 'none';
                } else {
                    dateInput.style.display = 'none';
                    textInput.style.display = 'block';
                }
            });

            //เรียกใช้ Datatable  |id table ต้องตรงกับ #
            $(document).ready(function() {
                $('#myTable').DataTable({
                    "order": [
                        [0, "desc"]
                    ]
                });
            });

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
        </script>
</body>



</html>