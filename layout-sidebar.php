	<div id="content-wrap" class="row">
		<div class="span12">
				<?php get_template_part('part-featured-full'); ?>

						<div class="row">
						<?php
							$mayflower_options = mayflower_get_options();
							$current_layout = $mayflower_options['default_layout'];
								if ( $current_layout == 'sidebar-content' ) {
									get_sidebar();
								} else {};
						?>

							<div class="span9">

								    <?php $mayflower_options = mayflower_get_options();
									    if( $mayflower_options['slider_toggle'] == 'true' ) { ?>

											<?php $mayflower_options = mayflower_get_options();
											if ( $mayflower_options['slider_layout'] == 'featured-in-content' ) { ?>

												<?php get_template_part('part-featured-in-content'); ?>

											<?php } else  { } ?>

									<?php } else  { } ?>

									<?php
										// If we are loading the Blog home page (home.php)
											if ( is_home() ) {
											get_template_part('part-home');
									}
										// If we are loading the staff page template
											else if ( is_page_template('page-staff.php') ) {
											get_template_part('part-staff');
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

											<div id="content">
												<div class="content-padding">

												<?php $my_block = get_the_block('Jumpy'); ?>
													<?php if ( is_active_sidebar( 'aside-widget-area' )  || $my_block != '')  { ?>
															<div class="row">
																<div class="span2 aside-border-left pull-right">
																	<div id="feature">
	
																				<?php // Multi-Content Block Code ?>
																				<?php the_block('Jumpy'); ?>
	
																				<?php // Global Widget Area ?>
																				<?php dynamic_sidebar( 'aside-widget-area' ); ?>
	
																	</div><!-- feature -->
																</div><!-- span2 -->
	
																<div class="span9">
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
																</div><!-- span9 -->
															</div><!-- row -->

												<?php } else {  ?>
													<div id="content">
														<div class="content-padding">
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
												<?php }; ?> 

												<?php
													get_template_part('part-blogroll');
												?>

											<?php endwhile; else: ?>
											<p><?php _e('Sorry, these aren\'t the bytes you are looking for.'); ?></p>
											<?php endif; ?>

									<?php } ?>
										</div><!-- content-padding -->
									</div><!-- #content -->
								<?php
									$mayflower_options = mayflower_get_options();
									$current_layout = $mayflower_options['default_layout'];
										if ( $current_layout == 'content-sidebar' ) {
											get_sidebar();
										} else {};
								?>
							</div><!-- span9 -->
		</div><!-- row -->
	</div><!-- span12 -->
</div><!-- #content-wrap .row -->