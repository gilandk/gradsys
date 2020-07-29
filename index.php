<?php
include('config.php');
if (isset($_POST['submit'])) {
  $user = $_POST['user'];
  $pass = $_POST['pass'];
  $query = "select * from userdata where username='$user' and password='$pass'";
  $r = mysqli_query($conn,$query);
  if (mysqli_num_rows($r) == 1) {
    $row = mysqli_fetch_assoc($r);
    $_SESSION['level'] = $row['level'];
    $_SESSION['id'] = $row['username'];
    $_SESSION['name'] = $row['fname'] . ' ' . $row['midname'] . ' ' . $row['lname'];

    if ($_SESSION['level'] == 'admin') {
      $level = "Administrator";
    } elseif ($_SESSION['level'] == 'teacher')
      $level = "Instructor";
    else {
      $level = "Student";
    }

    $act = $_SESSION['id'] . ' (' . $level . ') ' . $_SESSION['name'] . ' - logged in.';
    date_default_timezone_set('Asia/Manila');
    $date = date('m-d-Y h:i:s A');
    

    header('location:' . $row['level'] . '');
  } else {
    header('location:index.php?login=0');
  }
}
if (isset($_SESSION['level'])) {
  header('location:' . $_SESSION['level'] . '');
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

  <title>DYCI</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome.min.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link href="jumbotron.css" rel="stylesheet">

</head>

<body>

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <img src="gradingsystem/img/dycilogo.png" alt="" class="logo1">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Dr. Yanga's College Inc.</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <form class="navbar-form navbar-right" role="form" action="index.php" method="POST">
          <div class="form-group">
            <?php if (isset($_GET['login'])) : ?>
              <label class="text-danger">Invalid Username/Password</label>&nbsp;
            <?php endif; ?>
          </div>
          <div class="form-group">
            <input type="text" placeholder="ID No." class="form-control" name="user" autocomplete="off">
          </div>
          <div class="form-group">
            <input type="password" placeholder="Password" class="form-control" name="pass">
          </div>
          <button type="submit" class="btn btn-success" name="submit">Sign in</button>
        </form>
      </div>
      <!--/.navbar-collapse -->
    </div>
  </nav>


  <div class="jumbotron">
    <div class="container">
      <br />
      <img src="img/dycilogo.png" style="width:100px;height:100px;float:left">
      <h1>Welcome to DYCI Student Portal</h1><br>

      <p>DR. YANGA'S COLLEGE INC,</p>

      <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
    </div>
  </div>

  <div class="container">
    <!-- columns -->
    <div class="row">
      <div class="col-md-4">
        <h2 class="center"><i class="fa fa-users fa-5x"></i></h2>
        <p><strong>Student Module</strong></p>
        <p>Student will login using their ID no and password to view their grades.</p>
      </div>
      <div class="col-md-4">
        <h2 class="center"><i class="fa fa-table fa-5x"></i></h2>
        <p><strong>Admin Module</strong></p>
        <p>Administrator Module has all the priviledge of the system. The admin can manage the students and faculty information.</p>
      </div>
      <div class="col-md-4">
        <h2 class="center"><i class="fa fa-tasks fa-5x"></i></h2>
        <p><strong>Faculty Module</strong></p>
        <p>Faculty Module will be able to view their assigned class and view the students on that class.</p>
      </div>
    </div>

    <hr>

    <footer>
      <p>&copy; DYCI 2019</p>
    </footer>
  </div> <!-- /container -->

  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>