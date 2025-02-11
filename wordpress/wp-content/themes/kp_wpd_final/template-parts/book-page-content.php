<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WPD_Final
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="book-page">
        <div class="book-page-banner" style="background-image: url(<?= get_the_post_thumbnail_url(); ?>)">
            <div class="d-flex justify-content-center align-items-center book-page-title">
				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title text-white">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title text-white"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;
				?>
            </div>
        </div>
        <div class="container">
            <header class="entry-header">
                <br>
				<?php
				if ( 'post' === get_post_type() ) :
					?>
                    <div class="entry-meta">
						<?php

						?>
                    </div><!-- .entry-meta -->
				<?php endif; ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
				<?php
				the_content(
					sprintf(
						wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'kp_wpd_final' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kp_wpd_final' ),
						'after'  => '</div>',
					)
				);
				?>
            </div><!-- .entry-content -->
        </div>
    </div>
    <footer class="entry-footer">
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
