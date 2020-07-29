<?php
include('include/header.php');
include('include/sidebar.php');
include('data/data_model.php');
include('data/class_model.php');
include('data/student_model.php');
include('data/teacher_model.php');
$id = $_REQUEST['id'];
$subject = $data->getsubjectbyid($id);
$class = $class->getclassbyid($id);
$student = $student->getstudentbyid($id);
$teacher = $teacher->getteacherbyid($id);

?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <small>EDIT</small>
                </h1>
                <?php
                $edit = new Edit();
                $type = $_GET['type'];
                if ($type == 'subject') {
                    $edit->editsubject($subject);
                } else if ($type == 'class') {
                    $edit->editclass($class);
                } else if ($type == 'student') {
                    $edit->editstudent($student);
                } else if ($type == 'teacher') {
                    $edit->editteacher($teacher);
                }
                ?>
            </div>
        </div>
        <!-- /.row -->


    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include('include/footer.php');

class Edit
{

    function editsubject($subject)
    { ?>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
            </li>
            <li>
                <a href="subject.php">Subject</a>
            </li>
            <li class="active">
                Edit
            </li>
        </ol>
        <hr />
        <div class="modal-body">
            <?php
                    // UPDATED FETCH ARRAY
                    // REMOVED WARNING ON MYSQL_NUM_ROWS
                    if (@mysql_num_rows($subject)) {
                        $row = mysql_fetch_array($subject);
                        $ftype = 'edit';
                    } else {
                        $ftype = 'add';
                    }
                    ?>
            <form action="data/data_model.php" method="post">
                <input type="hidden" name="q" value="updatesubject">
                <input type="hidden" name="ftype" value="<?php echo $ftype; ?>">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="code_old" value="<?php echo $row['code']; ?>">

                <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control" value="<?php echo $row['code']; ?>" name="code" placeholder="subject code" />
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" value="<?php echo $row['title']; ?>" name="title" placeholder="subject title" />
                </div>

                <div class="form-group">
                    <label>College</label>
                    <select name="college" class="form-control" required>
                        <option value="">Select College Department...</option>
                        <option <?php if ($row['college'] == 'CCS') echo "selected" ?>>CCS</option>
                        <option <?php if ($row['college'] == 'COA') echo "selected" ?>>COA</option>
                        <option <?php if ($row['college'] == 'CBA') echo "selected" ?>>CBA</option>
                        <option <?php if ($row['college'] == 'CHS') echo "selected" ?>>CHS</option>
                        <option <?php if ($row['college'] == 'COED') echo "selected" ?>>COED</option>
                        <option <?php if ($row['college'] == 'CAS') echo "selected" ?>>CAS</option>
                        <option <?php if ($row['college'] == 'CME') echo "selected" ?>>CME</option>
                        <option <?php if ($row['college'] == 'CHMT') echo "selected" ?>>CHMT</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Subject Category</label>
                    <select name="category" class="form-control" required>
                        <option>Select Category...</option>
                        <option <?php if ($row['category'] == 'General Education') echo "selected" ?>>General Education</option>
                        <option <?php if ($row['category'] == 'Professional Education') echo "selected" ?>>Professional Education</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Subject Type</label>
                    <select name="type" class="form-control" required>
                        <option>Select Subject Type...</option>
                        <option <?php if ($row['type'] == 'Lecture') echo "selected" ?>>Lecture</option>
                        <option <?php if ($row['type'] == 'Laboratory') echo "selected" ?>>Laboratory</option>
                        <option <?php if ($row['type'] == 'Lec-Lab') echo "selected" ?>>Lec-Lab</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>No. Of Units</label>
                    <input type="number" min="1" max="5" class="form-control" value="<?php echo $row['unit']; ?>" name="unit" placeholder="no. of units" />
                </div>
        </div>
        <div class="modal-footer">
            <a href="subject.php"><button type="button" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</button></a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
            </form>
        </div>

    <?php    }

        function editclass($class)
        { ?>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
            </li>
            <li>
                <a href="class.php">Class Info</a>
            </li>
            <li class="active">
                Edit
            </li>
        </ol>
        <hr />
        <div class="modal-body">
            <?php while ($row = mysql_fetch_array($class)) : ?>
                <form action="data/class_model.php?q=updateclass&id=<?php echo $row['id'] ?>" method="post">

                    <div class="form-group">
                        <select name="subject" class="form-control" required>
                            <option value="">Select Subject...</option>
                            <?php
                                        $r = mysql_query("select * from subject");
                                        while ($re = mysql_fetch_array($r)) :
                                            ?>
                                <option <?php if ($row['subject'] == $re['code']) echo "selected" ?> value="<?php echo $re['code']; ?>"><?php echo $re['code']; ?> - (<?php echo $re['title']; ?>)</option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="mergesubject" class="form-control">
                            <option value=" ">Select Merge Subject...</option>
                            <?php
                                        $r = mysql_query("select * from subject");
                                        while ($re = mysql_fetch_array($r)) :
                                            ?>
                                <option <?php if ($row['mergesubject'] == $re['code']) echo "selected" ?> value="<?php echo $re['code']; ?>"><?php echo $re['code']; ?> - (<?php echo $re['title']; ?>)</option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="college" class="form-control" required>
                            <option value="">Select College Department...</option>
                            <option <?php if ($row['college'] == 'CCS') echo "selected" ?>>CCS</option>
                            <option <?php if ($row['college'] == 'COA') echo "selected" ?>>COA</option>
                            <option <?php if ($row['college'] == 'CBA') echo "selected" ?>>CBA</option>
                            <option <?php if ($row['college'] == 'CHS') echo "selected" ?>>CHS</option>
                            <option <?php if ($row['college'] == 'COED') echo "selected" ?>>COED</option>
                            <option <?php if ($row['college'] == 'CAS') echo "selected" ?>>CAS</option>
                            <option <?php if ($row['college'] == 'CME') echo "selected" ?>>CME</option>
                            <option <?php if ($row['college'] == 'CHMT') echo "selected" ?>>CHMT</option>
                        </select>
                    </div>

                    <div class="form-group">
                    <select name="course" class="form-control" required>
                        <option value="">Select Course...</option>
                        <!-- CCS -->
                        <option <?php if ($row['course'] == 'BSIT') echo "selected" ?>>BSIT</option>
                        <option <?php if ($row['course'] == 'BSCS') echo "selected" ?>>BSCS</option>
                        <option <?php if ($row['course'] == 'BSCOE') echo "selected" ?>>BSCOE</option>
                        <option <?php if ($row['course'] == 'ACT') echo "selected" ?>>ACT</option>
                        <!-- COA -->
                        <option <?php if ($row['course'] == 'BSA') echo "selected" ?>>BSA</option>
                        <option <?php if ($row['course'] == 'BSIS') echo "selected" ?>>BSIS</option>
                        <option <?php if ($row['course'] == 'BSAT') echo "selected" ?>>BSAT</option>
                        <!-- CBA -->
                        <option <?php if ($row['course'] == 'BSBA - HRDM') echo "selected" ?>>BSBA - HRDM</option>
                        <option <?php if ($row['course'] == 'BSBA - FM') echo "selected" ?>>BSBA - FM</option>
                        <option <?php if ($row['course'] == 'BSBA - OM') echo "selected" ?>>BSBA - OM</option>
                        <option <?php if ($row['course'] == 'BSBA - MM') echo "selected" ?>>BSBA - MM</option>
                        <!-- CHS -->
                        <option <?php if ($row['course'] == 'BSN') echo "selected" ?>>BSN</option>
                        <option <?php if ($row['course'] == 'BSM') echo "selected" ?>>BSM</option>
                        <!-- COED -->
                        <option <?php if ($row['course'] == 'BEED') echo "selected" ?>>BEED</option>
                        <option <?php if ($row['course'] == 'BSED BIO') echo "selected" ?>>BSED BIO</option>
                        <option <?php if ($row['course'] == 'BSED MATH') echo "selected" ?>>BSED MATH</option>
                        <option <?php if ($row['course'] == 'BSED ENGLISH') echo "selected" ?>>BSED ENGLISH</option>
                        <option <?php if ($row['course'] == 'BSED FIL') echo "selected" ?>>BSED FIL</option>
                        <!-- CAS -->
                        <option <?php if ($row['course'] == 'AB Psy') echo "selected" ?>>AB Psy</option>
                        <option <?php if ($row['course'] == 'AB Pol Scie') echo "selected" ?>>AB Pol Scie</option>
                        <!-- CME -->
                        <option <?php if ($row['course'] == 'BSME') echo "selected" ?>>BSME</option>
                        <!-- CHMT -->
                        <option <?php if ($row['course'] == 'BSHRM') echo "selected" ?>>BSHRM</option>
                        <option <?php if ($row['course'] == 'BST') echo "selected" ?>>BST</option>

                    </select>
                </div>

                <div class="form-group">
                    <select name="year" class="form-control" required>
                        <option value="">Select Year...</option>
                        <option <?php if ($row['year'] == 'I') echo "selected" ?>>I</option>
                        <option <?php if ($row['year'] == 'II') echo "selected" ?>>II</option>
                        <option <?php if ($row['year'] == 'III') echo "selected" ?>>III</option>
                        <option <?php if ($row['year'] == 'IV') echo "selected" ?>>IV</option>
                        <option <?php if ($row['year'] == 'V') echo "selected" ?>>V</option>
                    </select>
                </div>

                <div class="form-group">
                    <select name="section" class="form-control" required>
                        <option value="">Select Section...</option>
                        <option <?php if ($row['section'] == 'A') echo "selected" ?>>A</option>
                        <option <?php if ($row['section'] == 'B') echo "selected" ?>>B</option>
                        <option <?php if ($row['section'] == 'C') echo "selected" ?>>C</option>
                        <option <?php if ($row['section'] == 'D') echo "selected" ?>>D</option>
                        <option <?php if ($row['section'] == 'E') echo "selected" ?>>E</option>
                    </select>
                </div>

                    <div class="form-group">
                        <select name="sem" class="form-control" required>
                            <option value="">Select Semester...</option>
                            <option <?php if ($row['sem'] == '1st') echo "selected" ?>>1st</option>
                            <option <?php if ($row['sem'] == '2nd') echo "selected" ?>>2nd</option>
                            <option <?php if ($row['sem'] == 'summer') echo "selected" ?>>Summer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="sy" class="form-control" required>
                            <option value="">Select S.Y.</option>
                            <?php $year = date('Y'); ?>
                            <?php for ($c = 10; $c > 0; $c--) : ?>
                                <?php $sy = ($year) . '-' . ($year + 1); ?>
                                <option <?php if ($row['SY'] == $sy) echo "selected" ?>><?php echo $sy; ?></option>
                                <?php $year--; ?>
                            <?php endfor; ?>
                        </select>
                    </div>
        </div>
        <div class="modal-footer">
            <a href="class.php"><button type="button" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</button></a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
            </form>
        <?php endwhile; ?>
        </div>
    <?php
        }

        function editstudent($student)
        { ?>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
            </li>
            <li>
                <a href="studentlist.php">Student's List</a>
            </li>
            <li class="active">
                Edit
            </li>
        </ol>
        <hr />
        <div class="modal-body">
            <?php
                    // UPDATED FETCH ARRAY
                    // REMOVED WARNING ON MYSQL_NUM_ROWS
                    if (@mysql_num_rows($student)) {
                        $row = mysql_fetch_array($student);
                        $type = 'edit';
                    } else {
                        $type = 'add';
                    }
                    ?>
            <form action="data/student_model.php" method="post">
                <input type="hidden" name="q" value="updatestudent">
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="studid_old" value="<?php echo $row['studid']; ?>">
                <div class="form-group">
                    <input type="text" class="form-control" name="studid" value="<?php echo $row['studid']; ?>" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="fname" value="<?php echo $row['fname']; ?>" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="midname" value="<?php echo $row['midname']; ?>" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="lname" value="<?php echo $row['lname']; ?>" />
                </div>

                <div class="form-group">
                    <select name="college" class="form-control" required>
                        <option value="">Select College Department...</option>
                        <option <?php if ($row['college'] == 'CCS') echo "selected" ?>>CCS</option>
                        <option <?php if ($row['college'] == 'COA') echo "selected" ?>>COA</option>
                        <option <?php if ($row['college'] == 'CBA') echo "selected" ?>>CBA</option>
                        <option <?php if ($row['college'] == 'CHS') echo "selected" ?>>CHS</option>
                        <option <?php if ($row['college'] == 'COED') echo "selected" ?>>COED</option>
                        <option <?php if ($row['college'] == 'CAS') echo "selected" ?>>CAS</option>
                        <option <?php if ($row['college'] == 'CME') echo "selected" ?>>CME</option>
                        <option <?php if ($row['college'] == 'CHMT') echo "selected" ?>>CHMT</option>
                    </select>
                </div>

                <div class="form-group">
                    <select name="course" class="form-control" required>
                        <option value="">Select Course...</option>
                        <!-- CCS -->
                        <option <?php if ($row['course'] == 'BSIT') echo "selected" ?>>BSIT</option>
                        <option <?php if ($row['course'] == 'BSCS') echo "selected" ?>>BSCS</option>
                        <option <?php if ($row['course'] == 'BSCOE') echo "selected" ?>>BSCOE</option>
                        <option <?php if ($row['course'] == 'ACT') echo "selected" ?>>ACT</option>
                        <!-- COA -->
                        <option <?php if ($row['course'] == 'BSA') echo "selected" ?>>BSA</option>
                        <option <?php if ($row['course'] == 'BSIS') echo "selected" ?>>BSIS</option>
                        <option <?php if ($row['course'] == 'BSAT') echo "selected" ?>>BSAT</option>
                        <!-- CBA -->
                        <option <?php if ($row['course'] == 'BSBA - HRDM') echo "selected" ?>>BSBA - HRDM</option>
                        <option <?php if ($row['course'] == 'BSBA - FM') echo "selected" ?>>BSBA - FM</option>
                        <option <?php if ($row['course'] == 'BSBA - OM') echo "selected" ?>>BSBA - OM</option>
                        <option <?php if ($row['course'] == 'BSBA - MM') echo "selected" ?>>BSBA - MM</option>
                        <!-- CHS -->
                        <option <?php if ($row['course'] == 'BSN') echo "selected" ?>>BSN</option>
                        <option <?php if ($row['course'] == 'BSM') echo "selected" ?>>BSM</option>
                        <!-- COED -->
                        <option <?php if ($row['course'] == 'BEED') echo "selected" ?>>BEED</option>
                        <option <?php if ($row['course'] == 'BSED BIO') echo "selected" ?>>BSED BIO</option>
                        <option <?php if ($row['course'] == 'BSED MATH') echo "selected" ?>>BSED MATH</option>
                        <option <?php if ($row['course'] == 'BSED ENGLISH') echo "selected" ?>>BSED ENGLISH</option>
                        <option <?php if ($row['course'] == 'BSED FIL') echo "selected" ?>>BSED FIL</option>
                        <!-- CAS -->
                        <option <?php if ($row['course'] == 'AB Psy') echo "selected" ?>>AB Psy</option>
                        <option <?php if ($row['course'] == 'AB Pol Scie') echo "selected" ?>>AB Pol Scie</option>
                        <!-- CME -->
                        <option <?php if ($row['course'] == 'BSME') echo "selected" ?>>BSME</option>
                        <!-- CHMT -->
                        <option <?php if ($row['course'] == 'BSHRM') echo "selected" ?>>BSHRM</option>
                        <option <?php if ($row['course'] == 'BST') echo "selected" ?>>BST</option>

                    </select>
                </div>

                <div class="form-group">
                    <select name="year" class="form-control" required>
                        <option value="">Select Year...</option>
                        <option <?php if ($row['year'] == 'I') echo "selected" ?>>I</option>
                        <option <?php if ($row['year'] == 'II') echo "selected" ?>>II</option>
                        <option <?php if ($row['year'] == 'III') echo "selected" ?>>III</option>
                        <option <?php if ($row['year'] == 'IV') echo "selected" ?>>IV</option>
                        <option <?php if ($row['year'] == 'V') echo "selected" ?>>V</option>
                    </select>
                </div>

                <div class="form-group">
                    <select name="section" class="form-control" required>
                        <option value="">Select Section...</option>
                        <option <?php if ($row['section'] == 'A') echo "selected" ?>>A</option>
                        <option <?php if ($row['section'] == 'B') echo "selected" ?>>B</option>
                        <option <?php if ($row['section'] == 'C') echo "selected" ?>>C</option>
                        <option <?php if ($row['section'] == 'D') echo "selected" ?>>D</option>
                        <option <?php if ($row['section'] == 'E') echo "selected" ?>>E</option>
                    </select>
                </div>
        </div>

        <div class="modal-footer">
            <a href="studentlist.php"><button type="button" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</button></a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
            </form>
            </form>
        </div>

    <?php
        }

        function editteacher($teacher)
        { ?>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
            </li>
            <li>
                <a href="studentlist.php">Instructor's List</a>
            </li>
            <li class="active">
                Edit
            </li>
        </ol>
        <hr />
        <div class="modal-body">
            <?php
                    // UPDATED FETCH ARRAY
                    // REMOVED WARNING ON MYSQL_NUM_ROWS
                    if (@mysql_num_rows($teacher)) {
                        $row = mysql_fetch_array($teacher);
                        $type = 'edit';
                    } else {
                        $type = 'add';
                    }
                    ?>
            <form action="data/teacher_model.php" method="POST">
                <input type="hidden" name="q" value="updateteacher">
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="teachid_old" value="<?php echo $row['teachid']; ?>">
                <div class="form-group">
                    <input type="text" class="form-control" name="teachid" value="<?php echo $row['teachid']; ?>" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="fname" value="<?php echo $row['fname']; ?>" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="midname" value="<?php echo $row['midname']; ?>" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="lname" value="<?php echo $row['lname']; ?>" />
                </div>
                <div class="form-group">
                    <select name="college" class="form-control" required>
                        <option value="">Select College Department...</option>
                        <option <?php if ($row['college'] == 'CCS') echo "selected" ?>>CCS</option>
                        <option <?php if ($row['college'] == 'COA') echo "selected" ?>>COA</option>
                        <option <?php if ($row['college'] == 'CBA') echo "selected" ?>>CBA</option>
                        <option <?php if ($row['college'] == 'CHS') echo "selected" ?>>CHS</option>
                        <option <?php if ($row['college'] == 'COED') echo "selected" ?>>COED</option>
                        <option <?php if ($row['college'] == 'CAS') echo "selected" ?>>CAS</option>
                        <option <?php if ($row['college'] == 'CME') echo "selected" ?>>CME</option>
                        <option <?php if ($row['college'] == 'CHMT') echo "selected" ?>>CHMT</option>
                    </select>
                </div>
        </div>
        <div class="modal-footer">
            <a href="teacherlist.php"><button type="button" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</button></a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
            </form>
        </div>

<?php
    }
}

?>