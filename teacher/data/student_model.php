<?php
    $student = new Datastudent();
    if(isset($_GET['q'])){
        $function = $_GET['q'];
        $student->$function();
    }

    class Datastudent {

        function __construct(){
            if(!isset($_SESSION['id'])){
                header('location:../../');

            }
        }

        function getstudentbyclass($classid){
            $q = "select * from studentsubject where classid=$classid";
            $r = mysql_query($q);
            $q3 = "select * from studentsubjectlec where classid=$classid";
            $r3 = mysql_query($q3);
            $q4 = "select * from studentsubjectlab where classid=$classid";
            $r4 = mysql_query($q4);
            $student = array();
            if($classid != null){
               while($row = mysql_fetch_array($r)){
                    $q2 = 'select * from student where id='.$row['studid'].'';
                    $r2 = mysql_query($q2);
                    $student[] = mysql_fetch_array($r2);
                }
                while($row = mysql_fetch_array($r3)){
                    $q2 = 'select * from student where id='.$row['studid'].'';
                    $r2 = mysql_query($q2);
                    $student[] = mysql_fetch_array($r2);
                }
                while($row = mysql_fetch_array($r4)){
                    $q2 = 'select * from student where id='.$row['studid'].'';
                    $r2 = mysql_query($q2);
                    $student[] = mysql_fetch_array($r2);
                }
            }
            return $student;
        }

        function getstudentbysearch($classid,$search){
            $q = "select * from student where fname like '%$search%' or lname like '%$search%' or midname like '%$search%' or studid like '%$search%'";
            $r = mysql_query($q);
            $student = array();
            while($row = mysql_fetch_array($r)){
                $q2 = 'select * from studentsubject where studid='.$row['id'].' and classid='.$classid.'';
                $r2 = mysql_query($q2);
                $q3 = 'select * from studentsubjectlec where studid='.$row['id'].' and classid='.$classid.'';
                $r3 = mysql_query($q3);
                $q4 = 'select * from studentsubjectlab where studid='.$row['id'].' and classid='.$classid.'';
                $r4 = mysql_query($q4);
                if(mysql_num_rows($r2) > 0) {
                    $student[] = $row;
                }
                elseif(mysql_num_rows($r3) > 0) {
                    $student[] = $row;
                }
                elseif(mysql_num_rows($r4) > 0) {
                    $student[] = $row;
                }
            }
            return $student;
        }

        function getsubjectcriteria($teachid,$classid){
            $q = "select * from criteria where teachid='$teachid' and classid='$classid'";
            $r = mysql_query($q);
            if($row = mysql_fetch_array($r)){

                $catt1 = ($row['catt1']) ;
                $catt2 = ($row['catt2']) ;
                $catt3 = ($row['catt3']) ;
                $catt4 = ($row['catt4']) ;

                $cexam1 = ($row['cexam1']) ;
                $cexam2 = ($row['cexam2']) ;
                $cexam3 = ($row['cexam3']) ;
                $cexam4 = ($row['cexam4']) ;
                
                $cproject1 = ($row['cproject1']) ;
                $cproject2 = ($row['cproject2']) ;
                $cproject3 = ($row['cproject3']) ;
                $cproject4 = ($row['cproject4']) ;

                $cquiz1 = ($row['cquiz1']) ;
                $cquiz2 = ($row['cquiz2']) ;
                $cquiz3 = ($row['cquiz3']) ;
                $cquiz4 = ($row['cquiz4']) ;

                $cass1 = ($row['cass1']) ;
                $cass2 = ($row['cass2']) ;
                $cass3 = ($row['cass3']) ;
                $cass4 = ($row['cass4']) ;

                $crec1 = ($row['crec1']) ;
                $crec2 = ($row['crec2']) ;
                $crec3 = ($row['crec3']) ;
                $crec4 = ($row['crec4']) ;

                $csw1 = ($row['csw1']) ;
                $csw2 = ($row['csw2']) ;
                $csw3 = ($row['csw3']) ;
                $csw4 = ($row['csw4']) ;

                $cgw1 = ($row['cgw1']) ;
                $cgw2 = ($row['cgw2']) ;
                $cgw3 = ($row['cgw3']) ;
                $cgw4 = ($row['cgw4']) ;

                $ccharc1 = ($row['ccharc1']) ;
                $ccharc2 = ($row['ccharc2']) ;
                $ccharc3 = ($row['ccharc3']) ;
                $ccharc4 = ($row['ccharc4']) ;

                $wdprelim = ($row['wdprelim']) ;
                $wdmidterm = ($row['wdmidterm']) ;
                $wdsemifinal = ($row['wdsemifinal']);
                $wdfinal = ($row['wdfinal']) ;

                $cstandlec1 = ($row['cstandlec1']) ;
                $cstandlec2 = ($row['cstandlec2']) ;
                $cstandlec3 = ($row['cstandlec3']) ;
                $cstandlec4 = ($row['cstandlec4']) ;
                
                $cstandp1 = $cquiz1 + $cass1 + $crec1 + $csw1 + $cgw1;
                $cstandp2 = $cquiz2 + $cass2 + $crec2 + $csw2 + $cgw2;
                $cstandp3 = $cquiz3 + $cass3 + $crec3 + $csw3 + $cgw3;
                $cstandp4 = $cquiz4 + $cass4 + $crec4 + $csw4 + $cgw4;

                $cprelim = $catt1 + $cexam1 + $cproject1 + $cstandlec1 + $ccharc1;
                $cmidterm = $catt2 + $cexam2 + $cproject2 + $cstandlec2 + $ccharc2;
                $csemifinal = $catt3 + $cexam3 + $cproject3 + $cstandlec3 + $ccharc3;
                $cfinal= $catt4 + $cexam4 + $cproject4 + $cstandlec4 + $ccharc4;

                $ctotal = $wdprelim + $wdmidterm + $wdsemifinal + $wdfinal;

                $data = array(

                    'cprelim' => ($cprelim),
                    'cmidterm' => ($cmidterm),
                    'csemifinal' => ($csemifinal),
                    'cfinal' => ($cfinal),
                    'ctotal' => ($ctotal),
                    'cstandp1' => ($cstandp1),
                    'cstandp2' => ($cstandp2),
                    'cstandp3' => ($cstandp3),
                    'cstandp4' => ($cstandp4),
                    'catt1' => $row['catt1'],
                    'catt2' => $row['catt2'],
                    'catt3' => $row['catt3'],
                    'catt4' => $row['catt4'],
                    'cexam1' => $row['cexam1'],
                    'cexam2' => $row['cexam2'],
                    'cexam3' => $row['cexam3'],
                    'cexam4' => $row['cexam4'],
                    'cproject1' => $row['cproject1'],
                    'cproject2' => $row['cproject2'],
                    'cproject3' => $row['cproject3'],
                    'cproject4' => $row['cproject4'],
                    'cquiz1' => $row['cquiz1'],
                    'cquiz2' => $row['cquiz2'],
                    'cquiz3' => $row['cquiz3'],
                    'cquiz4' => $row['cquiz4'],
                    'cass1' => $row['cass1'],
                    'cass2' => $row['cass2'],
                    'cass3' => $row['cass3'],
                    'cass4' => $row['cass4'],
                    'crec1' => $row['crec1'],
                    'crec2' => $row['crec2'],
                    'crec3' => $row['crec3'],
                    'crec4' => $row['crec4'],
                    'csw1' => $row['csw1'],
                    'csw2' => $row['csw2'],
                    'csw3' => $row['csw3'],
                    'csw4' => $row['csw4'],
                    'cgw1' => $row['cgw1'],
                    'cgw2' => $row['cgw2'],
                    'cgw3' => $row['cgw3'],
                    'cgw4' => $row['cgw4'],
                    'ccharc1' => $row['ccharc1'],
                    'ccharc2' => $row['ccharc2'],
                    'ccharc3' => $row['ccharc3'],
                    'ccharc4' => $row['ccharc4'],
                    'wdprelim' => $row['wdprelim'],
                    'wdmidterm' => $row['wdmidterm'],
                    'wdsemifinal' => $row['wdsemifinal'],
                    'wdfinal' => $row['wdfinal'],
                    'ccstand1' => $row['ccstand1'],
                    'ccstand2' => $row['ccstand2'],
                    'ccstand3' => $row['ccstand3'],
                    'ccstand4' => $row['ccstand4'],
                    'cstandlec1' => $row['cstandlec1'],
                    'cstandlec2' => $row['cstandlec2'],
                    'cstandlec3' => $row['cstandlec3'],
                    'cstandlec4' => $row['cstandlec4'],
                );
            }

            return $data;
        }

        function getsubjectcriterialeclab($teachid,$classid){
            $q = "select * from criteria where teachid='$teachid' and classid='$classid'";
            $r = mysql_query($q);
            if($row = mysql_fetch_array($r)){

                $catt1 = ($row['catt1']) ;
                $catt2 = ($row['catt2']) ;
                $catt3 = ($row['catt3']) ;
                $catt4 = ($row['catt4']) ;

                $cexam1 = ($row['cexam1']) ;
                $cexam2 = ($row['cexam2']) ;
                $cexam3 = ($row['cexam3']) ;
                $cexam4 = ($row['cexam4']) ;

                //LEC

                $cquiz1 = ($row['cquiz1']) ;
                $cquiz2 = ($row['cquiz2']) ;
                $cquiz3 = ($row['cquiz3']) ;
                $cquiz4 = ($row['cquiz4']) ;

                $cass1 = ($row['cass1']) ;
                $cass2 = ($row['cass2']) ;
                $cass3 = ($row['cass3']) ;
                $cass4 = ($row['cass4']) ;

                $crec1 = ($row['crec1']) ;
                $crec2 = ($row['crec2']) ;
                $crec3 = ($row['crec3']) ;
                $crec4 = ($row['crec4']) ;

                $csw1 = ($row['csw1']) ;
                $csw2 = ($row['csw2']) ;
                $csw3 = ($row['csw3']) ;
                $csw4 = ($row['csw4']) ;

                $cgw1 = ($row['cgw1']) ;
                $cgw2 = ($row['cgw2']) ;
                $cgw3 = ($row['cgw3']) ;
                $cgw4 = ($row['cgw4']) ;

                //LAB

                $chon1 = ($row['chon1']) ;
                $chon2 = ($row['chon2']) ;
                $chon3 = ($row['chon3']) ;
                $chon4 = ($row['chon4']) ;

                $ccstudy1 = ($row['ccstudy1']) ;
                $ccstudy2 = ($row['ccstudy2']) ;
                $ccstudy3 = ($row['ccstudy3']) ;
                $ccstudy4 = ($row['ccstudy4']) ;
                
                $cact1 = ($row['cact1']) ;
                $cact2 = ($row['cact2']) ;
                $cact3 = ($row['cact3']) ;
                $cact4 = ($row['cact4']) ;

                $chexam1 = ($row['chexam1']);
                $chexam2 = ($row['chexam2']);
                $chexam3 = ($row['chexam3']);
                $chexam4 = ($row['chexam4']);
          
                $cproject1 = ($row['cproject1']) ;
                $cproject2 = ($row['cproject2']) ;
                $cproject3 = ($row['cproject3']) ;
                $cproject4 = ($row['cproject4']) ;

                $ccharc1 = ($row['ccharc1']) ;
                $ccharc2 = ($row['ccharc2']) ;
                $ccharc3 = ($row['ccharc3']) ;
                $ccharc4 = ($row['ccharc4']) ;

                $wdprelim = ($row['wdprelim']) ;
                $wdmidterm = ($row['wdmidterm']) ;
                $wdsemifinal = ($row['wdsemifinal']) ;
                $wdfinal = ($row['wdfinal']) ;

                $ccstand1 = ($row['ccstand1']) ;
                $ccstand2 = ($row['ccstand2']) ;
                $ccstand3 = ($row['ccstand3']) ;
                $ccstand4 = ($row['ccstand4']) ;

                $cstandlec1 = ($row['cstandlec1']) ;
                $cstandlec2 = ($row['cstandlec2']) ;
                $cstandlec3 = ($row['cstandlec3']) ;
                $cstandlec4 = ($row['cstandlec4']) ;

                $cstandlab1 = ($row['cstandlab1']) ;
                $cstandlab2 = ($row['cstandlab2']) ;
                $cstandlab3 = ($row['cstandlab3']) ;
                $cstandlab4 = ($row['cstandlab4']) ;

                $cstandlecp1 = $cquiz1 + $cass1 + $crec1 + $csw1 + $cgw1;
                $cstandlecp2 = $cquiz2 + $cass2 + $crec2 + $csw2 + $cgw2;
                $cstandlecp3 = $cquiz3 + $cass3 + $crec3 + $csw3 + $cgw3;
                $cstandlecp4 = $cquiz4 + $cass4 + $crec4 + $csw4 + $cgw4;

                $cstandlabp1 = $chon1 + $ccstudy1 + $cact1 + $chexam1;
                $cstandlabp2 = $chon2 + $ccstudy2 + $cact2 + $chexam2;
                $cstandlabp3 = $chon3 + $ccstudy3 + $cact3 + $chexam3;
                $cstandlabp4 = $chon4 + $ccstudy4 + $cact4 + $chexam4;
                
                $cstandp1 = $cstandlec1 + $cstandlab1;
                $cstandp2 = $cstandlec2 + $cstandlab2;
                $cstandp3 = $cstandlec3 + $cstandlab3;
                $cstandp4 = $cstandlec4 + $cstandlab4;

                $cprelim = $catt1 + $cexam1 + $ccstand1 + $cproject1 + $ccharc1;

                $cmidterm = $catt2 + $cexam2 + $ccstand2 + $cproject2 + $ccharc2;
                
                $csemifinal = $catt3 + $cexam3 + $ccstand3 + $cproject3 + $ccharc3;
                
                $cfinal= $catt4 + $cexam4 + $ccstand4 + $cproject4 + $ccharc4;

                $ctotal = $wdprelim + $wdmidterm + $wdsemifinal + $wdfinal;

                $data = array(

                    'cprelim' => ($cprelim),
                    'cmidterm' => ($cmidterm),
                    'csemifinal' => ($csemifinal),
                    'cfinal' => ($cfinal),
                    'ctotal' => ($ctotal),
                    'cstandp1' => ($cstandp1),
                    'cstandp2' => ($cstandp2),
                    'cstandp3' => ($cstandp3),
                    'cstandp4' => ($cstandp4),
                    'cstandlecp1' => ($cstandlecp1),
                    'cstandlecp2' => ($cstandlecp2),
                    'cstandlecp3' => ($cstandlecp3),
                    'cstandlecp4' => ($cstandlecp4),
                    'cstandlabp1' => ($cstandlabp1),
                    'cstandlabp2' => ($cstandlabp2),
                    'cstandlabp3' => ($cstandlabp3),
                    'cstandlabp4' => ($cstandlabp4),
                    'catt1' => $row['catt1'],
                    'catt2' => $row['catt2'],
                    'catt3' => $row['catt3'],
                    'catt4' => $row['catt4'],
                    'cexam1' => $row['cexam1'],
                    'cexam2' => $row['cexam2'],
                    'cexam3' => $row['cexam3'],
                    'cexam4' => $row['cexam4'],
                    'cquiz1' => $row['cquiz1'],
                    'cquiz2' => $row['cquiz2'],
                    'cquiz3' => $row['cquiz3'],
                    'cquiz4' => $row['cquiz4'],
                    'cass1' => $row['cass1'],
                    'cass2' => $row['cass2'],
                    'cass3' => $row['cass3'],
                    'cass4' => $row['cass4'],
                    'crec1' => $row['crec1'],
                    'crec2' => $row['crec2'],
                    'crec3' => $row['crec3'],
                    'crec4' => $row['crec4'],
                    'csw1' => $row['csw1'],
                    'csw2' => $row['csw2'],
                    'csw3' => $row['csw3'],
                    'csw4' => $row['csw4'],
                    'cgw1' => $row['cgw1'],
                    'cgw2' => $row['cgw2'],
                    'cgw3' => $row['cgw3'],
                    'cgw4' => $row['cgw4'],
                    'chon1' => $row['chon1'],
                    'chon2' => $row['chon2'],
                    'chon3' => $row['chon3'],
                    'chon4' => $row['chon4'],
                    'ccstudy1' => $row['ccstudy1'],
                    'ccstudy2' => $row['ccstudy2'],
                    'ccstudy3' => $row['ccstudy3'],
                    'ccstudy4' => $row['ccstudy4'],
                    'cact1' => $row['cact1'],
                    'cact2' => $row['cact2'],
                    'cact3' => $row['cact3'],
                    'cact4' => $row['cact4'],
                    'chexam1' => $row['chexam1'],
                    'chexam2' => $row['chexam2'],
                    'chexam3' => $row['chexam3'],
                    'chexam4' => $row['chexam4'],
                    'ccharc1' => $row['ccharc1'],
                    'ccharc2' => $row['ccharc2'],
                    'ccharc3' => $row['ccharc3'],
                    'ccharc4' => $row['ccharc4'],
                    'cproject1' => $row['cproject1'],
                    'cproject2' => $row['cproject2'],
                    'cproject3' => $row['cproject3'],
                    'cproject4' => $row['cproject4'],
                    'wdprelim' => $row['wdprelim'],
                    'wdmidterm' => $row['wdmidterm'],
                    'wdsemifinal' => $row['wdsemifinal'],
                    'wdfinal' => $row['wdfinal'],
                    'ccstand1' => $row['ccstand1'],
                    'ccstand2' => $row['ccstand2'],
                    'ccstand3' => $row['ccstand3'],
                    'ccstand4' => $row['ccstand4'],
                    'cstandlab1' => $row['cstandlab1'],
                    'cstandlab2' => $row['cstandlab2'],
                    'cstandlab3' => $row['cstandlab3'],
                    'cstandlab4' => $row['cstandlab4'],
                    'cstandlec1' => $row['cstandlec1'],
                    'cstandlec2' => $row['cstandlec2'],
                    'cstandlec3' => $row['cstandlec3'],
                    'cstandlec4' => $row['cstandlec4'],

                );
            }

            return $data;
        }

        function getsubjectcriterialab($teachid,$classid){
            $q = "select * from criteria where teachid='$teachid' and classid='$classid'";
            $r = mysql_query($q);
            if($row = mysql_fetch_array($r)){

                $catt1 = ($row['catt1']);
                $catt2 = ($row['catt2']);
                $catt3 = ($row['catt3']);
                $catt4 = ($row['catt4']); 

                //LAB

                $chon1 = ($row['chon1']);
                $chon2 = ($row['chon2']);
                $chon3 = ($row['chon3']);
                $chon4 = ($row['chon4']);

                $ccstudy1 = ($row['ccstudy1']);
                $ccstudy2 = ($row['ccstudy2']);
                $ccstudy3 = ($row['ccstudy3']);
                $ccstudy4 = ($row['ccstudy4']);
                
                $cact1 = ($row['cact1']);
                $cact2 = ($row['cact2']);
                $cact3 = ($row['cact3']);
                $cact4 = ($row['cact4']);

                $chexam1 = ($row['chexam1']);
                $chexam2 = ($row['chexam2']);
                $chexam3 = ($row['chexam3']);
                $chexam4 = ($row['chexam4']);

                //end
          
                $cproject1 = ($row['cproject1']);
                $cproject2 = ($row['cproject2']);
                $cproject3 = ($row['cproject3']);
                $cproject4 = ($row['cproject4']);

                $wdprelim = ($row['wdprelim']);
                $wdmidterm = ($row['wdmidterm']);
                $wdsemifinal = ($row['wdsemifinal']);
                $wdfinal = ($row['wdfinal']);

                $cstandlab1 = ($row['cstandlab1']) ;
                $cstandlab2 = ($row['cstandlab2']) ;
                $cstandlab3 = ($row['cstandlab3']) ;
                $cstandlab4 = ($row['cstandlab4']) ;

                $cstandp1 = $chon1 + $ccstudy1 + $cact1 + $chexam1;
                $cstandp2 = $chon2 + $ccstudy2 + $cact2 + $chexam2;
                $cstandp3 = $chon3 + $ccstudy3 + $cact3 + $chexam3;
                $cstandp4 = $chon4 + $ccstudy4 + $cact4 + $chexam4;

                $cprelim = $catt1 + $cstandlab1 + $cproject1;
                $cmidterm = $catt2 + $cstandlab2 + $cproject2;
                $csemifinal = $catt3 + $cstandlab3 + $cproject3;
                $cfinal= $catt4 + $cstandlab4 + $cproject4;

                $ctotal = $wdprelim + $wdmidterm + $wdsemifinal + $wdfinal;

                $data = array(

                    'cprelim' => ($cprelim),
                    'cmidterm' => ($cmidterm),
                    'csemifinal' => ($csemifinal),
                    'cfinal' => ($cfinal),
                    'ctotal' => ($ctotal),
                    'cstandp1' => ($cstandp1),
                    'cstandp2' => ($cstandp2),
                    'cstandp3' => ($cstandp3),
                    'cstandp4' => ($cstandp4),
                    'catt1' => $row['catt1'],
                    'catt2' => $row['catt2'],
                    'catt3' => $row['catt3'],
                    'catt4' => $row['catt4'],
                    'chon1' => $row['chon1'],
                    'chon2' => $row['chon2'],
                    'chon3' => $row['chon3'],
                    'chon4' => $row['chon4'],
                    'ccstudy1' => $row['ccstudy1'],
                    'ccstudy2' => $row['ccstudy2'],
                    'ccstudy3' => $row['ccstudy3'],
                    'ccstudy4' => $row['ccstudy4'],
                    'cact1' => $row['cact1'],
                    'cact2' => $row['cact2'],
                    'cact3' => $row['cact3'],
                    'cact4' => $row['cact4'],
                    'chexam1' => $row['chexam1'],
                    'chexam2' => $row['chexam2'],
                    'chexam3' => $row['chexam3'],
                    'chexam4' => $row['chexam4'],
                    'cproject1' => $row['cproject1'],
                    'cproject2' => $row['cproject2'],
                    'cproject3' => $row['cproject3'],
                    'cproject4' => $row['cproject4'],
                    'wdprelim' => $row['wdprelim'],
                    'wdmidterm' => $row['wdmidterm'],
                    'wdsemifinal' => $row['wdsemifinal'],
                    'wdfinal' => $row['wdfinal'],
                    'cstandlab1' => $row['cstandlab1'],
                    'cstandlab2' => $row['cstandlab2'],
                    'cstandlab3' => $row['cstandlab3'],
                    'cstandlab4' => $row['cstandlab4'],
                );
            }

            return $data;
        }

        function getstudentgrade($studid, $classid){
            
            $id = $_SESSION['id'];
            $q = "select * from teacher where teachid='$id'";
            $r = mysql_query($q);
            if ($row = mysql_fetch_array($r)) {
                $id = $row['id'];
            }

            $q = "SELECT * FROM `studentsubjectlec` LEFT JOIN criteria ON studentsubjectlec.classid = criteria.classid WHERE studentsubjectlec.studid='$studid' and criteria.teachid='$id'";
            $r = mysql_query($q);
            if($row = mysql_fetch_array($r)){

                $att1 = ($row['att1']) * (($row['catt1']) / 100 );
                $att2 = ($row['att2']) * (($row['catt2']) / 100 );
                $att3 = ($row['att3']) * (($row['catt3']) / 100 );
                $att4 = ($row['att4']) * (($row['catt4']) / 100 );

                $exam1 = ($row['exam1']) *  (($row['cexam1']) / 100);
                $exam2 = ($row['exam2']) *  (($row['cexam2']) / 100);
                $exam3 = ($row['exam3']) *  (($row['cexam3']) / 100);
                $exam4 = ($row['exam4']) *  (($row['cexam4']) / 100);

                $quiz1 = ($row['quiz1']) * (($row['cquiz1']) / 100);
                $quiz2 = ($row['quiz2']) * (($row['cquiz2']) / 100);
                $quiz3 = ($row['quiz3']) * (($row['cquiz3']) / 100);
                $quiz4 = ($row['quiz4']) * (($row['cquiz4']) / 100);

                $ass1 = ($row['ass1']) * (($row['cass1']) / 100);
                $ass2 = ($row['ass2']) * (($row['cass2']) / 100);
                $ass3 = ($row['ass3']) * (($row['cass3']) / 100);
                $ass4 = ($row['ass4']) * (($row['cass4']) / 100);

                $rec1 = ($row['rec1']) * (($row['crec1']) / 100);
                $rec2 = ($row['rec2']) * (($row['crec2']) / 100);
                $rec3 = ($row['rec3']) * (($row['crec3']) / 100);
                $rec4 = ($row['rec4']) * (($row['crec4']) / 100);

                $sw1 = ($row['sw1']) * (($row['csw1']) / 100);
                $sw2 = ($row['sw2']) * (($row['csw2']) / 100);
                $sw3 = ($row['sw3']) * (($row['csw3']) / 100);
                $sw4 = ($row['sw4']) * (($row['csw4']) / 100);

                $gw1 = ($row['gw1']) * (($row['cgw1']) / 100);
                $gw2 = ($row['gw2']) * (($row['cgw2']) / 100);
                $gw3 = ($row['gw3']) * (($row['cgw3']) / 100);
                $gw4 = ($row['gw4']) * (($row['cgw4']) / 100);

                $project1 = ($row['project1']) * (($row['cproject1']) / 100);
                $project2 = ($row['project2']) * (($row['cproject2']) / 100);
                $project3 = ($row['project3']) * (($row['cproject3']) / 100);
                $project4 = ($row['project4']) * (($row['cproject4']) / 100);

                $charc1 = ($row['charc1']) * (($row['ccharc1']) / 100);
                $charc2 = ($row['charc2']) * (($row['ccharc2']) / 100);
                $charc3 = ($row['charc3']) * (($row['ccharc3']) / 100);
                $charc4 = ($row['charc4']) * (($row['ccharc4']) / 100);

                $lecprelim = ($quiz1 + $ass1 + $rec1 + $sw1 + $gw1) * (($row['cstandlec1']) / 100);
                $lecmidterm = ($quiz2 + $ass2 + $rec2 + $sw2 + $gw2) * (($row['cstandlec2']) / 100);
                $lecsemis = ($quiz3 +  $ass3 + $rec3 + $sw3 + $gw3) * (($row['cstandlec3']) / 100);
                $lecfinals = ($quiz4 + $ass4 + $rec4 + $sw4 + $gw4) * (($row['cstandlec4']) / 100);

                $prelim = $att1 + $exam1 + $project1 + $lecprelim + $charc1;
                $midterm = $att2 + $exam2 + $project2 + $lecmidterm + $charc2;
                $semifinal = $att3 + $exam3 + $project3 + $lecsemis + $charc3;
                $final = $att4 + $exam4 + $project4 + $lecfinals + $charc4;

                $total = ($prelim * (($row['wdprelim']) / 100)) + ($midterm * (($row['wdmidterm']) / 100)) + ($semifinal * (($row['wdsemifinal']) / 100)) + ($final * (($row['wdfinal']) / 100));

                $data = array(
                    'eqtotal' => $this->gradeconversion($total),
                    'prelim' =>number_format($prelim, 2),
                    'midterm' =>number_format($midterm, 2),
                    'semifinal' =>number_format($semifinal, 2),
                    'final' =>number_format($final, 2),
                    'total' =>number_format($total, 2),
                    'att1' => $row['att1'],
                    'att2' => $row['att2'],
                    'att3' => $row['att3'],
                    'att4' => $row['att4'],
                    'exam1' => $row['exam1'],
                    'exam2' => $row['exam2'],
                    'exam3' => $row['exam3'],
                    'exam4' => $row['exam4'],
                    'project1' => $row['project1'],
                    'project2' => $row['project2'],
                    'project3' => $row['project3'],
                    'project4' => $row['project4'],
                    'quiz1' => $row['quiz1'],
                    'quiz2' => $row['quiz2'],
                    'quiz3' => $row['quiz3'],
                    'quiz4' => $row['quiz4'],
                    'ass1' => $row['ass1'],
                    'ass2' => $row['ass2'],
                    'ass3' => $row['ass3'],
                    'ass4' => $row['ass4'],
                    'rec1' => $row['rec1'],
                    'rec2' => $row['rec2'],
                    'rec3' => $row['rec3'],
                    'rec4' => $row['rec4'],
                    'sw1' => $row['sw1'],
                    'sw2' => $row['sw2'],
                    'sw3' => $row['sw3'],
                    'sw4' => $row['sw4'],
                    'gw1' => $row['gw1'],
                    'gw2' => $row['gw2'],
                    'gw3' => $row['gw3'],
                    'gw4' => $row['gw4'],
                    'charc1' => $row['charc1'],
                    'charc2' => $row['charc2'],
                    'charc3' => $row['charc3'],
                    'charc4' => $row['charc4'],

                    'cstandlec1' =>$row['cstandlec1'],
                    'cstandlec2' =>$row['cstandlec2'],
                    'cstandlec3' =>$row['cstandlec3'],
                    'cstandlec4' =>$row['cstandlec4'],
                    'cproject1' =>$row['cproject1'],
                    'cproject2' =>$row['cproject2'],
                    'cproject3' =>$row['cproject3'],
                    'cproject4' =>$row['cproject4'],
                );
            }

            return $data;
        }

        function getstudentgradelab($studid,$classid){
            $id = $_SESSION['id'];
            $q = "select * from teacher where teachid='$id'";
            $r = mysql_query($q);
            if ($row = mysql_fetch_array($r)) {
                $id = $row['id'];
            }

            $q = "SELECT * FROM `studentsubjectlab` LEFT JOIN criteria ON studentsubjectlab.classid = criteria.classid WHERE studentsubjectlab.studid='$studid' and criteria.teachid='$id'";
            $r = mysql_query($q);
            if($row = mysql_fetch_array($r)){

                $att1 = ($row['att1']) * (($row['catt1']) / 100 );
                $att2 = ($row['att2']) * (($row['catt2']) / 100 );
                $att3 = ($row['att3']) * (($row['catt3']) / 100 );
                $att4 = ($row['att4']) * (($row['catt4']) / 100 );

                //LAB

                $hon1 = ($row['hon1']) * (($row['chon1']) / 100);
                $hon2 = ($row['hon2']) * (($row['chon2']) / 100);
                $hon3 = ($row['hon3']) * (($row['chon3']) / 100);
                $hon4 = ($row['hon4']) * (($row['chon4']) / 100);

                $cstudy1 = ($row['cstudy1']) * (($row['ccstudy1']) / 100);
                $cstudy2 = ($row['cstudy2']) * (($row['ccstudy2']) / 100);
                $cstudy3 = ($row['cstudy3']) * (($row['ccstudy3']) / 100);
                $cstudy4 = ($row['cstudy4']) * (($row['ccstudy4']) / 100);
                
                $act1 = ($row['act1']) * (($row['cact1']) / 100);
                $act2 = ($row['act2']) * (($row['cact2']) / 100);
                $act3 = ($row['act3']) * (($row['cact3']) / 100);
                $act4 = ($row['act4']) * (($row['cact4']) / 100);

                $hexam1 = ($row['hexam1']) * (($row['chexam1']) / 100);
                $hexam2 = ($row['hexam2']) * (($row['chexam2']) / 100);
                $hexam3 = ($row['hexam3']) * (($row['chexam3']) / 100);
                $hexam4 = ($row['hexam4']) * (($row['chexam4']) / 100);

                 //END
                
                $project1 = ($row['project1']) * (($row['cproject1']) / 100);
                $project2 = ($row['project2']) * (($row['cproject2']) / 100);
                $project3 = ($row['project3']) * (($row['cproject3']) / 100);
                $project4 = ($row['project4']) * (($row['cproject4']) / 100);


                $labprelim = ($hon1 + $cstudy1 + $act1 + $hexam1) * (($row['cstandlab1']) / 100);
                $labmidterm = ($hon2 + $cstudy2 + $act2 + $hexam2) * (($row['cstandlab2']) / 100);
                $labsemis = ($hon3 + $cstudy3 + $act3 + $hexam3) * (($row['cstandlab3']) / 100);
                $labfinals = ($hon4 + $cstudy4 + $act4 + $hexam4) * (($row['cstandlab4']) / 100);


                $prelim = $att1 + $labprelim + $project1;
                $midterm = $att2 + $labmidterm + $project2;
                $semifinal = $att3 + $labsemis + $project3;
                $final = $att4 + $labfinals  + $project4;

                $total = ($prelim * (($row['wdprelim']) / 100)) + ($midterm * (($row['wdmidterm']) / 100)) + ($semifinal * (($row['wdsemifinal']) / 100)) + ($final * (($row['wdfinal']) / 100));

                $data = array(
                    'eqtotal' => $this->gradeconversion($total),
                    'prelim' =>number_format($prelim, 2),
                    'midterm' =>number_format($midterm, 2),
                    'semifinal' =>number_format($semifinal, 2),
                    'final' =>number_format($final, 2),
                    'total' =>number_format($total, 2),
                    'att1' => $row['att1'],
                    'att2' => $row['att2'],
                    'att3' => $row['att3'],
                    'att4' => $row['att4'],
                    'hon1' => $row['hon1'],
                    'hon2' => $row['hon2'],
                    'hon3' => $row['hon3'],
                    'hon4' => $row['hon4'],
                    'cstudy1' => $row['cstudy1'],
                    'cstudy2' => $row['cstudy2'],
                    'cstudy3' => $row['cstudy3'],
                    'cstudy4' => $row['cstudy4'],
                    'act1' => $row['act1'],
                    'act2' => $row['act2'],
                    'act3' => $row['act3'],
                    'act4' => $row['act4'],
                    'hexam1' => $row['hexam1'],
                    'hexam2' => $row['hexam2'],
                    'hexam3' => $row['hexam3'],
                    'hexam4' => $row['hexam4'],
                    'project1' => $row['project1'],
                    'project2' => $row['project2'],
                    'project3' => $row['project3'],
                    'project4' => $row['project4'],

                    'cproject1' => $row['cproject1'],
                    'cproject2' => $row['cproject2'],
                    'cproject3' => $row['cproject3'],
                    'cproject4' => $row['cproject4'],
                    'ccstand1' => $row['ccstand1'],
                    'ccstand2' => $row['ccstand2'],
                    'ccstand3' => $row['ccstand3'],
                    'ccstand4' => $row['ccstand4'],
                    'cstandlab1' => $row['cstandlab1'],
                    'cstandlab2' => $row['cstandlab2'],
                    'cstandlab3' => $row['cstandlab3'],
                    'cstandlab4' => $row['cstandlab4'],
                );
            }

            return $data;
        }
        

        function getstudentgradeleclab($studid,$id){

            $id = $_SESSION['id'];
            $q = "select * from teacher where teachid='$id'";
            $r = mysql_query($q);
            if ($row = mysql_fetch_array($r)) {
                $id = $row['id'];
            }

            $q = "SELECT * FROM `studentsubject` INNER JOIN criteria ON studentsubject.classid = criteria.classid WHERE studentsubject.studid='$studid' and criteria.teachid='$id'";
            $r = mysql_query($q);


            if($row = mysql_fetch_array($r)){

                $att1 = ($row['att1']) * (($row['catt1']) / 100 );
                $att2 = ($row['att2']) * (($row['catt2']) / 100 );
                $att3 = ($row['att3']) * (($row['catt3']) / 100 );
                $att4 = ($row['att4']) * (($row['catt4']) / 100 );

                $exam1 = ($row['exam1']) *  (($row['cexam1']) / 100);
                $exam2 = ($row['exam2']) *  (($row['cexam2']) / 100);
                $exam3 = ($row['exam3']) *  (($row['cexam3']) / 100);
                $exam4 = ($row['exam4']) *  (($row['cexam4']) / 100);

                //Lecture

                $quiz1 = ($row['quiz1']) * (($row['cquiz1']) / 100);
                $quiz2 = ($row['quiz2']) * (($row['cquiz2']) / 100);
                $quiz3 = ($row['quiz3']) * (($row['cquiz3']) / 100);
                $quiz4 = ($row['quiz4']) * (($row['cquiz4']) / 100);

                $ass1 = ($row['ass1']) * (($row['cass1']) / 100);
                $ass2 = ($row['ass2']) * (($row['cass2']) / 100);
                $ass3 = ($row['ass3']) * (($row['cass3']) / 100);
                $ass4 = ($row['ass4']) * (($row['cass4']) / 100);

                $rec1 = ($row['rec1']) * (($row['crec1']) / 100);
                $rec2 = ($row['rec2']) * (($row['crec2']) / 100);
                $rec3 = ($row['rec3']) * (($row['crec3']) / 100);
                $rec4 = ($row['rec4']) * (($row['crec4']) / 100);

                $sw1 = ($row['sw1']) * (($row['csw1']) / 100);
                $sw2 = ($row['sw2']) * (($row['csw2']) / 100);
                $sw3 = ($row['sw3']) * (($row['csw3']) / 100);
                $sw4 = ($row['sw4']) * (($row['csw4']) / 100);

                $gw1 = ($row['gw1']) * (($row['cgw1']) / 100);
                $gw2 = ($row['gw2']) * (($row['cgw2']) / 100);
                $gw3 = ($row['gw3']) * (($row['cgw3']) / 100);
                $gw4 = ($row['gw4']) * (($row['cgw4']) / 100);

                //END

                //LAB

                $hon1 = ($row['hon1']) * (($row['chon1']) / 100);
                $hon2 = ($row['hon2']) * (($row['chon2']) / 100);
                $hon3 = ($row['hon3']) * (($row['chon3']) / 100);
                $hon4 = ($row['hon4']) * (($row['chon4']) / 100);

                $cstudy1 = ($row['cstudy1']) * (($row['ccstudy1']) / 100);
                $cstudy2 = ($row['cstudy2']) * (($row['ccstudy2']) / 100);
                $cstudy3 = ($row['cstudy3']) * (($row['ccstudy3']) / 100);
                $cstudy4 = ($row['cstudy4']) * (($row['ccstudy4']) / 100);
                
                $act1 = ($row['act1']) * (($row['cact1']) / 100);
                $act2 = ($row['act2']) * (($row['cact2']) / 100);
                $act3 = ($row['act3']) * (($row['cact3']) / 100);
                $act4 = ($row['act4']) * (($row['cact4']) / 100);

                $hexam1 = ($row['hexam1']) * (($row['chexam1']) / 100);
                $hexam2 = ($row['hexam2']) * (($row['chexam2']) / 100);
                $hexam3 = ($row['hexam3']) * (($row['chexam3']) / 100);
                $hexam4 = ($row['hexam4']) * (($row['chexam4']) / 100);

                 //END
                
                $project1 = ($row['project1']) * (($row['cproject1']) / 100);
                $project2 = ($row['project2']) * (($row['cproject2']) / 100);
                $project3 = ($row['project3']) * (($row['cproject3']) / 100);
                $project4 = ($row['project4']) * (($row['cproject4']) / 100);

                $charc1 = ($row['charc1']) * (($row['ccharc1']) / 100);
                $charc2 = ($row['charc2']) * (($row['ccharc2']) / 100);
                $charc3 = ($row['charc3']) * (($row['ccharc3']) / 100);
                $charc4 = ($row['charc4']) * (($row['ccharc4']) / 100);

                $lecprelim = ($quiz1 + $ass1 + $rec1 + $sw1 + $gw1) * (($row['cstandlec1']) / 100);
                $lecmidterm = ($quiz2 + $ass2 + $rec2 + $sw2 + $gw2) * (($row['cstandlec2']) / 100);
                $lecsemis = ($quiz3 +  $ass3 + $rec3 + $sw3 + $gw3) * (($row['cstandlec3']) / 100);
                $lecfinals = ($quiz4 + $ass4 + $rec4 + $sw4 + $gw4) * (($row['cstandlec4']) / 100);

                $labprelim = ($hon1 + $cstudy1 + $act1 + $hexam1) * (($row['cstandlab1']) / 100);
                $labmidterm = ($hon2 + $cstudy2 + $act2 + $hexam2) * (($row['cstandlab2']) / 100);
                $labsemis = ($hon3 + $cstudy3 + $act3 + $hexam3) * (($row['cstandlab3']) / 100);
                $labfinals = ($hon4 + $cstudy4 + $act4 + $hexam4) * (($row['cstandlab4']) / 100);

                $csprelim = ($lecprelim + $labprelim) * (($row['ccstand1']) / 100);
                $csmidterm = ($lecmidterm + $labmidterm) * (($row['ccstand2']) / 100);
                $csemis = ($lecsemis + $labsemis) * (($row['ccstand3']) / 100);
                $csfinals = ($lecfinals + $labfinals) * (($row['ccstand4']) / 100);

                $prelim = $att1 + $exam1 + $csprelim + $project1 + $charc1;
                $midterm = $att2 + $exam2 + $csmidterm + $project2 + $charc2;
                $semifinal = $att3 + $exam3 + $csemis + $project3 + $charc3;
                $final = $att4 + $exam4 + $csfinals  + $project4 + $charc4;

                $total = ($prelim * (($row['wdprelim']) / 100)) + ($midterm * (($row['wdmidterm']) / 100)) + ($semifinal * (($row['wdsemifinal']) / 100)) + ($final * (($row['wdfinal']) / 100));

                $data = array(
                    'eqtotal' => $this->gradeconversion($total),
                    'prelim' =>number_format($prelim, 2),
                    'midterm' =>number_format($midterm, 2),
                    'semifinal' =>number_format($semifinal, 2),
                    'final' =>number_format($final, 2),
                    'total' =>number_format($total, 2),
                    'lecprelim' =>number_format($total, 2),
                    'lecmidterm' =>number_format($total, 2),
                    'lecsemis' =>number_format($total, 2),
                    'lecfinals' =>number_format($total, 2),
                    'labprelim' =>number_format($total, 2),
                    'labmidterm' =>number_format($total, 2),
                    'labsemis' =>number_format($total, 2),
                    'labfinals' =>number_format($total, 2),
                    'csprelim' =>number_format($total, 2),
                    'csmidterm' =>number_format($total, 2),
                    'cssemis' =>number_format($total, 2),
                    'csfinals' =>number_format($total, 2),
                    'att1' => $row['att1'],
                    'att2' => $row['att2'],
                    'att3' => $row['att3'],
                    'att4' => $row['att4'],
                    'exam1' => $row['exam1'],
                    'exam2' => $row['exam2'],
                    'exam3' => $row['exam3'],
                    'exam4' => $row['exam4'],
                    'quiz1' => $row['quiz1'],
                    'quiz2' => $row['quiz2'],
                    'quiz3' => $row['quiz3'],
                    'quiz4' => $row['quiz4'],
                    'ass1' => $row['ass1'],
                    'ass2' => $row['ass2'],
                    'ass3' => $row['ass3'],
                    'ass4' => $row['ass4'],
                    'rec1' => $row['rec1'],
                    'rec2' => $row['rec2'],
                    'rec3' => $row['rec3'],
                    'rec4' => $row['rec4'],
                    'sw1' => $row['sw1'],
                    'sw2' => $row['sw2'],
                    'sw3' => $row['sw3'],
                    'sw4' => $row['sw4'],
                    'gw1' => $row['gw1'],
                    'gw2' => $row['gw2'],
                    'gw3' => $row['gw3'],
                    'gw4' => $row['gw4'],
                    'hon1' => $row['hon1'],
                    'hon2' => $row['hon2'],
                    'hon3' => $row['hon3'],
                    'hon4' => $row['hon4'],
                    'cstudy1' => $row['cstudy1'],
                    'cstudy2' => $row['cstudy2'],
                    'cstudy3' => $row['cstudy3'],
                    'cstudy4' => $row['cstudy4'],
                    'act1' => $row['act1'],
                    'act2' => $row['act2'],
                    'act3' => $row['act3'],
                    'act4' => $row['act4'],
                    'hexam1' => $row['hexam1'],
                    'hexam2' => $row['hexam2'],
                    'hexam3' => $row['hexam3'],
                    'hexam4' => $row['hexam4'],
                    'project1' => $row['project1'],
                    'project2' => $row['project2'],
                    'project3' => $row['project3'],
                    'project4' => $row['project4'],
                    'charc1' => $row['charc1'],
                    'charc2' => $row['charc2'],
                    'charc3' => $row['charc3'],
                    'charc4' => $row['charc4'],
                    
                    'cproject1' => $row['cproject1'],
                    'cproject2' => $row['cproject2'],
                    'cproject3' => $row['cproject3'],
                    'cproject4' => $row['cproject4'],
                    'ccharc1' => $row['ccharc1'],
                    'ccharc2' => $row['ccharc2'],
                    'ccharc3' => $row['ccharc3'],
                    'ccharc4' => $row['ccharc4'],
                    'wdprelim' => $row['wdprelim'],
                    'wdmidterm' => $row['wdmidterm'],
                    'wdsemifinal' => $row['wdsemifinal'],
                    'wdfinal' => $row['wdfinal'],
                    'ccstand1' => $row['ccstand1'],
                    'ccstand2' => $row['ccstand2'],
                    'ccstand3' => $row['ccstand3'],
                    'ccstand4' => $row['ccstand4'],
                    'cstandlec1' => $row['cstandlec1'],
                    'cstandlec2' => $row['cstandlec2'],
                    'cstandlec3' => $row['cstandlec3'],
                    'cstandlec4' => $row['cstandlec4'],
                    'cstandlab1' => $row['cstandlab1'],
                    'cstandlab2' => $row['cstandlab2'],
                    'cstandlab3' => $row['cstandlab3'],
                    'cstandlab4' => $row['cstandlab4'],
                );
            }

            return $data;
        }


        function getstudentbyid($studid){
            $q = "select * from student where id=$studid";
            $r = mysql_query($q);
            $data = array();
            $data[] = mysql_fetch_array($r);
            return $data;
        }

        function gradeconversion($grade){
            $grade = number_format($grade);
            if($grade==0){
                 $data = 0;
            }else{
                switch ($grade) {

                    case 100:
                    case 99:
                    case 98:
                         $data = 1.00;
                         break;

                    case 97:
                    case 96:
                    case 95:
                         $data = 1.25;
                         break;

                    case 94:
                    case 93:
                    case 92:
                         $data = 1.50;
                         break;

                    case 91:
                    case 90:
                    case 89:
                         $data = 1.75;
                         break;

                    case 88:
                    case 87:
                    case 86:
                         $data = 2.00;
                         break;

                    case 85:
                    case 84:
                    case 83:
                         $data = 2.25;
                         break;

                    case 82:
                    case 81:
                    case 80:
                         $data = 2.50;
                         break;

                    case 79:
                    case 78:
                    case 77:
                         $data = 2.75;
                         break;

                    case 76:
                    case 75:
                         $data = 3.00;
                         break;

                     default:
                         $data = 5.0;
                }
            }
            return $data;
        }
    }