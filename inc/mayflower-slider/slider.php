<?php
/*
Plugin Name: Mayflower Featured Slider Plugin
Description: Add featured slider elements to Mayflower sites.
Version: 0.1
License: GPL
Author: Bellevue College DevCom
Author URI:
*/

///////////////////////////////////////
// - Get the Slider plugin stylesheet
///////////////////////////////////////
add_action( 'wp_enqueue_scripts', 'add_slider_stylesheet' );
function add_slider_stylesheet() {

    $css_path = WP_CONTENT_URL . '/themes/mayflower/inc/mayflower-slider/css/slider_styles.css';
    // registers your stylesheet
    wp_register_style( 'slider_styles', $css_path );

    // loads your stylesheet
    wp_enqueue_style( 'slider_styles' );
}




function slider_admin_styles($hook) {
    $css_path = WP_CONTENT_URL . '/themes/mayflower/inc/mayflower-slider/css/slider_styles.css';
	if('edit.php?post_type=slider' !=$hook )
        wp_register_style( 'slider_styles', $css_path );
        wp_enqueue_style( 'slider_styles' );
}
add_action( 'admin_enqueue_scripts', 'slider_admin_styles' );


///////////////////////////////////////
// - Setup Staff Custom Post type - //
///////////////////////////////////////



    add_action('init', 'bc_slider_register');

    function bc_slider_register() {
		$labels = array(
			'name' => _x('Featured Slider', 'post type general name'),
			'singular_name' => _x('Slide', 'post type singular name'),
			'add_new' => _x('Add New', 'Slide'),
			'add_new_item' => __('Add New Slide'),
			'edit_item' => __('Edit Slide'),
			'new_item' => __('New Slide'),
			'all_items' => __('Slide List'),
			'view_item' => __('View Slide'),
			'search_items' => __('Search Slides'),
			'not_found' =>  __('No Slides found'),
			'not_found_in_trash' => __('No Slides found in Trash'),
			'parent_item_colon' => '',
			'menu_name' => __('Featured Slider')
		);

        $args = array(
		    'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'hierarchical' => true,
            'has_archive' =>true,
            'rewrite' => true,
			'menu_position' => 4,
            'supports' => array('title', 'editor', 'thumbnail', 'category', 'author', 'revisions', /*'page-attributes',*/ 'author', 'comments'),
			'taxonomies' => array(/*'category', 'post_tag',*/) // this is IMPORTANT
           );

        register_post_type( 'slider' , $args );
    }


///////////////////////////////////////
// - Add a sub menu to the featured slider menu
///////////////////////////////////////

add_action( 'admin_menu', 'mayflower_register_slider_sort_page' );

function mayflower_register_slider_sort_page() {
	add_submenu_page(
		'edit.php?post_type=slider',
		'Order Slides',
		'Re-Order',
		'edit_pages', 'slider-order',
		'slider_order_page'
	);
}


///////////////////////////////////////
// - Create an interface showing each slide with a handle to sort
///////////////////////////////////////

function slider_order_page() {
?>
	<div class="wrap">
		<h2>Sort Slides</h2>
		<p>Simply drag the slide up or down and it will be saved in that order.</p>
	<?php $slides = new WP_Query( array( 'post_type' => 'slider', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order' ) ); ?>
	<?php if( $slides->have_posts() ) : ?>





		<table class="wp-list-table widefat fixed posts" id="sortable-table">
			<thead>
				<tr>
					<th class="column-order">Re-Order</th>
					<th class="column-thumbnail">Thumbnail</th>
					<!-- <th class="column-title">Title</th>
					<th class="column-title">Details</th> -->
				</tr>
			</thead>
			<tbody data-post-type="slider">
			<?php while( $slides->have_posts() ) : $slides->the_post(); ?>
				<tr id="post-<?php the_ID(); ?>">
					<td class="column-order"><img src="<?php echo get_stylesheet_directory_uri() . '/img/row-move.png'; ?>" title="" alt="Move Icon" width="16" height="16" class="" /></td>
					<td class="column-thumbnail">
						<div class="item active">
							<div class="img-wrapper">
								<?php the_post_thumbnail( 'featured-full' ); ?>


								<div class="carousel-caption">

<?php
	$mayflower_options = mayflower_get_options();
	if ( ! isset( $mayflower_options['slider_title'] ) )
		$mayflower_options['slider_title'] = 0;

	    if( $mayflower_options['slider_title'] == 1) {
?>

									<h2><?php the_title();?></h2>
<?php } else { } ?>

<?php
	$mayflower_options = mayflower_get_options();
	if ( ! isset( $mayflower_options['slider_excerpt'] ) )
		$mayflower_options['slider_excerpt'] = 0;

	    if( $mayflower_options['slider_excerpt'] == 1) {
?>

									<?php the_excerpt(); ?>
<?php } else { } ?>



								</div><!-- carousel-caption -->

							</div><!-- img-wrapper -->
						</div><!-- item active -->
					</td>
					<!-- <td class="column-title"><strong><?php the_title(); ?></strong></td>
					<td class="column-details"><div class="excerpt"><?php the_excerpt(); ?></div></td> -->
				</tr>
			<?php endwhile; ?>
			</tbody>
			<tfoot>
				<tr>
					<th class="column-order">Order</th>
					<th class="column-thumbnail">Thumbnail</th>
					<!-- <th class="column-title">Title</th>
					<th class="column-title">Details</th> -->
				</tr>
			</tfoot>

		</table>

	<?php else: ?>

		<p>No slides found, why not <a href="post-new.php?post_type=slider">create one?</a></p>

	<?php endif; ?>
	<?php wp_reset_postdata(); // Don't forget to reset again! ?>

	<style>
		/* Dodgy CSS ^_^ */
		#sortable-table td { background: white; }
		#sortable-table .column-order { padding: 3px 10px; width: 60px; }
		#sortable-table .column-order img { cursor: move; }
		#sortable-table td.column-order { vertical-align: middle; text-align: center; }
		#sortable-table .column-thumbnail { width: auto; }
		#sortable-table tbody tr.ui-state-highlight {
		height:202px;
		width: 100%;
	    background:white !important;
	    -webkit-box-shadow: inset 0px 1px 2px 1px rgba(0, 0, 0, 0.1);
	    -moz-box-shadow: inset 0px 1px 2px 1px rgba(0, 0, 0, 0.1);
	    box-shadow: inset 0px 1px 2px 1px rgba(0, 0, 0, 0.1);
	    }
	</style>
	</div><!-- .wrap -->

<?php

}


///////////////////////////////////////
// - Create an interface showing each slide with a handle to sort
///////////////////////////////////////

add_action( 'admin_enqueue_scripts', 'mayflower_slider_enqueue_scripts' );

function mayflower_slider_enqueue_scripts() {
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'mayflower-admin-scripts', get_template_directory_uri() . '/js/sorting-v2.js' );
}



///////////////////////////////////////
// - Register and write the ajax callback function to actually update the posts.
///////////////////////////////////////


add_action( 'wp_ajax_slider_update_post_order', 'slider_update_post_order' );

function slider_update_post_order() {
	global $wpdb;

	$post_type     = $_POST['postType'];
	$order        = $_POST['order'];

	/**
	*    Expect: $sorted = array(
	*                menu_order => post-XX
	*            );
	*/
	foreach( $order as $menu_order => $post_id )
	{
		$post_id         = intval( str_ireplace( 'post-', '', $post_id ) );
		$menu_order     = intval($menu_order);
		wp_update_post( array( 'ID' => $post_id, 'menu_order' => $menu_order ) );
	}

	die( '1' );
}






###########################
// - Remove Title & WYSIWYG Editor from Staff Post type
// - http://codex.wordpress.org/Function_Reference/remove_post_type_support

//	add_action('init', 'remove_slider_meta');

//	function remove_slider_meta() {
		//remove_post_type_support( 'slider', 'title' );
		//remove_post_type_support( 'slider', 'editor' );
//	}

//

////////////////////////////////////////////////////
// Remove Unncessary Meta Boxes on Staff Admin Screen
/////////////////////////////////////////////////////


if (is_admin()) :
function slider_remove_meta_boxes() {
  remove_meta_box('categorydiv', 'slider', 'normal');
  remove_meta_box('tagsdiv-post_tag', 'slider', 'normal');
  remove_meta_box('authordiv', 'slider', 'normal');
  remove_meta_box('commentstatusdiv', 'slider', 'normal');
  remove_meta_box('commentsdiv', 'slider', 'normal');
  remove_meta_box('revisionsdiv', 'slider', 'normal');
}
add_action( 'admin_menu', 'slider_remove_meta_boxes' );
endif;

/////////////////////////////////////////
// Custom Post Title text for Staff CPT
/////////////////////////////////////////

function mayflower_slider_title_text( $title ){
$screen = get_current_screen();
if ( 'slider' == $screen->post_type ) {
$title = 'Name of Slide';
}
return $title;
}

add_filter( 'enter_title_here', 'mayflower_slider_title_text' );


/////////////////////////////////////////
// Sub-Menu for sortables
/////////////////////////////////////////
/*
add_action( 'admin_menu', 'mayflower_staff_sub_menu' );

	function mayflower_staff_sub_menu() {
	    add_submenu_page(
	        'edit.php?post_type=slider',
	        'Order Slides',
	        'Order',
	        'edit_pages', 'slider-order',
	        'slider_staff_order_page'
	    );
	}
*/

///////////////////////////////////////
// Custom Columns for Slider Post type
///////////////////////////////////////

// Add to admin_init function
add_filter('manage_edit-slider_columns', 'add_slider_columns');

function add_slider_columns($slider_columns) {
		$slider_columns = array (
		'cb' => '<input type="checkbox" />',
		'thumbnail' => __('Featured Image'),
		'title' => __('Title'),
		'slider_link_to' => __('External URL'),
	);
//remove unwanted default columns
		unset($slider_columns['author']);
		unset($slider_columns['comments']);

		return $slider_columns;
	}

// Add to admin_init function
	add_action('manage_slider_posts_custom_column', 'manage_slider_columns', 10, 2);

	function manage_slider_columns($column, $post_id) {
	global $post;

	switch( $column ) {

		    case 'thumbnail':
					echo get_the_post_thumbnail( $post->ID, 'edit-screen-thumbnail' );
					break;
					    default:

			case 'slider_link_to':

				/* Get the post meta. */
				$slider_ext_url = get_post_meta( $post->ID, 'slider_url', true );
					echo $slider_ext_url;

			break;
			default:

				} //end switch

			} //end function


/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'add_slider_ext_url_mb' );
add_action( 'load-post-new.php', 'add_slider_ext_url_mb' );


///////////////////////////////////////
// Add Meta Box for External URL
///////////////////////////////////////

// Add the Meta Box
function add_slider_ext_url_mb() {
    add_meta_box(
		'slider_external_url', // $id
		'External URL', // $title
		'show_slider_ext_url', // $callback
		'slider', // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_slider_ext_url_mb');

// Field Array
$prefix = 'slider_';
$custom_meta_fields = array(
	array(
		'label'=> 'Slider Link',
		'desc'	=> '',
		'id'	=> $prefix.'url',
		'type'	=> 'url'
	),
);

// The Callback
function show_slider_ext_url() {
global $custom_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($custom_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // case items will go here

					case 'url':
					    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="' . esc_url($meta) . '" size="30" class="widefat" placeholder="http://" />
					        <br /><span class="description">'.$field['desc'].'</span>';
						echo '<p>If you want to link to an external page, enter the URL here.</p>';
					break;

                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_slider_custom_meta($post_id) {
    global $custom_meta_fields;

	// verify nonce
	if ( !isset( $_POST['custom_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['custom_meta_box_nonce'], basename( __FILE__ ) ) )
		return $post_id;


	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	// loop through fields and save the data
	foreach ($custom_meta_fields as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}
add_action('save_post', 'save_slider_custom_meta');
?>