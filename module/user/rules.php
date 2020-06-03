<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include_once($_SERVER['DOCUMENT_ROOT']."/php/Sessions.php");
$SessionInfos=Get_SessionInfos($_SESSION['s']);
if($SessionInfos==null){
	session_destroy();
	echo "<script>window.location = '/module/user/login.php';</script>"; 
};

include_once($_SERVER['DOCUMENT_ROOT']."/php/agb.php");


if(isset($_POST['action']) && $_POST['action']=="confirm"){
	set_confirm_status(intval($_POST['status']));
	if(intval($_POST['status'])==1){
		echo "<script>window.location = '/module/admin/kurs_erstellen.php';</script>"; 
	}
}


$actAGB=load_actual_AGB();
$_SESSION['agbID']=$actAGB['agbID'];

?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/head_main.php");?>
		<script>
			(function(document, history, location) {
				var HISTORY_SUPPORT = !!(history && history.pushState);

				var anchorScrolls = {
					ANCHOR_REGEX: /^#[^ ]+$/,
					OFFSET_HEIGHT_PX: 70,

					/**
     * Establish events, and fix initial scroll position if a hash is provided.
     */
					init: function() {
						this.scrollToCurrent();
						window.addEventListener('hashchange', this.scrollToCurrent.bind(this));
						document.body.addEventListener('click', this.delegateAnchors.bind(this));
					},

					/**
     * Return the offset amount to deduct from the normal scroll position.
     * Modify as appropriate to allow for dynamic calculations
     */
					getFixedOffset: function() {
						return this.OFFSET_HEIGHT_PX;
					},

					/**
     * If the provided href is an anchor which resolves to an element on the
     * page, scroll to it.
     * @param  {String} href
     * @return {Boolean} - Was the href an anchor.
     */
					scrollIfAnchor: function(href, pushToHistory) {
						var match, rect, anchorOffset;

						if(!this.ANCHOR_REGEX.test(href)) {
							return false;
						}

						match = document.getElementById(href.slice(1));

						if(match) {
							rect = match.getBoundingClientRect();
							anchorOffset = window.pageYOffset + rect.top - this.getFixedOffset();
							window.scrollTo(window.pageXOffset, anchorOffset);

							// Add the state to history as-per normal anchor links
							if(HISTORY_SUPPORT && pushToHistory) {
								history.pushState({}, document.title, location.pathname + href);
							}
						}

						return !!match;
					},

					/**
     * Attempt to scroll to the current location's hash.
     */
					scrollToCurrent: function() {
						this.scrollIfAnchor(window.location.hash);
					},

					/**
     * If the click event's target was an anchor, fix the scroll position.
     */
					delegateAnchors: function(e) {
						var elem = e.target;

						if(
							elem.nodeName === 'A' &&
							this.scrollIfAnchor(elem.getAttribute('href'), true)
						) {
							e.preventDefault();
						}
					}
				};

				window.addEventListener(
					'DOMContentLoaded', anchorScrolls.init.bind(anchorScrolls)
				);
			})(window.document, window.history, window.location);
		</script>
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<?php
					if(isset($actAGB['status']) && $actAGB['status']==0){
					?>
					<div class="alert alert-danger">
						<h3>Nutzungsbedingungen abgelehnt</h3>
						<p>
							Sie haben die Nutzungsbedingungen abgelehnt und können daher PUMA@LMU nicht verwenden. Falls Sie PUMA@LMU verwenden möchten, müssen Sie die Nutzungsbedingungen akzeptieren.
						</p>
					</div>
					<?php
					}					
					?>
				</div>
				<div class="col-md-1"></div>
			</div>

			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<?php echo html_entity_decode ($actAGB['text'], ENT_QUOTES , "UTF-8");?>
					<hr>
				</div>
				<div class="col-md-1"></div>
			</div>

			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-5">
					<form action method="post">
						<input type="hidden" value="1" name="status">
						<input type="hidden" value="confirm" name="action">
						<button type="submit" class="btn btn-success btn-block">Teilnamebedingungen zustimmen</button>
					</form>
				</div>
				<div class="col-md-5">
					<form action method="post">
						<input type="hidden" value="0" name="status">
						<input type="hidden" value="confirm" name="action">
						<button type="submit" class="btn btn-danger btn-block">Teilnamebedingungen ablehnen</button>
					</form>
				</div>
				<div class="col-md-1"></div>
			</div>

		</div>
	</body>
</html>