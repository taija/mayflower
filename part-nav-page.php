<?php while ( have_posts() ) : the_post(); ?>

	<div class="content-padding">
	<h1><?php the_title(); ?></h1>

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

	<?php
		$args = array(
			'post_type' => 'page',
			'posts_per_page' => -1,
			'orderby' => 'menu_order title',
			'post_status' => 'publish',
			'post_parent' => $post->ID
		);
		$loop = new WP_Query( $args );
		
		//number of columns
		$columnNum = 3;
		$count = 0;
		while ( $loop->have_posts() ) : $loop->the_post();
			$count++;
			if ($count == 1) {
					echo '<div class="row">';
			}
		?>
			<div class="span4 top-spacing25">
				<div class="content-padding">
					<h2>
						<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
					</h2>

					<?php
						the_excerpt();
						edit_post_link('edit', '<small>', '</small>');
					?>
				</div><!-- content-padding -->
			</div><!-- span4 -->
	
	
		<?php 
		if ($count == $columnNum) {
			echo '</div> <!-- .row -->';
			$count = 0;
		}
		

		endwhile; 
		
		if ($count > 0 ) {
					echo '</div> <!-- .row -->';
		}
		
		
		?>