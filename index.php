<?php get_header(); 


 //echo do_shortcode('[AllClassInformation course="ECON"]');
 //echo do_shortcode('[OneClassInformation course="ABE" number="042"]');


//Which template to use
if ( is_main_site() && is_front_page() ) {
	//Is BC Home page
	get_template_part('template-front-page');
} else { 
	// Layout
	get_template_part('layout');
}
		 
get_footer(); ?>