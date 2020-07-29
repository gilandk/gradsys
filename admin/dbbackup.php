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
        $tables = array();
        $result = mysqli_query($connection, "SHOW TABLES");
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
        $return = '';
        foreach ($tables as $table) {
            $result = mysqli_query($connection, "SELECT * FROM " . $table);
            $num_fields = mysqli_num_fields($result);

            $return .= 'DROP TABLE ' . $table . ';';
            $row2 = mysqli_fetch_row(mysqli_query($connection, "SHOW CREATE TABLE " . $table));
            $return .= "\n\n" . $row2[1] . ";\n\n";

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $return .= "INSERT INTO " . $table . " VALUES(";
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        if (isset($row[$j])) {
                            $return .= '"' . $row[$j] . '"';
                        } else {
                            $return .= '""';
                        }
                        if ($j < $num_fields - 1) {
                            $return .= ',';
                        }
                    }
                    $return .= ");\n";
                }
            }
            $return .= "\n\n\n";
        }
        //save file
        $handle = fopen("dbbackup.sql", "w+");
        fwrite($handle, $return);
        fclose($handle);
        $act = $_SESSION['id'] . ' (' . $level . ') ' . $_SESSION['name'] . ' - backed up database.';
        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y h:i:s A');
        mysql_query("insert into log values(null,'$date','$act')");
        echo "Successfully backed up";

        ?>

    </div>
    <!-- /#page-wrapper -->
    <?php include('include/footer.php');
