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


		<?php 
		// Make sure CE Custom Functionality plugin is active
		if ( class_exists( 'CE_Custom_Functions' ) && class_exists( 'CE_Plugin_Settings' ) ) :
			
			// Make sure AJAX method exists
			if ( method_exists( 'CE_Custom_Functions','cecf_ajax_course_info' ) ) :
				// Set PHP Variables
				$field_id     = CE_Plugin_Settings::get_ce_field_id( );
				$category_ID  = get_post_meta ( get_the_ID( ), $field_id , true );
				$ajax_nonce   = wp_create_nonce( 'campusce-ajax-request' );

				// Make sure Category ID is in correct format (4 numeric chars)
				if ( preg_match( '/^(\d{4})$/', $category_ID ) ) : ?>

					<hr />
					<script type="text/javascript">
						/*
						 * Pull course data from CampusCE
						 *
						 */
						jQuery( document ).ready( function( ) {

							// Hide response area so it can slide down later
							jQuery( "#response_area" ).hide( );

							// Base URL format for links to CampusCE
							var campusce_base_url = 'http://www.campusce.net/BC/course/course.aspx?C=';

							// Get data from WordPress
							jQuery.post (
								"<?php echo admin_url( 'admin-ajax.php' ); ?>",
								{
									action:   'cecf_ajax_get_data',
									catid:    '<?php echo $category_ID; ?>',
									security: '<?php echo $ajax_nonce; ?>'
								},
								function( campusce_data ) {
									var data = campusce_data; // Data from CampusCE
									var output = '';

									// verify data returned is JSON
									if ( typeof data == 'object' ) {
										output += '<ul class="list-group">';
										jQuery.each( data.courses, function( i, course ) {

											// Set variables for ease of use
											var campusce_url = campusce_base_url + course.CourseID + '&mc=' + course.CategoryID + '&pc=' + data.category.ParentID;
											var title = course.Title;
											var descr = course.WebDescr;

											// Build HTML output
											output += '<li class\="list-group-item">';
											output += '<h3><a href="' + campusce_url + '">' + title + '</a></h3>';
											output += '<p>' + descr + ' <a class="btn btn-default btn-xs" href="' + campusce_url + '">More <span class="sr-only"> about ' + title + '</span> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></p>';
											output += '</li>';
										});
										output += '</ul>';

									} else { // if non - JSON data is returned
										output += '<div class="well well-sm">';
										output += data;
										output += '</div>';
									}

									// Hide loading message
									jQuery("#loading-classes").hide( );

									// Output to DOM
									jQuery("#response_area").html( output ).slideDown( );
								}
							);
						});
					</script> 
					<noscript>
						JavaScript is required to view courses. Please enable JavaScript in your browser.
					</noscript>
					<div class="content-padding">
						<h2>Current <?php the_title( ); ?> Classes</h2>
						<div id="response_area"> </div>
						<p id="loading-classes" class="lead well well-sm"> <img src="/wp-includes/images/spinner.gif" alt="" /> &nbsp;Loading classes...</p>
					</div>
				<?php else : ?>
					<!-- Classes can not be retrieved. Class category code provided is in the wrong format, or is missing.-->
				<?php endif; ?>
			<?php else : // No AJAX Option
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
									<?php if ( empty( $class->CourseID ) == FALSE) {
										//Load title and desc in to variables, and force tags to be balanced
										$class_title = balanceTags( $class->Title, true );
										$class_desc  = balanceTags( wp_trim_words( $class->WebDescr, 40, '...' ), true );
										?>
										<?php $campusce_url = $campusce_base_url . $class->CourseID . '&mc=' . $class->CategoryID . '&pc=' . $parent_ID; ?>
										<li class="list-group-item">
											<h3><a href="<?php echo $campusce_url ?>"><?php echo $class_title ?></a></h3>
											<p><?php echo $class_desc ?> <a class="btn btn-default btn-xs" href="<?php echo $campusce_url ?>">More <span class="sr-only"> about <?php echo $class_title ?></span> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></p>
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



			<?php endif; ?>
		<?php else : 
			echo '<p>Error: Custom Functionality Plugin not active</p>';
		endif; ?>
	</section>
<?php endwhile; wp_reset_query( ); endif;
