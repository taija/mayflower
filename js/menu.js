jQuery(document).ready(function() {
	jQuery('.menu-item').has('.sub-menu').each( function() {
		if ( jQuery( this ).hasClass('active') ) {
			var linkText = jQuery( this ).children('a').first().text();
			jQuery( this ).prepend( collapseLink( linkText ) );
		} else {
			jQuery( this ).prepend( expandLink( linkText ) );
		}
	});
});

jQuery('.sidebar').on('click', '.menu-expand-button', function( event ) {
	event.preventDefault();
	var linkText = jQuery( this ).siblings('a').not('.menu-expand-button').first().text();
	if ( jQuery( this ).hasClass('expanded') ){
		jQuery(this).siblings('.sub-menu').slideUp( 100 );
		jQuery(this).replaceWith( expandLink( linkText ) );
	} else {
		jQuery(this).siblings('.sub-menu').slideDown( 100 );
		jQuery(this).replaceWith( collapseLink( linkText ) );
	}
});

function expandLink( linkText ) {
	return '<a class="menu-expand-button" href="#" aria-expanded="false"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true"></span><span class="sr-only">Expand ' + linkText + ' Submenu</span></a>';
}
function collapseLink( linkText ) {
	return '<a class="menu-expand-button expanded" href="#" aria-expanded="true"><span class="glyphicon glyphicon glyphicon-minus-sign" aria-hidden="true"></span><span class="sr-only">Collapse ' + linkText + ' Submenu</span></a';
}

// Handle globals mobile-s17 menu integration
jQuery(document).ready(function($) {
	if ($("#top-wrap").hasClass("mobile-s17")) {
		$('.sidebar').first().clone().appendTo("#main-nav-wrap");
	}
});