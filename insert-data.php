<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('connection.php');

function fix_orientation($img,$tmp_file){
    if(function_exists('exif_read_data')){
        $exif =@exif_read_data($tmp_file);
        if  ($exif && isset($exif['Orientation'])) {
            $orientation = $exif ['Orientation'];
            switch($orientation ) {
                case 3 :
                    $img = imagerotate($img, 180, 0);
                    break;
                case 6 :
                    $img = imagerotate($img, -90, 0);
                    break;
                case 8 : 
                    $img = imagerotate($img, 90, 0);
                    break;
                
            }
        }
    }
    return $img;
}


function resize_image($tmp_file, $dest_file, $max_resolution)
{

    $info = getimagesize($tmp_file);
    $mime = $info['mime'];


    if ($mime == 'image/jpeg') {
        $original_image = imagecreatefromjpeg($tmp_file);
        $original_image = fix_orientation($original_image,$tmp_file);
    } else if ($mime == 'image/png') {
        $original_image = imagecreatefrompng($tmp_file);
    } else {
        return false;
    }
    $original_width = imagesx($original_image);
    $original_height = imagesy($original_image);

    $ratio = $max_resolution / $original_width;
    $new_width = $max_resolution;
    $new_height = $original_height * $ratio;

    if ($new_height > $max_resolution) {
        $ratio = $max_resolution / $original_height;
        $new_height = $max_resolution;
        $new_width = $original_width * $ratio;
    }

    $new_image = imagecreatetruecolor($new_width, $new_height);

    if ($mime == 'image/png') {
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);
    }

    imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

    if ($mime == 'image/jpeg') {
        imagejpeg($new_image, $dest_file, 90);
    } else if ($mime == 'image/png') {
        imagepng($new_image, $dest_file);
    }
    imagedestroy($original_image);
    imagedestroy($new_image);
    return true;
}
//     if(file_exists($file)){ 

//         $original_image = imagecreatefromjpeg($file);

//         $original_width = imagesx($original_image);
//         $original_height = imagesy($original_image);


//         $ratio = $max_resolution / $original_width;
//         $new_width = $max_resolution;
//         $new_height = $original_height * $ratio;


//         if($new_height > $max_resolution) {
//             $ratio = $max_resolution / $original_height;
//             $new_width = $max_resolution;
//             $new_width = $original_width * $ratio;
//         }

//         if($original_image){
//             $new_image = imagecreatetruecolor($new_width,$new_height);
//             imagecopyresampled($new_image,$original_image,0,0,0,0,$new_width,$new_height,$original_width,$original_height);

//             imagejpeg($new_image,$file,90);
//         }
//     }

/*if(isset($_REQUEST['btn_report'])){
        echo "hello world";
    }

if (isset($_REQUEST['btn-login'])) {
    header("Location:login.php");
}

/*echo $date1," ",$numrand;*/
if (isset($_REQUEST['btn_report'])) {
    $raw_reporter = $_REQUEST['reporter_name'];
    list($reporter_name, $reporter_fullname) = explode('|', $raw_reporter);
    $position = $_REQUEST['position'];
    $report_date = $_REQUEST['report_date'];
    $room = $_REQUEST['room'];
    //$cleaner = $_REQUEST['cleaner'];
    $detail = $_REQUEST['detail'];
    $other_room = isset($_REQUEST['other_room']) ? trim($_REQUEST['other_room']) : '';

    $current = date('Y-m-d');

    $date = new DateTime($report_date);
    $year = (int)$date->format('Y');
    $month = (int)$date->format('m');

    $thai_year = $year + 543;

    if ($month >= 10) {
        $fiscal_year = $thai_year + 1;
    } else {
        $fiscal_year = $thai_year;
    }

    $fiscal_year = substr($fiscal_year, -2);

    if ($room === 'อื่นๆ') {
        if (empty($other_room)) {
            $errorMsg = 'กรุณาระบุชื่อห้องเพิ่มเติม';
        } else {
            $room = "อื่น ๆ - $other_room";
        }
    }

    if (empty($reporter_name)) {
        $errorMsg = "กรุณาระบุผู้รายงาน";
    } else if (empty($position)) {
        $errorMsg = "กรุณาระบุฝ่าย";
    } else if (empty($report_date)) {
        $errorMsg = "กรุณาระบุวันที่";
    } else if ($report_date > $current) {
        $errorMsg = "วันที่เกินจากปัจจุบัน";
    } else if (empty($room)) {
        $errorMsg = "กรุณาระบุห้อง";
    } else if (empty($detail)) {
        $errorMsg = "กรุณาระบุรายละเอียด";
    } else {
        try {
                    $sql = "SELECT COUNT(*) FROM clean_report WHERE fiscal_year = :fiscal_year";
                    $count_stmt = $db->prepare($sql);
                    $count_stmt->bindParam(':fiscal_year', $fiscal_year);
                    $count_stmt->execute();
                    $count = $count_stmt->fetchColumn();
                    $next_number = $count + 1;
                    $number = "{$next_number}/{$fiscal_year}";

                    // $img_file = (isset($_POST['img_file']) ? $_POST['img_file'] : '');

                    $newname = '';
                    $date1 = date("Ymd_His");
                    $numrand = (mt_rand());

                    $upload = $_FILES['img_file']['name'];
                    if ($upload != '') {
                        $typefile = strrchr($_FILES['img_file']['name'], ".");
                        if ($typefile == '.jpg' || $typefile  == '.jpeg' || $typefile  == '.png') {

                            // $file =$_FILES['img_file']['name'];
                            // resize_image($file,500);
                            $path = "upload/";
                            $newname = $numrand . $date1 . $typefile;
                            $dest_file = $path . $newname;
                            // move_uploaded_file($_FILES['img_file']['tmp_name'], $path_copy);

                            if (!resize_image($_FILES['img_file']['tmp_name'], $dest_file, 500)) {
                                $errorMsg = "บันทึกไฟล์ไม่สำเร็จ";
                                header("Location: index.php?messageER=" . urlencode($errorMsg));
                                die();
                            }
                        } else {
                            $errorMsg = "กรุณาอัพไฟล์รูปภาพเท่านั้น";
                            header("Location: index.php?messageIS=" . $errorMsg);
                            die();
                    }
                }



            $sql = "INSERT INTO clean_report(reporter_name, reporter_fullname, position, report_date, room, detail,image_name, fiscal_year,number) 
                    VALUES (:reporter_name, :reporter_fullname, :position, :report_date, :room,  :detail,:image_name, :fiscal_year, :number)";
                $insert_stmt = $db->prepare($sql);

                $params = array(
                    ':reporter_name' => $reporter_name,
                    ':reporter_fullname' => $reporter_fullname,
                    ':position' => $position,
                    ':report_date' => $report_date,
                    ':room' => $room,
                    ':detail' => $detail,
                    ':image_name' => $newname,
                    ':fiscal_year' => $fiscal_year,
                    ':number' => $number,

                );
                if ($insert_stmt->execute($params)) {
                    $insertMsg = "Report  Succesfully...";
                    header("Location: index.php?messageIS=" . $insertMsg);
                    die();
                }
        } catch (PDOException $e) {
            $errorMsg = "เกิดข้อผิดพลาด:" . $e->getMessage();
            header("Location: index.php?messageER=" . urlencode($errorMsg));
            die();
        }
    }

    header("Location: index.php?messageER=" . $errorMsg);
    die();
};
