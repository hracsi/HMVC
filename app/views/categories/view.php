<div class="posts">
    <?php foreach($Category['posts'] as $post): ?>
    <div class="post">
        <h1 class="post_title"><?php echo $post['title']; ?></h1>
        <p class="post_text warp"><?php echo $post['text']; ?></p>
        <p class="post_date"><?php echo $post['date']; ?></p>
    </div>
    <?php endforeach; ?>
</div>