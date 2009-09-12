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

// registration
include_once("includes/functions.php");
include_once("includes/config.php");

// Check if the ALLOW_JOIN variable is set
if (!ALLOW_JOIN) exit($ALERT['PAGE_UNAV']);

// Inserts the given (username, password) pair into the database.
// Returns true on success, false otherwise.
function addNewUser($username, $password, $email){
	global $conn;
	/* Add slashes if necessary (for query) */
	if(!get_magic_quotes_gpc()) {
		$username = addslashes($username);
		$password = addslashes($password);
		$email = addslashes($email);
	}
	$q = "INSERT INTO ".DB_PREFIX."users VALUES ('', '$username', '$password', '$email', ".time().", '".$_SERVER['REMOTE_ADDR']."', ".time().")";
	return mysql_query($q,$conn);
}



// Display registration result page
if(isset($_SESSION['registered'])){

	// html
	include_once(HTML_PATH."html_register_result.php");

	unset($_SESSION['reguname']);
	unset($_SESSION['registered']);
	unset($_SESSION['regresult']);
	return;
}



// If the register form has been submitted: check for errors.
// No errors (count($alertArr) == 0)? Add record to database.
// Errors? Display error messages and show form again.
if(isset($_POST['subform'])){

	// clean up
	if ($_POST['user'])				$_POST['user'] = cleanString($_POST['user'], 30);
	if ($_POST['pass_field_1'])		$_POST['pass_field_1'] = cleanString($_POST['pass_field_1'], 30);
	if ($_POST['pass_field_2'])		$_POST['pass_field_2'] = cleanString($_POST['pass_field_2'], 30);
	if ($_POST['email'])			$_POST['email'] = cleanString($_POST['email'], 140);
	if ($_POST['pass1'])			$_POST['pass1'] = cleanString($_POST['pass1'], 40);
	if ($_POST['pass2'])			$_POST['pass2'] = cleanString($_POST['pass2'], 40);
	if ($_POST['salt'])				$_POST['salt'] = '';
	if ($_POST['key'])				$_POST['key'] = '';

	// check for errors
	$alertArr = array();

	if(!$_POST['user']) {
		$alertArr[] = $ALERT['USER_NO'];
	}
	
	if(strlen($_POST['user']) > 30) {
		$alertArr[] = $ALERT['USER_TOLONG'];
	}
	
	if($_POST['user'] && strlen($_POST['user']) < 6) {
		$alertArr[] = $ALERT['USER_TOSHORT'];
	}

	if(!$_POST['pass_field_1']) {
		$alertArr[] = $ALERT['PASS_NO'];
	}

	if($_POST['pass_1'] != $_POST['pass_2']) {
		$alertArr[] = $ALERT['PASS_DIFF'];
	}

	if(strlen($_POST['pass_field_1']) > 30) {
		$alertArr[] = $ALERT['PASS_TOLONG'];
	}
	
	if($_POST['pass_field_1'] && strlen($_POST['pass_field_1']) < 6) {
		$alertArr[] = $ALERT['PASS_TOSHORT'];
	}

	if(!$_POST['email']) {
		$alertArr[] = $ALERT['EMAIL_NO'];
	}
	
	if(strlen($_POST['email']) > 140) {
		$alertArr[] = $ALERT['EMAIL_TOLONG'];
	}
	
	if($_POST['email'] && !emailValid($_POST['email'])) {
		$alertArr[] = $ALERT['EMAIL_INVALID'];
	}
	
	if($_POST['email'] && emailExist($_POST['email'])) {
		$alertArr[] = $ALERT['EMAIL_TAKEN'];
	}

	if(usernameTaken($_POST['user'])) {
		$alertArr[] = $ALERT['USER_TAKEN'];
	}

	// Captcha
	if (CAPTCHA) {
		if (empty($_POST['validator']) || $_POST['validator'] != $_SESSION['rand_code']) {
			$alertArr[] = $ALERT['CAPTCHA'];
		}
		unset($_SESSION['rand_code']);
	}

	if (count($alertArr) == 0) {
		// Add the new account to the database
		// (password has already been encrypted using javascript)
		$_SESSION['reguname'] = $_POST['user'];
		$_SESSION['regresult'] = addNewUser($_POST['user'], $_POST['pass1'], $_POST['email']);
		$_SESSION['registered'] = true;
		$refresh = $HTTP_SERVER_VARS[PHP_SELF];
		exit(include_once(HTML_PATH."html_refresh.php")); // stop script
	}
}

$alert = displayAlert($alertArr);

if ($_POST['pass_field_1']) $_POST['pass_field_1'] = "";
if ($_POST['pass_field_2']) $_POST['pass_field_2'] = "";

// html sign-up form
include_once(HTML_PATH."html_register_form.php");
?>