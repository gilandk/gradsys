<?php
include('include/header.php');
include('include/sidebar.php');
include('data/teacher_model.php');
include('data/data_model.php');

$CCS = $teacher->getcollege('CCS');
$COA = $teacher->getcollege('COA');
$CBA = $teacher->getcollege('CBA');
$CHS = $teacher->getcollege('CHS');
$COED = $teacher->getcollege('COED');
$CAS = $teacher->getcollege('CAS');
$CME = $teacher->getcollege('CME');
$CHMT = $teacher->getcollege('CHMT');

$search = isset($_POST['search']) ? $_POST['search'] : null;
$teacher = $teacher->getteacher($search);

?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <small>INSTRUCTOR LIST</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                    </li>
                    <li class="active">
                        Instructor List
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="form-inline form-padding">
                    <form action="teacherlist.php" method="post">
                        <input type="text" class="form-control" name="search" placeholder="Search Instructor...">
                        <button type="submit" name="submitsearch" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addteacher"><i class="fa fa-user"></i> Add Instructor</button>
                    </form>
                </div>
            </div>
        </div>
        <!--/.row -->
        <hr />
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
                        } else if ($r == 'has already an account.(Instructor ID conflict)') {
                            $class = 'danger';
                        } else {
                            $class = 'hide';
                        }
                        ?>
                    <div class="alert alert-<?php echo $class ?> <?php echo $classs; ?>">
                        <strong>Instructor <?php echo $r; ?>!</strong>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <!-- tab list -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#data1" role="tab" data-toggle="tab">ALL</a></li>
                    <li><a href="#data2" role="tab" data-toggle="tab">CCS</a></li>
                    <li><a href="#data3" role="tab" data-toggle="tab">COA</a></li>
                    <li><a href="#data4" role="tab" data-toggle="tab">CBA</a></li>
                    <li><a href="#data5" role="tab" data-toggle="tab">CHS</a></li>
                    <li><a href="#data6" role="tab" data-toggle="tab">COED</a></li>
                    <li><a href="#data7" role="tab" data-toggle="tab">CAS</a></li>
                    <li><a href="#data8" role="tab" data-toggle="tab">CME</a></li>
                    <li><a href="#data9" role="tab" data-toggle="tab">CHMT</a></li>
                </ul>
                <!-- tab list -->

                <div class="tab-content">
                    <div class="tab-pane active" id="data1">
                        <br />
                        <!-- table -->
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Instructor ID</th>
                                        <th>First name</th>
                                        <th>Middle name</th>
                                        <th>Last name</th>
                                        <th>College</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $c = 1; ?>
                                    <?php while ($row = mysql_fetch_array($teacher)) : ?>
                                        <tr>
                                            <td><?php echo $c; ?></td>
                                            <td><a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>"><?php echo $row['teachid']; ?></a></td>
                                            <td><?php echo $row['fname']; ?></td>
                                            <td><?php echo $row['midname']; ?></td>
                                            <td><?php echo $row['lname']; ?></td>
                                            <td><?php echo $row['college']; ?></td>
                                            <td class="text-center">
                                                <a href="data/settings_model.php?q=addaccount&level=teacher&id=<?php echo $row['id'] ?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>&nbsp;
                                                <a href="teacherload.php?id=<?php echo $row['id']; ?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                                <a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                        </tr>
                                        <?php $c++; ?>
                                    <?php endwhile; ?>
                                    <?php if (mysql_num_rows($teacher) < 1) : ?>
                                        <tr>
                                            <td colspan="12" class="bg-danger text-danger text-center">*** EMPTY ***</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- table -->
                    <!-- table -->
                    <div class="tab-pane" id="data2">
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Instructor ID</th>
                                        <th>First name</th>
                                        <th>Middle name</th>
                                        <th>Last name</th>
                                        <th>College</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $c = 1; ?>
                                    <?php while ($row = mysql_fetch_array($CCS)) : ?>
                                        <tr>
                                            <td><?php echo $c; ?></td>
                                            <td><a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>"><?php echo $row['teachid']; ?></a></td>
                                            <td><?php echo $row['fname']; ?></td>
                                            <td><?php echo $row['midname']; ?></td>
                                            <td><?php echo $row['lname']; ?></td>
                                            <td><?php echo $row['college']; ?></td>
                                            <td class="text-center">
                                                <a href="data/settings_model.php?q=addaccount&level=teacher&id=<?php echo $row['id'] ?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>&nbsp;
                                                <a href="teacherload.php?id=<?php echo $row['id']; ?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                                <a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                        </tr>
                                        <?php $c++; ?>
                                    <?php endwhile; ?>
                                    <?php if (mysql_num_rows($CCS) < 1) : ?>
                                        <tr>
                                            <td colspan="12" class="bg-danger text-danger text-center">*** EMPTY ***</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- table -->
                    <!-- table -->
                    <div class="tab-pane" id="data3">
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Instructor ID</th>
                                        <th>First name</th>
                                        <th>Middle name</th>
                                        <th>Last name</th>
                                        <th>College</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $c = 1; ?>
                                    <?php while ($row = mysql_fetch_array($COA)) : ?>
                                        <tr>
                                            <td><?php echo $c; ?></td>
                                            <td><a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>"><?php echo $row['teachid']; ?></a></td>
                                            <td><?php echo $row['fname']; ?></td>
                                            <td><?php echo $row['midname']; ?></td>
                                            <td><?php echo $row['lname']; ?></td>
                                            <td><?php echo $row['college']; ?></td>
                                            <td class="text-center">
                                                <a href="data/settings_model.php?q=addaccount&level=teacher&id=<?php echo $row['id'] ?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>&nbsp;
                                                <a href="teacherload.php?id=<?php echo $row['id']; ?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                                <a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                        </tr>
                                        <?php $c++; ?>
                                    <?php endwhile; ?>
                                    <?php if (mysql_num_rows($COA) < 1) : ?>
                                        <tr>
                                            <td colspan="12" class="bg-danger text-danger text-center">*** EMPTY ***</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- table -->
                    <!-- table -->
                    <div class="tab-pane" id="data4">
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Instructor ID</th>
                                        <th>First name</th>
                                        <th>Middle name</th>
                                        <th>Last name</th>
                                        <th>College</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $c = 1; ?>
                                    <?php while ($row = mysql_fetch_array($CBA)) : ?>
                                        <tr>
                                            <td><?php echo $c; ?></td>
                                            <td><a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>"><?php echo $row['teachid']; ?></a></td>
                                            <td><?php echo $row['fname']; ?></td>
                                            <td><?php echo $row['midname']; ?></td>
                                            <td><?php echo $row['lname']; ?></td>
                                            <td><?php echo $row['college']; ?></td>
                                            <td class="text-center">
                                                <a href="data/settings_model.php?q=addaccount&level=teacher&id=<?php echo $row['id'] ?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>&nbsp;
                                                <a href="teacherload.php?id=<?php echo $row['id']; ?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                                <a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                        </tr>
                                        <?php $c++; ?>
                                    <?php endwhile; ?>
                                    <?php if (mysql_num_rows($CBA) < 1) : ?>
                                        <tr>
                                            <td colspan="12" class="bg-danger text-danger text-center">*** EMPTY ***</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- table -->
                    <!-- table -->
                    <div class="tab-pane" id="data5">
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Instructor ID</th>
                                        <th>First name</th>
                                        <th>Middle name</th>
                                        <th>Last name</th>
                                        <th>College</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $c = 1; ?>
                                    <?php while ($row = mysql_fetch_array($CHS)) : ?>
                                        <tr>
                                            <td><?php echo $c; ?></td>
                                            <td><a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>"><?php echo $row['teachid']; ?></a></td>
                                            <td><?php echo $row['fname']; ?></td>
                                            <td><?php echo $row['midname']; ?></td>
                                            <td><?php echo $row['lname']; ?></td>
                                            <td><?php echo $row['college']; ?></td>
                                            <td class="text-center">
                                                <a href="data/settings_model.php?q=addaccount&level=teacher&id=<?php echo $row['id'] ?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>&nbsp;
                                                <a href="teacherload.php?id=<?php echo $row['id']; ?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                                <a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                        </tr>
                                        <?php $c++; ?>
                                    <?php endwhile; ?>
                                    <?php if (mysql_num_rows($CHS) < 1) : ?>
                                        <tr>
                                            <td colspan="12" class="bg-danger text-danger text-center">*** EMPTY ***</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- table -->
                    <!-- table -->
                    <div class="tab-pane" id="data6">
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Instructor ID</th>
                                        <th>First name</th>
                                        <th>Middle name</th>
                                        <th>Last name</th>
                                        <th>College</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $c = 1; ?>
                                    <?php while ($row = mysql_fetch_array($COED)) : ?>
                                        <tr>
                                            <td><?php echo $c; ?></td>
                                            <td><a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>"><?php echo $row['teachid']; ?></a></td>
                                            <td><?php echo $row['fname']; ?></td>
                                            <td><?php echo $row['midname']; ?></td>
                                            <td><?php echo $row['lname']; ?></td>
                                            <td><?php echo $row['college']; ?></td>
                                            <td class="text-center">
                                                <a href="data/settings_model.php?q=addaccount&level=teacher&id=<?php echo $row['id'] ?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>&nbsp;
                                                <a href="teacherload.php?id=<?php echo $row['id']; ?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                                <a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                        </tr>
                                        <?php $c++; ?>
                                    <?php endwhile; ?>
                                    <?php if (mysql_num_rows($COED) < 1) : ?>
                                        <tr>
                                            <td colspan="12" class="bg-danger text-danger text-center">*** EMPTY ***</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- table -->
                    <!-- table -->
                    <div class="tab-pane" id="data7">
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Instructor ID</th>
                                        <th>First name</th>
                                        <th>Middle name</th>
                                        <th>Last name</th>
                                        <th>College</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $c = 1; ?>
                                    <?php while ($row = mysql_fetch_array($CAS)) : ?>
                                        <tr>
                                            <td><?php echo $c; ?></td>
                                            <td><a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>"><?php echo $row['teachid']; ?></a></td>
                                            <td><?php echo $row['fname']; ?></td>
                                            <td><?php echo $row['midname']; ?></td>
                                            <td><?php echo $row['lname']; ?></td>
                                            <td><?php echo $row['college']; ?></td>
                                            <td class="text-center">
                                                <a href="data/settings_model.php?q=addaccount&level=teacher&id=<?php echo $row['id'] ?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>&nbsp;
                                                <a href="teacherload.php?id=<?php echo $row['id']; ?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                                <a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                        </tr>
                                        <?php $c++; ?>
                                    <?php endwhile; ?>
                                    <?php if (mysql_num_rows($CAS) < 1) : ?>
                                        <tr>
                                            <td colspan="12" class="bg-danger text-danger text-center">*** EMPTY ***</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- table -->
                    <!-- table -->
                    <div class="tab-pane" id="data8">
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Instructor ID</th>
                                        <th>First name</th>
                                        <th>Middle name</th>
                                        <th>Last name</th>
                                        <th>College</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $c = 1; ?>
                                    <?php while ($row = mysql_fetch_array($CME)) : ?>
                                        <tr>
                                            <td><?php echo $c; ?></td>
                                            <td><a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>"><?php echo $row['teachid']; ?></a></td>
                                            <td><?php echo $row['fname']; ?></td>
                                            <td><?php echo $row['midname']; ?></td>
                                            <td><?php echo $row['lname']; ?></td>
                                            <td><?php echo $row['college']; ?></td>
                                            <td class="text-center">
                                                <a href="data/settings_model.php?q=addaccount&level=teacher&id=<?php echo $row['id'] ?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>&nbsp;
                                                <a href="teacherload.php?id=<?php echo $row['id']; ?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                                <a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                        </tr>
                                        <?php $c++; ?>
                                    <?php endwhile; ?>
                                    <?php if (mysql_num_rows($CME) < 1) : ?>
                                        <tr>
                                            <td colspan="12" class="bg-danger text-danger text-center">*** EMPTY ***</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- table -->
                    <!-- table -->
                    <div class="tab-pane" id="data9">
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Instructor ID</th>
                                        <th>First name</th>
                                        <th>Middle name</th>
                                        <th>Last name</th>
                                        <th>College</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $c = 1; ?>
                                    <?php while ($row = mysql_fetch_array($CHMT)) : ?>
                                        <tr>
                                            <td><?php echo $c; ?></td>
                                            <td><a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>"><?php echo $row['teachid']; ?></a></td>
                                            <td><?php echo $row['fname']; ?></td>
                                            <td><?php echo $row['midname']; ?></td>
                                            <td><?php echo $row['lname']; ?></td>
                                            <td><?php echo $row['college']; ?></td>
                                            <td class="text-center">
                                                <a href="data/settings_model.php?q=addaccount&level=teacher&id=<?php echo $row['id'] ?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>&nbsp;
                                                <a href="teacherload.php?id=<?php echo $row['id']; ?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                                <a href="edit.php?type=teacher&id=<?php echo $row['id'] ?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                        </tr>
                                        <?php $c++; ?>
                                    <?php endwhile; ?>
                                    <?php if (mysql_num_rows($CHMT) < 1) : ?>
                                        <tr>
                                            <td colspan="12" class="bg-danger text-danger text-center">*** EMPTY ***</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- table -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php include('include/modal.php'); ?>
<?php include('include/footer.php'); ?>