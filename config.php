<?php
    session_start();
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'grading';

    $conn = mysqli_connect($host,$user,$pass,$db);
?>