<?php
	global $mayflower_options; 
	$mayflower_options = mayflower_get_options();
	
	global $globals_version;
	global $globals_path_over_http;
	global $mayflower_brand;
	global $mayflower_brand_css;

	global $mayflower_theme_version;
	$mayflower_theme_version = wp_get_theme();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title> 
		<?php 
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

<?php if (isset($post_meta_data['_seo_meta_description'][0])) { ?><?php echo '<meta name="description" content="'?><?php echo $post_meta_data['_seo_meta_description'][0] . '" />'; ?> <?php  } else { } ?>

<?php if (isset($post_meta_data['_seo_meta_description'][0])) { ?><?php echo '<meta name="keywords" content="'?><?php echo $post_meta_data['_seo_meta_keywords'][0] . '" />'; ?> <?php  } else { } ?>

	
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
    <link rel="icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/bellevue.ico" />
    <!--[if IE]><link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/bellevue.ico" /><![endif]-->
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" href="<?php echo $globals_path_over_http; ?>c/g.css?ver=<?php echo $globals_version; ?>">
    <link rel="stylesheet" media="print" href="<?php echo $globals_path_over_http; ?>c/p.css?ver=<?php echo $globals_version; ?>">
	<!--<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/font-awesome.css">-->
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>?ver=<?php echo $mayflower_theme_version->Version; ?>" type="text/css" media="screen" />

	<?php

	if( $mayflower_brand == 'lite' ) {  //allow for themes only for lite branding
		if( $mayflower_options['skin'] != 'default-color-scheme' ) { ?>
			<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/skins/'.$mayflower_options['skin'] . '.css' ?>" type="text/css" media="screen" /> <?php 
		}  
	}
	
	?>
	
    <script type="text/javascript" src="<?php echo $globals_path_over_http; ?>j/ghead.js?ver=<?php echo $globals_version; ?>"></script>
    <!--[if lt IE 9]><script type="text/javascript" src="<?php echo $globals_path_over_http; ?>j/respond.js?ver=<?php echo $globals_version; ?>"></script><![endif]-->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
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
            
            <div id="main-wrap" class="<?php echo $mayflower_brand_css; ?>">
            <div id="main" class="container">

			<?php
			//display site title on branded version 
			if ( is_main_site() && is_front_page() ) {
				//do nothing
			} else { ?>
                <div id="site-header">
                    <h1 class="site-title">
                        <?php bloginfo( 'name' ); ?>
                    </h1>
                </div><!-- container header --> <?php
			}
			
		} else { 
			############################
			### --- Lite version --- ###
			############################
		
			bc_tophead(); ?>

<div id="main-wrap" class="<?php echo $mayflower_brand_css; ?>">
	<div id="main" class="container">
    	<div id="site-header" class="row">
       		<div class="span8">
                <div class="content-padding">
                    <?php 
                    //the header_image functionality is not set on dashboard yet.  Still needs to be defined
                    $header_image = get_header_image();
                    if ( ! empty( $header_image ) ) : ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>" height="100px" width="auto" alt="" /></a>
                    <?php else : ?>

                        <h1 class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                        </h1>
                        <p class="site-description"><?php bloginfo('description'); ?></p>

                    <?php endif; ?>
                </div><!-- header-logo -->
            </div><!-- span8 -->
            
            <div class="span4 header-search pull-right">
                <div class="content-padding <?php 
                    if ( get_bloginfo('description') ) { 
                        echo 'top-spacing10';
                    }
                    ?>">
                    <?php get_search_form(); ?>	
                </div><!-- content-padding -->		
            </div><!-- span4 -->
        </div> <!--#site-header .row-->
            
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