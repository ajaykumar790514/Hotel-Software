<!-- <div class="table-responsive"> -->
	<div id="msg"></div>
	<?=$cal?>			
<!-- </div> -->

<script type="text/javascript">
$(document).ready(function(e) {
	var currentDate = <?=date('d')?>-5;
	if (currentDate>0) {
		currentDate = ("0" + currentDate).slice(-2);
		var calposition =  $('[date='+currentDate+']').position();
		$( "div.p-cal" ).scrollLeft( calposition.left );
	}
})
</script>