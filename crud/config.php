<?php

if($_SERVER['HTTP_HOST']=="localhost:8080"){
  define('HOST', 'localhost');
  define('USER', 'root');
  define('PASS', 'usbw');
  define('BASE', 'loja');
  define('PORT', '3307');
  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'root';
  $DATABASE_PASS = 'usbw';
  $DATABASE_NAME = 'loja';
  $DATABASE_PORT = '3307';
}else {
  define('HOST', 'localhost');
  define('USER', 'root2');
  define('PASS', 'usbw');
  define('BASE', 'test');
  define('PORT', '3306');
  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'root2';
  $DATABASE_PASS = 'usbw';
  $DATABASE_NAME = 'test';
  $DATABASE_PORT = '3306';
}
