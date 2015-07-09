<div class="divlogo">

</div>
				
<div class="divcadre">
	<form id="formulaire" method="post" action="check.php">
		<div>
			<div class="2col">
				<div class="one">
					<div class="textcenter">
							<?php
								echo DEFINE_SERVICE;
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
				</div>
				
				<div class="two">
					<div class="textcenter">
						<?php
							echo DEFINE_NUMBER;
						?>
					</div>
					<div>
						<div class="form-group">
							<textarea placeholder="0" class="form-control" name= "problem" id= "problem" rows = "1" cols = "6"></textarea>
						</div>
					</div>
				</div>
			</div>
			
			<div>
				<div class="textcenter">
					<?php
						echo ENTER_EMAIL;
					?>
				</div>
				
				<div class="form-group">
					<input class="form-control" id="mail" type="text" name= "mail" id= "mail" size = "50" maxlength = "15" placeholder="<?php echo MAIL_TXT; ?>"/>
				</div>
			</div>
			<div>
				
				<div>
						
				</div>
			</div>
			<div>
				<div class="textcenter">
			
					<?php 
						echo WELCOME_MSG;
					?>	
				</div>
				
				<div class="form-group">
					<textarea placeholder="<?php echo WELCOME_MSG; ?>" class="form-control" name= "problem" id= "problem" rows = "2" cols = "50"></textarea>
				</div>
			</div>
			<div class="bouton">
				<button class="btn-warning btn-lg btn" type="button"><?php echo SEND;?></button>
			</div>
			
		</div>
	</form>
</div>