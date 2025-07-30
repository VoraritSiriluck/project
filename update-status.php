<?php

require_once('connection.php');
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reporter_id'], $_POST['status'])) {
    $id = $_POST['reporter_id'];
    $status = $_POST['status'];
    $cancel_reason = isset($_POST['cancel_reason']) ? trim($_POST['cancel_reason']) : null;

    try {
        $stmt_old = $db->prepare("SELECT status FROM clean_report WHERE id = :id");
        $stmt_old->execute([':id' => $id]);
        $old = $stmt_old->fetch(PDO::FETCH_ASSOC);
        $old_status = $old['status'];


        if ($status === 'cancel') {
            $stmt = $db->prepare("UPDATE clean_report SET status = :status, cancel_reason = :reason WHERE id = :id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':reason', $cancel_reason);
        } else {
            $stmt = $db->prepare("UPDATE clean_report SET status = :status WHERE id = :id");
            $stmt->bindParam(':status', $status);
        }

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $log_stmt = $db->prepare("INSERT INTO activity_log (username, action, report_id, status_before, status_after)
                                    VALUE (:username, :action, :report_id, :before, :after)");
        $log_stmt->execute([
            ':username' => $_SESSION['username'],
            ':action' => 'อัปเดตสถานะรายงาน',
            ':report_id' =>$id,
            ':before' =>$old_status,
            ':after' =>$status

        ]);

        header("Location: inspect.php?check_id=" . urlencode($id) . "&message=Status+Update");
        exit;
    } catch (PDOException $e) {
        echo 'error' . $e->getMessage();
    }
}
