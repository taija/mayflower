<?php // Loop for posts
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array (
	'paged' => $paged,
	'post_type' => 'post',
	'order_by'=> 'date',
	'order' => 'DESC',
	'post_status' => 'publish'
	);

$loop = new WP_Query( $args );
if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post(); ?>
	<div class="content-padding">
		<?php  get_template_part( 'format', get_post_format() ); ?>
	</div><!-- content-padding -->
<?php endwhile; ?>

<?php wp_reset_postdata(); ?>

<?php mayflower_pagination(); ?>

<?php	wp_reset_query(); ?>
<?php else : ?>
<?php endif; ?>
