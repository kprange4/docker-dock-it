<?php

namespace KP\BookPlugin;
class ReviewPostType extends Singleton {

	const POST_TYPE = 'review';

	/** Static property to hold singleton instance */
	protected static $instance;

	/**
	 * Review post type constructor
	 */
	public function __construct() {
		add_action( 'init', [$this, 'registerPostType'], 0 );
		add_filter('the_content', [$this, 'reviewContent']);
	}

	/**
	 * Gets the editor setting value from database
	 * @return string
	 */
	public function toggleEditor() {
		$settings = BookPluginSettings::getInstance();
		$useEditor = '';
		if ($settings->showEditorReview()){
			$useEditor = 'editor';
		};

		return $useEditor;
	}

	// Register Custom Post Type

	/**
	 * Registers the review post type
	 * @return void
	 */
	function registerPostType() {

		$labels = array(
			'name'                  => _x( 'Reviews', 'Post Type General Name', TEXT_DOMAIN ),
			'singular_name'         => _x( 'Review', 'Post Type Singular Name', TEXT_DOMAIN ),
			'menu_name'             => __( 'Reviews', TEXT_DOMAIN ),
			'name_admin_bar'        => __( 'Review', TEXT_DOMAIN ),
			'archives'              => __( 'Review Archives', TEXT_DOMAIN ),
			'attributes'            => __( 'Review Attributes', TEXT_DOMAIN ),
			'parent_item_colon'     => __( 'Parent Review:', TEXT_DOMAIN ),
			'all_items'             => __( 'All Reviews', TEXT_DOMAIN ),
			'add_new_item'          => __( 'Add New Review', TEXT_DOMAIN ),
			'add_new'               => __( 'Add New Review', TEXT_DOMAIN ),
			'new_item'              => __( 'New Review', TEXT_DOMAIN ),
			'edit_item'             => __( 'Edit Review', TEXT_DOMAIN ),
			'update_item'           => __( 'Update Review', TEXT_DOMAIN ),
			'view_item'             => __( 'View Review', TEXT_DOMAIN ),
			'view_items'            => __( 'View Reviews', TEXT_DOMAIN ),
			'search_items'          => __( 'Search Review', TEXT_DOMAIN ),
			'not_found'             => __( 'Not found', TEXT_DOMAIN ),
			'not_found_in_trash'    => __( 'Not found in Trash', TEXT_DOMAIN ),
			'featured_image'        => __( 'Featured Image', TEXT_DOMAIN ),
			'set_featured_image'    => __( 'Set featured image', TEXT_DOMAIN ),
			'remove_featured_image' => __( 'Remove featured image', TEXT_DOMAIN ),
			'use_featured_image'    => __( 'Use as featured image', TEXT_DOMAIN ),
			'insert_into_item'      => __( 'Insert into review', TEXT_DOMAIN ),
			'uploaded_to_this_item' => __( 'Uploaded to this review', TEXT_DOMAIN ),
			'items_list'            => __( 'Reviews list', TEXT_DOMAIN ),
			'items_list_navigation' => __( 'Reviews list navigation', TEXT_DOMAIN ),
			'filter_items_list'     => __( 'Filter reviews list', TEXT_DOMAIN ),
		);
		$args   = array(
			'label'               => __( 'Review', TEXT_DOMAIN ),
			'labels'              => $labels,
			'supports'            => array( 'title', $this->toggleEditor() ),
			'taxonomies'          => array( 'review_category' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-admin-comments'
		);
		register_post_type( self::POST_TYPE, $args );

	}

	/**
	 * Displays review content on page
	 *
	 * @param $content
	 *
	 * @return mixed|string
	 */
	public function reviewContent($content) {

		if ( get_post_type() == self::POST_TYPE ) {

			$meta    = ReviewMeta::getInstance();
			$reviewer = $meta->getReviewer();
			$location = $meta->getLocation();
			$rating = intval($meta->getRating());
			$comment = $meta->getComment();

			// remember to add to existing content
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
		return $content;

	}
}