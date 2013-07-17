<?php get_header(); ?>
	<?php
		$mayflower_options = mayflower_get_options();
		$current_layout = $mayflower_options['default_layout'];

		 //echo do_shortcode('[AllClassInformation course="ECON"]');
		 //echo do_shortcode('[OneClassInformation course="ABE" number="042"]');
	?>

		<?php
				// Sidebar Right
				if ( $current_layout == 'content-sidebar' ) {
				get_template_part('layout-content-sidebar');
			}
				// No Sidebar
				else if ($current_layout == 'content') {
				get_template_part('layout-content');
			}
				// Sidebar Left
				else  {
				get_template_part('layout-sidebar-content');

				}

		 ?>
								<?php // Multi-Content Block Code ?>
								<?php the_block('Jumpy'); ?>
								<?php //$my_block = get_the_block('aside'); ?>
								<?php //if ($my_block == "") : ?>
									<?php //else : ?>
										<?php //echo $my_block; ?>
								<?php //endif ?>

<?php get_footer(); ?>