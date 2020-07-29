<?php
    include('include/header.php');
    include('include/sidebar.php');
    include('data/student_model.php');
    include('data/data_model.php');

    $id = $_GET['id'];
    $student = $student->getstudentbyid($id);
?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <small>STUDENT SUBJECT</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                    </li>
                    <li>
                        <a href="studentlist.php">Students</a>
                    </li>
                    <li class="active">
                        Student Subject
                    </li>
                </ol>
            </div>
        </div>

        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <?php while($row = mysql_fetch_array($student)): ?>
                <h4>Student ID : <?php echo $row['studid']; ?></h4>
                <h4>Name : <?php echo $row['fname'].' '.$row['midname'].' '.$row['lname']; ?></h4>
                <?php endwhile; ?>
                <hr />
                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Title</th>
                            <th>Merge Subject</th>
                            <th>Title</th>
                            <th>Instructor</th>
                            <th class="text-center">College</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                        $r1 = mysql_query("select * from studentsubject where studid=$id");
                        while($row = mysql_fetch_array($r1)):
                        $r2 = mysql_query('select * from class where id='.$row['classid'].'');
                        while($rows = mysql_fetch_array($r2)):
                        $r3 = mysql_query('select * from teacher where id='.$rows['teacher'].'');
                        $teacher = null;
                        if($r3){
                        $teacher = mysql_fetch_array($r3);
                        $teacher = $teacher['fname'].' '.$teacher['midname'].' '.$teacher['lname'];
                        }
                    ?>
                        <tr>
                            <td><?php echo $rows['subject']; ?></td>
                            <?php $title = $data->getsubjectbycode($rows['subject']); ?>
                            <td><?php echo $title['title']; ?></td>
                            <td><?php echo $rows['mergesubject']; ?></td>
                            <?php $mergetitle = $data->getsubjectbycode($rows['mergesubject']); ?>
                            <td><?php echo $mergetitle['title']; ?></td>
                            <td><?php echo $teacher ?></td>
                            <td class="text-center"><?php echo $rows['college']; ?></td>
                            <td class="text-center"><?php echo $rows['sem']; ?></td>
                            <td class="text-center"><a href="data/student_model.php?q=removesubject&studid=<?php echo $id;?>&classid=<?php echo $rows['id']; ?>"><i class="fa fa-times-circle text-danger fa-2x confirmation"></i></a></td>
                        </tr>
                    <?php endwhile; endwhile; ?>

                      <?php
                        $r4 = mysql_query("select * from studentsubjectlec where studid=$id");
                        while($row = mysql_fetch_array($r4)):
                        $r5 = mysql_query('select * from class where id='.$row['classid'].'');
                        while($rows = mysql_fetch_array($r5)):
                        $r6 = mysql_query('select * from teacher where id='.$rows['teacher'].'');
                        $teacher = null;
                        if($r6){
                        $teacher = mysql_fetch_array($r6);
                        $teacher = $teacher['fname'].' '.$teacher['midname'].' '.$teacher['lname'];
                        }


                    ?>

                        <tr>
                            <td><?php echo $rows['subject']; ?></td>
                            <?php $title = $data->getsubjectbycode($rows['subject']); ?>
                            <td><?php echo $title['title']; ?></td>
                            <td><?php echo $rows['mergesubject']; ?></td>
                            <?php $mergetitle = $data->getsubjectbycode($rows['mergesubject']); ?>
                            <td><?php echo $mergetitle['title']; ?></td>
                            <td><?php echo $teacher ?></td>
                            <td class="text-center"><?php echo $rows['college']; ?></td>
                            <td class="text-center"><?php echo $rows['sem']; ?></td>
                            <td class="text-center"><a href="data/student_model.php?q=removesubject&studid=<?php echo $id;?>&classid=<?php echo $rows['id']; ?>"><i class="fa fa-times-circle text-danger fa-2x confirmation"></i></a></td>
                        </tr>
                    <?php endwhile; endwhile; ?>

                      <?php
                        $r7 = mysql_query("select * from studentsubjectlab where studid=$id");
                        while($row = mysql_fetch_array($r7)):
                        $r8 = mysql_query('select * from class where id='.$row['classid'].'');
                        while($rows = mysql_fetch_array($r8)):
                        $r9 = mysql_query('select * from teacher where id='.$rows['teacher'].'');
                        $teacher = null;
                        if($r9){
                        $teacher = mysql_fetch_array($r9);
                        $teacher = $teacher['fname'].' '.$teacher['midname'].' '.$teacher['lname'];
                        }
                    ?>
                        <tr>
                            <td><?php echo $rows['subject']; ?></td>
                            <?php $title = $data->getsubjectbycode($rows['subject']); ?>
                            <td><?php echo $title['title']; ?></td>
                            <td><?php echo $rows['mergesubject']; ?></td>
                            <?php $mergetitle = $data->getsubjectbycode($rows['mergesubject']); ?>
                            <td><?php echo $mergetitle['title']; ?></td>
                            <td><?php echo $teacher ?></td>
                            <td class="text-center"><?php echo $rows['college']; ?></td>
                            <td class="text-center"><?php echo $rows['sem']; ?></td>
                            <td class="text-center"><a href="data/student_model.php?q=removesubject&studid=<?php echo $id;?>&classid=<?php echo $rows['id']; ?>"><i class="fa fa-times-circle text-danger fa-2x confirmation"></i></a></td>
                        </tr>
                    <?php endwhile; endwhile; ?>

                    </tbody>
                </table>
            </div>
            </div>
        </div>



    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
<?php include('include/footer.php');
