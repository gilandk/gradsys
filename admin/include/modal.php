<!-- add modal for subject -->
<div class="modal fade" id="addsubject" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add Subject</h3>
            </div>

            <div class="modal-body">
                <form action="data/data_model.php?q=addsubject" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="code" placeholder="subject code" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="subject title" />
                    </div>

                    <div class="form-group">
                        <select name="college" class="form-control" required>
                            <option value="">Select College Department...</option>
                            <option>CCS</option>
                            <option>COA</option>
                            <option>CBA</option>
                            <option>CHS</option>
                            <option>COED</option>
                            <option>CAS</option>
                            <option>CME</option>
                            <option>CHMT</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="category" class="form-control" required>
                            <option value="">Select Category...</option>
                            <option>General Education</option>
                            <option>Professional Education</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="type" class="form-control" required>
                            <option value="">Select Subject Type...</option>
                            <option>Lecture</option>
                            <option>Laboratory</option>
                            <option>Lec-Lab</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" min="1" max="5" class="form-control" name="unit" placeholder='no. of units' required />
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- add modal for class info -->
<div class="modal fade" id="addclass" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add Class Info</h3>
            </div>
            <div class="modal-body">
                <form action="data/class_model.php?q=addclass" method="post">

                    <div class="form-group">
                        <select name="subject" class="form-control" required>
                            <option value="">Select Subject...</option>

                            <?php
                            $r = mysql_query("select * from subject");
                            while ($row = mysql_fetch_array($r)) :
                                ?>
                                <option value="<?php echo $row['code']; ?>"><?php echo $row['code']; ?> - (<?php echo $row['title']; ?>)</option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="mergesubject" class="form-control">
                            <option value="">Select Merge Subject...</option>
                            <?php
                            $r = mysql_query("select * from subject");
                            while ($row = mysql_fetch_array($r)) :
                                ?>
                                <option value="<?php echo $row['code']; ?>"><?php echo $row['code']; ?> - (<?php echo $row['title']; ?>)</option>
                            <?php endwhile; ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <select name="college" class="form-control" required>
                            <option value="">Select College Department...</option>
                            <option>CCS</option>
                            <option>COA</option>
                            <option>CBA</option>
                            <option>CHS</option>
                            <option>COED</option>
                            <option>CAS</option>
                            <option>CME</option>
                            <option>CHMT</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="course" class="form-control" required>
                            <option value="">Select Course...</option>
                            <!-- CCS -->
                            <option>BSIT</option>
                            <option>BSCS</option>
                            <option>BSCOE</option>
                            <option>ACT</option>
                            <!-- COA -->
                            <option>BSA</option>
                            <option>BSIS</option>
                            <option>BSAT</option>
                            <!-- CBA -->
                            <option>BSBA - HRDM</option>
                            <option>BSBA - FM</option>
                            <option>BSBA - OM</option>
                            <option>BSBA - MM</option>
                            <!-- CHS -->
                            <option>BSN</option>
                            <option>BSM</option>
                            <!-- COED -->
                            <option>BEED</option>
                            <option>BSED BIO</option>
                            <option>BSED MATH</option>
                            <option>BSED ENGLISH</option>
                            <option>BSED FIL</option>
                            <!-- CME -->
                            <option>BSME</option>
                            <!-- CAS -->
                            <option>AB Psy</option>
                            <option>AB Pol Scie</option>
                            <!-- CHMT -->
                            <option>BSHRM</option>
                            <option>BST</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="year" class="form-control" required>
                            <option value="">Select Year...</option>
                            <option>I</option>
                            <option>II</option>
                            <option>III</option>
                            <option>IV</option>
                            <option>V</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="section" class="form-control" required>
                            <option value="">Select Year...</option>
                            <option>A</option>
                            <option>B</option>
                            <option>C</option>
                            <option>D</option>
                            <option>E</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="sem" class="form-control" required>
                            <option value="">Select Semester...</option>
                            <option>1st</option>
                            <option>2nd</option>
                            <option>Summer</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="sy" class="form-control" required>
                            <option value="">Select S.Y.</option>
                            <?php $year = date('Y'); ?>
                            <?php for ($c = 10; $c > 0; $c--) : ?>
                                <option><?php echo $year; ?>-<?php echo $year + 1 ?></option>
                                <?php $year--; ?>
                            <?php endfor; ?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- add modal for student -->
<div class="modal fade" id="addstudent" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa fa-user"></i> Add Student</h3>
            </div>
            <div class="modal-body">
                <form action="data/student_model.php?q=addstudent" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="studid" placeholder="Student ID" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="fname" placeholder="First name" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="midname" placeholder="Middle name" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="lname" placeholder="Last name" />
                    </div>
                    <div class="form-group">
                        <select name="college" class="form-control" required>
                            <option value="">Select College Department...</option>
                            <option>CCS</option>
                            <option>COA</option>
                            <option>CBA</option>
                            <option>CHS</option>
                            <option>COED</option>
                            <option>CAS</option>
                            <option>CME</option>
                            <option>CHMT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="course" class="form-control" required>
                            <option value="">Select Course...</option>
                            <!-- CCS -->
                            <option>BSIT</option>
                            <option>BSCS</option>
                            <option>BSCOE</option>
                            <option>ACT</option>
                            <!-- COA -->
                            <option>BSA</option>
                            <option>BSIS</option>
                            <option>BSAT</option>
                            <!-- CBA -->
                            <option>BSBA - HRDM</option>
                            <option>BSBA - FM</option>
                            <option>BSBA - OM</option>
                            <option>BSBA - MM</option>
                            <!-- CHS -->
                            <option>BSN</option>
                            <option>BSM</option>
                            <!-- COED -->
                            <option>BEED</option>
                            <option>BSED BIO</option>
                            <option>BSED MATH</option>
                            <option>BSED ENGLISH</option>
                            <option>BSED FIL</option>
                            <!-- CME -->
                            <option>BSME</option>
                            <!-- CAS -->
                            <option>AB Psy</option>
                            <option>AB Pol Scie</option>
                            <!-- CHMT -->
                            <option>BSHRM</option>
                            <option>BST</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="year" class="form-control" required>
                            <option value="">Select Year...</option>
                            <option>I</option>
                            <option>II</option>
                            <option>III</option>
                            <option>IV</option>
                            <option>V</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="section" class="form-control" required>
                            <option value="">Select Year...</option>
                            <option>A</option>
                            <option>B</option>
                            <option>C</option>
                            <option>D</option>
                            <option>E</option>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- add modal for teacher -->
<div class="modal fade" id="addteacher" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa fa-user"></i> Add Instructor</h3>
            </div>
            <div class="modal-body">
                <form action="data/teacher_model.php?q=addteacher" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="teachid" placeholder="Instructor ID" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="fname" placeholder="First name" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="midname" placeholder="Middle name" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="lname" placeholder="Last name" />
                    </div>
                    <div class="form-group">
                        <select name="college" class="form-control" required>
                            <option value="">Select College Department...</option>
                            <option>CCS</option>
                            <option>COA</option>
                            <option>CBA</option>
                            <option>CHS</option>
                            <option>COED</option>
                            <option>CAS</option>
                            <option>CME</option>
                            <option>CHMT</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>