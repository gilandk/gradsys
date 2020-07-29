<?php
include('include/header.php');
include('include/sidebar.php');
?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Settings <small> Maintenance</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-tasks"></i> Database
                    </li>
                </ol>
            </div>
        </div>

        <a href="dbmaint.php"><button type="submit" class="btn btn-primary">Return</button></a>
        <br>
        <br>

        <?php
        $connection = mysqli_connect('localhost', 'root', '', 'grading');
        $filename = 'dbbackup.sql';
        $handle = fopen($filename, "r+");
        $contents = fread($handle, filesize($filename));
        $sql = explode(';', $contents);
        foreach ($sql as $query) {
            $result = mysqli_query($connection, $query);
            if ($result) {
                echo '<tr><td><br></td></tr>';
                echo '<tr><td>' . $query . ' <b>SUCCESS</b></td></tr>';
                echo '<tr><td><br></td></tr>';
            }
        }
        fclose($handle);
        $act = $_SESSION['id'] . ' (' . $level . ') ' . $_SESSION['name'] . ' - backed up database.';
        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysql_query("insert into log values(null,'$date','$act')");
        echo '<br> Successfully imported';

        ?>

    </div>
    <!-- /#page-wrapper -->
    <?php include('include/footer.php');
