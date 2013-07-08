<?php
/**
 * Mayflower Theme Widgets
 *
 * This file defines the Widget functionality and
 * custom widgets for the Mayflower Theme.
 *
 * Widget Functions
 *
 *  - Register Widget Areas (Sidebars)
 *  - Define Widgets
 *  - Register Widgets
 *
 * For more information on hooks, actions, and filters,
 * see {@link http://codex.wordpress.org/Plugin_API Plugin API}.
 *
 * @package 	Mayflower
 * @copyright	Copyright (c) 2011, Chip Bennett
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Mayflower 1.0
 */

// add_action( 'after_setup_theme', 'mayflower_setup_widgets', 11 );

/**
 * Register all widget areas (sidebars)
 *
 * @uses	mayflower_get_widget_args()	Defined in functions/custom.php
 *
 * @since	WordPress 2.8
 */

/*
function mayflower_setup_widgets() {

register_sidebar( array_merge(
	array( // Top full-width widget area
		'name'			=> __( 'Sidebar Column Top', 'mayflower' ),
		'id'			=> 'sidebar-column-top',
		'description'	=> __( 'Top, full-width sidebar in two-column layout', 'mayflower' )
	),
	mayflower_get_widget_args()
) );
register_sidebar( array_merge(
	array( // Left Column widget area
		'name'			=> __( 'Sidebar Left', 'mayflower' ),
		'id'			=> 'sidebar-left',
		'description'	=> __( 'Left-column, half-width sidebar in three-column layout' , 'mayflower' )
	),
	mayflower_get_widget_args()
) );
register_sidebar( array_merge(
	array( // Right Column widget area
		'name'			=> __( 'Sidebar Right', 'mayflower' ),
		'id'			=> 'sidebar-right',
		'description'	=> __( 'Right-column, half-width sidebar in three-column layout', 'mayflower' )
	),
	mayflower_get_widget_args()
) );
register_sidebar( array_merge(
	array( // Bottom full-width widget area
		'name'			=> __( 'Sidebar Column Bottom', 'mayflower' ),
		'id'			=> 'sidebar-column-bottom',
		'description'	=> __( 'Bottom, full-width sidebar in two-column layout', 'mayflower' )
	),
	mayflower_get_widget_args()
) );
register_sidebar( array_merge(
	array( // Widget area beneath each Post content
		'name'			=> __( 'Post Entry Below', 'mayflower' ),
		'id'			=> 'post-entry-below',
		'description'	=> __( 'Beneath Post content, before Post footer', 'mayflower' )
	),
	mayflower_get_widget_args()
) );
register_sidebar( array_merge(
	array( // Widget area below each Post
		'name'			=> __( 'Post Below', 'mayflower' ),
		'id'			=> 'post-below',
		'description'	=> __( 'Beneath Post', 'mayflower' )
	),
	mayflower_get_widget_args()
) );

} // function mayflower_widget_setup()
*/

/**
 * Define Categories Custom Widget
 *
 * @uses	mayflower_get_custom_category_list()	Defined in /functions/custom.php
 *
 * @since	WordPress 2.8
 */
class mayflower_widget_categories extends WP_Widget {

    function mayflower_widget_categories() {
        $widget_ops = array('classname' => 'mayflower-widget-categories', 'description' => __( 'Mayflower theme widget to display the category list in the left column', 'mayflower' ) );
        $this->WP_Widget('mayflower_categories', __( 'Mayflower Categories', 'mayflower' ), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __( 'Mayflower Categories', 'mayflower' ) : $instance['title']);

        echo $before_widget;
        if ( $title )
            echo $before_title . $title . $after_title;
?>

<!-- Begin Categories -->
<ul class="leftcolcatlist">
	<?php echo mayflower_get_custom_category_list(); ?>
</ul>
<!-- End Categories -->

<?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);
?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'mayflower' ); ?>:</label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
    }
}

/**
 * Define Tags Custom Widget
 *
 * @uses	mayflower_get_custom_tag_list()	Defined in /functions/custom.php
 *
 * @since	WordPress 2.8
 */
class mayflower_widget_tags extends WP_Widget {

    function mayflower_widget_tags() {
        $widget_ops = array('classname' => 'mayflower-widget-tags', 'description' => __( 'Mayflower theme widget to display the tag list in the left column', 'mayflower' ) );
        $this->WP_Widget('mayflower_tags', __( 'Mayflower Tags', 'mayflower' ), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __( 'Mayflower Tags', 'mayflower' ) : $instance['title']);

        echo $before_widget;
        if ( $title )
            echo $before_title . $title . $after_title;
?>

<!-- Begin Tags -->
<ul class="leftcolcatlist">
	<?php echo mayflower_get_custom_tag_list(); ?>
</ul>
<!-- End Tags -->

<?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);
?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'mayflower' ); ?>:</label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
    }
}


/**
 * Define Post Formats Custom Widget
 *
 * @uses	mayflower_get_custom_post_format_list()	Defined in /functions/custom.php
 *
 * @since	WordPress 2.8
 */
class mayflower_widget_post_formats extends WP_Widget {

    function mayflower_widget_post_formats() {
        $widget_ops = array('classname' => 'mayflower-widget-post-formats', 'description' => __( 'Mayflower theme widget to display the Post Format list in the left column', 'mayflower' ) );
        $this->WP_Widget('mayflower_post_formats', __( 'Mayflower Post Formats', 'mayflower' ), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __( 'Mayflower Post Formats', 'mayflower' ) : $instance['title']);

        echo $before_widget;
        if ( $title )
            echo $before_title . $title . $after_title;
?>

<!-- Begin Post Formats -->
<ul class="leftcolcatlist">
	<?php echo mayflower_get_custom_post_format_list(); ?>
</ul>
<!-- End Post Formats -->

<?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);
?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'mayflower' ); ?>:</label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
    }
}

/**
 * Define Social Icons Custom Widget
 *
 * @uses	mayflower_get_custom_post_format_list()	Defined in /functions/custom.php
 *
 * @since	WordPress 2.8
 */
class mayflower_widget_social_icons extends WP_Widget {

    function mayflower_widget_social_icons() {
        $widget_ops = array('classname' => 'mayflower-widget-social-icons', 'description' => __( 'Mayflower theme widget to display social network icons', 'mayflower' ) );
        $this->WP_Widget('mayflower_social_icons', __( 'Mayflower Social Icons', 'mayflower' ), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __( 'Social Networks', 'mayflower' ) : $instance['title']);

        echo $before_widget;
        if ( $title )
            echo $before_title . $title . $after_title;
?>

<!-- Begin Social Icons -->
<ul class="leftcolcatlist">
	<?php echo mayflower_social_icons(); ?>
</ul>
<!-- End Social Icons -->

<?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);
?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'mayflower' ); ?>:</label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
    }
}


/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'mayflower_load_widgets' );

/**
 * Register all Custom Widgets
 *
 * @since	WordPress 2.8
 */
function mayflower_load_widgets() {
//	register_widget( 'mayflower_widget_categories' );
//	register_widget( 'mayflower_widget_tags' );
//	register_widget( 'mayflower_widget_post_formats' );
//	register_widget( 'mayflower_widget_social_icons' );
}
?>