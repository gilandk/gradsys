<?php
    $settings = new Datasettings();
    if(isset($_GET['q'])){
        $settings->$_GET['q']();
    }

    class Datasettings {

        function __construct(){
            if(!isset($_SESSION['id'])){
                header('location:../../');
            }
        }

        function getlevel($level){
            $q = "select * from userdata where level='$level' order by level asc";
            $r = mysql_query($q);
            return $r;
        }

        function changepassword(){
            include('../../config.php');
            $username = $_GET['username'];
            $new = ($_POST['new']);
            $confirm =($_POST['confirm']);
            if($new == $confirm){
                $r2 = mysql_query("update userdata set password='$new' where username='$username'");
                header('location:../settings.php?msg=success&username='.$username.'');
            }else{
                header('location:../settings.php?msg=error&username='.$username.'');
            }

            $act = "update password of username $username";
            date_default_timezone_set('Asia/Manila');
            $date = date('m-d-Y h:i:s A');
            mysql_query("insert into log values(null,'$date','$act')");
            
        }

        function addaccount(){
            include('../../config.php');
            $level = $_GET['level'];
            $id = $_GET['id'];
            $q = "select * from $level where id=$id";
            $r = mysql_query($q);
            $row = mysql_fetch_array($r);
            if($level == 'student'){
                $username = $row['studid'];
                $fname = $row['fname'];
                $midname = $row['midname'];
                $lname = $row['lname'];
                $password = $username;
            }else{
                $username = $row['teachid'];
                $fname = $row['fname'];
                $midname = $row['midname'];
                $lname = $row['lname'];
                $password = $username;
            }
            $verify = $this->verifyusername($username);
            if($verify){
                $q2 = "insert into userdata values(null,'$username','$fname','$midname','$lname','$level','$password')";
                mysql_query($q2);
                header('location:../'.$level.'list.php?r=added an account');
            }else{
                  header('location:../'.$level.'list.php?r=has already an account');
            }

            $act = "add account with the username of $username";
            date_default_timezone_set('Asia/Manila');
            $date = date('m-d-Y h:i:s A');
            mysql_query("insert into log values(null,'$date','$act')");;
            
        }

        //add admin account
        function adminaccount(){
            include('../../config.php');
            $id = $_GET['id'];
            $q = "select * from userdata where id=$id";
            $r = mysql_query($q);
            $row = mysql_fetch_array($r);

            $username = $row['username'];
            $fname = $row['fname'];
            $midname = $row['midname'];
            $lname = $row['lname'];
            $level = "admin";
            $password = $username;

            $verify = $this->verifyaccount($username);
            if($verify){
                $q2 = "insert into userdata values(null,'admin$username','$fname','$midname','$lname','$level','admin$password')";
                mysql_query($q2);
                header('location:../users.php?r=added admin account');
            }else{
                  header('location:../users.php?r=has already an account');
            }

            $act = "add account with the username of $username - $level";
            date_default_timezone_set('Asia/Manila');
            $date = date('m-d-Y h:i:s A');
            mysql_query("insert into log values(null,'$date','$act')");
            

        }

        function verifyaccount($level){
            $q = "select * from userdata where level='$level'";
            $r = mysql_query($q);
            if(mysql_num_rows($r) < 1){
               return true;
            }else{
                return false;
            }
        }

        function verifyusername($user){
            $q = "select * from userdata where username='$user'";
            $r = mysql_query($q);
            if(mysql_num_rows($r) < 1){
               return true;
            }else{
                return false;
            }
        }

        function getuser($search){
            $user = $_SESSION['id'];
            $q = "select * from userdata where username !='$user' and username like '%$search%' order by lname asc";
            $r = mysql_query($q);
            return $r;
        }
    }
