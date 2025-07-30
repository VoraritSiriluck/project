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

    <script>

    </script>

</head>

<style>
    #myTable thead th {
        color: black !important;
    }

    @media (max-width: 767.98px) {
        nav {
            
            width: 1px !important;
        }

        .main-content {
            margin-left:25px !important;
        }

        h1.fw-bold {
            font-size: 1.3rem;
        }

        h5.text-secondary {
            font-size: 1rem;
        }

        .btn{
            padding: 0.3rem 0.8rem;
            font-size: 0.9rem;
        }

        .table-responsive {
            overflow-x: auto;
        }
    }
</style>

<body class="">
    <nav class="bg-primary text-light p-3 vh-100 shadow border-end border-info d-md-block" style="width: 50px; position:fixed;">


        <form action="" method="POST" id="search" class="mb-4">
            <div class="mb-2">
                <select name="search_category" id="searchCategory" class="form-select" required style="display: none;">
                    <option value="">เลือกหมวดหมู่ค้นหา</option>
                    <option value="report_date">ค้นหาตามวันที่</option>
                    <option value="reporter_name">ค้นหาตามชื่อ</option>
                    <option value="position">ค้นหาตามตำแหน่ง</option>
                    <option value="roomsearch">ค้นหาตามห้อง</option>
                </select>
            </div>



        </form>

    </nav>
    <div class="">

        <div class="main-content" style="margin-left:50px;">
            <div class="container-fluid px-3">
                <div class="row align-items-center justify-content-between mb-4 fs-3 ">
                    <div class="col mt-3">
                        <h1 class="fw-bold text-primary"><b>ประวัติการรายงาน (ของนักวิทย์)</b></h1>
                        <h5 class="text-secondary">ตรวจสอบรายงาน</h5>
                    </div>

                    <div class="col-auto">
                        <a href="index.php" class="btn btn-primary shadow rounded px-4 py-2">
                            <b>Back</b></a>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-light" id="myTable">
                                        <thead class="table-light text-dark">
                                            <tr>
                                                <th>Fiscal Year</th>
                                                <th>Date (D/M/Y)</th>
                                                <th>Room</th>
                                                <th>Status</th>
                                                <!-- <th>Delete</th> -->
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $select_stmt = null;
                                            $sql = "SELECT * FROM clean_report ORDER BY report_date DESC";
                                            $select_stmt = $db->prepare($sql);
                                            $select_stmt->execute();

                                            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $original_date = $row['report_date'];
                                                $timestamp = strtotime($original_date);
                                                $thai_time = date("d/m/", $timestamp) . (date("Y", $timestamp) + 543);

                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $row["number"] . '/' . $row["fiscal_year"] ?></td>
                                                    <td data-order="<?php echo $row["report_date"]; ?>">
                                                        <?php echo $thai_time ?></td>


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

                                                    <!-- <td><a href="admin-delete.php?delete_id=<?php //echo $row['id']; 
                                                                                                    ?>" class="btn btn-outline-danger" onclick="return confirm('คุณต้องการจะลบข้อมูลนี้ใช่หรือไม่?')">Delete</a></td> -->
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>



        </div>
    </div>

    <?php include("script.php") ?>
    <script>
        //เรียกใช้ Datatable  |id table ต้องตรงกับ #
        $(document).ready(function() {
            const table = $('#myTable').DataTable({
                "order": [
                    [0, "desc"]
                ],

            });
        });
    </script>
</body>



</html>