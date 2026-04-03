<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Handle logout
if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

// Handle new post
if (isset($_POST['submit_post'])) {
  $body = trim($_POST['body']);
  $image_path = null;

  if (!empty($_FILES['image']['name'])) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif','webp'];
    if (in_array(strtolower($ext), $allowed)) {
      $filename = 'uploads/' . uniqid('ach_', true) . '.' . $ext;
      if (!is_dir('uploads')) mkdir('uploads', 0755, true);
      move_uploaded_file($_FILES['image']['tmp_name'], $filename);
      $image_path = $filename;
    }
  }

  if (!empty($body)) {
    $body_safe = mysqli_real_escape_string($conn, $body);
    $img_safe  = $image_path ? mysqli_real_escape_string($conn, $image_path) : null;
    $img_sql   = $img_safe ? "'$img_safe'" : "NULL";
    mysqli_query($conn, "INSERT INTO posts (user_id, type, body, image) VALUES ('$user_id', 'achievement', '$body_safe', $img_sql)");
  }
  header("Location: achievements.php");
  exit();
}

// Handle like toggle
if (isset($_POST['toggle_like'])) {
  $post_id = (int)$_POST['post_id'];
  $check = mysqli_query($conn, "SELECT id FROM likes WHERE post_id=$post_id AND user_id=$user_id");
  if (mysqli_num_rows($check) > 0) {
    mysqli_query($conn, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");
  } else {
    mysqli_query($conn, "INSERT INTO likes (post_id, user_id) VALUES ($post_id, $user_id)");
  }
  header("Location: achievements.php");
  exit();
}

// Handle comment
if (isset($_POST['submit_comment'])) {
  $post_id = (int)$_POST['post_id'];
  $comment = trim($_POST['comment_body']);
  if (!empty($comment)) {
    $comment_safe = mysqli_real_escape_string($conn, $comment);
    mysqli_query($conn, "INSERT INTO comments (post_id, user_id, body) VALUES ($post_id, $user_id, '$comment_safe')");
  }
  header("Location: achievements.php#post-$post_id");
  exit();
}

// Handle delete post
if (isset($_POST['delete_post'])) {
  $post_id = (int)$_POST['post_id'];
  $res = mysqli_query($conn, "SELECT user_id, image FROM posts WHERE id=$post_id AND type='achievement'");
  $p = mysqli_fetch_assoc($res);
  if ($p && $p['user_id'] == $user_id) {
    if ($p['image'] && file_exists($p['image'])) unlink($p['image']);
    mysqli_query($conn, "DELETE FROM posts WHERE id=$post_id");
  }
  header("Location: achievements.php");
  exit();
}

// Fetch current user
$res  = mysqli_query($conn, "SELECT username FROM users WHERE id=$user_id");
$user = mysqli_fetch_assoc($res);

// Fetch all achievement posts
$posts_res = mysqli_query($conn, "
  SELECT p.*, u.username,
    (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.id) AS like_count,
    (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.id AND l.user_id = $user_id) AS user_liked,
    (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS comment_count
  FROM posts p
  JOIN users u ON u.id = p.user_id
  WHERE p.type = 'achievement'
  ORDER BY p.created_at DESC
");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Achievements – Student GameHub</title>
  <link rel="stylesheet" href="assets/Styles.css"/>
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"/>
  <script defer src="assets/scripts.js"></script>
  <style>
    /* ── Feed Layout ── */
    .feed-wrapper {
      max-width: 720px;
      margin: 100px auto 60px;
      padding: 0 20px;
    }
    .feed-title {
      font-size: 28px;
      font-weight: 800;
      color: #fff;
      margin-bottom: 6px;
    }
    .feed-title span { color: #A0C878; }
    .feed-subtitle { color: #4a6070; font-size: 14px; margin-bottom: 28px; }

    /* ── Post Composer ── */
    .composer {
      background: #0b2230;
      border: 1px solid rgba(255,255,255,0.07);
      border-radius: 18px;
      padding: 22px 24px;
      margin-bottom: 28px;
    }
    .composer h3 { color: #fff; font-size: 16px; margin-bottom: 14px; display:flex; align-items:center; gap:8px; }
    .composer h3 i { color: #A0C878; font-size: 20px; }
    .composer textarea {
      width: 100%; background: #061e29;
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 12px; color: #f3f4f4;
      font-size: 14px; padding: 14px;
      resize: vertical; min-height: 90px;
      outline: none; font-family: inherit;
      transition: border-color 0.2s; box-sizing: border-box;
    }
    .composer textarea:focus { border-color: #A0C878; }
    .composer textarea::placeholder { color: #4a6070; }
    .composer-actions {
      display: flex; align-items: center;
      justify-content: space-between; margin-top: 14px; gap: 12px;
    }
    .img-label {
      display: flex; align-items: center; gap: 8px;
      background: #061e29; border: 1px solid rgba(255,255,255,0.1);
      border-radius: 10px; padding: 10px 16px;
      color: #b6c2cf; font-size: 13px; cursor: pointer;
      transition: border-color 0.2s;
    }
    .img-label:hover { border-color: #A0C878; color: #A0C878; }
    .img-label i { font-size: 18px; }
    .img-label input { display: none; }
    #img-name { color: #4a6070; font-size: 12px; margin-top: 6px; }
    .post-btn {
      background: #A0C878; color: #0a1a0d; border: none;
      border-radius: 10px; padding: 10px 22px;
      font-size: 14px; font-weight: 700; cursor: pointer;
      transition: background 0.2s, transform 0.1s; font-family: inherit;
    }
    .post-btn:hover { background: #8db862; }
    .post-btn:active { transform: scale(0.97); }

    /* ── Post Card ── */
    .post-card {
      background: #0b2230;
      border: 1px solid rgba(255,255,255,0.07);
      border-radius: 18px; margin-bottom: 22px;
      overflow: hidden; transition: border-color 0.2s;
    }
    .post-card:hover { border-color: rgba(160,200,120,0.25); }
    .post-header {
      display: flex; align-items: center;
      justify-content: space-between;
      padding: 18px 20px 0;
    }
    .post-author {
      display: flex; align-items: center; gap: 12px;
    }
    .avatar {
      width: 40px; height: 40px; border-radius: 50%;
      background: linear-gradient(135deg, #A0C878, #5fa832);
      display: flex; align-items: center; justify-content: center;
      color: #0a1a0d; font-size: 16px; font-weight: 700;
      text-transform: uppercase; flex-shrink: 0;
    }
    .post-meta { display: flex; flex-direction: column; }
    .post-username { color: #fff; font-weight: 700; font-size: 15px; }
    .post-time { color: #4a6070; font-size: 12px; }
    .post-badge {
      background: rgba(160,200,120,0.15);
      color: #A0C878; border-radius: 20px;
      padding: 4px 12px; font-size: 12px; font-weight: 600;
    }
    .delete-btn {
      background: none; border: none; color: #4a6070;
      cursor: pointer; font-size: 18px; padding: 4px;
      transition: color 0.2s; line-height: 1;
    }
    .delete-btn:hover { color: #ff6b6b; }
    .post-body {
      padding: 14px 20px; color: #c8d0d8;
      font-size: 15px; line-height: 1.65;
    }
    .post-img {
      width: 100%; max-height: 420px; object-fit: cover;
      border-top: 1px solid rgba(255,255,255,0.05);
    }
    .post-actions {
      display: flex; align-items: center; gap: 6px;
      padding: 12px 20px;
      border-top: 1px solid rgba(255,255,255,0.05);
    }
    .action-btn {
      display: flex; align-items: center; gap: 6px;
      background: none; border: none; color: #4a6070;
      font-size: 14px; cursor: pointer; padding: 8px 14px;
      border-radius: 8px; transition: all 0.2s; font-family: inherit;
    }
    .action-btn i { font-size: 18px; }
    .action-btn:hover { background: rgba(255,255,255,0.05); color: #b6c2cf; }
    .action-btn.liked { color: #A0C878; }
    .action-btn.liked i { animation: pop 0.3s ease; }
    @keyframes pop { 0%,100%{transform:scale(1)} 50%{transform:scale(1.3)} }

    /* ── Comments ── */
    .comments-section {
      padding: 0 20px 18px;
      border-top: 1px solid rgba(255,255,255,0.05);
    }
    .comments-section.hidden { display: none; }
    .comment-list { margin-bottom: 14px; }
    .comment-item {
      display: flex; gap: 10px; margin-top: 12px;
      padding-top: 12px;
      border-top: 1px solid rgba(255,255,255,0.04);
    }
    .comment-item:first-child { border-top: none; margin-top: 8px; }
    .comment-avatar {
      width: 32px; height: 32px; border-radius: 50%;
      background: linear-gradient(135deg, #3b49df, #6c63ff);
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 12px; font-weight: 700;
      text-transform: uppercase; flex-shrink: 0;
    }
    .comment-content { flex: 1; }
    .comment-user { color: #fff; font-size: 13px; font-weight: 700; }
    .comment-body { color: #8899aa; font-size: 13px; line-height: 1.5; }
    .comment-form {
      display: flex; gap: 10px; align-items: flex-start; margin-top: 10px;
    }
    .comment-form input {
      flex: 1; background: #061e29;
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 10px; color: #f3f4f4;
      font-size: 13px; padding: 10px 14px;
      outline: none; font-family: inherit;
      transition: border-color 0.2s;
    }
    .comment-form input:focus { border-color: #A0C878; }
    .comment-form input::placeholder { color: #4a6070; }
    .comment-submit {
      background: #A0C878; color: #0a1a0d; border: none;
      border-radius: 10px; padding: 10px 16px;
      cursor: pointer; font-size: 13px; font-weight: 700;
      transition: background 0.2s; font-family: inherit;
    }
    .comment-submit:hover { background: #8db862; }

    /* ── Empty State ── */
    .empty-state {
      text-align: center; padding: 60px 20px;
      color: #4a6070; border: 2px dashed rgba(255,255,255,0.06);
      border-radius: 18px;
    }
    .empty-state i { font-size: 48px; display: block; margin-bottom: 12px; color: #A0C878; }
    .empty-state p { font-size: 15px; }
  </style>
</head>
<body>
<header class="header" id="header">
  <nav class="nav container">
    <a href="index.php" class="nav__logo">Student GameHub</a>
    <div class="nav__menu" id="nav-menu">
      <ul class="nav__list">
        <li class="nav__item"><a href="index.php" class="nav__link">Home</a></li>
        <li class="nav__item"><a href="tutorial.php" class="nav__link">Tutorial</a></li>
        <li class="nav__item"><a href="problems.php" class="nav__link">Problems</a></li>
        <li class="nav__item"><a href="achievements.php" class="nav__link active-link">Achievements</a></li>
        <li class="nav__item"><a href="https://raslen.me/" class="nav__link">Contact-Me</a></li>
      </ul>
      <i class="uil uil-times nav__close" id="nav-close"></i>
    </div>
    <div class="nav__btns">
      <div class="nav__profile" id="nav-profile">
        <form method="POST">
          <div class="profile__info">
            <h3 class="profile__name"><?php echo htmlspecialchars($user['username']); ?></h3>
            <button class="profile__logout" name="logout"><b>Log out</b></button>
          </div>
        </form>
      </div>
      <div class="nav__toggle" id="nav-toggle"><i class="uil uil-apps"></i></div>
    </div>
  </nav>
</header>

<main>
  <div class="feed-wrapper">
    <h2 class="feed-title"><span>🏆 Achievements</span> & Wins</h2>
    <p class="feed-subtitle">Share your gaming wins, unlocks, and milestones with the community!</p>

    <!-- Composer -->
    <div class="composer">
      <h3><i class="uil uil-trophy"></i> Share an Achievement</h3>
      <form method="POST" enctype="multipart/form-data">
        <textarea name="body" placeholder="What did you unlock? What's your win? Share it!" required></textarea>
        <div id="img-name"></div>
        <div class="composer-actions">
          <label class="img-label">
            <i class="uil uil-image"></i> Add Screenshot
            <input type="file" name="image" accept="image/*" id="img-input">
          </label>
          <button type="submit" name="submit_post" class="post-btn">🏆 Post Achievement</button>
        </div>
      </form>
    </div>

    <!-- Posts Feed -->
    <?php if (mysqli_num_rows($posts_res) === 0): ?>
      <div class="empty-state">
        <i class="uil uil-award"></i>
        <p>No achievements posted yet. Share your first win!</p>
      </div>
    <?php else: ?>
      <?php while ($post = mysqli_fetch_assoc($posts_res)): ?>
        <?php
          $pid = $post['id'];
          $comments_res = mysqli_query($conn, "
            SELECT c.*, u.username FROM comments c
            JOIN users u ON u.id = c.user_id
            WHERE c.post_id = $pid ORDER BY c.created_at ASC
          ");
        ?>
        <div class="post-card" id="post-<?php echo $pid; ?>">
          <div class="post-header">
            <div class="post-author">
              <div class="avatar"><?php echo strtoupper(substr($post['username'], 0, 1)); ?></div>
              <div class="post-meta">
                <span class="post-username"><?php echo htmlspecialchars($post['username']); ?></span>
                <span class="post-time"><?php echo date('M j, Y · g:i A', strtotime($post['created_at'])); ?></span>
              </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px">
              <span class="post-badge">🏆 Achievement</span>
              <?php if ($post['user_id'] == $user_id): ?>
                <form method="POST" onsubmit="return confirm('Delete this post?')" style="margin:0">
                  <input type="hidden" name="post_id" value="<?php echo $pid; ?>">
                  <button type="submit" name="delete_post" class="delete-btn"><i class="uil uil-trash-alt"></i></button>
                </form>
              <?php endif; ?>
            </div>
          </div>

          <div class="post-body"><?php echo nl2br(htmlspecialchars($post['body'])); ?></div>

          <?php if ($post['image']): ?>
            <img src="<?php echo htmlspecialchars($post['image']); ?>" class="post-img" alt="Achievement screenshot">
          <?php endif; ?>

          <div class="post-actions">
            <!-- Like -->
            <form method="POST" style="margin:0">
              <input type="hidden" name="post_id" value="<?php echo $pid; ?>">
              <button type="submit" name="toggle_like"
                class="action-btn <?php echo $post['user_liked'] ? 'liked' : ''; ?>">
                <i class="uil uil-<?php echo $post['user_liked'] ? 'heart-alt' : 'heart'; ?>"></i>
                <?php echo $post['like_count']; ?>
              </button>
            </form>
            <!-- Comment toggle -->
            <button class="action-btn" onclick="toggleComments('comments-<?php echo $pid; ?>')">
              <i class="uil uil-comment-dots"></i> <?php echo $post['comment_count']; ?>
            </button>
          </div>

          <!-- Comments -->
          <div class="comments-section hidden" id="comments-<?php echo $pid; ?>">
            <div class="comment-list">
              <?php while ($c = mysqli_fetch_assoc($comments_res)): ?>
                <div class="comment-item">
                  <div class="comment-avatar"><?php echo strtoupper(substr($c['username'], 0, 1)); ?></div>
                  <div class="comment-content">
                    <div class="comment-user"><?php echo htmlspecialchars($c['username']); ?></div>
                    <div class="comment-body"><?php echo nl2br(htmlspecialchars($c['body'])); ?></div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
            <form method="POST" class="comment-form">
              <input type="hidden" name="post_id" value="<?php echo $pid; ?>">
              <input type="text" name="comment_body" placeholder="Congrats or say something..." required>
              <button type="submit" name="submit_comment" class="comment-submit">Send</button>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</main>

<script>
  document.getElementById('img-input').addEventListener('change', function () {
    document.getElementById('img-name').textContent = this.files[0] ? '📎 ' + this.files[0].name : '';
  });

  function toggleComments(id) {
    const el = document.getElementById(id);
    el.classList.toggle('hidden');
  }

  window.addEventListener('load', function () {
    const hash = window.location.hash;
    if (hash && hash.startsWith('#post-')) {
      const pid = hash.replace('#post-', '');
      const comments = document.getElementById('comments-' + pid);
      if (comments) comments.classList.remove('hidden');
    }
  });
</script>
</body>
</html>