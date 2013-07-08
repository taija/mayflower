<?php
/**
 * Mayflower Theme Options
 *
 * This file defines the Options for the Mayflower Theme.
 *
 * Theme Options Functions
 *
 *  - Define Default Theme Options
 *  - Register/Initialize Theme Options
 *  - Define Admin Settings Page
 *  - Register Contextual Help
 *
 * @package 	Mayflower
 * @copyright	Copyright (c) 2011, Chip Bennett
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Mayflower 1.0
 */

/**
 * Globalize the variable that holds the Theme Options
 *
 * @global	array	$mayflower_options	holds Theme options
 */
global $mayflower_options;

/**
 * Mayflower Theme Settings API Implementation
 *
 * Implement the WordPress Settings API for the
 * Mayflower Theme Settings.
 *
 * @link	http://codex.wordpress.org/Settings_API	Codex Reference: Settings API
 * @link	http://ottopress.com/2009/wordpress-settings-api-tutorial/	Otto
 * @link	http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/	Ozh
 */
function mayflower_register_options(){
	require( get_template_directory() . '/inc/functions/options-register.php' );
}
// Settings API options initilization and validation
add_action( 'admin_init', 'mayflower_register_options' );

/**
 * Setup the Theme Admin Settings Page
 *
 * Add "Mayflower Options" link to the "Appearance" menu
 *
 * @uses	mayflower_get_settings_page_cap()	defined in \functions\wordpress-hooks.php
 */
function mayflower_add_theme_page() {
	// Globalize Theme options page
	global $mayflower_settings_page;
	// Add Theme options page
	$mayflower_settings_page = add_theme_page(
		// $page_title
		// Name displayed in HTML title tag
		__( 'Theme Options', 'mayflower' ),
		// $menu_title
		// Name displayed in the Admin Menu
		__( 'Theme Options', 'mayflower' ),
		// $capability
		// User capability required to access page
		mayflower_get_settings_page_cap(),
		// $menu_slug
		// String to append to URL after "themes.php"
		'mayflower-settings',
		// $callback
		// Function to define settings page markup
		'mayflower_admin_options_page'
	);
	// Load contextual help
	add_action( 'load-' . $mayflower_settings_page, 'mayflower_settings_page_contextual_help' );
}
// Load the Admin Options page
add_action( 'admin_menu', 'mayflower_add_theme_page' );

/**
 * Mayflower Theme Settings Page Markup
 *
 * @uses	mayflower_get_current_tab()	defined in \functions\custom.php
 * @uses	mayflower_get_page_tab_markup()	defined in \functions\custom.php
 */
function mayflower_admin_options_page() {
	// Determine the current page tab
	$currenttab = mayflower_get_current_tab();
	// Define the page section accordingly
	$settings_section = 'mayflower_' . $currenttab . '_tab';
	?>

	<div class="wrap">
		<?php mayflower_get_page_tab_markup(); ?>
		<?php if ( isset( $_GET['settings-updated'] ) ) {
			echo '<div class="updated"><p>';
				echo __( 'Theme settings updated successfully.', 'mayflower' );
				echo '</p></div>';
		} ?>
		<form action="options.php" method="post">
		<?php
			// Implement settings field security, nonces, etc.
			settings_fields('theme_mayflower_options');
			// Output each settings section, and each
			// Settings field in each section
			do_settings_sections( $settings_section );
		?>
			<?php submit_button( __( 'Save Settings', 'mayflower' ), 'primary', 'theme_mayflower_options[submit-' . $currenttab . ']', false ); ?>
			<?php submit_button( __( 'Reset Defaults', 'mayflower' ), 'secondary', 'theme_mayflower_options[reset-' . $currenttab . ']', false ); ?>
		</form>
	</div>
<?php
}

/**
 * Mayflower Theme Option Defaults
 *
 * Returns an associative array that holds
 * all of the default values for all Theme
 * options.
 *
 * @uses	mayflower_get_option_parameters()	defined in \functions\options.php
 *
 * @return	array	$defaults	associative array of option defaults
 */
function mayflower_get_option_defaults() {
	// Get the array that holds all
	// Theme option parameters
	$option_parameters = mayflower_get_option_parameters();
	// Initialize the array to hold
	// the default values for all
	// Theme options
	$option_defaults = array();
	// Loop through the option
	// parameters array
	foreach ( $option_parameters as $option_parameter ) {
		$name = $option_parameter['name'];
		// Add an associative array key
		// to the defaults array for each
		// option in the parameters array
		$option_defaults[$name] = $option_parameter['default'];
	}
	// Return the defaults array
	return apply_filters( 'mayflower_option_defaults', $option_defaults );
}

/**
 * Define default options tab
 */
function mayflower_define_default_options_tab( $options ) {
	$options['default_options_tab'] = 'general';
	return $options;
}
add_filter( 'mayflower_option_defaults', 'mayflower_define_default_options_tab' );

/**
 * Mayflower Theme Option Parameters
 *
 * Array that holds parameters for all options for
 * Mayflower. The 'type' key is used to generate
 * the proper form field markup and to sanitize
 * the user-input data properly. The 'tab' key
 * determines the Settings Page on which the
 * option appears, and the 'section' tab determines
 * the section of the Settings Page tab in which
 * the option appears.
 *
 * @return	array	$options	array of arrays of option parameters
 */
function mayflower_get_option_parameters() {

    $options = array(
        'mayflower_version' => array(
			'name' => 'mayflower_version',
			'title' => __( 'Mayflower Version', 'mayflower' ),
			'type' => 'select',
			'valid_options' => array(
				'official' => array(
					'name' => 'official',
					'title' => __( 'Official - Branded Version', 'mayflower' )
				),
				'department' => array(
					'name' => 'department',
					'title' => __( 'Department - Lite Version', 'mayflower' )
				)
			),
			'description' => __( 'Choose which version of the theme to enable for this site.', 'mayflower' ),
			'section' => 'version',
			'tab' => 'general',
			'since' => '1.0',
			'default' => 'department'
		),
        'global_nav_selection' => array(
			'name' => 'global_nav_selection',
			'title' => __( 'Global Nav Selection', 'mayflower' ),
			'type' => 'select',
			'valid_options' => array(
				'nav-home' => array(
					'name' => 'nav-home',
					'title' => __( 'Home', 'mayflower' )
				),
				'nav-programs' => array(
					'name' => 'nav-programs',
					'title' => __( 'Programs', 'mayflower' )
				),
				'nav-enrollment' => array(
					'name' => 'nav-enrollment',
					'title' => __( 'Enrollment', 'mayflower' )
				),
				'nav-resources' => array(
					'name' => 'nav-resources',
					'title' => __( 'Campus Resources', 'mayflower' )
				),
				'nav-about' => array(
					'name' => 'nav-about',
					'title' => __( 'About Us', 'mayflower' )
				)
			),
			'description' => __( 'Which global nav item should be associated with this site?', 'mayflower' ),
			'section' => 'version',
			'tab' => 'general',
			'since' => '1.0',
			'default' => 'nav-home'
		),
		'ga_code' => array(
			'name' => 'ga_code',
			'title' => __( 'Google Analytics Code', 'mayflower' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => __( 'GA Code', 'mayflower' ),
			'section' => 'analytics',
			'tab' => 'general',
			'since' => '1.0',
			'default' => ''
		),
		'staff_toggle' => array(
			'name' => 'staff_toggle',
			'title' => __( 'Turn on Staff feature?', 'mayflower' ),
			'type' => 'checkbox',
			'description' => __( 'Turn on Staff feature', 'mayflower' ),
			'section' => 'features',
			'tab' => 'general',
			'since' => '1.0',
			'default' => false
		),
        'staff_layout' => array(
			'name' => 'staff_layout',
			'title' => __( 'Staff Page Layout', 'mayflower' ),
			'type' => 'select',
			'valid_options' => array(
				'list-view' => array(
					'name' => 'list-view',
					'title' => __( 'List View', 'mayflower' )
				),
				'grid-view' => array(
					'name' => 'grid-view',
					'title' => __( 'Grid View', 'mayflower' )
				)
			),
			'description' => __( 'Which layout to use for the staff page template.', 'mayflower' ),
			'section' => 'features',
			'tab' => 'general',
			'since' => '1.0',
			'default' => 'list-view'
		),
		'slider_toggle' => array(
			'name' => 'slider_toggle',
			'title' => __( 'Enable Home Page Slider feature?', 'mayflower' ),
			'type' => 'checkbox',
			'description' => __( 'Turn on Slider feature', 'mayflower' ),
			'section' => 'slider',
			'tab' => 'home',
			'since' => '1.0',
			'default' => false
		),
		'slider_layout' => array(
			'name' => 'slider_layout',
			'title' => __( 'Slider Layout', 'mayflower' ),
			'type' => 'custom',
			'valid_options' => array(
				'featured-full' => array(
				  'name' => 'featured-full',
				  'title' => __( '100% width featured above', 'mayflower' ),
				  'description' => __( '', 'mayflower' ),
				  ),
				'featured-in-content' => array(
				  'name' => 'featured-in-content',
				  'title' => __( 'Featured inside content area ', 'mayflower' ),
				  'description' => __( '', 'mayflower' ),
				  ),
			),
			'description' => '',
			'section' => 'slider',
			'tab' => 'home',
			'since' => '1.0',
			'default' => 'featured-full'
		),
		'slider_title' => array(
			'name' => 'slider_title',
			'title' => __( 'Show title?', 'mayflower' ),
			'type' => 'checkbox',
			'description' => __( 'Show title in featured slide?', 'mayflower' ),
			'section' => 'slider',
			'tab' => 'home',
			'since' => '1.0',
			'default' => true
		),
		'slider_excerpt' => array(
			'name' => 'slider_excerpt',
			'title' => __( 'Show excerpt?', 'mayflower' ),
			'type' => 'checkbox',
			'description' => __( 'Show excerpt in featured slide?', 'mayflower' ),
			'section' => 'slider',
			'tab' => 'home',
			'since' => '1.0',
			'default' => true
		),

/*		'show_on_front' => array (
			'name' => 'show_on_front',
			'title' => '',
			'type' => 'custom',
			'description' => mayflower_show_on_front(),
			'section' => 'front_page_displays',
			'tab' => 'home',
			'since' => '1.0',
			'default' => '',
		),
*/
		/*
        'header_nav_menu_position' => array(
			'name' => 'header_nav_menu_position',
			'title' => __( 'Header Nav Menu Position', 'mayflower' ),
			'type' => 'select',
			'valid_options' => array(
				'above' => array(
					'name' => 'above',
					'title' => __( 'Above', 'mayflower' )
				),
				'below' => array(
					'name' => 'below',
					'title' => __( 'Below', 'mayflower' )
				),
				'none' => array(
					'name' => 'none',
					'title' => __( 'Do Not Display', 'mayflower' )
				)
			),
			'description' => __( 'Display header navigation menu above or below the site title/description?', 'mayflower' ),
			'section' => 'header',
			'tab' => 'general',
			'since' => '1.1',
			'default' => 'above'
		),
		'header_nav_menu_depth' => array(
			'name' => 'header_nav_menu_depth',
			'title' => __( 'Header Nav Menu Depth', 'mayflower' ),
			'type' => 'select',
			'valid_options' => array(
				'1' => array(
					'name' => 1,
					'title' => __( 'One', 'mayflower' )
				),
				'2' => array(
					'name' => 2,
					'title' => __( 'Two', 'mayflower' )
				),
				'3' => array(
					'name' => 3,
					'title' => __( 'Three', 'mayflower' )
				)
			),
			'description' => __( 'How many levels of Page hierarchy should the Header Navigation Menu display?', 'mayflower' ),
			'section' => 'header',
			'tab' => 'general',
			'since' => '1.1',
			'default' => 1
		),
        'header_nav_menu_item_width' => array(
			'name' => 'header_nav_menu_item_width',
			'title' => __( 'Header Nav Menu Item Width', 'mayflower' ),
			'type' => 'select',
			'valid_options' => array(
				'fixed' => array(
					'name' => 'fixed',
					'title' => __( 'Fixed', 'mayflower' )
				),
				'fluid' => array(
					'name' => 'fluid',
					'title' => __( 'Fluid', 'mayflower' )
				)
			),
			'description' => __( 'Should Header Nav Menu items have a fixed or fluid width?', 'mayflower' ),
			'section' => 'header',
			'tab' => 'general',
			'since' => '2.1',
			'default' => 'fluid'
		),
        'display_footer_credit' => array(
			'name' => 'display_footer_credit',
			'title' => __( 'Display Footer Credit', 'mayflower' ),
			'type' => 'select',
			'valid_options' => array(
				'false' => array(
					'name' => 'false',
					'title' => __( 'Do Not Display', 'mayflower' )
				),
				'true' => array(
					'name' => 'true',
					'title' => __( 'Display', 'mayflower' )
				)
			),
			'description' => __( 'Display a credit link in the footer? This option is disabled by default, and you are under no obligation whatsoever to enable it.', 'mayflower' ),
			'section' => 'footer',
			'tab' => 'general',
			'since' => '1.1',
			'default' => false
		),
*/
		'default_layout' => array(
			'name' => 'default_layout',
			'title' => __( 'Default Site Layout', 'mayflower' ),
			'type' => 'custom',
			'valid_options' => array(
				'sidebar-content' => array(
				  'name' => 'sidebar-content',
				  'title' => __( 'Sidebar left, Content right', 'mayflower' ),
				  'description' => __( '', 'mayflower' ),
				  ),
				'content-sidebar' => array(
				  'name' => 'content-sidebar',
				  'title' => __( 'Content Right, Sidebar Left', 'mayflower' ),
				  'description' => __( '', 'mayflower' ),
				  ),
				'content' => array(
				  'name' => 'content',
				  'title' => __( 'One column, no sidebar', 'mayflower' ),
				  'description' => __( '', 'mayflower' ),
				  ),
			),
			'description' => '',
			'section' => 'site_defaults',
			'tab' => 'general',
			'since' => '1.0',
			'default' => 'sidebar-content'
		),
		'skin' => array(
			'name' => 'skin',
			'title' => __( 'Color Scheme', 'mayflower' ),
			'type' => 'custom',
			'valid_options' => array(
				'default-color-scheme' => array(
				  'name' => 'default-color-scheme',
				  'title' => __( 'Default', 'mayflower' ),
				  'description' => __( 'Default color scheme.', 'mayflower' ),
				 'scheme' => 'light'
				  ),
				'aqua' => array(
				  'name' => 'aqua',
				  'title' => __( 'Aqua', 'mayflower' ),
				  'description' => __( 'Aqua is a shade of blue.', 'mayflower' ),
				 'scheme' => 'light'
				  ),
				'red' => array(
				  'name' => 'red',
				  'title' => __( 'Red', 'mayflower' ),
				  'description' => __( 'Red is a hot color.', 'mayflower' ),
				  'scheme' => 'light'
				  ),
			),
			'description' => '',
			'section' => 'site_defaults',
			'tab' => 'general',
			'since' => '1.0',
			'default' => 'default-color-scheme'
		),
		'blog_homepage_toggle' => array(
			'name' => 'blog_homepage_toggle',
			'title' => __( 'Enable blog posts on home page?', 'mayflower' ),
			'type' => 'checkbox',
			'description' => __( 'Enable blog posts on home page', 'mayflower' ),
			'section' => 'homepage_options',
			'tab' => 'home',
			'since' => '1.0',
			'default' => false
		),
        'blog_number_posts' => array(
			'name' => 'blog_number_posts',
			'title' => __( 'Number of blog posts?', 'mayflower' ),
			'type' => 'select',
			'valid_options' => array(
				'1' => array(
					'name' => '1',
					'title' => __( '1', 'mayflower' )
				),
				'2' => array(
					'name' => '2',
					'title' => __( '2', 'mayflower' )
				),
				'3' => array(
					'name' => '3',
					'title' => __( '3', 'mayflower' )
				),
				'4' => array(
					'name' => '4',
					'title' => __( '4', 'mayflower' )
				),
				'5' => array(
					'name' => '5',
					'title' => __( '5', 'mayflower' )
				),
				'6' => array(
					'name' => '6',
					'title' => __( '6', 'mayflower' )
				),
				'7' => array(
					'name' => '7',
					'title' => __( '7', 'mayflower' )
				),
				'8' => array(
					'name' => '8',
					'title' => __( '8', 'mayflower' )
				),
				'9' => array(
					'name' => '9',
					'title' => __( '9', 'mayflower' )
				),
				'10' => array(
					'name' => '10',
					'title' => __( '10', 'mayflower' )
				),
			),
			'description' => __( 'How many blog posts should appear on the home page?', 'mayflower' ),
			'section' => 'homepage_options',
			'tab' => 'home',
			'since' => '1.0',
			'default' => '5'
		),

    );
    return apply_filters( 'mayflower_get_option_parameters', $options );
}

/**
 * Get Mayflower Theme Options
 *
 * Array that holds all of the defined values
 * for Mayflower Theme options. If the user
 * has not specified a value for a given Theme
 * option, then the option's default value is
 * used instead.
 *
 * @uses	mayflower_get_option_defaults()	defined in \functions\options.php
 *
 * @uses	get_option()
 * @uses	wp_parse_args()
 *
 * @return	array	$mayflower_options	current values for all Theme options
 */
function mayflower_get_options() {
	// Get the option defaults
	$option_defaults = mayflower_get_option_defaults();
	// Globalize the variable that holds the Theme options
	global $mayflower_options;
	// Parse the stored options with the defaults
	$mayflower_options = wp_parse_args( get_option( 'theme_mayflower_options', array() ), $option_defaults );
	// Return the parsed array
	return $mayflower_options;
}

/**
 * Separate settings by tab
 *
 * Returns an array of tabs, each of
 * which is an indexed array of settings
 * included with the specified tab.
 *
 * @uses	mayflower_get_option_parameters()	defined in \functions\options.php
 * @uses	mayflower_get_settings_page_tabs()	defined in \functions\options.php
 *
 * @return	array	$settingsbytab	array of arrays of settings by tab
 */
function mayflower_get_settings_by_tab() {
	// Get the list of settings page tabs
	$tabs = mayflower_get_settings_page_tabs();
	// Initialize an array to hold
	// an indexed array of tabnames
	$settingsbytab = array();
	// Loop through the array of tabs
	foreach ( $tabs as $tab ) {
		$tabname = $tab['name'];
		// Add an indexed array key
		// to the settings-by-tab
		// array for each tab name
		$settingsbytab[] = $tabname;
	}
	// Get the array of option parameters
	$option_parameters = mayflower_get_option_parameters();
	// Loop through the option parameters
	// array
	foreach ( $option_parameters as $option_parameter ) {
		$optiontab = $option_parameter['tab'];
		$optionname = $option_parameter['name'];
		// Add an indexed array key to the
		// settings-by-tab array for each
		// setting associated with each tab
		$settingsbytab[$optiontab][] = $optionname;
		$settingsbytab['all'][] = $optionname;
	}
	// Return the settings-by-tab
	// array
	return $settingsbytab;
}

/**
 * Mayflower Theme Admin Settings Page Tabs
 *
 * Array that holds all of the tabs for the
 * Mayflower Theme Settings Page. Each tab
 * key holds an array that defines the
 * sections for each tab, including the
 * description text.
 *
 * @uses	mayflower_get_skin_text()	defined in \functions\options-register.php
 *
 * @return	array	$tabs	array of arrays of tab parameters
 */
function mayflower_get_settings_page_tabs() {

	$tabs = array(
        'general' => array(
			'name' => 'general',
			'title' => __( 'General', 'mayflower' ),
			'sections' => array(
				'version' => array(
					'name' => 'version',
					'title' => __( 'Mayflower Version', 'mayflower' ),
					'description' => __( 'Which version of Mayflower Theme should be used for this site?', 'mayflower' )
				),
				/*
				'global_nav' => array(
					'name' => 'global_nav',
					'title' => __( 'Global Nav Selection', 'mayflower' ),
					'description' => __( 'Which global nav item should be associated with this site?', 'mayflower' )
				),
				*/
				'analytics' => array(
					'name' => 'analytics',
					'title' => __( 'Site Specific Google Analytics', 'mayflower' ),
					'description' => __( 'Add your site specific GA code.', 'mayflower' )
				),
				'features' => array(
					'name' => 'features',
					'title' => __( 'Toggle theme functionality', 'mayflower' ),
					'description' => __( 'Turn theme functionality on or off.', 'mayflower' )
				),
				'site_defaults' => array(
					'name' => 'site_defaults',
					'title' => __( 'Site Defaults', 'mayflower' ),
					'description' => __( 'Manage default settings for this web site.', 'mayflower' )
				),
				/*
				'skin' => array(
					'name' => 'skin',
					'title' => __( 'Color Scheme', 'mayflower' ),
					'description' => mayflower_get_skin_text()
				),
				*/

			)
		),
        'home' => array(
			'name' => 'home',
			'title' => __( 'Home Page', 'mayflower' ),
			'sections' => array(
//				'default_homepage' => array(
//					'name' => 'default_homepage',
//					'title' => __( 'Default Home Page Layout', 'mayflower' ),
//					'description' => mayflower_get_homepage_text()
//				),
				'homepage_options' => array(
					'name' => 'homepage_options',
					'title' => __( 'Home Page Options', 'mayflower' ),
					'description' => __( 'Manage home page options', 'mayflower' )
				),
				'slider' => array(
					'name' => 'slider',
					'title' => __( 'Slider Options', 'mayflower' ),
					'description' => __( 'Manage home page slider options', 'mayflower' )
				),
				/*
				'front_page_displays' => array(
					'name' => 'front_page_displays',
					'title' => __( 'Front Page Displays:', 'mayflower' ),
					'description' => __( '', 'mayflower' )
				),
				*/
			)
		),
    );
	return apply_filters( 'mayflower_get_settings_page_tabs', $tabs );
}

/**
 * Add Section Text for the Skin Settings Section
 */
function mayflower_get_skin_text() {

	$mayflower_options = mayflower_get_options();
	$option_parameters = mayflower_get_option_parameters();
	$mayflower_skins = $option_parameters['skin']['valid_options'];
	foreach ( $mayflower_skins as $skin ) {
		if ( $skin['name'] == $mayflower_options['skin'] ) {
		      $mayflower_current_skin = $skin;
		}
	}
	$skin_thumbnail_url = mayflower_locate_template_uri( array( 'skins/' . $mayflower_options['skin'] . '.png' ), false, false );
	$text = '';
//	$text .= '<p>"Skin" refers to wine made from exclusively or predominantly one variety of grape. Each skin has unique flavor and aromatic characteristics. Refer to the contextual help screen for descriptions and help regarding each theme option.</p>';
//	$text .= '<img class="mayflower-skin-thumb" src="' . $skin_thumbnail_url . '" width="150px" height="110px" alt="' . $mayflower_options['skin'] . '" />';
//	$text .= '<h4>Current Skin</h4>';
//	$text .= '<dl><dt><strong>' . $mayflower_current_skin['title'] . '</strong></dt><dd>' . $mayflower_current_skin['description'] . '</dd></dl>';
	return $text;
}
?>