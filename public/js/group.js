$(document).ready(function(){

	$( "#email" ).autocomplete({
	    minLength: 3,
	    source: function( request, response ) {
	      $.ajax({
	          	url: base_url + "/users_parcial",
	          	dataType: "json",
	            data: {term: request.term},
	          	success: function( data ) {
	              response( $.map( data, function( item ) {
	                  return {
	                      label: item.email,
	                      value: item.email
	                  }
	              }));
	          	}
	      });
	    }
	});
});