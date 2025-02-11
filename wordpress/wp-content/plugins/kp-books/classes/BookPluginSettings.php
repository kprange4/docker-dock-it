<?php

namespace KP\BookPlugin;

class BookPluginSettings extends Singleton {

    // Book and Review constants
	const SETTINGS_GROUP = 'book-settings';

    // Book constants
	const SHOW_EDITOR_BOOK = 'showEditorBook';

    // Review constants
	const SHOW_EDITOR_REVIEW = 'showEditorReview';

	/** Static property to hold singleton instance */
	protected static $instance;

	/**
	 * Settings page constructor
	 */
	public function __construct() {
		add_action( 'admin_init', [$this, 'registerSettings'], 0 );
		add_action('admin_menu', [$this, 'addMenuPages']);
	}

    // Book information meta box

	/**
     * Registers the settings groups
	 * @return void
	 */
	function registerSettings() {
        register_setting( self::SETTINGS_GROUP, self::SHOW_EDITOR_BOOK);
		register_setting( self::SETTINGS_GROUP, self::SHOW_EDITOR_REVIEW);
        $this->addFields();
	}

	/**
     * Adds submenus to the Book menu
	 * @return void
	 */
    public function addMenuPages() {
        add_submenu_page(
            'edit.php?post_type=book',
            'Book Plugin Settings',
            'Settings',
            'manage_options',
            'book-settings',
            [$this, 'settingsPage'],
            99
        );

	    add_submenu_page(
		    'edit.php?post_type=book',
		    'Reviews',
		    'All Reviews',
		    'edit_pages',
		    'edit.php?post_type=review',
		    '',
		    2
	    );

        remove_menu_page('edit.php?post_type=review');

//	    echo '<pre>';
//            print_r($GLOBALS['menu']);
//            die();
    }

	/**
     * Creates the form for the settings page
	 * @return void
	 */
    public function settingsPage(){ ?>
        <h1>Book Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields(self::SETTINGS_GROUP); ?>
            <?php do_settings_sections(self::SETTINGS_GROUP); ?>
            <?php submit_button('Save Changes'); ?>
        </form>
<?php
    }

	/**
     * Adds the fields to the settings page
	 * @return void
	 */
	public function addFields(){
		// ------ Book Settings ------
        add_settings_section(
                'book-general',
                'Book Settings',
            function (){},
                self::SETTINGS_GROUP
        );

		add_settings_field(
			self::SHOW_EDITOR_BOOK,
			'Use Gutenberg Editor',
			function (){
				$checked = get_option(self::SHOW_EDITOR_BOOK) ? 'checked' : '';
				?>
                <input type="checkbox"
                       id="<?= self::SHOW_EDITOR_BOOK ?>"
                       name="<?= self::SHOW_EDITOR_BOOK ?>"
					<?= $checked ?>
                       value="1">
				<?php
			},
			self::SETTINGS_GROUP,
			'book-general',
		);

        // ------ Review Settings ------

		add_settings_section(
			'review-general',
			'Review Settings',
			function (){},
			self::SETTINGS_GROUP
		);

		add_settings_field(
			self::SHOW_EDITOR_REVIEW,
			'Use Gutenberg Editor',
			function (){
				$checked = get_option(self::SHOW_EDITOR_REVIEW) ? 'checked' : '';
				?>
                <input type="checkbox"
                       id="<?= self::SHOW_EDITOR_REVIEW ?>"
                       name="<?= self::SHOW_EDITOR_REVIEW ?>"
					<?= $checked ?>
                       value="1">
				<?php
			},
			self::SETTINGS_GROUP,
			'review-general',
		);
	}

	/**
     * Gets the option set for the books post type from the database
	 * @return false|mixed|null
	 */
	public function showEditorBook() {
		return get_option(self::SHOW_EDITOR_BOOK);
	}

	/**
	 * Gets the option set for the review post type from the database
	 * @return false|mixed|null
	 */
	public function showEditorReview() {
		return get_option(self::SHOW_EDITOR_REVIEW);
	}

	/**
     * Sets the default settings
	 * @return void
	 */
	public function setDefaults() {
		// will not override existing values
		add_option(self::SHOW_EDITOR_BOOK, 0);
	}

}