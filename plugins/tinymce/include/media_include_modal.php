<style>

	.modalTinyMCE{
		min-width: 60%;

	}

</style>


<div id="MediaIncludeBox" class="modal">
	<div class="modal-dialog modalTinyMCE" role="document">
		<div class="modal-content ">
			<div class="modal-header">
				<h5 class="modal-title">PUMA - Media Include</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" >&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="mediaURL">
					<div class="form-group">
						<label for="bar">Kopieren Sie in nachfolgendes Feld die URL der Seite, auf der sich die Mediendatei befindet, die Sie gerne einbinden möchten.</label>
						<input class="form-control" type="text" name="InclURL" placeholder="URL der zu durchsuchenden Webseite">
						<input type="submit" class="btn btn-primary pull-right" value="Mediendateien auflisten" style="margin-top:5px;">
						<div style="clear:both;"></div>
					</div>
				</form>
				<div id="mediaWrapper">

				</div>
				<div style="clear:both;"></div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" language="javascript">
	$(document).on("click","div.PUMAMediaInclude",function(){
		item_url="";
		item_url = $(this).data("src");
		tinymce.activeEditor.execCommand('mceInsertContent', false, item_url);
		$( "#modalWrapper" ).empty();
		$( "body" ).removeClass( "modal-open" );

	});
</script>

<script>
	// Variable to hold request
	var request;

	// Bind to the submit event of our form
	$("#mediaURL").submit(function(event){

		// Prevent default posting of form - put here to work in case of errors
		event.preventDefault();

		// Abort any pending request
		if (request) {
			request.abort();
		}
		// setup some local variables
		var $form = $(this);

		// Let's select and cache all the fields
		var $inputs = $form.find("input, select, button, textarea");

		// Serialize the data in the form
		var serializedData = $form.serialize();
		var response="";
		// Let's disable the inputs for the duration of the Ajax request.
		// Note: we disable elements AFTER the form data has been serialized.
		// Disabled form elements will not be serialized.
		$inputs.prop("disabled", true);

		// Fire off the request to /form.php
		request = $.ajax({
			url: "/plugins/tinymce/include/media_include_ajax.php",
			type: "post",
			data: serializedData,
		});

		// Callback handler that will be called on success
		request.done(function (response, textStatus, jqXHR){
			$("#mediaWrapper").html(response);
// 			console.log(response);
		});

		// Callback handler that will be called on failure
		request.fail(function (jqXHR, textStatus, errorThrown){
			// Log the error to the console
			console.error(
				"The following error occurred: "+
				textStatus, errorThrown
			);
		});

		// Callback handler that will be called regardless
		// if the request failed or succeeded
		request.always(function () {
			// Reenable the inputs
			$inputs.prop("disabled", false);
		});


	});
</script>