<?php if ( is_front_page() ) :
	$mayflower_options = mayflower_get_options();
	if ( $mayflower_options['slider_toggle'] === true ) : ?>


		<div id="carousel-featured-in-content" class="carousel slide">
			<!-- Indicators -->
			<ol class="carousel-indicators">
			<?php $number = 0;
			$the_query = new WP_Query(array(
				'post_type'=>'slider',
				'posts_per_page' => ( $mayflower_options['slider_number_slides'] ),
			));
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
				if ( $the_query->current_post == 0 ) { ?>
					<li data-target="#carousel-featured-in-content" data-slide-to="<?php echo $number++; ?>" class="active"></li>
				<?php } else { ?>
					<li data-target="#carousel-featured-in-content" data-slide-to="<?php echo $number++; ?>"></li>
				<?php }
			endwhile; wp_reset_postdata(); ?>
			</ol>


			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<?php $the_query = new WP_Query(array(
					'post_type'=>'slider',
					'orderby'=> 'menu_order',
					'order'=> 'ASC',
					'posts_per_page' => $mayflower_options['slider_number_slides'],
				));
				while ( $the_query->have_posts() ) :
					$the_query->the_post(); ?>
					<?php if ( $the_query->current_post == 0 ) { ?>
						<div class="item active">
					<?php } else { ?>
						<div class="item">
					<?php } ?>

						<?php // If url field has content, add the URL to the post thumbnail.
						$slider_ext_url = get_post_meta($post->ID, '_slider_url', true);
						if ( !empty( $slider_ext_url ) ) { ?>
							<a href="<?php echo esc_url($slider_ext_url);?>"><?php the_post_thumbnail('featured-in-content'); ?></a>
						<?php } else { ?>
							<a href="<?php echo the_permalink(); ?>"><?php the_post_thumbnail('featured-in-content'); ?></a>
						<?php } //end else ?>
						<?php //should we show title & excerpt?
						$mayflower_options = mayflower_get_options();
						if ($mayflower_options['slider_title'] == 'true' || $mayflower_options['slider_excerpt'] == 'true' ) { ?>
							<div class="carousel-caption">
								<?php if ($mayflower_options['slider_title'] == 'true') {
									// If a post class has input, sanitize it and add it to the post class array.
									$slider_ext_url = get_post_meta($post->ID, '_slider_url', true);
									if ( !empty( $slider_ext_url ) ) { ?>
										<h2><a href="<?php echo esc_url($slider_ext_url);?>"><?php the_title(); ?></a></h2>
									<?php } else { ?>
										<h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
									<?php } //end else ?>
								<?php } else {
									echo '<!-- No Title -->';
								} ?>
								<?php if ($mayflower_options['slider_excerpt'] == 'true' ) { ?>
									<?php the_excerpt(); ?>
								<?php } else {
									echo '<!-- No Excerpt -->';
								} ?>

							</div><!-- carousel-caption -->

						<?php } else  { } ?>

					</div><!-- item -->

				<?php endwhile; wp_reset_postdata(); ?>

			</div><!-- carousel-inner -->
			<!-- Controls -->
			<?php $published_posts = wp_count_posts('slider')->publish;
			if ($published_posts >1 ) : ?>
				<a class="left carousel-control" href="#carousel-featured-in-content" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				</a>
				<a class="right carousel-control" href="#carousel-featured-in-content" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; //slider toggle ?>
<?php endif; //front page ?>
