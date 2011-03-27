<?php echo $html->docType(); ?>
<head>
    <?php
    echo $html->charset();
    echo $html->meta('Author', 'Mad Men');
    echo $html->meta('Keywords', 'Kaméleon, Chameleon, Blog, Kaméleon Blogja, Idézetek, Bejegyzések, Zenék, Gondolatok');
    echo $html->title(' - ' . $title);
    echo $html->css(array('default.css','style.css')); 
    echo $html->js(array ('jquery','scripts'));
    ?>
</head>
<body>
    <div class="header"></div>
    <div class="site">
        <div class="sidebar">
