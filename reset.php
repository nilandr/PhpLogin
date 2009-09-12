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

*/

session_start();
session_regenerate_id(true); // Generate new session id and delete old (PHP >= 5 only)

include_once("includes/functions.php");
include_once("includes/config.php");

// Check if the ALLOW_RESET variable is set
if (!ALLOW_RESET) exit($ALERT['PAGE_UNAV']);

// set session variable because $_GET['p'] will be gone when form is posted
if (!$_SESSION['forgot']) $_SESSION['forgot'] = $_GET['p'];

// check if p is in ".DB_PREFIX."forgot table
if(!get_magic_quotes_gpc()) $_SESSION['forgot'] = addslashes($_SESSION['forgot']);
$q = "select username from ".DB_PREFIX."forgot where password = '".$_SESSION['forgot']."' limit 1";
$result = mysql_query($q,$conn);
if(!$result || (mysql_numrows($result) < 1)){
	exit($ALERT['ERROR']); // p is not in ".DB_PREFIX."forgot table
} else {
	$dbarray = mysql_fetch_array($result);
	$_SESSION['username'] = $dbarray['username'];
}

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

	$q = "UPDATE ".DB_PREFIX."users SET password = '$password', ";
	$q .= "ip = '".$_SERVER['REMOTE_ADDR']."', lastdate = ".time()." WHERE username = '".$_SESSION['username']."'";
	$result = mysql_query($q,$conn);
	return $result;
}



// Display registration result page,
// and clean up the ".DB_PREFIX."forgot table.
if(isset($_SESSION['registered'])){

	// html
	include_once(HTML_PATH."html_reset_result.php");
	
	if($_SESSION['regresult']) {
		// clean up ".DB_PREFIX."forgot table
		$q = "DELETE FROM ".DB_PREFIX."forgot WHERE password = '".$_SESSION['forgot']."' LIMIT 1";
		mysql_query($q,$conn);			
	}
	unset($_SESSION['reguname']);
	unset($_SESSION['registered']);
	unset($_SESSION['regresult']);
	unset($_SESSION['forgot']);
	unset($_SESSION['username']);
	return;
}



// If the reset form has been submitted: check for errors.
// No errors (count($alertArr) == 0)? Submit changes to database.
// Errors? Display error messages and show form again.
if(isset($_POST['subform'])){

	// clean up
	if ($_POST['pass_field_1'])		$_POST['pass_field_1'] = cleanString($_POST['pass_field_1'], 30);
	if ($_POST['pass_field_2'])		$_POST['pass_field_2'] = cleanString($_POST['pass_field_2'], 30);
	if ($_POST['pass1'])			$_POST['pass1'] = cleanString($_POST['pass1'], 40);
	if ($_POST['pass2'])			$_POST['pass2'] = cleanString($_POST['pass2'], 40);
	if ($_POST['salt'])				$_POST['salt'] = '';
	if ($_POST['key'])				$_POST['key'] = '';

	// check for errors
	$alertArr = array();

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

	if (count($alertArr) == 0) {
		// Add the new account to the database
		// (password has already been encrypted using javascript)
		$_SESSION['registered'] = true;
		$_SESSION['reguname'] = $_SESSION['username'];
		$_SESSION['regresult'] = addNewUser($_SESSION['username'], $_POST['pass1'], $_POST['email']);
		$refresh = $HTTP_SERVER_VARS[PHP_SELF];
		exit(include_once(HTML_PATH."html_refresh.php")); // stop script
	}
}

$alert = displayAlert($alertArr);

if ($_POST['pass_field_1']) $_POST['pass_field_1'] = "";
if ($_POST['pass_field_2']) $_POST['pass_field_2'] = "";

// html reset form
include_once(HTML_PATH."html_reset_form.php");
?>