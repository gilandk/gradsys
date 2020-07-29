<?php



$class = new Dataclass();
if (isset($_GET['q'])) {
    $class->$_GET['q']();
}
class Dataclass
{



    function __construct()
    {
        include('config.php');
        if (!isset($_SESSION['id'])) {
            header('location:../../');
        }
    }


    //get all class info
    function getclass($search)
    {

        $q = "select * from class where course like '%$search%' or year like '%$search%' or section like '%$search%' or college like '%$search%' or sem like '%$search%' or subject like '%$search%' or mergesubject like '%$search%' or sy like '%$search%' order by course,year,section,college,sem,subject,mergesubject,SY asc";
        $r = mysqli_query($conn, $q);

        return $r;
    }
    //get class by ID
    function getclassbyid($id)
    {
        $q = "select * from class where id=$id";
        $r = mysqli_query($conn, $q);

        return $r;
    }

    function getcollege($college)
    {
        $q = "select * from class where college='$college' order by college asc";
        $r = mysqli_query($conn,$q);
        return $r;
    }

    //add class
    function addclass()
    {
        include('../../config.php');
        $course = $_POST['course'];
        $year = $_POST['year'];
        $section = $_POST['section'];
        $college = $_POST['college'];
        $sem = $_POST['sem'];
        $subject = $_POST['subject'];
        $mergesubject = $_POST['mergesubject'];
        $sy = $_POST['sy'];

        $q = "insert into class values('','$course','$year','$section','$college','$sem','','$subject','$mergesubject','$sy')";
        mysqli_query($conn,$q);

        $act = "create new class with the subject of $subject $mergesubject";

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysqli_query($conn,"insert into log values(null,'$date','$act')");

        header('location:../class.php?r=added');
    }

    //update class
    function updateclass()
    {
        include('../../config.php');
        $id = $_GET['id'];
        $course = $_POST['course'];
        $year = $_POST['year'];
        $section = $_POST['section'];
        $college = $_POST['college'];
        $sem = $_POST['sem'];
        $subject = $_POST['subject'];
        $mergesubject = $_POST['mergesubject'];
        $sy = $_POST['sy'];

        echo $q = "update class set course='$course', year='$year', section='$section', college='$college', sem='$sem', subject='$subject', mergesubject='$mergesubject',sy='$sy' where id=$id";
        mysqli_query($conn,$q);

        $act = "update class with the subject of $subject $mergesubject";

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysqli_query($conn,"insert into log values(null,'$date','$act')");

        header('location:../class.php?r=updated');
    }

    //get all students in that class
    function getstudentsubject()
    {
        $classid = $_GET['classid'];
        $q = "select * from studentsubject where classid=$classid";
        $r = mysqli_query($conn,$q);
        $result = array();
        while ($row = mysqli_fetch_array($r)) {
            $q2 = 'select * from student where id=' . $row['studid'] . '';
            $r2 = mysqli_query($conn,$q2);
            $result[] = mysqli_fetch_array($r2);
        }
        return $result;
    }

    //get all students in that class
    function getstudentsubjectlec()
    {
        $classid = $_GET['classid'];
        $q = "select * from studentsubjectlec where classid=$classid";
        $r = mysqli_query($conn,$q);
        $result = array();
        while ($row = mysqli_fetch_array($r)) {
            $q2 = 'select * from student where id=' . $row['studid'] . '';
            $r2 = mysqli_query($conn,$q2);
            $result[] = mysqli_fetch_array($r2);
        }
        return $result;
    }

    //get all students in that class
    function getstudentsubjectlab()
    {
        $classid = $_GET['classid'];
        $q = "select * from studentsubjectlab where classid=$classid";
        $r = mysqli_query($conn,$q);
        $result = array();
        while ($row = mysqli_fetch_array($r)) {
            $q2 = 'select * from student where id=' . $row['studid'] . '';
            $r2 = mysqli_query($conn,$q2);
            $result[] = mysqli_fetch_array($r2);
        }
        return $result;
    }

    //add student to class
    function addstudent()
    {
        include('../../config.php');
        $classid = $_GET['classid'];
        $studid = $_GET['studid'];

        $verify = $this->verifystudentleclab($studid, $classid);
        if ($verify) {
            echo $q = "INSERT INTO studentsubject (studid,classid) VALUES ('$studid', '$classid');";
            mysqli_query($q);
            header('location:../classstudent.php?r=success&classid=' . $classid . '');
        } else {
            header('location:../classstudent.php?r=duplicate&classid=' . $classid . '');
        }
        $tmp = mysqli_query($conn,"select * from class where id=$classid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_subject = $tmp_row['subject'];

        $tmp = mysqli_query($conn,"select * from student where id=$studid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_student = $tmp_row['fname'] . ' ' . $tmp_rowp['midname'] . ' ' . $tmp_row['lname'];

        $act = "add student $tmp_student to class $tmp_class with the subject of $tmp_subject";

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysqli_query($conn,"insert into log values(null,'$date','$act')");
    }

    //add student to class
    function addstudentlec()
    {
        include('../../config.php');
        $classid = $_GET['classid'];
        $studid = $_GET['studid'];

        $verify = $this->verifystudentlec($studid, $classid);
        if ($verify) {
            echo $q = "INSERT INTO studentsubjectlec (studid,classid) VALUES ('$studid', '$classid');";
            mysqli_query($conn,$q);
            header('location:../classstudentlec.php?r=success&classid=' . $classid . '');
        } else {
            header('location:../classstudentlec.php?r=duplicate&classid=' . $classid . '');
        }
        $tmp = mysqli_query($conn,"select * from class where id=$classid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_subject = $tmp_row['subject'];

        $tmp = mysqli_query($conn,"select * from student where id=$studid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_student = $tmp_row['fname'] . ' ' . $tmp_rowp['midname'] . ' ' . $tmp_row['lname'];

        $act = "add student $tmp_student to class $tmp_class with the subject of $tmp_subject";

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysqli_query($conn,"insert into log values(null,'$date','$act')");
    }

    //add student to class
    function addstudentlab()
    {
        include('../../config.php');
        $classid = $_GET['classid'];
        $studid = $_GET['studid'];

        $verify = $this->verifystudentlab($studid, $classid);
        if ($verify) {
            echo $q = "INSERT INTO studentsubjectlab (studid,classid) VALUES ('$studid', '$classid');";
            mysqli_query($conn,$q);
            header('location:../classstudentlab.php?r=success&classid=' . $classid . '');
        } else {
            header('location:../classstudentlab.php?r=duplicate&classid=' . $classid . '');
        }

        $tmp = mysqli_query($conn,"select * from class where id=$classid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_subject = $tmp_row['subject'];

        $tmp = mysqli_query($conn,"select * from student where id=$studid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_student = $tmp_row['fname'] . ' ' . $tmp_rowp['midname'] . ' ' . $tmp_row['lname'];

        $act = "add student $tmp_student to class $tmp_class with the subject of $tmp_subject";

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysqli_query($conn,"insert into log values(null,'$date','$act')");
    }


    //verify if he/she is enrolled
    function verifystudentleclab($studid, $classid)
    {
        include('../../config.php');
        $q = "select * from studentsubject where studid=$studid and classid=$classid";
        $r = mysqli_query($conn,$q);
        if (mysqli_num_rows($r) < 1) {
            return true;
        } else {
            return false;
        }
    }

    //verify if he/she is enrolled
    function verifystudentlec($studid, $classid)
    {
        include('../../config.php');
        $q = "select * from studentsubjectlec where studid=$studid and classid=$classid";
        $r = mysqli_query($conn,$q);
        if (mysqli_num_rows($r) < 1) {
            return true;
        } else {
            return false;
        }
    }

    //verify if he/she is enrolled
    function verifystudentlab($studid, $classid)
    {
        include('../../config.php');
        $q = "select * from studentsubjectlab where studid=$studid and classid=$classid";
        $r = mysqli_query($conn,$q);
        if (mysqli_num_rows($r) < 1) {
            return true;
        } else {
            return false;
        }
    }

    //remove student to the class
    function removestudent()
    {
        $classid = $_GET['classid'];
        $studid = $_GET['studid'];
        include('../../config.php');
        $q = "delete from studentsubject where studid=$studid and classid=$classid";
        mysqli_query($conn,$q);

        $tmp = mysqli_query($conn,"select * from class where id=$classid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_subject = $tmp_row['subject'];
        $tmp_mergesubject = $tmp_row['mergesubject'];

        $tmp = mysqli_query($conn,"select * from student where id=$studid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_student = $tmp_row['fname'] . ' ' . $tmp_rowp['midname'] . ' ' . $tmp_row['lname'];

        $act = "remove student $tmp_student from class $tmp_class with the subject of $tmp_subject";

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysqli_query($conn,"insert into log values(null,'$date','$act')");


        header('location:../classstudent.php?r=success&classid=' . $classid . '');
    }

    function removestudentlec()
    {
        $classid = $_GET['classid'];
        $studid = $_GET['studid'];
        include('../../config.php');
        $q = "delete from studentsubjectlec where studid=$studid and classid=$classid";
        mysqli_query($conn,$q);

        $tmp = mysqli_query($conn,"select * from class where id=$classid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_subject = $tmp_row['subject'];
        $tmp_mergesubject = $tmp_row['mergesubject'];

        $tmp = mysqli_query($conn,"select * from student where id=$studid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_student = $tmp_row['fname'] . ' ' . $tmp_rowp['midname'] . ' ' . $tmp_row['lname'];

        $act = "remove student $tmp_student from class $tmp_class with the subject of $tmp_subject";

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysqli_query($conn,"insert into log values(null,'$date','$act')");

        header('location:../classstudentlec.php?r=success&classid=' . $classid . '');
    }

    function removestudentlab()
    {
        $classid = $_GET['classid'];
        $studid = $_GET['studid'];
        include('../../config.php');
        $q = "delete from studentsubjectlab where studid=$studid and classid=$classid";
        mysqli_query($conn,$q);

        $tmp = mysqli_query($conn,"select * from class where id=$classid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_subject = $tmp_row['subject'];
        $tmp_mergesubject = $tmp_row['mergesubject'];

        $tmp = mysqli_query($conn,"select * from student where id=$studid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_student = $tmp_row['fname'] . ' ' . $tmp_rowp['midname'] . ' ' . $tmp_row['lname'];

        $act = "remove student $tmp_student from class $tmp_class with the subject of $tmp_subject";

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysqli_query($conn,"insert into log values(null,'$date','$act')");


        header('location:../classstudentlab.php?r=success&classid=' . $classid . '');
    }


    //update teacher
    function updateteacher()
    {
        include('../../config.php');
        $classid = $_GET['classid'];
        $teachid = $_GET['teachid'];

        $verify = $this->verifyteacher($teachid, $classid);
        if ($verify) {
            echo $q1 = "INSERT INTO criteria (teachid,classid) VALUES ('$teachid', '$classid');";
            mysqli_query($conn,$q1);
        }

        $q = "update class set teacher=$teachid where id=$classid";
        mysqli_query($conn,$q);

        $tmp = mysqli_query($conn,"select * from class where id=$classid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_subject = $tmp_row['subject'];
        $tmp_class = $tmp_row['course'] . ' ' . $tmp_row['year'] . '-' . $tmp_row['section'];

        $tmp = mysqli_query($conn,"select * from teacher where id=$teachid");
        $tmp_row = mysqli_fetch_array($tmp);
        $tmp_teacher = $tmp_row['fname'] . ' ' . $tmp_row['midname'] . ' ' . $tmp_row['lname'];

        $act = "assign teacher $tmp_teacher to class $tmp_class with the subject of $tmp_subject";

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysqli_query($conn,"insert into log values(null,'$date','$act')");

        header('location:../classteacher.php?classid=' . $classid . '&teacherid=' . $teachid . '');
    }

    //verify if he/she is enrolled
    function verifyteacher($teachid, $classid)
    {
        include('../../config.php');
        $q = "select * from criteria where teachid=$teachid and classid=$classid";
        $r = mysqli_query($conn,$q);
        if (mysqli_num_rows($r) < 1) {
            return true;
        } else {
            return false;
        }
    }
}
