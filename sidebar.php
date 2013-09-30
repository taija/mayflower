<div class="sidebar span3">

	<div class="content-padding">
		<?php dynamic_sidebar( 'global-widget-area' ); ?>

		<?php if( is_home() || is_single() ) :?>
			<?php dynamic_sidebar( 'blog-widget-area' ); ?>
		<?php else:?>

		<?php endif; ?>

	</div><!-- content-padding -->
</div><!-- span3 -->