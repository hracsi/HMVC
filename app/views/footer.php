        <?php global $startTime,$numberOfQueries,$numOfClasses,$classes; ?>
        <div class="footer">Rendering time: <?php echo round(microtime(true) - $startTime, 3); ?> sec. <?php echo $numberOfQueries; ?> number of queries. Number of clases: <?php echo $numOfClasses; ?></div>
        <?php //echo print_r($classes); ?>
    </div>
</body>
</html>