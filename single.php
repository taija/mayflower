<?php
/**
 * The Single Post Template File
 *
 * This displays all single posts
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
$current_layout = $mayflower_options['default_layout'];
?>

<div id="content" <?php if ( $mayflower_brand == 'branded' ) {?> class="box-shadow"<?php } ?>>

	<div class="row row-padding">

		<?php if ( has_active_sidebar() ) : ?>
			<div class="col-md-9 <?php  if ( $current_layout == 'sidebar-content' ) { ?>col-md-push-3<?php } ?>">
		<?php endif; ?>

				<?php
				/**
				 * Get Single Template Part
				 *
				 * Check for post type. Look within 'parts/' directory.
				 */
				$format = get_post_format();
				if ( $format ) {
					get_template_part( 'parts/single', $format );
				} else {
					get_template_part( 'parts/single', get_post_type() );
				} ?>

		<?php if ( has_active_sidebar() ) : ?>
			</div>
			<?php get_sidebar();
		endif; ?>
	</div>

</div><!-- #content-->

<?php get_footer(); ?>
