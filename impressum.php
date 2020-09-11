<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/agb.php");

$actAGB=load_actual_AGB();
$_SESSION['agbID']=$actAGB['agbID'];

?>

<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/head_main.php");?>
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
		<?php include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/includes/header_bar.php");?>

		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<p><a href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/index.php">zurück</a></p>
					<h3>Technische Umsetzung</h3>
					<p>StR Peter Mayer</p>
					<p>Theresienstraße 37 (Raum A014)</p>
					<p>80333 München</p>
					<p><a href="http://www.didaktik.physik.uni-muenchen.de/die_arbeitsgruppe/personen/peter_mayer/index.html">weitere Informationen</a></p>

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

		</div>
	</body>
</html>