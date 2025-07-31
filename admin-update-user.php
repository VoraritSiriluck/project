<?php

require_once('connection.php');
require_once('function-log.php');
session_start();

if (isset($_POST['btn-updateuser'])) {
    $user_id = $_POST['user_id'];
    $new_username = trim($_POST['new_username']);
    $new_password = trim($_POST['new_password']);

    if(empty($new_password)){
        header("Location: manage.php?status=error&messageER=" . urlencode("กรุณาระบุรหัสผ่านใหม่"));
        exit();

    }

    
    try {
        $old_stmt = $db->prepare("SELECT username FROM user WHERE id =:id");
        $old_stmt->bindParam(':id', $user_id);
        $old_stmt->execute();
        $old_row = $old_stmt->fetch(PDO::FETCH_ASSOC);

        if (!$old_row) {
            header("Location: manage.php?status=error&messageER=" . urlencode("ไม่พบข้อมูล User เดิม"));
            exit();
        }

        $old_username = $old_row['username'];

        $check_stmt = $db->prepare("SELECT username FROM user WHERE username = :username AND id != :id");
        $check_stmt->bindParam(':username', $new_username);
        $check_stmt->bindParam(':id',$user_id);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            $UserAlready = "ชื่อผู้ใช้นี้มีอยู่แล้ว";
            header("Location: manage.php?status=error&messageER=" . urlencode($UserAlready));
            exit();
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $sql = "UPDATE user SET username = :username, password = :password WHERE id = :id";
            $stmt = $db->prepare($sql);
            $param = array(
                ':username' => $new_username,
                ':password' => $hashed_password,
                ':id' => $user_id,
            );
            if ($stmt->execute($param)) {
                $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'unknown';
                $message = "แก้ไข username และ password จาก {$old_username} เป็น {$new_username}";
                active_log($db,$username,$message);
                $UpdateUserMsg = "Update User Succesfully...";
                header("Location: manage.php?status=success&messageUP=" . urlencode($UpdateUserMsg));
                exit();
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
