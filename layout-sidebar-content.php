<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="row">

	<?php
		get_template_part('part-featured-full');
	?>

	<div class="span12">
		<div class="row">
			<div class="span9 pull-right">
				<div class="row">
				    <?php
					    $mayflower_options = mayflower_get_options();
					    if( $mayflower_options['slider_toggle'] == 'true' ) { ?>


							<?php
					    $mayflower_options = mayflower_get_options();
							if ( $mayflower_options['slider_layout'] == 'featured-in-content' ) { ?>
							<div class="span9">
							<?php
								get_template_part('part-featured-in-content');
							?>

							<?php if ( 'staff' == get_post_type() ) {
								get_template_part('part-staff');

							} ?>

							</div><!-- span9 -->
							<?php } else  { } ?>

					<?php } elseif( $mayflower_options['slider_toggle'] == 'false' ) {
						  } // end elseif  ?>


					<div class="span3 pull-right aside-border-left">
						<div id="feature">
							<div class="content-padding-left-right">
								<?php // Multi-Content Block Code ?>
								<?php the_block('Jumpy'); ?>
								<?php //$my_block = get_the_block('aside'); ?>
								<?php //if ($my_block == "") : ?>
									<?php //else : ?>
										<?php //echo $my_block; ?>
								<?php //endif ?>
								<?php // Global Widget Area ?>
								<?php dynamic_sidebar( 'aside-widget-area' ); ?>
							</div><!-- content-padding-left-right -->
						</div><!-- feature -->
					</div><!-- span3 -->

					<div class="span6">
						<div class="content-padding-right">
							<div class="page-content">
								<h1><?php the_title(); ?></h1>
								<?php the_content(); ?>
							</div><!-- page-content -->

							<?php
								get_template_part('part-blogroll');
							?>


						<?php endwhile; else: ?>
						<p><?php _e('Sorry, these aren\'t the bytes you are looking for.'); ?></p>
						<?php endif; ?>
						</div><!-- content-padding-left-right -->
					</div><!-- span6 -->
				</div><!-- row -->
			</div><!-- span9 -->

			<?php get_sidebar(); // sidebar 1 ?>

		</div><!-- row -->
	</div><!-- span12 -->
</div><!-- row -->