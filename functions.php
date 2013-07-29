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
	    require( get_template_directory() . '/inc/functions/options.php');
	    require( get_template_directory() . '/inc/functions/options-customizer.php' );
	    require( get_template_directory() . '/inc/functions/network-options.php');
		require( get_template_directory() . '/inc/functions/hooks.php' );
//		require( get_template_directory() . '/inc/functions/post-custom-meta.php' );
	    require( get_template_directory() . '/inc/functions/contextual-help.php' );
		require( get_template_directory() . '/inc/functions/dynamic-css.php' );
		define("CLASSESURL","http://bellevuecollege.edu/classes/All/");
		define("PREREQUISITEURL","http://bellevuecollege.edu/enrollment/transfer/prerequisites/");


##################################
## Custom Menu Widget Override
##################################

if (include('inc/functions/custom_widgets.php')){
add_action("widgets_init", "load_custom_widgets");
}
function load_custom_widgets() {
unregister_widget("WP_Nav_Menu_Widget");
register_widget("My_Nav_Menu_Widget");
}



############################
// Custom Admin Bar Items
############################

	function mytheme_admin_bar_render() {
		global $wp_admin_bar;
	        $wp_admin_bar->add_menu( array(
	        'parent' => '',
	        'id' => 'mayflower-settings',
	        'title' => __('Theme Options'),
	        'href' => admin_url( 'themes.php?page=mayflower-settings')
	    ) );

	}

	add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );


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

	// Social Links
	if( file_exists(get_template_directory() . '/inc/mayflower-social-links/mayflower_social_links.php') )
	    require( get_template_directory() . '/inc/mayflower-social-links/mayflower_social_links.php');

	//Location
	if( file_exists(get_template_directory() . '/inc/mayflower-location/mayflower-location.php') )
	    require( get_template_directory() . '/inc/mayflower-location/mayflower-location.php');

	//Multiple Content Blocks
	if( file_exists(get_template_directory() . '/inc/multiple-content-blocks-mayflower/multiple-content-blocks.php') )
	    require( get_template_directory() . '/inc/multiple-content-blocks-mayflower/multiple-content-blocks.php');


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
	}

	// Custom Menus
	if (function_exists('add_theme_support')) {
	    add_theme_support('menus');
	}

######################################
// Remove WordPress default widgets
######################################

function remove_calendar_widget() {

	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Recent_Comments');
}

add_action( 'widgets_init', 'remove_calendar_widget' );

######################################
// Wordpress Widget Area Setup
######################################

	function mayflower_widgets_init() {

		// Global Widget Area - located just below the sidebar nav.
		register_sidebar( array(
			'name' => __( 'Global Sidebar Widget Area', 'mayflower' ),
			'id' => 'global-widget-area',
			'description' => __( 'This is the global widget area. Items will appear throughout the web site.', 'mayflower' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="global-widget-area">',
			'after_title' => '</h3>',
		) );


		// Blog Widget Area - located just below the global nav on blog pages.
		register_sidebar( array(
			'name' => __( 'Blog Sidebar Widget Area', 'mayflower' ),
			'id' => 'blog-widget-area',
			'description' => __( 'This is the blog widget area. Items will appear on blog pages.', 'mayflower' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

		// Static Page Widget Area - located just below the global nav on static pages.
		register_sidebar( array(
			'name' => __( 'Static Page Sidebar Widget Area', 'mayflower' ),
			'id' => 'page-widget-area',
			'description' => __( 'This is the static page widget area. Items will appear on static pages.', 'mayflower' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

		// Aside Widget Area - aside located in right column of page content.
		register_sidebar( array(
			'name' => __( 'In-Page Aside Widget Area', 'mayflower' ),
			'id' => 'aside-widget-area',
			'description' => __( 'This is the widget area for asides in pages.', 'mayflower' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
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

	$bc_globals_themepath = $_SERVER['DOCUMENT_ROOT'] . "/globals/2.0";

#######################################
//add college head - skinny id bar
#######################################

	function bc_tophead(){
	   global $bc_globals_themepath;
	   $header_top =  $bc_globals_themepath . "/common/litehead.html";
	   //$header_menu =  $bc_globals_themepath . "/common/bc_header_menu.html";
	   //$header_bottom =  $bc_globals_themepath . "/common/bc_header_bottom_small.html";
	   include_once($header_top);
	   //include_once($header_menu);
	   //include_once($header_bottom);
	}
	add_action('btheme_header','bc_tophead');

########################################
//add college head - big html dropdown
#########################################

	function bc_tophead_big() {
		global $bc_globals_themepath;
		$header_top_big = $bc_globals_themepath . "/common/bighead.html";
		//$header_menu =  $bc_globals_themepath . "/common/bc_header_menu.html";
		//$header_bottom_big = $bc_globals_themepath . "/common/bc_header_bottom_big.html";
		include_once($header_top_big);
		//include_once($header_menu);
		//include_once($header_bottom_big);
	}

	add_action('btheme_header','bc_tophead_big');

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
// Hide Global Nav Option if Lite version is selected
###########################
/*
jQuery(document).ready( function() {
  jQuery('theme_mayflower_options[mayflower_version]').bind('change', function (e) {
    if( jQuery('theme_mayflower_options[mayflower_version]').val() == 'official') {
      jQuery('#OtherDiv').show();
    }
    else{
      jQuery('#OtherDiv').hide();
    }
  });
});
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
		global $bc_globals_themepath;
		   $bc_footer =  $bc_globals_themepath . "/common/bigfoot_content.html";
		   $bc_footerlegal =  $bc_globals_themepath . "/common/legallinks.html";
		   ?>
	       <div id="bigfoot"><?php
		   include_once($bc_footer);
		   include_once($bc_footerlegal);
		   ?>  </div><?php
	}
	add_action('btheme_footer', 'bc_footer', 50);

###################
//college legal-links footer
###################

	function bc_footer_legal() {
		global $bc_globals_themepath;
		   $bc_footerlegal =  $bc_globals_themepath . "/common/legallinks.html";
		   ?>
	       <div id="bigfoot"><?php
		   include_once($bc_footerlegal);
		   ?>  </div><!-- #bigfoot --><?php
	}
	add_action('btheme_footer', 'bc_footer_legal', 50);


###################
//college footer analytics
###################

	function mayflower_analytics() {
	?>
	        <script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
			</script>


			<script type="text/javascript">
			/*multisite test setup*/
			try {
			var altpageTracker = _gat._getTracker("UA-17566683-1");
			altpageTracker._setDomainName(".bellevuecollege.edu");
			altpageTracker._setAllowLinker(true);
			altpageTracker._setAllowHash(false);
			altpageTracker._trackPageview();
			} catch (err) { }

			/*juse depts.bellevuecollege.edu*/
			try {
			var deptspageTracker = _gat._getTracker("UA-3966899-5");
			deptspageTracker._setDomainName(".bellevuecollege.edu");
			deptspageTracker._setAllowLinker(true);
			deptspageTracker._setAllowHash(false);
			deptspageTracker._trackPageview();
			} catch (err) { }


			</script>

	<?php
	}
	add_action('wp_footer', 'mayflower_analytics', 30);

##########################
//site specific analytics
##########################

	function mayflower_sitespecific_analytics () {
		$mayflower_options = mayflower_get_options();

		if ($mayflower_options['ga_code']) {

	 ?>

		<script type="text/javascript">
			/*Site-Specific GA code*/
			try {
			var sitepageTracker = _gat._getTracker("<?php echo $mayflower_options['ga_code'] ?>");
			sitepageTracker._setDomainName(".bellevuecollege.edu");
			sitepageTracker._setAllowLinker(true);
			sitepageTracker._setAllowHash(false);
			sitepageTracker._trackPageview();
			} catch (err) { }
		</script>
		<?php } // end if


	} // end function
	add_action('wp_footer', 'mayflower_sitespecific_analytics', 30);



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
	?>

	<?php
	#########################
	//
	########################

	class description_walker extends Walker_Nav_Menu {
	      function start_el(&$output, $item, $depth, $args)
	      {
	           global $wp_query;
	           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

	           $class_names = $value = '';

	           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

	           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
	           $class_names = ' class="'. esc_attr( $class_names ) . '"';

	           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

	           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

	           $prepend = '<div class="top sans">';
	           $append = '</div>';
	           $description  = ! empty( $item->title ) ? '<div class="bottom">'.esc_attr( $item->attr_title ).'</div>' : '';

	           if($depth != 0)
	           {
	                     $description = $append = $prepend = "";
	           }

	            $item_output = $args->before;
	            $item_output .= '<a'. $attributes .'>';
	            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
	            $item_output .= $description.$args->link_after;
	            $item_output .= '</a>';
	            $item_output .= $args->after;

	            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}

			function start_lvl(&$output, $depth) {
			    $indent = str_repeat("\t", $depth);
			    $output .= "\n$indent<ul class=\"nav nav-list\">\n";
			}
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

?>