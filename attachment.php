<?php
/**
 * Attachment Template File
 *
 * Displays File Attachments
 *
 */

get_header(); ?>
<?php
/**
 * Load Variables
 *
 */
global $mayflower_brand;
$mayflower_options = mayflower_get_options();
$current_layout    = $mayflower_options['default_layout'];
$description       = $post->post_content;
$caption           = $post->post_excerpt;
?>

<div id="content" <?php if ( $mayflower_brand == 'branded' ) {?> class="box-shadow"<?php } ?>>

	<div class="row row-padding">

		<?php if ( has_active_sidebar() ) : ?>
			<div class="col-md-9 <?php  if ( $current_layout == 'sidebar-content' ) { ?>col-md-push-3<?php } ?>">
		<?php endif; ?>

				<?php if (have_posts()) : while (have_posts()) : the_post(); /* Template format for images */ ?>
					<div class="content-padding">
						<?php if ( wp_attachment_is_image( $post->id ) ) : ?>
							<h2><?php the_title();?></h2>
							&nbsp;
							<div class="wp-caption">
								<a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>" rel="attachment">
									<?php echo wp_get_attachment_image($post->id, 'large', false, array('class' => 'attachment-large img-responsive aligncenter')); ?>
								</a>
								<?php if ( !empty($caption) ) { ?>
										<p class="wp-caption-text"><?php echo $caption; ?></p>
								<?php } ?>
							</div>
							<?php if ( !empty($description) ) { ?>
								<p><?php echo $description; ?></p>
							<?php } ?>
						<?php else : /* Display format for non-image files */?>
							<h2>Download File</h2>
							<div class="media">
								<div class="media-left">
									<?php echo wp_get_attachment_image($post->id, 'thumbnail', true, array('class' => 'media-object')); ?>
								</div>
								<div class="media-body">
									<h4 class="media-heading"><a href="<?php echo wp_get_attachment_url($post->ID) ?>"><?php the_title();?></a></h4>
									<?php if ( !empty($description) ) { ?>
										<p><?php echo $description; ?></p>
									<?php } ?>
								</div>
							</div>

						<?php endif; ?>

					</div><!-- content-padding -->

				<?php endwhile; ?>

				<?php wp_reset_query(); endif; ?>


		<?php if ( has_active_sidebar() ) : ?>
			</div>
			<?php get_sidebar();
		endif; ?>
	</div>

</div><!-- #content-->

<?php get_footer(); ?>
