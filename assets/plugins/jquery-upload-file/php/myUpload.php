<?php
include 'connMysql.php';
session_start();

// $phone = $_POST['phone'];
// $dir = $path . $phone;

$random = $_POST['_r'];
$path   = '../../../../assets/uploads/jquery-upload-file/';
$dir    = $path . $random;

// $_SESSION['random_folder'] = $random; // Petition_f收不到

$check = "SELECT `my_path` FROM petition_f WHERE my_path = '" . $random . "'";

if ($result = mysqli_query($con, $check)) {
    $rowcount = mysqli_num_rows($result);

    if ($rowcount == 0) {
        $sql = "INSERT INTO petition_f (my_path) VALUES ('" . $random . "')";
        mysqli_query($con, $sql) or die("失敗！" . mysqli_error($con));
    }
}

create_folders($dir);

function create_folders($dir)
{
    // is_dir() 函数检查指定的文件是否是目录。
    // dirname() 函数返回路径中的目录部分。
    return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777));
    // 如果$dir不是一個目錄,就返回$dir前面的路徑,並在此路徑下建立一個$dir目錄
    // 得到路徑後，先判斷是否已是一個有效的檔案目錄，如是則返回，結束程式。如果不是，（由於這裡用了OR作先擇性的條件，即只要滿足其中一個條件就行），則遞迴再呼叫自身，並且傳入的路徑中，少一級目錄。這樣來先回到上級有的父級目錄中，再用mkdir來建立下一級的。
}

$output_dir = $dir . '/';

if (isset($_FILES["myfile"])) {
    $ret = array();

    $error = $_FILES["myfile"]["error"];
    //You need to handle  both cases
    //If Any browser does not support serializing of multiple files using FormData()
    if (!is_array($_FILES["myfile"]["name"])) //single file
    {
        $fileName = $_FILES["myfile"]["name"];
        move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $fileName);
        $ret[] = $fileName;
    } else //Multiple files, file[]
    {
        $fileCount = count($_FILES["myfile"]["name"]);
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $_FILES["myfile"]["name"][$i];
            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $fileName);
            $ret[] = $fileName;
        }
    }
    echo json_encode($ret);
}
