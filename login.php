<?php

/*

 This is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This software is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this software; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 or visit www.gnu.org
 
 Code by Lutsen Stellingwerff (www.biepenlu.nl)
 
 Based on code from evolt.org by jpmaster77
 http://evolt.org/php_login_script_with_remember_me_feature

*/

session_start();
session_regenerate_id(true); // Generate new session id and delete old (PHP >= 5 only)
include_once("includes/functions.php");
include_once("includes/config.php");

// Checks if user has submitted username and password through the login form.
// If so, checks authenticity in database and create session.
if(isset($_POST['subform'])){

	// check for errors
	$alertArr = array();

	if(!$_POST['user'])			$alertArr[] = $ALERT['USER_NO'];
	if (!$_POST['pass_field'])	$alertArr[] = $ALERT['PASS_NO'];

	// clean up
	$_POST['user'] = cleanString($_POST['user'], 30);
	$_POST['pass_field'] = '';
	$_POST['pass'] = cleanString($_POST['pass'], 40);
	$_POST['salt'] = '';
	$_POST['key'] = '';

	if (count($alertArr) == 0) {

		// Username and password correct, register session variables
		$_SESSION['username'] = $_POST['user'];
		$_SESSION['password'] = $_POST['pass'];

		// User has requested to remember being logged in,
		// so we set a cookies containing username, called c_name.
		// The cookie containing password, called c_pass, is set by javascript,
		// encrypted with salt, but NOT with key because the key changes every session.
		if(isset($_POST['remember'])) {
			setcookie("c_name", $_SESSION['username'], time()+60*60*24*100, "/");
		}

		// cannot redirect using header() because header is already sent with session_start()
		// using html meta refresh instead
		$refresh = SUCCESS_URL;
		exit(include_once(HTML_PATH."html_refresh.php"));
	}
}

// Display the login form AFTER other header stuff like cookies.
// (Cookies should be set before sending any other header information)
$alert = displayAlert($alertArr);

if ($_POST['pass_field']) $_POST['pass_field'] = "";

// html
include_once(HTML_PATH."html_login.php");
?>