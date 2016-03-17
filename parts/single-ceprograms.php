<?php
/*  Template for displaying post type for the continuing education plugin.
    https://github.com/BellevueCollege/ce-custom-functionality
*/
if ( have_posts( ) ) : while ( have_posts( ) ) : the_post( ); ?>
	<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="content-padding post-heading">
			<h1><?php the_title( ) ?></h1>
		</div>
		<article class="content-padding">
			<?php the_content( ); ?>
		</article>
		<?php if ( class_exists( 'CE_Custom_Functions' ) && class_exists( 'CE_Plugin_Settings' ) ) :
			// Set variables
			$campusce_base_url = 'http://www.campusce.net/BC/course/course.aspx?C=';
			$field_id          = CE_Plugin_Settings::get_ce_field_id();
			$category_ID       = get_post_meta ( get_the_ID( ), $field_id , true );
			// Check if category_ID is properly defined (four digit number)
			if ( preg_match( '/^(\d{4})/', $category_ID ) ) :
				// Only load courses if category_ID is defined
				$courses   = CE_Custom_Functions::cecf_get_courses_by_category_id ( $category_ID );
				$category  = CE_Custom_Functions::cecf_get_category_by_id ( $category_ID ); ?>
				<section id="ce-courses" class="content-padding">
					<?php if ( !empty( $courses ) ) :
						$parent_ID = $category->ParentID; ?>
						<hr />
						<h2>Current <?php the_title( ); ?> Classes</h2>
						<ul class="list-group">
							<?php foreach ( $courses as $class ) { ?>
								<?php if ( empty( $class->CourseID ) == FALSE) { ?>
									<?php $campusce_url = $campusce_base_url . $class->CourseID . '&mc=' . $class->CategoryID . '&pc=' . $parent_ID; ?>
									<li class="list-group-item">
										<h3><a href="<?php echo $campusce_url ?>"><?php echo $class->Title ?></a></h3>
										<p><?php echo substr( $class->WebDescr,0,140 ) ?> ... <a class="btn btn-default btn-xs" href="<?php echo $campusce_url ?>">More <span class="sr-only"> about <?php echo $class->Title ?></span> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></p>
									</li>
								<?php } ?>
							<?php } ?>
						</ul>
					<?php else: // No available courses ?>
						<br>
						<div class="well well-sm">
							<p>Courses have begun. Please check back for future offerings.</p>
							<p>Also, check out our <a href="http://www.campusce.net/BC/category/category.aspx">online catalog</a> for other offerings.</p>
						</div>
					<?php endif; ?>
				</section>
			<?php else: // if field id is not available
				echo '<!-- Category ID is not defined, or does not match proper pattern -->';
			endif; ?>
		<?php else:
			echo "<p class='alert alert-warning'>CE Custom Functionality plugin is required and not active.</p>";
		endif; ?>
	</section>
<?php endwhile; wp_reset_query( ); endif;
