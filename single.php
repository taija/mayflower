<?php get_header(); ?>

<div class="whatpageisthis">single.php</div>

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
								<?php the_content(); ?>
							</div><!-- media-content -->
						    <?php
							if (is_single($post)){
							?>

					        <?php
							} else {
							?>
					           <p> <a class="btn btn-small primary-read-more" href="<?php the_permalink(); ?>">
					                Read More <i class="icon-chevron-right"></i>
					            </a>
					            </p>
					        <?php

							}
							?>
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
