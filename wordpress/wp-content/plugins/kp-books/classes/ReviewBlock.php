<?php

namespace KP\BookPlugin;

// Start up the engine
use WP_Query;

class ReviewBlock extends Singleton {

	/** Static property to hold singleton instance */
	protected static $instance;

	/**
	 * Review block shortcode constructor
	 */
	public function __construct() {
		add_shortcode( 'review-block', [ $this, 'reviewShortcode' ] );
	}

	/**
	 * Creates the content for the review shortcode
	 * @return string
	 */
	public function reviewShortcode() {
		$content = '';
		// The Query.
		$the_query = new WP_Query([
			'post_type' => ReviewPostType::POST_TYPE,
			'meta_key' => ReviewMeta::RATING,
			'meta_value' => 3,
			'meta_compare' => '>',
			'orderby'   => 'rand',
			'posts_per_page' => '1',

		]);

		// The Loop.
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$meta    = ReviewMeta::getInstance();
				$reviewer = $meta->getReviewer();
				$location = $meta->getLocation();
				$rating = intval($meta->getRating());
				$comment = $meta->getComment();

				$content .= '<div class="card mb-4">
						<div class="card-body">
							<h5 class="card-title"><span>' . implode('', array_fill(0, $rating, '<i class="fa-solid fa-star"></i>')) .
				            implode('', array_fill(0, 5 - $rating, '<i class="fa-regular fa-star"></i>')) . '</span>' . ' <b>' . esc_html( get_the_title() ) . '</b></h5>
							<h5 class="card-text">' . $reviewer  . '</h5>
							<p class="card-text">' . $location  . '</p>
							<p>' . $comment . '</p>
						</div>
					 </div>';
			}
		} else {
			esc_html_e( 'No reviews yet!' );
		}
		// Restore original Post Data.
		wp_reset_postdata();

		return $content;
	}



}
