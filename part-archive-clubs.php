<?php
if( is_tax() ) {
    global $wp_query;
    $term = $wp_query->get_queried_object();
    $title = $term->name;
    $description = $term->description;
}

/* Sort Alphabetically */
global $query_string;
query_posts( $query_string . '&orderby=title&order=ASC&posts_per_page=-1' );
?>
<div class="content-padding">
    <h1><?php if( is_tax() ) {
                echo $title;
              }
        ?> Student Clubs</h1>
        <?php if( is_tax() && !empty($description)) {
                ?><p class="lead"><?php echo $description; ?></p>
    <?php }
            ?><ul><?php
                    
                    if (have_posts()) : while (have_posts()) : the_post(); ?>
                        
						<li <?php post_class() ?>>
							<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
						</li>

				<?php endwhile;?>
            </ul>
			</div><!-- content-padding -->
				<?php wp_reset_postdata(); ?>
	
					
					<ul class="pager content-padding">
						<li>
							<?php previous_posts_link('<i class="icon-chevron-left"></i> Previous Page'); ?>
						</li>
						<li>
							<?php next_posts_link('Next page <i class="icon-chevron-right"></i>'); ?>
						</li>
					</ul>
					<?php wp_reset_query(); ?>
					<?php else : ?>
					<?php endif; ?>