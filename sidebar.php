<div class="sidebar span3 <?php
	$mayflower_options = mayflower_get_options();
	$current_layout = $mayflower_options['default_layout'];
	if ( $current_layout == 'sidebar-content' ) { 
		?>sidebarleft<?php
	} else {
		?>sidebarright<?php
	}; ?>">
		<?php dynamic_sidebar( 'global-widget-area' ); ?>

		<?php if( is_home() || is_single() ) :?>
			<?php dynamic_sidebar( 'blog-widget-area' ); ?>
		<?php else:?>

		<?php endif; ?>
</div><!-- span3 -->