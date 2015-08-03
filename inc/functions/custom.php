<?php
/**
 * Mayflower Theme custom functions
 *
 * Contains all of the Theme's custom functions, which include
 * helper functions and various filters.
 *
 * @package 	Mayflower
 * @copyright	Copyright (c) 2010, Chip Bennett
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Mayflower 1.0
 */

/**
 * @todo	complete inline documentation
 */


/* Assign global_nav_selection to body_class */

function mayflower_body_class_ia($classes) {
		$mayflower_options = mayflower_get_options();


        // add ia_options to classes
        $classes[] = $mayflower_options['global_nav_selection'];

        // return the $classes array
        return $classes;
    }
add_filter('body_class','mayflower_body_class_ia');

/**
 * Image Handling for gallery image metadata
 */
function mayflower_gallery_image_meta() {
	global $post;
	$post = get_post($post);
	$is_parent = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
	$attachmentimage = ( $is_parent ? array_shift( $is_parent ) : false );
	$imagepost = ( $attachmentimage ? $attachmentimage->ID : $post->ID );
	$m = get_post_meta( $imagepost, '_wp_attachment_metadata' , true );
	$image = wp_get_attachment_image( $imagepost, 'full' );
	$url = wp_get_attachment_url( $imagepost );
	$uploaddir = wp_upload_dir();
	$imagesize = size_format( filesize( $uploaddir['basedir'] . '/' . $m['file'] ) );
	$image_meta = array (
		'image' => $image,
		'url' => $url,
		'width' => $m['width'],
		'height' => $m['height'],
		'dimensions' => false,
		'filesize' => $imagesize,
		'created_timestamp' => $m['image_meta']['created_timestamp'],
		'copyright' => $m['image_meta']['copyright'],
		'credit' => $m['image_meta']['credit'],
		'aperture' => $m['image_meta']['aperture'],
		'focal_length' => $m['image_meta']['focal_length'],
		'iso' => $m['image_meta']['iso'],
		'shutter_speed' => $m['image_meta']['shutter_speed'],
		'camera' => $m['image_meta']['camera'],
		'caption' => '(No caption provided.)'
	);
	// image dimensions handler
	if ( $m['width'] && $m['height'] ) {
		$image_meta['dimensions'] = $m['width'] . '&#215;' . $m['height'] . ' px';
	}
	// image created_timestamp handler
	if ( $m['image_meta']['created_timestamp'] ) {
		$image_meta['created_timestamp'] = date( 'm M Y', $m['image_meta']['created_timestamp'] );
	}
	// image aperture handler
	if ( $m['image_meta']['aperture'] ) {
		$image_meta['aperture'] = 'f/' . $m['image_meta']['aperture'];
	}
	// shutter speed handler
	if ( ( $m['image_meta']['shutter_speed'] != '0' ) && ( ( 1 / $m['image_meta']['shutter_speed'] ) > 1 ) ) {
	$image_meta['shutter_speed'] =  "1/";
		if (number_format((1 / $m['image_meta']['shutter_speed']), 1) ==  number_format((1 / $m['image_meta']['shutter_speed']), 0)) {
			$image_meta['shutter_speed'] = $image_meta['shutter_speed'] . number_format((1 / $m['image_meta']['shutter_speed']), 0, '.', '') . ' sec';
		} else {
			$image_meta['shutter_speed'] = $image_meta['shutter_speed'] .  number_format((1 / $m['image_meta']['shutter_speed']), 1, '.', '') . ' sec';
		}
	} else {
		$image_meta['shutter_speed'] = $m['image_meta']['shutter_speed'].' sec';
	}
	// image caption handler
	if ( ! empty( $post->post_excerpt ) ) {
		$image_meta['caption'] = get_the_excerpt(); // this is the "caption"
	} else if ( is_object( $attachmentimage ) && $attachmentimage->post_excerpt ) {
		$image_meta['caption'] = $attachmentimage->post_excerpt;
	}
	return apply_filters( 'mayflower_gallery_image_meta', $image_meta );
}

/**
 * Image Handling for gallery previous/next links
 *
 * function needed because WP gives no easy way to
 * display both image and text in prev/next links.
 */
function mayflower_gallery_links() {
	global $post;
	$post = get_post($post);
	$attachments = array_values(get_children("post_parent=$post->post_parent&post_type=attachment&post_mime_type=image&orderby=menu_order ASC, ID ASC"));

	$k = 0;

	foreach ( $attachments as $k => $attachment )
		if ( $attachment->ID == $post->ID )
			break;

	$links = array( 'prevlink' => '', 'prevthumb' => '', 'nextlink' => '', 'nextthumb' => '' );

	if ( isset($attachments[$k+1]) ) {
		$links['prevlink'] = get_permalink($attachments[$k+1]->ID);
		$links['prevthumb'] = wp_get_attachment_link($attachments[$k+1]->ID, 'attachment-nav-thumbnail', true);
	}

	if ( isset($attachments[$k-1]) ) {
		$links['nextlink'] = get_permalink($attachments[$k-1]->ID);
		$links['nextthumb'] = wp_get_attachment_link($attachments[$k-1]->ID, 'attachment-nav-thumbnail', true);
	}

	return apply_filters( 'mayflower_gallery_links', $links );
}


/**
 * 404 error handling
 */
function mayflower_get_404_content() {

	if ( ! is_404() )
		return;

	// Variable to hold function output
	$mayflower_404 = '';

	// Variables to hold contextual output parts
	$mayflower_404_intro = '';
	$mayflower_404_posts = '';
	$mayflower_404_pages = '';
	$mayflower_404_category = '';
	$mayflower_404_tag = '';
	$mayflower_404_results = '';
	$mayflower_404_noresults = '';

	// Intro text

	$mayflower_404_intro .= '<p>';
	$mayflower_404_intro .= __( 'Oh no, not again.', 'mayflower' );
	$mayflower_404_intro .= '</p>';
	$mayflower_404_intro .= '<p>';
	$mayflower_404_intro .= __( 'Well, this is weird.', 'mayflower' ) . ' ' ;
	$mayflower_404_intro .= __( 'The post, page, or file you requested could not be found. ', 'mayflower' ) . ' ';
	$mayflower_404_intro .= __( 'The best laid plans of mice, and all that. ', 'mayflower' ) . ' ';
	$mayflower_404_intro .= __( 'Those who study the complex interplay of cause and effect in the history of the Universe say that this sort of thing is going on all the time.', 'mayflower' );
	$mayflower_404_intro .= '</p>';
	$mayflower_404_intro .= '<p>';
	$mayflower_404_intro .= __( 'I apologize for the inconvenience.', 'mayflower' ) . ' ';
	$mayflower_404_intro .= __( 'Let me try to make it up to you!', 'mayflower' );
	$mayflower_404_intro .= '<p>';

	// array to hold suggestions
	if ( ! isset ( $mayflower404suggestions ) ) {
		$mayflower404postsuggestions = false;
		$mayflower404pagesuggestions = false;
	}

	// Extract search term from URL
	$patterns_array[] = "/?(trackback|feed|page[0-9]*)/?$";
	$patterns_array[] = "\.html$";
	$patterns_array = array_map(create_function('$a', '$sep = (strpos($a, "@") === false ? "@" : "%"); return $sep.trim($a).$sep."i";'), $patterns_array);

	$search = preg_replace( $patterns_array, "", urldecode( $_SERVER["REQUEST_URI"] ) );
	$search = basename(trim($search));
	$search = preg_replace( $patterns_array, "", $search);
	$search_words = preg_replace( "@[_-]@", " ", $search);

	// Search for posts
	$posts = get_posts( array( "s" => $search_words ) );
	$mayflower404postsuggestions = $posts;

	// Search for pages
	$pages = get_posts( array( "s" => $search_words, "post_type" => "page" ) );
	$mayflower404pagesuggestions = $pages;

	$mayflower404suggestions = array_merge ( $mayflower404postsuggestions, $mayflower404pagesuggestions );
	$mayflower404nopostsorpages = true;

	if ( ! isset ( $mayflower404suggestions ) || ! is_array( $mayflower404suggestions ) || count( $mayflower404suggestions ) == 0 )  {
		$mayflower404nopostsorpages = true;
	} else {
		$mayflower404nopostsorpages = false;

		// Display list of post suggestions
		$suggestedposts = $mayflower404postsuggestions;
		if ( $suggestedposts > 0 ) {

			$mayflower_404_posts .= '<p>' . __( 'Here is a list of posts that you might have been looking for:', 'mayflower' ) . '</p>';
			$mayflower_404_posts .= '<ul class="oenology404_suggestions">';

			foreach ( $suggestedposts as $suggestedpost ) {
				$mayflower_404_posts .= '<li>';
				$mayflower_404_posts .= '<span style="text-transform:uppercase;">' . $suggestedpost->post_type . '</span>: <a href="' . get_permalink( $suggestedpost->ID ) . '">' . $suggestedpost->post_title . '</a>';
				$mayflower_404_posts .= '<blockquote>';

				if ( empty( $suggestedpost->post_excerpt ) ) {
					$suggestedpost->post_excerpt = explode(" ", strrev( substr( strip_tags( $suggestedpost->post_content ), 0, 300 ) ), 2 );
					$suggestedpost->post_excerpt = strrev( $suggestedpost->post_excerpt[1] );
					$suggestedpost->post_excerpt.= " [...]";
				}
				if ( $suggestedpost->post_excerpt ) {
					$mayflower_404_posts .= $suggestedpost->post_excerpt;
				} else {
					$mayflower_404_posts .= __( 'No excerpt available.', 'mayflower' );
				}

				$mayflower_404_posts .= '</blockquote>';
				$mayflower_404_posts .= '</li>';
			}
			$mayflower_404_posts .= '</ul>';

		}

		// Display list of page suggestions
		$suggestedpages = $mayflower404pagesuggestions;
		if ( $suggestedpages > 0 ) {

			$mayflower_404_pages .= '<p>' . __( 'Here is a list of pages that you might have been looking for:', 'mayflower' ) . '</p>';
			$mayflower_404_pages .= '<ul class="oenology404_suggestions">';

			foreach ( $suggestedpages as $suggestedpage ) {
				$mayflower_404_pages .= '<li>';
					$mayflower_404_pages .= '<span style="text-transform:uppercase;">' . $suggestedpage->post_type . '</span>: <a href="' . get_permalink( $suggestedpage->ID ) . '">' . $suggestedpage->post_title . '</a>';
					$mayflower_404_pages .= '<blockquote>';

							if ( empty( $suggestedpage->post_excerpt ) ) {
									$suggestedpage->post_excerpt = explode(" ", strrev( substr( strip_tags( $suggestedpage->post_content ), 0, 300 ) ), 2 );
									$suggestedpage->post_excerpt = strrev( $suggestedpage->post_excerpt[1] );
									$suggestedpage->post_excerpt.= " [...]";
								}
							if ( $suggestedpage->post_excerpt ) {
								$mayflower_404_pages .= $suggestedpage->post_excerpt;
							} else {
								$mayflower_404_pages .= __( 'No excerpt available.', 'mayflower' );
							}

				$mayflower_404_pages .= '</blockquote>';
				$mayflower_404_pages .= '</li>';
			}
			$mayflower_404_pages .= '</ul>';

		}
	}

	// See if we've matched a category
	$mayflower404nocategories = true;
	$categories = get_categories( array ( "name__like" => $search ) );
	if ( count( $categories ) > 0 ) {

		$mayflower404nocategories = false;

		$mayflower_404_category .= '<p>'. __( 'Perhaps you were looking for something in one of the following categories?', 'mayflower' ) . '</p>';
		$mayflower_404_category .= '<ul class="oenology404_suggestions">';
		foreach ( $categories as $category ) {
			$mayflower_404_category .= '<li><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a></li>';
		}
		$mayflower_404_category .= '</ul>';
	}
	// See if we've matched a tag
	$mayflower404notags = true;
	$tags = get_tags( array ( "name__like" => $search ) );
	if ( count( $tags ) > 0 ) {

		$mayflower404notags = false;

		$mayflower_404_tag = '<p>' . __( 'Perhaps you were looking for something with one of the following tags?', 'mayflower' ) . '</p>';
		$mayflower_404_tag .= '<ul class="oenology404_suggestions">';
		foreach ( $tags as $tag ) {
			$mayflower_404_tag .= '<li><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a></li>';
		}
		$mayflower_404_tag .= '</ul>';
	}

	// Define "no results" output
	$mayflower_404_noresults .= '<p>';
	$mayflower_404_noresults .= __( 'I apologize.', 'mayflower' ) . ' ';
	$mayflower_404_noresults .= __( 'For the life of me, I am unable to figure out what you were trying to find.', 'mayflower' ) . ' ';
	$mayflower_404_noresults .= __( 'Perhaps try searching, using the search form in the upper right-hand corner?', 'mayflower' );
	$mayflower_404_noresults .= '</p>';

	// Concatenate "results" output
	$mayflower_404_results = apply_filters( 'mayflower_404_intro', $mayflower_404_intro ) . apply_filters( 'mayflower_404_posts', $mayflower_404_posts ) . apply_filters( 'mayflower_404_pages', $mayflower_404_pages ) . apply_filters( 'mayflower_404_category', $mayflower_404_category ) . apply_filters( 'mayflower_404_tag', $mayflower_404_tag );

	$mayflower404noresults = false;

	if ( $mayflower404nopostsorpages && $mayflower404nocategories && $mayflower404notags ) {
		$mayflower404noresults = true;
	}
	$mayflower_404 = ( $mayflower404noresults ? apply_filters( 'mayflower_404_noresults', $mayflower_404_noresults ) : apply_filters( 'mayflower_404_results', $mayflower_404_results ) );

	return apply_filters( 'mayflower_404', $mayflower_404 );
}


/**
 * Determine Theme Color Scheme
 *
 * @uses	mayflower_get_options()				Defined in functions/options.php
 * @uses	mayflower_get_option_parameters()	Defined in functions/options.php
 */

function mayflower_get_color_scheme() {
	global $mayflower_options;
	$mayflower_options = mayflower_get_options();
	$default_options = mayflower_get_option_parameters();
	$mayflower_skins = $default_options['skin']['valid_options'];
	$mayflower_current_skin = array();
	foreach ( $mayflower_skins as $skin ) {
		if ( $skin['name'] == $mayflower_options['skin'] ) {
		      $mayflower_current_skin = $skin;
		}
	}
	$colorscheme = $mayflower_current_skin['scheme'];
	return $colorscheme;
}

/**
 * Get current page context
 *
 * Returns a string containing the context of the
 * current page. This string is useful for several
 * purposes, including applying an ID to the HTML
 * body tag, and adding a contextual $name to calls
 * to get_header(), get_footer(), get_sidebar(),
 * and get_template_part_file(), in order to
 * facilitate Child Themes overriding default Theme
 * template part files.
 *
 * @param	none
 * @return	string	current page context
 */
 /*
function mayflower_get_context() {

	$context = apply_filters( 'mayflower_default_context', 'index' );

	if ( is_front_page() ) {
		// Front Page
		$context = 'front-page';
	} else if ( is_date() ) {
		// Date Archive Index
		$context = 'date';
	} else if ( is_author() ) {
		// Author Archive Index
		$context = 'author';
	} else if ( is_category() ) {
		// Category Archive Index
		$context = 'category';
	} else if ( is_tag() ) {
		// Tag Archive Index
		$context = 'tag';
	} else if ( is_tax() ) {
		// Taxonomy Archive Index
		$context = 'taxonomy';
	} else if ( is_archive() ) {
		// Archive Index
		$context = 'archive';
	} else if ( is_search() ) {
		// Search Results Page
		$context = 'search';
	} else if ( is_404() ) {
		// Error 404 Page
		$context = '404';
	} else if ( is_attachment() ) {
		// Attachment Page
		$context = 'attachment';
	} else if ( is_singular( 'post' ) ) {
		// Single Blog Post
		$context = 'single';
	} else if ( is_page() ) {
		// Static Page
		$context = 'page';
	} else if ( is_singular() ) {
		// Single Custom Post
		$context = get_post_type();
	} else if ( is_home() ) {
		// Blog Posts Index
		$context = 'home';
	}

	return apply_filters( 'mayflower_get_context', $context );
}
*/
/**
 * Get Current Page Layout
 */
/*
function mayflower_get_current_page_layout() {

	// Use default layout for 404 pages
	if ( is_404() ) {
		return 'default';
	}

	// Otherwise, determine appropriate layout
	$layout = '';
	global $post;
	global $mayflower_options;
	$custom = ( get_post_custom( $post->ID ) ? get_post_custom( $post->ID ) : false );
	$custom_layout = ( isset( $custom['_mayflower_layout'][0] ) ? $custom['_mayflower_layout'][0] : 'default' );
	if ( ! is_admin() ) {
		if ( is_attachment() ) {
			$layout .= 'attachment';
		}
		else if ( is_front_page() && ! is_home() ) {
			if ( 'default' == $custom_layout ) {
				$layout .= $mayflower_options['default_front_page_layout'];
			} else {
				$layout .= $custom_layout;
			}
		}
		else if ( is_page() ) {
			if ( 'default' == $custom_layout ) {
				$layout .= $mayflower_options['default_static_page_layout'];
			} else {
				$layout .= $custom_layout;
			}
		}
		else if ( is_singular( 'post' ) ) {
			if ( 'gallery' == get_post_format() || 'image' == get_post_format() || 'video' == get_post_format() ) {
				$layout .= 'full';
			}
			else if ( 'default' == $custom_layout ) {
				$layout .= $mayflower_options['default_single_post_layout'];
			}
			else {
				$layout .= $custom_layout;
			}
		}
		else if ( is_home() || is_archive() || is_search() || is_404() ) {
			$layout .= $mayflower_options['post_index_layout'];
		}
	}
	else if ( is_admin() ) {
		if ( 'attachment' == $post->post_type ) {
			$layout .= 'attachment';
		}
		else if ( 'page' == $post->post_type ) {
			if ( 'default' == $custom_layout ) {
				$layout .= $mayflower_options['default_static_page_layout'];
			}
			else {
				$layout .= $custom_layout;
			}
		}
		else if ( 'post' == $post->post_type ) {
			if ( 'gallery' == get_post_format( $post->ID ) || 'image' == get_post_format( $post->ID ) || 'video' == get_post_format( $post->ID ) ) {
				$layout .= 'full';
			}
			if ( 'default' == $custom_layout ) {
				$layout .= $mayflower_options['default_single_post_layout'];
			}
			else {
				$layout .= $custom_layout;
			}
		}
	}
	return apply_filters( 'mayflower_get_current_page_layout', $layout );
}
*/
/**
 * Get current settings page tab
 */
function mayflower_get_current_tab() {

	$page = 'mayflower-settings';
	if ( isset( $_GET['page'] ) && 'mayflower-reference' == $_GET['page'] ) {
		$page = 'mayflower-reference';
	}
    if ( isset( $_GET['tab'] ) ) {
        $current = $_GET['tab'];
    } else {
		$mayflower_options = mayflower_get_options();
		$current = $mayflower_options['default_options_tab'];
    }
	return apply_filters( 'mayflower_get_current_tab', $current );
}


/**
 * Get custom category list
 */
function mayflower_get_custom_category_list() {
	$customcatlist ='';
	$customcats=  get_categories();
	foreach( $customcats as $customcat ) {
		$customcathref = get_category_link( $customcat->term_id );
		$customcatfeedlink = get_category_feed_link( $customcat->term_id );
		$customcatlist .= '<li><a title="' . esc_attr( sprintf( _x( 'Subscribe to the %s news feed', 'Category Name', 'mayflower' ), $customcat->name ) ) . '" href="' . $customcatfeedlink . '" class="custom-taxonomy-list-feed genericon"><span class="genericon-feed"></span></a><a href="' . $customcathref . '">' . $customcat->name . '</a> (' . $customcat->count . ')</li>';
	}
	return apply_filters( 'mayflower_get_custom_category_list', $customcatlist );
}


/**
 * Get custom post format list
 */
function mayflower_get_custom_post_format_list() {
	$postformatterms = get_terms( 'post_format' );
	$postformatlist = '';
	foreach( $postformatterms as $term ) {
		$termslug = substr( $term->slug, 12 );
		$termlink = get_post_format_link( $termslug );
		$postformatlist .= '<li><a title="' . esc_attr( sprintf( _x( 'Subscribe to the %s news feed', 'Post Format', 'mayflower' ), $term->name ) ) . '" href="' . $termlink .'feed/" class="custom-taxonomy-list-feed genericon"><span class="genericon-feed"></span></a><a href="'. $termlink .'">' . $term->name . '</a> (' . $term->count . ')</li>';
	}
	return apply_filters( 'mayflower_get_custom_post_format_list', $postformatlist );
}


/**
 * Get custom tag list
 */
function mayflower_get_custom_tag_list() {
	$customtaglist ='';
	$customtags =  get_tags();
	foreach( $customtags as $customtag ) {
		$customtaghref = get_tag_link( $customtag->term_id );
		$customtagfeedlink = get_tag_feed_link( $customtag->term_id );
		$customtaglist .= '<li><a title="' . esc_attr( sprintf( _x( 'Subscribe to the %s feed', 'Tag Name', 'mayflower' ), $customtag->name ) ) . '" href="' . $customtagfeedlink . '" class="custom-taxonomy-list-feed genericon"><span class="genericon-feed"></span></a><a href="' . $customtaghref . '">' . $customtag->name . '</a> (' . $customtag->count . ')</li>';
	}
	return apply_filters( 'mayflower_get_custom_tag_list', $customtaglist );
}

/**
 * Determine Header Text Color Setting
 *
 * Determine what color value to pass to the
 * HEADER_TEXTCOLOR constant, based on whether a
 * dark or light color scheme is being displayed.
 */
function mayflower_get_header_textcolor() {

	$headertextcolor = ( get_header_textcolor() ? get_header_textcolor() : false );
	if ( ! $headertextcolor ) {
		$colorscheme = mayflower_get_color_scheme();

		if ( 'light' == $colorscheme ) {
			$headertextcolor = apply_filters( 'mayflower_light_color_scheme_header_textcolor', '666666' );
		} elseif ( 'dark' == $colorscheme ) {
			$headertextcolor = apply_filters( 'mayflower_light_color_scheme_header_textcolor', 'dddddd' );
		}
	}
	return $headertextcolor;
}


/**
 * Define Mayflower Admin Page Tab Markup
 *
 * @uses	mayflower_get_current_tab()	defined in \functions\options.php
 * @uses	mayflower_get_settings_page_tabs()	defined in \functions\options.php
 *
 * @link	http://www.onedesigns.com/tutorials/separate-multiple-theme-options-pages-using-tabs	Daniel Tara
 */
function mayflower_get_page_tab_markup() {

	$page = 'mayflower-settings';

    $current = mayflower_get_current_tab();

	$tabs = mayflower_get_settings_page_tabs();

    $links = array();

    foreach( $tabs as $tab ) {
		$tabname = $tab['name'];
		$tabtitle = $tab['title'];
        if ( $tabname == $current ) {
            $links[] = "<a class='nav-tab nav-tab-active' href='?page=$page&tab=$tabname'>$tabtitle</a>";
        } else {
            $links[] = "<a class='nav-tab' href='?page=$page&tab=$tabname'>$tabtitle</a>";
        }
    }

    echo '<div id="icon-themes" class="icon32"><br /></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach ( $links as $link )
        echo $link;
    echo '</h2>';

}

/**
 * Paginate Archive Index Page Links
 */
function mayflower_get_paginate_archive_page_links( $type = 'plain', $endsize = 1, $midsize = 1 ) {
	global $wp_query, $wp_rewrite;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

	// Sanitize input argument values
	if ( ! in_array( $type, array( 'plain', 'list', 'array' ) ) ) $type = 'plain';
	$endsize = (int) $endsize;
	$midsize = (int) $midsize;

	// Setup argument array for paginate_links()
	$pagination = array(
		'base' => @add_query_arg('paged','%#%'),
		'format' => '',
		'total' => $wp_query->max_num_pages,
		'current' => $current,
		'show_all' => false,
		'end_size' => $endsize,
		'mid_size' => $midsize,
		'type' => $type,
		'prev_text' => '&lt;&lt;',
		'next_text' => '&gt;&gt;'
	);

	if( $wp_rewrite->using_permalinks() )
		$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

	if( !empty($wp_query->query_vars['s']) )
		$pagination['add_args'] = array( 's' => get_query_var( 's' ) );

	return paginate_links( $pagination );
}

/*
 * Define supported Post Format types
 *
 * Return an array containing the list of Post Format types
 * supported by the Theme.
 *
 * @param	none
 * @return	array	Post format types supported by the Theme
 * @since	Mayflower 1.2
 */
/*
function mayflower_get_post_formats() {
	$postformats = array(
		'aside' => array(
			'slug' => 'aside',
			'description' => __( 'An incidental remark; digression: a message that departs from the main subject.', 'mayflower' ),
			'location' => 'entry',
			'position' => 'left',
		),
		'audio' => array(
			'slug' => 'audio',
			'description' => __('A sound, or a sound signal; Of or relating to audible sound; Of or relating to the broadcasting or reproduction of sound, especially high-fidelity reproduction.', 'mayflower' ),
			'location' => 'title',
			'position' => 'right',
		),
		'chat' => array(
			'slug' => 'chat',
			'description' => __('Any kind of communication over the Internet; primarily direct one-on-one chat or text-based group chat (formally also known as synchronous conferencing), using tools such as instant messengers and Internet Relay Chat.', 'mayflower' ),
			'location' => 'title',
			'position' => 'right',
		),
		'gallery' => array(
			'slug' => 'gallery',
			'description' => __('A collection of art for exhibition.', 'mayflower' ),
			'location' => 'both',
			'position' => 'right',
		),
		'image' => array(
			'slug' => 'image',
			'description' => __('picture: A visual representation (of an object or scene or person or abstraction) produced on a surface.', 'mayflower' ),
			'location' => 'both',
			'position' => 'right',
		),
		'link' => array(
			'slug' => 'link',
			'description' => __('A reference to a document that the reader can directly follow, or that is followed automatically. The reference points to a whole document or to a specific element within a document.', 'mayflower' ),
			'location' => 'entry',
			'position' => 'left',
		),
		'quote' => array(
			'slug' => 'quote',
			'description' => __('A quotation, statement attributed to someone else; To refer to (part of) a statement that has been made by someone else.', 'mayflower' ),
			'location' => 'entry',
			'position' => 'left',
		),
		'status' => array(
			'slug' => 'status',
			'description' => __('state or condition of affairs', 'mayflower' ),
			'location' => 'entry',
			'position' => 'left',
		),
		'video'  => array(
			'slug' => 'video',
			'description' => __('A recording of both visual and audible components; Electronically capturing, recording, processing, storing, transmitting, and reconstructing a sequence of still images representing scenes in motion.', 'mayflower' ),
			'location' => 'title',
			'position' => 'right',
		),
		'standard'  => array(
			'slug' => 'standard',
			'description' => __('A standard blog post.', 'mayflower' ),
			'location' => 'title',
			'position' => 'right',
		)
	);
	return apply_filters( 'mayflower_get_post_formats', $postformats );
}
*/
/**
 * Mayflower Theme Social Networks
 *
 * Array that holds all of the valid social
 * networks for Mayflower.
 *
 * @return	array	$socialnetworks	array of arrays of social network parameters
 */
function mayflower_get_social_networks() {

	$socialnetworks = array(
        'dribbble' => array(
		'name' => 'dribbble',
		'title' => __( 'Dribbble', 'mayflower' ),
		'baseurl' => 'http://www.dribbble.com',
			'genericon' => ''
        ),
        'facebook' => array(
		'name' => 'facebook',
		'title' => __( 'Facebook', 'mayflower' ),
		'baseurl' => 'http://www.facebook.com',
			'genericon' => ''
        ),
        'flickr' => array(
		'name' => 'flickr',
		'title' => __( 'Flickr', 'mayflower' ),
		'baseurl' => 'http://www.flickr.com/photos',
			'genericon' => ''
        ),
        'github' => array(
		'name' => 'github',
		'title' => __( 'GitHub', 'mayflower' ),
		'baseurl' => 'http://www.github.com',
			'genericon' => ''
        ),
        'googleplus' => array(
		'name' => 'googleplus',
		'title' => __( 'Google+', 'mayflower' ),
		'baseurl' => 'http://profiles.google.com',
			'genericon' => ''
        ),
        'linkedin' => array(
		'name' => 'linkedin',
		'title' => __( 'Linked-In', 'mayflower' ),
		'baseurl' => 'http://www.linkedin.com/in',
			'genericon' => ''
        ),
        'pinterest' => array(
		'name' => 'pinterest',
		'title' => __( 'Pinterest', 'mayflower' ),
		'baseurl' => 'http://www.pinterest.com',
			'genericon' => ''
        ),
        'tumblr' => array(
		'name' => 'tumblr',
		'title' => __( 'Tumblr', 'mayflower' ),
		'baseurl' => 'tumblr.com',
			'genericon' => ''
        ),
        'twitter' => array(
		'name' => 'twitter',
		'title' => __( 'Twitter', 'mayflower' ),
		'baseurl' => 'http://www.twitter.com',
			'genericon' => ''
        ),
        'vimeo' => array(
		'name' => 'vimeo',
		'title' => __( 'Vimeo', 'mayflower' ),
		'baseurl' => 'http://www.vimeo.com',
			'genericon' => ''
        ),
        'wordpress' => array(
		'name' => 'wordpress',
		'title' => __( 'WordPress', 'mayflower' ),
		'baseurl' => 'http://profiles.wordpress.org',
			'genericon' => ''
        ),
        'youtube' => array(
		'name' => 'youtube',
		'title' => __( 'YouTube', 'mayflower' ),
		'baseurl' => 'http://www.youtube.com',
			'genericon' => ''
        ),
    );
	return apply_filters( 'mayflower_get_social_networks', $socialnetworks );
}

/**
 * Get WPORG Support Forum Feed
 *
 * @link 	http://codex.wordpress.org/Function_Reference/fetch_feed	fetch_feed()
 *
 * @return	HTML markup for feed list
 */
function mayflower_get_support_feed() {

	// Create transient key string. Used to ensure API data are
	// pinged only periodically. Different transient keys are
	// created for commits, open issues, and closed issues.
	$transient_key = 'mayflower_support_feed';

	// If cached (transient) data are used, output an HTML
	// comment indicating such
	$cached = get_transient( $transient_key );

	if ( false !== $cached ) {
		return $cached .= "\n" . '<!--Returned from transient cache.-->';
	}

	$markup = '';

	// Load feed functional file
	include_once( ABSPATH . WPINC . '/feed.php' );

	// Fetch the feed object
	$rss = fetch_feed( 'http://wordpress.org/support/rss/theme/mayflower' );

	// Error handling
	if ( ! is_wp_error( $rss ) ) {

		// Figure out how many total items there are, but limit it to 5.
		$maxitems = $rss->get_item_quantity( 15 );

		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items( 0, $maxitems );

		$markup .= '<table>';

			if ( $maxitems == 0 ) {
				$markup .= '<tr><td>' . __( 'No items', 'mayflower' ) . '</td></tr>';
			} else {
				$markup .= '<thead><tr><th>' . __( 'Topic', 'mayflower' ) . '</th><th>' . __( 'Posted', 'mayflower' ) . '</th></tr></thead><tbody>';
				// Loop through each feed item and display each item as a hyperlink.
				foreach ( $rss_items as $item ) {
					$markup .= '<tr>';
						$markup .= '<td style="padding:3px 5px;font-size:12px;">' . esc_html( $item->get_title() ) . '</td>';
						$markup .= '<td>';
							$markup .= '<a href="' . esc_url( $item->get_permalink() ) . '">';
								$markup .= human_time_diff( $item->get_date( 'U' ), current_time( 'timestamp' ) ) . ' ago';
							$markup .= '</a>';
						$markup .= '</td>';
					$markup .= '</tr>';
				}
			}

		$markup .= '</tbody></table>';

		// Set the transient (cache) for the API data
		set_transient( $transient_key, $markup, 60*60*24 );

	} else {
		$markup .= '<p>' . __( 'RSS feed error.', 'mayflower' ) . '</p>';
	}
	// Return markup
	return $markup;
}

/**
 * Define default Widget arguments
 *
 * @uses	mayflower_showhide_widget_content_close()	Defined in functions/custom.php
 * @uses	mayflower_showhide_widget_content_open()		Defined in functions/custom.php
 */

function mayflower_get_widget_args() {
	$widget_args = array(
		// Widget container opening tag, with classes
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		// Widget container closing tag
		'after_widget' => '</div>' . mayflower_showhide_widget_content_close(),
		// Widget Title container opening tag, with classes
		'before_title' => '<div class="title widgettitle">',
		// Widget Title container closing tag
		'after_title' => '</div>' . mayflower_showhide_widget_content_open()
	);
	return $widget_args;
}


/**
 * Add navigation links to infobar
 */
function mayflower_infobar_navigation() {

	// Start of Pagination
	if ( ! is_singular() ) {
		if ( function_exists( 'wp_paginate' ) ) {
			wp_paginate( 'title=' );
		} else {
			echo mayflower_get_paginate_archive_page_links( 'list' );
		}
	}

	if ( is_singular( 'post' ) && ! is_attachment() ) {
		echo '<div class="prevnextpostlinks">';
		next_post_link( '%link', '&lArr; ' );
		previous_post_link( '%link', ' &rArr;' );
		echo '</div>';
	}

}

/**
 * Locate the directory URI for a template
 *
 * This function is essentially a rewrite of locate_template()
 * that searches for filepath and returns file directory. Useful for
 * child-theme overrides of parent Theme resources.
 */
function mayflower_locate_template_uri( $template_names, $load = false, $require_once = true ) {
	$located = '';
	foreach ( (array) $template_names as $template_name ) {
		if ( ! $template_name ) {
			continue;
		}
		if ( file_exists( get_stylesheet_directory() . '/' . $template_name ) ) {
			$located = get_stylesheet_directory_uri() . '/' . $template_name;
			break;
		} else if ( file_exists( get_template_directory() . '/' . $template_name ) ) {
			$located = get_template_directory_uri() . '/' . $template_name;
			break;
		}
	}

	if ( $load && '' != $located ) {
		load_template( $located, $require_once );
	}

	return $located;
}


/**
 * Return widget content opening div
 */
function mayflower_showhide_widget_content_open() {
	$options = mayflower_get_options();
    $showhide = '<span class="showhide">';
    $showhide .= 'Click to ';
    $showhide .= '<span style="color:#5588aa;" onclick="d=this.parentElement.nextElementSibling; d.style.display==\'none\' ? d.style.display=\'block\' : d.style.display=\'none\';">view/hide</span>';
    $showhide .= '<br /></span>';
    $showhide .= '<div class="widget-inner" style="display:' . $options['widget_display_default_state'] . ';">';

    return apply_filters( 'mayflower_showhide_widget_content_open', $showhide );
}

/**
 * Return widget content closing div
 */
function mayflower_showhide_widget_content_close() {
	return apply_filters( 'mayflower_showhide_widget_content_close', '</div>' );
}

/**
 * Display Social Icons
 */
function mayflower_social_icons() {
	global $mayflower_options;
	$mayflower_options = mayflower_get_options();
	?>
	<div class="sidebar-social-icons">
	<?php
	// Obtain the list of valid social networks
	$socialprofiles = mayflower_get_social_networks();
	// Loop through each social network
	foreach ( $socialprofiles as $profile ) {
		// holds the profile name for the currentsocial network
		$profilename = $profile['name'] . '_profile';
		// if the user has provided a profile name
		// for the current social network
		if ( ! empty( $mayflower_options[$profilename] ) ) {
			// holds the base URL for the current social network
			$baseurl = $profile['baseurl'];
			// build the full URL, including base URL and profile name
			$profileurl = $baseurl . '/' . $mayflower_options[$profilename];
			// Tumblr has to be different
			if ( 'tumblr' == $profile['name'] ) {
				$profileurl = 'http://' . $mayflower_options[$profilename] . '.' . $baseurl;
			}
			// Output the fully formed social network profile link
			?>
			<a class="sidebar-social-icon genericon" href="<?php echo $profileurl; ?>" title="<?php echo $profile['title']; ?>">
				<span class="genericon-<?php echo $profile['name']; ?>"></span>
			</a>
		<?php
		}
	}
	?>
	</div>
	<?php
}

/**
 * Sort GitHub API Data
 *
 * Callback function for usort() to sort the GitHub
 * API (v3) issues data by issue number or commit date
 *
 * @return	object	object of GitHub API data sorted by issue number or commit date
 */
function mayflower_sort_github_data( $a, $b ) {
	$sort = 0;
	$param_a = '';
	$param_b = '';
	if ( isset( $a->number ) ) {
		$param_a = $a->number;
		$param_b = $b->number;
	} else if ( isset( $a->committer ) ) {
		$commit_a = $a->commit;
		$commit_b = $b->commit;
		$committer_a = $commit_a->committer;
		$committer_b = $commit_b->committer;
		$param_a = get_date_from_gmt( date( 'Y-m-d H:i:s', strtotime( $committer_a->date ) ), 'U' );
		$param_b = get_date_from_gmt( date( 'Y-m-d H:i:s', strtotime( $committer_b->date ) ), 'U' );
	}
	if (  $param_a ==  $param_b ) {
		$sort = 0;
	} else {
		$sort = ( $param_a < $param_b ? -1 : 1 );
	}
	return $sort;
}
