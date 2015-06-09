	<div class="content-padding">				

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php 
						$if_charted = get_post_meta( get_the_ID(), 'charted', true );
						if($if_charted)
						{
					?>
					
						<h2 <?php post_class() ?>>
							<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
						</h2>

						<small>Date posted: <?php echo get_the_date(); ?></small>	
					<?php } ?>					
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