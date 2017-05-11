<?php

/* Load  theme options framework
 *
 * This legacy code is mainly from the Oenology theme.
 * TODO: Define new orgizational schema and migrate content of functions.php
 *
 * theme-setup.php - sets theme functionality
 * wordpress-hooks.php - filters and functionality changes
 * options-admin.php - defines Mayflower Admin Only option page -
                       consider migrating to customizer
 * options.php - theme options definition
 * options-customizer.php - translate options.php to customizer
 * network-options.php - Network Admin options pane
 */

require( get_template_directory() . '/inc/functions/theme-setup.php' );
require( get_template_directory() . '/inc/functions/wordpress-hooks.php' );
require( get_template_directory() . '/inc/functions/options-customizer.php' );
require( get_template_directory() . '/inc/functions/globals-options.php');
require( get_template_directory() . '/inc/functions/globals.php');


#####################################################
// Configuration for classes shortcode
#####################################################
define("CLASSESURL","http://www.bellevuecollege.edu/classes/All/");
define("PREREQUISITEURL","http://www.bellevuecollege.edu/transfer/prerequisites/");
$gaCode = "";


############################
// show admin bar only for editors and higher
############################

if (!current_user_can('edit_pages')) {
	add_filter('show_admin_bar', '__return_false');
}

/**
 * Load Mayflower Embedded Plugins
 *
 * These files provide plugin-like functionality embedded within Mayflower.
 *
 * @since 1.0
 *
 */

$mayflower_options = mayflower_get_options();

// Slider
if ($mayflower_options['slider_toggle'] == 'true') {
	if ( file_exists( get_template_directory() . '/inc/mayflower-slider/slider.php' ) ) {
		require( get_template_directory() . '/inc/mayflower-slider/slider.php' );
	}
}

// Staff
if ($mayflower_options['staff_toggle'] == 'true') {
	if ( file_exists( get_template_directory() . '/inc/mayflower-staff/staff.php' ) ) {
		require( get_template_directory() . '/inc/mayflower-staff/staff.php' );
	}
}

// SEO
if ( file_exists( get_template_directory() . '/inc/mayflower-seo/mayflower_seo.php' ) ) {
	require( get_template_directory() . '/inc/mayflower-seo/mayflower_seo.php' );
}

// Course Description Shortcodes
if ( file_exists( get_template_directory() . '/inc/mayflower-course-descriptions/mayflower-course-descriptions.php') ) {
	require( get_template_directory() . '/inc/mayflower-course-descriptions/mayflower-course-descriptions.php' );
}


######################################
// Customize Excerpt Read More
######################################

function new_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink() . '">' . __('...more about ', 'mayflower') . get_the_title() . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

######################################
// Custom Pagination Function
######################################
function mayflower_pagination() {
	$big = 999999999; // need an unlikely integer

	$paginated_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'type' => 'array',
		'prev_text' => '<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Previous',
		'next_text' => 'Next <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>',
		'before_page_number' => '<span class="sr-only">Page</span>',
	) );
	// Output Pagination
	if ( $GLOBALS['wp_query']->max_num_pages > 1 ) { ?>
		<nav class="text-center content-padding">
			<ul class="pagination">
				<?php foreach( $paginated_links as $link ) {
					// Check if 'Current' class appears in string
					$is_current = strpos( $link, 'current' );
					if ( $is_current === false ) {
						echo '<li>';
						echo $link;
						echo '</li>';
					} else {
						echo '<li class="active">';
						echo $link;
						echo '</li>';
					}
				} ?>
			</ul>
		</nav> <?php
	}
}


######################################
// Remove Comments Feed
######################################

remove_action('wp_head', 'feed_links', 2);
add_action('wp_head', 'my_feed_links');

function my_feed_links() {
  if ( !current_theme_supports('automatic-feed-links') ) return;

  // post feed
  ?>
  <link rel="alternate" type="<?php echo feed_content_type(); ?>"
        title="<?php printf(__('%1$s %2$s Feed', 'mayflower'), get_bloginfo('name'), ' &raquo; '); ?>"
        href="<?php echo get_feed_link(); ?> " />
  <?php
}


######################################
// Remove WordPress default widgets
######################################

function mayflower_remove_default_widgets() {

	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_Pages');
}

add_action( 'widgets_init', 'mayflower_remove_default_widgets' );


######################################
// Remvoe Wordpress Version Number
######################################

function remove_wp_version() { return ''; }
add_filter('the_generator', 'remove_wp_version');


######################################
// Add frontend style to wysiwyg editor
######################################

function mayflower_add_editor_styles() {
	global $globals_url, $globals_version;
	add_editor_style( array(
		$globals_url . 'c/g.css?=' . $globals_version,
		'style.css',
		'css/custom-editor-style.css'
	) );
}
add_action( 'init', 'mayflower_add_editor_styles' );

######################################
// TinyMCE Customizations
######################################

//show/hide kitchen sink 'show' by default
	function unhide_kitchensink( $args ) {
		$args['wordpress_adv_hidden'] = false;
		return $args;
	}

	add_filter( 'tiny_mce_before_init', 'unhide_kitchensink' );


// Remove items from default tinymce editor
function mayflower_tinymce_buttons_remove( $init ) {
	//remove address and h1
 $init['block_formats'] = "Paragraph=p; Preformatted=pre; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6";
 return $init;
}
add_filter('tiny_mce_before_init', 'mayflower_tinymce_buttons_remove');

function myplugin_tinymce_buttons($buttons)
{
    //Remove the text color selector
    $remove = array('forecolor');

    return array_diff($buttons,$remove);
}
add_filter('mce_buttons_2','myplugin_tinymce_buttons');

######################################
// Add our Styles to wysiwyg editor
######################################

// Add the Style Dropdown Menu to the second row of visual editor buttons
function mayflower_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

add_filter( 'mce_buttons_2', 'mayflower_mce_buttons_2' );


//Add custom styles to tinymce editor
function mayflower_mce_before_init( $settings ) {

	$style_formats = array(
		array(
			'title' => 'Intro (.lead)',
			'block' => 'p',
			'classes' => 'lead',
			'wrapper' => false,
		),
		array(
			'title' => 'Alert (.alert-warning)',
			'block' => 'div',
			'classes' => 'alert alert-warning',
			'wrapper' => true,
		),
		array(
			'title' => 'Alert-Danger (.alert-danger)',
			'block' => 'div',
			'classes' => 'alert alert-danger',
			'wrapper' => true,
		),
		array(
			'title' => 'Alert-Info (.alert-info)',
			'block' => 'div',
			'classes' => 'alert alert-info',
			'wrapper' => true,
		),
		array(
			'title' => 'Alert-Success (.alert-success)',
			'block' => 'div',
			'classes' => 'alert alert-success',
			'wrapper' => true,
		),
		array(
			'title' => 'Well (.well)',
			'block' => 'div',
			'classes' => 'well',
			'wrapper' => true,
		),
	);


	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;

}

add_filter( 'tiny_mce_before_init', 'mayflower_mce_before_init' );


#############################
// Add *_is_blog function
#############################

function mayflower_is_blog() {
	if (is_home() || is_archive() || is_singular('post') || is_post_type_archive( 'post' )) return true; else return false;
}


#############################
// Add has_active_sidebar function
#############################
function has_active_sidebar() {
	$sidebar_is_active;
	//Default functionality
	if ( mayflower_is_blog() ) {
		if (    is_active_sidebar( 'top-global-widget-area' ) ||
				is_active_sidebar( 'blog-widget-area' ) ||
				is_active_sidebar( 'global-widget-area' ) ) {
			$sidebar_is_active = true;
		} else {
			$sidebar_is_active = false;
		}
	} else {
		if (    is_active_sidebar( 'top-global-widget-area' ) ||
				is_active_sidebar( 'page-widget-area' ) ||
				is_active_sidebar( 'global-widget-area' ) ) {
			$sidebar_is_active = true;
		} else {
			$sidebar_is_active = false;
		}
	}
	/**
	 * Add mayflower_active_sidebar filter
	 *
	 * Allows plugins and themes to override
	 * active sidebar state
	 */
	$sidebar_is_active = apply_filters( 'mayflower_active_sidebar', $sidebar_is_active );
	
	return $sidebar_is_active;
}


/**
 * Hook to allow display of additional sidebars
 *
 * Hooks in above Static in sidebar.php
 */
function mayflower_display_sidebar() {
	do_action( 'mayflower_display_sidebar' );
}

#############################
// Add is_multisite_home
#############################

function is_multisite_home () {
	if (is_main_site() && is_front_page()) return true; else return false;
}

#############################
// Assign global_nav_selection to body_class
#############################
if ( ! function_exists ( 'mayflower_body_class_ia' ) ) {
	function mayflower_body_class_ia( $classes ) {
		$mayflower_options = mayflower_get_options();

		// add ia_options to classes
		$classes[] = $mayflower_options['global_nav_selection'];

		// return the $classes array
		return $classes;
	}
}

add_filter( 'body_class','mayflower_body_class_ia' );

######################################
// Wordpress Widget Area Setup
######################################

/**
 * Register Sidebar Hook
 *
 * Allow plugins and themes to register additional
 * sidebars via the mayflower_register_sidebar hook
 */
function mayflower_register_sidebar() {
	do_action( 'mayflower_register_sidebar' );
}
// Register all sidebars
add_action( 'widgets_init', 'mayflower_register_sidebar' );


/**
 * Register Mayflower Sidebars
 *
 * Use hook to register mayflower sidebars
 */

// Top Global Widget Area - located just below the sidebar nav.
function mayflower_register_top_global_sidebar() {
	register_sidebar( array(
		'name' => __( 'Top Global Sidebar Widget Area', 'mayflower' ),
		'id' => 'top-global-widget-area',
		'description' => __( 'This is the top global widget area. Items will appear on all pages throughout the web site.', 'mayflower' ),
		'before_widget' => '<div class="wp-widget wp-widget-global %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title content-padding">',
		'after_title' => '</h2>',
	) );
}
add_action( 'mayflower_register_sidebar', 'mayflower_register_top_global_sidebar', 2 );

// Static Page Widget Area - located just below the global nav on static pages.
function mayflower_register_static_sidebar() {
	register_sidebar( array(
		'name' => __( 'Static Page Sidebar Widget Area', 'mayflower' ),
		'id' => 'page-widget-area',
		'description' => __( 'This is the static page widget area. Items will appear on all static pages.', 'mayflower' ),
		'before_widget' => '<div class="wp-widget wp-widget-static %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title content-padding">',
		'after_title' => '</h2>',
	) );
}
add_action( 'mayflower_register_sidebar', 'mayflower_register_static_sidebar', 4 );

// Blog Widget Area - located just below the global nav on blog pages.
function mayflower_register_blog_sidebar() {
	register_sidebar( array(
		'name' => __( 'Blog Sidebar Widget Area', 'mayflower' ),
		'id' => 'blog-widget-area',
		'description' => __( 'This is the blog widget area. Items will appear on all blog related pages.', 'mayflower' ),
		'before_widget' => '<div class="wp-widget wp-widget-blog %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title content-padding">',
		'after_title' => '</h2>',
	) );
}
add_action( 'mayflower_register_sidebar', 'mayflower_register_blog_sidebar', 6 );

// Bottom Global Widget Area - located just below the sidebar nav.
function mayflower_register_bottom_global_sidebar() {
	register_sidebar( array(
		'name' => __( 'Bottom Global Sidebar Widget Area', 'mayflower' ),
		'id' => 'global-widget-area',
		'description' => __( 'This is the bottom global widget area. Items will appear on all pages throughout the web site.', 'mayflower' ),
		'before_widget' => '<div class="wp-widget wp-widget-global %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title content-padding">',
		'after_title' => '</h2>',
	) );
}
add_action( 'mayflower_register_sidebar', 'mayflower_register_bottom_global_sidebar', 8 );


function widget_empty_title($output='') {

    if ($output == '&nbsp') {
        return '';
    }
    return $output;
}
add_filter('widget_title', 'widget_empty_title');

############################
// Force IE Edge in WP Admin
############################

//hook the administrative header output
add_action('admin_head', 'force_ie_edge_admin');

function force_ie_edge_admin() {
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
}

########################################
// Give active menu item 'active' class
########################################

add_filter('nav_menu_css_class' , 'mayflower_nav_active_class' , 10 , 2);
function mayflower_nav_active_class($classes, $item){
     if ( in_array('current-menu-item', $classes) || preg_grep( '/^current-.*-ancestor$/i', $classes )){
             $classes[] = 'active ';
     }

	//Apply active class on blog post parent
	if ( is_singular('post') ) {
		if( in_array('current_page_parent', $classes)){
             $classes[] = 'active ';
     	}
	}

	//Apply 'active' style to any menu item with the added class of 'staff' to highlight staff parent
	if ( is_singular('staff') ) {
		if( in_array('staff', $classes)){
             $classes[] = 'active ';
     	}
	}

     return $classes;
}

#######################################
// Load Scripts and Styles the WordPress way
#######################################

//set CSS type
$mayflower_brand = mayflower_get_option('mayflower_brand');
$mayflower_brand_css = "";
if( $mayflower_brand == 'lite' ) {
	$mayflower_brand_css = "globals-lite";
 } else {
	$mayflower_brand_css = "globals-branded";
}

function mayflower_scripts() {
	global $globals_url, $globals_version;
	wp_enqueue_style( 'globals', $globals_url . 'c/g.css', null, $globals_version, 'screen' );
	wp_enqueue_style( 'globals-print', $globals_url . 'c/p.css', null, $globals_version, 'print' );
	wp_enqueue_style( 'mayflower', get_stylesheet_uri());

	// These go first- modernizr and respond.js
	wp_enqueue_script( 'globals-head', $globals_url . 'j/ghead.js', $globals_version, null, false );

	// Wrap script in IE conditional- from http://stackoverflow.com/a/16221114
	wp_enqueue_script( 'globals-respond', $globals_url . 'j/respond.js', null, $globals_version, false );
	add_filter( 'script_loader_tag', function( $tag, $handle ) {
		if ( $handle === 'respond' ) {
			$tag = "<!--[if lt IE 9]>$tag<![endif]-->";
		}
		return $tag;
	}, 10, 2 );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap', $globals_url . 'j/bootstrap.min.js', array('jquery'), $globals_version, true );
	wp_enqueue_script( 'globals', $globals_url . 'j/g.js', array('jquery', 'bootstrap'), $globals_version, true );
	wp_enqueue_script( 'menu', get_template_directory_uri() . '/js/menu.js', array('jquery'), null , true );
}

add_action( 'wp_enqueue_scripts', 'mayflower_scripts' );


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


################################################################################
// - Apply mayflower custom CSS  (currently for staff/slider cpt)
################################################################################

	function mayflower_dashboard_styles($hook) {
	    $css_path = get_template_directory_uri() . '/css/dashboard.css';
		if('edit.php?post_type=staff' !=$hook )
	        wp_register_style( 'mayflower_dashboard', $css_path );
	        wp_enqueue_style( 'mayflower_dashboard' );
	}
	add_action( 'admin_enqueue_scripts', 'mayflower_dashboard_styles' );



############################
// Custom Widget Styles
############################

	plugins_url('mayflower_location/buildings/');

	add_action('admin_print_styles-widgets.php', 'mayflower_widgets_style');
	function mayflower_widgets_style()
	{ ?>
	<style type="text/css">
		div.widget[id*=_mayflower_] .widget-title{
		color: #2191bf;
		    background: url(<?php echo get_stylesheet_directory_uri() ?>/img/bc-blue-widget-stripe.png) no-repeat;
		    }
		div.widget[id*=_mayflower_] .widget-title h4 {
			padding-left: 6px;
			}
	</style>
	<?php
	}

####################################################
## Gravity Forms Filters
###################################################

// start tab index at position 9 so we don't conflict with skip to links or wp admin bar
add_filter("gform_tabindex", create_function("", "return 9;"));

/**
 * Filter GravityForms buttons
 *
 * Function from https://github.com/pbc-web/gravityforms-add-button-class/
 * This function accepts an extra 'new classes' perameter, and should not be
 * used with a filter directly.
 */
function mayflower_gf_add_class_to_button( $button, $form, $new_classes ) {

	preg_match( "/class='[\.a-zA-Z_ -]+'/", $button, $classes );
	$classes[0] = substr( $classes[0], 0, -1 );
	$classes[0] .= ' ';
	$classes[0] .= esc_attr( $new_classes );
	$classes[0] .= "'";
	$button_pieces = preg_split(
		"/class='[\.a-zA-Z_ -]+'/",
		$button,
		-1,
		PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
	);
	return $button_pieces[0] . $classes[0] . $button_pieces[1];
}

/**
 * Filter GravityForms submit button to add Bootstrap classes
 */
function mayflower_gf_add_class_to_submit_button( $button, $form ) {
	$new_classes = 'btn btn-primary pull-right';
	return mayflower_gf_add_class_to_button( $button, $form, $new_classes );
}
add_filter( 'gform_submit_button', 'mayflower_gf_add_class_to_submit_button', 10, 2);

/**
 * Filter GravityForms next button to add Bootstrap classes
 */
function mayflower_gf_add_class_to_next_button( $button, $form ) {
	$new_classes = 'btn btn-primary pull-right';
	return mayflower_gf_add_class_to_button( $button, $form, $new_classes );
}
add_filter( 'gform_next_button', 'mayflower_gf_add_class_to_next_button', 10, 2);

/**
 * Filter GravityForms previous button to add Bootstrap classes
 */
function mayflower_gf_add_class_to_previous_button( $button, $form ) {
	$new_classes = 'btn btn-default pull-left';
	return mayflower_gf_add_class_to_button( $button, $form, $new_classes );
}
add_filter( 'gform_previous_button', 'mayflower_gf_add_class_to_previous_button', 10, 2);


####################################################
## Override Dashicons Styles
####################################################


add_action('admin_head', 'override_dashicons');

function override_dashicons() { ?>
<style>
.dashicons-welcome-learn-more:before {
	line-height: 26px;
}
  </style>
<?php }

///////////////////////////////////////
// - CPT Re-ordering
// - Register and write the ajax callback function to actually update the posts.
// * Set action in sorting-v2.js to the function name below
///////////////////////////////////////

add_action( 'wp_ajax_mayflower_cpt_update_post_order', 'mayflower_cpt_update_post_order' );

function mayflower_cpt_update_post_order() {
	global $wpdb;

	$post_type     = $_POST['postType'];
	$order        = $_POST['order'];

	/**
	*    Expect: $sorted = array(
	*                menu_order => post-XX
	*            );
	*/
	foreach( $order as $menu_order => $post_id )
	{
		$post_id         = intval( str_ireplace( 'post-', '', $post_id ) );
		$menu_order     = intval($menu_order);
		wp_update_post( array( 'ID' => $post_id, 'menu_order' => $menu_order ) );
	}

	die( '1' );
}

/////////////////////////
// Custom Meta Boxes
/////////////////////////

// Field Array
$prefix = '_gnav_';
$global_section_meta_fields = array(
    array(
        'label'=> 'College navigation menu',
        'desc'  => 'This page and all it\'s children will have the above college navigation area selected',
        'id'    => $prefix.'college_nav_menu',
        'type'  => 'select',
        'options' => array (
            'nav-home' => array (
                'label' => 'Home',
                'value' => 'nav-home'
            ),
            'nav-classes' => array (
                'label' => 'Classes',
                'value' => 'nav-classes'
            ),
            'nav-programs' => array (
                'label' => 'Programs of Study',
                'value' => 'nav-programs'
            ),
            'nav-enrollment' => array (
                'label' => 'Enrollment',
                'value' => 'nav-enrollment'
            ),
            'nav-services' => array (
                'label' => 'Services',
                'value' => 'nav-services'
            ),
            'nav-campuslife' => array (
                'label' => 'Campus Life',
                'value' => 'nav-campuslife'
            ),
            'nav-about' => array (
                'label' => 'About Us',
                'value' => 'nav-about'
            )
        )
    )
);


// The Callback
function global_section_meta_box() {
global $global_section_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="global_section_meta_box" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($global_section_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch( $field['type'] ) {

					case 'input':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="60" />
							<br /><span class="description">'.$field['desc'].'</span>';
						break;

					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
							<br /><label for="'.$field['id'].'">'.$field['desc'].'</label>';
						break;

					case 'textarea':
					    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="58" rows="4">'.$meta.'</textarea>
					        <br /><span class="description">'.$field['desc'].'</span>';
						break;

					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
						break;
					//No Need for Default Case

				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}

// Save the Data
function save_global_section_meta($post_id) {
    global $global_section_meta_fields;
	// verify nonce

	// verify nonce
	if ( !isset( $_POST['global_section_meta_box'] ) || !wp_verify_nonce( $_POST['global_section_meta_box'], basename( __FILE__ ) ) )
		return $post_id;

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	// loop through fields and save the data
	foreach ($global_section_meta_fields as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}
add_action('save_post', 'save_global_section_meta');

/*
 *  Adding mayflower theme to have google analytics tracking for logged in users.
 */
function google_analytics_dashboard()
{
    if(is_user_logged_in())
    {
		$mayflower_globals_settings = get_option( 'globals_network_settings' );
		if ( is_multisite() ) {
        	$mayflower_globals_settings = get_site_option( 'globals_network_settings' );
		}
        $globals_google_analytics_code = $mayflower_globals_settings['globals_google_analytics_code'];
        global  $gaCode;
        $gaCode = "'" . $globals_google_analytics_code . "'";
        ?>

        <script type="text/javascript">
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            var ga_code = <?php echo $gaCode ; ?> ;
            ga('create', ga_code , 'bellevuecollege.edu', {'siteSpeedSampleRate': 100});
            ga('send', 'pageview');
        </script>
    <?php
    }
}
add_action('admin_head', 'google_analytics_dashboard');

##############################################################
// Responsive image class for posts & remove image dimensions
##############################################################

function bootstrap_responsive_images( $html ){
  $classes = 'img-responsive'; // separated by spaces, e.g. 'img image-link'

  // check if there are already classes assigned to the anchor
  if ( preg_match('/<img.*? class="/', $html) ) {
    $html = preg_replace('/(<img.*? class=".*?)(".*?\/>)/', '$1 ' . $classes . ' $2', $html);
  } else {
    $html = preg_replace('/(<img.*?)(\/>)/', '$1 class="' . $classes . '" $2', $html);
  }
  // remove dimensions from images,, does not need it!
  $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
  return $html;
}
add_filter( 'the_content','bootstrap_responsive_images',10 );
add_filter( 'post_thumbnail_html', 'bootstrap_responsive_images', 10 );

###############################################################
// Responsive video - add wrapper div with appropriate classes
###############################################################

add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);
function my_embed_oembed_html($html, $url, $attr, $post_id) {
  return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}

/**
 *  Add classes to image gallery container
 */
function mayflower_gallery_styles( $styles ) {
	$search = "'>";
	$replace = " clearfix row'>";
	$styles = str_replace( $search, $replace, $styles );
	return $styles;
}
add_action( 'gallery_style', 'mayflower_gallery_styles' );


/*
 * Alt Text Verification
 *
 * Taken from WP Accessibility Plugin https://wordpress.org/plugins/wp-accessibility/ Version 1.4.6
 */

// Add Checkbox to mark image as decorative
add_filter( 'attachment_fields_to_edit', 'wpa_insert_alt_verification', 10, 2 );
function wpa_insert_alt_verification( $form_fields, $post ) {
	$mime = get_post_mime_type( $post->ID );
	if ( $mime == 'image/jpeg' || $mime == 'image/png' || $mime == 'image/gif' ) {
		$no_alt = get_post_meta( $post->ID, '_no_alt', true );
		$alt = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
		$checked = checked( $no_alt, 1, false );
		$form_fields['no_alt'] = array( 
			'label' => __( 'Decorative', 'mayflower' ),
			'input' => 'html',
			'value' => 1,
			'html'  => "<input name='attachments[$post->ID][no_alt]' id='attachments-$post->ID-no_alt' value='1' type='checkbox' aria-describedby='wpa_help' $checked /> <em class='help' id='wpa_help'>" . __( '<strong>Image is purely decorative.</strong> This will strip alt text from the image, and should not be used if image contributes to page content.', 'mayflower' ) . "</em>"
		);
	}
	return $form_fields;
}

add_filter( 'attachment_fields_to_save', 'wpa_save_alt_verification', 10, 2 );
function wpa_save_alt_verification( $post, $attachment ) {
	if ( isset( $attachment['no_alt'] ) ) {
		update_post_meta( $post['ID'], '_no_alt', 1 );
	} else {
		delete_post_meta( $post['ID'], '_no_alt' );
	}
	return $post;
}

add_filter( 'image_send_to_editor', 'wpa_alt_attribute', 10, 8 );
function wpa_alt_attribute( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
	/* Get data for the image attachment. */
	$noalt = get_post_meta( $id, '_no_alt', true );
	/* Get the original title to compare to alt */
	$title = get_the_title( $id );
	$warning = false;
	if ( $noalt == 1 ) {
		$html = str_replace( 'alt="'.$alt.'"', 'alt=""', $html );
	}
	if ( ( $alt == '' || $alt == $title ) && $noalt != 1 ) {
		if ( $alt == $title ) {
			$warning = __( 'The alt text for this image is the same as the title. Please review your alternate text to ensure it describes the image.', 'mayflower' );
			$image = 'alt-same.png';
		} else {
			$warning = __( 'This image requires alt text, but the alt text is currently blank. Either add alt text or mark the image as decorative.', 'mayflower' );
			$image = 'alt-missing.png';
		}
	}
	if ( $warning ) {
		return $html . "<img class='wpa-image-missing-alt size-" . esc_attr( $size ) . ' ' . esc_attr( $align ) . "' src='" . get_template_directory_uri() . "/img/$image" . "' alt='" . esc_attr( $warning ) . "' />";
	}
	return $html;
}

/**
 * Pantheon Advanced Cache config
 *
 * These filters and actions improve cache clearing when using
 * the Pantheon Advanced Page Cache plugin
 * https://github.com/pantheon-systems/pantheon-advanced-page-cache
 **/

add_filter( 'pantheon_wp_main_query_surrogate_keys', function( $keys ) {
	global $post;

	// Top Global Sidebar Widget Area
	if ( is_active_sidebar('top-global-widget-area') or
		 is_active_sidebar('global-widget-area')     or
		 is_active_sidebar('page-widget-area')       or
		 is_active_sidebar('blog-widget-area') ) {
		// Add general sidebar key
		$keys[] = 'sidebar';
	}

	// If page has children, and has page template applied, add post ids to parent
	if ( is_page( ) ) {
		// Load child pages
		$children = get_pages( array( 'child_of' => $post->ID ) );

		// Check if page has children, and has template applied
		if ( ( count( $children ) > 0 ) && is_page_template() ) {
			// Add keys to current page
			foreach ( $children as $child ) {
				$keys[] = 'post-' . $child->ID;
			}
		}
	}

	// Return all keys
	return $keys;
});

// Clear pages with sidebars when sidebars are updated
add_action( 'update_option_sidebars_widgets', function() {
	if ( function_exists( 'pantheon_wp_clear_edge_keys' ) ) {
		pantheon_wp_clear_edge_keys( array( 'sidebar' ) );
	}
});
