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

$criteria = $student->getsubjectcriteria($teachid, $classid);
$mysubject = $subject->getsubjectbyid($classid)


?>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <small>Criteria (Lecture)</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                    </li>
                    <li>
                        <a href="subject.php">My Subject</a>
                    </li>
                    <li class="active">
                        Criteria (Lecture)
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
                        <form action="data/lecgrade_model.php?term=5&teachid=<?php echo $teachid; ?>&classid=<?php echo $classid; ?>" method="POST" id="criteria">
                            <div class="form-group">
                                <strong>Weight Distribution: PRELIM</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['wdprelim']; ?>" name="wdprelim" />
                            </div>
                            <div class="form-group">
                                <strong>Attendance</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['catt1']; ?>" name="catt1" />
                            </div>
                            <div class="panel panel-yellow">
                                <div class="panel-body">

                                    <?php
                                    if ($criteria['cstandlec1'] == 0) {
                                        $displec = "readonly";
                                    } else {
                                        $displec = "";
                                    }
                                    ?>

                                    <div class="form-group">
                                        <strong>Class Standing</strong><input type="number" class="form-control" value="<?php echo $criteria['cstandlec1']; ?>" name="cstandlec1" />
                                    </div>

                                    <?php
                                    if ($criteria['cstandp1'] != 100) {
                                        $styleplec = 'color:#e32214';
                                    } else {
                                        $styleplec = 'color:green';
                                    }
                                    ?>

                                    <strong>Class Standing % Distribution =</strong> <b style="<?php echo $styleplec ?>"><?php echo $criteria['cstandp1']; ?>%</b><br>

                                    <div class="form-group">
                                        <strong style="font-size:12px;">Quizzes</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cquiz1']; ?>" name="cquiz1" <?php echo $displec; ?> />
                                    </div>

                                    <div class="form-group">
                                        <strong style="font-size:12px;">Assignment</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cass1']; ?>" name="cass1" <?php echo $displec; ?> />
                                    </div>

                                    <div class="form-group">
                                        <strong style="font-size:12px;">Recitation</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['crec1']; ?>" name="crec1" <?php echo $displec; ?> />
                                    </div>

                                    <div class="form-group">
                                        <strong style="font-size:12px;">Seatwork</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['csw1']; ?>" name="csw1" <?php echo $displec; ?> />
                                    </div>

                                    <div class="form-group">
                                        <strong style="font-size:12px;">Groupwork</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cgw1']; ?>" name="cgw1" <?php echo $displec; ?> />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <strong>Character</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['ccharc1']; ?>" name="ccharc1" />
                            </div>

                            <div class="form-group">
                                <strong>Project</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cproject1']; ?>" name="cproject1" />
                            </div>

                            <div class="form-group">
                                <strong>Exam</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cexam1']; ?>" name="cexam1" />
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
                            <strong>Weight Distribution: MIDTERM</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['wdmidterm']; ?>" name="wdmidterm" />
                        </div>
                        <div class="form-group">
                            <strong>Attendance</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['catt2']; ?>" name="catt2" />
                        </div>

                        <div class="panel panel-yellow">
                            <div class="panel-body">

                                <?php
                                if ($criteria['cstandlec2'] == 0) {
                                    $dismlec = "readonly";
                                } else {
                                    $dismlec = "";
                                }
                                ?>

                                <div class="form-group">
                                    <strong>Class Standing</strong><input type="number" class="form-control" value="<?php echo $criteria['cstandlec2']; ?>" name="cstandlec2" />
                                </div>

                                <?php
                                if ($criteria['cstandp2'] != 100) {
                                    $stylemlec = 'color:#e32214';
                                } else {
                                    $stylemlec = 'color:green';
                                }
                                ?>

                                <strong>Class Standing % Distribution =</strong> <b style="<?php echo $stylemlec; ?>"> <?php echo $criteria['cstandp2']; ?>%</b><br>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Quizzes</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cquiz2']; ?>" name="cquiz2" <?php echo $dismlec; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Assignment</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cass2']; ?>" name="cass2" <?php echo $dismlec; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Recitation</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['crec2']; ?>" name="crec2" <?php echo $dismlec; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Seatwork</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['csw2']; ?>" name="csw2" <?php echo $dismlec; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Groupwork</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cgw2']; ?>" name="cgw2" <?php echo $dismlec; ?> />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <strong>Character</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['ccharc2']; ?>" name="ccharc2" />
                        </div>

                        <div class="form-group">
                            <strong>Project</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cproject2']; ?>" name="cproject2" />
                        </div>

                        <div class="form-group">
                            <strong>Exam</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cexam2']; ?>" name="cexam2" />
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
                            <strong>Weight Distribution: SEMI-FINALS</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['wdsemifinal']; ?>" name="wdsemifinal" />
                        </div>
                        <div class="form-group">
                            <strong>Attendance</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['catt3']; ?>" name="catt3" />
                        </div>
                        <div class="panel panel-yellow">
                            <div class="panel-body">

                                <?php
                                if ($criteria['cstandlec3'] == 0) {
                                    $dissflec = "readonly";
                                } else {
                                    $dissflec = "";
                                }
                                ?>

                                <div class="form-group">
                                    <strong>Class Standing</strong><input type="number" class="form-control" value="<?php echo $criteria['cstandlec3']; ?>" name="cstandlec3" />
                                </div>

                                <?php
                                if ($criteria['cstandp3'] != 100) {
                                    $stylesflec = 'color:#e32214';
                                } else {
                                    $stylesflec = 'color:green';
                                }
                                ?>

                                <strong>Class Standing % Distribution =</strong><b style="<?php echo $stylesflec; ?>"> <?php echo $criteria['cstandp3']; ?>%</b><br>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Quizzes</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cquiz3']; ?>" name="cquiz3" <?php echo $dissflec; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Assignment</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cass3']; ?>" name="cass3" <?php echo $dissflec; ?> />
                                </div>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Recitation</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['crec3']; ?>" name="crec3" <?php echo $dissflec; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Seatwork</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['csw3']; ?>" name="csw3" <?php echo $dissflec; ?> />
                                </div>

                                <div class="form-group">
                                    <strong style="font-size:12px;">Groupwork</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cgw3']; ?>" name="cgw3" <?php echo $dissflec; ?> />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <strong>Character</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['ccharc3']; ?>" name="ccharc3" />
                        </div>

                        <div class="form-group">
                            <strong>Project</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cproject3']; ?>" name="cproject3" />
                        </div>

                        <div class="form-group">
                            <strong>Exam</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cexam3']; ?>" name="cexam3" />
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
                            <strong>Weight Distribution: FINALS</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['wdfinal']; ?>" name="wdfinal" />
                        </div>
                        <div class="form-group">
                            <strong>Attendance</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['catt4']; ?>" name="catt4" />
                        </div>

                        <div class="panel panel-yellow">
                            <div class="panel-body">

                                <?php
                                if ($criteria['cstandlec4'] == 0) {
                                    $disflec = "readonly";
                                } else {
                                    $disflec = "";
                                }
                                ?>

                                <div class="form-group">
                                    <strong>Class Standing</strong><input type="number" class="form-control" value="<?php echo $criteria['cstandlec4']; ?>" name="cstandlec4" />
                                </div>
                                <?php
                                if ($criteria['cstandp4'] != 100) {
                                    $styleflec = 'color:#e32214';
                                } else {
                                    $styleflec = 'color:green';
                                }
                                ?>
                                <strong>Class Standing % Distribution =</strong><b style="<?php echo $styleflec; ?>"> <?php echo $criteria['cstandp4']; ?>%</b><br>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Quizzes</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cquiz4']; ?>" name="cquiz4" <?php echo $disflec; ?> />
                                </div>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Assignment</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cass4']; ?>" name="cass4" <?php echo $disflec; ?> />
                                </div>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Recitation</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['crec4']; ?>" name="crec4" <?php echo $disflec; ?> />
                                </div>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Seatwork</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['csw4']; ?>" name="csw4" <?php echo $disflec; ?> />
                                </div>
                                <div class="form-group">
                                    <strong style="font-size:12px;">Groupwork</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cgw4']; ?>" name="cgw4" <?php echo $dissflec; ?> />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <strong>Character</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['ccharc4']; ?>" name="ccharc4" />
                        </div>
                        <div class="form-group">
                            <strong>Project</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cproject4']; ?>" name="cproject4" />
                        </div>
                        <div class="form-group">
                            <strong>Exam</strong><input type="number" min=0 max=100 class="form-control" value="<?php echo $criteria['cexam4']; ?>" name="cexam4" />
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
