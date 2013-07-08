		<?php while ( have_posts() ) : the_post(); ?>
			<div class="content-padding">
			<h1><?php the_title(); ?></h1>

			<?php if($post->post_content=="") : ?>
			<!-- Don't display empty the_content or surround divs -->

			<?php else : ?>
			<!-- Do stuff when the_content has content -->
				<div class="page-content">
					<?php the_content(); ?>
				</div><!-- page-content -->

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

				while ( $loop->have_posts() ) : $loop->the_post();

	        ?>

            <div class="row-fluid">
	            <div class="span4">
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
			</div> <!--.row-fluid-->
        <?php endwhile; ?>
