<?php
if(isset($_POST['serial-text'])) {
    if($_POST['serial-text'] != '') {
        $pass = $_POST['serial-text'];
        $pass = str_replace(array("\r", "\n"), '', $pass);
            var_dump($pass);
            if($pass[0] == '[') {
                $new_pass = json_decode($pass, TRUE);
                $converted = serialize($new_pass);
            } else {
                
                $new_pass = json_decode($pass, TRUE);
                $converted = serialize($new_pass);
            }
            $data['result'] = $converted;
            $data['color'] = '#aad1aa';
    } else {
        $data['result'] = "Text not provided";
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
    <textarea name="serial-text" id="serial-text" cols="30" rows="10"></textarea><br>
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