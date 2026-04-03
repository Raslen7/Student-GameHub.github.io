<<<<<<< HEAD
 
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
                Home</a>
            </li>
            <li class="nav__item">
              <a href="tutorial.php" class="nav__link active-link">
             Tutorial</a>
            </li>
            <li class="nav__item">
              <a href="problems.php" class="nav__link">
            Problems</a>
            </li>
            <li class="nav__item">
              <a href="achievements.php" class="nav__link">
                Achivements</a>
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
      </nav>
    </header>
    <!-- main-->
    <main>
<h2 class="tuto-title">
    You Should have first <span style="color: #A0C878;">Torrent</span> and  <span style="color: #982598;">WinRAR</span>
</h2>

<section class="tuto">
    <div class="container-row">

        <div class="torrent">
            <div class="text">
                Torrent is a peer-to-peer file sharing protocol that enables users to distribute data over the internet efficiently. 
                It allows users to download and upload files simultaneously, making it a popular choice for sharing large files such as games, movies, and software.
                <br><br>
                • We need it to download the game files  
                <br>
                • We can pause and resume the download  
                <br>
                • Very useful for slow internet and large files
                <br>
                &nbsp; To download  Torrent <a target="_blank" href="https://www.utorrent.com/downloads/complete/track/stable/os/win/" style="color: #A0C878; font-weight: bold;">Click Here</a>
            </div>

            <div class="img">
                <img src="img/Screenshot_2026-02-19_095609-removebg-preview.png" alt="torrent">
            </div>
        </div>

        <div class="winrar">
            <div class="text">
                WinRAR is a file archiver utility for Windows that can create and view archives in RAR or ZIP file formats. 
                It also supports unpacking various archive file formats. WinRAR is widely used for compressing files to save space and for bundling multiple files together for easier sharing.
                <br><br>
                • We need it to extract the game files
                <br>
                • Reduce file size for easier sharing
                <br>
                • Protect files with encryption
                <br>
                &nbsp;  To download  Winrar <a target="_blank" href="https://www.win-rar.com/postdownload.html?&L=0" style="color: #982598; font-weight: bold;">Click Here</a>
            </div>

            <div class="img">
                <img src="img/rar-archive_57.png" alt="winrar">
            </div>
        </div>
    </div>
</section>




<section class="stept">
  <div class="tuto-title" >      u may have to shut down temporary windows defender or any antivirus software to avoid any issues during the installation process
    <br>   <br>  Sometimes, Windows Defender or antivirus software may detect extracted files as suspicious.
This usually happens because : <br> <br> 
 </div>
 <div class="cause">
  <ul>
  <li> The game files are often compressed and may contain executable files, which can trigger antivirus software to flag them as potential threats.  </li>
  <li> The game files may be new or uncommon, and antivirus software may not recognize them. </li>
  <li> The game files may be packed in a way that resembles malware, which can cause antivirus software to flag them as suspicious. </li>
  </ul>
 </div>
<div class="safe">all of the games in this websites are safe and tested <br>  <br> 
 Somtimes there is notes the game folder tell u how to unlock the game after installing it to avoid luanching errors</div>
    

</section>

<h2 class="Controler-title">
    Some Games can be played with a  <span style="color: #333fe7;">controller</span>
</h2>
<section class="tuto">
    <div class="container-row">

        <div class="torrent">
            <div class="text">
              <strong style="color: #F3F4F4;">DS4Windows</strong> is designed for contollers of ps3 and ps4 and ps5 xbox and many more it allows you to use your PlayStation controller on a Windows PC by emulating an Xbox controller.
                <br><br>
                • It give you the best gaming experience with less input lag and latency issues compared to other paid apps  
                <br>
                • The virtual controller is fully configurable: its buttons and sticks can be remapped to other buttons/sticks or entirely disable 
                <br>
                • the app is natively supported by most games. 
                 <br>
                <br>
                &nbsp; To download  DS4Windows <a target="_blank" href="https://ds4-windows.com/download/ryochan7-ds4windows/" style="color: #493ad1; font-weight: bold;">Click Here</a>
            </div>

            <div class="img">
                <img src="img/Controller.webp">
            </div>
        </div>

        <div class="winrar">
            <div class="text">
              <strong style="color: #F3F4F4;">X360CE</strong>  is a free and open-source software that allows you to use your regular PC controller  on a Windows PC by emulating an Xbox controller, which is natively supported by most games.
                <br><br>
                • Do not close Xbox 360 Controller Emulator  during the game, just minimise it to reduce CPU uses
                <br>
                • For more instructions on how to use it, check the official website <a target="_blank" href="https://www.x360ce.com/" style="color: #136e1a; font-weight: bold;">Click Here</a>
                 <br>
              
                <br>
                  &nbsp;  To download  X360CE <a target="_blank" href="https://www.x360ce.com/files/x360ce.zip" style="color: #136e1a; font-weight: bold;">Click Here</a>
              </div>

            <div class="img">
                <img src="img/2-18-removebg-preview.png" >
            </div>
        </div>
    </div>
</section>





     </main>
     
     

   
  </body>
</html>
=======
 
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
                Home</a>
            </li>
            <li class="nav__item">
              <a href="tutorial.php" class="nav__link active-link">
             Tutorial</a>
            </li>
            <li class="nav__item">
              <a href="problems.php" class="nav__link">
            Problems</a>
            </li>
            <li class="nav__item">
              <a href="achievements.php" class="nav__link">
                Achivements</a>
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
      </nav>
      </nav>
    </header>
    <!-- main-->
    <main>
<h2 class="tuto-title">
    You Should have first <span style="color: #A0C878;">Torrent</span> and  <span style="color: #982598;">WinRAR</span>
</h2>

<section class="tuto">
    <div class="container-row">

        <div class="torrent">
            <div class="text">
                Torrent is a peer-to-peer file sharing protocol that enables users to distribute data over the internet efficiently. 
                It allows users to download and upload files simultaneously, making it a popular choice for sharing large files such as games, movies, and software.
                <br><br>
                • We need it to download the game files  
                <br>
                • We can pause and resume the download  
                <br>
                • Very useful for slow internet and large files
                <br>
                &nbsp; To download  Torrent <a target="_blank" href="https://www.utorrent.com/downloads/complete/track/stable/os/win/" style="color: #A0C878; font-weight: bold;">Click Here</a>
            </div>

            <div class="img">
                <img src="img/Screenshot_2026-02-19_095609-removebg-preview.png" alt="torrent">
            </div>
        </div>

        <div class="winrar">
            <div class="text">
                WinRAR is a file archiver utility for Windows that can create and view archives in RAR or ZIP file formats. 
                It also supports unpacking various archive file formats. WinRAR is widely used for compressing files to save space and for bundling multiple files together for easier sharing.
                <br><br>
                • We need it to extract the game files
                <br>
                • Reduce file size for easier sharing
                <br>
                • Protect files with encryption
                <br>
                &nbsp;  To download  Winrar <a target="_blank" href="https://www.win-rar.com/postdownload.html?&L=0" style="color: #982598; font-weight: bold;">Click Here</a>
            </div>

            <div class="img">
                <img src="img/rar-archive_57.png" alt="winrar">
            </div>
        </div>
    </div>
</section>




<section class="stept">
  <div class="tuto-title" >      u may have to shut down temporary windows defender or any antivirus software to avoid any issues during the installation process
    <br>   <br>  Sometimes, Windows Defender or antivirus software may detect extracted files as suspicious.
This usually happens because : <br> <br> 
 </div>
 <div class="cause">
  <ul>
  <li> The game files are often compressed and may contain executable files, which can trigger antivirus software to flag them as potential threats.  </li>
  <li> The game files may be new or uncommon, and antivirus software may not recognize them. </li>
  <li> The game files may be packed in a way that resembles malware, which can cause antivirus software to flag them as suspicious. </li>
  </ul>
 </div>
<div class="safe">all of the games in this websites are safe and tested <br>  <br> 
 Somtimes there is notes the game folder tell u how to unlock the game after installing it to avoid luanching errors</div>
    

</section>

<h2 class="Controler-title">
    Some Games can be played with a  <span style="color: #333fe7;">controller</span>
</h2>
<section class="tuto">
    <div class="container-row">

        <div class="torrent">
            <div class="text">
              <strong style="color: #F3F4F4;">DS4Windows</strong> is designed for contollers of ps3 and ps4 and ps5 xbox and many more it allows you to use your PlayStation controller on a Windows PC by emulating an Xbox controller.
                <br><br>
                • It give you the best gaming experience with less input lag and latency issues compared to other paid apps  
                <br>
                • The virtual controller is fully configurable: its buttons and sticks can be remapped to other buttons/sticks or entirely disable 
                <br>
                • the app is natively supported by most games. 
                 <br>
                <br>
                &nbsp; To download  DS4Windows <a target="_blank" href="https://ds4-windows.com/download/ryochan7-ds4windows/" style="color: #493ad1; font-weight: bold;">Click Here</a>
            </div>

            <div class="img">
                <img src="img/Controller.webp">
            </div>
        </div>

        <div class="winrar">
            <div class="text">
              <strong style="color: #F3F4F4;">X360CE</strong>  is a free and open-source software that allows you to use your regular PC controller  on a Windows PC by emulating an Xbox controller, which is natively supported by most games.
                <br><br>
                • Do not close Xbox 360 Controller Emulator  during the game, just minimise it to reduce CPU uses
                <br>
                • For more instructions on how to use it, check the official website <a target="_blank" href="https://www.x360ce.com/" style="color: #136e1a; font-weight: bold;">Click Here</a>
                 <br>
              
                <br>
                  &nbsp;  To download  X360CE <a target="_blank" href="https://www.x360ce.com/files/x360ce.zip" style="color: #136e1a; font-weight: bold;">Click Here</a>
              </div>

            <div class="img">
                <img src="img/2-18-removebg-preview.png" >
            </div>
        </div>
    </div>
</section>





     </main>
     
     

   
  </body>
</html>
>>>>>>> 6f9d4fd (fix profile name problem)
