<?php
    include('include/header.php');
    include('include/sidebar.php');
    include('data/class_model.php');
    include('data/data_model.php');
    
    $CCS = $class->getcollege('CCS');
    $COA = $class->getcollege('COA');
    $CBA = $class->getcollege('CBA');
    $CHS = $class->getcollege('CHS');
    $COED = $class->getcollege('COED');
    $CAS = $class->getcollege('CAS');
    $CME = $class->getcollege('CME');
    $CHMT = $class->getcollege('CHMT');

    $search = isset($_POST['search']) ? $_POST['search']: null;
    $class = $class->getclass($search);
?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <small>CLASS INFORMATION</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                    </li>
                    <li class="active">
                        Class
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="form-inline form-padding">
                    <form action="class.php" method="post">
                        <input type="text" class="form-control" name="search" placeholder="Search Class Info...">
                        <button type="submit" name="submitsearch" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addclass">Add Class</button>
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
                            $classs='success';
                        }else if($r=='updated'){
                            $classs='info';
                        }else if($r=='deleted'){
                            $classs='danger';
                        }else{
                            $classs='hide';
                        }
                    ?>
                    <div class="alert alert-<?php echo $classs?> <?php echo $classs; ?>">
                        <strong>Class info <?php echo $r; ?>!</strong>
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
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Merge Subject</th>
                                <th>Title</th>
                                <th class="text-center">Course</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">S.Y.</th>
                                <th class="text-center">Instructor</th>
                                <th class="text-center">Students</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysqli_fetch_array($class)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <?php $title = $data->getsubjectbycode($row['subject']); ?>
                                    <?php $mergetitle = $data->getsubjectbycode($row['mergesubject']); ?>
                                    <?php $stype = $data->getsubjectbycode($row['subject']); ?>
                                    <td><?php echo $row['subject'];?></td>
                                    <td><?php echo $title['title'];?></td>
                                    <td><?php echo $row['mergesubject'];?></td>
                                    <td><?php echo $mergetitle['title'];?></td>
                                    <td class="text-center"><?php echo $row['course'].' '.$row['year'].' - '.$row['section'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['sem'];?></td>
                                    <td class="text-center"><?php echo $row['SY'];?></td>
                                    <td class="text-center"><a href="classteacher.php?classid=<?php echo $row['id'];?>&teacherid=0<?php echo $row['teacher'];?>" title="update teacher">Assign</a></td>
                                    <?php if($stype['type'] == 'Lec-Lab'): ?>
                                    <td class="text-center"><a href="classstudent.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php elseif($stype['type'] == 'Lecture'): ?>
                                    <td class="text-center"><a href="classstudentlec.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php else: ?>
                                    <td class="text-center"><a href="classstudentlab.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <a href="edit.php?type=class&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysqli_num_rows($class) < 1): ?>
                                <tr>
                                    <td colspan="12" class="bg-danger text-danger text-center">*** EMPTY ***</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>       
            </div>
            <div class="tab-pane" id="data2">
                    <br />
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Merge Subject</th>
                                <th>Title</th>
                                <th class="text-center">Course</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">S.Y.</th>
                                <th class="text-center">Instructor</th>
                                <th class="text-center">Students</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysqli_fetch_array($CCS)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <?php $title = $data->getsubjectbycode($row['subject']); ?>
                                    <?php $mergetitle = $data->getsubjectbycode($row['mergesubject']); ?>
                                    <?php $stype = $data->getsubjectbycode($row['subject']); ?>
                                    <td><?php echo $row['subject'];?></td>
                                    <td><?php echo $title['title'];?></td>
                                    <td><?php echo $row['mergesubject'];?></td>
                                    <td><?php echo $mergetitle['title'];?></td>
                                    <td class="text-center"><?php echo $row['course'].' '.$row['year'].' - '.$row['section'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['sem'];?></td>
                                    <td class="text-center"><?php echo $row['SY'];?></td>
                                    <td class="text-center"><a href="classteacher.php?classid=<?php echo $row['id'];?>&teacherid=0<?php echo $row['teacher'];?>" title="update teacher">Assign</a></td>
                                    <?php if($stype['type'] == 'Lec-Lab'): ?>
                                    <td class="text-center"><a href="classstudent.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php elseif($stype['type'] == 'Lecture'): ?>
                                    <td class="text-center"><a href="classstudentlec.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php else: ?>
                                    <td class="text-center"><a href="classstudentlab.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <a href="edit.php?type=class&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysqli_num_rows($CCS) < 1): ?>
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
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Merge Subject</th>
                                <th>Title</th>
                                <th class="text-center">Course</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">S.Y.</th>
                                <th class="text-center">Instructor</th>
                                <th class="text-center">Students</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysqli_fetch_array($COA)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <?php $title = $data->getsubjectbycode($row['subject']); ?>
                                    <?php $mergetitle = $data->getsubjectbycode($row['mergesubject']); ?>
                                    <?php $stype = $data->getsubjectbycode($row['subject']); ?>
                                    <td><?php echo $row['subject'];?></td>
                                    <td><?php echo $title['title'];?></td>
                                    <td><?php echo $row['mergesubject'];?></td>
                                    <td><?php echo $mergetitle['title'];?></td>
                                    <td class="text-center"><?php echo $row['course'].' '.$row['year'].' - '.$row['section'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['sem'];?></td>
                                    <td class="text-center"><?php echo $row['SY'];?></td>
                                    <td class="text-center"><a href="classteacher.php?classid=<?php echo $row['id'];?>&teacherid=0<?php echo $row['teacher'];?>" title="update teacher">Assign</a></td>
                                    <?php if($stype['type'] == 'Lec-Lab'): ?>
                                    <td class="text-center"><a href="classstudent.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php elseif($stype['type'] == 'Lecture'): ?>
                                    <td class="text-center"><a href="classstudentlec.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php else: ?>
                                    <td class="text-center"><a href="classstudentlab.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <a href="edit.php?type=class&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysqli_num_rows($COA) < 1): ?>
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
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Merge Subject</th>
                                <th>Title</th>
                                <th class="text-center">Course</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">S.Y.</th>
                                <th class="text-center">Instructor</th>
                                <th class="text-center">Students</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysqli_fetch_array($CBA)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <?php $title = $data->getsubjectbycode($row['subject']); ?>
                                    <?php $mergetitle = $data->getsubjectbycode($row['mergesubject']); ?>
                                    <?php $stype = $data->getsubjectbycode($row['subject']); ?>
                                    <td><?php echo $row['subject'];?></td>
                                    <td><?php echo $title['title'];?></td>
                                    <td><?php echo $row['mergesubject'];?></td>
                                    <td><?php echo $mergetitle['title'];?></td>
                                    <td class="text-center"><?php echo $row['course'].' '.$row['year'].' - '.$row['section'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['sem'];?></td>
                                    <td class="text-center"><?php echo $row['SY'];?></td>
                                    <td class="text-center"><a href="classteacher.php?classid=<?php echo $row['id'];?>&teacherid=0<?php echo $row['teacher'];?>" title="update teacher">Assign</a></td>
                                    <?php if($stype['type'] == 'Lec-Lab'): ?>
                                    <td class="text-center"><a href="classstudent.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php elseif($stype['type'] == 'Lecture'): ?>
                                    <td class="text-center"><a href="classstudentlec.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php else: ?>
                                    <td class="text-center"><a href="classstudentlab.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <a href="edit.php?type=class&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysqli_num_rows($CBA) < 1): ?>
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
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Merge Subject</th>
                                <th>Title</th>
                                <th class="text-center">Course</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">S.Y.</th>
                                <th class="text-center">Instructor</th>
                                <th class="text-center">Students</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysqli_fetch_array($CHS)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <?php $title = $data->getsubjectbycode($row['subject']); ?>
                                    <?php $mergetitle = $data->getsubjectbycode($row['mergesubject']); ?>
                                    <?php $stype = $data->getsubjectbycode($row['subject']); ?>
                                    <td><?php echo $row['subject'];?></td>
                                    <td><?php echo $title['title'];?></td>
                                    <td><?php echo $row['mergesubject'];?></td>
                                    <td><?php echo $mergetitle['title'];?></td>
                                    <td class="text-center"><?php echo $row['course'].' '.$row['year'].' - '.$row['section'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['sem'];?></td>
                                    <td class="text-center"><?php echo $row['SY'];?></td>
                                    <td class="text-center"><a href="classteacher.php?classid=<?php echo $row['id'];?>&teacherid=0<?php echo $row['teacher'];?>" title="update teacher">Assign</a></td>
                                    <?php if($stype['type'] == 'Lec-Lab'): ?>
                                    <td class="text-center"><a href="classstudent.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php elseif($stype['type'] == 'Lecture'): ?>
                                    <td class="text-center"><a href="classstudentlec.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php else: ?>
                                    <td class="text-center"><a href="classstudentlab.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <a href="edit.php?type=class&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysqli_num_rows($CHS) < 1): ?>
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
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Merge Subject</th>
                                <th>Title</th>
                                <th class="text-center">Course</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">S.Y.</th>
                                <th class="text-center">Instructor</th>
                                <th class="text-center">Students</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysqli_fetch_array($COED)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <?php $title = $data->getsubjectbycode($row['subject']); ?>
                                    <?php $mergetitle = $data->getsubjectbycode($row['mergesubject']); ?>
                                    <?php $stype = $data->getsubjectbycode($row['subject']); ?>
                                    <td><?php echo $row['subject'];?></td>
                                    <td><?php echo $title['title'];?></td>
                                    <td><?php echo $row['mergesubject'];?></td>
                                    <td><?php echo $mergetitle['title'];?></td>
                                    <td class="text-center"><?php echo $row['course'].' '.$row['year'].' - '.$row['section'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['sem'];?></td>
                                    <td class="text-center"><?php echo $row['SY'];?></td>
                                    <td class="text-center"><a href="classteacher.php?classid=<?php echo $row['id'];?>&teacherid=0<?php echo $row['teacher'];?>" title="update teacher">Assign</a></td>
                                    <?php if($stype['type'] == 'Lec-Lab'): ?>
                                    <td class="text-center"><a href="classstudent.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php elseif($stype['type'] == 'Lecture'): ?>
                                    <td class="text-center"><a href="classstudentlec.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php else: ?>
                                    <td class="text-center"><a href="classstudentlab.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <a href="edit.php?type=class&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysqli_num_rows($COED) < 1): ?>
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
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Merge Subject</th>
                                <th>Title</th>
                                <th class="text-center">Course</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">S.Y.</th>
                                <th class="text-center">Instructor</th>
                                <th class="text-center">Students</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysqli_fetch_array($CAS)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <?php $title = $data->getsubjectbycode($row['subject']); ?>
                                    <?php $mergetitle = $data->getsubjectbycode($row['mergesubject']); ?>
                                    <?php $stype = $data->getsubjectbycode($row['subject']); ?>
                                    <td><?php echo $row['subject'];?></td>
                                    <td><?php echo $title['title'];?></td>
                                    <td><?php echo $row['mergesubject'];?></td>
                                    <td><?php echo $mergetitle['title'];?></td>
                                    <td class="text-center"><?php echo $row['course'].' '.$row['year'].' - '.$row['section'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['sem'];?></td>
                                    <td class="text-center"><?php echo $row['SY'];?></td>
                                    <td class="text-center"><a href="classteacher.php?classid=<?php echo $row['id'];?>&teacherid=0<?php echo $row['teacher'];?>" title="update teacher">Assign</a></td>
                                    <?php if($stype['type'] == 'Lec-Lab'): ?>
                                    <td class="text-center"><a href="classstudent.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php elseif($stype['type'] == 'Lecture'): ?>
                                    <td class="text-center"><a href="classstudentlec.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php else: ?>
                                    <td class="text-center"><a href="classstudentlab.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <a href="edit.php?type=class&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysqli_num_rows($CAS) < 1): ?>
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
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Merge Subject</th>
                                <th>Title</th>
                                <th class="text-center">Course</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">S.Y.</th>
                                <th class="text-center">Instructor</th>
                                <th class="text-center">Students</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysqli_fetch_array($CME)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <?php $title = $data->getsubjectbycode($row['subject']); ?>
                                    <?php $mergetitle = $data->getsubjectbycode($row['mergesubject']); ?>
                                    <?php $stype = $data->getsubjectbycode($row['subject']); ?>
                                    <td><?php echo $row['subject'];?></td>
                                    <td><?php echo $title['title'];?></td>
                                    <td><?php echo $row['mergesubject'];?></td>
                                    <td><?php echo $mergetitle['title'];?></td>
                                    <td class="text-center"><?php echo $row['course'].' '.$row['year'].' - '.$row['section'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['sem'];?></td>
                                    <td class="text-center"><?php echo $row['SY'];?></td>
                                    <td class="text-center"><a href="classteacher.php?classid=<?php echo $row['id'];?>&teacherid=0<?php echo $row['teacher'];?>" title="update teacher">Assign</a></td>
                                    <?php if($stype['type'] == 'Lec-Lab'): ?>
                                    <td class="text-center"><a href="classstudent.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php elseif($stype['type'] == 'Lecture'): ?>
                                    <td class="text-center"><a href="classstudentlec.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php else: ?>
                                    <td class="text-center"><a href="classstudentlab.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <a href="edit.php?type=class&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysqli_num_rows($CME) < 1): ?>
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
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Merge Subject</th>
                                <th>Title</th>
                                <th class="text-center">Course</th>
                                <th class="text-center">College</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">S.Y.</th>
                                <th class="text-center">Instructor</th>
                                <th class="text-center">Students</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1; ?>
                            <?php while($row = mysqli_fetch_array($CHMT)): ?>
                                <tr>
                                    <td><?php echo $c;?></td>
                                    <?php $title = $data->getsubjectbycode($row['subject']); ?>
                                    <?php $mergetitle = $data->getsubjectbycode($row['mergesubject']); ?>
                                    <?php $stype = $data->getsubjectbycode($row['subject']); ?>
                                    <td><?php echo $row['subject'];?></td>
                                    <td><?php echo $title['title'];?></td>
                                    <td><?php echo $row['mergesubject'];?></td>
                                    <td><?php echo $mergetitle['title'];?></td>
                                    <td class="text-center"><?php echo $row['course'].' '.$row['year'].' - '.$row['section'];?></td>
                                    <td class="text-center"><?php echo $row['college'];?></td>
                                    <td class="text-center"><?php echo $row['sem'];?></td>
                                    <td class="text-center"><?php echo $row['SY'];?></td>
                                    <td class="text-center"><a href="classteacher.php?classid=<?php echo $row['id'];?>&teacherid=0<?php echo $row['teacher'];?>" title="update teacher">Assign</a></td>
                                    <?php if($stype['type'] == 'Lec-Lab'): ?>
                                    <td class="text-center"><a href="classstudent.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php elseif($stype['type'] == 'Lecture'): ?>
                                    <td class="text-center"><a href="classstudentlec.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php else: ?>
                                    <td class="text-center"><a href="classstudentlab.php?classid=<?php echo $row['id'];?>" title="update students" title="add student">Assign</a></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <a href="edit.php?type=class&id=<?php echo $row['id']?>" title="update class"><i class="fa fa-edit fa-2x text-primary"></i></a>
                                </tr>
                            <?php $c++; ?>
                            <?php endwhile; ?>
                            <?php if(mysqli_num_rows($CHMT) < 1): ?>
                                <tr>
                                    <td colspan="12" class="bg-danger text-danger text-center">*** EMPTY ***</td>
                                </tr>
                            <?php endif; ?>
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
<?php include('include/modal.php'); ?>
<?php include('include/footer.php'); ?>
