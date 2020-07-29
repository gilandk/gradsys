<?php
    include('../config.php');
    include('data/data_model.php');
    include('data/student_model.php');
    include('data/class_model.php');
    include('data/teacher_model.php');

    $classid = $_GET['classid'];
    $student = $student->getstudentbyclass($classid);
    $mysubject = $data->getsubjectbyclassid($classid);
    
?>



<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Masterlist</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        .wrapper {
            margin-top:20px !important;
            border:1px solid #777;
            background:#fff;
            margin:0 auto;
            padding: 20px;
        }
        body {
            background:#ccc;
        }
        img {
            max-height:150px;
            max-width:150px;
            margin-right:10px;
        }
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
            border-top: none !important;
        }
    </style>
    <!--  bootstrap end -->
</head>
<body>
    <div class="container wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h3>MASTER LIST</h3>
                    <hr />                  
                    <?php while($row = @mysql_fetch_array($mysubject)): ?>
                    <?php $mysubjectname = $data->getsubjectbycode($row['subject']); ?>
                    <?php $mergetitle = $data->getsubjectbycode($row['mergesubject']); ?>
                    <table class="table">
                        <tr>
                            <td style="width:20%;text-align:left;"><strong>SUBJ CODE:</strong></td>
                            <td style="width:*;text-align:left;"><?php echo $row['subject'].' / '.$row['mergesubject'];?></td>
                            <td style="width:10%;text-align:left;"><strong>COLLEGE:</strong></td>
                            <td style="width:25%;text-align:left;"><?php echo $row['college'];?></td>  
                        </tr>
                        <tr>
                            <td class="text-left"><strong>UNITS:</strong></td>
                            <td class="text-left"><?php echo $mysubjectname['unit'];?></td>
                            <td style="width:10%;text-align:left;"><strong>DATE:</strong></td>
                            <td style="width:25%;text-align:left;"><?php echo date('F d, Y')?></td>   
                        </tr>
                        <tr>
                            <td class="text-left"><strong>SUBJ NAME:</strong></td>
                            <td class="text-left"><?php echo $mysubjectname['title'].' / '.$mergetitle['title'];?></td>
                            <td class="text-left"><strong>S.Y :</strong></td>
                            <td class="text-left"><?php echo $row['SY'];?></td> 
                        </tr>
                        <tr>
                          <?php $teacher = $teacher->getteachername($row['teacher']); ?>
                            <td class="text-left"><strong>INSTRUCTOR:</strong></td>
                            <td class="text-left"><?php echo $teacher;?></td>
                        </tr>
                    </table>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Student's ID</th>
                                <th class="text-center">Student's Name</th>
                                <th class="text-center">Course</th>
                                <th class="text-center">Year</th>
                                <th class="text-center">Section</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php $c=1; ?>
                    <?php foreach($student as $row): ?>
                        <tr>
                            <td><?php echo $c; ?></td>
                            <td class="text-center"><?php echo $row['studid'];?></td>
                            <td><?php echo $row['lname'].', '.$row['fname'].' '.$row['midname']; ?></td>
                            <td class="text-center"><?php echo $row['course'];?></td>
                            <td class="text-center"><?php echo $row['year'];?></td>
                            <td class="text-center"><?php echo $row['section'];?></td>
                            
                        </tr>
                    <?php $c++; ?>
                    <?php endforeach; ?>
                    <?php if(!$student): ?>
                        <tr><td colspan="12" class="text-center text-danger"><strong>*** No Result ***</strong></td></tr>
                    <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
