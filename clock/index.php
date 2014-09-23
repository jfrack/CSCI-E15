<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>CSCI E-15: Clock Exercise</title>
	<!-- Get local CSS -->
	<link rel="stylesheet" type="text/css" href="style.css" />
	<?php require('logic.php'); ?>
</head>
<body class=<?=$timeDay?>>
	<div>
		<h1>
			It is <?=$time?>
		</h1>
		Time zone: <?=$timeZone?>
		<br>
		<img src=<?=$image?>>
	</div>
</body>