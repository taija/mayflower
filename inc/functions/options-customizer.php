<?php
/**
 * Mayflower Options (Customizer Implimentation)
 *
 * This file builds out all settings within the Theme Customizer
 *
 */

/*
 * Class to add additional headings/info to the Customizer
 *
 * From http://coreymckrill.com/blog/2014/01/09/adding-arbitrary-html-to-a-wordpress-theme-customizer-section/
 */
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Mayflower_Customize_Misc_Control' ) ) :
class Mayflower_Customize_Misc_Control extends WP_Customize_Control {
	public $settings = 'blogname';
	public $description = '';

	public function render_content() {
		switch ( $this->type ) {
			default:
			case 'text' :
				echo '<p class="description">' . $this->description . '</p>';
				break;

			case 'heading':
				echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
				break;

			case 'line' :
				echo '<hr />';
				break;
		}
	}
}
endif;

/**
 * Array of default values
 *
 * WordPress does not pass out default values
 * for settings that have not been configured.
 */

$mayflower_theme_option_defaults = array(
	'mayflower_brand' => 'lite',
	'global_nav_selection' => 'nav-home',
	'ga_code' => '',
	'default_layout' => 'sidebar-content',
	'staff_toggle' => false,
	'staff_layout' => 'list-view',
	'slider_toggle' => false,
	'slider_layout' => 'featured-in-content',
	'slider_number_slides' => '5',
	'slider_title' => true,
	'slider_excerpt' => true,
	'slider_order' => 'menu_order',
	'blog_homepage_toggle' => true,
	'blog_number_posts' => '5',
	'facebook' => '',
	'twitter' => '',
	'flickr' => '',
	'linkedin' => '',
	'youtube' => '',
);

/**
 * Pass panels, settings, and controls into customizer
 *
 * WordPress does not pass out default values
 * for settings that have not been configured.
 */
function mayflower_register_theme_customizer( $wp_customize ) {
	global $mayflower_theme_option_defaults;
	/**
	 * Create panels and sections
	 *
	 */
	$wp_customize->add_panel( 'mayflower', array(
		'title' => __( 'Mayflower Theme' ),
		'description' => __( "<p>These settings center around the Bellevue College 'Mayflower' theme.</p>", 'mayflower' ),
		'priority' => 160, // Mixed with top-level-section hierarchy.
	) );
	$wp_customize->add_section( 'mayflower_home' , array(
		'title'      => __('Home Page Settings','mayflower'),
		'panel'     => 'mayflower',
		'priority'   => 31,
	) );
	$wp_customize->add_section( 'mayflower_general' , array(
		'title'      => __('General Settings','mayflower'),
		'panel'     => 'mayflower',
		'priority'   => 30,
	) );
	$wp_customize->add_section( 'mayflower_social' , array(
		'title'      => __('Social Media Settings','mayflower'),
		'panel'     => 'mayflower',
		'description' => __( 'To display icons for social media sites, paste in URLs to your page on each platform in the spaces provided. If you leave one empty, it will not display. <strong>Only applies to Mayflower Lite branding.</strong>', 'mayflower' ),
		'priority'   => 32,
	) );

	/**
	 * Customizer Settings and Controls
	 */

	/**
	 * General Settings
	 */
	$wp_customize->add_setting( 'theme_mayflower_options[mayflower_brand]' , array(
		'type'              => 'option',
		'capability'        => 'unfiltered_html', //Targeted for super admins only
		'default'           => $mayflower_theme_option_defaults['mayflower_brand'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[global_nav_selection]' , array(
		'type'              => 'option',
		'capability'        => 'unfiltered_html', //Targeted for super admins only
		'default'           => $mayflower_theme_option_defaults['global_nav_selection'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[ga_code]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['ga_code'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[default_layout]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['default_layout'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[staff_toggle]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['staff_toggle'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[staff_layout]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['staff_layout'],
	) );
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'mayflower_brand',
			array(
				'label'          => __( 'Mayflower Branding', 'mayflower' ),
				'description'    => __( 'Which branding of Mayflower Theme should be used for this site?', 'mayflower' ),
				'section'        => 'mayflower_general',
				'settings'       => 'theme_mayflower_options[mayflower_brand]',
				'type'           => 'radio',
				'choices'        => array(
					'branded'   => __( 'Branded: Main college branding', 'mayflower' ),
					'lite'      => __( 'Lite - Department branding', 'mayflower' ),
				)
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'global_nav_selection',
			array(
				'label'          => __( 'Global Nav Selection', 'mayflower' ),
				'description'    => __( 'If <strong>branded</strong>, select which website area this site appears under', 'mayflower' ),
				'section'        => 'mayflower_general',
				'settings'       => 'theme_mayflower_options[global_nav_selection]',
				'type'           => 'select',
				'choices'        => array(
					'nav-home'       => __( 'Home', 'mayflower' ),
					'nav-classes'    => __( 'Classes', 'mayflower' ),
					'nav-programs'   => __( 'Programs of Study', 'mayflower' ),
					'nav-enrollment' => __( 'Enrollment', 'mayflower' ),
					'nav-services'   => __( 'Services', 'mayflower' ),
					'nav-campuslife' => __( 'Campus Life', 'mayflower' ),
					'nav-about'      => __( 'About Us', 'mayflower' ),
				)
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'ga_code',
			array(
				'label'          => __( 'Google Analytics Tracking ID', 'mayflower' ),
				'description'    => __( 'Should start with UA-[...]', 'mayflower' ),
				'section'        => 'mayflower_general',
				'settings'       => 'theme_mayflower_options[ga_code]',
				'type'           => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'default_layout',
			array(
				'label'          => __( 'Site Layout', 'mayflower' ),
				'section'        => 'mayflower_general',
				'settings'       => 'theme_mayflower_options[default_layout]',
				'type'           => 'radio',
				'choices'        => array(
					'sidebar-content'  => __( 'Sidebar left, Content right', 'mayflower' ),
					'content-sidebar'  => __( 'Sidebar right, Content left', 'mayflower' ),
				)
			)
		)
	);
	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
		$wp_customize,
			'mayflower_staff-heading',
			array(
				'section'      => 'mayflower_general',
				'label'        => __( 'Staff Section', 'mayflower' ),
				'type'         => 'heading',
			)
		)
	);
	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
		$wp_customize,
			'mayflower_staff-desc',
			array(
				'section'      => 'mayflower_general',
				'description'  => __( 'Turn on a new Staff area of the dashboard to enter employee listings', 'mayflower' ),
				'type'         => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'staff_toggle',
			array(
				'label'          => __( 'Turn on Staff feature?', 'mayflower' ),
				'section'        => 'mayflower_general',
				'settings'       => 'theme_mayflower_options[staff_toggle]',
				'type'           => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'staff_layout',
			array(
				'label'          => __( 'Staff Layout', 'mayflower' ),
				'section'        => 'mayflower_general',
				'settings'       => 'theme_mayflower_options[staff_layout]',
				'type'           => 'radio',
				'choices'        => array(
					'list-view'  => __( 'List View', 'mayflower' ),
					'grid-view'  => __( 'Grid View', 'mayflower' ),
				)
			)
		)
	);



	/*
	 * Home Page Settings
	 */
	$wp_customize->add_setting( 'theme_mayflower_options[slider_toggle]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['slider_toggle'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[slider_layout]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['slider_layout'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[slider_number_slides]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['slider_number_slides'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[slider_title]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['slider_title'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[slider_excerpt]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['slider_excerpt'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[slider_order]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['slider_order'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[blog_homepage_toggle]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['blog_homepage_toggle'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[blog_number_posts]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['blog_number_posts'],
	) );
	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
		$wp_customize,
			'mayflower_slider-heading',
			array(
				'section'      => 'mayflower_home',
				'label'        => __( 'Home Page Slider', 'mayflower' ),
				'type'         => 'heading',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'slider_toggle',
			array(
				'label'          => __( 'Enable Home Page Slider feature?', 'mayflower' ),
				'section'        => 'mayflower_home',
				'settings'       => 'theme_mayflower_options[slider_toggle]',
				'type'           => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'slider_layout',
			array(
				'label'          => __( 'Slider Layout', 'mayflower' ),
				'section'        => 'mayflower_home',
				'settings'       => 'theme_mayflower_options[slider_layout]',
				'type'           => 'radio',
				'choices'        => array(
					'featured-full'       => __( '100% width, featured above content', 'mayflower' ),
					'featured-in-content' => __( 'Featured inside content area', 'mayflower' ),
				)
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'slider_number_slides',
			array(
				'label'          => __( 'How many slides should we show?', 'mayflower' ),
				'section'        => 'mayflower_home',
				'settings'       => 'theme_mayflower_options[slider_number_slides]',
				'type'           => 'select',
				'choices'        => array(
					'1'       => __( '1', 'mayflower' ),
					'2'       => __( '2', 'mayflower' ),
					'3'       => __( '3', 'mayflower' ),
					'4'       => __( '4', 'mayflower' ),
					'5'       => __( '5', 'mayflower' ),
					'6'       => __( '6', 'mayflower' ),
					'7'       => __( '7', 'mayflower' ),
					'8'       => __( '8', 'mayflower' ),
					'9'       => __( '9', 'mayflower' ),
					'10'      => __( '10', 'mayflower' ),
					'11'      => __( '11', 'mayflower' ),
					'12'      => __( '12', 'mayflower' ),
					'13'      => __( '13', 'mayflower' ),
				)
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'slider_title',
			array(
				'label'          => __( 'Show slider title?', 'mayflower' ),
				'section'        => 'mayflower_home',
				'settings'       => 'theme_mayflower_options[slider_title]',
				'type'           => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'slider_excerpt',
			array(
				'label'          => __( 'Show slider excerpt?', 'mayflower' ),
				'section'        => 'mayflower_home',
				'settings'       => 'theme_mayflower_options[slider_excerpt]',
				'type'           => 'checkbox',
			)
		)
	);
	/* The slider order functionality is not implimented.
	 * Control has been commented to avoid confusion.

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'slider_order',
			array(
				'label'          => __( 'Slide Order', 'mayflower' ),
				'section'        => 'mayflower_home',
				'settings'       => 'theme_mayflower_options[slider_order]',
				'type'           => 'radio',
				'choices'        => array(
					'menu_order'       => __( 'Sort Order (as set)', 'mayflower' ),
					'rand' => __( 'Randomized', 'mayflower' ),
				)
			)
		)
	); */
	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
		$wp_customize,
			'mayflower_blog-line',
			array(
				'section'      => 'mayflower_home',
				'type'         => 'line',
			)
		)
	);
	$wp_customize->add_control(
		new Mayflower_Customize_Misc_Control(
		$wp_customize,
			'mayflower_blog-heading',
			array(
				'section'      => 'mayflower_home',
				'label'        => __( 'Blog Posts on Home Page', 'mayflower' ),
				'type'         => 'heading',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'blog_homepage_toggle',
			array(
				'label'          => __( 'Enable blog posts on home page?', 'mayflower' ),
				'description'    => __( 'Show recent blog posts below home page content. Only applies if homepage it set to a static page.', 'mayflower' ),
				'section'        => 'mayflower_home',
				'settings'       => 'theme_mayflower_options[blog_homepage_toggle]',
				'type'           => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'blog_number_posts',
			array(
				'label'          => __( 'Number of blog posts', 'mayflower' ),
				'description'    => __( 'How many blog posts should display below page content?', 'mayflower' ),
				'section'        => 'mayflower_home',
				'settings'       => 'theme_mayflower_options[blog_number_posts]',
				'type'           => 'select',
				'choices'        => array(
					'1'       => __( '1', 'mayflower' ),
					'2'       => __( '2', 'mayflower' ),
					'3'       => __( '3', 'mayflower' ),
					'4'       => __( '4', 'mayflower' ),
					'5'       => __( '5', 'mayflower' ),
					'6'       => __( '6', 'mayflower' ),
					'7'       => __( '7', 'mayflower' ),
					'8'       => __( '8', 'mayflower' ),
					'9'       => __( '9', 'mayflower' ),
					'10'      => __( '10', 'mayflower' ),
				)
			)
		)
	);

	/*
	 * Social Media Settings
	 */
	$wp_customize->add_setting( 'theme_mayflower_options[facebook]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['facebook'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[twitter]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['twitter'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[flickr]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['flickr'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[linkedin]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['linkedin'],
	) );
	$wp_customize->add_setting( 'theme_mayflower_options[youtube]' , array(
		'type'              => 'option',
		'default'           => $mayflower_theme_option_defaults['youtube'],
	) );
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'facebook',
			array(
				'label'          => __( 'Facebook', 'mayflower' ),
				'section'        => 'mayflower_social',
				'settings'       => 'theme_mayflower_options[facebook]',
				'type'           => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'twitter',
			array(
				'label'          => __( 'Twitter', 'mayflower' ),
				'section'        => 'mayflower_social',
				'settings'       => 'theme_mayflower_options[twitter]',
				'type'           => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'flickr',
			array(
				'label'          => __( 'Flickr', 'mayflower' ),
				'section'        => 'mayflower_social',
				'settings'       => 'theme_mayflower_options[flickr]',
				'type'           => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'linkedin',
			array(
				'label'          => __( 'LinkedIn', 'mayflower' ),
				'section'        => 'mayflower_social',
				'settings'       => 'theme_mayflower_options[linkedin]',
				'type'           => 'text',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'youtube',
			array(
				'label'          => __( 'YouTube', 'mayflower' ),
				'section'        => 'mayflower_social',
				'settings'       => 'theme_mayflower_options[youtube]',
				'type'           => 'text',
			)
		)
	);


}

add_action( 'customize_register', 'mayflower_register_theme_customizer' );

/**
 * Load options and merge with defaults array
 *
 * Returns array of all mayflower options.
 */
function mayflower_get_options() {
	/* Globalize $mayflower_theme_option_defaults */
	global $mayflower_theme_option_defaults;

	/* Merge theme options and theme options defaults */
	$mayflower_options = wp_parse_args( get_option( 'theme_mayflower_options', array() ), $mayflower_theme_option_defaults );

	/* return all values */
	return $mayflower_options;
}

/**
 * Return value of option
 *
 * Pass option key to get option value.
 */
function mayflower_get_option( $option ) {
	$mayflower_options = mayflower_get_options();
	$option = $mayflower_options[$option];
	return $option;
}
