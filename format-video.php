	<h2 <?php post_class() ?>>
		<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
	</h2>

	<small>Date posted: <?php echo get_the_date(); ?></small>

	<div class="video-container">
		<?php the_content(); ?>
	</div>
	<hr />