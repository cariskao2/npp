<?php
$mail   = $_POST['mail'];
$getImg = $_POST['hidden'];

$unique = array_unique($newArr = explode(',', $getImg));

echo $mail . '<br>';

foreach ($unique as $key => $value) {
    echo $value;
}
