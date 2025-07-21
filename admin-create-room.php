<?php
require('./function.php');
require_once("connection.php");

if (isset($_REQUEST['btn-createroom'])) {
    $new_room = $_POST['new_room'];

    if (empty($new_room)) {
        redirectMessage('error', 'กรุณาระบุชื่อห้องที่ต้องการจะเพิ่ม', 'room');
    } else {
        try {
            $check_stmt = $db->prepare("SELECT room_name FROM room WHERE room_name = :room_name");
            $check_stmt->bindParam(':room_name', $new_room);
            $check_stmt->execute();
            if ($check_stmt->rowCount() > 0) {
                redirectMessage('error', 'ห้องนี้ถูกเพิ่มอยู่แล้ว', 'room');
            } else {
                $Insert_room = "INSERT INTO room(`room_name`) VALUE (:new_room)";
                $create_room = $db->prepare($Insert_room);
                $create_room->bindParam(":new_room", $new_room);
                if ($create_room->execute()) {
                    redirectMessage('success', 'เพิ่มห้องสำเร็จเสร็จสิ้น', 'room');
                } else {
                    redirectMessage('error', 'ไม่สามารถเพิ่มข้อมูลได้', 'room');
                }
            }
        } catch (PDOException $e) {

            redirectMessage('error', 'เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล');
        }
    }
}
