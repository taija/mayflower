<?php while ( have_posts() ) : the_post(); ?>
	<div class="content-padding">
		<h1><?php the_title(); ?></h1>

		<?php if ( $post-> post_content=="" ) : /* Don't display empty the_content or surround divs */ ?>

		<?php else : /* Do stuff when the_content has content */ ?>
			<?php the_content(); ?>
		<?php endif; ?>

	</div><!-- content-padding -->
<?php endwhile; ?>

<?php wp_reset_postdata(); ?>

<?php
$args = array(
	'post_type'      => 'page',
	'posts_per_page' => -1,
	'order'          => 'ASC',
	'orderby'        => 'menu_order title',
	'post_status'    => 'publish',
	'post_parent'    => $post->ID
);

$loop = new WP_Query( $args );

//number of columns
$columnNum = 3;
$count = 0;

while ( $loop->have_posts() ) : $loop->the_post();
	$count++;
	if ( $count == 1 ) {
		echo '<div class="row">';
	} ?>

	<div class="col-md-4 top-spacing15">
		<div class="content-padding nav-page">

			<?php if ( has_post_thumbnail() ) { ?>
				<a class="" href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'home-small-ad', array( 'class' => 'img-responsive' ) ); ?>
				</a>
			<?php } else {} ?>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
			<?php
				the_excerpt();
				edit_post_link('edit', '<small>', '</small>');
			?>
		</div><!-- content-padding .nav-page -->
	</div><!-- col-md-4 -->
	<?php if ( $count == $columnNum ) { ?>
		</div> <!-- .row -->
		<?php $count = 0;
	} ?>

<?php endwhile; ?>
<?php if ($count > 0 ) { ?>
	</div> <!-- .row -->
<?php } ?>

<?php wp_reset_postdata(); ?>
