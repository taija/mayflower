<?php
/**
 * Mayflower Theme custom functions
 *
 * Contains all of the Theme's custom functions, which include
 * helper functions and various filters.
 *
 * @package 	Mayflower
 * @copyright	Copyright (c) 2010, Chip Bennett
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Mayflower 1.0
 */

/**
 * @todo	complete inline documentation
 */


/* Assign global_nav_selection to body_class */

function mayflower_body_class_ia( $classes ) {
	$mayflower_options = mayflower_get_options();

	// add ia_options to classes
	$classes[] = $mayflower_options['global_nav_selection'];

	// return the $classes array
	return $classes;
}
add_filter( 'body_class','mayflower_body_class_ia' );


/**
 * Determine Header Text Color Setting
 *
 * Determine what color value to pass to the
 * HEADER_TEXTCOLOR constant, based on whether a
 * dark or light color scheme is being displayed.
 */
function mayflower_get_header_textcolor() {

	$headertextcolor = ( get_header_textcolor() ? get_header_textcolor() : false );
	if ( ! $headertextcolor ) {
		$colorscheme = mayflower_get_color_scheme();

		if ( 'light' == $colorscheme ) {
			$headertextcolor = apply_filters( 'mayflower_light_color_scheme_header_textcolor', '666666' );
		} elseif ( 'dark' == $colorscheme ) {
			$headertextcolor = apply_filters( 'mayflower_light_color_scheme_header_textcolor', 'dddddd' );
		}
	}
	return $headertextcolor;
}


/**
 * Locate the directory URI for a template
 *
 * This function is essentially a rewrite of locate_template()
 * that searches for filepath and returns file directory. Useful for
 * child-theme overrides of parent Theme resources.
 */
function mayflower_locate_template_uri( $template_names, $load = false, $require_once = true ) {
	$located = '';
	foreach ( (array) $template_names as $template_name ) {
		if ( ! $template_name ) {
			continue;
		}
		if ( file_exists( get_stylesheet_directory() . '/' . $template_name ) ) {
			$located = get_stylesheet_directory_uri() . '/' . $template_name;
			break;
		} else if ( file_exists( get_template_directory() . '/' . $template_name ) ) {
			$located = get_template_directory_uri() . '/' . $template_name;
			break;
		}
	}

	if ( $load && '' != $located ) {
		load_template( $located, $require_once );
	}

	return $located;
}
