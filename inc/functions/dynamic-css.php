<?php
/**
 * Oenology Dynamic Styles and Scripts
 *
 * This file defines the dynamic styles and
 * scripts that are output in the front and
 * back end.
 *
 * @package 	Oenology
 * @copyright	Copyright (c) 2011, Chip Bennett
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Oenology 2.3
 */


/**
 * Enqueue Custom Admin Page Stylesheet
 */
function mayflower_enqueue_admin_style() {

	// define admin stylesheet
	$admin_handle = 'mayflower_admin_stylesheet';
	$admin_stylesheet = get_template_directory_uri() . '/css/mayflower-admin.css';

	wp_enqueue_style( $admin_handle, $admin_stylesheet, '', false );
}
// Enqueue Admin Stylesheet at admin_print_styles()
add_action( 'admin_print_styles-appearance_page_mayflower-settings', 'mayflower_enqueue_admin_style', 11 );

/**
 * Enqueue #content img max-width
 *
 * Set the max-width CSS property for
 * images inside div#content, based on
 * the $content_width global variable.
 */
function mayflower_enqueue_content_img_max_width() {
	global $content_width;
?>
<style type="text/css">
.post-entry img,
.post-entry .wp-caption {
	max-width: <?php echo $content_width; ?>px;
}
</style>
<?php
}
// Enqueue Skin Stylesheet at wp_print_styles
add_action( 'wp_print_styles', 'mayflower_enqueue_content_img_max_width', 11 );
