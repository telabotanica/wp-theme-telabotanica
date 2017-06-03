<?php
/**
 * Footer.
 */
?>

	</div><!-- .site-content -->

	<?php
    if (!isset($GLOBALS['is_error'])) {
        the_telabotanica_module('footer');
    }
    ?>

<?php wp_footer(); ?>
</body>
</html>
