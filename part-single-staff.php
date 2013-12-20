<?php
	if (have_posts()) : while (have_posts()) : the_post();
?>
	<div class="content-padding">
		<h2>
			<?php the_title();?>
		</h2>
			<?php if ( is_singular('staff')) { } else {?>
				<small>Date posted: <?php the_date(); ?></small>
			<?php } ?>
				    <div class="media">
				    <a class="pull-left wp-caption" href="<?php the_permalink(); ?>">
					<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail('medium', array('class' => 'media-object'));
						}
						else {
							echo '<img src="' . get_stylesheet_directory_uri() . '/img/thumbnail-default.png" />';
						}
					?>

					</a>

				<div class="media-body">
					<div class="caption staff-details">
						<?php $post_meta_data = get_post_custom($post->ID); ?>
							<h2><?php the_title(); ?></h2>

							<?php if (isset($post_meta_data['_staff_position'][0])) { ?>
								<h3>
									<?php echo $post_meta_data['_staff_position'][0]; ?>
								</h3>
							<?php } ?>

							<ul>

								<?php if (isset($post_meta_data['_staff_email'][0])) { ?>
									<li>
										<strong>Email: </strong>
										<a href="mailto:<?php echo $post_meta_data['_staff_email'][0];  ?>"><?php echo $post_meta_data['_staff_email'][0]; ?></a>
									</li>
								<?php } ?>

								<?php if (isset($post_meta_data['_staff_phone'][0])) { ?>
									<li>
										<strong>Phone: </strong>
										<?php echo $post_meta_data['_staff_phone'][0];  ?>
									</li>
								<?php } ?>

								<?php if (isset($post_meta_data['_staff_office_location'][0])) { ?>
									<li>
										<strong>Office Location: </strong>
										<?php echo $post_meta_data['_staff_office_location'][0]; ?>
									</li>
								<?php } ?>

								<?php if (isset($post_meta_data['_staff_office_hours'][0])) { ?>
									<li>
										<strong>Office Hours: </strong><?php echo $post_meta_data['_staff_office_hours'][0]; ?>
									</li>
								<?php } ?>

								<?php if(empty($post->post_content)) {  } else { ?>
									<li>
										<br />
										<strong>Bio: </strong><br />
										<?php the_content();  ?>
									</li>
								<?php } ?>
							</ul>
					</div><!-- caption -->

					</div><!-- media-body -->
				</div><!-- media -->	</div><!-- content-padding -->

	<?php endwhile; ?>

<?php wp_reset_query(); endif; ?>
