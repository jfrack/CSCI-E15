<?php
function between($number, $from, $to)
{
	return ($number>=$from && $number<$to);
}

$time = date('g:iA');
$timeZone = date('e');
// get current hour of the day (0-23)
$hour = date('G');
$imagePath = 'http://making-the-internet.s3.amazonaws.com/';

if (between($hour,5,11)) {
	$timeDay = 'morning';
	$image = $imagePath.'php-morning.png';
}
else if (between($hour,11,16)) {
	$timeDay = 'afternoon';
	$image = $imagePath.'php-afternoon.png';
}
else if (between($hour,16,20)) {
	$timeDay = 'evening';
	$image = $imagePath.'php-evening.png';
}
else {
	$timeDay = 'night';
	$image = $imagePath.'php-night.png';
}
?>