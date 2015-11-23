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

<?php mayflower_pagination(); ?>
<?php endif; ?>
