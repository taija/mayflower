<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
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

function has_active_sidebar() {
	if ( is_active_sidebar( 'top-global-widget-area' ) ||
			   is_active_sidebar( 'page-widget-area' ) ||
			   is_active_sidebar( 'global-widget-area' ) ) {
		return true;
	} else {
		return false;
	}
}
?>

<div id="content" <?php if ( $mayflower_brand == 'branded' ) {?> class="box-shadow"<?php } ?>>

	<?php
	/**
	 * Load Featured Slideshow Full Width
	 *
	 */
	if ( $mayflower_options['slider_layout'] == 'featured-full' &&
		 $mayflower_options['slider_toggle'] == 'true') {
		get_template_part('part-featured-full');
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
					get_template_part('part-featured-in-content');
				} ?>
				<?php get_template_part( 'content', 'home' ); ?>
		<?php if ( has_active_sidebar() ) : ?>
			</div>
			<?php get_sidebar();
		endif; ?>
	</div>

</div><!-- #content-->

<?php get_footer(); ?>
