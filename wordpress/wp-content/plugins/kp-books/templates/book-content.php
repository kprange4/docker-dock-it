<?php

namespace KP\BookPlugin;

use WP_Query;

$settings = BookPluginSettings::getInstance();

// The Query.
$the_query = new WP_Query([
	'post_type' => ReviewPostType::POST_TYPE,
	'meta_key' => ReviewMeta::BOOK,
	'meta_value' => get_the_ID(),
	'orderby' => ReviewMeta::RATING,
	'order' => 'ASC',
]);

// The Loop.
if ( $the_query->have_posts() ) {
	$totalRating = 0;
	$averageRating = 0;
	$averageRatingContent = '';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$meta    = ReviewMeta::getInstance();
		$rating = $meta->getRating();
		$totalRating += $rating;
		$numReviews = $the_query->found_posts;
	}

	$averageRating = ceil($totalRating / $numReviews);

	$averageRatingContent = '<h5 class="card-title"><span>' . implode('', array_fill(0, $averageRating, '<i class="fa-solid fa-star"></i>')) .
	            implode('', array_fill(0, 5 - $averageRating, '<i class="fa-regular fa-star"></i>')) . '</span></h5>';
} else {
	$averageRatingContent = '';
}
// Restore original Post Data.
wp_reset_postdata();

$post = get_post();
$meta          = BookMeta::getInstance();
$publisher     = $meta->getPublisher();
$publishedDate = wp_date( get_option( 'date_format' ), strtotime($meta->getPublishedDate()) );
$pageCount     = $meta->getPageCount();
$price         = number_format(floatval($meta->getPrice()), 2);
$description   = $meta->getDescription();
$genres = get_the_terms($post->ID, 'book_genre');
	foreach ( $genres as $genre ) {
		$genreName = $genre->name;
	}

$content = '<div class="book-content-wrapper row mb-4">
				<div class="col-md-3">' . get_the_post_thumbnail()  . '</div>
				<div class="description col-md-8">
					<span>' . $publishedDate . ' | ' . $genreName . '</span>
					<h1 class="mt-3">' . esc_html( get_the_title() ) . '</h1>
					<p>' . $averageRatingContent . '</p>
					<h5>' . $publisher . '</h5>
					<p>' . $description . '</p>
					<p>' . $pageCount . ' pages</p>
					<hr>
					<h4>$' . $price . '</h4>
				</div>
			</div>';

$content .=	'<div class="row">
				<h3>Reviews</h3>';

// The Loop.
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$meta    = ReviewMeta::getInstance();
		$reviewer = $meta->getReviewer();
		$location = $meta->getLocation();
		$rating = $meta->getRating();
		$comment = $meta->getComment();

		$content .= '
					<div class="card mb-4">
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
	$content .= '<p>No reviews yet!</p>';

	return $content;
}
// Restore original Post Data.
wp_reset_postdata();