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

<ul class="pager content-padding">
	<li>
		<?php previous_posts_link('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Previous Page'); ?>
	</li>
	<li>
		<?php next_posts_link('Next Page <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></i>'); ?>
	</li>
</ul>

<?php	wp_reset_query(); ?>
<?php else : ?>
<?php endif; ?>
