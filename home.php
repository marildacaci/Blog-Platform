<?php
require_once './partials/db.php';
include './partials/header.php';
?>

<main>
    <div class="container">
        <div class="main__content">
            <h1>Welcome to My Blog</h1>
            <p>Discover articles, stories, and insights from around the world.</p>
        </div>

        <br>

        <div class="home-container">
            <?php
            $sql = "SELECT id, user_id, title, first_image, first_paragraph, created_at
                    FROM posts
                    ORDER BY created_at DESC";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0):
                while ($post = mysqli_fetch_assoc($result)):
                    ?>
                    <article class="home-card">
                        <?php if ($post['first_image']): ?>
                            <img class="home-image" src="<?php echo $post['first_image']; ?>"
                                alt="<?php echo $post['title']; ?>">
                        <?php endif; ?>

                        <div style="padding:1rem;">
                            <h2>
                                <a href="post.php?id=<?php echo $post['id']; ?>" class="home-title">
                                    <?php echo $post['title']; ?>
                                </a>
                            </h2>

                            <p class="home-paragraph">
                                <?php echo nl2br($post['first_paragraph']);?>
                            </p>

                            <small class="home-date">
                                Posted on <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
                            </small>
                        </div>
                    </article>
                    <?php
                endwhile;
                mysqli_free_result($result);
            else:
                ?>
                <p style="text-align:center; color:#666; width:100%;"> No posts yet. Check back soon!</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
include './partials/footer.php';

mysqli_close($conn);
?>