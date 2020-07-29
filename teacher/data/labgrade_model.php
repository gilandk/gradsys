<?php
    include('../../config.php');
    $teachid = $_GET['teachid'];
    $studid = $_GET['studid'];
    $classid = $_GET['classid'];
    $term = $_GET['term'];

    $grade = new Datagrade();
    if($term == 1){
        $grade->grades($studid,$classid);
    }
    elseif($term == 5){
        $grade->criteria($teachid,$classid);
    }

    class Datagrade {

        function __construct(){
            if(!isset($_SESSION['id'])){
                header('location:../../');
            }
        }

        function grades($studid,$classid){

            $patt = $_POST['att1'];
            $phon = $_POST['hon1'];
            $pcstudy = $_POST['cstudy1'];
            $pact = $_POST['act1'];
            $phexam = $_POST['hexam1'];
            $pproject = $_POST['project1'];


            $matt = $_POST['att2'];
            $mhon = $_POST['hon2'];
            $mcstudy = $_POST['cstudy2'];
            $mact = $_POST['act2'];
            $mhexam = $_POST['hexam2'];
            $mproject = $_POST['project2'];


            $sfatt = $_POST['att3'];
            $sfhon = $_POST['hon3'];
            $sfcstudy = $_POST['cstudy3'];
            $sfact = $_POST['act3'];
            $sfhexam = $_POST['hexam3'];
            $sfproject = $_POST['project3'];

            $fatt = $_POST['att4'];
            $fhon = $_POST['hon4'];
            $fcstudy = $_POST['cstudy4'];
            $fact = $_POST['act4'];
            $fhexam = $_POST['hexam4'];
            $fproject = $_POST['project4'];
 
            $q = "update studentsubjectlab set
            att1=$patt, hon1=$phon, cstudy1=$pcstudy, act1=$pact, hexam1=$phexam, project1=$pproject,
            att2=$matt, hon2=$mhon, cstudy2=$mcstudy, act2=$mact, hexam2=$mhexam, project2=$mproject,
            att3=$sfatt, hon3=$sfhon, cstudy3=$sfcstudy, act3=$sfact, hexam3=$sfhexam, project3=$sfproject,
            att4=$fatt, hon4=$fhon, cstudy4=$fcstudy, act4=$fact, hexam4=$fhexam, project4=$fproject
            where studid=$studid and classid=$classid";
            
            
            mysql_query($q);
            $this->createlog($studid,$classid);

            header('location:../lab.php?studid='.$studid.'&classid='.$classid.'&status=1');
        }

        function createlog($studid,$classid){
            $student = mysql_query("select * from student where id=$studid");
            $student = mysql_fetch_array($student);
            $student = $student['fname'].' '.$student['midname'].' '.$student['lname'];

            $subject = mysql_query("select * from class where id=$classid");
            $subject = mysql_fetch_array($subject);
            $subject = $subject['subject'];

            $act = $_SESSION['id'].' Updated the grades of '.$student.' in '.$subject.'';
            date_default_timezone_set('Asia/Manila');
            $date = date('m-d-Y h:i:s A');
            mysql_query("insert into log values(null,'$date','$act')");
            
            return true;
        }

        //CRITERIA
        function criteria($teachid,$classid){

            $patt = $_POST['catt1'];
            $phon = $_POST['chon1'];
            $pcstudy = $_POST['ccstudy1'];
            $pact = $_POST['cact1'];
            $phexam = $_POST['chexam1'];
            $pproject = $_POST['cproject1'];
            $wdprelim = $_POST['wdprelim'];
            $pcstandlab = $_POST['cstandlab1'];

            $matt = $_POST['catt2'];
            $mhon = $_POST['chon2'];
            $mcstudy = $_POST['ccstudy2'];
            $mact = $_POST['cact2'];
            $mhexam = $_POST['chexam2'];
            $mproject = $_POST['cproject2'];
            $wdmidterm = $_POST['wdmidterm'];
            $mcstandlab = $_POST['cstandlab2'];
            
            $sfatt = $_POST['catt3'];
            $sfhon = $_POST['chon3'];
            $sfcstudy = $_POST['ccstudy3'];
            $sfact = $_POST['cact3'];
            $sfhexam = $_POST['chexam3'];
            $sfproject = $_POST['cproject3'];
            $wdsemifinal = $_POST['wdsemifinal'];
            $sfcstandlab = $_POST['cstandlab3'];

            $fatt = $_POST['catt4'];
            $fhon = $_POST['chon4'];
            $fcstudy = $_POST['ccstudy4'];
            $fact = $_POST['cact4'];
            $fhexam = $_POST['chexam4'];
            $fproject = $_POST['cproject4'];
            $wdfinal = $_POST['wdfinal'];
            $fcstandlab = $_POST['cstandlab4'];

            $pret = $pcstandlab + $patt  + $pproject;
            $midt = $mcstandlab + $matt + $mproject;
            $sft = $sfcstandlab + $sfatt  + $sfproject;
            $ft = $fcstandlab + $fatt  + $fproject;

            $wd = $wdprelim + $wdmidterm + $wdsemifinal + $wdfinal;

            if($wd != 100) {
                header('location:../criterialab.php?teachid='.$teachid.'&classid='.$classid.'&status=2');
            }
            else if($pret != 100) {
                header('location:../criterialab.php?teachid='.$teachid.'&classid='.$classid.'&status=3');
            }
            else if($midt != 100) {
                header('location:../criterialab.php?teachid='.$teachid.'&classid='.$classid.'&status=4');
            }
            else if($sft != 100) {
                header('location:../criterialab.php?teachid='.$teachid.'&classid='.$classid.'&status=5');
            }
            else if($ft != 100) {
                header('location:../criterialab.php?teachid='.$teachid.'&classid='.$classid.'&status=6');
            }
            else{

            $q = "update criteria set
            catt1=$patt, chon1=$phon, ccstudy1=$pcstudy, cact1=$pact, chexam1=$phexam, cproject1=$pproject, wdprelim=$wdprelim, cstandlab1=$pcstandlab,
            catt2=$matt, chon2=$mhon, ccstudy2=$mcstudy, cact2=$mact, chexam2=$mhexam, cproject2=$mproject, wdmidterm=$wdmidterm, cstandlab2=$mcstandlab,
            catt3=$sfatt, chon3=$sfhon, ccstudy3=$sfcstudy, cact3=$sfact, chexam3=$sfhexam, cproject3=$sfproject, wdsemifinal=$wdsemifinal, cstandlab3=$sfcstandlab,
            catt4=$fatt, chon4=$fhon, ccstudy4=$fcstudy, cact4=$fact, chexam4=$fhexam, cproject4=$fproject, wdfinal=$wdfinal, cstandlab4=$fcstandlab
            where teachid=$teachid and classid=$classid";
            
            mysql_query($q);
            $this->ccreatelog($teachid,$classid);

            header('location:../criterialab.php?teachid='.$teachid.'&classid='.$classid.'&status=1');
            }
        }

        function ccreatelog($teachid,$classid){
            $teacher = mysql_query("select * from teacher where id=$teachid");
            $teacher = mysql_fetch_array($teacher);
            $teacher = $teacher['fname'].' '.$teacher['midname'].' '.$teacher['lname'];

            $subject = mysql_query("select * from class where id=$classid");
            $subject = mysql_fetch_array($subject);
            $subject = $subject['subject'];

            $act = $_SESSION['id'].' '.$teacher.' Updated the criteria of '.$subject.'';
            date_default_timezone_set('Asia/Manila');
            $date = date('m-d-Y h:i:s A');
            mysql_query("insert into log values(null,'$date','$act')");
            
            return true;
        }

    }