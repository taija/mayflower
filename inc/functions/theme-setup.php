<?php
/**
 * Mayflower Theme Setup
 *
 * This file defines the setup functions for the Mayflower Theme.
 *
 * For more information on hooks, actions, and filters,
 * see {@link http://codex.wordpress.org/Plugin_API Plugin API}.
 *
 * @package 	Mayflower
 * @copyright	Copyright (c) 2015 Bellevue College
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Mayflower 1.0
 */



/**
 * Define Theme setup
 *
 * Add Theme support for and configure various core WordPress
 * functionality.
 *
 */

function mayflower_setup() {
	/*
	 * Add Theme support for Automatic Feed Links
	 *
	 * Automatically add RSS feed links to document header.
	 *
	 * Child Themes can remove support for this feature via
	 * remove_theme_support( 'automatic-feed-links' ).
	 *
	 * @since	WordPress 2.9.0
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Add Theme support for Post Thumbmails
	 *
	 * This feature enables Post Thumbnails support for a Theme.
	 *
	 *
	 * @since	WordPress 2.9.0
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Set default Post Thumbnail size
	 *
	 * Sets the dimensions for the default
	 * 'thumbnail' image size.
	 *
	 * Child Themes can override this setting
	 * via set_post_thumbnail_size().
	 */
	set_post_thumbnail_size( 150, 150, true );

	/**
	 * Add 'post-title-thumbnail' Image size
	 *
	 * Defines a new image size to the default array,
	 * which includes 'full', 'large', 'medium', and'
	 * 'thumbnail'.
	 *
	 * The 'post-title-thumbnail' image is defined
	 * as having dimensions of 55x55px, and will
	 * be hard-cropped rather than box-resized.
	 *
	 * Child Themes can override this setting
	 * via add_image_size().
	 */
	add_image_size( 'post-title-thumbnail', 55, 55, true );

	/**
	 * Add 'attachment-nav-thumbnail' Image size
	 *
	 * Defines a new image size to the default array,
	 * which includes 'full', 'large', 'medium', and'
	 * 'thumbnail'.
	 *
	 * The 'post-title-thumbnail' image is defined
	 * as having dimensions of 45x45px, and will
	 * be hard-cropped rather than box-resized.
	 *
	 * Child Themes can override this setting
	 * via add_image_size().
	 */
	add_image_size( 'attachment-nav-thumbnail', 45, 45, true );

	/**
	 * Add 'edit-screen-thumbnail' Image size
	 *
	 * Defines a new image size to the default array,
	 * which includes 'full', 'large', 'medium', and'
	 * 'thumbnail'.
	 *
	 * The 'edit-screen-thumbnail' image is defined
	 * as having dimensions of 100x100px, and will
	 * be hard-cropped rather than box-resized.
	 *
	 * Child Themes can override this setting
	 * via add_image_size().
	 */
	add_image_size( 'edit-screen-thumbnail', 100, 100, true );

	/**
	 * Add 'lite_header_logo' Image size
	 *
	 * Defines a new image size to the default array,
	 * which includes 'full', 'large', 'medium', and'
	 * 'thumbnail'.
	 *
	 * The 'lite_header_logo' is used as the logo size for
	 * Mayflower Lite.
	 *
	 * Child Themes can override this setting
	 * via add_image_size().
	 */
	add_image_size( 'lite_header_logo', 1170, 63, true);

	/**
	 * Add 'sort-screen-thumbnail' Image size
	 *
	 * Defines a new image size to the default array,
	 * which includes 'full', 'large', 'medium', and'
	 * 'thumbnail'.
	 *
	 * The 'sort-screen-thumbnail' is used on sort screens
	 *
	 * Child Themes can override this setting
	 * via add_image_size().
	 */
	add_image_size( 'sort-screen-thumbnail', 300, 125, true );

	/**
	 * Add 'staff-thumbnail' Image size
	 *
	 * Defines a new image size to the default array,
	 * which includes 'full', 'large', 'medium', and'
	 * 'thumbnail'.
	 *
	 * The 'staff-thumbnail' is used for staff page listings.
	 * This would need to be migrated out of Mayflower if
	 * the Embedded Staff Plugin was extracted.
	 *
	 * Child Themes can override this setting
	 * via add_image_size().
	 */
	add_image_size( 'staff-thumbnail', 300, 200, true );

	/**
	 * Add 'featured-full' Image size
	 *
	 * Defines a new image size to the default array,
	 * which includes 'full', 'large', 'medium', and'
	 * 'thumbnail'.
	 *
	 * The 'feaured-full' size is used for full-width
	 * display of the featured slider.
	 *
	 * Child Themes can override this setting
	 * via add_image_size().
	 */
	add_image_size( 'featured-full', 1170,488,true);

	/**
	 * Add 'featured-in-content' Image size
	 *
	 * Defines a new image size to the default array,
	 * which includes 'full', 'large', 'medium', and'
	 * 'thumbnail'.
	 *
	 * The 'feaured-in-content' size is used for in-content
	 * display of the featured slider.
	 *
	 * Child Themes can override this setting
	 * via add_image_size().
	 */
	add_image_size( 'featured-in-content', 900,375,true);

	/**
	 * Add 'home-small-ad' Image size
	 *
	 * Defines a new image size to the default array,
	 * which includes 'full', 'large', 'medium', and'
	 * 'thumbnail'.
	 *
	 * The 'home-small-ad' size is used for the
	 * small add on college homepage
	 *
	 * Child Themes can override this setting
	 * via add_image_size().
	 */
	add_image_size( 'home-small-ad', 300,200,true);

	/**
	 * Add theme support for HTML 5 Galleries
	 *
	 * Adds HTML5 style gallery markup
	 */
	add_theme_support( 'html5', array( 'gallery', 'caption' ) );

	/*
	 * Register Navigation Menu (Mayflower Lite)
	 *
	 * Registers one navigation menu for Top Nav
	 * in Mayflower Lite
	 *
	 * @since Wordpress 3.0
	 */
	register_nav_menus( array(
		'nav-top' => 'Top Navigation',
	));

	/**
	 * Add support for excerpts on pages
	 *
	 * Allows page to define excerpts to be used
	 * on navigation pages, etc.
	 *
	 */
	add_post_type_support( 'page', 'excerpt' );

	/**
	 * Add theme support for a custom header image
	 *
	 * Allows logo display in Mayflower Lite
	 *
	 */
	add_theme_support( 'custom-header', array(
		'default-image' => '',
		'width'         => 690,
		'height'        => 100,
		'flex-height'   => true,
		'header-text'   => false
	));

	/**
	 * Add support post formats
	 *
	 * Allows for support of the following formats
	 * * Video
	 *
	 */
	add_theme_support( 'post-formats', array( 'video' ) );

	/**
	 * Tabs Shortcode plugin Configuration
	 *
	 * Configures Tabs Shortcode plugin to use
	 * Bootstrap styles.
	 *
	 */
	add_theme_support( 'tabs', 'twitter-bootstrap' );

	/**
	 * Set maximum content width for theme
	 *
	 * Maximum width for insterted media.
	 *
	 */
	if ( ! isset( $content_width ) ) {
		$content_width = 1170;
	}

	/**
	 * Set Default Image Link to None
	 */
	update_option('image_default_link_type','none');

	/**
	 * Set Default Image Alignment to Left
	 */
	update_option( 'image_default_align', 'left' );

}

add_action( 'after_setup_theme', 'mayflower_setup', 10 );
