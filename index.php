<?php
require_once('connection.php');

if (isset($_GET['messageER'])) {
    $errorMsg = $_GET['messageER'];
} else {
}

if (isset($_GET['messageIS'])) {
    $insertMsg = $_GET['messageIS'];
} else {
}

try {
    $stmt = $db->prepare("SELECT id, room_name FROM room ORDER BY room_name ASC");
    $stmt->execute();
    $room = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("ดึงข้อมูลห้องล้มเหลว: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php") ?>
    <title>Report System</title>
</head>

<style>
    .body {
        background-image: url("image/pngtree-abstract-watercolor-background-with-pastel-colors-like-light-blue-and-pink-image_16394760.jpg");
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        background-size: cover;
    }
</style>


<body class="bg-primary bg-opacity-10">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row g-0 shadow rounded overflow-hidden">
                    <!-- ซ้าย: รูปภาพ -->
                    <div class="col-md-6 bg-white d-flex align-items-center justify-content-center p-4">
                        <img src="image/logo_osit.png" class="img-fluid rounded" alt="ตัวอย่างภาพ">
                    </div>

                    <!-- ขวา: ฟอร์ม -->
                    <div class="col-md-6 bg-primary text-white p-4">
                        <h5 class="mb-4">ฟอร์มแจ้งปัญหา / รายงาน</h5>
                        <?php
                        if (isset($errorMsg)) {
                        ?>
                            <div class="alert alert-danger">
                                <strong>ผิดพลาด <?php echo $errorMsg ?></strong>
                            </div>
                        <?php } ?>


                        <?php
                        if (isset($insertMsg)) {
                        ?>
                            <div class="alert alert-success">
                                <strong><?php echo $insertMsg ?></strong>
                            </div>
                        <?php } ?>
                        <form method="POST" class="" enctype="multipart/form-data" action="insert-data.php">



                            <!-- ชื่อ -->
                            <div class="mb-3">
                                <label for="name" class="form-label">ชื่อ</label>
                                <select name="reporter_name" id="reporter_name" class="form-select">
                                    <option value="">--กรุณาระบุชื่อผู้รายงาน--</option>

                                </select>
                            </div>

                            <!-- ฝ่าย -->
                            <div class="mb-3">
                                <label for="department" class="form-label">ฝ่าย</label>
                                <select name="position" class="form-select" required>
                                    <option value="">--กรุณาระบุฝ่าย--</option>
                                    <option value="ฝ่ายการบริหารและการจัดการ">ฝ่ายการบริหารและการจัดการ</option>
                                    <option value="ฝ่ายบริการเครื่องมือวิจัยทางวิทยาศาสตร์">ฝ่ายบริการเครื่องมือวิจัยทางวิทยาศาสตร์</option>
                                    <option value="ฝ่ายซ่อมบำรุงรักษาและพัฒนาเครื่องมือ">ฝ่ายซ่อมบำรุงรักษาและพัฒนาเครื่องมือ</option>
                                </select>
                            </div>

                            <!-- วันที่ -->
                            <div class="mb-3">
                                <label for="date" class="form-label">วันที่</label>
                                <input type="date" class="form-control" name="report_date" max="<?php echo date("Y-m-d"); ?>" required>
                            </div>

                            <!-- ห้อง -->
                            <div class="mb-3">
                                <label for="room" class="form-label">ห้อง</label>
                                <select name="room" id="room" class="form-select" required>
                                    <option value="">--กรุณาระบุห้อง--</option>
                                    <?php foreach ($room as $room): ?>
                                        <option value="<?= htmlspecialchars($room['room_name']) ?>">
                                            <?= htmlspecialchars($room['room_name']) ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <input type="text" class="form-control  mt-2" id="other_room" name="other_room" placeholder="กรุณาระบุห้อง" disabled>
                            </div>

                            <!-- รายละเอียด -->
                            <div class="mb-3">
                                <label for="details" class="form-label">รายละเอียด</label>
                                <textarea class="form-control" placeholder="detail" name="detail" style="height: 100px" required></textarea>
                            </div>

                            <!-- Upload รูปภาพ -->
                            <div class="mb-4">
                                <label for="image" class="form-label">อัปโหลดรูปภาพ</label>
                                <input type="file" name="img_file" required class="form-control mt-2" accept="image/jpeg, image/png, image/jpg"> <br>
                                <span color="red" class="text mb-2 text-danger"><b>*อัพโหลดได้เฉพาะ .jpeg , .jpg , .png </b></span>
                            </div>

                            <!-- ปุ่มส่ง -->
                            <div class="d-grid">
                                <input type="submit" class="btn btn-light rounded-pill" name="btn_report" value="ส่งรายงาน >>">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="container bg-primary pb-4 mb-0">

        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href=""
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <svg
                    class="bi me-2" width="40" height="32" aria-hidden="true">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4 text-light"><b>Cleaning System Report</b>
                </span>
            </a>

        </header>


        <form method="POST" class="row bg-secondary p-4 m-4 rounded-5" enctype="multipart/form-data" action="insert-data.php">

            <div class="row-cols-2 mb-1">
                <label for="" class="form-label text-white"><b>กรุณากรอกชื่อผู้รายงาน : </b></label>
                <select name="reporter_name" id="reporter_name" class="form-select">
                    <option value="">--กรุณาระบุชื่อผู้รายงาน--</option>

                </select>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="" class="form-label text-white"><b>ระบุฝ่าย : </b></label>
                    <select name="position" class="form-select" required>
                        <option value="">--กรุณาระบุฝ่าย--</option>
                        <option value="ฝ่ายการบริหารและการจัดการ">ฝ่ายการบริหารและการจัดการ</option>
                        <option value="ฝ่ายบริการเครื่องมือวิจัยทางวิทยาศาสตร์">ฝ่ายบริการเครื่องมือวิจัยทางวิทยาศาสตร์</option>
                        <option value="ฝ่ายซ่อมบำรุงรักษาและพัฒนาเครื่องมือ">ฝ่ายซ่อมบำรุงรักษาและพัฒนาเครื่องมือ</option>
                    </select>

                </div>
                <div class="col-md-6">
                    <label for="" class="form-label text-white"><b>วันที่แจ้ง : </b></label>
                    <input type="date" class="form-control" name="report_date" max="<?php echo date("Y-m-d"); ?>" required>
                </div>
            </div>
            <div class="row-cols-2 mb-3">
                <label for="" class="form-label text-white"><b>ห้องที่รายงาน : </b></label>
                <select name="room" id="room" class="form-select" required>
                    <option value="">--กรุณาระบุห้อง--</option>
                    
                </select>
                <input type="text" class="form-control  mt-2" id="other_room" name="other_room" placeholder="กรุณาระบุห้อง" disabled>

            </div>

            <div class="">
                <label for="" class="form-label text-white"><b>รายละเอียด : </b></label>
                <textarea class="form-control" placeholder="detail" name="detail" style="height: 100px" required></textarea>

            </div>
            <div>
                <label for="" class="form-label text-white mt-2"><b>อัพโหลดรูปภาพ : </b></label>
                <input type="file" name="img_file" required class="form-control mt-2" accept="image/jpeg, image/png, image/jpg"> <br>
                <span color="red" class="text mb-2 text-danger"><b>*อัพโหลดได้เฉพาะ .jpeg , .jpg , .png </b></span>


            </div>


            <div class="row  mb-3 mt-3 ">
                <div class="col w-1">
                    <input type="submit" class=" btn btn-success fs-5" name="btn_report" value="Report >>">
                </div>


            </div>

    </div>
    </div>

    </form>



    </div> -->

    <?php include("script.php") ?>
    <script>
        fetch('https://osit.psu.ac.th/api/mishr/get_all_users.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    token: '3gmA05aIR0ZTDfHFvyvAkyEtWY2rFiEEGeQBr0OW1P5imvjlfgjy1u1M7z2TQmKA'
                })
            })

            .then(response => response.json())
            .then(data => {
                const select = document.getElementById("reporter_name");
                data.data.forEach(person => {
                    const option = document.createElement("option");
                    option.value = `${person.pn_username}|${person.pn_name} ${person.pn_surname}`;
                    option.textContent = `${person.pn_fname}${person.pn_name} ${person.pn_surname}`;
                    select.appendChild(option);
                })
            })

            .catch(error => {
                console.error('เกิดข้อผิดพลาดในการโหลดชื่อ:', error);
                const select = document.getElementById('reporter_name');
                select.innerHTML = '<option value="">--ไม่สามารถโหลดชื่อได้--</option>';
            });

        const room = document.getElementById('room');
        const otherRoom = document.getElementById('other_room');

        room.addEventListener('change', function() {
            const selectedValue = this.value;
            console.log('selectedValue', selectedValue);

            if (selectedValue === 'อื่นๆ') {
                otherRoom.disabled = false;
                otherRoom.required = true;
            } else {

                otherRoom.disabled = true;
                otherRoom.required = false;
                otherRoom.value = '';
            }
        })
    </script>
</body>

</html>