<?php
// Set up taxonomy variables
if( is_tax() ) {
	global $wp_query;
	$term = $wp_query->get_queried_object();
	$title = $term->name;
	$description = $term->description;
}

// Sort Alphabetically and force all posts to Display
global $query_string;
query_posts( $query_string . '&orderby=title&order=ASC' );
?>

	<div class="content-padding top-spacing15">
	<h1>
		<?php if( is_tax() ) {
			echo $title.'&nbsp;';
		} ?>
		
	</h1>
	<?php if( is_tax() && !empty($description)) : ?>
		<p class="lead">
			<?php echo $description; ?>
		</p>
	<?php endif; ?>
	
	<?php if (have_posts()) : ?>		
		<?php while (have_posts()) : the_post(); ?>	
			<div class="media">
			    <a class="pull-left" href="<?php the_permalink(); ?>">
				<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail('thumbnail', array('class' => 'media-object img-responsive img-thumbnail'));
					}
					else {
						echo '<img alt="" src="' . get_stylesheet_directory_uri() . '/img/thumbnail-default.png" />';
					}
				?>
				</a>

				<div class="media-body">
					<div class="caption staff-details content-padding">
						<?php $post_meta_data = get_post_custom($post->ID); ?>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php echo do_shortcode('[custom_fields_block wrap = "<ul>" open_line = "<li>" open_title="<strong>"
								close_title="</strong>" close_line = "</li>" open_value = " : "] '); ?>
							<?php if(empty($post->post_content)) {  } else { ?>
								<h3 class="staff-biography">Notable Achievements:</h3>
							<?php the_excerpt();  ?>
						<?php } ?>
					</div><!-- caption -->
				</div><!-- media-body -->
			</div><!-- media -->
			<hr />
		<?php endwhile; wp_reset_postdata(); ?>
	</div><!-- content-padding -->
	<?php mayflower_pagination(); ?>
	<?php wp_reset_query(); ?>
	<?php endif; ?>
	
	
