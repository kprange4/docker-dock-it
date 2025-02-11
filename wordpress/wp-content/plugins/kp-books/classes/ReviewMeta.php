<?php

namespace KP\BookPlugin;

class ReviewMeta extends Singleton {
	const REVIEWER = 'reviewer';
	const LOCATION = 'location';
	const RATING = 'rating';
	const BOOK = 'book';
	const COMMENT = 'comment';

	/** Static property to hold singleton instance */
	protected static $instance;

	/**
	 * Constructs the meta for reviews and saves the information given as a post.
	 */
	public function __construct() {
		add_action( 'admin_init', [$this, 'registerMetaBox'], 0 );
		add_action('save_post_' . ReviewPostType::POST_TYPE, [$this, 'saveReview'], 0);
		add_action('save_post_' . ReviewPostType::POST_TYPE, [$this, 'saveComment'], 0);
	}

	/**
	 * Adds the meta boxes to the page.
	 * @return void
	 */
	function registerMetaBox() {
		add_meta_box('review_meta',
			'Review', [$this, 'reviewForm'],
			ReviewPostType::POST_TYPE,
			'normal',
			'core');
		add_meta_box('review_comment_meta',
			'Comment', [$this, 'commentForm'],
			ReviewPostType::POST_TYPE,
			'normal',
			'core');
	}

	/**
	 * Creates the review info form with necessary fields.
	 *
	 * @return void
	 */
	function reviewForm() {
		// get meta from the database
		$reviewer = $this->getReviewer();
		$location = $this->getLocation();
		$rating = $this->getRating();
		$book = $this->getBook();
		?>
		<p>
			<label><?= __('Name: ') ?><input type="text" name="<?= self::REVIEWER ?>" value="<?= $reviewer ?>"></label>
		</p>
		<p>
			<label><?= __('Location: ') ?><input type="text" name="<?= self::LOCATION ?>" value="<?= $location ?>" placeholder="City, State"></label>
		</p>
		<p>
			<?= __('Rating: ') ?><br>
				<?php for ($rating = 1; $rating <= 5; $rating++): ?>
                    <label>
                        <input type="radio" name="<?= self::RATING ?>" value="<?= $rating ?>" <?= $this->getRating() == $rating ? 'checked' : '' ?>>
                        <span ></span>
                        <span><?= implode('', array_fill(0, $rating, '<span class="dashicons dashicons-star-filled"></span>')) ?><?=
							implode('', array_fill(0, 5 - $rating, '<span class="dashicons dashicons-star-empty"></span>')) ?></span>
                    </label><br>
				<?php endfor; ?>
		</p>
		<p>
			<label><?= __('Book:') ?>
                <?php
                    wp_dropdown_pages( array(
                            'post_type' => BookPostType::POST_TYPE,
                            'name' => self::BOOK,
                            'value' => $book,
                        )
                    )
                ?>
            </label>
		</p>
		<?php
	}

	/**
	 * Gets, sanitizes, and saves the inputs to the database.
	 *
	 * @return void
	 */
	function saveReview() {
		// get values
		$reviewer = $_POST[self::REVIEWER];
		$location = $_POST[self::LOCATION];
		$rating = $_POST[self::RATING];
		$book = $_POST[self::BOOK];

		// sanitize
		$reviewer = sanitize_text_field($reviewer);
		$location = sanitize_text_field($location);
		$rating = sanitize_text_field($rating);
		$book = sanitize_text_field($book);

		// put in database
		$post = get_post();
		update_post_meta($post->ID, self::REVIEWER, $reviewer);
		update_post_meta($post->ID, self::LOCATION, $location);
		update_post_meta($post->ID, self::RATING, $rating);
		update_post_meta($post->ID, self::BOOK, $book);
	}

	/**
	 * Gets the reviewer value from database.
	 * @return mixed
	 */
	public function getReviewer(){
		$post = get_post();
		return get_post_meta($post->ID, self::REVIEWER, true);
	}

	/**
	 * Gets the location value from database.
	 * @return mixed
	 */
	public function getLocation(){
		$post = get_post();
		return get_post_meta($post->ID, self::LOCATION, true);
	}

	/**
	 * Gets the rating value from database.
	 * @return mixed
	 */
	public function getRating(){
		$post = get_post();
		return get_post_meta($post->ID, self::RATING, true);
	}

	/**
	 * Gets the book value from database.
	 * @return mixed
	 */
    public function getBook(){
	    $post = get_post();
	    return get_post_meta($post->ID, self::BOOK, true);
    }

	/**
	 * Creates the review comment form with necessary fields.
	 *
	 * @return void
	 */
	function commentForm() {
		// get meta from the database
		$comment = $this->getComment();
		wp_editor($comment, self::COMMENT);
	}

	/**
	 * Gets, sanitizes, and saves the inputs to the database.
	 *
	 * @return void
	 */
	function saveComment() {
		// get values
		$comment = $_POST[self::COMMENT];

		// sanitize
		$comment = sanitize_text_field($comment);

		// put in database
		$post = get_post();
		update_post_meta($post->ID, self::COMMENT, $comment);
	}

	/**
	 * Gets the comment value from database.
	 * @return mixed
	 */
	public function getComment() {
		$post = get_post();
		return get_post_meta($post->ID, self::COMMENT, true);
	}
}