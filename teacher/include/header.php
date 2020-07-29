<?php
include('../config.php');
$level = isset($_SESSION['level']) ? $_SESSION['level'] : null;
if ($level == null) {
    header('location:../index.php');
} else if ($level != 'teacher') {
    header('location:../' . $level . '');
}
$id = $_SESSION['id'];
$q = "select * from teacher where teachid='$id'";
$r = mysql_query($q);
if ($row = mysql_fetch_array($r)) {
    $id = $row['id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Teacher Panel</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/sb-admin.css" rel="stylesheet">
    <link href="../css/plugins/morris.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">


</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">DYCI - INSTRUCTOR PANEL</a>
            </div>
            <ul class="nav navbar-right top-nav">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><label class="text-title"><i class="fa fa-user"></i> Hi, <?php echo $_SESSION['name']; ?> (Instructor)<b class="caret"></label></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="settings.php"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>