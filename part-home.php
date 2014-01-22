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
						<hr />
					<?php } else {} ?>
				<?php endwhile;?>
				<?php wp_reset_postdata(); ?>

				<?php // Loop for posts
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$args = array(
						'paged' => $paged,
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
				     <?php 
				
					if ( !get_post_format()) {
				               get_template_part('format', 'standard');
			         } else {
				               get_template_part('format', get_post_format());
				          }
					?>



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