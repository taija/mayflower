<?php
### Sidebar - Contains Sub Page navigation
### Automatically appears if sub-nav exists
?>

<?php
/* Check which layout option is being used */
/* If a layout without a sidebar is selected don't run this code

	$options = get_option( 'mayflower_layout_options' );

//	$options = mayflower_get_theme_options();
	$current_layout = $options['theme_layout'];

	if ( 'content' != $current_layout ) :
*/
?>

		<div class="sidebar span3 pull-left">
			<!-- <div class="content-padding-left-right"> -->


			<?php /*
			if($post->post_parent) {
				$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
				$titlenamer = get_the_title($post->post_parent);
			}

			else {
				$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
				$titlenamer = get_the_title($post->ID);
			}
			if ($children) { ?>

				<ul class="nav nav-tabs nav-stacked">
					<li class="nav-header">In this section:</li>
					<?php echo $children; ?>
				</ul>

			<?php } */ ?>


			<!-- <ul class="section-nav section-nav-list" id="my-collapse-nav"> -->
				<!-- <li class="section-nav-header">In this section:</li> -->
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
			<!-- </ul> -->

			<div class="content-padding-left-right">
				<?php dynamic_sidebar( 'global-widget-area' ); ?>

				<?php if( is_home() || is_single() ) :?>
					<?php dynamic_sidebar( 'blog-widget-area' ); ?>
				<?php else:?>

				<?php endif; ?>

			</div><!-- content-padding-left-right -->
			<!-- </div> --><!-- content-padding-left -->
		</div><!-- span3 -->

<!--
			$('#subnav ul ul').hide();
			//mark item as selected and show submenu if necessary
			$('#subnav ul a[href="' + folderpath + '"]').addClass('selected');
			$('#subnav > ul > li > a.selected').siblings('ul').slideDown();
			$('#subnav ul a.selected').parents('ul').show();
			$('#subnav ul ul ul').hide();
-->
		<!-- <script>

				jQuery('ul.section-nav ul.sub-menu').hide();
				//mark item as selected and show submenu if necessary
				/* $('#subnav ul a[href="' + folderpath + '"]').addClass('selected'); */
				jQuery('ul.section-nav > li.current-menu-item a').siblings('ul').fadeIn(800);
				jQuery('ul.section-nav .current-menu-item').parents('ul').show();
				jQuery('ul.section-nav ul ul').hide();
		</script> -->

<!--
		<script>
			jQuery(document).ready(function(){
				jQuery('ul.section-nav li.menu-item a').click(function(e){
				  e.preventDefault();
				  if (jQuery(this).parent().children('.sub-menu:first').is(':visible')) {
				       jQuery(this).parent().children('.sub-menu:first').hide();
				  } else {
				       jQuery(this).parent().children('.sub-menu:first').show().slideDown();
				  }
				});
			});
		</script>
-->
<?php // endif; ?>