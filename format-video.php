<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	<h2 <?php post_class() ?>>
		<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
	</h2>
	<p class="entry-date"><?php _e('Date posted:', 'mayflower'); ?> <?php echo get_the_date(); ?></p>

	<div class="video-container">
		<?php the_content(); ?>
	</div>
</article>
<hr>
