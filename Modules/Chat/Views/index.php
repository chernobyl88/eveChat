<script type="text/javascript">

function check(base, data) {
	$.ajax({
		"dataType": "Json",
		"type":"post",
	    "data": data,//$('#details').serialise(),
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
					<input class="form-control" id="mail" type="text" name= "mail" id= "mail" size = "50" maxlength = "15" placeholder="Entrez ici votre adresse e-mail"/>
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
					<textarea placeholder="<?php echo PROBLEM_TXT; ?>" class="form-control" name= "problem" id= "problem" rows = "20" cols = "50"></textarea>
				</div>
			</div>
			<div>
				<div>
					<label for="agree"><?php echo VALID_TXT; ?></label>
				</div>
				
				<div>
					<input type = "checkbox" name = "agree" id = "agree" /> <label for="agree"><?php echo AGREE; ?></label>
				</div>
			</div>	
			<div class="bouton">
				<button class="btn-warning btn-lg btn" type="button"><?php echo SEND;?></button>
			</div>
			
		</div>
	</form>
</div>