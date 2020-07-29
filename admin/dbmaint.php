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

        <!-- /.row -->

        <h4> Backup Database </h4>
        <a href="dbbackup.php"><button type="submit" class="btn btn-primary" >Backup</button></a>
        </form>
        <hr>

        <h4> Restore Database </h4>
        <a href="dbrestore.php"><button type="submit" class="btn btn-primary" >Restore</button></a>
        
        <br>
        <br>

    </div>
    <!-- /.container-fluid -->
    
</div>
<!-- /#page-wrapper -->    
<?php include('include/footer.php');

