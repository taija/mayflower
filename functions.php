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
require( get_template_directory() . '/inc/functions/options-admin.php');
require( get_template_directory() . '/inc/functions/options.php');
require( get_template_directory() . '/inc/functions/options-customizer.php' );
require( get_template_directory() . '/inc/functions/network-options.php');
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
    add_editor_style( 'css/custom-editor-style.css' );
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
	if ( mayflower_is_blog() ) {
		if (    is_active_sidebar( 'top-global-widget-area' ) ||
				is_active_sidebar( 'blog-widget-area' ) ||
				is_active_sidebar( 'global-widget-area' ) ) {
			return true;
		} else {
			return false;
		}
	} else {
		if (    is_active_sidebar( 'top-global-widget-area' ) ||
				is_active_sidebar( 'page-widget-area' ) ||
				is_active_sidebar( 'global-widget-area' ) ) {
			return true;
		} else {
			return false;
		}
	}
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
	wp_enqueue_script( 'globals', $globals_url . 'j/g.js', array('jquery'), $globals_version, true );
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
        $network_mayflower_settings = get_site_option( 'globals_network_settings' );
        $globals_google_analytics_code = $network_mayflower_settings['globals_google_analytics_code'];
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

/**
 * Filter Image Caption Shortcode to remove width
 *
 * Unfortionatly this whole functionality set had to be duplicated from core,
 * as I was unable to get the img_caption_shortcode_width filter to function.
 */
add_filter('img_caption_shortcode','fix_img_caption_shortcode_inline_style',10,3);

function fix_img_caption_shortcode_inline_style( $output,$attr,$content ) {
	$atts = shortcode_atts( array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => '',
		'class'   => '',
	), $attr, 'caption' );

	$atts['width'] = (int) $atts['width'];
	if ( $atts['width'] < 1 || empty( $atts['caption'] ) )
		return $content;

	if ( ! empty( $atts['id'] ) )
		$atts['id'] = 'id="' . esc_attr( sanitize_html_class( $atts['id'] ) ) . '" ';

	$class = trim( 'wp-caption ' . $atts['align'] . ' ' . $atts['class'] );

	$html5 = current_theme_supports( 'html5', 'caption' );
	// HTML5 captions never added the extra 10px to the image width
	$width = $html5 ? $atts['width'] : ( 10 + $atts['width'] );

	$caption_width = apply_filters( 'img_caption_shortcode_width', $width, $atts, $content );
		$style = '';
		if ( $caption_width )
			$style = ''; // This is the only change from WP Core! This has been removed

			$html = '';
			if ( $html5 ) {
				$html = '<figure ' . $atts['id'] . $style . 'class="' . esc_attr( $class ) . '">'
					. do_shortcode( $content ) . '<figcaption class="wp-caption-text">' . $atts['caption'] . '</figcaption></figure>';
			} else {
				$html = '<div ' . $atts['id'] . $style . 'class="' . esc_attr( $class ) . '">'
					. do_shortcode( $content ) . '<p class="wp-caption-text">' . $atts['caption'] . '</p></div>';
			}

	return $html;
}
