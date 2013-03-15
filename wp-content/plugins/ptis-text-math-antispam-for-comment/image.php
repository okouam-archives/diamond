<?php
session_start();
$qdata = $_SESSION['qdata'];
$question = iconv ('utf-8', 'windows-1251', $qdata);
$image = imageCreate (strlen ($question)*7, 9);
$bgColor = imagecolorallocate ($image, 255, 255, 255);
$textColor = imagecolorallocate ($image, 21, 21, 21);
$mf = imageloadfont ('./myfont.phpfont');
imagestring ($image, $mf, 1, 1, $question, $textColor);
header ('Content-type: image\/jpeg');
imagejpeg ($image);
?>