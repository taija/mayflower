<?php
/*
Plugin Name:  Mayflower Social Links
Plugin URI:   http://www.bellevuecollege.edu/
Description:  Social Links Widget.
Version:      0.1
Author:       BC DevCom
Author URI:   http://www.bellevuecollege.edu/
*/


add_action( 'wp_enqueue_scripts', 'add_my_stylesheet' );
function add_my_stylesheet() {

    $css_path =WP_CONTENT_URL . '/themes/mayflower/inc/mayflower-social-links/mayflower_social_links.css';
 echo <<<EOF
<style type="text/css">
div.widget[id*=_monkeyman_] .widget-title {
    color: #2191bf;
}
</style>
EOF;
    // registers your stylesheet

		wp_register_style( 'mayflower_social_styles', 
			$css_path, 
			array(), 
			null, 
			'all' );
			

    // loads your stylesheet
    wp_enqueue_style( 'mayflower_social_styles' );
}


class mayflower_social_links extends WP_Widget {

// constructor
    function mayflower_social_links() {
        parent::WP_Widget(false, $name = __('Social Links', 'wp_widget_plugin') );
    }

// widget form creation (dashboard)
function form($instance) {

	// Check values
	if( $instance) {
	     $social_title = esc_attr($instance['social_title']);
	     $facebook_url = esc_attr($instance['facebook_url']);
	     $twitter_url = esc_attr($instance['twitter_url']);
	     $youtube_url = esc_attr($instance['youtube_url']);
	     $vimeo_url = esc_attr($instance['vimeo_url']);
	     $picasa_url = esc_attr($instance['picasa_url']);
	     $flickr_url = esc_attr($instance['flickr_url']);
	     $googleplus_url = esc_attr($instance['googleplus_url']);
	     $linkedin_url = esc_attr($instance['linkedin_url']);
	} else {
	     $social_title = '';
	     $facebook_url = '';
	     $twitter_url = '';
	     $youtube_url = '';
	     $vimeo_url = '';
	     $picasa_url = '';
	     $flickr_url = '';
	     $googleplus_url = '';
	     $linkedin_url = '';
	}
?>

<p>
<label for="<?php echo $this->get_field_id('social_title'); ?>"><?php _e('Title:', 'wp_widget_plugin'); ?></label>
<input id="<?php echo $this->get_field_id('social_title'); ?>" class="widefat" name="<?php echo $this->get_field_name('social_title'); ?>" type="text" value="<?php echo $social_title; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('facebook_url'); ?>"><?php _e('Facebook URL:', 'wp_widget_plugin'); ?></label>
<input id="<?php echo $this->get_field_id('facebook_url'); ?>" class="widefat" name="<?php echo $this->get_field_name('facebook_url'); ?>" type="text" value="<?php echo esc_url($facebook_url); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('twitter_url'); ?>"><?php _e('Twitter URL:', 'wp_widget_plugin'); ?></label>
<input id="<?php echo $this->get_field_id('twitter_url'); ?>" class="widefat" name="<?php echo $this->get_field_name('twitter_url'); ?>" type="text" value="<?php echo esc_url($twitter_url); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('youtube_url'); ?>"><?php _e('YouTube URL:', 'wp_widget_plugin'); ?></label>
<input id="<?php echo $this->get_field_id('youtube_url'); ?>" class="widefat" name="<?php echo $this->get_field_name('youtube_url'); ?>" type="text" value="<?php echo esc_url($youtube_url); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('vimeo_url'); ?>"><?php _e('Vimeo URL:', 'wp_widget_plugin'); ?></label>
<input id="<?php echo $this->get_field_id('vimeo_url'); ?>" class="widefat" name="<?php echo $this->get_field_name('vimeo_url'); ?>" type="text" value="<?php echo esc_url($vimeo_url); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('picasa_url'); ?>"><?php _e('Picasa URL:', 'wp_widget_plugin'); ?></label>
<input id="<?php echo $this->get_field_id('picasa_url'); ?>" class="widefat" name="<?php echo $this->get_field_name('picasa_url'); ?>" type="text" value="<?php echo esc_url($picasa_url); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('flickr_url'); ?>"><?php _e('Flickr URL:', 'wp_widget_plugin'); ?></label>
<input id="<?php echo $this->get_field_id('flickr_url'); ?>" class="widefat" name="<?php echo $this->get_field_name('flickr_url'); ?>" type="text" value="<?php echo esc_url($flickr_url); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('googleplus_url'); ?>"><?php _e('Google+ URL:', 'wp_widget_plugin'); ?></label>
<input id="<?php echo $this->get_field_id('googleplus_url'); ?>" class="widefat" name="<?php echo $this->get_field_name('googleplus_url'); ?>" type="text" value="<?php echo esc_url($googleplus_url); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('linkedin_url'); ?>"><?php _e('LinkedIn URL:', 'wp_widget_plugin'); ?></label>
<input id="<?php echo $this->get_field_id('linkedin_url'); ?>" class="widefat" name="<?php echo $this->get_field_name('linkedin_url'); ?>" type="text" value="<?php echo esc_url($linkedin_url); ?>" />
</p>

<?php
}

// update widget
function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['social_title'] = strip_tags($new_instance['social_title']);
      $instance['facebook_url'] = strip_tags($new_instance['facebook_url']);
      $instance['twitter_url'] = strip_tags($new_instance['twitter_url']);
      $instance['youtube_url'] = strip_tags($new_instance['youtube_url']);
      $instance['vimeo_url'] = strip_tags($new_instance['vimeo_url']);
      $instance['picasa_url'] = strip_tags($new_instance['picasa_url']);
      $instance['flickr_url'] = strip_tags($new_instance['flickr_url']);
      $instance['googleplus_url'] = strip_tags($new_instance['googleplus_url']);
      $instance['linkedin_url'] = strip_tags($new_instance['linkedin_url']);
     return $instance;
}
// display widget (frontend)
function widget($args, $instance) {
   extract( $args );
   // these are the widget options
   $social_title = apply_filters('widget_title', $instance['social_title']);
   $facebook_url = $instance['facebook_url'];
   $twitter_url = $instance['twitter_url'];
   $youtube_url = $instance['youtube_url'];
   $vimeo_url = $instance['vimeo_url'];
   $picasa_url = $instance['picasa_url'];
   $flickr_url = $instance['flickr_url'];
   $googleplus_url = $instance['googleplus_url'];
   $linkedin_url = $instance['linkedin_url'];

   echo $before_widget;
   // Display the widget
   ?>


		<div class="mayflower-social-links">
<?php

   // Check if social title is populated
   if( $social_title ) {
      echo $before_title . $social_title . $after_title;
   }
?>
			<ul>
<?php


   // Check if facebook url is populated
   if( $facebook_url ) { ?>
		<li class="facebook"><a href="<?php echo esc_url($facebook_url);?>" title="Like us on Facebook">Facebook</a></li>
	<?php
   }

   // Check if twitter url is populated
   if( $twitter_url ) { ?>
		<li class="twitter"><a href="<?php echo esc_url($twitter_url);?>" title="Follow us on Twitter">Twitter</a></li>
	<?php
   }

   // Check if youtube url is populated
   if( $youtube_url ) { ?>
		<li class="youtube"><a href="<?php echo esc_url($youtube_url);?>" title="Watch our YouTube videos">YouTube</a></li>
	<?php
   }

   // Check if vimeo url is populated
   if( $vimeo_url ) { ?>
		<li class="vimeo"><a href="<?php echo esc_url($vimeo_url);?>" title="Watch our Vimeo videos">Vimeo</a></li>
	<?php
   }

   // Check if picasa url is populated
   if( $picasa_url ) { ?>
		<li class="picasa"><a href="<?php echo esc_url($picasa_url);?>" title="View our Picasa photos">Picasa</a></li>
	<?php
   }

   // Check if picasa url is populated
   if( $flickr_url ) { ?>
		<li class="flickr"><a href="<?php echo esc_url($flickr_url);?>" title="View our Flickr photos">Flickr</a></li>
	<?php
   }

   // Check if Google+ url is populated
   if( $googleplus_url ) { ?>
		<li class="googleplus"><a href="<?php echo esc_url($googleplus_url);?>" title="Connect on Google+">Google Plus</a></li>
	<?php
   }

   // Check if LinkedIn url is populated
   if( $linkedin_url ) { ?>
		<li class="linkedin"><a href="<?php echo esc_url($linkedin_url);?>" title="Connect on LinkedIn">LinkedIn</a></li>
	<?php
   }


?>
		</ul>
	</div><!-- span3 -->

<?php
   echo $after_widget;
}} // mayflower_social_links Class

// register widget
add_action( 'widgets_init', create_function( '', 'register_widget( "mayflower_social_links" );' ) );

?>