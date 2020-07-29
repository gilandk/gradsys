<?php
//    die('FORM VARIABLE "q" equals: '.$_REQUEST['q']);
$student = new Datastudent();
if (isset($_REQUEST['q'])) {
    $student->$_REQUEST['q']();
}
class Datastudent
{

    function __construct()
    {
        if (!isset($_SESSION['id'])) {
            // header('location:../../'); 
        }
    }
    //get all student info
    function getstudent($search)
    {
        $q = "select * from student where studid like '%$search%' or fname like '%$search%' or midname like '%$search%' or lname like '%$search%' or college like '%$search%' or course like '%$search%' or year like '%$search%' or section like '%$search%' order by section,year,course,college,lname,midname,fname,studid";
        $r = mysql_query($q);

        return $r;
    }

    //get class by ID
    function getstudentbyid($id)
    {
        $q = "select * from student where id=$id";
        $r = mysql_query($q);

        return $r;
    }

    function getcollege($college)
    {
        $q = "select * from student where college='$college' order by college asc";
        $r = mysql_query($q);
        return $r;
    }

    function getstudentbyclass($classid)
    {
        $q = "select * from studentsubject where classid=$classid";
        $r = mysql_query($q);
        $q3 = "select * from studentsubjectlec where classid=$classid";
        $r3 = mysql_query($q3);
        $q4 = "select * from studentsubjectlab where classid=$classid";
        $r4 = mysql_query($q4);
        $student = array();
        if ($classid != null) {
            while ($row = mysql_fetch_array($r)) {
                $q2 = 'select * from student where id=' . $row['studid'] . '';
                $r2 = mysql_query($q2);
                $student[] = mysql_fetch_array($r2);
            }
            while ($row = mysql_fetch_array($r3)) {
                $q2 = 'select * from student where id=' . $row['studid'] . '';
                $r2 = mysql_query($q2);
                $student[] = mysql_fetch_array($r2);
            }
            while ($row = mysql_fetch_array($r4)) {
                $q2 = 'select * from student where id=' . $row['studid'] . '';
                $r2 = mysql_query($q2);
                $student[] = mysql_fetch_array($r2);
            }
        }
        return $student;
    }

    //add student
    function addstudent()
    {

        include('../../config.php');
        $studid = $_POST['studid'];
        $fname = $_POST['fname'];
        $midname = $_POST['midname'];
        $lname = $_POST['lname'];
        $college = $_POST['college'];
        $course = $_POST['course'];
        $year = $_POST['year'];
        $section = $_POST['section'];

        $q1 = "SELECT * FROM student where studid='$studid'";
        $r = mysql_query($q1);

        if (mysql_num_rows($r) > 0) {
            header('location:../studentlist.php?r=has already an account');
        } else {
            $q = "insert into student values('','$studid','$fname','$midname','$lname','$college','$course','$year','$section')";
            mysql_query($q);

            $name = $fname . ' ' . $midname . ' ' . $lname;
            $act = "add new student $name";
            date_default_timezone_set('Asia/Manila');
            $date = date('m-d-Y h:i:s A');
            mysql_query("insert into log values(null,'$date','$act')");

            header('location:../studentlist.php?r=added');
        }
    }

    //update student
    function updatestudent()
    {
        include('../../config.php');
        $id = $_POST['id'];
        $studid = $_POST['studid'];
        $studid_old = $_POST['studid_old'];
        $fname = $_POST['fname'];
        $midname = $_POST['midname'];
        $lname = $_POST['lname'];
        $college = $_POST['college'];
        $course = $_POST['course'];
        $year = $_POST['year'];
        $section = $_POST['section'];

        $q1 = "SELECT * FROM student where studid='$studid'";
        $r = mysql_query($q1);

        if (mysql_num_rows($r) == 0) {
            $allow_update = true;
        } else {
            if ($studid == $studid_old) {
                $allow_update = true;
            } else {
                $allow_update = false;
            }
        }

        $name = $fname . ' ' . $midname . ' ' . $lname;

        if ($_POST['type'] == 'add') {
            if ($allow_update) {
                $q = "insert into student values('','$studid','$fname','$midname','$lname','$college','$course','$year','$section')";

                $act = "updated $name";
                date_default_timezone_set('Asia/Manila');
                $date = date('m-d-Y h:i:s A');
                mysql_query("insert into log values(null,'$date','$act')");

                header('location:../studentlist.php?r=updated');
            } else {
                header('location:../studentlist.php?r=has already an account.(Student ID conflict)');
            }
        } elseif ($_POST['type'] == 'edit') {
            if ($allow_update) {
                $q = "update student set studid='$studid', fname='$fname', midname='$midname', lname='$lname', college='$college', course='$course', year='$year', section='$section' where id=$id";

                $act = "updated $name";
                date_default_timezone_set('Asia/Manila');
                $date = date('m-d-Y h:i:s A');
                mysql_query("insert into log values(null,'$date','$act')");

                header('location:../studentlist.php?r=updated');
            } else {
                header('location:../studentlist.php?r=has already an account.(Student ID conflict)');
            }
        }
        mysql_query($q);
    }
}
