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

include_once("includes/functions.php");
include_once("includes/config.php");

// Check if the ALLOW_RESET variable is set
if (!ALLOW_RESET) exit($ALERT['PAGE_UNAV']);

// Add new username, generated password string and email address to ".DB_PREFIX."forgot table
function addNewForgot($username, $password, $email){
	global $conn;
	/* Add slashes if necessary (for query) */
	if(!get_magic_quotes_gpc()) {
		$username = addslashes($username);
		$password = addslashes($password);
		$email = addslashes($email);
	}
	
	// add to database
	$q = "INSERT INTO ".DB_PREFIX."forgot VALUES ('$username', '$password', '$email', ".time().", '".$_SERVER['REMOTE_ADDR']."')";
	return mysql_query($q,$conn);
}

// Check if a forgot mail has already been sent to specified emial address
function forgotExist($email){
	global $conn;
	if(!get_magic_quotes_gpc()){
		$email = addslashes($email);
	}
	$q = "select * from ".DB_PREFIX."forgot where email = '$email' limit 1";
	$result = mysql_query($q,$conn);
	if (mysql_numrows($result) > 0) {
		return true;
	} else {
		return false;
	}
}

// Checks to see if the user has submitted his email address through the login form.
// If so, checks authenticity in database and sends email to user to recover password.
if(isset($_POST['subform'])){

	// clean up
	$_POST['email'] = cleanString($_POST['email'], 30);

	// check for errors
	$alertArr = array();
	$username = emailExist($_POST['email']);

	/* Check that all fields were typed in */
	if(!$_POST['email'])				$alertArr[] = $ALERT['EMAIL_NO'];
	if(!emailValid($_POST['email']))	$alertArr[] = $ALERT['EMAIL_INVALID'];
	if(!$username)						$alertArr[] = $ALERT['EMAIL_NOTEXIST'];
	if(forgotExist($_POST['email']))	$alertArr[] = $ALERT['EMAIL_ALREADYSENT'];

	if (count($alertArr) == 0) {

		// add new forgotten password and send email
		$password = sha1(randString().$username);

		// Email
		$from = EMAIL;
		$subject = $MAILTEXT['FORGOT_SUBJECT'];
		$body = $MAILTEXT['FORGOT_BODY'];
		$body .= LOGIN_URL."reset.php?p=".$password."\r\n\r\n";
		$body .= $MAILTEXT['FORGOT_FOOTER'];

		if (addNewForgot($username, $password, $email) && mail($_POST['email'],$subject,$body,'From: '.$from."\r\n")) {
			exit($ALERT['EMAIL_SENT_FORGOT']);
		} else {
			exit($ALERT['EMAIL_SENT_ERROR']);
		}
	}
}

$alert = displayAlert($alertArr);

// html
include_once(HTML_PATH."html_forgot.php");
?>