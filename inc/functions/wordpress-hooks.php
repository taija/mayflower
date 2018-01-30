<?php
/**
 * Mayflower Theme WordPress Core Hooks
 *
 * Contains all of the Theme's functions that
 * hook into core action/filter hooks, other
 * than Theme Setup functions, Plugin functions,
 * and Settings API functions
 *
 */

/**
 * Add parent class to wp_nav_menu parent list items
 *
 * Allows menu item to be targeted when on child page
 *
 */
add_filter( 'wp_nav_menu_objects', 'mayflower_add_menu_parent_class' );

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
// Hook into comment_form_before
add_action( 'comment_form_before', 'mayflower_enqueue_comment_reply' );

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
add_filter( 'widget_title', 'mayflower_filter_widget_title' );

function mayflower_filter_widget_title( $title ) {
	if ( $title ) {
		return $title;
	} else {
		return '&nbsp';
	}
}

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
add_filter( 'get_comments_number', 'mayflower_comment_count', 0 );

function mayflower_comment_count( $count ) {
	// Only filter the comments number
	// in the front-end display
	if ( ! is_admin() ) {
		global $id;
		$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
		return count( $comments_by_type['comment'] );
	} else {
		return $count;
	}
}
// Hook custom comment number into 'get_comments_number'

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
add_filter( 'the_title', 'mayflower_untitled_post', 10, 1 );

function mayflower_untitled_post( $title ) {
	if ( '' == $title ) {
		return apply_filters( 'mayflower_untitled_post_title', '<em>(' . __( 'Untitled', 'mayflower' ) . ')</em>' );
	} else {
		return $title;
	}
}

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

// Hook current_cat function into 'wp_list_categories'
add_filter( 'wp_list_categories', 'mayflower_show_current_cat_on_single' );

function mayflower_show_current_cat_on_single( $output ) {

	global $post;

	if ( is_singular( 'post' ) ) {

		$categories = wp_get_post_categories( $post->ID );

		foreach ( $categories as $catid ) {
			$cat = get_category( $catid );
			// Find cat-item-ID in the string
			if ( preg_match( '#cat-item-' . $cat->cat_ID . '#', $output ) ) {
				$output = str_replace( 'cat-item-' . $cat->cat_ID, 'cat-item-' . $cat->cat_ID . ' current-cat', $output );
			}
		}
	}
	return $output;
}


/**
 * Output optimized document titles
 *
 * Uses WordPress 4.1+ title framework
 *
 */
add_filter( 'document_title_parts', 'mayflower_document_title_parts', 10, 1 );
add_filter( 'document_title_separator', 'mayflower_document_title_separator', 10, 1 );


function mayflower_document_title_parts( $title_parts ) {
	global $post;

	if ( is_front_page() ) {
		$title_parts['tagline'] = '';
		$title_parts['site']    = __( 'Bellevue College' );
	}
	// Output custom title if available
	$post_meta_data = get_post_custom( $post->ID );
	if ( isset( $post_meta_data['_seo_custom_page_title'][0] ) ) {
		$title_parts['title']   = $post_meta_data['_seo_custom_page_title'][0];
		$title_parts['tagline'] = '';
		$title_parts['site']    = '';
	}
	return $title_parts;
}

function mayflower_document_title_separator( $mayflower_document_title_separator ) {
	return is_front_page() ? '@' : '::';
}


/**
 * Customize 'Read More' text on posts
 *
 */
add_filter( 'excerpt_more', 'mayflower_read_more_override' );

function mayflower_read_more_override( $more ) {
	return ' <a class="read-more" href="' . get_permalink() . '">' . __( '...more about ', 'mayflower' ) . get_the_title() . '</a>';
}


add_action( 'widgets_init', 'mayflower_remove_default_widgets' );

function mayflower_remove_default_widgets() {

	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_Pages' );
}

/**
 * Remove WP version number from head
 *
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Gutenberg Time!
 *
 * Add hooks for Gutenberg features
 *
 * Gutenberg beta plugin v2.0
 */

function mayflower_gutenberg_blacklist_blocks() {
	wp_enqueue_script(
		'mayflower-gutenberg-blacklist-blocks',
		get_template_directory_uri() . '/js/gutenberg.js',
		array( 'wp-blocks', 'wp-element' )
	);
}
add_action( 'enqueue_block_editor_assets', 'mayflower_gutenberg_blacklist_blocks' );

/**
 * Customize WordPress Visual Editor
 *
 * Add and change stylesheets and buttons in the
 * WP visual editor interface
 *
 */

/**
 * Add theme stylesheets to Visual editor
 */
add_action( 'init', 'mayflower_add_editor_styles' );

function mayflower_add_editor_styles() {
	global $globals_url, $globals_version;
	add_editor_style( array(
		$globals_url . 'c/g.css?=' . $globals_version,
		'style.css?=' . MAYFLOWER_STYLE_VERSION,
		'css/custom-editor-style.css',
	) );
}

/**
 * TinyMCE Changes
 */

/**
 * Show Kitchen Sink by default
 */
add_filter( 'tiny_mce_before_init', 'mayflower_unhide_kitchensink' );

function mayflower_unhide_kitchensink( $args ) {
	$args['wordpress_adv_hidden'] = false;
	return $args;
}

/**
 * Remove Address and H1 blocks from TinyMCE
 */
add_filter( 'tiny_mce_before_init', 'mayflower_tinymce_buttons_remove' );

function mayflower_tinymce_buttons_remove( $init ) {
	//remove address and h1
	$init['block_formats'] = 'Paragraph=p; Preformatted=pre; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6';
	return $init;
}

/**
 * Remove text color selector
 */
add_filter( 'mce_buttons_2','mayflower_tinymce_buttons' );

function mayflower_tinymce_buttons( $buttons ) {
	//Remove the text color selector
	$remove = array( 'forecolor' );

	return array_diff( $buttons, $remove );
}

/**
 * Formats dropdown menu with block styles
 */

/**
 * Add Formats dropdown menu
 */
add_filter( 'mce_buttons_2', 'mayflower_mce_buttons_2' );

function mayflower_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

/**
 * Add styles to the dropdown
 */
add_filter( 'tiny_mce_before_init', 'mayflower_mce_before_init' );

function mayflower_mce_before_init( $settings ) {

	$style_formats = array(
		array(
			'title' => 'Intro (.lead)',
			'block' => 'p',
			'classes' => 'lead',
			'wrapper' => false,
		),
		array(
			'title' => 'Alert (.alert-warning)',
			'block' => 'div',
			'classes' => 'alert alert-warning',
			'wrapper' => true,
		),
		array(
			'title' => 'Alert-Danger (.alert-danger)',
			'block' => 'div',
			'classes' => 'alert alert-danger',
			'wrapper' => true,
		),
		array(
			'title' => 'Alert-Info (.alert-info)',
			'block' => 'div',
			'classes' => 'alert alert-info',
			'wrapper' => true,
		),
		array(
			'title' => 'Alert-Success (.alert-success)',
			'block' => 'div',
			'classes' => 'alert alert-success',
			'wrapper' => true,
		),
		array(
			'title' => 'Well (.well)',
			'block' => 'div',
			'classes' => 'well',
			'wrapper' => true,
		),
	);
	$settings['style_formats'] = json_encode( $style_formats );
	return $settings;
}

/**
 * Assign global_nav_selection to body_class
 */
add_filter( 'body_class','mayflower_body_class_ia' );

if ( ! function_exists( 'mayflower_body_class_ia' ) ) {
	function mayflower_body_class_ia( $classes ) {
		$mayflower_options = mayflower_get_options();

		// add ia_options to classes
		$classes[] = $mayflower_options['global_nav_selection'];

		// return the $classes array
		return $classes;
	}
}

/**
 * Register sidebars / widget areas
 */

/**
 * Register Sidebar Hook
 *
 * Allow plugins and themes to register additional
 * sidebars via the mayflower_register_sidebar hook
 */
add_action( 'widgets_init', 'mayflower_register_sidebar' );

function mayflower_register_sidebar() {
	do_action( 'mayflower_register_sidebar' );
}


/**
 * Register Mayflower Sidebars
 *
 * Use hook to register mayflower sidebars
 */

/**
 * Top Global Widget Area - located just below the sidebar nav.
 */
add_action( 'mayflower_register_sidebar', 'mayflower_register_top_global_sidebar', 2 );

function mayflower_register_top_global_sidebar() {
	register_sidebar( array(
		'name' => __( 'Top Global Sidebar Widget Area', 'mayflower' ),
		'id' => 'top-global-widget-area',
		'description' => __( 'This is the top global widget area. Items will appear on all pages throughout the web site.', 'mayflower' ),
		'before_widget' => '<div class="wp-widget wp-widget-global %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title content-padding">',
		'after_title' => '</h2>',
	) );
}

/**
 * Static Page Widget Area - located just below the global nav on static pages.
 */
add_action( 'mayflower_register_sidebar', 'mayflower_register_static_sidebar', 4 );

function mayflower_register_static_sidebar() {
	register_sidebar( array(
		'name' => __( 'Static Page Sidebar Widget Area', 'mayflower' ),
		'id' => 'page-widget-area',
		'description' => __( 'This is the static page widget area. Items will appear on all static pages.', 'mayflower' ),
		'before_widget' => '<div class="wp-widget wp-widget-static %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title content-padding">',
		'after_title' => '</h2>',
	) );
}

/**
 * Blog Widget Area - located just below the global nav on blog pages.
 */
add_action( 'mayflower_register_sidebar', 'mayflower_register_blog_sidebar', 6 );

function mayflower_register_blog_sidebar() {
	register_sidebar( array(
		'name' => __( 'Blog Sidebar Widget Area', 'mayflower' ),
		'id' => 'blog-widget-area',
		'description' => __( 'This is the blog widget area. Items will appear on all blog related pages.', 'mayflower' ),
		'before_widget' => '<div class="wp-widget wp-widget-blog %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title content-padding">',
		'after_title' => '</h2>',
	) );
}

/**
 * Bottom Global Widget Area - located just below the sidebar nav.
 */
add_action( 'mayflower_register_sidebar', 'mayflower_register_bottom_global_sidebar', 8 );

function mayflower_register_bottom_global_sidebar() {
	register_sidebar( array(
		'name' => __( 'Bottom Global Sidebar Widget Area', 'mayflower' ),
		'id' => 'global-widget-area',
		'description' => __( 'This is the bottom global widget area. Items will appear on all pages throughout the web site.', 'mayflower' ),
		'before_widget' => '<div class="wp-widget wp-widget-global %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title content-padding">',
		'after_title' => '</h2>',
	) );
}


add_filter( 'widget_title', 'mayflower_widget_empty_title' );
function mayflower_widget_empty_title( $output = '' ) {
	if ( '&nbsp' == $output ) {
		return '';
	}
	return $output;
}


/**
 * Add meta tag to force IE to Edge mode in dashboard
 */
add_action( 'admin_head', 'mayflower_force_ie_edge_admin' );

function mayflower_force_ie_edge_admin() {
	echo '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
}

/**
 * Add 'active' class to active menu items
 */
add_filter( 'nav_menu_css_class' , 'mayflower_nav_active_class' , 10 , 2 );

function mayflower_nav_active_class( $classes, $item ) {
	if ( in_array( 'current-menu-item', $classes ) || preg_grep( '/^current-.*-ancestor$/i', $classes ) ) {
			$classes[] = 'active ';
	}

	//Apply active class on blog post parent
	if ( is_singular( 'post' ) ) {
		if ( in_array( 'current_page_parent', $classes ) ) {
			$classes[] = 'active ';
		}
	}

	//Apply 'active' style to any menu item with the added class of 'staff' to highlight staff parent
	if ( is_singular( 'staff' ) ) {
		if ( in_array( 'staff', $classes ) ) {
			$classes[] = 'active ';
		}
	}

	return $classes;
}

/**
 * Load Scripts and Styles
 */

/**
 * Async/Defer load - adapted from https://ikreativ.com/async-with-wordpress-enqueue/
 *
 * Allow insertion of async / defer tags to support loading outside scripts
 */
add_filter( 'clean_url', 'mayflower_defer_async_scripts', 11, 1 );

function mayflower_defer_async_scripts( $url ) {
	if ( strpos( $url, '#asyncload' ) ) {
		if ( is_admin() ) {
			return str_replace( '#asyncload', '', $url );
		} else {
			return str_replace( '#asyncload', '', $url ) . "' async='async";
		}
	} elseif ( strpos( $url, '#deferload' ) ) {
		if ( is_admin() ) {
			return str_replace( '#deferload', '', $url );
		} else {
			return str_replace( '#deferload', '', $url ) . "' defer='defer";
		}
	} elseif ( strpos( $url, '#asyncdeferload' ) ) {
		if ( is_admin() ) {
			return str_replace( '#asyncdeferload', '', $url );
		} else {
			return str_replace( '#asyncdeferload', '', $url ) . "' defer='defer' async='async";
		}
	} else {
		return $url;
	}
}


/**
 * Enqueue Mayflower scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'mayflower_scripts' );

function mayflower_scripts() {
	global $globals_url, $globals_version;
	wp_enqueue_style( 'globals', $globals_url . 'c/g.css', null, $globals_version, 'screen' );
	wp_enqueue_style( 'globals-print', $globals_url . 'c/p.css', null, $globals_version, 'print' );
	wp_enqueue_style( 'mayflower', get_stylesheet_uri(), null, MAYFLOWER_STYLE_VERSION );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'globals-head', $globals_url . 'j/ghead-full.min.js', array( 'jquery' ), $globals_version, false );
	wp_enqueue_script( 'globals', $globals_url . 'j/gfoot-full.min.js', array( 'jquery' ), $globals_version, true );
	wp_enqueue_script( 'menu', get_template_directory_uri() . '/js/menu.js#deferload', array( 'jquery' ), MAYFLOWER_STYLE_VERSION , true );

	wp_enqueue_script( 'youvisit', 'https://www.youvisit.com/tour/Embed/js2#asyncdeferload', null, null , true );

	if ( current_user_can( 'edit_posts' ) ) {
		wp_enqueue_script( 'a11y-warnings-js', get_template_directory_uri() . '/js/a11y-warnings.js#deferload', array( 'jquery' ), time(), true );
		wp_enqueue_style( 'a11y-warnings-css', get_template_directory_uri() . '/css/a11y-warnings.css', null, time() );
	}
}


/**
 * Enqueue Custom Admin Page Stylesheet
 */
add_action( 'admin_print_styles-appearance_page_mayflower-settings', 'mayflower_enqueue_admin_style', 11 );

function mayflower_enqueue_admin_style() {

	// define admin stylesheet
	$admin_handle = 'mayflower_admin_stylesheet';
	$admin_stylesheet = get_template_directory_uri() . '/css/mayflower-admin.css';

	wp_enqueue_style( $admin_handle, $admin_stylesheet, '', false );
}


/**
 * Enqueue Dashboard Stylesheet
 *
 * Used for Staff and Slider custom post types
 */
add_action( 'admin_enqueue_scripts', 'mayflower_dashboard_styles' );

function mayflower_dashboard_styles( $hook ) {
	$css_path = get_template_directory_uri() . '/css/dashboard.css';
	if ( 'edit.php?post_type=staff' != $hook ) {
		wp_register_style( 'mayflower_dashboard', $css_path );
		wp_enqueue_style( 'mayflower_dashboard' );
	}
}

/*
 *  Adding mayflower theme to have google analytics tracking for logged in users.
 */
add_action( 'admin_head', 'mayflower_google_analytics_dashboard' );

function mayflower_google_analytics_dashboard() {

	if ( is_user_logged_in() ) {

		$mayflower_globals_settings = get_option( 'globals_network_settings' );
		if ( is_multisite() ) {
			$mayflower_globals_settings = get_site_option( 'globals_network_settings' );
		}

		$globals_google_analytics_code = $mayflower_globals_settings['globals_google_analytics_code'];

		if ( $globals_google_analytics_code ) {
			?>
			<script type="text/javascript">
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
				ga('create', '<?php echo esc_attr( $globals_google_analytics_code ); ?>', 'bellevuecollege.edu', {'siteSpeedSampleRate': 100});
				ga('send', 'pageview');
			</script>
			<?php
		}
	}
}


/*
 * Add responsive classes to images
 */
add_filter( 'the_content','mayflower_bootstrap_responsive_images',10 );
add_filter( 'post_thumbnail_html', 'mayflower_bootstrap_responsive_images', 10 );

function mayflower_bootstrap_responsive_images( $html ) {
	$classes = 'img-responsive'; // separated by spaces, e.g. 'img image-link'

	// check if there are already classes assigned to the anchor
	if ( preg_match( '/<img.*? class="/', $html ) ) {
		$html = preg_replace( '/(<img.*? class=".*?)(".*?\/>)/', '$1 ' . $classes . ' $2', $html );
	} else {
		$html = preg_replace( '/(<img.*?)(\/>)/', '$1 class="' . $classes . '" $2', $html );
	}
	// remove dimensions from images,, does not need it!
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', '', $html );
	return $html;
}

/*
 * Add responsive classes to video embeds
 *
 */

add_filter( 'embed_oembed_html', 'mayflower_embed_oembed_html', 99, 4 );

function mayflower_embed_oembed_html( $html, $url, $attr, $post_id ) {
	return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}

/*
 * Alt Text Verification
 *
 * Taken from WP Accessibility Plugin https://wordpress.org/plugins/wp-accessibility/ Version 1.4.6
 */

// Add Checkbox to mark image as decorative
add_filter( 'attachment_fields_to_edit', 'wpa_insert_alt_verification', 10, 2 );

function wpa_insert_alt_verification( $form_fields, $post ) {
	$mime = get_post_mime_type( $post->ID );
	if ( $mime == 'image/jpeg' || $mime == 'image/png' || $mime == 'image/gif' ) {
		$no_alt = get_post_meta( $post->ID, '_no_alt', true );
		$alt = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
		$checked = checked( $no_alt, 1, false );
		$form_fields['no_alt'] = array(
			'label' => __( 'Decorative', 'mayflower' ),
			'input' => 'html',
			'value' => 1,
			'html'  => "<input name='attachments[$post->ID][no_alt]' id='attachments-$post->ID-no_alt' value='1' type='checkbox' aria-describedby='wpa_help' $checked /> <em class='help' id='wpa_help'>" . __( '<strong>Image is purely decorative.</strong> This will strip alt text from the image, and should not be used if image contributes to page content.', 'mayflower' ) . '</em>',
		);
	}
	return $form_fields;
}

add_filter( 'attachment_fields_to_save', 'wpa_save_alt_verification', 10, 2 );

function wpa_save_alt_verification( $post, $attachment ) {
	if ( isset( $attachment['no_alt'] ) ) {
		update_post_meta( $post['ID'], '_no_alt', 1 );
	} else {
		delete_post_meta( $post['ID'], '_no_alt' );
	}
	return $post;
}

add_filter( 'image_send_to_editor', 'wpa_alt_attribute', 10, 8 );

function wpa_alt_attribute( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
	/* Get data for the image attachment. */
	$noalt = get_post_meta( $id, '_no_alt', true );
	/* Get the original title to compare to alt */
	$title = get_the_title( $id );
	$warning = false;
	if ( $noalt == 1 ) {
		$html = str_replace( 'alt="' . $alt . '"', 'alt=""', $html );
	}
	if ( ( $alt == '' || $alt == $title ) && $noalt != 1 ) {
		if ( $alt == $title ) {
			$warning = __( 'The alt text for this image is the same as the title. Please review your alternate text to ensure it describes the image.', 'mayflower' );
			$image = 'alt-same.png';
		} else {
			$warning = __( 'This image requires alt text, but the alt text is currently blank. Either add alt text or mark the image as decorative.', 'mayflower' );
			$image = 'alt-missing.png';
		}
	}
	if ( $warning ) {
		return $html . "<img class='wpa-image-missing-alt size-" . esc_attr( $size ) . ' ' . esc_attr( $align ) . "' src='" . get_template_directory_uri() . "/img/$image" . "' alt='" . esc_attr( $warning ) . "' />";
	}
	return $html;
}



