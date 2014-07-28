	<div id="main-nav-wrap" class="lite">
	  <div class="container">
						<nav id="college-navbar" class="navbar navbar-default" role="navigation">
	                    <?php
	                        /** Loading WordPress Custom Menu with Fallback to wp_list_pages **/
	                        wp_nav_menu( array(
															'theme_location' => 'nav-top',
													  	'menu_class'      	=> 'nav navbar-nav',														
	                            'fallback_cb' => 'false',
	                            'items_wrap' => '<ul class="nav navbar-nav" id="main-nav"><li id="nav-top"><a href="#top">Top ^</a></li>%3$s</ul>',
	                            'menu_id' => 'main-nav')
	                        );
	                    ?>
						</nav><!-- navbar -->
		</div><!-- /.container -->
	</div><!-- main-nav-wrap -->
</div> <!-- .flexwrap -->