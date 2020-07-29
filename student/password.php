<?php
$settings = new Datasettings();
if (isset($_GET['q'])) {
    $settings->$_GET['q']();
}

class Datasettings
{

    function __construct()
    {
        if (!isset($_SESSION['id'])) {
            header('location:../../');
        }
    }

    function changepassword()
    {
        include('../config.php');
        $username = $_GET['username'];
        $current = ($_POST['current']);
        $new = ($_POST['new']);
        $confirm = ($_POST['confirm']);
        $q = "select * from userdata where username='$username' and password='$current'";
        $r = mysql_query($q);
        if (mysql_num_rows($r) > 0) {
            if ($new == $confirm) {
                $act = $username . ' changes his/her password.';
                date_default_timezone_set('Asia/Manila');
                $date = date('m-d-Y h:i:s A');
                mysql_query("insert into log values(null,'$date','$act')");
                $r2 = mysql_query("update userdata set password='$new' where username='$username' and password='$current'");
                header('location:index.php?msg=success&username=' . $username . '');
            } else {
                header('location:index.php?msg=error&username=' . $username . '');
            }
        } else {
            header('location:index.php?msg=error&username=' . $username . '');
        }
    }
}
