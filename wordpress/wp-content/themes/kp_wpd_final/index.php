<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WPD_Final
 */

get_header();
?>

    <main id="primary" class="site-main">
        <div class="banner-image" style="background-image: url(<?= header_image() ?>)">
            <div class="container">
                <div class="banner d-flex align-items-center">
                    <div class="row">
                        <div class="homepage-intro col-md-6 text-white">
                            <h1>J.K. Rowling</h1>
                            <p>J.K. Rowling is the author behind the iconic Harry Potter series, captivating readers
                                with
                                her
                                magical worlds and unforgettable characters. Her books have inspired millions, sparking
                                imaginations and a love for storytelling. Discover the magic of J.K. Rowling's works
                                here.</p>
                            <a class="btn btn-primary" href="<?= get_page_link( 11 ) ?>">Her Books</a>
                        </div>
                        <div class="col-md-5 offset-1 mt-4 align-items-center">
							<?php
							echo do_shortcode( '[review-block]' );
							?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main><!-- #main -->
<?php
//get_sidebar();
get_footer();
