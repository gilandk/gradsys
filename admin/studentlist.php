<?php
    include('include/header.php');
    include('include/sidebar.php');
    include('data/student_model.php');

    $CCS = $student->getcollege('CCS');
    $COA = $student->getcollege('COA');
    $CBA = $student->getcollege('CBA');
    $CHS = $student->getcollege('CHS');
    $COED = $student->getcollege('COED');
    $CAS = $student->getcollege('CAS');
    $CME = $student->getcollege('CME');
    $CHMT = $student->getcollege('CHMT');

    $search = isset($_POST['search']) ? $_POST['search']: null;
    $student = $student->getstudent($search);
?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <small>STUDENT'S LIST</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                    </li>
                    <li class="active">
                        Student's List
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="form-inline form-padding">
                    <form action="studentlist.php" method="post">
                        <input type="text" class="form-control" name="search" placeholder="Search Students...">
                        <button type="submit" name="submitsearch" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addstudent"><i class="fa fa-user"></i> Add Student</button>
                    </form>
                </div>
            </div>
        </div>
        <!--/.row -->
        <hr />
        <div class="row">
            <div class="col-lg-12">

                <?php if(isset($_GET['r'])): ?>
                    <?php
                        $r = $_GET['r'];
                        if($r=='added'){
                            $class='success';
                        }else if($r=='updated'){
                            $class='info';
                        }else if($r=='deleted'){
                            $class='danger';
                        }else if($r=='added an account'){
                            $class='success';
                        }else if($r=='has already an account'){
                            $class='danger';
                        }else if($r=='has already an account.(Student ID conflict)'){
                            $class='danger';
                        }else{
                            $class='hide';
                        }
                    ?>
                    
                    <div class="alert alert-<?php echo $class?> <?php echo $classs; ?>">
                        <strong>Student <?php echo $r; ?>!</strong>
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
                                <th>Student ID</th>
                                <th>First name</th>
                                <th>Middle name</th>
                                <th>Last name</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Course/Year</th>
                                <th class="text-center">Section</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysql_fetch_array($student)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <td><a href="edit.php?type=student&id=<?php echo $row['id']?>"><?php echo $row['studid'];?></a></td>
                                    <td><?php echo $row['fname'];?></td>
                                    <td><?php echo $row['midname'];?></td>
                                    <td><?php echo $row['lname'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['course'].'&nbsp;'.$row['year'];?>
                                    <td class="text-center"><?php echo $row['section'];?></td>
                                    <td class="text-center">
                                        <a href="data/settings_model.php?q=addaccount&level=student&id=<?php echo $row['id']?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>
                                        <a href="studentsubject.php?id=<?php echo $row['id'];?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                        <a href="edit.php?type=student&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysql_num_rows($student) < 1): ?>
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
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>First name</th>
                                <th>Middle name</th>
                                <th>Last name</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Course/Year</th>
                                <th class="text-center">Section</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysql_fetch_array($CCS)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <td><a href="edit.php?type=student&id=<?php echo $row['id']?>"><?php echo $row['studid'];?></a></td>
                                    <td><?php echo $row['fname'];?></td>
                                    <td><?php echo $row['midname'];?></td>
                                    <td><?php echo $row['lname'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['course'].'&nbsp;'.$row['year'];?>
                                    <td class="text-center"><?php echo $row['section'];?></td>
                                    <td class="text-center">
                                        <a href="data/settings_model.php?q=addaccount&level=student&id=<?php echo $row['id']?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>
                                        <a href="studentsubject.php?id=<?php echo $row['id'];?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                        <a href="edit.php?type=student&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysql_num_rows($CCS) < 1): ?>
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
                                <th>Student ID</th>
                                <th>First name</th>
                                <th>Middle name</th>
                                <th>Last name</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Course/Year</th>
                                <th class="text-center">Section</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysql_fetch_array($COA)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <td><a href="edit.php?type=student&id=<?php echo $row['id']?>"><?php echo $row['studid'];?></a></td>
                                    <td><?php echo $row['fname'];?></td>
                                    <td><?php echo $row['midname'];?></td>
                                    <td><?php echo $row['lname'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['course'].'&nbsp;'.$row['year'];?>
                                    <td class="text-center"><?php echo $row['section'];?></td>
                                    <td class="text-center">
                                        <a href="data/settings_model.php?q=addaccount&level=student&id=<?php echo $row['id']?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>
                                        <a href="studentsubject.php?id=<?php echo $row['id'];?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                        <a href="edit.php?type=student&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysql_num_rows($COA) < 1): ?>
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
                                <th>Student ID</th>
                                <th>First name</th>
                                <th>Middle name</th>
                                <th>Last name</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Course/Year</th>
                                <th class="text-center">Section</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysql_fetch_array($CBA)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <td><a href="edit.php?type=student&id=<?php echo $row['id']?>"><?php echo $row['studid'];?></a></td>
                                    <td><?php echo $row['fname'];?></td>
                                    <td><?php echo $row['midname'];?></td>
                                    <td><?php echo $row['lname'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['course'].'&nbsp;'.$row['year'];?>
                                    <td class="text-center"><?php echo $row['section'];?></td>
                                    <td class="text-center">
                                        <a href="data/settings_model.php?q=addaccount&level=student&id=<?php echo $row['id']?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>
                                        <a href="studentsubject.php?id=<?php echo $row['id'];?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                        <a href="edit.php?type=student&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysql_num_rows($CBA) < 1): ?>
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
                                <th>Student ID</th>
                                <th>First name</th>
                                <th>Middle name</th>
                                <th>Last name</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Course/Year</th>
                                <th class="text-center">Section</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysql_fetch_array($CHS)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <td><a href="edit.php?type=student&id=<?php echo $row['id']?>"><?php echo $row['studid'];?></a></td>
                                    <td><?php echo $row['fname'];?></td>
                                    <td><?php echo $row['midname'];?></td>
                                    <td><?php echo $row['lname'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['course'].'&nbsp;'.$row['year'];?>
                                    <td class="text-center"><?php echo $row['section'];?></td>
                                    <td class="text-center">
                                        <a href="data/settings_model.php?q=addaccount&level=student&id=<?php echo $row['id']?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>
                                        <a href="studentsubject.php?id=<?php echo $row['id'];?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                        <a href="edit.php?type=student&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysql_num_rows($CHS) < 1): ?>
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
                                <th>Student ID</th>
                                <th>First name</th>
                                <th>Middle name</th>
                                <th>Last name</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Course/Year</th>
                                <th class="text-center">Section</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysql_fetch_array($COED)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <td><a href="edit.php?type=student&id=<?php echo $row['id']?>"><?php echo $row['studid'];?></a></td>
                                    <td><?php echo $row['fname'];?></td>
                                    <td><?php echo $row['midname'];?></td>
                                    <td><?php echo $row['lname'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['course'].'&nbsp;'.$row['year'];?>
                                    <td class="text-center"><?php echo $row['section'];?></td>
                                    <td class="text-center">
                                        <a href="data/settings_model.php?q=addaccount&level=student&id=<?php echo $row['id']?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>
                                        <a href="studentsubject.php?id=<?php echo $row['id'];?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                        <a href="edit.php?type=student&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysql_num_rows($COED) < 1): ?>
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
                                <th>Student ID</th>
                                <th>First name</th>
                                <th>Middle name</th>
                                <th>Last name</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Course/Year</th>
                                <th class="text-center">Section</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysql_fetch_array($CAS)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <td><a href="edit.php?type=student&id=<?php echo $row['id']?>"><?php echo $row['studid'];?></a></td>
                                    <td><?php echo $row['fname'];?></td>
                                    <td><?php echo $row['midname'];?></td>
                                    <td><?php echo $row['lname'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['course'].'&nbsp;'.$row['year'];?>
                                    <td class="text-center"><?php echo $row['section'];?></td>
                                    <td class="text-center">
                                        <a href="data/settings_model.php?q=addaccount&level=student&id=<?php echo $row['id']?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>
                                        <a href="studentsubject.php?id=<?php echo $row['id'];?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                        <a href="edit.php?type=student&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysql_num_rows($CAS) < 1): ?>
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
                                <th>Student ID</th>
                                <th>First name</th>
                                <th>Middle name</th>
                                <th>Last name</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Course/Year</th>
                                <th class="text-center">Section</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysql_fetch_array($CME)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <td><a href="edit.php?type=student&id=<?php echo $row['id']?>"><?php echo $row['studid'];?></a></td>
                                    <td><?php echo $row['fname'];?></td>
                                    <td><?php echo $row['midname'];?></td>
                                    <td><?php echo $row['lname'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['course'].'&nbsp;'.$row['year'];?>
                                    <td class="text-center"><?php echo $row['section'];?></td>
                                    <td class="text-center">
                                        <a href="data/settings_model.php?q=addaccount&level=student&id=<?php echo $row['id']?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>
                                        <a href="studentsubject.php?id=<?php echo $row['id'];?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                        <a href="edit.php?type=student&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysql_num_rows($CME) < 1): ?>
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
                                <th>Student ID</th>
                                <th>First name</th>
                                <th>Middle name</th>
                                <th>Last name</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Course/Year</th>
                                <th class="text-center">Section</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysql_fetch_array($CHMT)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <td><a href="edit.php?type=student&id=<?php echo $row['id']?>"><?php echo $row['studid'];?></a></td>
                                    <td><?php echo $row['fname'];?></td>
                                    <td><?php echo $row['midname'];?></td>
                                    <td><?php echo $row['lname'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['course'].'&nbsp;'.$row['year'];?>
                                    <td class="text-center"><?php echo $row['section'];?></td>
                                    <td class="text-center">
                                        <a href="data/settings_model.php?q=addaccount&level=student&id=<?php echo $row['id']?>" class="confirmacc"><i class="fa fa-key fa-2x text-warning"></i></a>
                                        <a href="studentsubject.php?id=<?php echo $row['id'];?>" title="Update Subject"><i class="fa fa-bar-chart-o fa-2x text-success"></i></a> &nbsp;
                                        <a href="edit.php?type=student&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysql_num_rows($CHMT) < 1): ?>
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
