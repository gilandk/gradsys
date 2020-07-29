<?php
//    die('FORM VARIABLE "q" equals: '.$_REQUEST['q']);

$teacher = new Datateacher();

if (isset($_REQUEST['q'])) {
    $teacher->$_REQUEST['q']();
}

class Datateacher
{

    function __construct()
    {

        if (!isset($_SESSION['id'])) {
            // header('location:../../');
        }
    }
    //get all teacher info
    function getteacher($search)
    {
        $q = "select * from teacher where teachid like '%$search%' or fname like '%$search%' or midname like '%$search%' or lname like '%$search%' or college like '%$search%' order by college,lname,midname,fname,teachid";
        $r = mysql_query($q);

        return $r;
    }

    //get teacher by ID
    function getteacherbyid($id)
    {
        $q = "select * from teacher where id=$id";
        $r = mysql_query($q);

        return $r;
    }

    function getteachername($teachid)
    {
        $r = mysql_query("select * from teacher where id=$teachid");
        $result = mysql_fetch_array($r);
        $data = $result['fname'] . ' ' . $result['midname'] . ' ' . $result['lname'];
        return $data;
    }

    function getcollege($college)
    {
        $q = "select * from teacher where college='$college' order by college asc";
        $r = mysql_query($q);
        return $r;
    }

    //add teacher
    function addteacher()
    {
        include('../../config.php');
        $teachid = $_POST['teachid'];
        $fname = $_POST['fname'];
        $midname = $_POST['midname'];
        $lname = $_POST['lname'];
        $college = $_POST['college'];

        $q1 = "SELECT * FROM teacher where teachid='$teachid'";
        $r = mysql_query($q1);

        if (mysql_num_rows($r) > 0) {
            header('location:../teacherlist.php?r=has already an account');
        } else {
            $q = "insert into teacher values('','$teachid','$fname','$midname','$lname','$college')";
            mysql_query($q);

            $name = $fname . ' ' . $midname . ' ' . $lname;
            $act = "add new teacher $name";
            date_default_timezone_set('Asia/Manila');
            $date = date('m-d-Y h:i:s A');
            mysql_query("insert into log values(null,'$date','$act')");
        }
    }

    function updateteacher()
    {

        include('../../config.php');
        $id = $_POST['id'];
        $teachid = $_POST['teachid'];
        $teachid_old = $_POST['teachid_old'];
        $fname = $_POST['fname'];
        $midname = $_POST['midname'];
        $lname = $_POST['lname'];
        $college = $_POST['college'];

        $q1 = "SELECT * FROM teacher where teachid='$teachid'";
        $r = mysql_query($q1);

        if (mysql_num_rows($r) == 0) {
            $allow_update = true;
        } else {
            if ($teachid == $teachid_old) {
                $allow_update = true;
            } else {
                $allow_update = false;
            }
        }

        $name = $fname . ' ' . $midname . ' ' . $lname;

        if ($_POST['type'] == 'add') {
            if ($allow_update) {
                $q = "insert into teacher values('','$teachid','$fname','$midname','$lname','$college')";

                $act = "updated $name";
                date_default_timezone_set('Asia/Manila');
                $date = date('m-d-Y h:i:s A');
                mysql_query("insert into log values(null,'$date','$act')");

                header('location:../teacherlist.php?r=updated');
            } else {
                header('location:../teacherlist.php?r=has already an account.(Instructor ID conflict)');
            }
        } elseif ($_POST['type'] == 'edit') {
            if ($allow_update) {
                $q = "update teacher set teachid='$teachid', fname='$fname', midname='$midname', lname='$lname', college='$college' where id=$id";

                $act = "updated $name";
                date_default_timezone_set('Asia/Manila');
                $date = date('m-d-Y h:i:s A');
                mysql_query("insert into log values(null,'$date','$act')");

                header('location:../teacherlist.php?r=updated');
            } else {
                header('location:../teacherlist.php?r=has already an account.(Instructor ID conflict)');
            }
        }
        mysql_query($q);
    }

    //remove teacher from class
    function removesubject()
    {
        include('../../config.php');
        $classid = $_GET['classid'];
        $teachid = $_GET['teachid'];
        mysql_query("update class set teacher=null where id=$classid");
        header('location:../teacherload.php?id=' . $teachid . '');

        $tmp = mysql_query("select * from class where id=$classid");
        $tmp_row = mysql_fetch_array($tmp);
        $tmp_subject = $tmp_row['subject'];
        $tmp_class = $tmp_row['course'] . ' ' . $tmp_row['year'] . '-' . $tmp_row['section'];

        $tmp = mysql_query("select * from teacher where id=$teachid");
        $tmp_row = mysql_fetch_array($tmp);
        $tmp_teacher = $tmp_row['fname'] . ' ' . $tmp_rowp['midname'] . ' ' . $tmp_row['lname'];

        $act = "remove teacher $tmp_teacher from class $tmp_class with the subject of $tmp_subject";
        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysql_query("insert into log values(null,'$date','$act')");
    }
}
