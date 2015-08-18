<?php
/**
 * Front Page Template File
 *
 * Loads Blog and Static Homepages in Mayflower
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

	<?php
	/**
	 * Load Featured Slideshow Full Width
	 *
	 */
	if ( $mayflower_options['slider_layout'] == 'featured-full' &&
		 $mayflower_options['slider_toggle'] == 'true') {
		get_template_part('parts/featured-full');
	} ?>


	<div class="row row-padding">

		<?php if ( has_active_sidebar() ) : ?>
			<div class="col-md-9 <?php  if ( $current_layout == 'sidebar-content' ) { ?>col-md-push-3<?php } ?>">
		<?php endif; ?>

				<?php
				/**
				 * Load Featured Slideshow in Content
				 *
				 */
				if ( $mayflower_options['slider_toggle'] == 'true' &&
					 $mayflower_options['slider_layout'] == 'featured-in-content' ) {
					get_template_part( 'parts/featured-in-content' );?>
					<div class="content-padding top-spacing30"> </div>
				<?php }
				/**
				 * Check if static homepage is set
				 */
				if ( 'page' == get_option( 'show_on_front' ) ) {
					get_template_part( 'parts/content', 'static-home' );
				} else {
					get_template_part( 'parts/content', 'blog-home' );
				}

				?>
		<?php if ( has_active_sidebar() ) : ?>
			</div>
			<?php get_sidebar();
		endif; ?>
	</div>

</div><!-- #content-->

<?php get_footer(); ?>
