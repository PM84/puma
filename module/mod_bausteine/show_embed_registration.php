<?php 
include($_SERVER['DOCUMENT_ROOT'].$bInfo['embLink']);

?>

<script>
	$("#btn_abgabe").hide();
	$(document).on("keypress", ":input:not(textarea)", function(event) {
		return event.keyCode != 13;
	});
</script>