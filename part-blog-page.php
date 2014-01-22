<?php
	 if (is_active_sidebar('top-global-widget-area') || is_active_sidebar('blog-widget-area') || is_active_sidebar('global-widget-area')) { ?>
	
	<?php //IF SIDEBAR HAS CONTENT ?>
									<div class="row row-padding">  
									<?php
									$mayflower_options = mayflower_get_options();
									$current_layout = $mayflower_options['default_layout'];
									if ( $current_layout == 'sidebar-content' ) { 
										get_sidebar(); 
									}; ?>
										
									    <div class="span9">
									    <?php 
									    if( $mayflower_options['slider_toggle'] == 'true' ) { 
									       if ( $mayflower_options['slider_layout'] == 'featured-in-content' ) { 
									            get_template_part('part-featured-in-content'); 
									        } 
									    }  
									    if ( is_home() ) {
									        // If we are loading the Blog home page (home.php)
									        get_template_part('part-home');
									    } else if ( is_page_template('page-staff.php') ) {
									        // If we are loading the staff page template
									        get_template_part('part-staff');
									    } else if ( is_singular('staff') ) {
									        // If we are loading the single-staff 
									        get_template_part('part-single-staff');
									    } else if ( is_page_template('page-nav-page.php') ) {
									        // If we are loading the navigation-page page template
									        get_template_part('part-nav-page');
									    } else if ( is_single() ) {
									        // If we are loading the single post template (single.php)
									        get_template_part('part-single');
										} else if ( is_archive() ) {
											// If we are loading the navigation-page page template
											get_template_part('part-archive');
									    } else {
											
									        if ( have_posts() ) : while ( have_posts() ) : the_post(); 
												?>

									            <div class="content-padding <?php 
									                //display slider in content if option is selected
									                if ( ($mayflower_options['slider_toggle'] == 'true') && ($mayflower_options['slider_layout'] == 'featured-in-content')){ 
									                    echo "row-padding";
									                } 
									            ?>">
									            <?php
									                
									            if (is_front_page() ) {
									                //don't show the title on the home page
									            } else { 
									                if ( is_main_site()) {
									                    //if main site, only show title here if page is not top-most ancestor
									                    if(intval($post->post_parent)>0){
									                        ?><h1><?php the_title(); ?></h1><?php
									                    }
									                } else {
									                    ?><h1><?php the_title(); ?></h1><?php
									                }
									            }; ?>
									            
									            </div><!--.content-padding-->
									            
									            <?php
									            if($post->post_content=="") : ?>
									                <!-- Don't display empty the_content or surround divs -->
									                <?php
									            else : ?>	
									                <div class="content-padding">
									                <?php 
									                the_content(); ?>
									                </div> <!--.content-padding-->
									                <?php 
									            endif; 
									                        
									            get_template_part('part-blogroll'); ?>
									            <?php
									        endwhile; else: ?>
									                <p><?php _e('Sorry, these aren\'t the bytes you are looking for.'); ?></p>
									        <?php 
									        endif; 
									    } ?>
									    </div><!-- span9 --><?php
								    
								    if ( $current_layout == 'content-sidebar' ) {
								        get_sidebar();
								    } else {};
								    ?>
								 
									</div><!-- .row .row-padding -->	
	<?php
	} //END IF SIDEBAR HAS CONTENT
	
	else {
	//SIDEBAR IS EMPTY
	?>
								    <div class="row-padding">
								    <?php
									if ( is_home() ) {
										// If we are loading the Blog home page (home.php)
										get_template_part('part-home');
									} else if ( is_page_template('page-staff.php') ) {
										// If we are loading the staff page template
										get_template_part('part-staff');
									} else if ( is_singular('staff') ) {
										// If we are loading the single-staff 
										get_template_part('part-single-staff');
									} else if ( is_page_template('page-nav-page.php') ) {
										// If we are loading the navigation-page page template
										get_template_part('part-nav-page');
									} else if ( is_single() ) {
										// If we are loading the navigation-page page template
										get_template_part('part-single');
									} else if ( is_archive() ) {
										// If we are loading the navigation-page page template
										get_template_part('part-archive');
									} else { 
									
										if ( have_posts() ) : while ( have_posts() ) : the_post(); 
								?>
								        
								            <div class="content-padding <?php 
								                //display slider in content if option is selected
								                if ( ($mayflower_options['slider_toggle'] == 'true') && ($mayflower_options['slider_layout'] == 'featured-in-content')){ 
								                    echo "row-padding";
								                } 
								            ?>">
								            <?php
								                
								            if (is_front_page() ) {
								                //don't show the title on the home page
								            } else { 
								                if ( is_main_site()) {
								                    //if main site, only show title here if page is not top-most ancestor
								                    if(intval($post->post_parent)>0){
								                        ?><h1><?php the_title(); ?></h1><?php
								                    }
								                } else {
								                    ?><h1><?php the_title(); ?></h1><?php
								                }
								            }; ?>
								            
								            </div><!--.content-padding-->
								            
								            <?php
								            if($post->post_content=="") : ?>
								                <!-- Don't display empty the_content or surround divs -->
								                <?php
								            else : ?>	
								                <div class="content-padding">
								                <?php 
								                the_content(); ?>
								                </div> <!--.content-padding-->
								                <?php 
								            endif; 
								                        
								            get_template_part('part-blogroll'); ?>
								            
										<?php
										endwhile; else: ?>
										<p><?php _e('Sorry, these aren\'t the bytes you are looking for.'); ?></p>
										<?php endif; 
									} ?>
								    </div><!--.row-padding-->

	<?php
	} //END SIDEBAR IS EMPTY
	?>