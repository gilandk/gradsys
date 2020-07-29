<?php
include('../config.php');
$level = isset($_SESSION['level']) ? $_SESSION['level'] : null;
if ($level == null) {
    header('location:../index.php');
} else if ($level != 'student') {
    header('location:../' . $level . '');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>STUDENT GRADES</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="mystyle.css" />


</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Dr. Yanga's Colleges Inc.</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <div class="navbar-form navbar-right">
                    <label class="text-title">
                        Hi, <?php echo $_SESSION['name']; ?> (Student)&nbsp;&nbsp;
                    </label>
                    <a href="../logout.php"><button type="button" class="btn btn-success" name="submit">Logout</button></a>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#changepass">Change Password</button>
                </div>
            </div>
        </div>
    </nav>

    <?php
    include('grade.php');
    $mysubject = $grade->getsubject();

    $sy = $grade->getsubjectSY('SY', 'classid', 'teacher');
    ?>


    <div class="container" style="margin-top:60px;">
        <!--columns -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-center">Report of Grades</h2>
                <hr />

                <div class="">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="alert alert-info">
                                <th class="text-center">S.Y.</th>
                                <th class="text-center">Subject Code</th>
                                <th class="text-center">Subject Title</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">Prelim</th>
                                <th class="text-center">Midterm</th>
                                <th class="text-center">Semi-Final</th>
                                <th class="text-center">Final</th>
                                <th class="text-center">Final Grade</th>
                                <th class="text-center">Equivalent</th>
                                <th class="text-center">Units</th>
                                <th class="text-center">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $c = 1; ?>

                            <?php foreach ($mysubject as $row) : ?>
                                <tr>

                                    <td class="text-center"><?php echo $row['SY']; ?></td>

                                    <td class="text-center"><?php echo $row['subject']; ?></td>


                                    <?php $title = $grade->getsubjectitle($row['subject']); ?>
                                    <td class="text-center"><?php echo $title[0]['title']; ?></td>
                                    <td class="text-center"><?php echo $row['sem']; ?></td>


                                    <!-- grades compute -->

                                    <?php if ($title[0]['type'] == 'Lecture') : ?>
                                        <?php $mygrade = $grade->getgrade($row['teacher']); ?>

                                    <?php elseif ($title[0]['type'] == 'Lec-Lab') : ?>
                                        <?php $mygrade = $grade->getgradeleclab($row['teacher']); ?>

                                    <?php else : ?>
                                        <?php $mygrade = $grade->getgradelab($row['teacher']); ?>

                                    <?php endif; ?>

                                    <!-- grades compute -->

                                    <td class="text-center"><?php echo $mygrade['prelim']; ?></td>
                                    <td class="text-center"><?php echo $mygrade['midterm']; ?></td>
                                    <td class="text-center"><?php echo $mygrade['semifinal']; ?></td>
                                    <td class="text-center"><?php echo $mygrade['final']; ?></td>
                                    <td class="text-center"><?php echo $mygrade['total']; ?></td>
                                    <td class="text-center"><?php echo $mygrade['eqtotal']; ?></td>
                                    <td class="text-center"><?php echo $title[0]['unit']; ?></td>
                                    <?php
                                        if ($mygrade['eqtotal'] <= 3.0 && ($mygrade['eqtotal'] >= 1.0)) {
                                            $remarks = 'PASSED';
                                            $class = 'text-success';
                                        } elseif ($mygrade['eqtotal'] >= 3.0 && ($mygrade['eqtotal'] <= 5.0)) {
                                            $remarks = 'FAILED';
                                            $class = 'text-danger';
                                        } else {
                                            $remarks = 'NO GRADE';
                                            $class = 'text-danger';
                                        }

                                        ?>
                                    <td class="text-center <?php echo $class; ?>"><?php echo $remarks; ?></td>
                                </tr>

                                <?php $c++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <h4 class="text-center text-danger">*** NOTHING FOLLOWS ***</h4>

                </div>
            </div>

        </div>

        <!-- <div class="row">
        <?php foreach ($mysubject as $row) : ?>
        <div class="col-lg-4 gradeform">
            <div class="form_hover " style="background-color: #428BCA;">
                <p style="text-align: center; margin-top: 20px;">
                    <i class="fa fa-bar-chart-o" style="font-size: 147px;color:#fff;"></i>
                </p>

                <div class="header">
                    <div class="blur"></div>
                    <div class="header-text">
                        <div class="panel panel-success" style="height: 247px;">
                            <div class="panel-heading">
                                <h3 style="color: #428BCA;">Subject: <?php echo $row['subject']; ?></h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered">
                                    <tr class="alert alert-danger">
                                        <th>Prelim</th>
                                        <th>Midterm</th>
                                        <th>Semi-Final</th>
                                        <th>Final</th>
                                        <th>GPA</th>
                                    </tr>
                           
                                    <tr>
                                <?php $title = $grade->getsubjectitle($row['subject']); ?>
                                <?php if ($title[0]['type'] == 'Lecture') : ?>
                                <?php $mygrade = $grade->getgrade($row['id']); ?>
                                <?php elseif ($title[0]['type'] == 'Lec-Lab') : ?>
                                <?php $mygrade = $grade->getgradeleclab($row['id']); ?>
                                <?php else : ?>
                                <?php $mygrade = $grade->getgradelab($row['id']); ?>
                                <?php endif; ?>
                                        <td><?php echo $mygrade['prelim']; ?></td>
                                        <td><?php echo $mygrade['midterm']; ?></td>
                                        <td><?php echo $mygrade['semifinal']; ?></td>
                                        <td><?php echo $mygrade['final']; ?></td>
                                        <td><?php echo $mygrade['eqtotal']; ?></td>
                                    </tr>

                                </table>
                                <div class="form-group">
                                    <?php $teacher = $grade->getteacher($row['teacher']); ?>
                                    <label>Instructor: <?php echo $teacher; ?></label><br />
                                    <label>Semester: <?php echo $row['sem'] ?> Sem</label><br />
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php endforeach; ?>
      </div> -->


        <!-- add modal for change password -->
        <div class="modal fade" id="changepass" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Change Password</h3>
                    </div>
                    <div class="modal-body">
                        <form action="password.php?q=changepassword&username=<?php echo $_SESSION['id']; ?>" method="post">
                            <div class="form-group">
                                <input type="password" class="form-control" name="current" placeholder="Current Password" />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="new" placeholder="New Password" />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="confirm" placeholder="Confirm Password" />
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Change</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <hr>

        <footer>
            <p>&copy; DYCI 2019</p>
        </footer>
    </div>


    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>