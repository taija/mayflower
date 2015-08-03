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
