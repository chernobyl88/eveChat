<script type="text/javascript">

function check(data) {
	base
	$.ajax({
		"dataType": "Json",
		"type":"post",
	    "data": data,//$('#formulaire').serialise(),
	    "url": base+"/chat/check.html"
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

function isEmailValid(email) {
	var pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
    return pattern.test(email);
};

$('#sendfirstform').click(function(){
	if(!isEmailValid(email)) { 
		var mail = $('#mail').val()
	} else {
		$("#mail").css( "border-color", "red"; "border-style", "solid" );
		alertify.error('Veuillez saisir une adresse e-mail correcte');
	}
	if($("#service").val() != "") { 
		var service = $('.listederoulante').val();
	} else {
		$("#service").css( "border-color", "red"; "border-style", "solid" );
		alertify.error('Veuillez selectionner le département concerné');
	}
	if($("#probleme").length >= 100 ) { 
		var probleme = $('#probleme').val();
	} else {
		$("#probleme").css( "border-color", "red"; "border-style", "solid" );
		alertify.error("Veuillez décrire votre problème" <br>"100 Au minimum 100 caractères sont requis" );
	}
	if ((!isEmailValid(email)) && ($("#service").val()) && ($("#probleme").length >= 100 ) && ($('input[name=agree]').is(':checked'))) {
		check({"mail": mail, "service": service, "probleme": probleme})
	} else {
	    alertify.alert("Veuillez cocher la case qui indique que vous acceptez les conditions d'utilisation");
	}	
});


$( document ).ready(function() {
	envoi();
}
					

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