<?php
global $mayflower_options;

// Load options if they are not already present.
if ( ! ( is_array( $mayflower_options ) ) ) {
	$mayflower_options = mayflower_get_options();
}

// Set variables for ease of use/configuration
$limit_searchform_scope  = $mayflower_options['limit_searchform_scope'];
$search_url_default      = '/search/';
$search_url              = ( $limit_searchform_scope && ( '' !== $mayflower_options['custom_search_url'] ) ) ?
								$mayflower_options['custom_search_url'] : $search_url_default;
$search_field_id         = $limit_searchform_scope ? 'college-search-field-custom' : 'college-search-field' ;
$filter_value            = mayflower_trimmed_url();
$search_api_key          = '' !== $mayflower_options['custom_search_api_key'] ? $mayflower_options['custom_search_api_key'] :
							'YUFwdxQ6-Kaa9Zac4rpb'; // <-- Default API Key
$search_query_peram      = 'txtQuery';
$filter_peram            = 'site[]'; // hardcoded default.

?>
<form action="<?php echo esc_url( $search_url ); ?>" method="get" class="form-search" id="bc-search">
	<label class="sr-only" for="<?php echo esc_attr( $search_field_id ); ?>">Search</label>
	<div class="input-group pull-right" role="search">
	<input type="text" name="<?php echo esc_attr( $search_field_id ); ?>" class="form-control" id="<?php echo esc_attr( $search_field_id ) ?>"  />
		
		<?php if ( $limit_searchform_scope ) : ?>
			<?php if ( '' === $mayflower_options['custom_search_url'] ) :
				// If there is NOT a custom search URL, output filter peram and filter js ?>
				<input type="hidden" class="college-search-filter" name="<?php echo esc_attr( $filter_peram ) ?>" value="<?php echo esc_attr( $filter_value ) ?>">
				<script type="text/javascript">
					(function ($) {
						$('#<?php echo esc_attr( $search_field_id ) ?>').swiftype({ 
							"engineKey" : "<?php echo esc_textarea( $search_api_key ); ?>",
							"filters" : {
								"page": {
									"wp_site_slug" : ["<?php echo esc_textarea( $filter_value ); ?>"]
								}
							}
						});
					})(jQuery);
				</script>
			<?php else :
				// Else output custom engine key ?>
				<script type="text/javascript">
					(function ($) {
						$('#<?php echo esc_attr( $search_field_id ) ?>').swiftype({ 
							"engineKey" : "<?php echo esc_textarea( $search_api_key ); ?>",
						});
					})(jQuery);
				</script>
			<?php endif; // no custom search url set ?>
		<?php endif; // limit searchform scope ?>
		<div class="input-group-btn">
			<button type="submit" class="btn btn-default" id="college-search-submit">Search</button>
			<?php if ( $limit_searchform_scope ) : ?>
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="caret"></span>
					<span class="sr-only">More Search Options</span>
				</button>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="<?php echo esc_url( $search_url ); ?>" id="college-search-site-link">Search <?php bloginfo( 'name' ); ?></a></li>
					<li><a href="<?php echo esc_url( $search_url_default ); ?>" id="college-search-all-link">Search Bellevue College <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a></li>
				</ul>
				<script type="text/javascript">
					/* Generate search URL in dropdown */
					jQuery('#college-search-site-link').click( function( event ) {
						// Default action is to simply go to search page, if no JS
						event.preventDefault();

						// Submit
						document.getElementById('bc-search').submit();
					});
					jQuery('#college-search-all-link').click( function( event ) {
						/* Default action is to simply go to search page, if no JS */
						event.preventDefault();

						// Remove filters and reset action URL
						jQuery('.college-search-filter').remove();
						jQuery('#bc-search').attr('action', '<?php echo esc_url( $search_url_default ); ?>');

						// Submit
						document.getElementById('bc-search').submit();
					});
				</script>
			<?php endif; // limit searchform scope ?>
		</div>
	</div>
</form>
