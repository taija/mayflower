	<div class="content-padding">

					<?php if (is_category()) { ?>
						<h2 class="archive_title">
							<?php single_cat_title(); ?>
						</h2>
					<?php } elseif (is_tag()) { ?> 
						<h2 class="archive_title">
							<?php single_tag_title(); ?>
						</h2>
					<?php } elseif (is_author()) { ?>
						<h2 class="archive_title">
							<?php get_the_author_meta('display_name'); ?>
						</h2>
					<?php } elseif (is_day()) { ?>
						<h2 class="archive_title">
							<?php the_time('l, F j, Y'); ?>
						</h2>
					<?php } elseif (is_month()) { ?>
					    <h2 class="archive_title">
					    	<?php the_time('F Y'); ?>
					    </h2>
					<?php } elseif (is_year()) { ?>
					    <h2 class="archive_title">
					    	<?php the_time('Y'); ?>
					    </h2>
					<?php } ?>

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
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
					 </div>
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
						        <?php

								}
								?>
						    </div><!-- media-body -->
						</div><!-- media -->
						<hr />
				<?php endwhile;?>
			</div><!-- content-padding -->
				<?php wp_reset_postdata(); ?>
	
					
					<ul class="pager content-padding">
						<li>
							<?php previous_posts_link('<i class="icon-chevron-left"></i> Previous Page'); ?>
						</li>
						<li>
							<?php next_posts_link('Next page <i class="icon-chevron-right"></i>'); ?>
						</li>
					</ul>
					<?php wp_reset_query(); ?>								
					
					<?php else : ?>					
					<?php endif; ?>