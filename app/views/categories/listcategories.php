            <div class="categories">
                <h1 class="categories">Kategóriák:</h1>
                <?php foreach($categories as $cat): ?>
                    <?php echo $html->makeLink($cat['name'], array('controller' => 'Categories', 'action' => 'view', 'id' => $cat['ID'], 'title' => $cat['name']), array('class' => 'category_link')); ?>
                    <br />
                <?php endforeach; ?>
                <br /><br /><br />
            </div>
        </div>