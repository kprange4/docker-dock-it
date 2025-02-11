<?php

namespace KP\BookPlugin;

/**
 * Book Genre class registers taxonomy of book genre.
 */
class BookSeries extends Singleton{
	const TAXONOMY = 'book_series';

	/** Static property to hold singleton instance */
	protected static $instance;

	/**
	 * Book series taxonomy constructor
	 */
	public function __construct() {
		add_action( 'init', [$this, 'registerSeries'], 0 );
	}

	/**
	 *
	 * Registers series as a taxonomy.
	 *
	 * @return void
	 */
	function registerSeries() {

		$labels = array(
			'name'                       => _x( 'Series', 'Taxonomy General Name', TEXT_DOMAIN ),
			'singular_name'              => _x( 'Series', 'Taxonomy Singular Name', TEXT_DOMAIN ),
			'menu_name'                  => __( 'Series', TEXT_DOMAIN ),
			'all_items'                  => __( 'All Series', TEXT_DOMAIN ),
			'parent_item'                => __( 'Parent Series', TEXT_DOMAIN ),
			'parent_item_colon'          => __( 'Parent Series:', TEXT_DOMAIN ),
			'new_item_name'              => __( 'New Series Name', TEXT_DOMAIN ),
			'add_new_item'               => __( 'Add New Series', TEXT_DOMAIN ),
			'edit_item'                  => __( 'Edit Series', TEXT_DOMAIN ),
			'update_item'                => __( 'Update Series', TEXT_DOMAIN ),
			'view_item'                  => __( 'View Series', TEXT_DOMAIN ),
			'separate_items_with_commas' => __( 'Separate series with commas', TEXT_DOMAIN ),
			'add_or_remove_items'        => __( 'Add or remove series', TEXT_DOMAIN ),
			'choose_from_most_used'      => __( 'Choose from the most used', TEXT_DOMAIN ),
			'popular_items'              => __( 'Popular series', TEXT_DOMAIN ),
			'search_items'               => __( 'Search series', TEXT_DOMAIN ),
			'not_found'                  => __( 'Not Found', TEXT_DOMAIN ),
			'no_terms'                   => __( 'No series', TEXT_DOMAIN ),
			'items_list'                 => __( 'Series list', TEXT_DOMAIN ),
			'items_list_navigation'      => __( 'Series list navigation', TEXT_DOMAIN ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'show_in_rest'               => true,
		);
		register_taxonomy( self::TAXONOMY, array( BookPostType::POST_TYPE ), $args );
	}
}