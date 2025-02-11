<?php

namespace KP\BookPlugin;

class BookMeta extends Singleton {
	const PUBLISHER = 'publisher';
	const PUBLISHED_DATE = 'publishedDate';
	const PAGE_COUNT = 'pageCount';
	const PRICE = 'price';
    const DESCRIPTION = 'description';

	/**
	 * Static property to hold singleton instance
	 *
	 */
	protected static $instance;

	/**
	 * Constructs the meta for book and saves the information given as a post.
	 */
	public function __construct() {
		add_action( 'admin_init', [$this, 'registerMetaBox'], 0 );
		add_action('save_post_' . BookPostType::POST_TYPE, [$this, 'saveBookInfo'], 0);
		add_action('save_post_' . BookPostType::POST_TYPE, [$this, 'saveBookDescription'], 0);
	}

    // Book information meta box

	/**
     * Adds the meta boxes to the page.
     *
	 * @return void
	 */
	function registerMetaBox() {
		add_meta_box('book_info_meta',
			'Book Information', [$this, 'bookInfoForm'],
			BookPostType::POST_TYPE,
			'normal',
			'core');

		add_meta_box('book_description_meta',
			'Book Description', [$this, 'bookDescriptionForm'],
			BookPostType::POST_TYPE,
			'normal',
			'core');
	}

	/**
     * Creates the book info form with necessary fields.
     *
	 * @return void
	 */
	function bookInfoForm() {
		// get meta from the database
		$publisher = $this->getPublisher();
		$publishedDate = $this->getPublishedDate();
		$pageCount = $this->getPageCount();
		$price = number_format(floatval($this->getPrice()), 2);
//		$series = $this->getSeries();
		?>
		<p>
			<label><?= __('Publisher:') ?> <input type="text" name="<?= self::PUBLISHER ?>" value="<?= $publisher ?>"></label>
		</p>
		<p>
			<label><?= __('Date Published:') ?> <input type="date" name="<?= self::PUBLISHED_DATE ?>" value="<?= $publishedDate ?>"></label>
		</p>
        <p>
            <label><?= __('Page Count:') ?> <input type="number" name="<?= self::PAGE_COUNT ?>" value="<?= $pageCount ?>"></label>
        </p>
        <p>
            <label><?= __('Price: $') ?><input type="number" step=".01" name="<?= self::PRICE ?>" value="<?= $price ?>"></label>
        </p>
		<?php
	}

	/**
     * Gets, sanitizes, and saves the inputs to the database.
     *
	 * @return void
	 */
	function saveBookInfo() {
		// get values
		$publisher = $_POST[self::PUBLISHER];
		$publishedDate = $_POST[self::PUBLISHED_DATE];
		$pageCount = $_POST[self::PAGE_COUNT];
		$price = $_POST[self::PRICE];

		// sanitize
		$publisher = sanitize_text_field($publisher);
		$publishedDate = sanitize_text_field($publishedDate);
		$pageCount = sanitize_text_field($pageCount);
		$price = sanitize_text_field($price);

		// put in database
		$post = get_post();
		update_post_meta($post->ID, self::PUBLISHER, $publisher);
		update_post_meta($post->ID, self::PUBLISHED_DATE, $publishedDate);
		update_post_meta($post->ID, self::PAGE_COUNT, $pageCount);
		update_post_meta($post->ID, self::PRICE, $price);
	}

	/**
     * Gets the publisher value from database.
	 * @return mixed
	 */
	public function getPublisher(){
		$post = get_post();
		return get_post_meta($post->ID, self::PUBLISHER, true);
	}

	/**
     * Gets the published date value from database.
	 * @return mixed
	 */
	public function getPublishedDate(){
		$post = get_post();
		return get_post_meta($post->ID, self::PUBLISHED_DATE, true);
	}

	/**
     * Gets the page count value from database.
	 * @return mixed
	 */
	public function getPageCount(){
		$post = get_post();
		return get_post_meta($post->ID, self::PAGE_COUNT, true);
	}

	/**
     * Gets the price value from database.
	 * @return mixed
	 */
	public function getPrice(){
		$post = get_post();
		return get_post_meta($post->ID, self::PRICE, true);
	}

    // Book description meta box

	/**
     * Creates the book description form with editor.
	 * @return void
	 */
	function bookDescriptionForm() {
		// get meta from the database
		$description = $this->getDescription();
        wp_editor($description, self::DESCRIPTION);
	}

	/**
	 * Gets, sanitizes, and saves the inputs to the database.
	 * @return void
	 */
	function saveBookDescription() {
		// get values
		$description = $_POST[self::DESCRIPTION];

		// sanitize
		$description = sanitize_text_field($description);

		// put in database
		$post = get_post();
		update_post_meta($post->ID, self::DESCRIPTION, $description);
	}

	/**
     * Gets the description value from database.
	 * @return mixed
	 */
	public function getDescription(){
		$post = get_post();
		return get_post_meta($post->ID, self::DESCRIPTION, true);
	}

}