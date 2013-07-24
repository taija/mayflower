	<div id="content-wrap" class="row">
		<div class="span12">

			<?php
				// If we are loading the Blog home page (home.php)
					if ( is_home() ) {
					get_template_part('part-home');
			}
				// If we are loading the staff page template
					else if ( is_page_template('page-staff.php') ) {
					get_template_part('part-staff');
			}
				// If we are loading the single-staff 
					else if ( is_single('staff') ) {
					get_template_part('part-single-staff');
			}
				// If we are loading the navigation-page page template
					else if ( is_page_template('page-nav-page.php') ) {
					get_template_part('part-nav-page');
			}
				// If we are loading the navigation-page page template
					else if ( is_single() ) {
					get_template_part('part-single');
			}
					else { ?>

						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

							<?php
								get_template_part('part-featured-full');
							?>
					<div id="content">
						<div class="content-padding">
							<?php if ( is_active_sidebar( 'aside-widget-area' ) ) : ?>
								<div class="span2 aside pull-right">
									<div id="feature">
										<div class="content-padding">

												<?php // Multi-Content Block Code ?>
												<?php the_block('Jumpy'); ?>

												<?php // Global Widget Area ?>
												<?php dynamic_sidebar( 'aside-widget-area' ); ?>

										</div><!-- content-padding -->
									</div><!-- feature -->
								</div><!-- span2 -->
							<?php endif; ?>


							<?php if($post->post_content=="") : ?>
							<!-- Don't display empty the_content or surround divs -->

							<?php else : ?>
							<!-- Do stuff when the_content has content -->
								<div class="page-content">
									<?php if (is_front_page() ) {
										//don't show the title on the home page
										} else { ?>
										<h1><?php the_title(); ?></h1>
										<?php 	}; ?>
									<?php the_content(); ?>
								</div><!-- page-content -->

							<?php endif; ?>

							<?php
								get_template_part('part-blogroll');
							?>

						<?php endwhile; else: ?>
						<p><?php _e('Sorry, these aren\'t the bytes you are looking for.'); ?></p>
						<?php endif; ?>

					</div><!-- content-padding -->
			</div><!-- #content -->
				<?php } ?>
		</div><!-- span12 -->
	</div><!-- #content-wrap  .row -->