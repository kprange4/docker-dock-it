<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WPD_Final
 */

?>


	<footer id="colophon" class="site-footer">
        <div>
			<?php
			dynamic_sidebar('recent-books')
			?>
        </div>
        <div class="container">
        <div class="row">
            <?php dynamic_sidebar('Footer 1') ?>
        </div>
		<div class="site-info">
                <div class="text-white d-flex justify-content-center align-items-center p-4">

                  <h6>© <?php echo date('Y') ?> J.K. Rowling</h6>
                </div>
		</div><!-- .site-info -->
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
