<?php
include('include/header.php');
include('include/sidebar.php');
include('data/subject_model.php');
include('data/student_model.php');

$id = $_SESSION['id'];
$q = "select * from teacher where teachid='$id'";
$r = mysql_query($q);
if ($row = mysql_fetch_array($r)) {
    $teacher = $row['fname'] . ' ' . $row['midname'] . ' ' . $row['lname'];
}

$teacher = $subject->getteacherbyid($id);
$classid = isset($_GET['classid']) ? $_GET['classid'] : null;
$teachid = $_GET['teachid'];

$criteria = $student->getsubjectcriterialab($teachid,$classid);
$mysubject = $subject->getsubjectbyid($classid)

?>


<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <small>Criteria (Laboratory)</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                    </li>
                    <li>
                        <a href="subject.php">My Subject</a>
                    </li>
                    <li class="active">
                        Criteria (Laboratory)
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- START GRADES -->
        <div class="row">
            <div class="col-lg-12">
                <h4>Instructor ID : <?php echo $row['teachid']; ?></h4>
                <h4>Name : <?php echo $row['fname'] . ' ' . $row['midname'] . ' ' . $row['lname']; ?></h4>
                <h4>College : <?php echo $row['college']; ?></h4>
                <hr />

                <?php if (isset($_GET['status'])) : ?>
                    <?php if ($_GET['status'] == 1) : ?>
                        <div class="alert alert-success">
                            <strong>Done!</strong>
                        </div>
                    <?php elseif ($_GET['status'] == 2) : ?>
                        <div class="alert alert-danger">
                            <strong>Invalid! Weight Distribution Criteria</strong>
                        </div>
                    <?php elseif ($_GET['status'] == 3) : ?>
                        <div class="alert alert-danger">
                            <strong>Invalid! PRELIM Criteria</strong>
                        </div>
                    <?php elseif ($_GET['status'] == 4) : ?>
                        <div class="alert alert-danger">
                            <strong>Invalid! MIDTERM Criteria</strong>
                        </div>
                    <?php elseif ($_GET['status'] == 5) : ?>
                        <div class="alert alert-danger">
                            <strong>Invalid! SEMI-FINAL Criteria</strong>
                        </div>
                    <?php elseif ($_GET['status'] == 6) : ?>
                        <div class="alert alert-danger">
                            <strong>Invalid! FINAL Criteria</strong>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr class="bg-primary">
                            <td><strong>Subject</strong></td>
                            <td><strong>Title</strong></td>
                            <td><strong>Merge Subject</strong></td>
                            <td><strong>Title</strong></td>
                            <td><strong>Catergory</strong></td>
                            <td><strong>Subject Type</strong></td>
                            <td><strong>Unit</strong></td>
                        </tr>

                        <?php while ($row = @mysql_fetch_array($mysubject)) : ?>
                            <?php $mysubjectname = $subject->getsubjectbycode($row['subject']); ?>
                            <?php $mergetitle = $subject->getsubjectbycode($row['mergesubject']); ?>
                            <tr class="bg-info">

                                <td><?php echo $row['subject']; ?></td>
                                <td><?php echo $mysubjectname['title']; ?></td>
                                <td><?php echo $row['mergesubject']; ?></td>
                                <td><?php echo $mergetitle['title']; ?></td>
                                <td><?php echo $mysubjectname['category']; ?></td>
                                <td><?php echo $mysubjectname['type']; ?></td>
                                <td><?php echo $mysubjectname['unit']; ?></td>
                            </tr>
                        <?php endwhile; ?>

                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr class="bg-info">
                            <?php
                            if ($criteria['ctotal'] != 100) {
                                $stylewd = 'color:#e32214';
                                $message = "- INVALID TOTAL %";
                            } else {
                                $stylewd = 'color:green';
                                $message = "";
                            }
                            ?>
                            <td style="text-align:center;font-size:20px;"><strong style="font-size:20px;">Weight Distribution Percetage (%): </strong> <b style="<?php echo $stylewd; ?>"><?php echo $criteria['ctotal']; ?>% <?php echo $message; ?></b></td>
                            <td style="text-align:center"><button type="submit" class="btn btn-primary" onclick="submitForms()">Save</button> </td>
                    </table>
                </div>
            </div>

            <!-- START PRELIM -->
            <div class="col-lg-3 col-md-2">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-bar-chart-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <?php
                                if ($criteria['cprelim'] != 100) {
                                    $stylep = 'color:#e32214';
                                    $invalid = "INVALID";
                                } else {
                                    $invalid = "";
                                }
                                ?>
                                <div class="huge" style="<?php echo $stylep; ?>"><?php echo $criteria['cprelim']; ?>% </div>
                                <b style="<?php echo $stylep; ?>"> <?php echo $invalid; ?> </b>
                                <div>PRELIM</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="data/labgrade_model.php?term=5&teachid=<?php echo $teachid; ?>&classid=<?php echo $classid; ?>" method="POST" id="criteria">

                            <div class="form-group">
                                <strong>Weight Distribution: Prelim</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['wdprelim']; ?>" name="wdprelim" />
                            </div>

                            <div class="form-group">
                                <strong>Attendance</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['catt1']; ?>" name="catt1" />
                            </div>

                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div class="form-group">
                                    <?php
                                        if ($criteria['cstandlab1'] == 0) {
                                            $displab = "readonly";
                                        } else {
                                            $displab = "";
                                        }
                                        ?>

                                        <strong>Class Standing</strong><input type="number" class="form-control" value="<?php echo $criteria['cstandlab1']; ?>" name="cstandlab1" />
                                    </div>

                                

                                    <?php
                                    if ($criteria['cstandp1'] != 100) {
                                        $styleplab = 'color:#e32214';
                                    } else {
                                        $styleplab = 'color:green';
                                    }
                                    ?>

                                    <strong>Class Standing % Distribution =</strong> <b style="<?php echo $styleplab ?>"><?php echo $criteria['cstandp1']; ?>%</b><br>

                                    <div class="form-group">
                                        <strong style="font-size:12px;">Hands-On/Practical</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['chon1']; ?>" name="chon1" <?php echo $displab; ?> />
                                    </div>

                                    <div class="form-group">
                                        <strong style="font-size:12px;">Case Study</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['ccstudy1']; ?>" name="ccstudy1" <?php echo $displab; ?> />
                                    </div>

                                    <div class="form-group">
                                        <strong style="font-size:12px;">Activity</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cact1']; ?>" name="cact1" <?php echo $displab; ?> />
                                    </div>

                                    <div class="form-group">
                                        <strong style="font-size:12px;">Hands-on Exam</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['chexam1']; ?>" name="chexam1" <?php echo $displab; ?> />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <strong>Project</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cproject1']; ?>" name="cproject1" />
                            </div>
                    </div>
                </div>
            </div>
            <!-- END Prelim -->

            <!-- START MIDTERM -->
            <div class="col-lg-3 col-md-3">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-bar-chart-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">

                                <?php
                                if ($criteria['cmidterm'] != 100) {
                                    $stylem = 'color:#e32214';
                                    $invalid = "INVALID";
                                } else {
                                    $invalid = "";
                                }
                                ?>

                                <div class="huge" style="<?php echo $stylem; ?>"><?php echo $criteria['cmidterm']; ?>%</div>
                                <b style="<?php echo $stylem; ?>"> <?php echo $invalid; ?> </b>
                                <div>MIDTERM</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <strong>Weight Distribution: Midterm</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['wdmidterm']; ?>" name="wdmidterm" />
                        </div>
                        <div class="form-group">
                            <strong>Attendance</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['catt2']; ?>" name="catt2" />
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-body">

                                <?php
                                if ($criteria['cstandlab2'] == 0) {
                                    $dismlab = "readonly";
                                } else {
                                    $dismlab = "";
                                }
                                ?>

                                <div class="form-group">
                                    <strong>Class Standing</strong><input type="number" class="form-control" value="<?php echo $criteria['cstandlab2']; ?>" name="cstandlab2" />
                                </div>


                                <?php
                                if ($criteria['cstandp2'] != 100) {
                                    $stylemlab = 'color:#e32214';
                                } else {
                                    $stylemlab = 'color:green';
                                }
                                ?>

                                <strong>Class Standing % Distribution =</strong> <b style="<?php echo $stylemlab; ?>"> <?php echo $criteria['cstandp2']; ?>%</b><br>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-On/Practical</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['chon2']; ?>" name="chon2" <?php echo $dismlab; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Case Study</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['ccstudy2']; ?>" name="ccstudy2" <?php echo $dismlab; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Activity</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cact2']; ?>" name="cact2" <?php echo $dismlab; ?> />
                                </div>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-on Exam</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['chexam2']; ?>" name="chexam2" <?php echo $dismlab; ?> />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <strong>Project</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cproject2']; ?>" name="cproject2" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MIDTERM -->

            <!-- START SEMI FINALS -->
            <div class="col-lg-3 col-md-3">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-bar-chart-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <?php
                                if ($criteria['csemifinal'] != 100) {
                                    $stylesf = 'color:#e32214';
                                    $invalid = "INVALID";
                                } else {
                                    $invalid = "";
                                }
                                ?>
                                <div class="huge" style="<?php echo $stylesf; ?>"><?php echo $criteria['csemifinal']; ?>%</div>
                                <b style="<?php echo $stylesf; ?>"> <?php echo $invalid; ?> </b>
                                <div>SEMI-FINALS</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <strong>Weight Distribution: Semi-Finals</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['wdsemifinal']; ?>" name="wdsemifinal" />
                        </div>

                        <div class="form-group">
                            <strong>Attendance</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['catt3']; ?>" name="catt3" />
                        </div>
                        
                        <div class="panel panel-primary">
                            <div class="panel-body">

                                <?php
                                if ($criteria['cstandlab3'] == 0) {
                                    $dissflab = "readonly";
                                } else {
                                    $dissflab = "";
                                }
                                ?>

                                <div class="form-group">
                                    <strong>Class Standing</strong><input type="number" class="form-control" value="<?php echo $criteria['cstandlab3']; ?>" name="cstandlab3" />
                                </div>

                                <?php
                                if ($criteria['cstandp3'] != 100) {
                                    $stylesflab = 'color:#e32214';
                                } else {
                                    $stylesflab = 'color:green';
                                }
                                ?>

                                <strong>Class Standing % Distribution =</strong><b style="<?php echo $stylesflab; ?>"> <?php echo $criteria['cstandp3']; ?>%</b><br>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-On/Practical</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['chon3']; ?>" name="chon3" <?php echo $dissflab; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Case Study</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['ccstudy3']; ?>" name="ccstudy3" <?php echo $dissflab; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Activity</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cact3']; ?>" name="cact3" <?php echo $dissflab; ?> />
                                </div>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-on Exam</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['chexam3']; ?>" name="chexam3" <?php echo $dissflab; ?> />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <strong>Project</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cproject3']; ?>" name="cproject3" />
                        </div>

                    </div>
                </div>
            </div>

            <!-- END SEMI FINALS -->
            <!-- START FINALS -->
            <div class="col-lg-3 col-md-3">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-bar-chart-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <?php
                                if ($criteria['cfinal'] != 100) {
                                    $stylefinal = 'color:#e32214';
                                    $invalid = "INVALID";
                                } else {
                                    $invalid = "";
                                }
                                ?>
                                <div class="huge" style="<?php echo $stylefinal; ?>"><?php echo $criteria['cfinal']; ?>%</div>
                                <b style="<?php echo $stylefinal; ?>"> <?php echo $invalid; ?> </b>
                                <div>FINALS</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <strong>Weight Distribution: Finals</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['wdfinal']; ?>" name="wdfinal" />
                        </div>
                        <div class="form-group">
                            <strong>Attendance</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['catt4']; ?>" name="catt4" />
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-body">

                                <?php
                                if ($criteria['cstandlab4'] == 0) {
                                    $disflab = "readonly";
                                } else {
                                    $disflab = "";
                                }
                                ?>

                                <div class="form-group">
                                    <strong>Class Standing</strong><input type="number" class="form-control" value="<?php echo $criteria['cstandlab4']; ?>" name="cstandlab4" />
                                </div>
                                <?php
                                if ($criteria['cstandp4'] != 100) {
                                    $styleflab = 'color:#e32214';
                                } else {
                                    $styleflab = 'color:green';
                                }
                                ?>
                                <strong>Class Standing % Distribution =</strong><b style="<?php echo $styleflab; ?>"> <?php echo $criteria['cstandp4']; ?>%</b><br>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-On/Practical</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['chon4']; ?>" name="chon4" <?php echo $disflab; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Case Study</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['ccstudy4']; ?>" name="ccstudy4" <?php echo $disflab; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Activity</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cact4']; ?>" name="cact4" <?php echo $disflab; ?> />
                                </div>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Hands-on Exam</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['chexam4']; ?>" name="chexam4" <?php echo $disflab; ?> />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <strong>Project</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cproject4']; ?>" name="cproject4" />
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
            document.getElementById("criteria").submit();
            alert('Criteria Successfully Updated!');
        }
    </script>
</div>
<!-- /#page-wrapper -->
<?php include('include/footer.php');
