<?php
/**
 * Content Template for Mayflower Static Homepage
 */

$mayflower_options = mayflower_get_options();

if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<h1 class="sr-only"><?php the_title(); ?></h1>
	<?php
	/**
	* Prevent Empty Container from loading if there is no content
	*/
	if ( $post->post_content != "" ) : ?>
		<div class="content-padding">
			<?php the_content(); ?>
		</div><!--.content-padding-->
	<?php endif; ?>
	<?php
	/**
	 * Check if posts are displayed on static homepage
	 */
	if ( $mayflower_options['blog_homepage_toggle'] === true ) : ?>
		<div id="static-homepage-posts" class="top-spacing30">

			<?php // Loop for posts
			$args = array(
				'post_type' => 'post',
				'order_by'=> 'date',
				'order' => 'DESC',
				'posts_per_page' => $mayflower_options['blog_number_posts'],
				'post_status' => 'publish'
			);

			$loop = new WP_Query( $args );
			if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post(); ?>
				<div class="content-padding">
					<?php  get_template_part( 'format', get_post_format() ); ?>
				</div><!-- content-padding -->
			<?php endwhile; ?>
			<?php else : ?>
			<?php endif; ?>

		</div>
	<?php endif; ?>
<?php endwhile; else: ?>
	<p><?php _e('Sorry, these aren\'t the bytes you are looking for.'); ?></p>
<?php endif; ?>
