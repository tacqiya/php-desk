<?php

define('TIME_ZONE', 'Asia/Dubai');
define('TIME_ZONE_IN_UTC', 'UTC+4');
if(function_exists('date_default_timezone_set')){
   date_default_timezone_set(TIME_ZONE);
}

$servername   = "localhost";
$database = "icar";
$username = "root";
$password = "";

// $conn = new mysqli($servername, $username, $password, $database);

// if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
// }


if($_POST['pledge']) {
   $pledge = $_POST['pledge'];
   $datetime = date('Y-m-d H:i:s');

   $connect = mysqli_connect($servername, $username, $password, $database);
   $sql = "insert into cop_28_pledge (pledge, datetime) values('$pledge', '$datetime')";
   if($pledge == 'Reduce the use of plastic') {
      $img = 'assets/images/student_program/program-5.png';
   } else if($pledge == 'Keep the environment clean') {
      $img = 'assets/images/student_program/program-6.png';
   } else if($pledge == 'Not throwing away waste into outside') {
      $img = 'assets/images/student_program/program-7.png';
   }
   
   if (mysqli_query($connect, $sql)) {
      $total = "SELECT * FROM cop_28_pledge";
      $totalResult = mysqli_query($connect, $total);

      $votedFor = "SELECT * FROM cop_28_pledge where pledge = '$pledge'";
      $votedResult = mysqli_query($connect, $votedFor);
      $percentage = ($votedResult->num_rows/$totalResult->num_rows) * 100;
      // echo "<pre>"; print_r($votedResult->num_rows); echo "</pre>";
      $div = '<div class="modal-result" style="line-height: 2; text-align: center;"><p>Successfully submitted.</p>
      <p>'.$votedResult->num_rows.' have pledged for '.$pledge.'</p>
      <span>Total votes : '.$totalResult->num_rows.'</span><br>
      <span>Option voted for : '.$votedResult->num_rows.'</span>
      <h3>Voting result:</h3>
      <div class="w3-border">
         <div class="w3-grey" style="height:24px;width:'.$percentage.'%"></div>
      </div>
      <p>Thanks to your supporting this pledge! We need more votes to reach the next goal - can you help?</p>
      <img src="'.$img.'" />
      <br>
      <span class="share">Share: <a href="#" class="fb">FB</a> <a href="#" class="twit">X</a></span>
      </div>';
      echo json_encode(array('error' => false, 'message' => $div));
   } else {
      echo json_encode(array('error' => false, 'message' => '<div style="line-height: 2; text-align: center;">Unable to process the request. Please try again or contact administrator.</div>'));
   }
}