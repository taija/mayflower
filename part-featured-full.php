<?php if ( is_front_page() ) {

	    $mayflower_options = mayflower_get_options();
	    if( $mayflower_options['slider_toggle'] === true && $mayflower_options['slider_layout'] === 'featured-full') { ?>

					<div id="myCarousel" class="carousel slide full">

						<ol class="carousel-indicators">
							<?php
								$number = 0;
								$the_query = new WP_Query(array(
									'post_type'=>'slider',
									'posts_per_page' => ($mayflower_options['slider_number_slides'] ), 
								));
								while ( $the_query->have_posts() ) :
								$the_query->the_post();
								?>
						<li data-target="#myCarousel" data-slide-to="<?php echo $number++; ?>"></li>

						<?php endwhile; wp_reset_postdata(); ?>
						</ol>

						<div class="carousel-inner">
							<?php
							$the_query = new WP_Query(array(
								'post_type'=>'slider',
								'orderby'=> 'menu_order',
								'order'=> 'ASC',
								'posts_per_page' => 1,
							));
							while ( $the_query->have_posts() ) :
							$the_query->the_post();
							?>
	
							<div class="item active">
								<?php
							        // If url field has content, add the URL to the post thumbnail.
									$slider_ext_url = get_post_meta($post->ID, '_slider_url', true);
								        if ( !empty( $slider_ext_url ) )
									{ ?>
	
									<h2>
										<a href="<?php echo esc_url($slider_ext_url);?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('featured-full');?></a>
									</h2>
	
									<?php } else { ?>
	
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured-full');?></a>
								<?php	} //end else ?>
	
							<?php
								//should we show title & excerpt?
								$mayflower_options = mayflower_get_options();
									if ($mayflower_options['slider_title'] == 'true' || $mayflower_options['slider_excerpt'] == 'true' ) { ?>
	
	
									<div class="carousel-caption">
										<?php
											if ($mayflower_options['slider_title'] == 'true') {
										        // If a post class has input, sanitize it and add it to the post class array.
												$slider_ext_url = get_post_meta($post->ID, '_slider_url', true);
											        if ( !empty( $slider_ext_url ) )
												{ ?>
	
												<h2>
													<a href="<?php echo esc_url($slider_ext_url);?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
												</h2>
	
												<?php } else { ?>
													<h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
	
											<?php	} //end else ?>
										<?php } else { } ?>
	
										<?php if ($mayflower_options['slider_excerpt'] == 'true' ) { ?>
											<?php the_excerpt(); ?>
										<?php } else { } ?>
	
									</div><!-- carousel-caption -->
	
							<?php } else  { } ?>
	
							</div><!-- item active -->
	
							<?php
								endwhile;
									wp_reset_postdata();
							?>
	
							<?php
								$the_query = new WP_Query(array(
									'post_type'=>'slider',
									'orderby'=> 'menu_order',
									'order'=>'ASC',
									'posts_per_page' => ($mayflower_options['slider_number_slides'] -1), // subtract 1 (-1) is here to account for the first loop.
									'offset' => 1
								));
								while ( $the_query->have_posts() ) :
								$the_query->the_post();
							?>
							<div class="item">
								<?php
							        // If a post class has input, sanitize it and add it to the post class array.
									$slider_ext_url = get_post_meta($post->ID, '_slider_url', true);
								        if ( !empty( $slider_ext_url ) )
									{ ?>
	
									<h2>
										<a href="<?php echo esc_url($slider_ext_url);?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('featured-full');?></a>
									</h2>
	
									<?php } else { ?>
	
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured-full');?></a>
								<?php	} //end else ?>
	
							<?php
								//should we show title & excerpt?
								$mayflower_options = mayflower_get_options();
									if ($mayflower_options['slider_title'] == 'true' || $mayflower_options['slider_excerpt'] == 'true' ) { ?>
	
	
									<div class="carousel-caption">
										<?php
											if ($mayflower_options['slider_title'] == 'true') {
										        // If a post class has input, sanitize it and add it to the post class array.
												$slider_ext_url = get_post_meta($post->ID, '_slider_url', true);
											        if ( !empty( $slider_ext_url ) )
												{ ?>
	
												<h2>
													<a href="<?php echo esc_url($slider_ext_url);?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
												</h2>
	
												<?php } else { ?>
													<h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
	
											<?php	} //end else ?>
										<?php } else { } ?>
	
										<?php if ($mayflower_options['slider_excerpt'] == 'true' ) { ?>
											<?php the_excerpt(); ?>
										<?php } else { } ?>
	
									</div><!-- carousel-caption -->
	
							<?php } else  { } ?>
	
							</div><!-- item -->
	
							<?php
								endwhile;
								wp_reset_postdata();
							?>
						</div><!-- carousel-inner -->
	
						<?php
							$published_posts = wp_count_posts('slider')->publish;
							if ($published_posts >1 ) { ?>
								<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
								<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
						<?php } else //don't show controls ?>
	
					</div><!-- #myCarousel -->
	

		<?php } elseif( $mayflower_options['slider_toggle'] == 'false' ) { } ?>

<?php
} else {
	// This is not a homepage so display nothing
		}
?>