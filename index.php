<?php get_header();

//Which template to use
if ( is_multisite_home () ) {
	//Is BC Home page
	get_template_part('template-front-page');
} else {
	// Layout
	get_template_part('layout');
}

get_footer(); ?>