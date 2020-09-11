<?php
// Der closing - DIV TAG schließt den Tag aus menu.php	
?>
<script>
	$( ".jsIESupport" ).click(function() {
// 		alert("HALLO");
		$('<input />').attr('type', 'hidden')
			.attr('name', $(this).attr('name'))
			.attr('value', this.value)
			.appendTo('#'+$(this).attr('form'));
		$( '#'+$(this).attr('form') ).submit();
	});
</script>

</div>