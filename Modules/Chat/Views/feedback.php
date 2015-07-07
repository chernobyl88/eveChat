<script>
function post(data,base) {
	$.ajax({
		"dataType": "Json",
		"type":"post",
	    "data": data,
	    "url": base+"/Chat/sendFeedback.php"
	})
	.done(function( msg ) {
		alert( "Data Saved: " + msg );
	});
};

$( document ).ready(function() {
	
	$("#envoyer").click(function(){
		if($("#feedback").val().length >= 10 ) {
			var quality = $('#quality').val();
			var politess = $('#politess').val();
			var reply = $('#reply').val();
			var feedback = $('#feedback').val();
			post ({ "feedback": feedback, "quality": quality, "politess": politess, "reply": reply},"<?php echo $rootLang;?>")
		} else {
			$("#feedback").css("border-color","red").css("border-style","solid");
			alertify.error("Si vous le désirez, au minimum 10 caractères sont requis pour laisser un message au superviseur. <br><br> Sinon, cliquez sur Passer." );
			$("#feedback").click(function() {
				$("#feedback").css("border-color","#66afe9").css("border-style","solid"); 
				});
		}
	});

	
	
});

</script>

<div class="divcadre">
	<div class="textcenter">
		<div class="eval">
			<?php echo FEEDBACK_QUALITY;?>
		</div>
		<div id="quality" class="rateit bigstars" data-rateit-starwidth="44" data-rateit-starheight="20" data-rateit-step="0.45"></div>	
	</div>
	<div class="textcenter">
		<div class="eval">
			<?php echo FEEDBACK_POLITESS;?>
		</div>
		<div id="politess" class="rateit bigstars" data-rateit-starwidth="44" data-rateit-starheight="20" data-rateit-step="0.45"></div>	
	</div>
	<div class="textcenter">
		<div class="eval">
			<?php echo FEEDBACK_REPLY;?>
		</div>
		<div id="reply" class="rateit bigstars" data-rateit-starwidth="44" data-rateit-starheight="20" data-rateit-step="0.45"></div>	
	</div>	
	
	<!--<?php
	if (count($listeError) == 0) {
	foreach ($typeQuestion AS $type) {
		?>
		
		
		
		   <div>
			<div class="textcenter">
				<?php echo (defined(strtoupper("FEEDBACK_" . $type))) ? constant(strtoupper("FEEDBACK_" . $type)) : $type;?>
			</div>
			<div>
				<select name="<?php echo $type;?>">
					<?php
					for ($i = 1; $i <= $maxFeedback; $i++) {
						?>
						<option value="<?php echo $i?>"><?php echo $i?></option>
						<?php
					}
					?>
				</select>
			</div>
		</div>
		
		<?php
	}
	?>-->

	<div class="textcenter">
			
		<?php echo ENTER_MESSAGE;?>	
	</div>
				
	<div class="form-group">
		<textarea placeholder="<?php echo ENTER_MSG;?>" class="form-control" name= "feedback" id= "feedback" rows = "20" cols = "50"></textarea>
	</div>
	<div class="divabouton">
		<div class="left">
			<button class="btn-warning btn-lg btn" id="plainte" type="button" class="left"onClick="location.href='pleinte.html'"><?php echo COMPLAINT;?></button>
		</div>
		<div class="bouton">
			<button class="btn-warning btn-lg btn" id="envoyer" type="button"><?php echo SEND;?></button>
		</div>
		<div class="bouton">
			<button class="btn-warning btn-lg btn" id="skip" type="button" onClick="location.href='thanks.html'"><?php echo SKIP;?></button>
		</div>
	</div>
	<?php
	} else {
		foreach ($listeError AS $e) {
			echo $e;	
		}
	}
	?>
</div>	
