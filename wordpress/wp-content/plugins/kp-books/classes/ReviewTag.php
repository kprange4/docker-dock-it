<?php

namespace KP\BookPlugin;
class ReviewTag extends Singleton {
	const TAXONOMY = 'review_tag';

	public function __construct() {
		add_action( 'init', [$this, 'registerTag'], 0 );
	}

	// Register Custom Taxonomy
	function registerTag() {

		$labels = array(
			'name'                       => _x( 'Tags', 'Taxonomy General Name', TEXT_DOMAIN ),
			'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name', TEXT_DOMAIN ),
			'menu_name'                  => __( 'Tag', TEXT_DOMAIN ),
			'all_items'                  => __( 'All Tags', TEXT_DOMAIN ),
			'parent_item'                => __( 'Parent Tag', TEXT_DOMAIN ),
			'parent_item_colon'          => __( 'Parent Tag:', TEXT_DOMAIN ),
			'new_item_name'              => __( 'New Tag Name', TEXT_DOMAIN ),
			'add_new_item'               => __( 'Add New Tag', TEXT_DOMAIN ),
			'edit_item'                  => __( 'Edit Tag', TEXT_DOMAIN ),
			'update_item'                => __( 'Update Tag', TEXT_DOMAIN ),
			'view_item'                  => __( 'View Tag', TEXT_DOMAIN ),
			'separate_items_with_commas' => __( 'Separate tags with commas', TEXT_DOMAIN ),
			'add_or_remove_items'        => __( 'Add or remove tags', TEXT_DOMAIN ),
			'choose_from_most_used'      => __( 'Choose from the most used', TEXT_DOMAIN ),
			'popular_items'              => __( 'Popular Tags', TEXT_DOMAIN ),
			'search_items'               => __( 'Search Tags', TEXT_DOMAIN ),
			'not_found'                  => __( 'Not Found', TEXT_DOMAIN ),
			'no_terms'                   => __( 'No tags', TEXT_DOMAIN ),
			'items_list'                 => __( 'Tags list', TEXT_DOMAIN ),
			'items_list_navigation'      => __( 'Tags list navigation', TEXT_DOMAIN ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'show_in_rest'               => true,
		);
		register_taxonomy( self::TAXONOMY, ReviewPostType::POST_TYPE, $args );

	}
}