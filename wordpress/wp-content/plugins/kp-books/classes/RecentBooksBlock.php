<?php

namespace KP\BookPlugin;

// Start up the engine
use WP_Query;

class RecentBooksBlock extends Singleton {

	/** Static property to hold singleton instance */
	protected static $instance;

	/**
	 * Recent books block shortcode constructor
	 */
	public function __construct() {
		add_shortcode( 'recent-books-block', [ $this, 'recentBooksShortcode' ] );
	}

	/**
	 * Creates the content for the recent books shortcode
	 * @return string
	 */
	public function recentBooksShortcode() {
		$content = '<div class="recent-books">
					<div class="container">
					<div class="row d-flex justify-content-between align-items-center">
					<h4 class="col-md-2">Recent Books</h4>
					';
		// The Query.
		$the_query = new WP_Query([
			'post_type' => BookPostType::POST_TYPE,
			'meta_key' => BookMeta::PUBLISHED_DATE,
			'orderby'   => 'meta_value',
			'order' => 'DESC',
			'posts_per_page' => '4',

		]);

		// The Loop.
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$meta    = BookMeta::getInstance();

				$content .= '<div class="col-sm-4 col-md-2 recent-book-thumbnail">
								<a href="' . get_the_permalink() . '">' . get_the_post_thumbnail() . '</a>
								
							 </div>';
			}
		} else {
			esc_html_e( 'No reviews yet!' );
		}
		// Restore original Post Data.
		wp_reset_postdata();

		$content .= '</div></div></div>';

		return $content;
	}



}
