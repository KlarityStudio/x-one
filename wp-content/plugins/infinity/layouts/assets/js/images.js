jQuery(document).ready(function($){
	jQuery( '.image-part a:first-child' ).hover( function() {
			jQuery( this ).find( '.initial-image' ).hide();
			jQuery( this ).find( '.flip-image' ).show();
	}, function() {
			jQuery( this ).find( '.initial-image' ).show();
			jQuery( this ).find( '.flip-image' ).hide();
	});
});
