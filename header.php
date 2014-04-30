<!DOCTYPE html>
<?php
	global $mayflower_options; 
	$mayflower_options = mayflower_get_options();
	
	global $globals_version;
	global $globals_url;
	global $globals_path;
	global $mayflower_brand;
	global $mayflower_brand_css;

	global $mayflower_theme_version;
	$mayflower_theme_version = wp_get_theme();
?>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<title><?php 
		$post_meta_data = get_post_custom($post->ID);
		if (isset($post_meta_data['_seo_custom_page_title'][0])) { 
			echo $post_meta_data['_seo_custom_page_title'][0];
		} else { 
			if (is_front_page() ) { bloginfo('name');
				?> @ Bellevue College<?php 
			} else {
				wp_title(" :: ",true, 'right'); 
			} 
		}
	?></title>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<?php if (isset($post_meta_data['_seo_meta_description'][0])) { ?><?php echo '<meta name="description" content="'?><?php echo $post_meta_data['_seo_meta_description'][0] . '" />'; ?> <?php  } else { } ?>
	<?php if (isset($post_meta_data['_seo_meta_description'][0])) { ?><?php echo '<meta name="keywords" content="'?><?php echo $post_meta_data['_seo_meta_keywords'][0] . '" />'; ?> <?php  } else { } ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/bellevue.ico" />
    <!--[if IE]><link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/bellevue.ico" /><![endif]-->
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" href="<?php echo $globals_url; ?>c/g.css?ver=<?php echo $globals_version; ?>">
    <link rel="stylesheet" media="print" href="<?php echo $globals_url; ?>c/p.css?ver=<?php echo $globals_version; ?>">
	<!--<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/font-awesome.css">-->
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>?ver=<?php echo $mayflower_theme_version->Version; ?>" type="text/css" media="screen" />

	<?php

	if( $mayflower_brand == 'lite' ) {  //allow for themes only for lite branding
		if( $mayflower_options['skin'] != 'default-color-scheme' ) { ?>
			<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/skins/'.$mayflower_options['skin'] . '.css' ?>" type="text/css" media="screen" /> <?php 
		}  
	}
	
	?>
	
    <script type="text/javascript" src="<?php echo $globals_url; ?>j/ghead.js?ver=<?php echo $globals_version; ?>"></script>
    <!--[if lt IE 9]><script type="text/javascript" src="<?php echo $globals_url; ?>j/respond.js?ver=<?php echo $globals_version; ?>"></script><![endif]-->

	<?php wp_head(); 
	
	$post_top_parent_id = 0; //if needed, this ID is set to the top parent of this post
	$is_main_site = FALSE;  //assume the site is not the root site, unless otherwhise specified
	
	//set $post_top_parent_id and $is_main_site for later use (ignore error404 page)
	if ( is_main_site() && !(is_404())) {
		$is_main_site = TRUE;  //this is the root site
		if ($post->post_parent!="0"){
			//this page has a parent
			if(intval($post->post_parent)>0)
			{
				while(intval($post->post_parent)>0)
					$post = get_post($post->post_parent);
			}
			$post_top_parent_id = $post->ID;  //now we now the top parent
		}
	}
	echo '<!-- parentid= '. $post_top_parent_id . '-->';
	?>            
</head>

<body <?php 
		//if this is the root site, set main college nav menu to highlight.
		if ($is_main_site == TRUE){
			if($post_top_parent_id == 0){
				if (isset($post_meta_data['_gnav_college_nav_menu'][0])) {
					body_class($post_meta_data['_gnav_college_nav_menu'][0]);	
				} else {
					body_class();
				}	
			} else {
				$meta_values = get_post_meta( $post_top_parent_id, '_gnav_college_nav_menu', true );
				if (isset($meta_values)) {
					body_class($meta_values);	
				} else {
					body_class();
				}
			}
		} else {
			body_class();	
		}
?>>
<?php
		//display ravealert message
	$rave_message = get_site_option('ravealert_currentMsg');
	$rave_class = get_site_option('ravealert_classCurrentMsg');
	if($rave_message!="")
	{
	?>
	<div id='alertmessage' class="<?php echo $rave_class;?>"><?php echo $rave_message;?></div>
	<?php
	}
	?>
	
    <?php
	##############################################
	### Branded or Lite versions of the header
	##############################################

		//$options = get_option('mayflower_site_options');

		

		if( $mayflower_brand == 'branded' )  {
			###############################
			### --- Branded version --- ###
			###############################
			bc_tophead_big();?>
            
			<?php
			//display site title on branded version 
			if ( is_main_site() && is_front_page() ) {
				?>
                <div id="main-wrap" class="<?php echo $mayflower_brand_css; ?> bchome">
           		<div id="main" class="container">
				<?php
			} else if (is_404()){
				?>
                <div id="main-wrap" class="<?php echo $mayflower_brand_css; ?>">
           		<div id="main" class="container">
				<?php
			} else { ?>
            
                <div id="main-wrap" class="<?php echo $mayflower_brand_css; ?>">
           		<div id="main" class="container">
				
                <div class="content-padding">
                <div id="site-header">
                    <h1 class="site-title">
                        <?php 
						if ($is_main_site == TRUE){
							if($post_top_parent_id == 0){
								the_title();
							} else {
								echo '<a href="'.get_permalink($post_top_parent_id).'">'.get_the_title($post_top_parent_id).'</a>';
							}
						} else {
							bloginfo('name'); 
						}
						?>
                    </h1>
                </div><!-- container header --> 
				</div><!-- content-padding --><?php
			}
			
		} else { 
			############################
			### --- Lite version --- ###
			############################
		
			bc_tophead(); ?>

<div id="main-wrap" class="<?php echo $mayflower_brand_css; ?>">
	<div id="main" class="container">
		<div class="container">
	    	<div id="site-header" class="row">
	       		<div class="span8">
	                <div class="content-padding">
	                    <?php 

	                    $header_image = get_header_image();
	                    if ( ! empty( $header_image ) ) : ?>
							<div class="header-image">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> : <?php bloginfo('description'); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
							</div><!-- header-image -->
	                    <?php else : ?>
	
	                        <h1 class="site-title">
	                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
	                        </h1>
	                        <p class="site-description"><?php bloginfo('description'); ?></p>
	
	                    <?php endif; ?>
	                
	                </div><!-- .content-padding -->
	            </div><!-- span8 -->
						<div class="span4">
	                        <div class="header-search content-padding <?php 
								if ( get_bloginfo('description') ) { 
									echo 'header-search-w-description ';
								} ?> 
								<?php if(get_bloginfo('description') <> '') {  
									echo 'header-social-links-no-margin ';
								 } ?>">
								 
	                		<div class="social-media">
	                    		<ul>
									<?php if (!empty($mayflower_options['facebook'])) {
										$facebook = esc_url($mayflower_options['facebook'] ); ?>
										<li><a href="<?php echo $mayflower_options['facebook']; ?>" title="facebook"><img src="<?php echo $globals_url; ?>i/facebook.png" alt="facebook" /></a></li>
									<?php } ?>
	
									<?php if (!empty($mayflower_options['twitter'])) { ?>
										<li><a href="<?php echo $mayflower_options['twitter']; ?>" title="twitter"><img src="<?php echo $globals_url; ?>i/twitter.png" alt="twitter" /></a></li>
									<?php } ?>
									
									<?php if (!empty($mayflower_options['flickr'])) { ?>
										<li><a href="<?php echo $mayflower_options['flickr']; ?>" title="flickr"><img src="<?php echo $globals_url; ?>i/flickr.png" alt="flickr" /></a></li>
									<?php } ?>
									
									<?php if (!empty($mayflower_options['youtube'])) { ?>
										<li><a href="<?php echo $mayflower_options['youtube']; ?>" title="youtube"><img src="<?php echo $globals_url; ?>i/youtube.png" alt="youtube" /></a></li>
									<?php } ?>
	
									<?php if (!empty($mayflower_options['linkedin'])) { ?>
										<li><a href="<?php echo $mayflower_options['linkedin']; ?>" title="linkedin"><img src="<?php echo $globals_url; ?>i/linkedin.png" alt="facebook" /></a></li>
									<?php } ?>
	                    		</ul>
	                    	</div><!-- social-media -->
	
		<?php $mayflower_adminonly_options = get_option( 'mayflower_admin_theme_general_options' ); ?>
	
		<?php if( empty( $mayflower_adminonly_options['hide_searchform'] ) ) { ?>
								<?php get_search_form(); ?>	

		<?php } else {}  ?>
		
	                        </div> <!--content-padding -->
						</div><!-- span4 -->
	        </div> <!--#site-header .row-->
		</div><!-- container -->            
        <div class="navbar">
            <div class="navbar-inner">
                    <?php
                        /** Loading WordPress Custom Menu with Fallback to wp_list_pages **/
                        wp_nav_menu( array(
							'theme_location' => 'nav-top',
                            'menu' => 'main-nav',
                            'container_class' => 'nav-collapse',
                            'menu_class' => 'nav',
                            'fallback_cb' => 'false',
                            'menu_id' => 'main-nav')
                        );
                    ?>
            </div><!-- navbar-inner -->
        </div><!-- navbar -->
   
		<?php } //end lite
?>