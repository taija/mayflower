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
?>

<div id="content" <?php if ( $mayflower_brand == 'branded' ) {?> class="box-shadow"<?php } ?>>

	<div class="row row-padding">

		<?php if ( has_active_sidebar() ) : ?>
			<div class="col-md-9 <?php  if ( $current_layout == 'sidebar-content' ) { ?>col-md-push-3<?php } ?>">
		<?php endif; ?>
				<?php if ( have_posts() ) : ?>
					<?php
					// Start the loop.
					while ( have_posts() ) : the_post(); ?>
						<div class="content-padding">
							<h1><?php the_title(); ?></h1>
						</div>
						<div class="content-padding">
							<?php the_content(); ?>
						</div>

					<?php endwhile;
				// If no content, include the "No posts found" template.
				else :
					get_template_part( 'parts/content', 'none' );

				endif; ?>

		<?php if ( has_active_sidebar() ) : ?>
			</div>
			<?php get_sidebar();
		endif; ?>
	</div>

</div><!-- #content-->

<?php get_footer(); ?>
