<script type="text/javascript">
$(document).ready(function() {
	$("#envoyer").click(function() {
		if($("#pleinte").length >= 100 ) {
			var pleinte = $('#pleinte').val();
		} else {
			$("#pleinte").css("border-color","red").css("border-style","solid");
			alertify.error("Veuillez décrire votre plainte <br> 100 Au minimum 100 caractères sont requis" );
		}
	});
	
});

</script>

<div class="divcadre">
	<div class="textcenter">
		<?php echo ENTER_COMPLAINT;?>	
	</div>
				
	<div class="form-group">
		<textarea placeholder="<?php echo PROBLEM_TXT;?>" class="form-control" name= "pleinte" id= "pleinte" rows = "20" cols = "50"></textarea>
	</div>
	<div class="bouton">
		<button class="btn-warning btn-lg btn" type="button" id="envoyer"><?php echo SEND;?></button>
	</div>
	<div class="bouton">
		<button class="btn-warning btn-lg btn"  id="retour" type="button" onClick="location.href='feedback.html'"><?php echo BACK;?></button>
	</div>
</div>
