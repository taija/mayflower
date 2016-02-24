<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="content-padding">
		<div class="staff-details">
			<div class="row">
				<div class="col-md-4 col-sm-6">
					<a href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'medium', array( 'class' => 'img-thumbnail img-responsive' ) );
						}
						else {
							echo '<img alt="" src="' . get_stylesheet_directory_uri() . '/img/thumbnail-default.png" />';
						} ?>
					</a>
				</div>
				<div class="col-md-8 col-sm-6">
					<?php $post_meta_data = get_post_custom($post->ID); ?>
					<h1><?php the_title(); ?></h1>
					
					<?php echo do_shortcode('[custom_fields_block wrap = "<ul>" open_line = "<li>" open_title="<strong>"
						close_title="</strong>" close_line = "</li>" open_value = " : "] ');
						echo get_the_term_list( $post->ID, 'topics','<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Topic</strong> : ');
						echo get_the_term_list( $post->ID, 'expertise', '<strong></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Expertise</strong> : ');
					?>
						
				</div>
			</div>
			<?php if ( empty( $post->post_content ) ) {  } else { ?>
				<h2 class="staff-biography">Notable Achievements:</h2>
					<?php the_content();  ?>
			<?php } ?>

		</div><!-- staff-details -->
	</div><!-- content-padding -->

<?php endwhile; ?>
<?php wp_reset_query(); endif; ?>
