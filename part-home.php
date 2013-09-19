<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$sticky = get_option( 'sticky_posts' );
					$args = array(
					  'paged' => $paged,
					  'ignore_sticky_posts' =>1,
					  'orderby' => 'date',
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
					<div class="content-padding">
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
				</div><!-- content-padding -->

				<?php endwhile;?>
				<?php wp_reset_postdata(); ?>

				<?php // Loop for posts
					$args = array(
						'post_type' => 'post',
						'order_by'=> 'date',
						'order' => 'DESC',
						'post__not_in' => get_option('sticky_posts'),
						'ignore_sticky_posts' => 1,
						'post_status' => 'publish'
						);

					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
				?>
				<div class="content-padding">
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
					</div><!-- content-padding -->
				<?php endwhile; ?>
					<ul class="pager content-padding">
						<li>
							<?php previous_posts_link('<i class="icon-chevron-left"></i> Previous Page'); ?>
						</li>
						<li>
							<?php next_posts_link('Next page <i class="icon-chevron-right"></i>'); ?>
						</li>
					</ul>
<?php	wp_reset_query(); ?>