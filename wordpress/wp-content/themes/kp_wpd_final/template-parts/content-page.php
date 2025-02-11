<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WPD_Final
 */

?>
<div class="container">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <?php the_title( '<h1 class="entry-title mt-4">', '</h1>' ); ?>
        </header><!-- .entry-header -->



        <?php kp_wpd_final_post_thumbnail(); ?>

        <div class="entry-content">
            <?php
            the_content();

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kp_wpd_final' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->

        <?php if ( get_edit_post_link() ) : ?>
            <footer class="entry-footer">
            </footer><!-- .entry-footer -->
        <?php endif; ?>
    </article><!-- #post-<?php the_ID(); ?> -->
</div>
