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

function mayflower_body_class_ia($classes) {
		$mayflower_options = mayflower_get_options();


        // add ia_options to classes
        $classes[] = $mayflower_options['global_nav_selection'];

        // return the $classes array
        return $classes;
    }
add_filter('body_class','mayflower_body_class_ia');


/**
 * Determine Theme Color Scheme
 *
 * @uses	mayflower_get_options()				Defined in functions/options.php
 * @uses	mayflower_get_option_parameters()	Defined in functions/options.php
 */

function mayflower_get_color_scheme() {
	global $mayflower_options;
	$mayflower_options = mayflower_get_options();
	$default_options = mayflower_get_option_parameters();
	$mayflower_skins = $default_options['skin']['valid_options'];
	$mayflower_current_skin = array();
	foreach ( $mayflower_skins as $skin ) {
		if ( $skin['name'] == $mayflower_options['skin'] ) {
		      $mayflower_current_skin = $skin;
		}
	}
	$colorscheme = $mayflower_current_skin['scheme'];
	return $colorscheme;
}
/**
 * Get current settings page tab
 */
function mayflower_get_current_tab() {

	$page = 'mayflower-settings';
	if ( isset( $_GET['page'] ) && 'mayflower-reference' == $_GET['page'] ) {
		$page = 'mayflower-reference';
	}
    if ( isset( $_GET['tab'] ) ) {
        $current = $_GET['tab'];
    } else {
		$mayflower_options = mayflower_get_options();
		$current = $mayflower_options['default_options_tab'];
    }
	return apply_filters( 'mayflower_get_current_tab', $current );
}



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
 * Define Mayflower Admin Page Tab Markup
 *
 * @uses	mayflower_get_current_tab()	defined in \functions\options.php
 * @uses	mayflower_get_settings_page_tabs()	defined in \functions\options.php
 *
 * @link	http://www.onedesigns.com/tutorials/separate-multiple-theme-options-pages-using-tabs	Daniel Tara
 */
function mayflower_get_page_tab_markup() {

	$page = 'mayflower-settings';

    $current = mayflower_get_current_tab();

	$tabs = mayflower_get_settings_page_tabs();

    $links = array();

    foreach( $tabs as $tab ) {
		$tabname = $tab['name'];
		$tabtitle = $tab['title'];
        if ( $tabname == $current ) {
            $links[] = "<a class='nav-tab nav-tab-active' href='?page=$page&tab=$tabname'>$tabtitle</a>";
        } else {
            $links[] = "<a class='nav-tab' href='?page=$page&tab=$tabname'>$tabtitle</a>";
        }
    }

    echo '<div id="icon-themes" class="icon32"><br /></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach ( $links as $link )
        echo $link;
    echo '</h2>';

}


/**
 * Get WPORG Support Forum Feed
 *
 * @link 	http://codex.wordpress.org/Function_Reference/fetch_feed	fetch_feed()
 *
 * @return	HTML markup for feed list
 */
function mayflower_get_support_feed() {

	// Create transient key string. Used to ensure API data are
	// pinged only periodically. Different transient keys are
	// created for commits, open issues, and closed issues.
	$transient_key = 'mayflower_support_feed';

	// If cached (transient) data are used, output an HTML
	// comment indicating such
	$cached = get_transient( $transient_key );

	if ( false !== $cached ) {
		return $cached .= "\n" . '<!--Returned from transient cache.-->';
	}

	$markup = '';

	// Load feed functional file
	include_once( ABSPATH . WPINC . '/feed.php' );

	// Fetch the feed object
	$rss = fetch_feed( 'http://wordpress.org/support/rss/theme/mayflower' );

	// Error handling
	if ( ! is_wp_error( $rss ) ) {

		// Figure out how many total items there are, but limit it to 5.
		$maxitems = $rss->get_item_quantity( 15 );

		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items( 0, $maxitems );

		$markup .= '<table>';

			if ( $maxitems == 0 ) {
				$markup .= '<tr><td>' . __( 'No items', 'mayflower' ) . '</td></tr>';
			} else {
				$markup .= '<thead><tr><th>' . __( 'Topic', 'mayflower' ) . '</th><th>' . __( 'Posted', 'mayflower' ) . '</th></tr></thead><tbody>';
				// Loop through each feed item and display each item as a hyperlink.
				foreach ( $rss_items as $item ) {
					$markup .= '<tr>';
						$markup .= '<td style="padding:3px 5px;font-size:12px;">' . esc_html( $item->get_title() ) . '</td>';
						$markup .= '<td>';
							$markup .= '<a href="' . esc_url( $item->get_permalink() ) . '">';
								$markup .= human_time_diff( $item->get_date( 'U' ), current_time( 'timestamp' ) ) . ' ago';
							$markup .= '</a>';
						$markup .= '</td>';
					$markup .= '</tr>';
				}
			}

		$markup .= '</tbody></table>';

		// Set the transient (cache) for the API data
		set_transient( $transient_key, $markup, 60*60*24 );

	} else {
		$markup .= '<p>' . __( 'RSS feed error.', 'mayflower' ) . '</p>';
	}
	// Return markup
	return $markup;
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


/**
 * Return widget content opening div
 */
function mayflower_showhide_widget_content_open() {
	$options = mayflower_get_options();
    $showhide = '<span class="showhide">';
    $showhide .= 'Click to ';
    $showhide .= '<span style="color:#5588aa;" onclick="d=this.parentElement.nextElementSibling; d.style.display==\'none\' ? d.style.display=\'block\' : d.style.display=\'none\';">view/hide</span>';
    $showhide .= '<br /></span>';
    $showhide .= '<div class="widget-inner" style="display:' . $options['widget_display_default_state'] . ';">';

    return apply_filters( 'mayflower_showhide_widget_content_open', $showhide );
}

/**
 * Return widget content closing div
 */
function mayflower_showhide_widget_content_close() {
	return apply_filters( 'mayflower_showhide_widget_content_close', '</div>' );
}

/**
 * Display Social Icons
 */
function mayflower_social_icons() {
	global $mayflower_options;
	$mayflower_options = mayflower_get_options();
	?>
	<div class="sidebar-social-icons">
	<?php
	// Obtain the list of valid social networks
	$socialprofiles = mayflower_get_social_networks();
	// Loop through each social network
	foreach ( $socialprofiles as $profile ) {
		// holds the profile name for the currentsocial network
		$profilename = $profile['name'] . '_profile';
		// if the user has provided a profile name
		// for the current social network
		if ( ! empty( $mayflower_options[$profilename] ) ) {
			// holds the base URL for the current social network
			$baseurl = $profile['baseurl'];
			// build the full URL, including base URL and profile name
			$profileurl = $baseurl . '/' . $mayflower_options[$profilename];
			// Tumblr has to be different
			if ( 'tumblr' == $profile['name'] ) {
				$profileurl = 'http://' . $mayflower_options[$profilename] . '.' . $baseurl;
			}
			// Output the fully formed social network profile link
			?>
			<a class="sidebar-social-icon genericon" href="<?php echo $profileurl; ?>" title="<?php echo $profile['title']; ?>">
				<span class="genericon-<?php echo $profile['name']; ?>"></span>
			</a>
		<?php
		}
	}
	?>
	</div>
	<?php
}
