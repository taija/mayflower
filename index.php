<?php get_header(); ?>

	<?php
		$mayflower_options = mayflower_get_options();
		$current_layout = $mayflower_options['default_layout'];

		 //echo do_shortcode('[AllClassInformation course="ECON"]');
		 //echo do_shortcode('[OneClassInformation course="ABE" number="042"]');
	?>
		<?php
				// Sidebar Layout
				if ( $current_layout == 'content-sidebar' || $current_layout == 'sidebar-content' ) {
				get_template_part('layout-sidebar');
			}
				// No Sidebar Layout - Just Content
				else { 
				get_template_part('layout-content');
				}
		 ?>
<?php get_footer(); ?>