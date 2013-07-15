<div class="sidebar span3">

	<?php
		/** Loading WordPress Custom Menu **/
			wp_nav_menu( array(
				'theme_location' => 'side-nav',
				'container' => 'false',
				'fallback_cb' => 'false',
			    'items_wrap' => '<ul class="section-nav section-nav-list" id="my-collapse-nav"><li class="section-nav-header">In this section: </li>%3$s</ul>',
				'link_before'          => '<span class="arrow"></span>'
				)
			);
	?>

	<div class="content-padding">
		<?php dynamic_sidebar( 'global-widget-area' ); ?>

		<?php if( is_home() || is_single() ) :?>
			<?php dynamic_sidebar( 'blog-widget-area' ); ?>
		<?php else:?>

		<?php endif; ?>

	</div><!-- content-padding -->
</div><!-- span3 -->