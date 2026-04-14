<?php
session_start();
include 'db.php';

if (isset($_POST['submit'])) {

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];

        header("Location: index.php");
        exit();

    } else {
        echo "Invalid email or password!";
        header("Location: login.php");
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
     <title>Login – Student GameHub</title>
     
  </head>
  <body>
    <header class="header" id="header">
      <nav class="nav container">
        <a href="index.html" class="nav__logo">Student GameHub</a>
        <div class="nav__menu" id="nav-menu">
          <ul class="nav__list ">
            <li class="nav__item">
              <a href="#home" class="nav__link active-link">
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
          <div class="nav__toggle" id="nav-toggle">
            <!--bchhh tkonn lblasaa taa luser hathii -->
            <i class="uil uil-apps"></i>
          </div>
        </div>
      </nav>
    </header>
    <!-- main-->
<main class="auth-main">
  <div class="auth-card">
 
    <div class="auth-logo">🎮</div>
    <h2 class="auth-title">Welcome back!</h2>
    <p class="auth-subtitle">Don't have an account? <a href="register.php">Register here</a></p>
 
 
    <form method="POST" action="login.php" novalidate>
 
      <div class="field">
        <label for="email">Email address</label>
        <div class="input-wrap">
          <i class="uil uil-envelope"></i>
          <input
            type="email" id="email" name="email"
            placeholder="you@example.com"
            autocomplete="email" required/>
        </div>
      </div>
 
      <div class="field">
        <label for="password">Password</label>
        <div class="input-wrap">
          <i class="uil uil-lock"></i>
          <input
            type="password" id="password" name="password"
            placeholder="Your password"
            autocomplete="current-password" required/>
          <i class="uil uil-eye toggle-pw" id="toggle-pw" data-target="password"></i>
        </div>
      </div>
 
      <button type="submit" name="submit" class="auth-submit">Login</button>
    </form>
 
    <p class="auth-divider">New here? <a href="register.php">Create an account</a></p>
 
  </div>
</main>
 


     

   
  </body>
</html>