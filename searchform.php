<?php
// Globalize $mayflower_options
global $mayflower_options;

// Load options if they are not already present
if ( !( is_array( $mayflower_options ) ) ) {
	$mayflower_options = mayflower_get_options();
}

// Set variables for ease of use
$limit_searchform_scope  = $mayflower_options['limit_searchform_scope'];
$custom_searchform_query = $mayflower_options['custom_searchform_query'];
$custom_searchform_scopes = $mayflower_options['custom_searchform_scope'];
$search_url              = '//www.bellevuecollege.edu/search/';
$site_url                = get_site_url();

/* Set Scope to Site URL if not otherwise defined
   Explode if it is defined */
if ( empty( $custom_searchform_scopes ) ) {
	$custom_searchform_scopes[0] = $site_url;
} else {
	$custom_searchform_scopes = explode(',', $custom_searchform_scopes );
}
?>
<form action="<?php echo $search_url; ?>" method="get" class="form-search" id="bc-search">
	<label class="sr-only" for="college-search-field">Search</label>
	<div class="input-group pull-right" role="search">
		<input type="text" value="" name="txtQuery" class="form-control" id="college-search-field" maxlength="255">
		<div class="input-group-btn">
			<button type="submit" class="btn btn-default" id="college-search-submit">Search</button>
			<?php if ( $limit_searchform_scope ) : ?>
			<?php //Output filter fields
				foreach( $custom_searchform_scopes as $scope ) { ?>
					<input type="hidden" value="<?php echo trim( $scope ); ?>" name="<?php echo $custom_searchform_query; ?>[]">
			<?php } ?>
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="caret"></span>
					<span class="sr-only">More Search Options</span>
				</button>
				<div class="dropdown-menu dropdown-menu-right">
					<a href="<?php echo $search_url; ?>" class="btn btn-link" id="college-search-submit-all">Search all of Bellevue College</a>
				</div>
				<script type="text/javascript">
					/* Generate search URL in dropdown */
					jQuery('#college-search-submit-all').click( function( event ) {
						/* Default action is to simply go to search page, if no JS */
						event.preventDefault();
						var url = "<?php echo $search_url; ?>?txtQuery=" + jQuery( '#college-search-field' ).val(); 
						jQuery(location).attr('href', url);
					});
				</script>
			<?php endif; ?>
		</div>
	</div>
</form>
