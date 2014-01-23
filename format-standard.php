<div class="content-padding">
	<h2 <?php post_class() ?>>
		<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
	</h2>
	
	<small>Date posted: <?php echo get_the_date(); ?></small>


		<div class="media">
<?php
if ( has_post_thumbnail() ) {
	?>

	 <div class="pull-left wp-caption">
		<?php
			the_post_thumbnail('medium', array('class' => 'media-object'));
				if(get_post(get_post_thumbnail_id())->post_excerpt) {
                    $tn_id = get_post_thumbnail_id( $post->ID );

                    $img = wp_get_attachment_image_src( $tn_id, 'medium' );
                    $width = $img[1];
                    ?>
				<p class="featured-caption media-object wp-caption-text" style="width:<?php echo $width.'px';?>"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></p>
				<?php } ?>
	 </div><!-- wp-caption -->
<?php
	}
	else {	}
?>

			<div class="media-body">

				<div class="media-content">
					<?php the_excerpt(); ?>
				</div><!-- media-content -->
			    <?php
				if (is_single($post)){
				?>

		        <?php
				} else {
				?>
					<p>
						<a class="btn btn-small primary-read-more" href="<?php the_permalink(); ?>">
					Read More <i class="icon-chevron-right"></i>
				</a>
					</p>
		        <?php

				}
				?>
		    </div><!-- media-body -->
		</div><!-- media -->
	<hr />
</div><!-- content-padding -->
