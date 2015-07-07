<script type="text/javascript">
function post(data,base) {
	$.ajax({
		"dataType": "Json",
		"type":"post",
	    "data": data,     
	    "url": base+"/Chat/sendPleinte.php"
	})
	.done(function( msg ) {
		alert( "Data Saved: " + msg );
	});
};

$( document ).ready(function() {
	
	$("#envoyer").click(function(){
		if($("#pleinte").val().length >= 100 ) {
			var pleinte = $('#pleinte').val();
			post ({ "complaint": pleinte},"<?php echo $rootLang;?>")
		} else {
			$("#pleinte").css("border-color","red").css("border-style","solid");
			alertify.error("Veuillez décrire votre plainte <br> 100 Au minimum 100 caractères sont requis" );
			$("#pleinte").click(function() {
				$("#pleinte").css("border-color","#66afe9").css("border-style","solid"); 
				});
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
