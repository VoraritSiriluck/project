<?php

require_once('connection.php');

if (isset($_POST['btn-updateuser'])) {
    $user_id = $_POST['user_id'];
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];

    
    try {
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
                $UpdateUserMsg = "Update User Succesfully...";
                header("Location: manage.php?status=success&messageUP=" . urlencode($UpdateUserMsg));
                exit();
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
