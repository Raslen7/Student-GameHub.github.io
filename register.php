<?php
session_start();
include 'db.php';

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];


    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: login.php");
        exit();
    } else {
        header("Location: register.php");
        exit();
    }
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
      <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"/>

    <script defer src="assets/scripts.js"></script>
     <title>Register – Student GameHub</title>
     
  </head>
  <body>
    <header class="header" id="header">
      <nav class="nav container">
        <a href="index.html" class="nav__logo">Student GameHub</a>
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
              <a href="achievements.php" class="nav__link">
                Achivements</a>
            </li>
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
          <div class="nav__toggle" id="nav-toggle">
            <!--bchhh tkonn lblasaa taa luser hathii -->
             <i class="uil uil-apps"></i>
          </div>
        </div>
      </nav>
    </header>
    <!-- main-->
<main class="auth-main">
  <form method="POST" action="register.php"             >
  <div class="auth-card">
 
    <div class="auth-logo">🎮</div>
    <h2 class="auth-title">Create an account</h2>
    <p class="auth-subtitle">You have an account? <a href="login.php">login here</a></p>
        
  <!-- USERNAME -->
  <div class="field">
    <label for="username">Username</label>
    <div class="input-wrap">
      <i class="uil uil-user"></i>
      <input
        type="text" id="username" name="username"
        placeholder="Your username"
        required />
    </div>
  </div>

  <!-- EMAIL -->
  <div class="field">
    <label for="email">Email address</label>
    <div class="input-wrap">
      <i class="uil uil-envelope"></i>
      <input
        type="email" id="email" name="email"
        placeholder="you@example.com"
        required />
    </div>
  </div>

  <!-- PASSWORD -->
  <div class="field">
    <label for="password">Password</label>
    <div class="input-wrap">
      <i class="uil uil-lock"></i>
      <input
        type="password" id="password" name="password"
        placeholder="Your password"
        required />
      <i class="uil uil-eye toggle-pw" data-target="password"></i>
    </div>
  </div>

  <!-- CONFIRM PASSWORD -->
  <div class="field">
    <label for="confirm">Confirm Password</label>
    <div class="input-wrap">
      <i class="uil uil-lock"></i>
      <input
        type="password" id="confirm" name="confirm"
        placeholder="Repeat password"
        required />
      <i class="uil uil-eye toggle-pw" data-target="confirm"></i>
    </div>
  </div>

  <button type="submit" name="submit" class="auth-submit">Register</button>
</div>
</form>
</main>
 
<script>
  const toggles = document.querySelectorAll('.toggle-pw');

  toggles.forEach(toggle => {
    toggle.addEventListener('click', function () {
      const input = document.getElementById(this.dataset.target);

      const isText = input.type === 'text';
      input.type = isText ? 'password' : 'text';

      this.classList.toggle('uil-eye', isText);
      this.classList.toggle('uil-eye-slash', !isText);
    });
  });
</script>
     

   
  </body>
</html>