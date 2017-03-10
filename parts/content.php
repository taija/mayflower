<!-- A Template Was Missing! Using parts/content to output content. -->
<div class="content-padding">
	<h1><?php the_title();?></h1>
	<div>
		<small>Date posted: <?php the_date(); ?></small>
	</div>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="pull-left wp-caption single-featured-thumb">
			<?php
			the_post_thumbnail('medium', array('class' => 'media-object'));
			if ( get_post( get_post_thumbnail_id() ) -> post_excerpt ) {
				 $tn_id = get_post_thumbnail_id( $post->ID );
				 $img = wp_get_attachment_image_src( $tn_id, 'medium' );
				 $width = $img[1]; ?>
				<p class="featured-caption media-object wp-caption-text" style="width:<?php echo $width.'px';?>"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></p>
			<?php } ?>
		</div>
	<?php endif; ?>
	<div data-swiftype-name="body" data-swiftype-type="text">
		<?php the_content(); ?>
	</div>

	<?php // comments_template(); ?>

</div><!-- content-padding -->
