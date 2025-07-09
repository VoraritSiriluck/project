<?php

require_once('connection.php');

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
        width: 1200px;
        padding-bottom: 36px;

    }

    .chart {
        width: 100%;
        height: auto;
    }
</style>

<body class="bg-dark">
<!-- Side Bar -->
<div class="d-flex">
        
        <nav class="bg-dark text-light p-3 vh-100" style="width: 280px; position:fixed;">
            <a href="chart.php" class="d-flex align-items-center mb-4 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" aria-hidden="true">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4"><b>Chart </b></span>
            </a>
            
            <hr>
             <button type="button" class="btn btn-warning w-100 mb-2 " data-bs-toggle="modal" data-bs-target="#CreateUser">
                Create User
            </button>

            <button type="button" class="btn btn-light w-100 mb-2" data-bs-toggle="modal" data-bs-target="#CreateRoom">
                Create Room
            </button>

            

            <a href="chart.php" class="btn btn-primary w-100 mb-2">Chart</a>
            <!-- <a href="admin.php?logout='1'" class="btn btn-danger w-100">Logout</a> -->
              <button type="button" class="btn btn-danger w-100 mb-2" data-bs-toggle="modal" data-bs-target="#Logout">
                Logout
            </button>
        </nav>

        <!-- Modal -->
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


    <div class="container bg-light rounded-3" style="margin-left:280px;">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom ">
            <a href=""
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none ">
                <svg
                    class="bi me-2" width="40" height="32" aria-hidden="true">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                
                <form action="" method="POST" class="" style="margin-left: 400px; margin-top:15px">
                    <span class="me-1"><b>ค้นหาช่วงเวลา ตั้งแต่: </b></span>
                    <input type="date" name="date_start" class="me-1" required>
                    <span class="me-1"><b>จนถึง</b></span>
                    <input type="date" name="date_end" class="me-2" required>
                    <input type="submit" name="date_search" class=" btn btn-success px-4" value="Search">
                </form>

                <a href="javascript:window.history.back()" class="col-md-1 me-5   mt-3 align-items-end btn btn-dark"><b>Back</b></a>
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