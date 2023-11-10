<?php
if(isset($_POST['password'])) {
    if($_POST['password'] != '') {
        $pass = $_POST['password'];
        $times = $_POST['times'];
        if($times > 0) {
            for($i=1;$i<=$times;$i++) {
                $pass = md5($pass);
            }
            $converted = $pass;
            $data['result'] = $converted;
            $data['color'] = '#aad1aa';
        } else {
            $data['result'] = 'Times should be greater than 0';
            $data['color'] = '#fdbf4c';
        }
        
    } else {
        $data['result'] = "No password provided";
        $data['color'] = '#fdbf4c';
    }
} else {
    $data['result'] = '';
    $data['color'] = 'transparent';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MD5 Converter</title>
    <style>
    .result {
        background-color: <?=$data['color'] ?>;
        padding: 10px;
        display: inline-block;
    }
    </style>
</head>

<body>
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
        <input type="text" name="password" id="password" placeholder="Enter password" required><br>
        <input type="text" name="times" id="times" placeholder="Enter times to convert" required><br>
        <input type="submit" value="Submit">
    </form>
    <span class="result"><?= $data['result'] ?></span>

    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
</body>

</html>