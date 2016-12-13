<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="content-padding post-heading">
			<h1><?php the_title();?></h1><br />
		</div>
		<article class="content-padding">
			<div class="row">
				<div class="col-md-4 col-sm-5">
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'medium', array( 'class' => 'img-thumbnail img-responsive' ) );
					}
					else {
						echo '<img alt="" src="' . get_stylesheet_directory_uri() . '/img/thumbnail-default.png" />';
					} ?>
				</div>
				<div class="col-md-8 col-sm-7">
					<?php $post_meta_data = get_post_custom($post->ID); ?>

					<ul>
						<?php echo do_shortcode('[custom_fields_block wrap = "" open_line = "<li>" open_title="<strong>"
						close_title="</strong>" close_line = "</li>" open_value = ": "] ');
						echo get_the_term_list( $post->ID, 'experts_topics','<li><strong>Topics</strong>: ', ' ', '</li>');
						echo get_the_term_list( $post->ID, 'experts_expertise', '<li><strong>Expertise</strong>: ', ' ', '</li>');
					?>
					</ul>
				</div>
			</div>
			<?php if ( !empty( $post->post_content ) ) : ?>
				<h2 class="staff-biography">Notable Achievements:</h2>
				<?php the_content();  ?>
			<?php endif; ?>

		</article><!-- content-padding -->
	</section>

<?php endwhile; ?>
<?php wp_reset_query(); endif;
