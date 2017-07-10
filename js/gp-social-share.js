jQuery( function( $ ) {
	
	$( '#gp-social-share a' ).click(function(){

		var url = $( this ).attr( 'href' );

		window.open( url, 'Social Share', 'width=500,height=400');

		return false;

	} );
	
} );