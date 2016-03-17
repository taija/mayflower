<div class="sidebar col-md-3 <?php
		$mayflower_options = mayflower_get_options();
		$current_layout = $mayflower_options['default_layout'];
		if ( $current_layout == 'sidebar-content' ) { 
			?>sidebarleft col-md-pull-9<?php
		} else {
			?>sidebarright<?php
		}; ?>">

		<?php if ( is_active_sidebar( 'top-global-widget-area' ) ) : ?>
			<?php dynamic_sidebar( 'top-global-widget-area' ); ?>
		<?php endif; ?>

		<?php // Hook to allow display of more widget areas
		mayflower_display_sidebar(); ?>

		<?php if ( is_active_sidebar( 'page-widget-area' ) ) : ?>
			<?php if( mayflower_is_blog() ) { } else 
			 dynamic_sidebar( 'page-widget-area' ); ?>
		<?php endif; ?>
	
		<?php if ( is_active_sidebar( 'blog-widget-area' ) ) : ?>
			<?php if( mayflower_is_blog() ) :?>
				<?php dynamic_sidebar( 'blog-widget-area' ); ?>
			<?php endif;?>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'global-widget-area' ) ) : ?>
			<?php dynamic_sidebar( 'global-widget-area' ); ?>
		<?php endif; ?>

</div><!-- col-md-3 -->