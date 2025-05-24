<?php
require_once './partials/db.php';
include './partials/header.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  echo '<p>Invalid post ID.</p>';
  include './partials/footer.php';
  exit;
}
$post_id = (int) $_GET['id'];

$liked = false;
if (isset($_SESSION['user_id'])) {
  $uid = (int) $_SESSION['user_id'];
  $sqlLike = "SELECT 1 FROM likes WHERE likes_user_id = $uid AND likes_post_id = $post_id LIMIT 1";
  $resLike = mysqli_query($conn, $sqlLike);
  if ($resLike && mysqli_num_rows($resLike) > 0) {
    $liked = true;
  }
}

$sqlP = "SELECT posts.id, posts.user_id, posts.title, posts.first_image, posts.first_paragraph, posts.created_at,
        users.username
        FROM posts
        JOIN users ON posts.user_id = users.id
        WHERE posts.id = $post_id";
$resultP = mysqli_query($conn, $sqlP);

if (!$resultP || mysqli_num_rows($resultP) === 0) {
  echo '<p>Post not found.</p>';
  include './partials/footer.php';
  exit;
}

$post = mysqli_fetch_assoc($resultP);
mysqli_free_result($resultP);
?>
<main class="post-container">
  <div class="home-card" style="margin: 10px;">
    <div>
      <h1 class="home-title" style="text-align: center; padding-top: 20px">
        <?php echo htmlspecialchars($post['title']); ?></h1>
      <p style="color:#555; text-align: center; padding: 0px">
        by <strong><?php echo htmlspecialchars($post['username']); ?></strong>
        &bull; <?php echo date('F j, Y, g:ia', strtotime($post['created_at'])); ?>
      </p>
    </div>

    <div style="padding: 1rem">
      <?php if ($post['first_image']): ?>
        <img src="<?php echo htmlspecialchars($post['first_image']); ?>"
          alt="<?php echo htmlspecialchars($post['title']); ?>" class="post-image">
      <?php endif; ?>

      <div class="post-paragraph">
        <?php echo nl2br(htmlspecialchars($post['first_paragraph'])); ?>
      </div>

      <form action="./backend/like.php" method="POST" style="margin-bottom:2rem;">
        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
        <button
        class="post-like-button<?php echo $liked ? ' liked' : ''; ?>"
        onclick="toggleLikeButton(this)"
        type="submit">Like</button>
      </form>
    </div>
  </div>

  <section>
    <h2>Comments</h2>

    <?php
    $sqlC = "SELECT comments.comment, comments.commented_at, users.username
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE comments.post_id = $post_id
            ORDER BY comments.commented_at DESC";
    $resultC = mysqli_query($conn, $sqlC);

    if ($resultC && mysqli_num_rows($resultC) > 0):
      while ($c = mysqli_fetch_assoc($resultC)):
        ?>
        <div class="post-comment">
          <p><strong><?php echo htmlspecialchars($c['username']); ?></strong>
            <small style="color:#777;">
              &bull; <?php echo date('F j, Y, g:ia', strtotime($c['commented_at'])); ?>
            </small>
          </p>
          <p><?php echo nl2br(htmlspecialchars($c['comment'])); ?></p>
        </div>
        <?php
      endwhile;
      mysqli_free_result($resultC);
    else:
      echo '<p>No comments yet. Be the first to comment!</p>';
    endif;
    ?>

    <form action="./backend/comment.php" method="POST" style="margin-top:1.5rem;">
      <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
      <div>
        <textarea class="post-comment-textarea" name="comment" rows="4" required
          placeholder="Write your comment here…"></textarea>
      </div>
      <button class="post-comment-button" type="submit">Post Comment</button>
    </form>
  </section>
</main>

<script src="./js/index.js"></script>

<?php
include './partials/footer.php';
mysqli_close($conn);
?>