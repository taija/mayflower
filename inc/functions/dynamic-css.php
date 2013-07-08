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

/**
 * Enqueue Footer Nav Menu Styles
 *
 * If no menu is assigned to the nav-footer
 * Theme Location, then set the footer to
 * center-align content
 */
function mayflower_enqueue_footer_nav_menu_style() {
	if ( has_nav_menu( 'nav-footer' ) ) {
	?>
<style type="text/css">
#footer {
	text-align: left;
}
</style>
	<?php
	}
}
add_action( 'wp_print_styles', 'mayflower_enqueue_footer_nav_menu_style', 11 );


/**
 * Enqueue Skin Stylesheet
 *
 * @uses	mayflower_get_options()			Defined in functions/options.php
 * @uses	mayflower_get_color_scheme()	Defined in functions/custom.php
 * @uses	mayflower_locate_template_uri()	Defined in functions/custom.php
 */
/*
function mayflower_enqueue_skin_style() {

	// define skin stylesheet
	global $mayflower_options;
	$mayflower_options = mayflower_get_options();
	$color_scheme = mayflower_get_color_scheme();
	if ( 'cuvee' != $color_scheme ) {
		$fonts_stylesheet = mayflower_locate_template_uri( array( 'css/fonts.css' ), false, false );
		wp_enqueue_style( 'mayflower-fonts', $fonts_stylesheet );
		$scheme_handle = 'mayflower_' . $color_scheme . '_stylesheet';
		$scheme_stylesheet = mayflower_locate_template_uri( array( 'skins/' . $color_scheme . '.css' ), false, false );
		wp_enqueue_style( $scheme_handle, $scheme_stylesheet );
	}
	$skin_handle = 'mayflower_' . $mayflower_options['skin'] . '_stylesheet';
	$skin_stylesheet = mayflower_locate_template_uri( array( 'skins/' . $mayflower_options['skin'] . '.css' ), false, false );

	wp_enqueue_style( $skin_handle, $skin_stylesheet );
}
// Enqueue Skin Stylesheet at wp_print_styles
add_action('wp_enqueue_scripts', 'mayflower_enqueue_skin_style', 11 );
*/

/**
 * Enqueue Header Nav Menu Styles
 *
 * @uses	mayflower_get_options()			Defined in functions/options.php
 */

/*
function mayflower_enqueue_header_nav_menu_style() {
	global $mayflower_options;
	$mayflower_options = mayflower_get_options();
	$header_nav_menu_item_width = $mayflower_options['header_nav_menu_item_width'];
	if ( 'fluid' == $header_nav_menu_item_width ) {

	?>

<style type="text/css">
.nav-header li a,
.nav-header li a:link,
.nav-header li a:visited,
.nav-header li a:hover,
.nav-header li a:active {
     width: auto;
	 padding: 0px 10px;
}
#nav ul {
	width: auto;
}
#nav ul li a {
	width: auto;
	min-width: 100px;
}
#nav ul ul {
	width: auto;
}
</style>
	<?php
	}
}
add_action( 'wp_print_styles', 'mayflower_enqueue_header_nav_menu_style', 11 );
*/
?>