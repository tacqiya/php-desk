<html>

<head></head>

<body>
    <video controls>
        <source src="/Stream.php?file=/somevideo.mov">
    </video>
</body>

</html>


<?php

include_once('StreamVideo.php');

$file = $_GET['file'];

$obj = new StreamVideo();
$obj->initFile($file);
$obj->validateFile();
$obj->setHeaders();
$obj->streamContent();
?>