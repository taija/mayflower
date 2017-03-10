<?php
/**
 * Template Name: Navigation Page (List)
 */
?>
<?php get_header(); ?>
<?php
/**
 * Load Variables
 *
 */
global $mayflower_brand;
$mayflower_options = mayflower_get_options();
$current_layout = $mayflower_options['default_layout'];
?>

<div id="content" data-swiftype-index='true' <?php if ( $mayflower_brand == 'branded' ) {?> class="box-shadow"<?php } ?>>

	<div class="row row-padding">

		<?php if ( has_active_sidebar() ) : ?>
			<div class="col-md-9 <?php  if ( $current_layout == 'sidebar-content' ) { ?>col-md-push-3<?php } ?>">
		<?php else : // Full Width Container ?>
			<div class="col-md-12">
		<?php endif;

				get_template_part( 'parts/page-nav-page-list' ); ?>

			</div>
		<?php if ( has_active_sidebar() ) : ?>
			<?php get_sidebar();
		endif; ?>
	</div>

</div><!-- #content-->
<?php get_footer(); ?>
