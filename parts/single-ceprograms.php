<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
/*  Template for displaying post type for the continuing education plugin.
    https://github.com/BellevueCollege/ce-custom-functionality
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

					<?php if ( is_plugin_active ( 'ce-custom-functionality/ce-custom-functionality.php' ) ) { 
                        $field_id = CE_Plugin_Settings::get_ce_field_id();
                        $category_ID = get_post_meta ( get_the_ID(), $field_id , true );
						$courses = CE_Custom_Functions::cecf_get_courses_by_category_id ( $category_ID );
						$category = CE_Custom_Functions::cecf_get_category_by_id ( $category_ID );
						$parent_ID = $category->ParentID; ?>
					
					<ul class="list-group">
					
					<?php foreach ( $courses as $class ) { ?>				
						<?php if(empty($class->CourseID) == FALSE) { ?>
						<?php $campusce_url = 'http://www.campusce.net/BC/course/course.aspx?C=' . $class->CourseID . '&mc=' . $class->CategoryID . '&pc=' . $parent_ID; ?>
						<li class="list-group-item">
								<h3><a href="<?php echo $campusce_url ?>"><?php echo $class->Title ?></a></h3>
								<p><?php echo substr($class->WebDescr,0,140) ?>... <a href="<?php echo $campusce_url ?>">More »</a></p>
						</li>
						<?php } ?>
																	
					<?php } ?>
					</ul>									
					
					<?php } else { echo "The plugin is not active!"; } ?>				
			</div>
		</div>
	</div><!--.content-padding-->

	<?php endwhile;
	wp_reset_query();
endif;
?>