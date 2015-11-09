<?
/**
 * Theme Settings area
 *
 * Configuration for Mayflower Homepage settings area
 * in the customizer
 */
function mayflower_admin_only_register( $wp_customize ) {
	
	/**
	 * Validate checkbox input
	 */
	function sanitize_checkbox( $input ) {
		if ( $input == true || $input == 1 ) {
			return true;
		} else {
			return false;
		}
	}

	$wp_customize->add_section( 'mayflower_admin_options' , array(
		'title'      => __( 'Mayflower Admin Only ', 'mayflower_admin_only' ),
		'panel'      => 'mayflower',
		'capability' => 'unfiltered_html', //Limit this section to Super-Admin only
		'priority'   => 150,
	) );
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
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'hide_searchform', array(
		'label'        => __( 'Hide Search Form', 'hide_searchform' ),
		'description'  => __( 'Hide Search in Mayflower Lite' ),
		'section'      => 'mayflower_admin_options',
		'settings'     => 'hide_searchform',
		'type'         => 'checkbox',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'limit_searchform_scope', array(
		'label'        => __( 'Limit Search Form Scope', 'limit_searchform_scope' ),
		'description'  => __( 'Search within the subsite instead of within the master BC scope' ),
		'section'      => 'mayflower_admin_options',
		'settings'     => 'limit_searchform_scope',
		'type'         => 'checkbox',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'custom_searchform_scope', array(
		'label'        => __( 'Custom Search Form Scope', 'custom_searchform_scope' ),
		'description'  => __( 'Allows definition of custom scope. If none is defined, local site URL will be used. ' ),
		'section'      => 'mayflower_admin_options',
		'settings'     => 'custom_searchform_scope',
		'type'         => 'text',
	) ) );
}
add_action( 'customize_register', 'mayflower_admin_only_register' );

