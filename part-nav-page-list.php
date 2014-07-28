<?php while ( have_posts() ) : the_post(); ?>

	<div class="content-padding">
    <?php 
	if ( is_main_site()) {
		if(intval($post->post_parent)>0){
			?><h1><?php the_title(); ?></h1><?php
		}
	} else {
		?><h1><?php the_title(); ?></h1><?php
	}
	?>
                        
	

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

	<div class="content-padding nav-page">
	
		<ul class="media-list">
		<?php
			$args = array(
				'post_type' => 'page',
				'posts_per_page' => -1,
				'orderby' => 'menu_order title',
				'post_status' => 'publish',
				'post_parent' => $post->ID
			);
			$loop = new WP_Query( $args );
			
			while ( $loop->have_posts() ) : $loop->the_post(); 
		?>     
			<li class="media">
							<?php
								if ( has_post_thumbnail() ) {
									?>
				
									 <div class="pull-left wp-caption">
										<?php
											the_post_thumbnail('thumbnail', array('class' => 'media-object'));
												if(get_post(get_post_thumbnail_id())->post_excerpt) {
                          $tn_id = get_post_thumbnail_id( $post->ID );

                          $img = wp_get_attachment_image_src( $tn_id, 'medium' );
                          $width = $img[1];
										?>
												<p class="featured-caption media-object wp-caption-text" style="width:<?php echo $width.'px';?>"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></p>
												<?php } ?>
									 </div><!-- pull-left wp-caption -->
								<?php
									}
									else {	}
								?>

							<div class="media-body">
								<h2>
									<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
								</h2>
									<?php
										the_excerpt();
										edit_post_link('edit', '<small>', '</small>');
									?>
					    </div><!-- media-body -->
			</li><!-- media -->
				<?php endwhile;?>
				<?php wp_reset_postdata(); ?>
		
		</ul>
	</div><!-- content-padding .nav-page -->
