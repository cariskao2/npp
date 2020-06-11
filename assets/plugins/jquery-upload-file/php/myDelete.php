<?php
include 'connMysql.php';

// $phone      = $_POST['phone'];
// $dir        = $path . $phone;

$random     = $_POST['_r'];
$path       = '../../../../assets/uploads/jquery-upload-file/';
$dir        = $path . $random;
$output_dir = $dir . '/';

if (isset($_POST['img'])) {
    $fileName = $_POST['img'];
    $fileName = str_replace("..", ".", $fileName); //required. if somebody is trying parent folder files
    $filePath = $output_dir . $fileName;

    if (file_exists($filePath)) {
        unlink($filePath);
    }

    if (count(scandir($dir)) == 2) {
        rmdir($dir);

        $sql = "DELETE FROM petition_f WHERE my_path = '" . $random . "'";
        mysqli_query($con, $sql) or die("失敗！" . mysqli_error($con));
    }

    echo json_encode("Deleted File " . $fileName);
}
