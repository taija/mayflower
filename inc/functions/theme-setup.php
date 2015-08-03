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
 * @copyright	Copyright (c) 2011, Chip Bennett
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Mayflower 1.0
 */

/**
 * @todo	complete inline documentation
 */

/**
 * Define Theme setup
 *
 * Add Theme support for and configure various core WordPress
 * functionality, define the Theme's content width, etc.
 *
 * @link	http://codex.wordpress.org/Function_Reference/add_editor_style				add_editor_style()
 * @link	http://codex.wordpress.org/Function_Reference/add_image_size				add_image_size()
 * @link	http://codex.wordpress.org/Function_Reference/add_theme_support				add_theme_support()
 * @link	http://codex.wordpress.org/Function_Reference/apply_filters					apply_filters()
 * @link	http://codex.wordpress.org/Function_Reference/apply_filters					get_header_image()
 * @link	http://codex.wordpress.org/Function_Reference/get_header_textcolor			get_header_textcolor()
 * @link	http://codex.wordpress.org/Function_Reference/get_locale					get_locale()
 * @link	http://codex.wordpress.org/Function_Reference/get_option					get_option()
 * @link	http://codex.wordpress.org/Function_Reference/get_template_directory		get_template_directory()
 * @link	http://codex.wordpress.org/Function_Reference/get_template_directory_uri	get_template_directory_uri()
 * @link	http://codex.wordpress.org/Function_Reference/get_theme_root				get_theme_root()
 * @link	http://codex.wordpress.org/Function_Reference/is_readable					is_readable()
 * @link	http://codex.wordpress.org/Function_Reference/load_theme_textdomain			load_theme_textdomain()
 * @link	http://codex.wordpress.org/Function_Reference/register_default_headers		register_default_headers()
 * @link	http://codex.wordpress.org/Function_Reference/register_nav_menus			register_nav_menus()
 * @link	http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size		set_post_thumbnail_size()
 *
 * @link	http://php.net/manual/en/function.file-exists.php							PHP reference: file_exists()
 *
 * @uses	mayflower_admin_header_style()	Defined in \functions\theme-setup.php
 * @uses	mayflower_get_post_formats()		Defined in \functions\custom.php
 * @uses	mayflower_get_color_scheme()		Defined in \functions\dynamic-css.php
 * @uses	mayflower_header_style()			Defined in \functions\theme-setup.php
 */
function mayflower_setup() {

	/*
	 * Enable translation
	 *
	 * Declare Theme textdomain and define
	 * location for translation files.
	 *
	 * Translations can be added to the /languages
	 * directory.
	 *
	 * @since	Mayflower 2.2
	 */
	load_theme_textdomain( 'mayflower', get_template_directory() . '/languages' );

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
	 * Add Theme support for Post Thumbnails
	 *
	 * Allow users to specify "featured" images for Posts.
	 *
	 * Child Themes can remove support for this feature via
	 * remove_theme_support( 'post-thumbnails' ).
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

	/*
	 * Define Nav Menus (since WordPress 3.0)
	 */

	// This theme uses wp_nav_menu() in one locations: Top Navigation.
	register_nav_menus( array(
		'nav-top' => 'Top Navigation',
	) );


}
// Hook mayflower_setup() into 'after_setup_theme'
add_action( 'after_setup_theme', 'mayflower_setup', 10 );
