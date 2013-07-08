	<div id="myCarousel" class="carousel slide">
		<div class="carousel-inner">
			<?php
			$the_query = new WP_Query(array(
				'post_type'=>'slider',
				'orderby' => 'menu_order',
				'order'=> 'ASC',
				'posts_per_page' => 1,
			));
			while ( $the_query->have_posts() ) :
			$the_query->the_post();
			?>

			<div class="item active">
				<?php
			        // If a post class has input, sanitize it and add it to the post class array.
					$slider_ext_url = get_post_meta($post->ID, 'slider_url', true);
				        if ( !empty( $slider_ext_url ) )
					{ ?>

					<h2>
						<a href="<?php echo esc_url($slider_ext_url);?>" title="<?php echo $slider_ext_url; ?>"><?php the_post_thumbnail('featured-in-content');?></a>
					</h2>

					<?php } else { ?>

				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured-in-content');?></a>
				<?	} //end else ?>
			<?php
				$options = get_option( 'mayflower_slider_options' );
					if ( ! isset( $options['theme_slider_title_show'] ) )
						$options['theme_slider_title_show'] = 0;

					if ( $options['theme_slider_title_show'] == 1 ) { ?>

				<div class="carousel-caption">
						<?php
					        // If a post class has input, sanitize it and add it to the post class array.
							$slider_ext_url = get_post_meta($post->ID, 'slider_url', true);
						        if ( !empty( $slider_ext_url ) )
							{ ?>

							<h2>
								<a href="<?php echo esc_url($slider_ext_url);?>" title="<?php echo $slider_ext_url; ?>"><?php the_title(); ?></a>
							</h2>

							<?php } else { ?>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>

						<?	} //end else ?>
					<?php the_excerpt(); ?>
				</div>
			<?php } else  { } ?>

			</div><!-- item active -->

			<?php
				endwhile;
					wp_reset_postdata();
			?>

			<?php
				$the_query = new WP_Query(array(
					'post_type'=>'slider',
					'orderby' => 'menu_order',
					'order'=> 'ASC',
					'posts_per_page' => 4,
					'offset' => 1
				));
				while ( $the_query->have_posts() ) :
				$the_query->the_post();
			?>
			<div class="item">
				<?php
			        // If a post class has input, sanitize it and add it to the post class array.
					$slider_ext_url = get_post_meta($post->ID, 'slider_url', true);
				        if ( !empty( $slider_ext_url ) )
					{ ?>

					<h2>
						<a href="<?php echo esc_url($slider_ext_url);?>" title="<?php echo $slider_ext_url; ?>"><?php the_post_thumbnail('featured-in-content');?></a>
					</h2>

					<?php } else { ?>

				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured-full');?></a>
				<?	} //end else ?>

			<?php
				$options = get_option( 'mayflower_slider_options' );
					if ( ! isset( $options['theme_slider_title_show'] ) )
						$options['theme_slider_title_show'] = 0;

					if ( $options['theme_slider_title_show'] == 1 ) { ?>

					<div class="carousel-caption">
						<?php
					        // If a post class has input, sanitize it and add it to the post class array.
							$slider_ext_url = get_post_meta($post->ID, 'slider_url', true);
						        if ( !empty( $slider_ext_url ) )
							{ ?>

							<h2>
								<a href="<?php echo esc_url($slider_ext_url);?>" title="<?php echo $slider_ext_url; ?>"><?php the_title(); ?></a>
							</h2>

							<?php } else { ?>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>

						<?	} //end else ?>
						<?php the_excerpt(); ?>
					</div>
			<?php } else  { } ?>

			</div><!-- item -->

			<?php
				endwhile;
				wp_reset_postdata();
			?>
		</div><!-- carousel-inner -->

		<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>

	</div><!-- #myCarousel -->
