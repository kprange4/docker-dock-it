<?php
/**
 * Book Plugin
 *
 * @wordpress-plugin
 * Plugin Name: Books
 * Description: Add books an author wrote.
 * Version: 1.0.0
 * Author: Kaylee Prange
 * Text Domain: kp-books
 */

namespace KP\BookPlugin;

register_activation_hook(__FILE__, ['KP\BookPlugin\BookPlugin', 'activatePlugin']);
register_deactivation_hook(__FILE__, ['KP\BookPlugin\BookPlugin', 'deactivatePlugin']);
const TEXT_DOMAIN = 'kp-books';

// include classes
require_once "classes/Singleton.php";
require_once "classes/BookPlugin.php";
require_once "classes/BookPostType.php";
require_once "classes/BookGenre.php";
require_once "classes/BookMeta.php";
require_once "classes/ReviewPostType.php";
require_once "classes/ReviewMeta.php";
require_once "classes/ReviewBlock.php";
require_once "classes/RecentBooksBlock.php";
require_once "classes/BookSeries.php";
require_once "classes/BookPluginSettings.php";

// instantiate singletons
BookPlugin::getInstance();