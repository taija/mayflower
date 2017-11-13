<?php
/**
 * Template Name: Full Width (No Sidebar)
 */
get_header();

global $mayflower_brand;
$mayflower_options = mayflower_get_options();
$current_layout = $mayflower_options['default_layout'];
?>

<div id="content" data-swiftype-index='true' <?php if ( $mayflower_brand == 'branded' ) {?> class="box-shadow"<?php } ?>>

	<div class="row row-padding">
		<div class="col-md-12">
			<?php if ( have_posts() ) : ?>
				<?php
				// Start the loop.
				while ( have_posts() ) : the_post(); ?>
					<main id="post-<?php the_ID(); ?>" <?php post_class( '' ); ?> role="main">
						<?php get_template_part( 'parts/page' ); ?>
					</main>
				<?php endwhile;
			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'parts/content', 'none' );
			endif; ?>
		</div>
	</div>
</div><!-- #content-->

<?php get_footer();

