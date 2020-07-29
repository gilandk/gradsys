<?php     
    include('config.php');

    if ($_SESSION['level'] == 'admin'){
        $level = "Administrator";
      }
      elseif ($_SESSION['level'] == 'teacher')
        $level = "Instructor";
      else {
        $level = "Student";
      }

    $act = $_SESSION['id'].' ('.$level.') '.$_SESSION['name'].' - logged out.';

    date_default_timezone_set('Asia/Manila');         
    $date = date('m-d-Y h:i:s A');
    mysql_query("insert into log values(null,'$date','$act')");
    session_destroy();
    header('location:index.php');
?>