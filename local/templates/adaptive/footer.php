<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

		<?php
		//особая логка по тому, где располагается футер. на главной и не на главной - он располагается в разных местах DOM дерева
		//см:
		//главная local/templates/adaptive/markup/pages/index.html
		//не главная local/templates/adaptive/markup/pages/text.html
		if (!isMainPage()) {
			\CU_Layout_Footer::printFooter();
		}
		?>

		<script>
			BX.ready(function(){
				var upButton = document.querySelector('[data-role="eshopUpButton"]');
				BX.bind(upButton, "click", function(){
					var windowScroll = BX.GetWindowScrollPos();
					(new BX.easing({
						duration : 500,
						start : { scroll : windowScroll.scrollTop },
						finish : { scroll : 0 },
						transition : BX.easing.makeEaseOut(BX.easing.transitions.quart),
						step : function(state){
							window.scrollTo(0, state.scroll);
						},
						complete: function() {
						}
					})).animate();
				})
			});
		</script>
	</body>
</html>