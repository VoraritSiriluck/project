<?php

require_once('connection.php');
require_once('function-log.php');
session_start();

if (isset($_REQUEST["delete_id"])) {
    $id = $_REQUEST['delete_id'];

    $select_stmt = $db->prepare("SELECT image_name FROM clean_report WHERE id = :id");
    $select_stmt->bindParam(":id", $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $file_path = 'upload/' . $row['image_name'];

        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }


    $delete_stmt = $db->prepare('DELETE FROM clean_report WHERE id= :id');
    $delete_stmt->bindParam(":id", $id);
    //
    if ($delete_stmt->execute()) {
        // $Delete = "";
        header('Location: admin.php?messageUP=' . urlencode('Delete Report Success'));
        die();
    }
    //
}

if (isset($_REQUEST["deleteuser_id"])) {
    $id = $_REQUEST['deleteuser_id'];

    $select_stmt = $db->prepare("SELECT username FROM user WHERE id =:id");
    $select_stmt->bindParam(":id", $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $delete_username = $row['username'];

        $delete_stmt = $db->prepare('DELETE FROM user WHERE id = :id');
        $delete_stmt->bindParam(":id", $id);
        if ($delete_stmt->execute()) {
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'unknown';
            $message = "ลบ username ชื่อ {$delete_username}";
            active_log($db, $username, $message);
            header('Location: manage.php?messageUP=' . urlencode('Delete User Success'));
            die();
        }
        //
    }
}

if (isset($_REQUEST["deleteroom_id"])) {
    $id = $_REQUEST['deleteroom_id'];

    $select_stmt = $db->prepare("SELECT room_name FROM room WHERE id = :id");
    $select_stmt->bindParam(":id", $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $delete_room = $row['room_name'];

        $delete_stmt = $db->prepare('DELETE FROM room WHERE id= :id');
        $delete_stmt->bindParam(":id", $id);
        if ($delete_stmt->execute()) {
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'unknown';
            $message = "ลบห้อง ชื่อ {$delete_room}";
            active_log($db, $username, $message);
            header('Location: manage.php?messageUP=' . urlencode('Delete Room Success'));
            die();
        }
    }



    //
}
