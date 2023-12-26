<?php
session_start();
$servername   = "localhost";
$database = "otp_db";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

if($_POST['email']) {
    $email = $_POST['email'];
    $sql ="SELECT * FROM email_id_check where email='$email'";
    $check = mysqli_query($conn, $sql);
    if(mysqli_num_rows($check) > 0) {
        $otp = rand(11111, 99999);
        $update = mysqli_query($conn, "UPDATE email_id_check set otp='$otp' where email='$email'");
        $_SESSION['email'] = $email;
        //sent mail
        echo json_encode(['error' => false, 'msg' => 'Success']);
    } else {
        echo json_encode(['error' => true, 'msg' => 'Failed']);
    }
}
?>