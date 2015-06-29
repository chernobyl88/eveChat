<script type="text/javascript">

function callBack() {
	setTimeout(function(){
		check("<?php echo $rootLang;?>", JSON.stringify(new Object()));
	}, 1000);
}
</script>

<script src="<?php echo $root;?>/Web/js/check.js"></script>

<script>
$(document).ready(function() {
	callBack();
});


</script>
<div class="divlogo">

</div>
				
<div class="divcadre">
	<div id="attendre">
		<p>Veuillez patientez, un conseiller va vous répondre.</p>
	</div>
</div>