<div id="content">
<?php  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php if($post->post_content=="") : ?>
			<!-- Don't display empty the_content or surround divs -->
				<div class="page-content">
					<div class="content-padding">
					<h1><?php the_title(); ?></h1>
					</div><!-- content-padding -->
				</div><!-- page-content -->
			<?php else : ?>
			<!-- Do stuff when the_content has content -->
				<div class="page-content">
					<div class="content-padding">
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
					</div><!-- content-padding -->
				</div><!-- page-content -->

			<?php endif; ?>

			<?php endwhile; else: ?>
			<p><?php _e('Sorry, these aren\'t the bytes you are looking for.'); ?></p>
			<?php endif; ?>

<?php
	$mayflower_options = mayflower_get_options();
	if( $mayflower_options['staff_layout'] == 'list-view' ) { ?>
			
            <div class="content-padding top-spacing15">
			<?php
				// Start showing staff list
				$loop = new WP_Query( array( 'post_type' => 'staff', 'posts_per_page' => 50, 'orderby' => 'menu_order', 'order' => 'ASC') );

				while ( $loop->have_posts() ) : $loop->the_post();
			?>

				
				    <div class="media">
				    <a class="pull-left" href="<?php the_permalink(); ?>">
					<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail('thumbnail', array('class' => 'media-object'));
						}
						else {
							echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/img/thumbnail-default.png" />';
						}
					?>

					    </a>

				<div class="media-body">
					<div class="caption staff-details">
						<?php $post_meta_data = get_post_custom($post->ID); ?>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

							<?php if (isset($post_meta_data['staff_position'][0])) { ?>
								<h3>
									<?php echo $post_meta_data['staff_position'][0]; ?>
								</h3>													
							<?php } ?>

							<ul>
								<?php if (isset($post_meta_data['staff_email'][0])) { ?>
									<li>
										<strong>Email: </strong>
										<a href="mailto:<?php echo $post_meta_data['staff_email'][0];  ?>"><?php echo $post_meta_data['staff_email'][0]; ?></a>
									</li>
								<?php } ?>

								<?php if (isset($post_meta_data['staff_phone'][0])) { ?>
									<li>
										<strong>Phone: </strong>
										<?php echo $post_meta_data['staff_phone'][0];  ?>
									</li>
								<?php } ?>

								<?php if (isset($post_meta_data['staff_office_location'][0])) { ?>
									<li>
										<strong>Office Location: </strong>
										<?php echo $post_meta_data['staff_office_location'][0];  ?>
									</li>
								<?php } ?>

								<?php if (isset($post_meta_data['staff_office_hours'][0])) { ?>
									<li>
										<strong>Office Hours: </strong><?php echo $post_meta_data['staff_office_hours'][0];  ?>
									</li>
								<?php } ?>

								<?php if(empty($post->post_content)) {  } else { ?>
									<li>
										<br />
										<strong>Bio: </strong><br />
										<?php the_excerpt();  ?>
									</li>
								<?php } ?>
							</ul>
					</div><!-- caption -->

				    </div><!-- media-body -->
			    </div><!-- media -->
			
				<hr />
				<?php endwhile; wp_reset_postdata(); ?>
			</div><!-- content-padding -->
	<?php } elseif( $mayflower_options['staff_layout'] == 'grid-view' ) {  ?>

			<?php
				// Start showing staff list
				$loop = new WP_Query( array( 'post_type' => 'staff', 'posts_per_page' => 50, 'orderby' => 'menu_order', 'order' => 'ASC') );

				while ( $loop->have_posts() ) : $loop->the_post();
			?>

	<ul class="thumbnails">
		<li class="span4">
			<div class="content-padding">
				<div class="thumbnail">
					<?php if(has_post_thumbnail()) { ?>
					<?php echo get_the_post_thumbnail(get_the_ID(), 'staff-thumbnail');  ?>
					<?php } else { }?>

					<div class="caption staff-details">
						<?php $post_meta_data = get_post_custom($post->ID); ?>
							<h2><?php the_title(); ?></h2>
							<h3>
								<?php if (isset($post_meta_data['staff_position'][0])) {
								echo $post_meta_data['staff_position'][0]; } ?>
							</h3>

							<ul>
								<li>
									<?php if (isset($post_meta_data['staff_email'][0])) {
									echo $post_meta_data['staff_email'][0]; } ?>
								</li>
								<li>
									<?php if (isset($post_meta_data['staff_phone'][0])) { ?>
									<strong>Phone: </strong>
									<?php echo $post_meta_data['staff_phone'][0]; } ?>
								</li>
								<li>
									<?php if (isset($post_meta_data['staff_office_location'][0])) { ?>
									<strong>Office Location: </strong>
									<?php echo $post_meta_data['staff_office_location'][0]; } ?>
								</li>
								<li>
									<?php if (isset($post_meta_data['staff_office_hours'][0])) { ?>
									<strong>Office Hours: </strong><?php echo $post_meta_data['staff_office_hours'][0]; } ?>
								</li>
								<li>
									<?php // Check to see if the post has content ?>
									<?php if(empty($post->post_content)) {  } else { ?>
									<br />
									<strong>Bio: </strong><br />
									<?php the_excerpt(); } ?>
								</li>
							</ul>
						<!--
						<p>
							<a class="btn btn-primary" href="#">Action</a>
							<a class="btn" href="#">Action</a>
						</p>
						-->
					</div><!-- caption -->
				</div><!-- thumbnail -->
			</div><!-- content-padding -->
		</li>
				<?php endwhile; wp_reset_postdata(); ?>
	</ul>
<?php } // end elseif  ?>
</div><!--#content-->