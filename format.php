<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	<h2 <?php post_class() ?>>
		<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
	</h2>
	<p class="entry-date"><?php _e('Date posted:', 'mayflower'); ?> <?php echo get_the_date(); ?></p>
	<?php if ( has_post_thumbnail() ) :

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
	<?php the_excerpt(); ?>
</article>
<hr>
