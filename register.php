<?php
session_start();
include 'db.php';

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];


    // Hash password
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
     <title>Login – Student GameHub</title>
  <style>
    .auth-main {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 100px 20px 60px;
    }
    .auth-card {
      background: #0b2230;
      border: 1px solid rgba(255,255,255,0.07);
      border-radius: 20px;
      padding: 44px 40px;
      width: 100%;
      max-width: 420px;
    }
    .auth-logo     { text-align:center; font-size:44px; margin-bottom:6px; }
    .auth-title    { text-align:center; font-size:22px; font-weight:700; color:#fff; margin-bottom:6px; }
    .auth-subtitle { text-align:center; font-size:14px; color:#4a6070; margin-bottom:30px; }
    .auth-subtitle a { color:#7aa2ff; text-decoration:none; }
    .auth-subtitle a:hover { text-decoration:underline; }
 
    .error-box {
      background: rgba(255,107,107,0.1);
      border: 1px solid rgba(255,107,107,0.3);
      border-radius: 10px;
      padding: 12px 16px;
      margin-bottom: 20px;
      font-size: 13px;
      color: #ff6b6b;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .error-box i { font-size: 16px; }
    .field       { display:flex; flex-direction:column; gap:6px; margin-bottom:16px; }
    .field label { font-size:13px; font-weight:600; color:#b6c2cf; }
    .input-wrap   { position:relative; display:flex; align-items:center; }
.input-wrap i {
  position:absolute;
  left:14px;
  font-size:18px;
  color:#4a6070;
  pointer-events:none;
}

/* OVERRIDE for toggle */
.toggle-pw {
  right:14px;
  left:auto; /* IMPORTANT */
  pointer-events:auto; /* allow click */
  cursor:pointer;
}    .input-wrap input {
      width:100%; background:#061e29;
      border:1px solid rgba(255,255,255,0.1);
      border-radius:10px; color:#F3F4F4;
      font-size:14px; padding:12px 14px 12px 44px;
      outline:none; transition:border-color 0.2s;
      font-family:Arial,sans-serif;
    }
    .input-wrap input:focus      { border-color:#3b49df; }
    .input-wrap input::placeholder { color:#4a6070; }
    .toggle-pw:hover { color:#b6c2cf; }
    .auth-submit {
      width:100%; padding:14px; background:#3b49df;
      color:#fff; border:none; border-radius:10px;
      font-size:15px; font-weight:700; cursor:pointer;
      transition:background 0.2s, transform 0.1s;
      margin-top:6px; font-family:Arial,sans-serif;
    }
    .auth-submit:hover  { background:#2d39c0; }
    .auth-submit:active { transform:scale(0.98); }
 
    .auth-divider { text-align:center; margin-top:22px; font-size:13px; color:#4a6070; }
    .auth-divider a { color:#7aa2ff; text-decoration:none; font-weight:600; }
    .auth-divider a:hover { text-decoration:underline; }
    @media (max-width:500px) { .auth-card { padding:30px 20px; } }
  </style>
     
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
    <h2 class="auth-title">Welcome back!</h2>
    <p class="auth-subtitle">Don't have an account? <a href="login.php">login here</a></p>
        
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



