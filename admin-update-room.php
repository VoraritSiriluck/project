<?php
require('./function.php');
require_once('connection.php');

if (isset($_POST['btn-updateroom'])) {
    $room_id = $_POST['room_id'];
    $new_roomname = $_POST['room_name'];

    try {
        $check_stmt = $db->prepare("SELECT room_name FROM room WHERE room_name = :room_name AND id != :id");
        $check_stmt->bindParam(':room_name', $new_roomname);
        $check_stmt->bindParam(':id',$room_id);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            $RoomAlready = "ชื่อห้องนี้มีอยู่แล้ว";
            header("Location: manage.php?status=error&messageER=" . urlencode($RoomAlready));
            exit();
        } else {
            $sql = "UPDATE room SET room_name = :room_name WHERE id = :id";
            $stmt = $db->prepare($sql);
            $param = array(
                ':room_name' => $new_roomname,
                ':id' => $room_id,
            );
            if ($stmt->execute($param)) {
                $UpdateRoomMsg = "Update Room Successfully...";
                header("Location: manage.php?status=success&messageUP=" . urlencode($UpdateRoomMsg));
                exit();
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
