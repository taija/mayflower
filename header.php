<?php global $mayflower_options; $mayflower_options = mayflower_get_options(); ?>
<?php
// Get Mayflower version number from Mayflower network settings
	$network_mayflower_settings = get_site_option( 'mayflower_network_mayflower_settings' );
 	$mayflower_version = $network_mayflower_settings['mayflower_version']; 
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php 
		if (is_front_page() ) { bloginfo('name');
			?> @ Bellevue College<?php 
		} else {
			wp_title(" :: ",true, 'right'); 
		} 
	?></title>
	
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/bellevue.ico" />
    <!--[if IE]><link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/bellevue.ico" /><![endif]-->
		
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/globals.css">
	<!--<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/bootstrap.css">-->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/font-awesome.css">
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>?ver=<?php echo $mayflower_version; ?>" type="text/css" media="screen" />

			<?php
				if( $mayflower_options['skin'] != 'default-color-scheme' ) { ?>
				<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/skins/'.$mayflower_options['skin'] . '.css' ?>" type="text/css" media="screen" />
				<?php }  ?>

	

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	//Set up a class depending on mayflower version used
	$mayflowerVersionCSS = "globals-branded";
	Global $mayflowerVersion;
	if( $mayflower_options['mayflower_version'] == 'department' ) {
		$mayflowerVersionCSS = "globals-lite";
		$mayflowerVersion = "lite";
	} else {
		$mayflowerVersion = "branded";
	}
	
	##############################################
	### Branded or Lite versions of the header
	##############################################

		//$options = get_option('mayflower_site_options');

		###############################
		### --- Branded version --- ###
		###############################

		if( $mayflower_options['mayflower_version'] == 'official' ) {

			bc_tophead_big();

			//display site title on branded version ?>

			<div class="container header">
				<h1 class="site-title">
					<?php bloginfo( 'name' ); ?>
				</h1>
			</div><!-- container header -->

		<div class="container wrapper bcause-branded"><!-- box shadow container --> <!--NEED TO UPDATE BCAUSE reference-->
		<div class="container content"><!-- content container -->

		<?php } //end branded

		############################
		### --- Lite version --- ###
		############################

		 elseif ( $mayflower_options['mayflower_version'] == 'department' ) { ?>

				<?php bc_tophead(); ?>

<div id="main-wrap" class="<?php echo $mayflowerVersionCSS; ?>">
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

		########################
		### --- Fallback --- ###
		########################

			else
		{
				bc_tophead_big();

		} // end lite ?>