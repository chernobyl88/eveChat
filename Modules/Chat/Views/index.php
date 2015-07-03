<script type="text/javascript">

	
	function check(data, base) {	
		$.ajax({
			"dataType": "Json",
			"type":"post",
		    "data": data,//$('#formulaire').serialise(),
		    "url": base+"/Chat/check.html"
		}).done(function(data) {
			if(data.entity && data.entity.valid == 1)
				$(window).attr("location",base+"/chat/chat.html");
			else
				if(data.entity && data.entity.valid == 0)
					if (data.entity.error && data.entity.error.entity.length > 0) {
						$.each(data.entity.error.entity, function(key, data) {
							alert(data);
						});
					} else 
						callBack();//$(window).attr("location", base+"/chat/check.html");
			
		}).fail(function(xhr,error){
			alert(error);
		});
	}

	
$( document ).ready(function() {	
	
	$("#sendfirstform").click(function(){
		var email = $('#mail').val()
		var valid = /^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(email)
		if (valid) {
			var email = $('#mail').val()
		} else {
			$("#mail").css("border-color","red").css("border-style","solid");
			alertify.error('Veuillez saisir une adresse e-mail correcte');
			$("#mail").click(function() {
				$("#mail").css("border-color","#66afe9").css("border-style","solid"); 
				});
		}
		if($(".listederoulante").val() > 0) { 
			var sujet = $('.listederoulante').val();
		} else {
			$(".listederoulante").css("border-color","red").css("border-style","solid");
			alertify.error('Veuillez selectionner le département concerné');
			$(".listederoulante").click(function() {
				$(".listederoulante").css("border-color","#66afe9").css("border-style","solid"); 
				});
		}
		if($("#probleme").val().length > 100 ) { 
			var probleme = $('#probleme').val();
		} else {
			$("#probleme").css("border-color","red").css("border-style","solid");
			alertify.error("Veuillez décrire votre problème :<br> Au minimum 100 caractères sont requis." );
			$("#probleme").click(function() {
				$("#probleme").css("border-color","#66afe9").css("border-style","solid"); 
				});
		}
		if ($('input[name=agree]').is(':checked')) {
		} else {
		    alertify.alert("Veuillez cocher la case qui indique que vous acceptez les conditions d'utilisation");
		}	
		if (($('#agree').is(':checked')) && (valid) && ($(".listederoulante").val() > 0) && ($("#probleme").val().length > 100 )) {
			check({"mail": mail, "sujet": sujet, "probleme": probleme},"<?php echo $rootLang;?>")
		} else {
		    alertify.alert("Verifiez que tout les champs sont correctement remplis");
		}	
	});
});

					

</script>
<div class="divlogo">

</div>
				
<div class="divcadre">
	<form id="formulaire" method="post" action="check.php">
		<div>
			<div>
				<div class="textcenter">
					<?php
						echo ENTER_EMAIL;
					?>
				</div>
				
				<div class="form-group">
					<input class="form-control" type="text" required="required" name= "mail" id= "mail" size = "50"  placeholder="<?php echo MAIL_TXT; ?>" />
				</div>
			</div>
			<div>
				<div class="textcenter">
					<?php
						echo INSERT_SUBJECT;
					?>
				</div>
				<div class="divlistederoulante">
					<select class="listederoulante" name="request">
					<option disabled="disabled" selected="selected" value="0">Veuilliez choisir le sujet lié à votre problème</option>
					<?php
					foreach($listeReq AS $elem) {
						?>
						<option value="<?php echo$elem["id"]?>"><?php echo $elem["cst_type"]?></option>
						<?php
					}
					?>
					</select>
				</div>
				<div>
						
				</div>
			</div>
			<div>
				<div class="textcenter">
			
					<?php 
						echo ENTER_PROBLEM;
					?>	
				</div>
				
				<div class="form-group">
					<textarea placeholder="<?php echo PROBLEM_TXT; ?>" required="required" class="form-control" name= "probleme" id= "probleme" rows = "20" cols = "50"></textarea>
				</div>
			</div>
			<div>
				<div>
					<label for="agree"><?php echo VALID_TXT; ?></label>
				</div>
				
				<div>
					<input type = "checkbox" required="required" name ="agree" id ="agree" /> <label for="agree"><?php echo AGREE; ?></label>
				</div>
			</div>	
			<div class="bouton">
				<button class="btn-warning btn-lg btn" type="button" id="sendfirstform"><?php echo SEND;?></button>
			</div>
			
		</div>
	</form>
</div>