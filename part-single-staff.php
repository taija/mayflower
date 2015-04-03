<?php
	if (have_posts()) : while (have_posts()) : the_post();
?>
	<div class="content-padding">
			<?php if ( is_singular('staff')) { } else {?>
				<small>Date posted: <?php the_date(); ?></small>
			<?php } ?>
				    <!--<div class="media">-->
				    

				<!--<div class="media-body">-->
				
					<div class="staff-details">
						
							<div class="row">
							<div class="col-md-4 col-sm-6">
							<a href="<?php the_permalink(); ?>">
								<?php
									if ( has_post_thumbnail() ) {
										the_post_thumbnail('medium', array('class' => 'img-thumbnail img-responsive'));
									}
									else {
										echo '<img alt="" src="' . get_stylesheet_directory_uri() . '/img/thumbnail-default.png" />';
									}
								?>
			
								</a>
							</div>
							<div class="col-md-8 col-sm-6">
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

							</ul></div></div>
							<?php if(empty($post->post_content)) {  } else { ?>
									
										<h3 class="staff-biography">Biography: </h3
										<?php the_content();  ?>
								<?php } ?>
					<!-- </div> --><!-- caption -->

					<!--</div>--><!-- media-body -->
				</div><!-- media -->	</div><!-- content-padding -->

	<?php endwhile; ?>

<?php wp_reset_query(); endif; ?>
