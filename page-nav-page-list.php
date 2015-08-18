<?php
/**
 * Template Name: Navigation Page (List)
 */
?>
<?php get_header(); ?>
<?php
/**
 * Load Variables
 *
 */
global $mayflower_brand;
$mayflower_options = mayflower_get_options();
$current_layout = $mayflower_options['default_layout'];
?>

<div id="content" <?php if ( $mayflower_brand == 'branded' ) {?> class="box-shadow"<?php } ?>>

	<div class="row row-padding">

		<?php if ( has_active_sidebar() ) : ?>
			<div class="col-md-9 <?php  if ( $current_layout == 'sidebar-content' ) { ?>col-md-push-3<?php } ?>">
		<?php endif; ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<div class="content-padding">
					<h1><?php the_title(); ?></h1>

					<?php if($post->post_content=="") : ?>
					<!-- Don't display empty the_content or surround divs -->

					<?php else : ?>
					<!-- Do stuff when the_content has content -->

								<?php the_content(); ?>
					<?php endif; ?>
						<?php
							endwhile;
							wp_reset_postdata();
						?>
					</div><!-- content-padding -->

					<div class="content-padding nav-page nav-page-list">

						<?php
							$args = array(
								'post_type' => 'page',
								'posts_per_page' => -1,
								'order' => 'ASC',
								'orderby' => 'menu_order title',
								'post_status' => 'publish',
								'post_parent' => $post->ID
							);
							$loop = new WP_Query( $args );

							while ( $loop->have_posts() ) : $loop->the_post();
						?>

										<h2 <?php post_class() ?>>
											<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
										</h2>

										<div class="media">
											<?php
												if ( has_post_thumbnail() ) {
													?>

													 <div class="pull-left wp-caption">
														<a href="<?php the_permalink(); ?>">
															<?php
																the_post_thumbnail('thumbnail', array('class' => 'media-object')); ?>
														</a>
													 </div><!-- wp-caption -->
												<?php
													}
													else {	}
												?>

											<div class="media-body">

												<div class="media-content content-padding">
													<?php the_excerpt(); ?>
												</div><!-- media-content -->

												<?php
												if (is_single($post)){
												?>

												<?php
												} else {
												?>
												   <p>
														<!--<a class="btn btn-default btn-sm primary-read-more" href="<?php the_permalink(); ?>">
													Read More <i class="icon-chevron-right"></i>
														</a>-->
													</p>
												<?php

												}
												?>
											</div><!-- media-body -->
										</div><!-- media -->

								<?php endwhile;?>
								<?php wp_reset_postdata(); ?>

					</div><!-- content-padding .nav-page -->
		<?php if ( has_active_sidebar() ) : ?>
			</div>
			<?php get_sidebar();
		endif; ?>
	</div>

</div><!-- #content-->
<?php get_footer(); ?>
