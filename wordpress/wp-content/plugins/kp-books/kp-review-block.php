<?php

namespace KP\BookPlugin;

// Start up the engine
use WP_Query;

class ReviewBlock extends Singleton {

	protected static $instance;

	/**
	 * This is our constructor
	 *
	 * @return void
	 */
	private function __construct() {
		add_shortcode('author-block', [$this, 'authorShortcode']);
	}
	public function reviewShortcode($atts) {

		// The Query.
		$the_query = new WP_Query([
			'post_type' => ReviewPostType::POST_TYPE,

		]);

// The Loop.
		if ( $the_query->have_posts() ) {
			echo '<ul>';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				echo '<li>' . esc_html( get_the_title() ) . '</li>';
			}
			echo '</ul>';
		} else {
			esc_html_e( 'Sorry, no posts matched your criteria.' );
		}
// Restore original Post Data.
		wp_reset_postdata();

		$a = shortcode_atts([
			'name' => get_the_author_meta('display_name'),
			'bio' => get_the_author_meta('description'),
			'image_url' => get_avatar_url(get_the_author_meta('ID')),
		], $atts);

		return "<div>
				<img src='" . $a['image_url'] . "' alt='Photo of " . $a['name'] . "' style='width:150px' />
				<h3>{$a['name']}</h3>
				<p>{$a['bio']}</p>
				</div>";
	}

}
