<?php
include('include/header.php');
include('include/sidebar.php');
include('data/subject_model.php');

$firstsem = $subject->getsubject('1st', $id);
$secondsem = $subject->getsubject('2nd', $id);
$summer = $subject->getsubject('Summer', $id);
?>


<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <small>MY SUBJECTS</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                    </li>
                    <li class="active">
                        My Subjects
                    </li>
                </ol>
            </div>
        </div>

        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#data1" role="tab" data-toggle="tab">First Sem</a></li>
                    <li><a href="#data2" role="tab" data-toggle="tab">Second Sem</a></li>
                    <li><a href="#data3" role="tab" data-toggle="tab">Summer</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="data1">
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Subject</th>
                                        <th class="text-center">Merge Subject</th>
                                        <th class="text-center">Course/Year</th>
                                        <th class="text-center">Section</th>
                                        <th class="text-center">College</th>
                                        <th class="text-center">School Year</th>
                                        <th class="text-center">Students</th>
                                        <th class="text-center">Criteria</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $c = 1; ?>
                                    <?php while ($row = mysql_fetch_array($firstsem)) : ?>
                                        <tr>
                                            <td><?php echo $c; ?></td>
                                            <td class="text-center"><?php echo $row['subject']; ?></td>
                                            <td class="text-center"><?php echo $row['mergesubject']; ?></td>
                                            <?php $subjectname = $subject->getsubjectbycode($row['subject']); ?>
                                            <td class="text-center"><?php echo $row['course'] . ' ' . $row['year']; ?></td>
                                            <td class="text-center"><?php echo $row['section']; ?></td>
                                            <td class="text-center"><?php echo $row['college']; ?></td>
                                            <td class="text-center"><?php echo $row['SY']; ?></td>
                                            <td class="text-center"><a href="student.php?classid=<?php echo $row['id']; ?>">View Students</a></td>
                                            <?php if ($subjectname['type'] == 'Lecture') : ?>
                                                <td class="text-center"><a href="criterialec.php?teachid=<?php echo $row['teacher']; ?>&classid=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-gear fa-lg" title="criteria"></i></a></td>
                                            <?php elseif ($subjectname['type'] == 'Lec-Lab') : ?>
                                                <td class="text-center"><a href="criterialeclab.php?teachid=<?php echo $row['teacher']; ?>&classid=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-gear fa-lg" title="criteria"></i></a></td>
                                            <?php else : ?>
                                                <td class="text-center"><a href="criterialab.php?teachid=<?php echo $row['teacher']; ?>&classid=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-gear fa-lg" title="criteria"></i></a></td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php $c++; ?>
                                    <?php endwhile; ?>


                                    <?php if (mysql_num_rows($firstsem) < 1) : ?>
                                        <tr>
                                            <td colspan="12" class="text-center text-danger"><strong>*** EMPTY ***</strong></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="data2">
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Subject</th>
                                        <th class="text-center">Merge Subject</th>
                                        <th class="text-center">Course</th>
                                        <th class="text-center">Section</th>
                                        <th class="text-center">College</th>
                                        <th class="text-center">School Year</th>
                                        <th class="text-center">Students</th>
                                        <th class="text-center">Criteria</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $c = 1; ?>
                                    <?php while ($row = mysql_fetch_array($secondsem)) : ?>
                                        <tr>
                                            <td><?php echo $c; ?></td>
                                            <td class="text-center"><?php echo $row['subject']; ?></td>
                                            <td class="text-center"><?php echo $row['mergesubject']; ?></td>
                                            <?php $subjectname = $subject->getsubjectbycode($row['subject']); ?>
                                            <td class="text-center"><?php echo $row['course'] . ' ' . $row['year']; ?></td>
                                            <td class="text-center"><?php echo $row['section']; ?></td>
                                            <td class="text-center"><?php echo $row['college']; ?></td>
                                            <td class="text-center"><?php echo $row['SY']; ?></td>
                                            <td class="text-center"><a href="student.php?classid=<?php echo $row['id']; ?>">View Students</a></td>
                                            <?php if ($subjectname['type'] == 'Lecture') : ?>
                                                <td class="text-center"><a href="criterialec.php?teachid=<?php echo $row['teacher']; ?>&classid=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-gear fa-lg" title="criteria"></i></a></td>
                                            <?php elseif ($subjectname['type'] == 'Lec-Lab') : ?>
                                                <td class="text-center"><a href="criterialeclab.php?teachid=<?php echo $row['teacher']; ?>&classid=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-gear fa-lg" title="criteria"></i></a></td>
                                            <?php else : ?>
                                                <td class="text-center"><a href="criterialab.php?teachid=<?php echo $row['teacher']; ?>&classid=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-gear fa-lg" title="criteria"></i></a></td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php $c++; ?>
                                    <?php endwhile; ?>
                                    <?php if (mysql_num_rows($secondsem) < 1) : ?>
                                        <tr>
                                            <td colspan="12" class="text-center text-danger"><strong>*** EMPTY ***</strong></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="data3">
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Subject</th>
                                        <th class="text-center">Merge Subject</th>
                                        <th class="text-center">Course</th>
                                        <th class="text-center">Section</th>
                                        <th class="text-center">College</th>
                                        <th class="text-center">School Year</th>
                                        <th class="text-center">Students</th>
                                        <th class="text-center">Criteria</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $c = 1; ?>
                                    <?php while ($row = mysql_fetch_array($summer)) : ?>
                                        <tr>
                                            <td><?php echo $c; ?></td>
                                            <td class="text-center"><?php echo $row['subject']; ?></td>
                                            <td class="text-center"><?php echo $row['mergesubject']; ?></td>
                                            <?php $subjectname = $subject->getsubjectbycode($row['subject']); ?>
                                            <td class="text-center"><?php echo $row['course'] . ' ' . $row['year']; ?></td>
                                            <td class="text-center"><?php echo $row['section']; ?></td>
                                            <td class="text-center"><?php echo $row['college']; ?></td>
                                            <td class="text-center"><?php echo $row['SY']; ?></td>
                                            <td class="text-center"><a href="student.php?classid=<?php echo $row['id']; ?>">View Students</a></td>
                                            <?php if ($subjectname['type'] == 'Lecture') : ?>
                                                <td class="text-center"><a href="criterialec.php?teachid=<?php echo $row['teacher']; ?>&classid=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-gear fa-lg" title="criteria"></i></a></td>
                                            <?php elseif ($subjectname['type'] == 'Lec-Lab') : ?>
                                                <td class="text-center"><a href="criterialeclab.php?teachid=<?php echo $row['teacher']; ?>&classid=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-gear fa-lg" title="criteria"></i></a></td>
                                            <?php else : ?>
                                                <td class="text-center"><a href="criterialab.php?teachid=<?php echo $row['teacher']; ?>&classid=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-gear fa-lg" title="criteria"></i></a></td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php $c++; ?>
                                    <?php endwhile; ?>
                                    <?php if (mysql_num_rows($summer) < 1) : ?>
                                        <tr>
                                            <td colspan="12" class="text-center text-danger"><strong>*** EMPTY ***</strong></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
</div>
<?php include('include/footer.php');
