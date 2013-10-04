<div class="sidebar span3">
		<?php dynamic_sidebar( 'global-widget-area' ); ?>

		<?php if( is_home() || is_single() ) :?>
			<?php dynamic_sidebar( 'blog-widget-area' ); ?>
		<?php else:?>

		<?php endif; ?>
</div><!-- span3 -->