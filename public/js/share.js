/*
	This doccument includes all the logic. To use the file you must ensure that your view:
	- Contains a tag with id = file-data (no matter what kind of tag), which contains a data-id attribute with the file to query
	- Contains a tbody tag with id = shareTableBody 
	- Contains a form (#share-form-del) that contains in its route an :ID string to delete elements
	- Contains a form (#share-form-add) ready to add new elements
*/

$(document).ready(function(){
    var currentFile = $("#file-data").data('id');
    var url =  base_url + "/file/" + currentFile + "/share";
     $.get(url)
     	.done(function(data){
			for (i = 0; i < data.length; i++) { 
				createHTMLRowForData(data[i]);
			}

			bindDeletes();
     	})
     	.fail(function(){
     		$("#shareTableBody").html("<tr><td>There was an error while loading the data</td></tr>");
     	});


    $( "#share-email" ).autocomplete({
	    minLength: 3,
	    source: function( request, response ) {
	      $.ajax({
	          	url: base_url + "/users_complete",
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

	$('.datepicker').datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy/mm/dd" });

	$('#share-form-new').submit(function(event){
		event.preventDefault();

		var btn = $(this).find('button');
		var img = $(this).find('img');
		btn.fadeOut();
		img.fadeIn();

		var form = $('#share-form-new');

		var data = $(this).serialize();

		$.post($(this).attr('action'), data)
			.done(function (data) {
				form.find('#share-email').val('');
				createHTMLRowForData(data);
				bindDeletes();
				img.fadeOut();
				btn.fadeIn();
			})
			.fail(function() {
				img.fadeOut();
				btn.fadeIn();
				alert('There was a problem while sharing. Please ensure that dueDate was chosen from the calendar and that the user actually exists.');
			})

	});
});


function bindDeletes(){
	$(".btn-delete").off().click(function(e){
		e.preventDefault();
		var tr = $(this).parents("tr");
		var id = tr.data('id');
		var form = $('#share-form-del');
		var action = form.attr('action').replace(':ID', id);
		var data = form.serialize();

		var td = $(this).parents('.share-options-td');
		var oldHTML = td.html();
		td.html('<div class="col-xs-12 bar"></div>');

		var progressBar = td.children(".bar").progressbar({
  			value: false
		});

		$.post(action, data)
			.done(function (data) {
				tr.fadeOut();
				progressBar.progressbar('destroy');
			})
			.fail(function() {
				progressBar.progressbar('destroy');
				td.html(oldHTML);
				bindDeletes();
				alert('There was a problem while deleting the share');
			})
		});
}

function createHTMLRowForData(data){

	$("tr[data-id='" + data.id + "']").remove();

	var generatedHtml = '<tr data-id="' + data.id + '">';
	generatedHtml += "<td>" + data.email + "</td>";
	generatedHtml += "<td>" + data.name + "</td>";

	var text = data.dueDate == null ? "Never" : data.dueDate;
	generatedHtml += "<td>" + text + "</td>";
	generatedHtml += '<td class="share-options-td"><button type="button" class="btn btn-danger btn-delete">Delete entry</button></td>';
	generatedHtml += "</tr>"
	$("#shareTableBody").append(generatedHtml);

}