<div class="content-padding">
	<?php if (is_category()) { ?>
		<h1 class="archive_title"><?php single_cat_title(); ?></h1>
	<?php } elseif (is_tag()) { ?>
		<h1 class="archive_title"><?php single_tag_title(); ?></h1>
	<?php } elseif (is_author()) { ?>
		<h1 class="archive_title"><?php get_the_author_meta('display_name'); ?></h1>
	<?php } elseif (is_day()) { ?>
		<h1 class="archive_title"><?php the_time('l, F j, Y'); ?></h1>
	<?php } elseif (is_month()) { ?>
		<h1 class="archive_title"><?php the_time('F Y'); ?></h1>
	<?php } elseif (is_year()) { ?>
		<h1 class="archive_title"><?php the_time('Y'); ?></h1>
	<?php } else { ?>
		<h1>Archive</h1><!-- No Page Title Available -->
	<?php } ?>
</div>
<div class="top-spacing30"></div>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="content-padding">
		<?php get_template_part( 'format', get_post_format() ); ?>
	</div><!-- content-padding -->
<?php endwhile;?>
<?php wp_reset_postdata(); ?>

<ul class="pager content-padding">
	<li>
		<?php previous_posts_link('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Previous Page'); ?>
	</li>
	<li>
		<?php next_posts_link('Next Page <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></i>'); ?>
	</li>
</ul>
<?php wp_reset_query(); ?>

<?php else :
	get_template_part( 'parts/content', 'none' );
endif; ?>
