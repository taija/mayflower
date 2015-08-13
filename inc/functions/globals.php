<?php
/**
 * Set Up Globals Calls
 *
 * These files provide plugin-like functionality embedded within Mayflower.
 *
 */

/**
 * Set Up Globals Paths
 */
$network_mayflower_settings = get_site_option( 'globals_network_settings' );
$globals_path = $network_mayflower_settings['globals_path'];

if ( empty( $globals_path ) ) {
	$globals_path =  $_SERVER['DOCUMENT_ROOT'] . "/g/3/";
}

$bc_globals_html_filepath = $globals_path . "h/";
$bc_globals_lhead_filename = 'lhead.html';
$bc_globals_bhead_filename = 'bhead.html';
$bc_globals_bfoot_filename = 'bfoot.html';
$bc_globals_legal_filename = 'legal.html';

/**
 * Add Globals 'lite' Header
 */
function bc_tophead(){
	global $bc_globals_html_filepath;
	global $bc_globals_lhead_filename;

	$header_top =  $bc_globals_html_filepath . $bc_globals_lhead_filename;
	include_once($header_top);
}
add_action('mayflower_header','bc_tophead');

/**
 * Add Globals 'branded' Header
 */
function bc_tophead_big() {
	global $bc_globals_html_filepath;
	global $bc_globals_bhead_filename;

	$header_top_big = $bc_globals_html_filepath . $bc_globals_bhead_filename;
	include_once($header_top_big);
}
add_action('mayflower_header','bc_tophead_big');


/**
 * Add Globals 'branded' Footer
 */
function bc_footer() {
	global $bc_globals_html_filepath;
	global $bc_globals_bfoot_filename;
	global $bc_globals_legal_filename;

	$bc_footer =  $bc_globals_html_filepath . $bc_globals_bfoot_filename;
	$bc_footerlegal =  $bc_globals_html_filepath . $bc_globals_legal_filename;
	include_once($bc_footer);
	include_once($bc_footerlegal);
}
add_action('mayflower_footer', 'bc_footer', 50);

/**
 * Add Homepage Specific Footer
 */
function bc_home_footer() {
	global $bc_globals_html_filepath;
	global $bc_globals_bfoot_filename;
	global $bc_globals_legal_filename;

	$bc_footer =  $bc_globals_html_filepath . $bc_globals_bfoot_filename;
	$bc_footerlegal =  $bc_globals_html_filepath . $bc_globals_legal_filename;
	include_once($bc_footer);
	get_template_part( 'front-page-legal' );
	include_once($bc_footerlegal);
}
add_action('mayflower_footer', 'bc_home_footer', 50);

/**
 * Add Legal Footer
 */
function bc_footer_legal() {
	global $bc_globals_html_filepath;
	global $bc_globals_legal_filename;

	$bc_footerlegal =  $bc_globals_html_filepath . $bc_globals_legal_filename;
	include_once($bc_footerlegal);
}
add_action('mayflower_footer', 'bc_footer_legal', 50);
