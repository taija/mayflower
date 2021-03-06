<?php
/**
 * Mayflower Theme WordPress Core Hooks
 *
 * Contains all of the Theme's functions that
 * hook into core action/filter hooks, other
 * than Theme Setup functions, Widget functions,
 * and Settings API functions
 *
 */

/**
 * Add parent class to wp_nav_menu parent list items
 *
 * Allows menu item to be targeted when on child page
 *
 */
function mayflower_add_menu_parent_class( $items ) {
	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'menu-item-parent';
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'mayflower_add_menu_parent_class' );


/**
 * Enqueue comment-reply script
 *
 * Action Hook: comment_form_before
 *
 * Enqueues the comment-reply script only
 * when appropriate; i.e. when the current
 * page template uses the comments template,
 * the current post has comments open, and
 * the site is configured to display threaded
 * comments.
 *
 * Since Oenology 2.6, this callback is hooked
 * into 'comment_form_before' instead of being
 * hooked into 'wp_enqueue_scripts'. Using the
 * 'comment_form_before' hook, which fires as
 * part of the comment_form() template tag
 * output, eliminates the need for the comments_open()
 * and is_singluar() conditional checks, since the
 * comment_form() template tag only outputs on
 * singular pages with comments open. Using the
 * 'comment_form_before' hook to call wp_enqueue_script()
 * requires WordPress 3.3, in order to perform
 * inline script enqueueing.
 *
 * @link	http://codex.wordpress.org/Function_Reference/get_option		Codex Reference: get_option()
 * @link	http://codex.wordpress.org/Function_Reference/wp_enqueue_script	Codex Reference: wp_enqueue_script()
 *
 * @since	Oenology 2.0
 */
function mayflower_enqueue_comment_reply() {
	// Enqueue the comment-reply script on
	//single blog post pages with comments
	// open and threaded comments
	if (
		// Returns the value for the specified option.
		// 'thread_comments' is a Boolean option where
		// comments are threaded if TRUE, and flat if
		// FALSE
		get_option( 'thread_comments' )
	) {
		// enqueue the javascript that performs
		//in-link comment reply fanciness
		wp_enqueue_script( 'comment-reply' );
	}
}
// Hook into comment_form_before
add_action( 'comment_form_before', 'mayflower_enqueue_comment_reply' );



/**
 * Filter Widget Title
 *
 * Filter Hook: widget_title
 *
 * Filter 'widget_title' to output
 * a non-breaking space (&nbsp;) if
 * no title is defined. This output
 * is necessary in order for the
 * custom $after_widget output, that
 * wraps the Widget content in a
 * show/hide container, to be rendered.
 *
 * @since	Oenology 2.6
 */
function mayflower_filter_widget_title( $title ) {
	if ( $title ) {
		return $title;
	} else {
		return '&nbsp';
	}
}
add_filter( 'widget_title', 'mayflower_filter_widget_title' );

/**
 * Output number of comments, excluding pings
 *
 * Filter Hook: get_comments_number
 *
 * Filter 'get_comments_number' to display correct
 * number of comments (count only comments, not
 * trackbacks/pingbacks)
 *
 * @link	http://codex.wordpress.org/Function_Reference/is_admin	Codex Reference: is_admin()
 * @link	http://codex.wordpress.org/Function_Reference/get_comments	Codex Reference: get_comments()
 * @link	http://codex.wordpress.org/Function_Reference/separate_comments	Codex Reference: separate_comments()
 * @link	http://php.net/manual/en/function.count.php	PHP Reference: count()
 *
 * @link	http://www.wpbeginner.com/wp-tutorials/display-the-most-accurate-comment-count-in-wordpress/ WPBeginner
 *
 * @since	Oenology 2.0
 */
function mayflower_comment_count( $count ) {
	// Only filter the comments number
	// in the front-end display
	if (
	// WordPress conditional that returns true if
	// the current page is in the WP-Admin back-end
	! is_admin()
	) {
		global $id;
		$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
		return count( $comments_by_type['comment'] );
	}
	// Otherwise, when in the WP-Admin
	// back end, don't filter comments
	// number
	else {
		return $count;
	}
}
// Hook custom comment number into 'get_comments_number'
add_filter('get_comments_number', 'mayflower_comment_count', 0);

/**
 * Output default Post Title if none is provided
 *
 * Filter Hook: the_title
 *
 * Filter 'the_title' to output '(Untitled)' if
 * no Post Title is provided
 *
 * @since	Oenology 2.0
 */
function mayflower_untitled_post( $title ) {
	if ( '' == $title ) {
		return apply_filters( 'mayflower_untitled_post_title', '<em>(' . __( 'Untitled', 'mayflower' ) . ')</em>' );
	} else {
		return $title;
	}
}
add_filter( 'the_title', 'mayflower_untitled_post', 10, 1 );

/**
 * Remove default gallery shortcode inline styles
 *
 * Filter Hook: use_default_gallery_style
 *
 * Return false for the 'use_default_gallery_style'
 * filter, so that WordPress does not output
 * <style> tags and code for galleries in the document
 * body.
 *
 * @since	Oenology 2.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );


/**
 * Add 'current_cat' class for single posts
 *
 * Filter Hook: wp_list_categories
 *
 * Filter 'wp_list_categories' to add a
 * "current-cat" CSS class declaration.
 *
 * @link	http://www.studiograsshopper.ch/code-snippets/dynamic-category-menu-highlighting-for-single-posts/ StudioGrasshopper
 *
 * @since	Oenology 2.0
 */
function mayflower_show_current_cat_on_single($output) {

	global $post;

	if( is_singular( 'post' ) ) {

		$categories = wp_get_post_categories( $post->ID );

		foreach( $categories as $catid ) {
			$cat = get_category($catid);
			// Find cat-item-ID in the string
			if( preg_match( '#cat-item-' . $cat->cat_ID . '#', $output ) ) {
				$output = str_replace( 'cat-item-' . $cat->cat_ID, 'cat-item-' . $cat->cat_ID . ' current-cat', $output );
			}
		}

	}
	return $output;
}
// Hook current_cat function into 'wp_list_categories'
add_filter('wp_list_categories', 'mayflower_show_current_cat_on_single');

/**
 * Output optimized document titles
 *
 * Filter Hook: wp_title
 *
 * Filter 'wp_title' to output contextual content
 *
 * @link	http://codex.wordpress.org/Function_Reference/get_bloginfo	Codex reference: get_bloginfo()
 * @link	http://codex.wordpress.org/Function_Reference/get_search_query	Codex reference: get_search_query()
 * @link	http://codex.wordpress.org/Function_Reference/is_feed	Codex reference: is_feed()
 * @link	http://codex.wordpress.org/Function_Reference/is_home	Codex reference: is_home()
 * @link	http://codex.wordpress.org/Function_Reference/is_front_page	Codex reference: is_front_page()
 * @link	http://codex.wordpress.org/Function_Reference/is_search	Codex reference: is_search()
 * @link	http://php.net/manual/en/function.max.php	PHP reference: max()
 * @link	http://php.net/manual/en/function.sprintf.php	PHP reference: sprintf()
 *
 * @since	Oenology 2.0
 */
function mayflower_filter_wp_title( $title, $separator ) { // taken from TwentyTen 1.0
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( 'Search results for %s', '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( 'Page %s', $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( 'Page %s', max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
// Hook into 'wp_title'
add_filter( 'wp_title', 'mayflower_filter_wp_title', 10, 2 );
