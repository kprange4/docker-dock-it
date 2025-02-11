<?php

namespace KP\BookPlugin;

class BookPlugin extends Singleton {

	/**
	 * Book Plugin Constructor
	 * registers activate and deactivate functions
	 * instantiates all the singletons
	 */
	public function __construct() {
		register_activation_hook(__FILE__, [$this, 'activatePlugin']);
		register_deactivation_hook(__FILE__, [$this, 'deactivatePlugin']);

		// instantiate singletons
		BookPostType::getInstance();
		BookGenre::getInstance();
		BookSeries::getInstance();
		BookMeta::getInstance();
		ReviewPostType::getInstance();
		ReviewMeta::getInstance();
		ReviewBlock::getInstance();
		RecentBooksBlock::getInstance();
		BookPluginSettings::getInstance();
	}

	/**
	 * Activates the plugin when called
	 * Sets the default settings
	 * @return void
	 */
	function activatePlugin() {
		//manually register the post type
		BookPostType::getInstance()->registerPostType();
		BookGenre::getInstance()->registerGenre();
		BookSeries::getInstance()->registerSeries();
		ReviewPostType::getInstance()->registerPostType();

		// flush the permalink cache
		flush_rewrite_rules();

		// set default settings
		BookPluginSettings::getInstance()->setDefaults();
	}

	/**
	 * Deactivates plugin when called
	 * @return void
	 */
	function deactivatePlugin() {
		flush_rewrite_rules();
	}
}