<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>EVE</title>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $root;?>/Web/js/alertify.min.js"></script>
		<script type="text/javascript" src="<?php echo $root;?>/Web/js/jquery.rateit.min.js"></script>	
		<link rel="stylesheet" href="<?php echo $root;?>/Web/css/alertify.core.css">
		<link rel="stylesheet" href="<?php echo $root;?>/Web/css/alertify.default.css" id="toggleCSS" />
		<link rel=stylesheet type="text/css" href="<?php echo $root;?>/Web/css/bootstrap.css">
		<link rel=stylesheet type="text/css" href="<?php echo $root;?>/Web/css/bootstrap.min.css">		
		<link rel=stylesheet type="text/css" href="<?php echo $root;?>/Web/css/rateit.css">	
		<link rel=stylesheet type="text/css" href="<?php echo $root;?>/Web/css/ajouts.css">
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