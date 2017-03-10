<div class="content-padding post-heading">
	<h1><?php the_title(); ?></h1>
</div>
<?php if ( function_exists( 'post_and_page_asides_return_title' ) ) :
	get_template_part( 'parts/aside' );
endif; ?>
<article class="content-padding" data-swiftype-name="body" data-swiftype-type="text">
	<?php the_content(); ?>
	<div class="clearfix"></div>
	<p id="modified-date" class="text-right"><small><?php _e('Last Updated ', 'mayflower'); the_modified_date(); ?></small></p>
</article>
