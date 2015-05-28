<div>
	<form method="post" action="check.php">
		<div>
			<div>
				<div>
					<?php
						echo ENTER_EMAIL;
					?>
				</div>
				
				<div>
					<input type = text name= "mail" id= "mail" size = "50" maxlength = "15" />
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