<?php
// Posts sorted alphabetically
global $query_string;
$posts = query_posts($query_string .'&orderby=title&order=asc&posts_per_page=-1'); ?>

<div class="content-padding">
	<h1> Programs Supported by Student Programs</h1>
	<?php if (have_posts()) : ?>
		<ul>
			<?php while (have_posts()) : the_post(); ?>
				<li <?php post_class() ?>>
					<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
				</li>
			<?php endwhile;?>
		</ul>
</div><!-- content-padding -->

<ul class="pager content-padding">
	<li>
		<?php previous_posts_link('<i class="icon-chevron-left" aria-hidden="true"></i> Previous Page'); ?>
	</li>
	<li>
		<?php next_posts_link('Next page <i class="icon-chevron-right" aria-hidden="true"></i>'); ?>
	</li>
</ul>
<?php endif; ?>
