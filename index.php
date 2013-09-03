<?php get_header(); 

$mayflower_options = mayflower_get_options();
$current_layout = $mayflower_options['default_layout'];

 //echo do_shortcode('[AllClassInformation course="ECON"]');
 //echo do_shortcode('[OneClassInformation course="ABE" number="042"]');


//Which template to use
if ( is_main_site() && is_front_page() ) {
	//Is BC Home page
	get_template_part('template-front-page');
} else if ( $current_layout == 'content-sidebar' || $current_layout == 'sidebar-content' ) {
	//Sidebar layout
	get_template_part('layout-sidebar');
} else { 
	//No sidebar layout
	get_template_part('layout-content');
}
		 
get_footer(); ?>