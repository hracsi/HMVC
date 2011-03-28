        <div class="posts">
            <?php foreach($Post['posts'] as $post): ?>
            <div class="post">
                <h1 class="post_title">
                    <?php echo $html->makeLink($post['title'],array('controller' => 'posts', 'action' => 'view', 'id' => $post['id']),array('class' => 'post'));?>
                </h1>
                <p class="post_text warp"><?php echo $post['text']; ?></p>
                <p class="post_date"><?php echo $post['date']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>