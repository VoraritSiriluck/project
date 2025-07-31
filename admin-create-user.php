<?php

require('./function.php');
require_once('connection.php');
require_once('function-log.php');
session_start();

if (isset($_REQUEST['btn-createuser'])) {
    $new_username = trim($_POST['new_username']);
    $new_password = $_POST['new_password'];

    if (empty($new_username)) {
        redirectMessage('error', 'กรุณาระบุชื่อผู้ใช้ที่ต้องการ', 'user');
    } else if (empty($new_password)) {
        redirectMessage('error', 'กรุณาระบุรหัสที่ต้องการ', 'user');
    } else {
        try {
            $check_stmt = $db->prepare("SELECT username FROM user WHERE username = :username");
            $check_stmt->bindParam(':username', $new_username);
            $check_stmt->execute();

            if ($check_stmt->rowCount() > 0) {
                redirectMessage('error', 'ชื่อผู้ใช้นี้มีอยู่แล้ว', 'user');
            } else {
                //
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $Insert_user = "INSERT INTO user(`username`,`password`) VALUES (:new_user, :new_password)";
                $create_stmt = $db->prepare($Insert_user);
                $create_stmt->bindParam(':new_user', $new_username);
                $create_stmt->bindParam(':new_password', $hashed_password);

                if ($create_stmt->execute()) {
                    $username = $_SESSION['username'];
                    $message = "เพิ่ม username ชื่อ {$new_username}";
                    active_log($db,$username,$message);
                    redirectMessage('success', 'สร้างผู้ใช้สำเร็จแล้ว');
                } else {
                    redirectMessage('error', 'ไม่สามารถเพิ่มข้อมูลได้');
                }
            }
        } catch (PDOException $e) {
            redirectMessage('error', 'เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล', 'user');
        };
    }
};
