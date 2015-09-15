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
        'mayflower_brand' => array(
			'name' => 'mayflower_brand',
			'title' => __( 'Mayflower Brand', 'mayflower' ),
			'type' => 'select',
			'valid_options' => array(
				'official' => array(
					'name' => 'branded',
					'title' => __( 'Branded: Main college branding', 'mayflower' )
				),
				'department' => array(
					'name' => 'lite',
					'title' => __( 'Lite - Department branding', 'mayflower' )
				)
			),
			'description' => __( 'Choose which version of the theme to enable for this site.', 'mayflower' ),
			'section' => 'version',
			'tab' => 'general',
			'since' => '1.0',
			'default' => 'lite'
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
				'nav-classes' => array(
					'name' => 'nav-classes',
					'title' => __( 'Classes', 'mayflower' )
				),
				'nav-programs' => array(
					'name' => 'nav-programs',
					'title' => __( 'Programs of Study', 'mayflower' )
				),
				'nav-enrollment' => array(
					'name' => 'nav-enrollment',
					'title' => __( 'Enrollment', 'mayflower' )
				),
				'nav-services' => array(
					'name' => 'nav-services',
					'title' => __( 'Services', 'mayflower' )
				),
				'nav-campuslife' => array(
					'name' => 'nav-campuslife',
					'title' => __( 'Campus Life', 'mayflower' )
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
        'slider_number_slides' => array(
			'name' => 'slider_number_slides',
			'title' => __( 'Number of slides?', 'mayflower' ),
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
				'11' => array(
					'name' => '11',
					'title' => __( '11', 'mayflower' )
				),
				'12' => array(
					'name' => '12',
					'title' => __( '12', 'mayflower' )
				),
				'13' => array(
					'name' => '13',
					'title' => __( '13', 'mayflower' )
				),
			),
			'description' => __( 'How many featured slides should we show?', 'mayflower' ),
			'section' => 'slider',
			'tab' => 'home',
			'since' => '1.0',
			'default' => '5'
		),
		

        'slider_order' => array(
			'name' => 'slider_order',
			'title' => __( 'Slide Order', 'mayflower' ),
			'type' => 'select',
			'valid_options' => array(
				'menu_order' => array(
					'name' => 'menu_order',
					'title' => __( 'Sort Order', 'mayflower' )
				),
				'rand' => array(
					'name' => 'rand',
					'title' => __( 'Random', 'mayflower' )
				),

			),
			'description' => __( 'How should we sort the slides?', 'mayflower' ),
			'section' => 'slider',
			'tab' => 'home',
			'since' => '1.0',
			'default' => 'menu_order'
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
				  'title' => __( 'Sidebar Right, Content Left', 'mayflower' ),
				  'description' => __( '', 'mayflower' ),
				  ),
			),
			'description' => '',
			'section' => 'site_defaults',
			'tab' => 'general',
			'since' => '1.3.3',
			'default' => 'sidebar-content'
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

		'facebook' => array(
			'name' => 'facebook',
			'title' => __( 'Facebook URL', 'mayflower' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => __( 'ex: http://facebook.com/bellevuecollege', 'mayflower' ),
			'section' => 'social_links',
			'tab' => 'social',
			'since' => '1.4',
			'default' => ''
		),
		'twitter' => array(
			'name' => 'twitter',
			'title' => __( 'Twitter URL', 'mayflower' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => __( 'ex: https://twitter.com/BellevueCollege', 'mayflower' ),
			'section' => 'social_links',
			'tab' => 'social',
			'since' => '1.4',
			'default' => ''
		),
		'flickr' => array(
			'name' => 'flickr',
			'title' => __( 'Flickr URL', 'mayflower' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => __( 'ex: http://www.flickr.com/people/bellevuecollege/', 'mayflower' ),
			'section' => 'social_links',
			'tab' => 'social',
			'since' => '1.4',
			'default' => ''
		),
		'linkedin' => array(
			'name' => 'linkedin',
			'title' => __( 'Linkedin URL', 'mayflower' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => __( 'ex: http://www.linkedin.com/company/bellevue-college', 'mayflower' ),
			'section' => 'social_links',
			'tab' => 'social',
			'since' => '1.4',
			'default' => ''
		),
		'youtube' => array(
			'name' => 'youtube',
			'title' => __( 'Youtube URL', 'mayflower' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => __( 'ex: http://www.youtube.com/user/BellevueCollege', 'mayflower' ),
			'section' => 'social_links',
			'tab' => 'social',
			'since' => '1.4',
			'default' => ''
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
					'title' => __( 'Mayflower Branding', 'mayflower' ),
					'description' => __( 'Which branding of Mayflower Theme should be used for this site?', 'mayflower' )
				),
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
					'description' => __( 'Manage default layout options for this web site. <br /><br /><em>*Note that if sidebar widget area are empty there will be no sidebar and the page content will fill the whole content area.</em> ', 'mayflower' )
				),

			)
		),
        'home' => array(
			'name' => 'home',
			'title' => __( 'Home Page', 'mayflower' ),
			'sections' => array(
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
			)
		),

      'social' => array(
			'name' => 'social',
			'title' => __( 'Social Media', 'mayflower' ),
			'sections' => array(
				'social_links' => array(
					'name' => 'social_links',
					'title' => __( 'Social Media', 'mayflower' ),
					'description' => __( 'Manage social media sites', 'mayflower' )
				),
			)
		),

    );
	return apply_filters( 'mayflower_get_settings_page_tabs', $tabs );
}
