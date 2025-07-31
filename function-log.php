<?php

function active_log($db, $username, $action)
{
    try {
        $stmt = $db->prepare("INSERT INTO activity_log (username, action) VALUES (:username, :action)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':action', $action);
        $stmt->execute();
    } catch (PDOException $e) {
        error_log("Activity Log Error: " . $e->getMessage());
    }
}
