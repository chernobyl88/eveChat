<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>EVE</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<link rel=stylesheet type="text/css" href="eve/Web/css/bootstrap.css">
	</head>
	<body>
	
	<?php
	if ($user->isAuthenticated()) {
		?>
		<a href="?deco=1"><i class="icon-off"></i><?php echo MENUDECO ;?></a>
		<?php
	}
	?>
	
		<?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
		<?php echo $content;?>
	</body>
</html>