<?php
// No direct access!
defined( 'ABSPATH' ) || die( 'Sorry, no direct access allowed' );

// Version # used to invalidate stylesheet caching
define( 'MAYFLOWER_STYLE_VERSION', '2.17' );

/* Load  theme options framework
 *
 * This legacy code is mainly from the Oenology theme.
 * TODO: Define new orgizational schema and migrate content of functions.php
 *
 * theme-setup.php - sets theme functionality
 * wordpress-hooks.php - filters and functionality changes
 * plugin-hooks.php - filters and functionality changes for first- and third-party plugins
 * options-admin.php - defines Mayflower Admin Only option page -
                       consider migrating to customizer
 * options.php - theme options definition
 * options-customizer.php - translate options.php to customizer
 * network-options.php - Network Admin options pane
 */
require( get_template_directory() . '/inc/functions/theme-setup.php' );
require( get_template_directory() . '/inc/functions/options-customizer.php' );

/* Load Mayflower Options in to Variable */
$mayflower_options = mayflower_get_options();

require( get_template_directory() . '/inc/functions/wordpress-hooks.php' );
require( get_template_directory() . '/inc/functions/plugin-hooks.php' );
require( get_template_directory() . '/inc/functions/globals-options.php' );
require( get_template_directory() . '/inc/functions/globals.php' );


#####################################################
// Configuration for classes shortcode
#####################################################
define( 'CLASSESURL', '//www.bellevuecollege.edu/classes/All/' );
define( 'PREREQUISITEURL', '//www.bellevuecollege.edu/transfer/prerequisites/' );


/**
 * Load Mayflower Embedded Plugins
 *
 * These files provide plugin-like functionality embedded within Mayflower.
 *
 * @since 1.0
 *
 */

$mayflower_options = mayflower_get_options();

// Slider
if ( true == $mayflower_options['slider_toggle'] ) {
	if ( file_exists( get_template_directory() . '/inc/mayflower-slider/slider.php' ) ) {
		require( get_template_directory() . '/inc/mayflower-slider/slider.php' );
	}
}

// Staff
if ( true == $mayflower_options['staff_toggle'] ) {
	if ( file_exists( get_template_directory() . '/inc/mayflower-staff/staff.php' ) ) {
		require( get_template_directory() . '/inc/mayflower-staff/staff.php' );
	}
}

// SEO
if ( file_exists( get_template_directory() . '/inc/mayflower-seo/mayflower_seo.php' ) ) {
	require( get_template_directory() . '/inc/mayflower-seo/mayflower_seo.php' );
}

// Course Description Shortcodes
if ( file_exists( get_template_directory() . '/inc/mayflower-course-descriptions/mayflower-course-descriptions.php' ) ) {
	require( get_template_directory() . '/inc/mayflower-course-descriptions/mayflower-course-descriptions.php' );
}


/**
 * Custom Pagination Function
 *
 * Output pagination using Globals/Mayflower styles
 *
 */
function mayflower_pagination() {
	$big = 999999999; // need an unlikely integer

	$paginated_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var( 'paged' ) ),
		'type' => 'array',
		'prev_text' => '<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Previous',
		'next_text' => 'Next <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>',
		'before_page_number' => '<span class="sr-only">Page</span>',
	) );
	// Output Pagination
	if ( $GLOBALS['wp_query']->max_num_pages > 1 ) { ?>
		<nav class="text-center content-padding">
			<ul class="pagination">
				<?php foreach ( $paginated_links as $link ) {
					// Check if 'Current' class appears in string
					$is_current = strpos( $link, 'current' );
					if ( false === $is_current ) {
						echo '<li>';
						echo $link;
						echo '</li>';
					} else {
						echo '<li class="active">';
						echo $link;
						echo '</li>';
					}
				} ?>
			</ul>
		</nav> <?php
	}
}


/**
 * Mayflower Is Blog function
 *
 * Returns true if the current page is a blog page
 *
 */
function mayflower_is_blog() {
	if ( is_home() || is_archive() || is_singular( 'post' ) || is_post_type_archive( 'post' ) ) {
		return true;
	} else {
		return false;
	}
}


/**
 * Has Active Sidebar function
 *
 * Check if sidebar widgets are present
 *
 */
function has_active_sidebar() {
	$sidebar_is_active;
	//Default functionality
	if ( mayflower_is_blog() ) {
		if ( is_active_sidebar( 'top-global-widget-area' ) ||
			 is_active_sidebar( 'blog-widget-area' ) ||
			 is_active_sidebar( 'global-widget-area' ) ) {
			$sidebar_is_active = true;
		} else {
			$sidebar_is_active = false;
		}
	} else {
		if ( is_active_sidebar( 'top-global-widget-area' ) ||
			 is_active_sidebar( 'page-widget-area' ) ||
			 is_active_sidebar( 'global-widget-area' ) ) {
			$sidebar_is_active = true;
		} else {
			$sidebar_is_active = false;
		}
	}

	// Disable sidebar if page template is full-width
	if ( is_page_template( 'page-full-width.php' ) ) {
		$sidebar_is_active = false;
	}
	/**
	 * Add mayflower_active_sidebar filter
	 *
	 * Allows plugins and themes to override
	 * active sidebar state
	 */
	$sidebar_is_active = apply_filters( 'mayflower_active_sidebar', $sidebar_is_active );

	return $sidebar_is_active;
}


/**
 * Mayflower Display Sidebar hook
 *
 * Hooks in above Static in sidebar.php
 */
function mayflower_display_sidebar() {
	do_action( 'mayflower_display_sidebar' );
}

/**
 * Is Multisite Home function
 *
 * Return true if on the multisite root homepage
 *
 */
function is_multisite_home() {
	if ( is_main_site() && is_front_page() ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Mayflower Trimmed URL function
 *
 * Return trimmed URL (for example, www.bellevuecollege.edu/sample ).
 * Used for Swiftype. Based on https://stackoverflow.com/a/4357691
 *
 */
function mayflower_trimmed_url() {
	$site_url = get_site_url( null, '', 'https' );
	$parsed = parse_url( $site_url );
	return $parsed['host'] . $parsed['path'];
}


/**
 * Set $mayflower_brand variable
 *
 * Used in page templates. TODO- move to function
 *
 */
$mayflower_brand = mayflower_get_option( 'mayflower_brand' );
$mayflower_brand_css = '';
if ( $mayflower_brand == 'lite' ) {
	$mayflower_brand_css = 'globals-lite';
} else {
	$mayflower_brand_css = 'globals-branded';
}


/**
 * Mayflower CPT Update Post Order action hook
 *
 * Save post order on custom post order page used by Staff and Slider
 *
 */
add_action( 'wp_ajax_mayflower_cpt_update_post_order', 'mayflower_cpt_update_post_order' );

function mayflower_cpt_update_post_order() {
	global $wpdb;

	$post_type     = $_POST['postType'];
	$order        = $_POST['order'];

	/**
	*    Expect: $sorted = array(
	*                menu_order => post-XX
	*            );
	*/
	foreach ( $order as $menu_order => $post_id ) {
		$post_id         = intval( str_ireplace( 'post-', '', $post_id ) );
		$menu_order     = intval( $menu_order );
		wp_update_post( array(
			'ID' => $post_id,
			'menu_order' => $menu_order,
		) );
	}
	die( '1' );
}

/**
 * Custom Meta Boxes
 *
 * Globals nav selection meta boxes. Not sure where this is used. 
 *
 */

// Field Array
$prefix = '_gnav_';
$global_section_meta_fields = array(
	array(
		'label' => 'College navigation menu',
		'desc'  => 'This page and all it\'s children will have the above college navigation area selected',
		'id'    => $prefix . 'college_nav_menu',
		'type'  => 'select',
		'options' => array(
			'nav-home' => array(
				'label' => 'Home',
				'value' => 'nav-home',
			),
			'nav-classes' => array(
				'label' => 'Classes',
				'value' => 'nav-classes',
			),
			'nav-programs' => array(
				'label' => 'Programs of Study',
				'value' => 'nav-programs',
			),
			'nav-enrollment' => array(
				'label' => 'Enrollment',
				'value' => 'nav-enrollment',
			),
			'nav-services' => array(
				'label' => 'Services',
				'value' => 'nav-services',
			),
			'nav-campuslife' => array(
				'label' => 'Campus Life',
				'value' => 'nav-campuslife',
			),
			'nav-about' => array(
				'label' => 'About Us',
				'value' => 'nav-about',
			),
		),
	),
);


// The Callback
function global_section_meta_box() {
	global $global_section_meta_fields, $post;
	// Use nonce for verification
	echo '<input type="hidden" name="global_section_meta_box" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ( $global_section_meta_fields as $field ) {
		// get value of this field if it exists for this post
		$meta = get_post_meta( $post->ID, $field['id'], true );
		// begin a table row with
		echo '<tr>
				<th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
				<td>';
				switch( $field['type'] ) {
					case 'input':
						echo '<input type="text" name="'.$field['id'].'" id="' . $field['id'] . '" value="' . $meta . '" size="60" />
							<br /><span class="description">'.$field['desc'].'</span>';
						break;

					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
							<br /><label for="'.$field['id'].'">'.$field['desc'].'</label>';
						break;

					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="58" rows="4">'.$meta.'</textarea>
							<br /><span class="description">'.$field['desc'].'</span>';
						break;

					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ( $field['options'] as $option ) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
						break;
					//No Need for Default Case

				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}

// Save the Data
add_action( 'save_post', 'save_global_section_meta' );

function save_global_section_meta( $post_id ) {
	global $global_section_meta_fields;
	// verify nonce

	// verify nonce
	if ( ! isset( $_POST['global_section_meta_box'] ) || ! wp_verify_nonce( $_POST['global_section_meta_box'], basename( __FILE__ ) ) ) {
		return $post_id;
	}
	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	// check permissions
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
	}
	// loop through fields and save the data
	foreach ( $global_section_meta_fields as $field ) {
		$old = get_post_meta( $post_id, $field['id'], true );
		$new = $_POST[ $field['id'] ];
		if ( $new && $new != $old ) {
			update_post_meta( $post_id, $field['id'], $new );
		} elseif ( '' == $new && $old ) {
			delete_post_meta( $post_id, $field['id'], $old );
		}
	} // End foreach().
}
