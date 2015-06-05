<div class="divcadre">

	<?php
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
	?>

	<div class="textcenter">
			
		<?php echo ENTER_MESSAGE;?>	
	</div>
				
	<div class="form-group">
		<textarea placeholder="<?php echo ENTER_MSG;?>" class="form-control" name= "problem" id= "problem" rows = "20" cols = "50"></textarea>
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
