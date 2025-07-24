<?php

require_once('connection.php');

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

if (isset($_POST['date_search'])) {
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];

    $select_stmt = $db->prepare("SELECT `report_date` ,COUNT(`report_date`) AS count_report FROM `clean_report` WHERE `report_date` BETWEEN :d_start AND :d_end GROUP BY `report_date`");
    $select_stmt->bindParam(':d_start', $date_start);
    $select_stmt->bindParam(':d_end', $date_end);
    $select_stmt->execute();
    $report_d = [];
    $report_count = [];

    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
        $timestamp = strtotime($row['report_date']);
        $thai_time = date("d/m/", $timestamp) . (date("Y", $timestamp) + 543);

        $report_d[] = '"' . $thai_time . '"';
        $report_count[] = $row['count_report'];
    }
} else {
    $current_month = date('m');
    $current_year = date('Y');

    $sql = "SELECT `report_date`,COUNT(`report_date`) AS count_report  FROM `clean_report` WHERE MONTH(`report_date`) = :current_month AND YEAR(`report_date`)= :current_year GROUP BY `report_date`";
    $select_stmt = $db->prepare($sql);
    $select_stmt->bindParam(':current_month', $current_month);
    $select_stmt->bindParam(':current_year', $current_year);
    $select_stmt->execute();
    $report_d = [];
    $report_count = [];


    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
        $timestamp = strtotime($row['report_date']);
        $thai_time = date("d/m/", $timestamp) . (date("Y", $timestamp) + 543);

        $report_d[] = '"' . $thai_time . '"';
        $report_count[] = $row['count_report'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php") ?>
    <title>chart</title>
</head>
<style>
    .backchart {
        /* width: 1200px; */
        width: flex;
        padding-bottom: 36px;

    }

    .chart {
        width: 100%;
        height: auto;
    }
</style>

<body class="bg-light">
    <!-- Side Bar -->
    <div class="d-flex">

        <nav class="bg-primary text-light p-3 vh-100" style="width: 280px; position:fixed;">
            <a href="chart.php" class="d-flex align-items-center mb-4 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" aria-hidden="true">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4"><b>แบบฟอร์มคำร้องขอทำความสะอาดพื้นที่ </b></span>
            </a>
            <hr>
            <a href="manage.php" class="btn btn-warning w-100 mb-2 shadow rounded">Manage User & Room</a>
            <a href="chart.php" class="btn btn-dark w-100 mb-2 shadow rounded">Chart</a>
            <!-- <a href="admin.php?logout='1'" class="btn btn-danger w-100">Logout</a> -->
            <button type="button" class="btn btn-danger w-100 mb-2 shadow rounded" data-bs-toggle="modal" data-bs-target="#Logout">
                Logout
            </button>
        </nav>
        <?php include('./modal-create-user.php') ?>
        <?php include('./modal-create-room.php') ?>
        <?php include('./modal-logout.php') ?>

        <div class="container bg-light rounded-3" style="margin-left:280px;">

            <header class="d-flex flex-warp justify-content-center py-3 mb-4 border-bottom ">
                <a href=""
                    class="d-flex align-item-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                    <svg
                        class="bi me-2" width="40" height="32" aria-hidden="true">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                    <div class="text-primary ">
                        <h1><b>สถิติการส่งรายงาน</b></h1>
                        
                    </div>
                    <div class="mt-3 " style="margin-left: 90px;">
                        <form action="">
                            <span class="me-1"><b>ค้นหาช่วงเวลา ตั้งแต่: </b></span>
                            <input type="date" name="date_start" class="me-1" required>
                            <span class="me-1"><b>จนถึง</b></span>
                            <input type="date" name="date_end" class="me-2" required>
                            <input type="submit" name="date_search" class="btn btn-success px-4 shadow rounded" value="Search">
                        </form>
                    </div>
                    
                    <a href="admin.php" class="col-md-1 me-2 mt-3 align-item-end btn btn-primary shadow rounded">
                        <b>Back</b></a>
                    </a>
                
                
                
            </header>
            
            <div class="backchart">
                <canvas id="chart"></canvas>
            </div>
        </div>




        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            Chart.defaults.font.size = 16;
            const ctx = document.getElementById('chart');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [<?php echo implode(",", $report_d) ?>],
                    datasets: [{
                        label: 'จำนวนรายงานในแต่ละวัน',
                        data: [<?php echo implode(",", $report_count) ?>],
                        fill: true, //false,
                        borderColor: 'rgb(255, 0, 0)',
                        tension: 0.1,
                        //borderWidth: 1

                    }]
                },
                options: {
                    plugin: {
                        legend: {
                            labels: {
                                font: {
                                    size: 50
                                }
                            },
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        <?php include("script.php") ?>
</body>

</html>