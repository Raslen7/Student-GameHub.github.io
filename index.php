<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student GameHub</title>
    <link rel="stylesheet" href="assets/Styles.css" />
    <link href="https://emoji-css.afeld.me/emoji.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <script defer src="assets/scripts.js"></script>
     
  </head>
  <body>
    <header class="header" id="header">
      <nav class="nav container">
        <a href="index.php" class="nav__logo">Student GameHub</a>
        <div class="nav__menu" id="nav-menu">
          <ul class="nav__list ">
            <li class="nav__item">
              <a href="index.php" class="nav__link active-link">
            Home</a>
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
              <a href="achievements.php" class="nav__link">
                Achievements</a>
            </li>
         
            <li class="nav__item">
              <a href="https://raslen.me/" class="nav__link">
                Contact-Me</a>
            </li>
          </ul>
          <i class="uil uil-times nav__close" id="nav-close"></i>
        </div>
        <div class="nav__btns">
          <!--bchhh tkonn lblasaa taa luser hathii -->
                      <?php
                       session_start();
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
                <button class="profile__logout" name="logout" id="logout-btn"><b>Log out</b></button>
                <?php
                if (isset($_POST['logout'])) {
                  session_destroy();
                  header("Location: login.php");
                  exit();
                }
                ?>
              </div>
            </form>
          </div>
        </div>
      </nav>
    </header>
    <!-- main-->
    <main>
      <section class="m">
     <div class="hero-text">
  <h2> It’s <span> time </span>to take a break.
</h2>
  <p>Grab a cup of tea, relax, and enjoy the game.</p></div>

      <div class="m__img">
        <img width="500"  height="300" src="img/hq720.jpg" alt="">
      </div>
      </section>
   

          <section class="games-section">
  
  <!-- Categories -->
  <div id="category-container" class="category-container"></div>
  <!-- Games Grid -->
  <div id="game-grid" class="game-grid"></div>

</section>



































      </section>
       




     </main>
     
     

   
  </body>
</html>
