<?php
include('include/header.php');
include('include/sidebar.php');
include('data/settings_model.php');

$student = $settings->getlevel('student');
$teacher = $settings->getlevel('teacher');
$admin = $settings->getlevel('admin');

$search = isset($_POST['search']) ? $_POST['search'] : null;
$user = $settings->getuser($search);
?>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Settings <small>Users</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                    </li>
                    <li class="active">
                        Users
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <?php if (isset($_GET['r'])) : ?>
                    <?php
                        $r = $_GET['r'];
                        if ($r == 'added') {
                            $class = 'success';
                        } else if ($r == 'updated') {
                            $class = 'info';
                        } else if ($r == 'deleted') {
                            $class = 'danger';
                        } else if ($r == 'has already an account') {
                            $class = 'danger';
                        } else if ($r == 'added an account') {
                            $class = 'success';
                        } else if ($r == 'added admin account') {
                            $class = 'success';
                        } else {
                            $class = 'hide';
                        }
                        ?>
                    <div class="alert alert-<?php echo $class ?> <?php echo $classs; ?>">
                        <strong>Account <?php echo $r; ?>!</strong>
                    </div>
                <?php endif; ?>
                <div class="form-inline form-padding">
                    <form action="users.php" method="post">
                        <input type="text" class="form-control" name="search" placeholder="Search by username">
                        <button type="submit" name="submitsearch" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                    </form>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">

                <!-- tab list -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#data1" role="tab" data-toggle="tab">All</a></li>
                    <li><a href="#data2" role="tab" data-toggle="tab">Student</a></li>
                    <li><a href="#data3" role="tab" data-toggle="tab">Instructor</a></li>
                    <li><a href="#data4" role="tab" data-toggle="tab">Admin</a></li>
                </ul>
                <!-- tab list -->
                <div class="tab-content">
                    <div class="tab-pane active" id="data1">
                        <br />
                        <!-- table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>Password</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php while ($row = mysql_fetch_array($user)) : ?>
                                        <tr>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['lname'] . ', ' . $row['fname'] . ' ' . $row['midname']; ?></td>

                                            <?php
                                                if ($row['level'] == 'teacher') {
                                                    $style = "color:#f0ad4e";
                                                    $level = "Instructor";
                                                } elseif ($row['level'] == 'admin') {
                                                    $style = "color:blue";
                                                    $level = "Admin";
                                                } else {
                                                    $style = "color:#e32214";
                                                    $level = "Student";
                                                }

                                                ?>

                                            <td><b style="<?php echo $style; ?>"><?php echo $level; ?></b></td>
                                            <td><a href="settings.php?username=<?php echo $row['username']; ?>" style="color:green">Update</a></td>
                                            <td><a href="data/data_model.php?q=delete&table=userdata&id=<?php echo $row['id'] ?>" title="Remove" class="text-danger confirmation">Remove</a></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="data2">
                        <br />
                        <!-- table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>Password</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysql_fetch_array($student)) : ?>
                                        <tr>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['lname'] . ', ' . $row['fname'] . ' ' . $row['midname']; ?></td>
                                            <?php
                                                if ($row['level'] == 'teacher') {
                                                    $style = "color:#f0ad4e";
                                                    $level = "Instructor";
                                                } elseif ($row['level'] == 'admin') {
                                                    $style = "color:blue";
                                                    $level = "Admin";
                                                } else {
                                                    $style = "color:#e32214";
                                                    $level = "Student";
                                                }

                                                ?>

                                            <td><b style="<?php echo $style; ?>"><?php echo $level; ?></b></td>
                                            <td><a href="settings.php?username=<?php echo $row['username']; ?>">Update</a></td>
                                            <td><a href="data/data_model.php?q=delete&table=userdata&id=<?php echo $row['id'] ?>" title="Remove" class="text-danger confirmation">Remove</a></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="data3">
                        <br />
                        <!-- table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th class="text-center">Add Admin Account</th>
                                        <th>Password</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysql_fetch_array($teacher)) : ?>
                                        <tr>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['lname'] . ', ' . $row['fname'] . ' ' . $row['midname']; ?></td>

                                            <?php
                                                if ($row['level'] == 'teacher') {
                                                    $style = "color:#f0ad4e";
                                                    $level = "Instructor";
                                                } elseif ($row['level'] == 'admin') {
                                                    $style = "color:blue";
                                                    $level = "Admin";
                                                } else {
                                                    $style = "color:#e32214";
                                                    $level = "Student";
                                                }

                                                ?>

                                            <td><b style="<?php echo $style; ?>"><?php echo $level; ?></b></td>
                                            <td class="text-center"><a href="data/settings_model.php?q=adminaccount&table=userdata&id=<?php echo $row['id'] ?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>&nbsp;</td>

                                            <td><a href="settings.php?username=<?php echo $row['username']; ?>">Update</a></td>
                                            <td><a href="data/data_model.php?q=delete&table=userdata&id=<?php echo $row['id'] ?>" title="Remove" class="text-danger confirmation">Remove</a></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="data4">
                        <br />
                        <!-- table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th class="text-center">Admin account</th>
                                        <th>Password</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysql_fetch_array($admin)) : ?>
                                        <tr>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['lname'] . ', ' . $row['fname'] . ' ' . $row['midname']; ?></td>
                                            <?php
                                                if ($row['level'] == 'teacher') {
                                                    $style = "color:#f0ad4e";
                                                    $level = "Instructor";
                                                } elseif ($row['level'] == 'admin') {
                                                    $style = "color:blue";
                                                    $level = "Admin";
                                                } else {
                                                    $style = "color:#e32214";
                                                    $level = "Student";
                                                }

                                                ?>

                                            <td><b style="<?php echo $style; ?>"><?php echo $level; ?></b></td>
                                            <td class="text-center"><b style="color:green">ACTIVE</b></td>

                                            <td><a href="settings.php?username=<?php echo $row['username']; ?>">Update</a></td>
                                            <td><a href="data/data_model.php?q=delete&table=userdata&id=<?php echo $row['id'] ?>" title="Remove" class="text-danger confirmation">Remove</a></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>

            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include('include/footer.php');
