<?php
/*
Template Name: BC home page
*/
?>

<?php global $mayflower_options; $mayflower_options = mayflower_get_options(); ?>
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
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />

			<?php
				if( $mayflower_options['skin'] != 'default-color-scheme' ) { ?>
				<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/skins/'.$mayflower_options['skin'] . '.css' ?>" type="text/css" media="screen" />
				<?php }  ?>

	
   
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/homepage.css">
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/test.js"></script>
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/respond.js"></script>
	<?php wp_head(); ?>
    
	
</head>

<body <?php body_class(); ?>>

	<?php
	//Set up a class depending on mayflower version used and set variable to minimize calls to DB from theme optiosn
	

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


		###############################
		### --- Branded version --- ###
		###############################
		
		
			bc_tophead_big();
		
	
			
			

			//display site title on branded version ?>
            


<div id="main-wrap">
		<div class="container wrapper bcause-branded"><!-- box shadow container --> <!--NEED TO UPDATE BCAUSE reference-->
		<div class="container"><!-- content container -->


	<?php
		$mayflower_options = mayflower_get_options();
		$current_layout = $mayflower_options['default_layout'];

		 //echo do_shortcode('[AllClassInformation course="ECON"]');
		 //echo do_shortcode('[OneClassInformation course="ABE" number="042"]');
	?>
		
 
        <div class="content-row bchomepage" id="content">
        
        <ul id="mobilelinks" class="clearfix">
            <li><a href="http://bellevuecollege.edu/about/gettinghere/maps/" class="btn btn-info">Maps</a></li>
            <li><a href="http://bellevuecollege.edu/about/around/directions/" class="btn btn-info">Directions</a></li>
            <li><a href="http://bellevuecollege.edu/contacts/" class="btn btn-info">Contact Us</a></li>
		</ul>
        
        
        <section class="box-shadow" id="menusfor">
        	<div class="content-padding">
                <h2>Menus for:</h2>
                <ul>
                    <li><a href="http://bellevuecollege.edu/students/">Students</a></li>
                    <li><a href="http://bellevuecollege.edu/future/">Future Students</a></li>
                    <li><a href="http://bellevuecollege.edu/isp/">International Students</a></li>
                    <li><a href="http://bellevuecollege.edu/employees/">Faculty &amp; Staff</a></li>
                    <li><a href="http://bellevuecollege.edu/businesses/">Businesses</a></li>
                    <li><a href="http://bellevuecollege.edu/visitors/">Visitors &amp; Community</a></li>
             	</ul>
             </div>
         </section>
		<section id="homeslider">
		
			 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>




<?php if ( is_front_page() ) {

	    $mayflower_options = mayflower_get_options();
	    if( $mayflower_options['slider_toggle'] === true && $mayflower_options['slider_layout'] === 'featured-full') { ?>
					<div id="myCarousel" class="carousel slide full box-shadow">
						 <ol class="carousel-indicators">
							<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
							<li data-target="#myCarousel" data-slide-to="1"></li>
							<li data-target="#myCarousel" data-slide-to="2"></li>
						</ol>

						<div class="carousel-inner">
							<?php
							$the_query = new WP_Query(array(
								'post_type'=>'slider',
								'orderby'=> 'menu_order',
								'order'=> 'ASC',
								'posts_per_page' => 1,
							));
							while ( $the_query->have_posts() ) :
							$the_query->the_post();
							?>
	
							<div class="item active">
								<?php
							        // If url field has content, add the URL to the post thumbnail.
									$slider_ext_url = get_post_meta($post->ID, 'slider_url', true);
								        if ( !empty( $slider_ext_url ) )
									{ ?>
	
									<h2>
										<a href="<?php echo esc_url($slider_ext_url);?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('featured-full');?></a>
									</h2>
	
									<?php } else { ?>
	
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured-full');?></a>
								<?php	} //end else ?>
	
							<?php
								//should we show title & excerpt?
								$mayflower_options = mayflower_get_options();
									if ($mayflower_options['slider_title'] == 'true' || $mayflower_options['slider_excerpt'] == 'true' ) { ?>
	
	
									<div class="carousel-caption">
										<?php
											if ($mayflower_options['slider_title'] == 'true') {
										        // If a post class has input, sanitize it and add it to the post class array.
												$slider_ext_url = get_post_meta($post->ID, 'slider_url', true);
											        if ( !empty( $slider_ext_url ) )
												{ ?>
	
												<h2>
													<a href="<?php echo esc_url($slider_ext_url);?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
												</h2>
	
												<?php } else { ?>
													<h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
	
											<?php	} //end else ?>
										<?php } else { } ?>
	
										<?php if ($mayflower_options['slider_excerpt'] == 'true' ) { ?>
											<?php the_excerpt(); ?>
										<?php } else { } ?>
	
									</div><!-- carousel-caption -->
	
							<?php } else  { } ?>
	
							</div><!-- item active -->
	
							<?php
								endwhile;
									wp_reset_postdata();
							?>
	
							<?php
								$the_query = new WP_Query(array(
									'post_type'=>'slider',
									'orderby'=> 'menu_order',
									'order'=>'ASC',
									'posts_per_page' => ($mayflower_options['slider_number_slides'] -1), // subtract 1 (-1) is here to account for the first loop.
									'offset' => 1
								));
								while ( $the_query->have_posts() ) :
								$the_query->the_post();
							?>
							<div class="item">
								<?php
							        // If a post class has input, sanitize it and add it to the post class array.
									$slider_ext_url = get_post_meta($post->ID, 'slider_url', true);
								        if ( !empty( $slider_ext_url ) )
									{ ?>
	
									<h2>
										<a href="<?php echo esc_url($slider_ext_url);?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('featured-full');?></a>
									</h2>
	
									<?php } else { ?>
	
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured-full');?></a>
								<?php	} //end else ?>
	
							<?php
								//should we show title & excerpt?
								$mayflower_options = mayflower_get_options();
									if ($mayflower_options['slider_title'] == 'true' || $mayflower_options['slider_excerpt'] == 'true' ) { ?>
	
	
									<div class="carousel-caption">
										<?php
											if ($mayflower_options['slider_title'] == 'true') {
										        // If a post class has input, sanitize it and add it to the post class array.
												$slider_ext_url = get_post_meta($post->ID, 'slider_url', true);
											        if ( !empty( $slider_ext_url ) )
												{ ?>
	
												<h2>
													<a href="<?php echo esc_url($slider_ext_url);?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
												</h2>
	
												<?php } else { ?>
													<h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
	
											<?php	} //end else ?>
										<?php } else { } ?>
	
										<?php if ($mayflower_options['slider_excerpt'] == 'true' ) { ?>
											<?php the_excerpt(); ?>
										<?php } else { } ?>
	
									</div><!-- carousel-caption -->
	
							<?php } else  { } ?>
	
							</div><!-- item -->
	
							<?php
								endwhile;
								wp_reset_postdata();
							?>
						</div><!-- carousel-inner -->
	
						<?php
							$published_posts = wp_count_posts('slider')->publish;
							if ($published_posts >1 ) { ?>
								<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
								<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
						<?php } else //don't show controls ?>
	
					</div><!-- #myCarousel -->
	

		<?php } elseif( $mayflower_options['slider_toggle'] == 'false' ) { } ?>

<?php
} else {
	// This is not a homepage so display nothing
		}
?>
</section> 
</div><!--.row-->

<div class="content-row">

<section id="home-news">
    <header class="content-padding">
              <h2>News &amp; Announcements</h2>
    </header>
    <div  class="content-padding">
          <ul>
             <li><a href="http://news.bellevuecollege.edu/2013/06/bellevue-college-wins-prestigious-climate-leadership-award/">Bellevue College wins prestigious climate leadership award</a></li>
              <li><a href="http://news.bellevuecollege.edu/2013/05/nursing-instructor-earns-presitigious-scholarship/">Nursing instructor earns prestigious scholarship</a></li>
              
              <li><a href="http://news.bellevuecollege.edu/2013/05/bellevue-college-working-to-close-skills-gap-that-hinders-employment/">Bellevue College working to close 'skills gap' that hinders employment</a></li>
              <li><a class="more" href="http://news.bellevuecollege.edu/"><strong>More news...</strong><span class="arrow"></span></a></li>
        </ul>
    </div>
</section>

<section id="home-events">
    <header class="content-padding">
              <h2>Events</h2>
    </header>
    <div  class="content-padding">
          <ul>
        <!-- begin event listing -->
            <li><a href="http://bellevuecollege.edu/events/event-details/?mc_id=1818"><strong>7/25</strong> - Healthcare Programs Information Session</a></li>
            <li><a href="http://bellevuecollege.edu/events/event-details/?mc_id=1229"><strong>8/10</strong> - Diagnostic Ultrasound August Graduation</a></li>
            <li><a href="http://bellevuecollege.edu/events/event-details/?cid=all&amp;mc_id=1820"><strong>8/15</strong> - Healthcare Programs Information Session</a></li>
            <!-- end event listing -->
            <li><a class="more" href="http://bellevuecollege.edu/events"><strong>More events...</strong></a></li>
            <li><a id="calendar" href="/enrollment/calendar/"><strong>Academic Calendar</strong></a> </li>
            
        </ul>
    </div>
</section>

<!--<div id="homeads">

	
</div>-->

<div id="home-sidelinks">
	<p id="apply" ><a href="/enrollment/admissions/#content" class="btn btn-success"><strong>Apply</strong> for admissions</a></p>
    <!--<p id="donate"><a href="https://bellevuecollege.edu/foundation/donate/">Give to Bellevue College</a></p>-->
    
    <p id="homead">
    	<a href="http://bellevuecollege.edu/athletics/"><img src="/globals/2.0/temp/adsmall2.gif" class="box-shadow"></a>
	</p>
	
	

</div>
</div><!-- .row -->	
</div> <!-- #mainwrap-->					
				
           


	<?php endwhile; else: ?>
    <p><?php _e('Sorry, these aren\'t the bytes you are looking for.'); ?></p>
    <?php endif; ?>

	
    
    
<?php get_footer(); ?>