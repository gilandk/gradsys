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
            $pexam = $_POST['exam1'];
            $pquiz = $_POST['quiz1'];
            $pass = $_POST['ass1'];
            $prec = $_POST['rec1'];
            $psw = $_POST['sw1'];
            $pgw = $_POST['gw1'];
            $pproject = $_POST['project1'];
            $pcharc = $_POST['charc1'];

            $matt = $_POST['att2'];
            $mexam = $_POST['exam2'];
            $mquiz = $_POST['quiz2'];
            $mass = $_POST['ass2'];
            $mrec = $_POST['rec2'];
            $msw = $_POST['sw2'];
            $mgw = $_POST['gw2'];
            $mproject = $_POST['project2'];
            $mcharc = $_POST['charc2'];

            $sfatt = $_POST['att3'];
            $sfquiz = $_POST['quiz3'];
            $sfexam = $_POST['exam3'];
            $sfass = $_POST['ass3'];
            $sfrec = $_POST['rec3'];
            $sfsw = $_POST['sw3'];
            $sfgw = $_POST['gw3'];
            $sfproject = $_POST['project3'];
            $sfcharc = $_POST['charc3'];

            $fatt = $_POST['att4'];
            $fexam = $_POST['exam4'];
            $fquiz = $_POST['quiz4'];
            $fass = $_POST['ass4'];
            $frec = $_POST['rec4'];
            $fsw = $_POST['sw4'];
            $fgw = $_POST['gw4'];
            $fproject = $_POST['project4'];
            $fcharc = $_POST['charc4'];

            $q = "update studentsubjectlec set
            att1=$patt, exam1=$pexam, quiz1=$pquiz, ass1=$pass, rec1=$prec, sw1=$psw, project1=$pproject, charc1=$pcharc,
            att2=$matt, exam2=$mexam, quiz2=$mquiz, ass2=$mass, rec2=$mrec, sw2=$msw, gw2=$mgw, project2=$mproject, charc2=$mcharc,
            att3=$sfatt, exam3=$sfexam, quiz3=$sfquiz, ass3=$sfass, rec3=$sfrec, sw3=$sfsw, gw3=$sfgw, project3=$sfproject, charc3=$sfcharc,
            att4=$fatt, exam4=$fexam, quiz4=$fquiz, ass4=$fass, rec4=$frec, sw4=$fsw, gw4=$fgw, project4=$fproject, charc4=$fcharc 
            where studid=$studid and classid=$classid";
            
            mysql_query($q);
            $this->createlog($studid,$classid);

            header('location:../lec.php?studid='.$studid.'&classid='.$classid.'&status=1');
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
            $pexam = $_POST['cexam1'];
            $pquiz = $_POST['cquiz1'];
            $pass = $_POST['cass1'];
            $prec = $_POST['crec1'];
            $psw = $_POST['csw1'];
            $pgw = $_POST['cgw1'];
            $pproject = $_POST['cproject1'];
            $pcharc = $_POST['ccharc1'];
            $wdprelim = $_POST['wdprelim'];
            $pcstandlec = $_POST['cstandlec1'];

            $matt = $_POST['catt2'];
            $mexam = $_POST['cexam2'];
            $mquiz = $_POST['cquiz2'];
            $mass = $_POST['cass2'];
            $mrec = $_POST['crec2'];
            $msw = $_POST['csw2'];
            $mgw = $_POST['cgw2'];
            $mproject = $_POST['cproject2'];
            $mcharc = $_POST['ccharc2'];
            $wdmidterm = $_POST['wdmidterm'];

            $mcstandlec = $_POST['cstandlec2'];
            
            $sfatt = $_POST['catt3'];
            $sfexam = $_POST['cexam3'];
            $sfquiz = $_POST['cquiz3'];
            $sfass = $_POST['cass3'];
            $sfrec = $_POST['crec3'];
            $sfsw = $_POST['csw3'];
            $sfgw = $_POST['cgw3'];
            $sfproject = $_POST['cproject3'];
            $sfcharc = $_POST['ccharc3'];
            $wdsemifinal = $_POST['wdsemifinal'];
            $sfcstandlec = $_POST['cstandlec3'];

            $fatt = $_POST['catt4'];
            $fexam = $_POST['cexam4'];
            $fquiz = $_POST['cquiz4'];
            $fass = $_POST['cass4'];
            $frec = $_POST['crec4'];
            $fsw = $_POST['csw4'];
            $fgw = $_POST['cgw4'];
            $fproject = $_POST['cproject4'];
            $fcharc = $_POST['ccharc4'];
            $wdfinal = $_POST['wdfinal'];
            $fcstandlec = $_POST['cstandlec4'];

            
            $pret = $pcstandlec + $pexam + $patt + $pcharc + $pproject;
            $midt = $mcstandlec + $mexam + $matt + $mcharc + $mproject;
            $sft = $sfcstandlec + $sfexam + $sfatt + $sfcharc + $sfproject;
            $ft = $fcstandlec + $fexam + $fatt + $fcharc + $fproject;

            $wd = $wdprelim + $wdmidterm + $wdsemifinal + $wdfinal;

            if($wd != 100) {
                header('location:../criterialec.php?teachid='.$teachid.'&classid='.$classid.'&status=2');
            }
            else if($pret != 100) {
                header('location:../criterialec.php?teachid='.$teachid.'&classid='.$classid.'&status=3');
            }
            else if($midt != 100) {
                header('location:../criterialec.php?teachid='.$teachid.'&classid='.$classid.'&status=4');
            }
            else if($sft != 100) {
                header('location:../criterialec.php?teachid='.$teachid.'&classid='.$classid.'&status=5');
            }
            else if($ft != 100) {
                header('location:../criterialec.php?teachid='.$teachid.'&classid='.$classid.'&status=6');
            }
            else{
            $q = "update criteria set
            catt1=$patt, cexam1=$pexam, cquiz1=$pquiz, cass1=$pass, crec1=$prec, csw1=$psw, cgw1=$pgw, cproject1=$pproject, ccharc1=$pcharc, wdprelim=$wdprelim, cstandlec1=$pcstandlec,
            catt2=$matt, cexam2=$mexam, cquiz2=$mquiz, cass2=$mass, crec2=$mrec, csw2=$msw, cgw2=$mgw, cproject2=$mproject, ccharc2=$mcharc, wdmidterm=$wdmidterm, cstandlec2=$mcstandlec, 
            catt3=$sfatt, cexam3=$sfexam, cquiz3=$sfquiz, cass3=$sfass, crec3=$sfrec, csw3=$sfsw, cgw3=$sfgw, cproject3=$sfproject, ccharc3=$sfcharc, wdsemifinal=$wdsemifinal, cstandlec3=$sfcstandlec, 
            catt4=$fatt, cexam4=$fexam, cquiz4=$fquiz, cass4=$fass, crec4=$frec, csw4=$fsw, cgw4=$fgw, cproject4=$fproject, ccharc4=$fcharc, wdfinal=$wdfinal, cstandlec4=$fcstandlec
            where teachid=$teachid and classid=$classid";
            
            mysql_query($q);
            $this->ccreatelog($teachid,$classid);

            header('location:../criterialec.php?teachid='.$teachid.'&classid='.$classid.'&status=1');
            }
        }

        function ccreatelog($teachid,$classid){
            $teacher = mysql_query("select * from teacher where id=$teachid");
            $teacher = mysql_fetch_array($teacher);
            $teacher = $teacher['fname'].' '.$teacher['midname'].' '.$teacher['lname'];

            $subject = mysql_query("select * from class where id=$classid");
            $subject = mysql_fetch_array($subject);
            $subject = $subject['subject'];

            $act = $_SESSION['id'].' Updated the criteria of '.$teacher.' in '.$subject.'';
            date_default_timezone_set('Asia/Manila');
            $date = date('m-d-Y h:i:s A');
            mysql_query("insert into log values(null,'$date','$act')");
            
            return true;
        }

    }
