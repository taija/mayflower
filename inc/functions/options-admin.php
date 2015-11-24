<?
/**
 * Administrator Only Settings
 *
 * Configuration for the Mayflower Admin Only
 * settings section in the customizer
 */
function mayflower_admin_only_register( $wp_customize ) {
	
	/**
	 * Data Validation Functions
	 *
	 * These functions are refrenced via callbacks, and used
	 * to sanitize setting inputs.
	 */
	/**
	 * Validate checkbox input
	 *
	 * Return false if input is not true or 1
	 */
	function sanitize_checkbox( $input ) {
		if ( $input == true || $input == 1 ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Add options using Customizer API
	 */

	/**
	 * Create new section
	 *
	 * New section within Mayflower panel called Administrator Only
	 */
	$wp_customize->add_section( 'mayflower_admin_options' , array(
		'title'      => __( 'Administrator Only ', 'mayflower' ),
		'panel'      => 'mayflower',
		'capability' => 'unfiltered_html', //Limit this section to Super-Admin only
		'priority'   => 300,
	) );

	/**
	 * Add settings
	 */
	$wp_customize->add_setting( 'hide_searchform' , array(
		'default'           => false,
		'transport'         => 'refresh',
		'capability'        => 'unfiltered_html', //Limit this section to Super-Admin only
		'sanitize_callback' => 'sanitize_checkbox',
	) );
	$wp_customize->add_setting( 'limit_searchform_scope' , array(
		'default'           => false,
		'transport'         => 'refresh',
		'capability'        => 'unfiltered_html', //Limit this section to Super-Admin only
		'sanitize_callback' => 'sanitize_checkbox',
	) );
	$wp_customize->add_setting( 'custom_searchform_scope' , array(
		'transport'         => 'refresh',
		'capability'        => 'unfiltered_html', //Limit this section to Super-Admin only
		'sanitize_callback' => 'sanitize_text_field',
	) );

	/**
	 * Add controls to collect information
	 */
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'hide_searchform', array(
		'label'        => __( 'Hide Search Form', 'mayflower' ),
		'description'  => __( 'Hide Search in Mayflower Lite', 'mayflower' ),
		'section'      => 'mayflower_admin_options',
		'settings'     => 'hide_searchform',
		'type'         => 'checkbox',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'limit_searchform_scope', array(
		'label'        => __( 'Limit Search Form Scope', 'mayflower' ),
		'description'  => __( 'Search within the subsite instead of within the master BC scope', 'mayflower' ),
		'section'      => 'mayflower_admin_options',
		'settings'     => 'limit_searchform_scope',
		'type'         => 'checkbox',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'custom_searchform_scope', array(
		'label'        => __( 'Custom Search Form Scope', 'mayflower' ),
		'description'  => __( 'Allows definition of custom scope. If none is defined, local site URL will be used. ', 'mayflower' ),
		'section'      => 'mayflower_admin_options',
		'settings'     => 'custom_searchform_scope',
		'type'         => 'text',
	) ) );
}
add_action( 'customize_register', 'mayflower_admin_only_register' );

