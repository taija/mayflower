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

$bc_globals_html_filepath      = $globals_path . "h/";
$bc_globals_lhead_filename     = 'lhead.html';
$bc_globals_bhead_filename     = 'bhead.html';
$bc_globals_bfoot_filename     = 'bfoot.html';
$bc_globals_legal_filename     = 'legal.html';
$bc_globals_galite_filename    = 'galite.html';
$bc_globals_gabranded_filename = 'gabranded.html';

/**
 * Add Globals 'lite' Header
 */
function bc_tophead(){
	global $bc_globals_html_filepath,
		$bc_globals_lhead_filename;

	$header_top =  $bc_globals_html_filepath . $bc_globals_lhead_filename;
	include_once($header_top);
}
add_action('mayflower_header','bc_tophead');

/**
 * Add Globals 'branded' Header
 */
function bc_tophead_big() {
	global $bc_globals_html_filepath,
		$bc_globals_bhead_filename;

	$header_top_big = $bc_globals_html_filepath . $bc_globals_bhead_filename;
	include_once($header_top_big);
}
add_action('mayflower_header','bc_tophead_big');


/**
 * Add Globals 'branded' Footer
 *
 * Function is pluggable for easy changes in child themes
 */
if ( ! function_exists ( 'bc_footer' ) ) {
	function bc_footer() {
		global $bc_globals_html_filepath,
			$bc_globals_bfoot_filename,
			$bc_globals_legal_filename;

		$bc_footer =  $bc_globals_html_filepath . $bc_globals_bfoot_filename;
		$bc_footerlegal =  $bc_globals_html_filepath . $bc_globals_legal_filename;
		include_once($bc_footer);
		include_once($bc_footerlegal);
	}
}
add_action('mayflower_footer', 'bc_footer', 50);

/**
 * Add Legal Footer
 */
function bc_footer_legal() {
	global $bc_globals_html_filepath,
		$bc_globals_legal_filename;

	$bc_footerlegal =  $bc_globals_html_filepath . $bc_globals_legal_filename;
	include_once($bc_footerlegal);
}
add_action('mayflower_footer', 'bc_footer_legal', 50);


/**
 * Add Google Analytics Scripts
 */
function mayflower_analytics () {
	global $bc_globals_html_filepath,
		$mayflower_brand,
		$bc_globals_galite_filename,
		$bc_globals_gabranded_filename;

	$bc_gacode_lite = $bc_globals_html_filepath . $bc_globals_galite_filename;
	$bc_gacode_branded =  $bc_globals_html_filepath . $bc_globals_gabranded_filename;

	if ( $mayflower_brand == 'lite' ) {
		include_once($bc_gacode_lite);
	} else {
		include_once($bc_gacode_branded);
	}

	$mayflower_options = mayflower_get_options();

	if ($mayflower_options['ga_code']) {
		// Format reference https://developers.google.com/analytics/devguides/collection/gajs/?hl=nl&csw=1#MultipleCommands
		?>
		<script type="text/javascript">
			/*Site-Specific GA code*/
			ga('create','<?php echo $mayflower_options['ga_code'] ?>','bellevuecollege.edu',{'name':'singlesite'});  //Multisite Tracking Code
			ga('singlesite.send','pageview');
		</script>
	<?php }

} // end function
add_action('wp_head', 'mayflower_analytics', 30);
