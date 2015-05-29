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
<div>
	<form id="formulaire" method="post" action="check.php">
		<div>
			<div>
				<div>
					<?php
						echo ENTER_EMAIL;
					?>
				</div>
				
				<div>
					<input id="mail" type="text" name= "mail" id= "mail" size = "50" maxlength = "15" />
				</div>
			</div>
			<div>
				<div>
					<?php
						echo INSERT_SUBJECT;
					?>
				</div>
					<select name="request">
					<?php
					foreach($listeReq AS $elem) {
						?>
						<option value="<?php echo$elem["id"]?>"><?php echo $elem["cst_type"]?></option>
						<?php
					}
					?>
					</select>
				<div>
						
				</div>
			</div>
			<div>
				<div>
			
					<?php 
						echo ENTER_PROBLEM;
					?>	
				</div>
				
				<div>
					<textarea name= "problem" id= "problem" rows = "20" cols = "50"></textarea>
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
			
		</div>
	</form>
</div>