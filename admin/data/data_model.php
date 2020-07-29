<?php
$data = new Data();
if (isset($_REQUEST['q'])) {
    $data->$_REQUEST['q']();
}
class Data
{

    function __construct()
    {
        if (!isset($_SESSION['id'])) {
            // header('location:../../');
        }
    }

    //get all subjects
    function getsubject($search)
    {
        $q = "select * from subject where code like '%$search%' or title like '%$search%' or college like '%$search%' or category like '%$search%' or type like '%$search%' or unit like '%$search%' order by code asc";
        $r = mysql_query($q);

        return $r;
    }
    //get subject by ID
    function getsubjectbyid($id)
    {
        $q = "select * from subject where id=$id";
        $r = mysql_query($q);
        return $r;
    }

    //get subject by classID
    function getsubjectbyclassid($id)
    {
        $q = "select * from class where id=$id";
        $r = mysql_query($q);
        return $r;
    }

    //get subject by code
    function getsubjectbycode($code)
    {
        $q = "select * from subject where code='$code'";
        $r = mysql_query($q);
        $data = mysql_fetch_array($r);
        return $data;
    }

    function getcollege($college)
    {
        $q = "select * from subject where college='$college' order by college asc";
        $r = mysql_query($q);
        return $r;
    }

    //add subject
    function addsubject()
    {
        include('../../config.php');
        $code = $_POST['code'];
        $title = $_POST['title'];
        $college = $_POST['college'];
        $category = $_POST['category'];
        $type = $_POST['type'];
        $unit = $_POST['unit'];

        $q1 = "select * from subject where code='$code'";
        $r = mysql_query($q1);

        if (mysql_num_rows($r) > 0) {
            header('location:../subject.php?r=duplicate ERROR');
        } else {

            $q = "insert into subject values('','$code','$title','$college','$category','$type','$unit')";
            mysql_query($q);

            $act = "add new subject $code - $title";
            date_default_timezone_set('Asia/Manila');
            $date = date('m-d-Y h:i:s A');
            echo $q4 = "insert into log values(null,'$date','$act')";
            mysql_query($q4);

            header('location:../subject.php?r=added');
        }
    }

    function updatesubject()
    {
        include('../../config.php');
        $id = $_POST['id'];
        $code = $_POST['code'];
        $code_old = $_POST['code_old'];
        $title = $_POST['title'];
        $college = $_POST['college'];
        $category = $_POST['category'];
        $type = $_POST['type'];
        $unit = $_POST['unit'];

        $q1 = "select * from subject where code='$code'";
        $r = mysql_query($q1);

        if (mysql_num_rows($r) == 0) {
            $allow_update = true;
        } else {
            if ($code == $code_old) {
                $allow_update = true;
            } else {
                $allow_update = false;
            }
        }

        if ($_POST['ftype'] == 'add') {
            if ($allow_update) {
                $q = "insert into subject values('','$code','$title','$college','$category','$type','$unit')";
                mysql_query($q);

                $act = "update subject $code - $title";

                date_default_timezone_set('Asia/Manila');
                $date = date('m-d-Y h:i:s A');
                mysql_query("insert into log values(null,'$date','$act')");
                header('location:../subject.php?r=updated');
            } else {
                header('location:../subject.php?r=duplicate ERROR(Subject Code conflict)');
            }
        } elseif ($_POST['ftype'] == 'edit') {
            if ($allow_update) {
                $q = "update subject set code='$code', title='$title', college='$college', category='$category', type='$type', unit=$unit where id=$id";

                $act = "update subject $code - $title";
                date_default_timezone_set('Asia/Manila');
                $date = date('m-d-Y h:i:s A');
                mysql_query("insert into log values(null,'$date','$act')");

                header('location:../subject.php?r=updated');
            } else {
                header('location:../subject.php?r=duplicate ERROR(Subject Code conflict)');
            }
        }
        mysql_query($q);
    }

    //GLOBAL DELETION
    function delete()
    {
        include('../../config.php');
        $table = $_GET['table'];
        $id = $_GET['id'];
        $q = "delete from $table where id=$id";
        $r = null;

        $tmp = mysql_query("select * from $table where id=$id");
        $tmp_row = mysql_fetch_array($tmp);

        mysql_query($q);

        if ($table == 'subject') {
            $record = $tmp_row['code'];
            header('location:../subject.php?r=deleted');
        } else if ($table == 'class') {
            $record = $tmp_row['subject'];
            header('location:../class.php?r=deleted');
        } else if ($table == 'student') {
            $record = $tmp_row['fname'];
            header('location:../studentlist.php?r=deleted');
        } else if ($table == 'teacher') {
            $record = $tmp_row['fname'];
            header('location:../teacherlist.php?r=deleted');
        } else if ($table == 'userdata') {
            $record = $tmp_row['username'];
            header('location:../users.php?r=deleted');
        }

        $act = "delete $record from $table";
        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysql_query("insert into log values(null,'$date','$act')");
    }
}
