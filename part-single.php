<?php
	if (have_posts()) : while (have_posts()) : the_post();
?>
	<div class="content-padding">
		<h2>
			<?php the_title();?>
		</h2>
			<?php if ( is_singular('staff')) { } else {?>
				<small>Date posted: <?php the_date(); ?></small>
			<?php } ?>
		<div class="media">
	
			<?php
				if ( has_post_thumbnail() ) {
					?>
	
					 <div class="pull-left">
						<?php
							the_post_thumbnail('thumbnail', array('class' => 'media-object'));
								if(get_post(get_post_thumbnail_id())->post_excerpt) { ?>
								<span class="featured-caption media-object"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></span>
								<?php } ?>
					 </div>
				<?php
					}
					else {	}
				?>
	
			<div class="media-body">
	
				<div class="media-content">
					<?php the_content(); ?>
				</div><!-- media-content -->
			    <?php
				if (is_single($post)){
				?>
	
		        <?php
				} else {
				?>
		           <p> <a class="btn btn-small primary-read-more" href="<?php the_permalink(); ?>">
		                Read More <i class="icon-chevron-right"></i>
		            </a>
		            </p>
		        <?php
	
				}
				?>
		    </div><!-- media-body -->
		</div><!-- media -->
	</div><!-- content-padding -->

	<?php endwhile; ?>

<?php wp_reset_query(); endif; ?>