<div class="content-padding">
	<h1 class="archive_title">
		<?php if ( is_category() ) { ?>
			<?php single_cat_title(); ?>
		<?php } elseif ( is_tag() ) { ?>
			<?php single_tag_title(); ?>
		<?php } elseif ( is_author() ) { ?>
			<?php $author = get_userdata( get_query_var( 'author' ) );
				_e( 'Posts by ', 'mayflower' );
				echo $author->display_name; ?>
		<?php } elseif ( is_day() ) { ?>
			<?php the_time('l, F j, Y'); ?>
		<?php } elseif ( is_month() ) { ?>
			<?php the_time('F Y'); ?>
		<?php } elseif ( is_year() ) { ?>
			<?php the_time('Y'); ?>
		<?php } else { ?>
			Archive<!-- No Page Title Available -->
		<?php } ?>
	</h1>
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
