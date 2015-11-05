<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
/*  Template for displaying post type for the student-club plugin.
    https://github.com/BellevueCollege/student-club
*/

if (have_posts()) :
	while (have_posts()) : the_post();
		 ?>
	<div class="content-padding">
		<div class="row">
			<div class="col-md-12">
					<h1><?php the_title()?></h1>

					<?php the_content(); ?>
					
					<h2>Current <?php the_title(); ?> Classes</h3>
					
					<?php $category_ID = get_post_meta( get_the_ID(), '_ct_text_562fe946ccfcd', true );?>

					<?php if ( is_plugin_active('ce-custom-functions/ce-custom-functions.php') ) { 
						$courses = CE_Custom_Functions::cecf_get_courses_by_category_id($category_ID);
						$parent_ID = '';
					}?>

					<ul class="list-group">
					
					<?php foreach($courses as $class) { ?>
						<?php if(empty($class->ParentID) == FALSE) { 
							$parent_ID = $class->ParentID;}?>						
						<?php if(empty($class->CourseID) == FALSE) { ?>
						<?php $campusce_url = '/ce/category/course-details/?CourseID=' . $class->CourseID . '&ParentID=' . $parent_ID . '&CategoryID=' . $class->CategoryID . '&Name=' . $class->Title; ?>
						<li class="list-group-item">
								<h3><a href="<?php echo $campusce_url ?>"><?php echo $class->Title ?></a></h3>
								<p><?php echo substr($class->WebDescr,0,140) ?>... <a href="<?php echo $campusce_url ?>">More »</a></p>
						</li>
						<?php } ?>
																	
					<?php } ?>
					</ul>
				
			</div>
		</div>
	</div><!--.content-padding-->

	<?php endwhile;
	wp_reset_query();
endif;
?>