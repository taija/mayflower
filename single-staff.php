<?php get_header(); ?>

<div class="whatpageisthis">single-staff.php</div>

	<div class="container">
        <div class="row">
            <div class="span8" id="content">
				<?php

				if (have_posts()) : while (have_posts()) : the_post();

				?>

					<h2>
						<?php the_title();?>
					</h2>

					<div class="media">

						<?php
							if ( has_post_thumbnail() ) {
								?>

								 <a class="pull-left" href="<?php the_permalink(); ?>" style="text-decoration:none;color:black;">
									<?php
										the_post_thumbnail('thumbnail', array('class' => 'media-object'));
											if(get_post(get_post_thumbnail_id())->post_excerpt) { ?>
											<span class="featured-caption media-object"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></span>
											<?php } ?>
								 </a>
							<?php
								}
								else {	}
							?>

						<div class="media-body">

							<div class="media-content">
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
						</div><!-- media-content -->
					    </div><!-- media-body -->
					</div><!-- media -->


					<?php endwhile; ?>

<?php
/*
    <ul class="pager">
    <li class="previous">
    <?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?>
    </li>
    <li class="next">
    <?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?>
    </li>
    </ul>


				<!--<nav class="nav-single">
					<span class="nav-previous"></span>
					<span class="nav-next"></span>
				</nav>.nav-single -->
*/
?>
				<?php wp_reset_query(); endif; ?>

		</div><!--#content .span8 -->
			<?php get_sidebar(); ?>
		</div><!-- row -->
	</div><!-- container -->
<?php get_footer();
