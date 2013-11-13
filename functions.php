<?php

#####################################################
// Load up our experimental theme options page and related code.
#####################################################

	/**
	 * Include the Theme Options Function File
	 *
	 * options.php includes the Theme options and Admin Settings page
	 * - Define default Theme Options
	 * - Register/Initialize Theme Options
	 * - Admin Settings Page
	 * - Contextual Help
	 */

	/**
	 * Include the Theme Options Theme Customizer Function File
	 *
	 * options-customizer.php includes the functions required to
	 * integrate the Theme options into the WordPress Theme
	 * Customizer.
	 */

	    require( get_template_directory() . '/inc/functions/custom.php' );
		require( get_template_directory() . '/inc/functions/theme-setup.php' );
	    require( get_template_directory() . '/inc/functions/wordpress-hooks.php' );
		require( get_template_directory() . '/inc/functions/widgets.php' );
		require( get_template_directory() . '/inc/functions/custom_widgets.php' );
	    require( get_template_directory() . '/inc/functions/options.php');
	    require( get_template_directory() . '/inc/functions/options-customizer.php' );
	    require( get_template_directory() . '/inc/functions/network-options.php');
		require( get_template_directory() . '/inc/functions/hooks.php' );
//		require( get_template_directory() . '/inc/functions/post-custom-meta.php' );
	    require( get_template_directory() . '/inc/functions/contextual-help.php' );
		require( get_template_directory() . '/inc/functions/dynamic-css.php' );
//		require( get_template_directory() . '/inc/functions/helperfunctions.php' );
		define("CLASSESURL","http://bellevuecollege.edu/classes/All/");
		define("PREREQUISITEURL","http://bellevuecollege.edu/enrollment/transfer/prerequisites/");


##################################
## Custom Menu Widget Override
##################################

function load_custom_widgets() {
	unregister_widget("WP_Nav_Menu_Widget");
	register_widget("My_Nav_Menu_Widget");
}

////////////////////////////////////////////////////
// Remove Unneeded Meta Boxes on Pages
/////////////////////////////////////////////////////

function mayflower_remove_meta_boxes() {
  remove_meta_box('postimagediv', 'page', 'side');
}
add_action( 'do_meta_boxes', 'mayflower_remove_meta_boxes' );


############################
// Custom Admin Bar Items
############################

	function mytheme_admin_bar_render() {
		global $wp_admin_bar;
	        $wp_admin_bar->add_menu( array(
	        'parent' => '',
	        'id' => 'mayflower-settings',
	        'title' => 'Theme Options',
	        'href' => admin_url( 'themes.php?page=mayflower-settings')
	    ) );

	}

	add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

############################
// show admin bar only for editors and higher
############################

if (!current_user_can('edit_pages')) {
	add_filter('show_admin_bar', '__return_false');
}

#####################################################
// Load up our plugins
#####################################################

	// Slider
	$mayflower_options = mayflower_get_options();
	if ($mayflower_options['slider_toggle'] == 'true') {
		if( file_exists(get_template_directory() . '/inc/mayflower-slider/slider.php') )
		    require( get_template_directory() . '/inc/mayflower-slider/slider.php');
		}

	// Staff
	$mayflower_options = mayflower_get_options();
	if ($mayflower_options['staff_toggle'] == 'true') {
		if( file_exists(get_template_directory() . '/inc/mayflower-staff/staff.php') )
		    require( get_template_directory() . '/inc/mayflower-staff/staff.php');
		}

	// SEO
			if( file_exists(get_template_directory() . '/inc/mayflower-seo/mayflower_seo.php') )
			    require( get_template_directory() . '/inc/mayflower-seo/mayflower_seo.php');

	// Home Page
		if ( current_user_can('manage_network') ) {
			if( file_exists(get_template_directory() . '/inc/mayflower-bc-home/bc-home.php') )
			    require( get_template_directory() . '/inc/mayflower-bc-home/bc-home.php');
		} // end current_user_can

	// Social Links
//	if( file_exists(get_template_directory() . '/inc/mayflower-social-links/mayflower_social_links.php') )
//	    require( get_template_directory() . '/inc/mayflower-social-links/mayflower_social_links.php');

	//Location
//	if( file_exists(get_template_directory() . '/inc/mayflower-location/mayflower-location.php') )
//	    require( get_template_directory() . '/inc/mayflower-location/mayflower-location.php');

	//Multiple Content Blocks
//	if( file_exists(get_template_directory() . '/inc/multiple-content-blocks-mayflower/multiple-content-blocks.php') )
//	    require( get_template_directory() . '/inc/multiple-content-blocks-mayflower/multiple-content-blocks.php');

	//Rave Alert functionality
	if( file_exists(get_template_directory() . '/inc/alert-notification/alertnotification.php') )
		    require( get_template_directory() . '/inc/alert-notification/alertnotification.php');


	//Service Forms functionality
if( file_exists(get_template_directory() . '/inc/service-forms/service_forms_functions.php') )
	    require( get_template_directory() . '/inc/service-forms/service_forms_functions.php');

#######################################
// adds wordpress theme support
#######################################
// enable excerpts on pages
add_post_type_support( 'page', 'excerpt' );


	add_action( 'after_setup_theme', 'my_theme_setup' );
	function my_theme_setup() {
		add_image_size( 'edit-screen-thumbnail', 100, 100, true );
	}

	// Post Thumbnails
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
	        set_post_thumbnail_size( 150, 150 );
	        add_image_size( 'lite_header_logo', 1170, 63, true);
			add_image_size( 'edit-screen-thumbnail', 100, 100, true );
			add_image_size( 'sort-screen-thumbnail', 300, 125, true );
			add_image_size( 'staff-thumbnail', 300, 200, true );
	        add_image_size( 'featured-full', 1200,500,true);
	        add_image_size( 'featured-in-content', 900,375,true);
	        add_image_size( 'home-small-ad', 300,200,true);
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
        title="<?php printf(__('%1$s %2$s Feed'), get_bloginfo('name'), ' &raquo; '); ?>"
        href="<?php echo get_feed_link(); ?> " />
  <?php 
}


######################################
// Remove WordPress default widgets
######################################

function remove_calendar_widget() {

	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_Pages');
}

add_action( 'widgets_init', 'remove_calendar_widget' );


######################################
// Remvoe Wordpress Version Number
######################################

function remove_wp_version() { return ''; }
add_filter('the_generator', 'remove_wp_version');


######################################
// Add frontend style to wysiwyg editor
######################################

function mayflower_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'init', 'mayflower_add_editor_styles' );



######################################
// Wordpress Widget Area Setup
######################################

	function mayflower_widgets_init() {

		// Static Page Widget Area - located just below the global nav on static pages.
		register_sidebar( array(
			'name' => __( 'Static Page Sidebar Widget Area', 'mayflower' ),
			'id' => 'page-widget-area',
			'description' => __( 'This is the static page widget area. Items will appear on static pages.', 'mayflower' ),
			'before_widget' => '<div class="wp-widget wp-widget-static">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title content-padding">',
			'after_title' => '</h2>',
		) );

		// Blog Widget Area - located just below the global nav on blog pages.
		register_sidebar( array(
			'name' => __( 'Blog Sidebar Widget Area', 'mayflower' ),
			'id' => 'blog-widget-area',
			'description' => __( 'This is the blog widget area. Items will appear on blog pages.', 'mayflower' ),
			'before_widget' => '<div class="wp-widget wp-widget-blog">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title content-padding">',
			'after_title' => '</h2>',
		) );

		// Global Widget Area - located just below the sidebar nav.
		register_sidebar( array(
			'name' => __( 'Global Sidebar Widget Area', 'mayflower' ),
			'id' => 'global-widget-area',
			'description' => __( 'This is the global widget area. Items will appear throughout the web site.', 'mayflower' ),
			'before_widget' => '<div class="wp-widget wp-widget-global">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="global-widget-area content-padding">',
			'after_title' => '</h2>',
		) );

		// Aside Widget Area - aside located in right column of page content.
/*
		register_sidebar( array(
			'name' => __( 'In-Page Aside Widget Area', 'mayflower' ),
			'id' => 'aside-widget-area',
			'description' => __( 'This is the widget area for asides in pages.', 'mayflower' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
*/
		// Area 3, located in left column of footer.
/*
		register_sidebar( array(
			'name' => __( 'Footer Left Column Widget', 'mayflower' ),
			'id' => 'footer-left-widget-area',
			'description' => __( 'This is the widget area for the left column of the footer.', 'mayflower' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		) );

		// Area 4, located in middle column of footer.
		register_sidebar( array(
			'name' => __( 'Footer Center Column Widget', 'mayflower' ),
			'id' => 'footer-center-widget-area',
			'description' => __( 'This is the widget area for the center column of the footer.', 'mayflower' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		) );

		// Area 5, located in right column of footer.
		register_sidebar( array(
			'name' => __( 'Footer Right Column Widget', 'mayflower' ),
			'id' => 'footer-right-widget-area',
			'description' => __( 'This is the widget area for the right column of the footer.', 'mayflower' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		) );
*/
	}

	/** Register sidebars by running mayflower_widgets_init() on the widgets_init hook. */
	add_action( 'widgets_init', 'mayflower_widgets_init' );


#########################
//set globals path
#########################

	$bc_globals_html_filepath = $_SERVER['DOCUMENT_ROOT'] . "/g/2/h/";
	
#######################################
//add college head - skinny id bar
#######################################

	function bc_tophead(){
	   global $bc_globals_html_filepath;
	   $header_top =  $bc_globals_html_filepath . "lhead.html";
	   include_once($header_top);
	}
	add_action('mayflower_header','bc_tophead');

########################################
//add college head - big html dropdown
#########################################

	function bc_tophead_big() {
		global $bc_globals_html_filepath;
		$header_top_big = $bc_globals_html_filepath . "bhead.html";
		include_once($header_top_big);
	}

	add_action('mayflower_header','bc_tophead_big');

###########################
// Custom do_settings_sections function
###########################
/*
function custom_do_settings_sections($page) {
    global $wp_settings_sections, $wp_settings_fields;

    if ( !isset($wp_settings_sections) || !isset($wp_settings_sections[$page]) )
        return;

    foreach( (array) $wp_settings_sections[$page] as $section ) {
        echo "<h3 class="$section['title']">{$section['title']}</h3>\n";
        call_user_func($section['callback'], $section);
        if ( !isset($wp_settings_fields) ||
             !isset($wp_settings_fields[$page]) ||
             !isset($wp_settings_fields[$page][$section['id']]) )
                continue;
        echo '<div class="settings-form-wrapper">';
        custom_do_settings_fields($page, $section['id']);
        echo '</div>';
    }
}

function custom_do_settings_fields($page, $section) {
    global $wp_settings_fields;

    if ( !isset($wp_settings_fields) ||
         !isset($wp_settings_fields[$page]) ||
         !isset($wp_settings_fields[$page][$section]) )
        return;

    foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {
        echo '<div class="settings-form-row">';
        if ( !empty($field['args']['label_for']) )
            echo '<p><label for="' . $field['args']['label_for'] . '">' .
                $field['title'] . '</label><br />';
        else
            echo '<p>' . $field['title'] . '<br />';
        call_user_func($field['callback'], $field['args']);
        echo '</p></div>';
    }
}
*/

###########################
//set up college headscripts
##########################

	function head_scripts() {
		?>
		<script type="text/javascript">
			/*<![CDATA[*/
			jQuery.noConflict();
			jQuery(document).ready(function(){
				jQuery(".nav-news a").addClass("selected");
			});
			/*]]>*/
		</script>
		<script type="text/javascript" src="/globals/btheme_v0.1/js/searchbox.js"></script>
		<?php
	}
	add_filter('head_scripts','head_scripts');

###################
//college big footer
###################

	function bc_footer() {
		global $bc_globals_html_filepath;
		   $bc_footer =  $bc_globals_html_filepath . "bfoot.html";
		   $bc_footerlegal =  $bc_globals_html_filepath . "legal.html";
		   include_once($bc_footer);
		   include_once($bc_footerlegal);
	}
	add_action('btheme_footer', 'bc_footer', 50);

###################
//college legal-links footer
###################

	function bc_footer_legal() {
		global $bc_globals_html_filepath;
		   $bc_footerlegal =  $bc_globals_html_filepath . "legal.html";
		   
		   include_once($bc_footerlegal);
		 
	}
	add_action('btheme_footer', 'bc_footer_legal', 50);


##########################
//site specific analytics
##########################

	function mayflower_sitespecific_analytics () {
		$mayflower_options = mayflower_get_options();

		if ($mayflower_options['ga_code']) {
		// Format reference https://developers.google.com/analytics/devguides/collection/gajs/?hl=nl&csw=1#MultipleCommands
	 	?>
			<script type="text/javascript">
                /*Site-Specific GA code*/
				_gaq.push(
				  ['site._setAccount', '<?php echo $mayflower_options['ga_code'] ?>'],
				  ['site._setDomainName', 'bellevuecollege.edu'],
				  ['site._setAllowLinker', true],
				  ['site._trackPageview']
				);
            </script>
		<?php
		} // end if


	} // end function
	add_action('wp_footer', 'mayflower_sitespecific_analytics', 30);


############################
// Force IE Edge in WP Admin
############################

//hook the administrative header output
add_action('admin_head', 'force_ie_edge_admin');

function force_ie_edge_admin() {
echo '
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
';
}

########################################
// Give active menu item 'active' class
########################################

add_filter('nav_menu_css_class' , 'mayflower_nav_active_class' , 10 , 2);
function mayflower_nav_active_class($classes, $item){
     if( in_array('current-menu-item', $classes) || in_array('current-page-ancestor', $classes)){
             $classes[] = 'active ';
     }
	
	/*Apply active class on blog post parent*/
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



	#################################
	/*
		This function is a shortcode to get class schedule data returned as json string for a given course name or a course name and number.
		Fogbugz #2154
	*/
	#################################

	function AllClassInformationRoutine($args)
	{
		$course = $args["course"];
		if(!empty($course))
		{
			$url = CLASSESURL.$course."?format=json";
			$json = file_get_contents($url,0,null,null);
			$html = decodejsonClassInfo($json);
			return $html;
		}
		return null;
	}
	function OneClassInformationRoutine($args)
	{
		$course = $args["course"];
		$number = $args["number"];
		if(!empty($course) && !empty($number))
		{
			$url = CLASSESURL.$course."?format=json";
			$json = file_get_contents($url,0,null,null);
			$html = decodejsonClassInfo($json,$number);
			return $html;
		}
		return null;
	}

	function decodejsonClassInfo($jsonString,$number = NULL)
	{
		$decodeJson = json_decode($jsonString,true);
		$htmlString = "";
		$courses = $decodeJson["Courses"];
		$htmlString .= "<div class='classDescriptions'>";
		foreach($courses as $sections)
		{
			if($number!=null)
			{
				if($sections["Number"] == $number)
				{
					$htmlString .= getHtmlForCourse($sections);
				}				
			}
			else
			{
				$htmlString .= getHtmlForCourse($sections);
			}
		}
		$htmlString .= "</div>"; //classDescriptions

		return $htmlString;
	}

	function getHtmlForCourse($sections)
	{
		$htmlString .= "<div class='classInfo'>";
		$htmlString .= "<h2 class='classHeading'>";
			$courseUrl = CLASSESURL.$sections["Subject"];
			if($sections["IsCommonCourse"])
			{
				$courseUrl .= "&";
			}
			$courseUrl .= "/".$sections["Number"];
			
			$htmlString .= "<a href='".$courseUrl."''>";
			$htmlString .= "<span class='courseID'>".$sections["Descriptions"][0]["CourseID"]."</span>";
			$htmlString .= "<span class='courseTitle'>".$sections["Title"]."</span>";
			$htmlString .= "<span class='courseCredits'> &#8226; ";
			
			if($sections["IsVariableCredits"])
			{					
				$htmlString .= "V1-".$sections["Credits"]." <abbr title='variable credit'>Cr.</abbr>";
			}
			else
			{
				$htmlString .= $sections["Credits"]." <abbr title='credit(s)'>Cr.</abbr>";
			}
			$htmlString .= "</span>";
			$htmlString .= "</a>";
			$htmlString .= "</h2>";//classHeading 
			$htmlString .= "<p class='classDescription'>" . $sections["Descriptions"][0]["Description"] . "</p>";
			$htmlString .= "<p class='classDetailsLink'>";
			$htmlString .= "<a href='".$courseUrl."'>View details for ".$sections["Descriptions"][0]["CourseID"]."</a>";
			$htmlString .= "</p>";
			$htmlString .= "</div>"; //classInfo
			return $htmlString;
	}


	add_shortcode('AllClassInformation', 'AllClassInformationRoutine');
	add_shortcode('OneClassInformation', 'OneClassInformationRoutine');

	//$mayflower_options['mayflower_version']
	//global $mayflowerVersion;
	//global $mayflower_brand;
	//$mayflowerVersionCSS
	//mayflower_brand_css
	$mayflower_brand = $mayflower_options['mayflower_brand'];
	$mayflower_brand_css = "";
	if( $mayflower_brand == 'lite' ) {
		$mayflower_brand_css = "globals-lite";
	} else {
		$mayflower_brand_css = "globals-branded";
	}
	
	
	// Get Mayflower network setting values
	$network_mayflower_settings = get_site_option( 'globals_network_settings' );
	//$mayflower_version = $network_mayflower_settings['mayflower_version']; 
	$globals_version = $network_mayflower_settings['globals_version']; 
	$globals_path = $network_mayflower_settings['globals_path']; 
	$globals_path_over_http = $globals_path;
	if (empty($globals_path)) {
		$globals_path_over_http = "/g/2/";
	}

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
/*
	Cron Job for RaveAlert. Cron runs the functions located in alertnotification.php file.
*/	
	
	add_filter('cron_schedules', 'new_interval');

// add once 1 minute interval to wp schedules
function new_interval($interval) {

    $interval['minutes_1'] = array('interval' => 1*60, 'display' => 'Once 1 minutes');

    return $interval;
}
add_action( 'my_cron', 'myCronFunction' );
//error_log("WP functions file running");
//function my_activation() {
	if ( ! wp_next_scheduled( 'my_cron' ) ) {
	  wp_schedule_event( time(), 'minutes_1', 'my_cron' );
	}
	else
	{
		//error_log("my cron is already scheduled");
	}
	wp_cron();
	
	
	
	
	
	
/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'add_global_section_meta_box' );
add_action( 'load-post-new.php', 'add_global_section_meta_box' );

/////////////////////////
// Custom Meta Boxes
/////////////////////////



/* Adds a box to the main column on the Post and Page edit screens */
function add_global_section_meta_box() { 
	global $post; 
	if ( is_main_site()) {
		if ( ! empty($post) && is_a($post, 'WP_Post') ) {
			if ("0" == $post->post_parent){
			//if (intval($post->post_parent)>0) {			
				$screens = array('page');
				foreach ($screens as $screen) {
					add_meta_box(
						'global_section_meta_box',
						'College Navigation Area',
						'global_section_meta_box',
						$screen,
						'normal',
						'low'
					);
				}
			}
		}
	}
}

add_action('add_meta_boxes', 'add_global_section_meta_box');


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
				switch($field['type']) {
					// case items will go here

					// text
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

?>