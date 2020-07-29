<?php
include('include/header.php');
include('include/sidebar.php');
include('data/student_model.php');

$classid = isset($_GET['classid']) ? $_GET['classid'] : null;
$studid = isset($_GET['studid']) ? $_GET['studid'] : null;
$studentgrade = $student->getstudentgradelab($studid, $classid);
$mystudent = $student->getstudentbyid($studid);
?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <small>LABORATORY</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                    </li>
                    <li>
                        <a href="subject.php">My Subject</a>
                    </li>
                    <li>
                        <a href="student.php?classid=<?php echo $classid ?>">My Students</a>
                    </li>
                    <li class="active">
                        Laboratory
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- START GRADES -->
        <div class="row">
            <div class="col-lg-12">
                <?php foreach ($mystudent as $row) : ?>
                    <h4>Instructor ID : <?php echo $row['studid']; ?></h4>
                    <h4>Name : <?php echo $row['fname'] . ' ' . $row['midname'] . ' ' . $row['lname']; ?></h4>
                    <hr />
                <?php endforeach; ?>
                <?php if (isset($_GET['status'])) : ?>
                    <?php if ($_GET['status'] == 1) : ?>
                        <div class="alert alert-success">
                            <strong>Done!</strong>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr class="bg-primary">
                            <td><strong>Prelim</strong></td>
                            <td><strong>Midterm</strong></td>
                            <td><strong>Semi-Final</strong></td>
                            <td><strong>Final</strong></td>
                            <td><strong>FINAL GRADE</strong></td>
                            <td><strong>EQUIVALENT</strong></td>
                            <td><strong>REMARKS</strong></td>
                            <td class="text-center"><strong>Update Grades</strong></td>
                        </tr>
                        <?php foreach ($mystudent as $row) : ?>
                            <tr class="bg-info">
                                <td><?php echo $studentgrade['prelim']; ?></td>
                                <td><?php echo $studentgrade['midterm']; ?></td>
                                <td><?php echo $studentgrade['semifinal']; ?></td>
                                <td><?php echo $studentgrade['final']; ?></td>
                                <td><?php echo $studentgrade['total']; ?></td>
                                <?php
                                    if ($studentgrade['eqtotal'] <= 3.0 && ($studentgrade['eqtotal'] >= 1.0)) {
                                        $class = 'text-success';
                                        $remarks = "PASSED";
                                    } elseif ($studentgrade['eqtotal'] >= 3.0 && ($studentgrade['eqtotal'] <= 5.0)) {
                                        $class = 'text-danger';
                                        $remarks = "FAILED";
                                    } else {
                                        $class = 'text-danger';
                                        $remarks = "NO GRADE";
                                    }

                                    ?>
                                <td class="<?php echo $class; ?>"><?php echo $studentgrade['eqtotal']; ?></td>
                                <td class="<?php echo $class; ?>"><?php echo $remarks; ?></td>
                                <td style="text-align:center;padding:2px"><button type="submit" class="btn btn-primary" onclick="submitForms()">Save</button> </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

     
                <!-- END GRADE -->
                <!-- START PRELIM -->
                <div class="col-lg-3 col-md-2">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bar-chart-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $studentgrade['prelim']; ?></div>
                                    <div>PRELIM</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form action="data/labgrade_model.php?term=1&studid=<?php echo $studid; ?>&classid=<?php echo $classid; ?>" method="POST" id="grades">
                                <div class="form-group">
                                    <strong>Attendance</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['att1']; ?>" name="att1" />
                                </div>
                                
                                <div class="panel panel-primary">
                                <div class="panel-body">
                                
                                <?php if ($studentgrade['cstandlab1'] == 0 ){
                                    $dis_p = "readonly";
                                    $csp = 'color:#e32214';
                                }
                                else {
                                    $dis_p = "";
                                }
                                ?>
                            
                                <strong style="<?php echo $csp; ?>">Class Standing</strong><br>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-on</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['hon1']; ?>" name="hon1"  <?php echo $dis_p; ?>/>
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Case Study</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['cstudy1']; ?>" name="cstudy1"  <?php echo $dis_p; ?>/>
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Activity</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['act1']; ?>" name="act1"  <?php echo $dis_p; ?>/>
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-on Exam</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['hexam1']; ?>" name="hexam1" <?php echo $dis_p; ?> />
                                </div>
                                
                                </div>
                                </div>
                                <?php
                                if ($studentgrade['cproject1'] == 0) {
                                    $disp1 = "readonly";
                                    $ppcolor = 'color:#e32214';
                                } else {
                                    $disp1 = "";
                                }
                                ?>
                                <div class="form-group">
                                    <strong style="<?php echo $ppcolor; ?>">Project</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['project1']; ?>" name="project1" <?php echo $disp1; ?>/>
                                </div>
                            
                        </div>
                    </div>
                </div>
                <!-- END Prelim -->

                <!-- START MIDTERM -->
                <div class="col-lg-3 col-md-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bar-chart-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $studentgrade['midterm']; ?></div>
                                    <div>MIDTERM</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                                <div class="form-group">
                                    <strong>Attendance</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['att2']; ?>" name="att2" />
                                </div>
                             
                                <div class="panel panel-primary">
                                <div class="panel-body">

                                <?php if ($studentgrade['cstandlab2'] == 0 ){
                                    $dis_m = "readonly";
                                    $csm = 'color:#e32214';
                                }
                                else {
                                    $dis_m = "";
                                }
                                ?>

                                <strong style="<?php echo $csm; ?>">Class Standing</strong><br>
                               
                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-on</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['hon2']; ?>" name="hon2"  <?php echo $dis_m; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Case Study</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['cstudy2']; ?>" name="cstudy2"  <?php echo $dis_m; ?>/>
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Activity</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['act2']; ?>" name="act2"  <?php echo $dis_m; ?>/>
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-on Exam</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['hexam2']; ?>" name="hexam2"  <?php echo $dis_m; ?> />
                                </div>

                                </div>
                                </div>

                                <?php
                                if ($studentgrade['cproject2'] == 0) {
                                    $disp2 = "readonly";
                                    $mpcolor = 'color:#e32214';
                                } else {
                                    $disp2 = "";
                                }
                                ?>
                                <div class="form-group">
                                    <strong style="<?php echo $mpcolor; ?>">Project</strong><input type="number" min=50 max=100 class="form-control" value="<?php echo $studentgrade['project2']; ?>" name="project2" <?php echo $disp2; ?> />
                                </div>                
                        </div>
                    </div>
                </div>
                <!-- END MIDTERM -->

                <!-- START SEMI FINALS -->
                <div class="col-lg-3 col-md-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bar-chart-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $studentgrade['semifinal']; ?></div>
                                    <div>SEMI-FINAL</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                                <div class="form-group">
                                    <strong>Attendance</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['att3']; ?>" name="att3" />
                                </div>

                                <div class="panel panel-primary">
                                <div class="panel-body">

                                <?php if ($studentgrade['cstandlab3'] == 0 ){
                                    $dis_sf = "readonly";
                                    $cssf = 'color:#e32214';
                                }
                                else {
                                    $dis_sf = "";
                                }
                                ?>

                                <strong style="<?php echo $cssf; ?>">Class Standing</strong><br>
                                
                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-on</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['hon3']; ?>" name="hon3" <?php echo $dis_sf; ?>/>
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Case Study</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['cstudy3']; ?>" name="cstudy3" <?php echo $dis_sf; ?>/>
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Activity</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['act3']; ?>" name="act3" <?php echo $dis_sf; ?>/>
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-on Exam</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['hexam3']; ?>" name="hexam3" <?php echo $dis_sf; ?> />
                                </div>

                                </div>
                                </div>

                                <?php
                                if ($studentgrade['cproject3'] == 0) {
                                    $disp3 = "readonly";
                                    $sfpcolor = 'color:#e32214';
                                } else {
                                    $disp3 = "";
                                }
                                ?>
                                <div class="form-group">
                                    <strong style="<?php echo $sfpcolor; ?>">Project</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['project3']; ?>" name="project3" <?php echo $disp3; ?>/>
                                </div>                
                        </div>
                    </div>
                </div>

                <!-- END SEMI FINALS -->
                <!-- START FINALS -->
                <div class="col-lg-3 col-md-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bar-chart-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $studentgrade['final']; ?></div>
                                    <div>FINAL</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                                <div class="form-group">
                                    <strong>Attendance</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['att4']; ?>" name="att4" />
                                </div>

                                <div class="panel panel-primary">
                                <div class="panel-body">

                                <?php if ($studentgrade['cstandlab4'] == 0 ){
                                    $dis_f = "readonly";
                                    $csf = 'color:#e32214';
                                }
                                else {
                                    $dis_f = "";
                                }
                                ?>

                                <strong style="<?php echo $csf; ?>">Class Standing</strong><br>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-on</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['hon4']; ?>" name="hon4" <?php echo $dis_f; ?>/>
                                </div>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Case Study</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['cstudy4']; ?>" name="cstudy4" <?php echo $dis_f; ?>/>
                                </div>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Activity</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['act4']; ?>" name="act4" <?php echo $dis_f; ?>/>
                                </div>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-on Exam</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['hexam4']; ?>" name="hexam4" <?php echo $dis_f; ?> />
                                </div>

                                </div>
                            </div>
                                <?php
                                if ($studentgrade['cproject4'] == 0) {
                                    $disp4 = "readonly";
                                    $fpcolor = 'color:#e32214';
                                } else {
                                    $disp4 = "";
                                }
                                ?>
                                <div class="form-group">
                                    <strong style="<?php echo $fpcolor; ?>">Project</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $studentgrade['project4']; ?>" name="project4" <?php echo $disp4; ?>/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END FINALS -->


            </div>

            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        <script>
        submitForms = function() {
            document.getElementById("grades").submit();
        }
    </script>
    </div>
    <!-- /#page-wrapper -->
    <?php include('include/footer.php');
