<?php
session_start();

require_once('connection.php');
require_once('function-log.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $stmt = $db->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['username'];
        header("Location: admin.php");
        active_log($db,$_SESSION['username'],"เข้าสู่ระบบ");
        exit;
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }


    /*if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: admin.php");
        exit;
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }*/
}


// ถ้ายังไม่ login ให้แสดงฟอร์ม login

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php") ?>
    <title>Admin Login</title>

</head>



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
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4 text-light">Cleaning Report Check System</h1>
                        </div>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger mt-2">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        <hr>
                        <form method="POST" class="user">
                            <!-- User -->
                            <div class="form-group mb-3">
                                <input type="text" class="form-control form-control-user mb-2" name="username" aria-describedby="emailHelp" placeholder="Username">
                            </div>
                            <!-- Password -->
                            <div class="form-group mb-3">
                                <input type="password" class="form-control form-control-user mb-2" name="password" placeholder="Password">
                            </div>
                            <hr>
                            <button class="btn btn-success my-3 fs-5 ">Log-In>></button><br>
                        </form>
                        <div class="text-end mt-3">
                            <a class="icon-link icon-link-hover link-underline-secondary text-body-secondary" href="index.php" style="text-decoration: none;"><b>back</b>
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <!--<form method="POST">
            <div class="row">
                <h5>
                    <div class="col">
                        <label for="" class="form-label text-white"><b>Username :</b></label>
                        <input type="text" name="username" class="rounded-3" placeholder="ชื่อผู้ใช้" >

                    </div>
                    <div class="">
                        <label for="" class="form-label text-white"><b>Password : </b></label>
                        <input type="password" name="password" class="rounded-3" placeholder="รหัสผ่าน" required>
                    </div>
                </h5>
            </div>
            <input type="submit" class="btn btn-success my-3 fs-4  " value="Log-In">

        </form>-->

    </div>
    <?php include("script.php") ?>
</body>

</html>