<?php if ( is_front_page() ) {
	?>
    	<div class="content-padding top-spacing30">
    <?php
	// This is a homepage
    //Display the Featured Slider and fill the entire space above the content
	    $mayflower_options = mayflower_get_options();
	    if( $mayflower_options['blog_homepage_toggle'] === true) { ?>

				<?php // Loop for posts
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

					<?php

						if ( $sticky ) {
							// insert here your stuff…
							?>
						<h2 <?php post_class() ?>>
							<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
						</h2>

						<small>Date posted: <?php echo get_the_date(); ?></small>


						<div class="media">
						    <a class="pull-left" href="<?php the_permalink(); ?>">
							<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail('thumbnail', array('class' => 'media-object'));
										if(get_post(get_post_thumbnail_id())->post_excerpt) { ?>
											<span class="featured-caption media-object"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></span>
										<?php } ?>
							<?php

								}
								else {

								}
							?>

							    </a>

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
					<h2 <?php post_class() ?>>
						<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
					</h2>
					
					<small>Date posted: <?php echo get_the_date(); ?></small>


						<div class="media">
						    <a class="pull-left" href="<?php the_permalink(); ?>">
							<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail('thumbnail', array('class' => 'media-object'));
										if(get_post(get_post_thumbnail_id())->post_excerpt) { ?>
											<span class="featured-caption media-object"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></span>
										<?php } ?>
							<?php

								}
								else {
									//echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/img/thumbnail-default.png" />';
								}
							?>

							    </a>

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
				<?php endwhile; ?>
				<?php	wp_reset_postdata(); ?>

			</div><!--.content-padding-->
		<?php } elseif( $mayflower_options['blog_homepage_toggle'] == 'false' ) { ?>

		<?php } // end if show nothing ?>
<?php
} else {
	// This is not a homepage so display nothing
		}
?>