<?php

/*

Nice script from http://www.finalwebsites.com/snippets.php?id=39

example of usage:
inside your form
<input type="text" name="validator" id="validator" size="4" />
<img src="captcha.php" alt="CAPTCHA image" width="60" height="20" vspace="1" align="top" />

and test the value of the "validator" form field like:
if (!empty($_POST['validator']) && $_POST['validator'] == $_SESSION['rand_code']) {
	process your form here
	at least destroy the session
	unset($_SESSION['rand_code']);

*/

session_start();
session_regenerate_id(true); // Generate new session id and delete old (PHP >= 5 only)

// Captcha string
if (!isset($_SESSION['rand_code'])) {
	$str = "";
	$length = 0;
	for ($i = 0; $i < 4; $i++) {
	// this numbers refer to numbers of the ascii table (small-caps)
		 $str .= chr(rand(97, 122));
	}
	$_SESSION['rand_code'] = $str;
}

// generate captcha image
$imgX = 60;
$imgY = 20;
$image = imagecreatetruecolor(60, 20);
$backgr_col = imagecolorallocate($image, 238,239,239);
$border_col = imagecolorallocate($image, 125,125,125);
$text_col = imagecolorallocate($image, 125,125,125);
imagefilledrectangle($image, 0, 0, 60, 20, $backgr_col);
imagerectangle($image, 0, 0, 59, 19, $border_col);
$font = "includes/elephant.ttf"; // font
$font_size = rand(12, 15);
$angle = rand(-5, 5);
$box = imagettfbbox($font_size, $angle, $font, $_SESSION['rand_code']);
$x = (int)($imgX - $box[4]) / 2;
$y = (int)($imgY - $box[5]) / 2;
imagettftext($image, $font_size, $angle, $x, $y, $text_col, $font, $_SESSION['rand_code']);
header("Content-type: image/png");
imagepng($image);
imagedestroy ($image);

?>

