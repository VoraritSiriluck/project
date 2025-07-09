<?php 

require_once('connection.php');

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reporter_id'], $_POST['status'])) {
    $id = $_POST['reporter_id'];
    $status = $_POST['status'];
    $cancel_reason = isset($_POST['cancel_reason']) ? trim($_POST['cancel_reason']) :null;

    try{
        if($status === 'cancel') {
            $stmt = $db->prepare("UPDATE clean_report SET status = :status, cancel_reason = :reason WHERE id = :id");
            $stmt->bindParam(':status' ,$status);
            $stmt->bindParam(':reason', $cancel_reason);
        }else{
            $stmt = $db->prepare("UPDATE clean_report SET status = :status WHERE id = :id");
        $stmt->bindParam(':status' ,$status);
        }
        
        $stmt->bindParam(':id',$id);
        $stmt->execute();

        header("Location: inspect.php?check_id=" . urlencode($id) . "&message=Status+Update");
        exit;

    }catch (PDOException $e){
        echo 'error' . $e->getMessage();
    }
}

?>
