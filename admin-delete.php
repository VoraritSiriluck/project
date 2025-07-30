<?php
require_once('connection.php');

if (isset($_REQUEST["delete_id"])) {
    $id = $_REQUEST['delete_id'];

    $select_stmt = $db->prepare("SELECT image_name FROM clean_report WHERE id = :id");
    $select_stmt->bindParam(":id",$id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $file_path = 'upload/' . $row['image'];

        if(file_exists($file_path)){
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

    
    $delete_stmt = $db->prepare('DELETE FROM user WHERE id= :id');
    $delete_stmt->bindParam(":id", $id);
    //
    if ($delete_stmt->execute()) {
        header('Location: manage.php?messageUP=' . urlencode('Delete User Success'));
        die();
    }
    //
}

if (isset($_REQUEST["deleteroom_id"])) {
    $id = $_REQUEST['deleteroom_id'];

    
    $delete_stmt = $db->prepare('DELETE FROM room WHERE id= :id');
    $delete_stmt->bindParam(":id", $id);
    //
    if ($delete_stmt->execute()) {
        header('Location: manage.php?messageUP=' . urlencode('Delete Room Success'));
        die();
    }
    //
}


