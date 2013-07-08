				<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$args = array(
					  'paged' => $paged,
					  'ignore_sticky_posts' =>1,
					  'orderby' => 'date',
					  'order' => 'ASC'
					);

					query_posts($args);
				?>

				<?php
				if (have_posts()) : while (have_posts()) : the_post();
				?>
<div class="content-padding">
					<h2 <?php post_class() ?>>
						<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
					</h2>

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
				</div><!-- content-padding -->
				<?php
					endwhile;
					posts_nav_link();
					wp_reset_query();
					endif;

					?>
