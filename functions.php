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
			require( get_template_directory() . '/inc/functions/options-admin.php');
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
        $gaCode = "";

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
/*
function mayflower_remove_meta_boxes() {
  remove_meta_box('postimagediv', 'page', 'side');
}
add_action( 'do_meta_boxes', 'mayflower_remove_meta_boxes' );
*/

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
				add_image_size( 'featured-full', 1170,488,true);
				add_image_size( 'featured-in-content', 900,375,true);
				add_image_size( 'home-small-ad', 300,200,true);
	}

/* custom header support */
$header_args = array(
    'default-image'	=> '',
    'width'			=> 690,
    'height'		=> 100,
		//'flex-width'	=> true,
		'flex-height'	=> true,
    'header-text'	=> false

);
add_theme_support( 'custom-header', $header_args );

/* Post format support */
add_theme_support( 'post-formats', array( 'video' ) );

/* Let Tabs Shortcode plugin use bootstrap styles*/
add_theme_support( 'tabs', 'twitter-bootstrap' );

######################################
// Customize Excerpt Read More
######################################

function new_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink() . '">' . __('...more about ', 'your-text-domain') . get_the_title() . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );


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
    add_editor_style( 'custom-editor-style.css' );
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
function my_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );


//Add custom styles to tinymce editor
function my_mce_before_init( $settings ) {

    $style_formats = array(
		array(
			'title' => 'Alert',
            'selector' => 'p',
			'classes' => 'alert alert-warning',
		),
		array(
			'title' => 'Alert-Danger',
			'selector' => 'p',
			'classes' => 'alert alert-error alert-danger',
		),
		array(
			'title' => 'Alert-Info',
			'selector' => 'p',
			'classes' => 'alert alert-info',
		),
		array(
			'title' => 'Alert-Success',
			'selector' => 'p',
			'classes' => 'alert alert-success',
		),
/*
		array(
			'title' => 'Button-Black',
			'inline' => 'button',
			'classes' => 'btn btn-inverse',
			'wrapper' => false,
		),
		array(
			'title' => 'Button-Blue',
			'inline' => 'button',
			'classes' => 'btn btn-primary',
			'wrapper' => false,
		),
		array(
			'title' => 'Button-Grey',
			'inline' => 'button',
			//'selector' => 'a',
			'classes' => 'btn',
			'wrapper' => false,
		),
*/
		array(
			'title' => 'Well',
			'selector' => 'p',
			'classes' => 'well',
			'wrapper' => false,
		),
    );


    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}

add_filter( 'tiny_mce_before_init', 'my_mce_before_init' );


#############################
// Add *_is_blog function
#############################

function mayflower_is_blog () {
	if (is_home() || is_archive() || is_singular('post') || is_post_type_archive( 'post' )) return true; else return false;
}

#############################
// Add is_multisite_home
#############################

function is_multisite_home () {
	if (is_main_site() && is_front_page()) return true; else return false;
}


######################################
// Wordpress Widget Area Setup
######################################

	function mayflower_widgets_init() {

		// Top Global Widget Area - located just below the sidebar nav.
		register_sidebar( array(
			'name' => __( 'Top Global Sidebar Widget Area', 'mayflower' ),
			'id' => 'top-global-widget-area',
			'description' => __( 'This is the top global widget area. Items will appear on all pages throughout the web site.', 'mayflower' ),
			'before_widget' => '<div class="wp-widget wp-widget-global %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title content-padding">',
			'after_title' => '</h2>',
		) );

		// Static Page Widget Area - located just below the global nav on static pages.
		register_sidebar( array(
			'name' => __( 'Static Page Sidebar Widget Area', 'mayflower' ),
			'id' => 'page-widget-area',
			'description' => __( 'This is the static page widget area. Items will appear on all static pages.', 'mayflower' ),
			'before_widget' => '<div class="wp-widget wp-widget-static %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title content-padding">',
			'after_title' => '</h2>',
		) );

		// Blog Widget Area - located just below the global nav on blog pages.
		register_sidebar( array(
			'name' => __( 'Blog Sidebar Widget Area', 'mayflower' ),
			'id' => 'blog-widget-area',
			'description' => __( 'This is the blog widget area. Items will appear on all blog related pages.', 'mayflower' ),
			'before_widget' => '<div class="wp-widget wp-widget-blog %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title content-padding">',
			'after_title' => '</h2>',
		) );

		// Bottom Global Widget Area - located just below the sidebar nav.
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

	/** Register sidebars by running mayflower_widgets_init() on the widgets_init hook. */
	add_action( 'widgets_init', 'mayflower_widgets_init' );


function widget_empty_title($output='') {

    if ($output == '&nbsp') {
        return '';
    }
    return $output;
}
add_filter('widget_title', 'widget_empty_title');

############################################
//Customize widget areas for certain pages
############################################
/*
add_filter( 'sidebars_widgets', 'control_widget_pages' );

function control_widget_pages( $sidebars_widgets ) {

	if(is_home() || is_single() )

		$sidebars_widgets['page-widget-area'] = false;

	return $sidebars_widgets;
}
*/

#########################
//set globals path
#########################

	$network_mayflower_settings = get_site_option( 'globals_network_settings' );
	$globals_path = $network_mayflower_settings['globals_path'];
	if (empty($globals_path)) {
		$globals_path =  $_SERVER['DOCUMENT_ROOT'] . "/g/2/";
	}

	$bc_globals_html_filepath = $globals_path . "h/";

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
     if( in_array('current-menu-item', $classes) || in_array('current-page-ancestor', $classes)){
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

function mayflower_scripts() {
	global $globals_url, $globals_version;

	wp_enqueue_style( 'gobals', $globals_url . 'c/g.css', null, $globals_version, 'screen' );
	wp_enqueue_style( 'gobals-print', $globals_url . 'c/p.css', null, $globals_version, 'print' );
	wp_enqueue_style( 'mayflower', get_stylesheet_uri());

	// These go first- modernizr and respond.js
	wp_enqueue_script( 'gobals-head', $globals_url . 'j/ghead.js', $globals_version, null, false );

	// Wrap script in IE conditional- from http://stackoverflow.com/a/16221114
	wp_enqueue_script( 'respond', $globals_url . 'j/respond.js', null, $globals_version, false );
	add_filter( 'script_loader_tag', function( $tag, $handle ) {
		if ( $handle === 'respond' ) {
			$tag = "<!--[if lt IE 9]>$tag<![endif]-->";
		}
		return $tag;
	}, 10, 2 );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap', $globals_url . 'j/bootstrap.min.js', array('jquery'), $globals_version, true );
	wp_enqueue_script( 'globals', $globals_url . 'j/g.js', array('jquery'), $globals_version, true );
}

add_action( 'wp_enqueue_scripts', 'mayflower_scripts' );




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

####################################################
## Add Course Description Shortcode Button & Modal
####################################################

add_action('media_buttons', 'add_shortcode_button', 99);

function add_shortcode_button() {
            echo '<a href="#TB_inline?width=480&inlineId=select_form" class="thickbox button" id="add_course" title="' . __("Add Course", 'mayflower') . '"><span class="dashicons dashicons-welcome-learn-more"></span> ' . __("Add Course", "mayflower") . '</a>';
        }
function add_coursedesc_popup() {

        ?>
        <script>
            function InsertCourse(){
                var subject = jQuery("#add_subject").val();
                if(subject == ""){
                    alert("<?php _e("Please select a subject", "mayflower") ?>");
                    return;
                }
                var courseID = jQuery("#add_course_id").val();
                if(courseID == ""){
                    alert("<?php _e("Please select a course", "mayflower") ?>");
                    return;
                }

                var subject_select = jQuery("#add_subject option[value='" + subject + "']").text().replace(/[\[\]]/g, '');
                var display_course_description = jQuery("#display_course_description").is(":checked");
                var description_qs = !display_course_description ? " description=\"false\"" : " description=\"true\"";

                window.send_to_editor("[coursedescription subject=\"" + subject + "\" courseid=\"" + courseID + "\"" + description_qs + "]");
            }
            jQuery(document.body).on('change','#add_subject',function(){
                //alert('Change Happened');
                var selectedSubject = jQuery('#add_subject :selected').text();
                var selectedSubject = jQuery.trim(selectedSubject);
                var data = {
                                action: 'get_course',
                                subject: selectedSubject
                           };
                jQuery.post(ajaxurl,data,function(response){
                    //alert('Got this from the server: ' + response);
                    if(response)
                    {
                        try{
                            var json = JSON.parse(response);
                           // alert(json.Courses);
                            var courses = json.Courses;
                            var el = jQuery("#add_course_id");
                            if(courses.length>0)
                            {
                                el.empty();
                                jQuery("#add_course_id").append("<option value=''>Select Course</option>");
                            }

                            for(var i=0;i < courses.length;i++)
                            {
                                //alert(courses[i].CourseID);
                                jQuery("#add_course_id").append("<option value='"+courses[i].CourseID+"'>"+courses[i].CourseID+"</option>")
                            }
                        }catch(e){
                            alert("Error:",e);
                        }
                    }

                });
            });
		</script>

        <div id="select_form" style="display:none;">
            <div class="wrap">
                <div>
                    <div style="padding:15px 15px 0 15px;">
                        <h3 style="color:#5A5A5A!important; font-family:Georgia,Times New Roman,Times,serif!important; font-size:1.8em!important; font-weight:normal!important;"><?php _e("Insert a course", "mayflower"); ?></h3>
                        <span>
                            <?php _e("Select a subject to add it to your post or page.", "mayflower"); ?>
                        </span>
                    </div>
                    <div style="padding:15px 15px 0 15px;">

                        <select id="add_subject">
                            <option value="">  <?php _e("Select Subject", "mayflower"); ?>  </option>
								<?php
								$json_subjects_url = "http://www.bellevuecollege.edu/classes/Api/Subjects?format=json";
								//$json = file_get_contents($json_subjects_url,0,null,null);
                                $json = wp_remote_get($json_subjects_url);
                                if(!empty($json) && !empty($json['body']))
                                {
                                    $links = json_decode($json['body'], TRUE);
                                    ?>
                                    <?php
                                    //error_log("links :". $links);
                                        foreach($links as $key=>$val){
                                    ?>
                                        <option>
                                            <?php echo trim($val['Slug']); ?>
                                        </option>
                                <?php
                                        }
                                }
								?>
                        </select> <br/>
                        <select id="add_course_id">
                            <option value="">  <?php _e("Select Course", "mayflower"); ?>  </option>
                        </select>
                    </div>
                    <div style="padding:15px 15px 0 15px;">
                        <input type="checkbox" id="display_course_description"  /> <label for="display_course_description"><?php _e("Display course description", "mayflower"); ?></label>
                    </div>
                    <div style="padding:15px;">
                        <input type="button" class="button-primary" value="<?php _e("Insert course", "mayflower"); ?>" onclick="InsertCourse();"/>&nbsp;&nbsp;&nbsp;
                    <a class="button" style="color:#bbb;" href="#" onclick="tb_remove(); return false;"><?php _e("Cancel", "mayflower"); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }


add_action('admin_footer',  'add_coursedesc_popup');

/*
 * Ajax call to get courses
 * */
add_action('wp_ajax_get_course','get_course_callback');

function get_course_callback() {
    $subject = $_POST['subject'];
    $json_subjects_url = "http://www.bellevuecollege.edu/classes/All/".$subject."?format=json";
    $json = wp_remote_get($json_subjects_url);
    //$json = file_get_contents($json_subjects_url,0,null,null);
    //$links = json_decode($json, TRUE);
    if(!empty($json) && !empty($json['body']))
    {
        echo $json['body'];
    }
    die();
}

add_shortcode('coursedescription', 'coursedescription_func' );

function coursedescription_func($atts)
{
      $subject = $atts["subject"];
      $course = $atts["courseid"];// Attribute name should always read in lower case.
    $description = $atts["description"];
    //error_log("Hello". $subject);
    //error_log("Hello2". $course);
    if(!empty($course) && !empty($subject))
    {
        //error_log("course :".$course);
        $course_split = explode(" ",$course);
        $course_letter = $course_split[0];
        $course_id = $course_split[1];
        $subject = trim(html_entity_decode  ($subject));
        $url = "http://www.bellevuecollege.edu/classes/All/".$subject."?format=json";
        //error_log("url :".$url);
        //$json = file_get_contents($url,0,null,null);
        $json = wp_remote_get($url);
		// error_log("json :".$json);
        if(!empty($json) && !empty($json['body']))
        {
		    $html = decodejsonClassInfo($json['body'],$course_id,$description);
            return $html;
        }
    }
    return null;
}


	#################################
	/*
		This function is a shortcode to get class schedule data returned as json string for a given course name or a course name and number.
		Fogbugz #2154
	*/
	#################################
/*
	function AllClassInformationRoutine($args)
	{
		$course = trim($args["course"]);
		if(!empty($course))
		{
			$url = CLASSESURL.$course."?format=json";
			//$json = file_get_contents($url,0,null,null);
            $json = wp_remote_get($url);
            if(!empty($json) && !empty($json['body']))
            {
                $html = decodejsonClassInfo($json);
                return $html;
            }
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
			//$json = file_get_contents($url,0,null,null);
            $json = wp_remote_get($url);
            if(!empty($json) && !empty($json['body']))
            {
                $html = decodejsonClassInfo($json,$number);
                return $html;
            }

		}
		return null;
	}
add_shortcode('AllClassInformation', 'AllClassInformationRoutine');
add_shortcode('OneClassInformation', 'OneClassInformationRoutine');
*/

	function decodejsonClassInfo($jsonString,$number = NULL,$description = NULL)
	{
		$decodeJson = json_decode($jsonString,true);
		$htmlString = "";
		$courses = $decodeJson["Courses"];
		$htmlString .= "<div class='classDescriptions'>";
        //error_log("number :".$number);
        if(count($courses)>0)
        {
            foreach($courses as $sections)
            {
                if($number!=null)
                {
                    if($sections["Number"] == $number)
                    {
                        //error_log("$$$$$$$$$$$$$$$$$$$$$$$");
                        $htmlString .= getHtmlForCourse($sections,$description);
                    }
                }
                else
                {
                    $htmlString .= getHtmlForCourse($sections,$description);
                }
            }
        }
		$htmlString .= "</div>"; //classDescriptions

		return $htmlString;
	}


	function getHtmlForCourse($sections,$description = NULL)
	{
		$htmlString = "";
		$htmlString .= "<div class='class-info'>";
		$htmlString .= "<h5 class='class-heading'>";
			$courseUrl = CLASSESURL.$sections["Subject"];
			if($sections["IsCommonCourse"])
			{
				$courseUrl .= "&";
			}
			$courseUrl .= "/".$sections["Number"];

			$htmlString .= "<a href='".$courseUrl."''>";
			$htmlString .= "<span class='course-id'>".$sections["Descriptions"][0]["CourseID"]."</span>";
			$htmlString .= " <span class='course-title'>".$sections["Title"]."</span>";
			$htmlString .= "<span class='course-credits'> &#8226; ";

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
			$htmlString .= "</h5>";//classHeading
        //error_log("description:".$description);
        if($description=="true" && !empty($sections["Descriptions"]))
        {
            //error_log("Not here");
			$htmlString .= "<p class='class-description'>" . $sections["Descriptions"][0]["Description"] . "</p>";
			$htmlString .= "<p class='class-details-link'>";
			$htmlString .= "<a href='".$courseUrl."'>View details for ".$sections["Descriptions"][0]["CourseID"]."</a>";
			$htmlString .= "</p>";
        }
			$htmlString .= "</div>"; //classInfo
			return $htmlString;
	}



	$mayflower_brand = $mayflower_options['mayflower_brand'];
	$mayflower_brand_css = "";
	if( $mayflower_brand == 'lite' ) {
		$mayflower_brand_css = "globals-lite";
	} else {
		$mayflower_brand_css = "globals-branded";
	}

	// Get Mayflower network setting values
	$network_mayflower_settings = get_site_option( 'globals_network_settings' );
	$globals_version = $network_mayflower_settings['globals_version'];
	$globals_path = $network_mayflower_settings['globals_path'];
	$globals_url = $network_mayflower_settings['globals_url'];
	$globals_path_over_http = $globals_url;
    $globals_google_analytics_code = $network_mayflower_settings['globals_google_analytics_code'];

	if (empty($globals_url)) {
		$globals_url = "/g/2/";
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
    //error_log("GOOGLE ANALYTICS");
    if(is_user_logged_in())
    {
        $network_mayflower_settings = get_site_option( 'globals_network_settings' );
        $globals_google_analytics_code = $network_mayflower_settings['globals_google_analytics_code'];
        //error_log("google analytics code :".$globals_google_analytics_code);
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

##########################
//analytics for lite, branded and single site
##########################

function mayflower_analytics () {
    global $bc_globals_html_filepath, $mayflower_brand;
    $bc_gacode_lite =  $bc_globals_html_filepath . "galite.html";
    $bc_gacode_branded =  $bc_globals_html_filepath . "gabranded.html";
    if( $mayflower_brand == 'lite') {
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
    <?php
    } // end if


} // end function
add_action('wp_head', 'mayflower_analytics', 30);

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

?>
