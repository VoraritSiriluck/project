<?php

require_once('connection.php');
require_once('function-log.php');
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reporter_id'], $_POST['status'])) {
    $id = $_POST['reporter_id'];
    $status = $_POST['status'];
    $cancel_reason = isset($_POST['cancel_reason']) ? trim($_POST['cancel_reason']) : null;

    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'unknown';
    $now = date("Y-m-d H:i:s");

    try {
        if ($status === 'cancel') {
            $stmt = $db->prepare("UPDATE clean_report 
            SET status = :status, 
                cancel_reason = :reason, 
                last_user_edit = :user, 
                last_time_edit = :time 
            WHERE id = :id");
            
            $stmt->bindParam(':reason', $cancel_reason);
        } else {
            $stmt = $db->prepare("UPDATE clean_report SET status = :status, 
            last_user_edit = :user, 
            last_time_edit = :time 
            WHERE id = :id");
            
        }

        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user',$username);
        $stmt->bindParam(':time',$now);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $message = "แก้ไขสถานะ report ID {$id} เป็น {$status}";
        active_log($db, $username, $message);

        header("Location: inspect.php?check_id=" . urlencode($id) . "&message=Status+Update");
        exit;
    } catch (PDOException $e) {
        echo 'error' . $e->getMessage();
    }
}
