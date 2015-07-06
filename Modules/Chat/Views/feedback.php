<script>
$( document ).ready(function() {
	$("#input-id").rating();
});
</script>
<div class="divcadre">

	<?php
	if (count($listeError) == 0) {
	foreach ($typeQuestion AS $type) {
		?>
		
		<div>
			<input id="input-id" type="number" class="rating" min=1 max=10 step=1 data-size="md" data-rtl="true">
		</div>
		
		<!--   <div>
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
		</div>-->
		
		<?php
	}
	?>

	<div class="textcenter">
			
		<?php echo ENTER_MESSAGE;?>	
	</div>
				
	<div class="form-group">
		<textarea placeholder="<?php echo ENTER_MSG;?>" class="form-control" name= "feedback" id= "feedback" rows = "20" cols = "50"></textarea>
	</div>
	
	<div class="bouton">
		<button class="btn-warning btn-lg btn" type="button"><?php echo SEND;?></button>
	</div>
	<?php
	} else {
		foreach ($listeError AS $e) {
			echo $e;	
		}
	}
	?>
</div>	
