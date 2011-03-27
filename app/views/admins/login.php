</div></div>
<br style="clear: both;" />

    <?php if ( $_SESSION['admin'] == 'Y' ): ?>
        <div align="center">
            <h2>Menü</h2>
            <a class="category_link" href="/admins/posts">Bejegyzések</a><br />
            <a class="category_link" href="/admins/categories">Kategóriák</a><br />
            <a class="category_link" href="/admins/settings">Hozzászólások</a><br />
            <a class="category_link" href="/admins/logout">Magamról</a><br />
            <a class="category_link" href="/admins/logout">Kijelentkezés</a><br />
        </div>
    <?php else: ?>
        <div align="center">
            <form action="<?php echo $Admin['form']['action']; ?>" method="<?php echo $Admin['form']['method']; ?>">
                <b>Jelszó:</b><br />
                <input type="password" name="password" size="19" /><br /><br />
                <input type="submit" name="kuld" value=" OK! " />
            </form>
        </div>
    <?php endif; ?>
