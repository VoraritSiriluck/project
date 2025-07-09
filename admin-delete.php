<?php
require_once('connection.php');

if (isset($_REQUEST["delete_id"])) {
    /** ดึงข้อมูลไว้ทำไม ???? */
    $id = $_REQUEST['delete_id'];
    $select_stmt = $db->prepare("SELECT * FROM clean_report WHERE id=:id");
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);


    $delete_stmt = $db->prepare('DELETE FROM clean_report WHERE id= :id');
    $delete_stmt->bindParam(":id", $id);
    $delete_stmt->execute();
    //
    if ($delete_stmt->execute()) {
        $Delete = "";
        header('Location: admin.php?deleteat_id=' . $Delete);
        die();
    }
    //
}
