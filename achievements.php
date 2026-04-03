<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student GameHub</title>
    <link rel="stylesheet" href="assets/Styles.css" />
    <script defer src="assets/scripts.js"></script>
     
  </head>
  <body>
    <header class="header" id="header">
      <nav class="nav container">
        <a href="index.html" class="nav__logo">Student GameHub</a>
        <div class="nav__menu" id="nav-menu">
          <ul class="nav__list ">
            <li class="nav__item">
              <a href="index.php" class="nav__link ">
           </i>Home</a>
            </li>
            <li class="nav__item">
              <a href="tutorial.php" class="nav__link">
               Tutorial</a>
            </li>
            <li class="nav__item">
              <a href="problems.php" class="nav__link">
                Problems</a>
            </li>
            <li class="nav__item">
              <a href="achievements.php" class="nav__link active-link">
                Achievements</a>
            </li>
         
            <li class="nav__item">
              <a href="https://raslen.me/" class="nav__link">
             Contact-Me</a>
            </li>
          </ul>
        </div>
 <div class="nav__btns">
          <!--bchhh tkonn lblasaa taa luser hathii -->
                      <?php
                      if (!isset($_SESSION['user_id'])) {
                        header("Location: login.php");
                                   exit();
                                                   }
                             ?>
       

          <div class="nav__profile" id="nav-profile">
          <?php
include 'db.php';
$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>
<form method="POST">

            <div class="profile__info">
              <h3 class="profile__name"><?php echo $user['username']; ?></h3>
              <button class="profile__logout" name="logout" id="logout-btn">Logout</button>
              <?php
              if (isset($_POST['logout'])) {
                session_destroy();
                header("Location: login.php");
                exit();
              }
              ?>
            </div>
            <i class="uil uil-angle-down nav__profile-icon" id="profile-toggle"></i>
          </div>
          <form>
        </div>
      </nav>
    </header>
    <!-- main-->
    <main>
   




     </main>
     
     

   
  </body>
</html>