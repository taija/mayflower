<?php if ( is_front_page() ) { ?>
    	
    <?php
	// This is a homepage
    //Display the Featured Slider and fill the entire space above the content
	    $mayflower_options = mayflower_get_options();
	    if( $mayflower_options['blog_homepage_toggle'] === true) { ?>
			
			<div class="content-padding top-spacing30">
				<?php // Loop for sticky posts
					$sticky = get_option( 'sticky_posts' );
					$args = array(
						'post_type' => 'post',
						'order_by'=> 'date',
						'order' => 'DESC',
						'post__in'  =>  $sticky,
						'post_status' => 'publish'
						);

					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
				?>

					<?php if ( $sticky ) { ?>
						<h2 <?php post_class() ?>>
							<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
						</h2>

						<small>Date posted: <?php echo get_the_date(); ?></small>

						<div class="media">
							<?php
								if ( has_post_thumbnail() ) {
									?>
				
									 <div class="pull-left wp-caption">
										<?php
											the_post_thumbnail('medium', array('class' => 'media-object'));
												if(get_post(get_post_thumbnail_id())->post_excerpt) {
				                                    $tn_id = get_post_thumbnail_id( $post->ID );
				
				                                    $img = wp_get_attachment_image_src( $tn_id, 'medium' );
				                                    $width = $img[1];
				                                    ?>
												<p class="featured-caption media-object wp-caption-text" style="width:<?php echo $width.'px';?>"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></p>
												<?php } ?>
									 </div><!-- wp-caption -->
								<?php
									}
									else {	}
								?>

							<div class="media-body">

								<div class="media-content">
									<?php the_excerpt(); ?>
								</div><!-- media-content -->

							    <?php
								if (is_single($post)){
								?>

						        <?php
								} else {
								?>
						           <p>
										<a class="btn btn-small primary-read-more" href="<?php the_permalink(); ?>">
									Read More <i class="icon-chevron-right"></i>
							            </a>
						            </p>
						        <?php

								}
								?>
						    </div><!-- media-body -->
						</div><!-- media -->

						<hr />
					<?php } else {} ?>

				<?php endwhile;?>
				<?php wp_reset_postdata(); ?>

				<?php // Loop for posts
					$args = array(
						'post_type' => 'post',
						'order_by'=> 'date',
						'order' => 'DESC',
						'posts_per_page' => $mayflower_options['blog_number_posts'],
						'post__not_in' => get_option('sticky_posts'),
						'ignore_sticky_posts' => 1,
						'post_status' => 'publish'
						);

					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
				?>
				     <?php 
				
					if ( !get_post_format()) {
				               get_template_part('format', 'standard');
			         } else {
				               get_template_part('format', get_post_format());
				          }
					?>
				<?php endwhile; ?>
				<?php	wp_reset_postdata(); ?>
			</div><!-- content-padding top-spacing30 -->
		<?php } elseif( $mayflower_options['blog_homepage_toggle'] == 'false' ) { ?>

		<?php } // end if show nothing ?>
<?php
} else {
	// This is not a homepage so display nothing
		}
?>