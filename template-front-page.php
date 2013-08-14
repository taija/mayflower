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
    <link rel="stylesheet" href="<?php echo $globals_path_over_http; ?>c/g.css?ver=<?php echo $globals_version; ?>">
    <link rel="stylesheet" media="print" href="<?php echo $globals_path_over_http; ?>c/p.css?ver=<?php echo $globals_version; ?>">
	<!--<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/font-awesome.css">-->
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>?ver=<?php echo $mayflower_theme_version->Version; ?>" type="text/css" media="screen" />


    <script type="text/javascript" src="<?php echo $globals_path_over_http; ?>j/ghead.js?ver=<?php echo $globals_version; ?>"></script>
    <!--[if IE]><script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/responsive-nav.js/1.0.14/responsive-nav.min.js"></script><![endif]-->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
		bc_tophead_big();
	 ?>
            


<div id="main-wrap" class="<?php echo $mayflower_brand_css; ?>">
		<div class="container wrapper">
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

					<?php get_template_part('part-featured-full'); ?>

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
		<?php
			$the_query = new WP_Query(array(
				'post_type'=>'small_ad',
				'orderby'=> 'rand',
				'order'=> 'ASC',
				'posts_per_page' => 1,
			));

			while ( $the_query->have_posts() ) :
			$the_query->the_post();
		?>

		<?php
	        // If url field has content, add the URL to the post thumbnail.
				$small_ad_ext_url = get_post_meta( $post->ID, '_small_ad_url', true );


		        if ( !empty( $small_ad_ext_url ) )
			{ ?>

			<h2>
				<a href="<?php echo esc_url($small_ad_ext_url);?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('home-small-ad');?></a>
			</h2>

			<?php } else { ?>

		<a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('home-small-ad');?> </a>
		<?php	} //end else ?>

<!--     	<a href="http://bellevuecollege.edu/athletics/"><img src="/globals/2.0/temp/adsmall2.gif" class="box-shadow"></a> -->
	</p>
		<?php
			endwhile;
				wp_reset_postdata();
		?>

</div>
</div><!-- .row -->	
</div> <!-- #mainwrap-->					
				
           


	<?php endwhile; else: ?>
    <p><?php _e('Sorry, these aren\'t the bytes you are looking for.'); ?></p>
    <?php endif; ?>

	
    
    
<?php get_footer(); ?>