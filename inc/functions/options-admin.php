<?php

/**
 * Tutorial can be found here: https://github.com/tommcfarlin/WordPress-Settings-Sandbox
 * This function introduces the Mayflower Admin Only settings into the 'Appearance' menu 
 */
function mayflower_admin_example_theme_menu() {

	add_theme_page(
		'Mayflower Admin Only Settings', 			// The title to be displayed in the browser window for this page.
		'Mayflower Admin Only Settings',			// The text to be displayed for this menu item
		'administrator',											// Which type of users can see this menu item
		'mayflower_admin_theme_options',			// The unique ID - that is, the slug - for this menu item
		'mayflower_admin_theme_display'				// The name of the function to call when rendering this menu's page
	);

} // end mayflower_admin_example_theme_menu
add_action( 'admin_menu', 'mayflower_admin_example_theme_menu' );

/**
 * Renders a simple page to display for the theme menu defined above.
 */
function mayflower_admin_theme_display( $active_tab = '' ) {
?>
	<!-- Create a header in the default WordPress 'wrap' container -->
	<div class="wrap">
	
		<h2><?php _e( 'Mayflower Admin Only Settings', 'mayflower_admin' ); ?></h2>
		<?php settings_errors(); ?>
		
		<?php if( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		} else {
			$active_tab = 'general_options';
		} // end if/else ?>

		<h2 class="nav-tab-wrapper">
			<a href="?page=mayflower_admin_theme_options&tab=general_options" class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Settings', 'mayflower_admin' ); ?></a>
		</h2>
		
		<form method="post" action="options.php">
			<?php

				if( $active_tab == 'general_options' ) {

					settings_fields( 'mayflower_admin_theme_general_options' );
					do_settings_sections( 'mayflower_admin_theme_general_options' );
}

				submit_button();

			?>
		</form>
		
	</div><!-- /.wrap -->
<?php
} // end mayflower_admin_theme_display

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */ 

/**
 * Provides default values for the Display Options.
 */
function mayflower_admin_theme_default_general_options() {

	$defaults = array(
		'hide_searchform'		=> '',
	);

	return apply_filters( 'mayflower_admin_theme_default_general_options', $defaults );

} // end mayflower_admin_theme_default_general_options


/**
 * Initializes the theme's display options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */ 
function mayflower_admin_initialize_theme_options() {

	// If the theme options don't exist, create them.
	if( false == get_option( 'mayflower_admin_theme_general_options' ) ) {	
		add_option( 'mayflower_admin_theme_general_options', apply_filters( 'mayflower_admin_theme_default_general_options', mayflower_admin_theme_default_general_options() ) );
	} // end if

	// First, we register a section. This is necessary since all future options must belong to a 
/*
	add_settings_section(
		'mayflower_brand_section',			// ID used to identify this section and with which to register options
		__( 'Mayflower Brand', 'mayflower_admin' ),		// Title to be displayed on the administration page
		'mayflower_admin_mayflower_brand_callback',	// Callback used to render the description of the section
		'mayflower_admin_theme_general_options'		// Page on which to add this section of options
	);
*/
	add_settings_section(
		'searchform_settings_section',			// ID used to identify this section and with which to register options
		__( 'Hide Search Form', 'mayflower_admin' ),		// Title to be displayed on the administration page
		'mayflower_admin_general_options_callback',	// Callback used to render the description of the section
		'mayflower_admin_theme_general_options'		// Page on which to add this section of options
	);

	// Next, we'll introduce the fields for toggling the visibility of elements.
	add_settings_field(	
		'hide_searchform',						// ID used to identify the field throughout the theme
		__( 'Hide search form in header?', 'mayflower_admin' ),							// The label to the left of the option interface element
		'mayflower_admin_toggle_searchform_callback',	// The name of the function responsible for rendering the option interface
		'mayflower_admin_theme_general_options',	// The page on which this option will be displayed
		'searchform_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Check to hide search form.', 'mayflower_admin' ),
		)
	);

	// Finally, we register the fields with WordPress
	register_setting(
		'mayflower_admin_theme_general_options',
		'mayflower_admin_theme_general_options'
	);

} // end mayflower_admin_initialize_theme_options
add_action( 'admin_init', 'mayflower_admin_initialize_theme_options' );


/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */ 

/**
 * This function provides a simple description for the General Options page. 
 *
 * It's called from the 'mayflower_admin_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function mayflower_admin_mayflower_brand_callback() {
	echo '<p>' . __( 'Which branding of Mayflower Theme should be used for this site?', 'mayflower_admin' ) . '</p>';
} // end mayflower_admin_general_options_callback

function mayflower_admin_general_options_callback() {
	echo '<p>' . __( '', 'mayflower_admin' ) . '</p>';
} // end mayflower_admin_general_options_callback

/* ------------------------------------------------------------------------ *
 * Field Callbacks
 * ------------------------------------------------------------------------ */ 

/**
 * This function renders the interface elements for toggling the visibility of the search form element.
 * 
 * It accepts an array or arguments and expects the first element in the array to be the description
 * to be displayed next to the checkbox.
 */
function mayflower_admin_toggle_searchform_callback($args) {

	// First, we read the options collection
	$options = get_option('mayflower_admin_theme_general_options');

	// Next, we update the name attribute to access this element's ID in the context of the display options array
	// We also access the hide_searchform element of the options collection in the call to the checked() helper function
	$html = '<input type="checkbox" id="hide_searchform" name="mayflower_admin_theme_general_options[hide_searchform]" value="1" ' . checked( 1, isset( $options['hide_searchform'] ) ? $options['hide_searchform'] : 0, false ) . '/>'; 

	// Here, we'll take the first argument of the array and add it to a label next to the checkbox
	$html .= '<label for="hide_searchform">&nbsp;'  . $args[0] . '</label>'; 

	echo $html;

} // end mayflower_admin_toggle_searchform_callback




?>