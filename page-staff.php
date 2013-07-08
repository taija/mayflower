<?php
/*
Template Name: Staff Page
*/
?>

<?php get_header(); ?>

	<?php
		$mayflower_options = mayflower_get_options();
		$default_layout = $mayflower_options['default_layout'];
	?>

		<?php
				// Sidebar Right
				if ( $default_layout == 'content-sidebar' ) {
				get_template_part('layout-content-sidebar');
			}
				// No Sidebar
				else if ($default_layout == 'content') {
				get_template_part('layout-content');
			}
				// Sidebar Left
				else  {
				get_template_part('layout-sidebar-content');

				}
		 ?>

<?php get_footer(); ?>