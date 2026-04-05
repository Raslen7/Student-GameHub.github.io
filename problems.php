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
    if (in_array(strtolower($ext), $allowed)) { /* in array techecki haja fi haja */
      $filename = 'uploads/' . uniqid('prob_', true) . '.' . $ext;
      if (!is_dir('uploads')) mkdir('uploads', 0755, true); /* ldossierr li n5abii fihh tswwrr*/
      move_uploaded_file($_FILES['image']['tmp_name'], $filename);
      $image_path = $filename;
    }
  }

  if (!empty($body)) {

    $body_safe = mysqli_real_escape_string($conn, $body); /*  kn msgg fihh ''' ynjm yamli mchakel li naml el isnert lele sql */

    if (!empty($image_path)) {
        $img_safe = mysqli_real_escape_string($conn, $image_path);
    } else {
        $img_safe = null;
    }

    if ($img_safe) {
        $img_sql = "'$img_safe'";
    } else {
        $img_sql = "NULL";
    }

    mysqli_query($conn, "INSERT INTO posts (user_id, type, body, image)  VALUES ('$user_id', 'problem', '$body_safe', $img_sql)");
}

header("Location: problems.php");
exit();
}
//button el likee
if (isset($_POST['toggle_like'])) {
  $post_id = (int)$_POST['post_id'];

  $check = mysqli_query($conn, "SELECT id FROM likes WHERE post_id=$post_id AND user_id=$user_id");

  if (mysqli_num_rows($check) > 0) {
    mysqli_query($conn, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");
  } else {
    mysqli_query($conn, "INSERT INTO likes (post_id, user_id) VALUES ($post_id, $user_id)");
  }
  header("Location: problems.php");
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
  header("Location: problems.php#post-$post_id");
  exit();
}

// 3ndk el 7a9 tfs5 lpsot ttaak 
if (isset($_POST['delete_post'])) {
  $post_id = (int)$_POST['post_id'];
  $res = mysqli_query($conn, "SELECT user_id, image FROM posts WHERE id=$post_id AND type='problem'");
  $p = mysqli_fetch_assoc($res);
  if ($p && $p['user_id'] == $user_id) {
    if ($p['image'] && file_exists($p['image'])) unlink($p['image']);
    mysqli_query($conn, "DELETE FROM posts WHERE id=$post_id");
  }
  header("Location: problems.php");
  exit();
}


$res  = mysqli_query($conn, "SELECT username FROM users WHERE id=$user_id");
$user = mysqli_fetch_assoc($res);

// requet nlam biha les postt taa lproblems b7ass el date taa creation
$posts_res = mysqli_query($conn, "
  SELECT p.*, u.username,
    (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.id) AS like_count,
    (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.id AND l.user_id = $user_id) AS user_liked,
    (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS comment_count
  FROM posts p , users u 
  WHERE p.type = 'problem' and u.id = p.user_id
  ORDER BY p.created_at DESC
");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Problems – Student GameHub</title>
  <link rel="stylesheet" href="assets/styles.css"/>
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"/>
  <script defer src="assets/scripts.js"></script>
  
</head>
<body>
<header class="header" id="header">
  <nav class="nav container">
    <a href="index.php" class="nav__logo">Student GameHub</a>
    <div class="nav__menu" id="nav-menu">
      <ul class="nav__list">
        <li class="nav__item"><a href="index.php" class="nav__link">Home</a></li>
        <li class="nav__item"><a href="tutorial.php" class="nav__link">Tutorial</a></li>
        <li class="nav__item"><a href="problems.php" class="nav__link active-link">Problems</a></li>
        <li class="nav__item"><a href="achievements.php" class="nav__link">Achievements</a></li>
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
    <h2 class="feed-title"><span>⚠️ Problems</span> & Help</h2>
    <p class="feed-subtitle">Stuck on something? Share your issue and get help from the community.</p>

    <!-- Composer -->
    <div class="composer">
      <h3><i class="uil uil-exclamation-triangle"></i> Share a Problem</h3>
      <form method="POST" enctype="multipart/form-data">
        <textarea name="body" placeholder="Describe your problem... What game? What issue?" required></textarea>
        <div id="img-name"></div>
        <div class="composer-actions">
          <label class="img-label">
            <i class="uil uil-image"></i> Add Image
            <input type="file" name="image" accept="image/*" id="img-input">
          </label>
          <button type="submit" name="submit_post" class="post-btn">Post Problem</button>
        </div>
      </form>
    </div>

    <!-- Posts Feed -->
    <?php if (mysqli_num_rows($posts_res) === 0): ?>
      <div class="empty-state">
        <i class="uil uil-comment-question"></i>
        <p>No problems posted yet. Be the first to share!</p>
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
            <?php if ($post['user_id'] == $user_id): ?>
              <form method="POST" onsubmit="return confirm('Delete this post?')">
                <input type="hidden" name="post_id" value="<?php echo $pid; ?>">
                <button type="submit" name="delete_post" class="delete-btn"><i class="uil uil-trash-alt"></i></button>
              </form>
            <?php endif; ?>
          </div>

          <div class="post-body"><?php echo nl2br(htmlspecialchars($post['body'])); ?></div>

          <?php if ($post['image']): ?>
            <img src="<?php echo htmlspecialchars($post['image']); ?>" class="post-img" alt="Post image">
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
              <input type="text" name="comment_body" placeholder="Write a comment..." required>
              <button type="submit" name="submit_comment" class="comment-submit">Send</button>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</main>

<script>
  // Image file name display
  document.getElementById('img-input').addEventListener('change', function () {
    document.getElementById('img-name').textContent = this.files[0] ? '📎 ' + this.files[0].name : '';
  });

  // Toggle comments visibility
  function toggleComments(id) {
    const el = document.getElementById(id);
    el.classList.toggle('hidden');
  }

  // Auto-open comments if URL has anchor
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