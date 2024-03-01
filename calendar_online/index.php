<?php

// https://settings.calendar.online/public-api
// https://calendar.online/

$current_date = date('Y-m-d', strtotime("-1 days"));
$last_date = date('Y-m-d', strtotime('+1 year'));
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.calendar.online/public/event?startDate='.$current_date.'&endDate='.$last_date.'&timeZone=Europe%2FBerlin&query=',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'X-API-KEY: d33e55272aa133c6216a4378d26383427210310f9ed8d71cecbfc321253881ad',
    'Cookie: PHPSESSID=atod7u7cjo4ujrs40ld078femt'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo '<pre>'; print_r(json_decode($response)) ; echo '</pre>';

foreach(json_decode($response) as $calendar_out) {
    $start_date = str_replace("00:00:00", " ", $calendar_out->startDate);
    $end_date = str_replace("00:00:00", " ", $calendar_out->endDate);

    if($calendar_out->startDate > $current_date) {
        echo date("j M", strtotime($start_date)).' - '.date("j M", strtotime($end_date)).'<br>';
        echo $calendar_out->title.'<br><br>';
    }
}