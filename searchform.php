<?php
// Globalize $mayflower_options
global $mayflower_options;

// Load options if they are not already present
if ( !( is_array( $mayflower_options ) ) ) {
	$mayflower_options = mayflower_get_options();
}

// Set variables for ease of use
$limit_searchform_scope  = $mayflower_options['limit_searchform_scope'];
$custom_searchform_scope = $mayflower_options['custom_searchform_scope'];
$search_url              = '//www.bellevuecollege.edu/search/';
$site_url                = get_site_url();

/* Set Scope to Site URL if not otherwise defined */
if ( empty( $custom_searchform_scope ) ) {
	$custom_searchform_scope = "[site:$site_url]";
}
?>
<form action="<?php echo $search_url; ?>" method="get" class="form-search" id="bc-search">
	<div class="input-group pull-right" role="search">
		<label class="sr-only" for="college-search-field">Search</label>
		<input type="text" value="" name="txtQuery" class="form-control" id="college-search-field" maxlength="255">
		<div class="input-group-btn">
			<button type="submit" class="btn btn-default" id="college-search-submit">Search</button>
			<?php if ( $limit_searchform_scope ) : ?>
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="caret"></span>
					<span class="sr-only">More Search Options</span>
				</button>
				<div class="dropdown-menu dropdown-menu-right">
					<a href="<?php echo $search_url; ?>" class="btn btn-link" id="college-search-submit-all">Search all of Bellevue College</a>
				</div>
				<script type="text/javascript">
					/* Insert limiting search terms on submit */
					jQuery( "#bc-search" ).submit(function( event ) {
						jQuery('#college-search-field').val('<?php echo $custom_searchform_scope; ?> ' + jQuery('#college-search-field').val());
					});
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
