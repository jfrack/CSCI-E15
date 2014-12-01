<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>OOP in PHP</title>
	<?php include ("class_lib.php"); ?>
</head>
<body>
	<?php

		$stefan = new person("Stefan Foo II");
		$jimmy = new person("Jimmy Bar III");
		$jimmy = new person("");

		//$stefan->set_name("Stefan Foo");
		//$jimmy->set_name("Jimmy Bar");

		echo "Stefan's full name: " . $stefan->get_name();
		echo "<br>";
		echo "Jimmy's full name: " . $jimmy->get_name();

		echo "foo";
	?>

</body>
</html>
