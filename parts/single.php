<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="content-padding">
		<h1><?php the_title();?></h1>
		<p class="entry-date">Date posted: <?php the_date(); ?></p>

		<?php if ( has_post_thumbnail() && get_post_format() != 'video' ) :

			if ( get_post( get_post_thumbnail_id() )->post_excerpt ) :

				$tn_id = get_post_thumbnail_id( $post->ID );
				$img = wp_get_attachment_image_src( $tn_id, 'medium' );
				$width = $img[1]; ?>

				<figure class="img-thumbnail alignleft wp-caption">
					<?php the_post_thumbnail( 'medium' ); ?>
					<figcaption class="featured-caption wp-caption-text" style="width:<?php echo $width.'px';?>"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></p>
				</figure><!-- wp-caption -->
			<?php else : ?>
				<?php the_post_thumbnail( 'medium', array( 'class' => 'img-thumbnail alignleft' ) ); ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php the_content(); ?>
	</div><!-- content-padding -->

	<?php endwhile; ?>

<?php wp_reset_query();
endif; ?>
