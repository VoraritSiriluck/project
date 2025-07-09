<?php

require_once('connection.php');

if (isset($_REQUEST['btn-createuser'])) {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];

    if (empty($new_username)) {
        $errorMsg = "กรุณาระบุชื่อผู้ใช้ที่ต้องการ";
    } else if (empty($new_password)) {
        $errorMsg = "กรุณาระบุรหัสที่ต้องการ";
    } else {
        try {
            if(!isset($errorMsg)){
                $Insert_user = "INSERT INTO user(`username`,`password`) VALUES (:new_user, :new_password)";
                $create_stmt = $db->prepare($Insert_user);
                $create_stmt->bindParam(':new_user',$new_username);
                $create_stmt->bindParam(':new_password',$new_password);
                if($create_stmt->execute()){
                    $createMsg = "Create successfully...";
                    header("Location:register.php");
                    die();
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        };
    }
};

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php") ?>
    <title>Register</title>
</head>

<body>
    <div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Insert User
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Insert User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST">
                        <div class="modal-body">
                            <div class="row-4">
                                <div class="col">
                                    <label for="" class="form-label">Username :</label>
                                    <input type="text" class="form-control" name="new_username" required>

                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Password :</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="" class="btn btn-warning">Edit User</a>
                            <button type="submit" class="btn btn-success" name="btn-createuser" >Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <?php include("script.php") ?>
</body>

</html>