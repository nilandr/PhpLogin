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

if ('functions.php' == basename($_SERVER['SCRIPT_FILENAME']))
	exit("You cannot access this file directly");

// Checks whether or not the given username is in the database,
// if so it checks if the given password is the same password in the database for that user.
// If the user doesn't exist or if the passwords don't match up, it returns an error code (1 or 2). 
// On success it returns 0.
function confirmUser($username, $password){
	global $conn;
	/* Add slashes if necessary (for query) */
	if(!get_magic_quotes_gpc()) {
		$username = addslashes($username);
	}

	/* Verify that user is in database */
	$q = "select password from ".DB_PREFIX."users where username = '$username' limit 1";
	$result = mysql_query($q,$conn);
	if(!$result || (mysql_numrows($result) < 1)){
		return 1; // Indicates username failure
	}

	/* Retrieve password from result, strip slashes */
	$dbarray = mysql_fetch_array($result);
	// combine password in database with key
	$dbarray['password']  = hmac($_SESSION['key'], stripslashes($dbarray['password']));
	$password = stripslashes($password);

	/* Validate that password is correct */
	if($password == $dbarray['password']){
		return 0; // Success! Username and password confirmed
	}
	else{
		return 2; // Indicates password failure
	}
}



// prevent including php or html in a string
function cleanString($string, $length) {
	$string = filter_var($string, FILTER_SANITIZE_STRING); // PHP 5
	$string = trim($string);
	$string = stripslashes($string);
	$string = strip_tags($string);
	$string = substr($string, 0, $length);
	return $string;
}



// Calculate HMAC according to RFC2104
// http://www.ietf.org/rfc/rfc2104.txt
// From php.net by mina86 at tlen dot pl 19-Sep-2005 10:41
function hmac($key, $data, $hash = 'sha1', $blocksize = 64) {
	if (strlen($key)>$blocksize) {
		$key = pack('H*', $hash($key));
	}
	$key  = str_pad($key, $blocksize, chr(0));
	$ipad = str_repeat(chr(0x36), $blocksize);
	$opad = str_repeat(chr(0x5c), $blocksize);
	return $hash(($key^$opad) . pack('H*', $hash(($key^$ipad) . $data)));
}

function displayAlert($alertArr) {
	if (count($alertArr) > 0) {
		$string = '';
		foreach ($alertArr as $val) {
			$string .= $val."<br />\n";
		}
		return $string;
	} else {
		return false;
	}
}



// email validation
// (original: Chris Williams, cwilliams@aerospace.state.al.us, www.php.net)
/*function emailValid($email) {
	// Do the basic Reg Exp Matching for simple validation
	if (eregi("^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$", $email)) {

		// split the Email Up for Server validation
		list($Username, $Domain) = split("@",$email);

		// If you get an mx record then this is a valid email domain
		if(@getmxrr($Domain, $MXHost)) {
			return TRUE;
		} else {
			// else use the domain given to try and connect on port 25
			// if you can connect then it's a valid domain and that's good enough
			if(@fsockopen($Domain, 25, $errno, $errstr, 30)) {
				return TRUE; 
			} else {
				return FALSE; 
			}
		}
	} else {
		return FALSE;
	}
}*/
// Update: use PHP 5 filter function instead
function emailValid($email) {
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}


/* 
Author: Peter Mugane Kionga-Kamau
http://www.pmkmedia.com

Description: string str_makerand(int $minlength, int $maxlength, bool $useupper, bool $usespecial, bool $usenumbers) 
returns a randomly generated string of length between $minlength and $maxlength inclusively.

Notes: 
- If $useupper is true uppercase characters will be used; if false they will be excluded.
- If $usespecial is true special characters will be used; if false they will be excluded.
- If $usenumbers is true numerical characters will be used; if false they will be excluded.
- If $minlength is equal to $maxlength a string of length $maxlength will be returned.
- Not all special characters are included since they could cause parse errors with queries. 

Modify at will.

(original function name: str_makerand)
*/
function randString($minlength = 6, $maxlength = 30, $useupper = true, $usespecial = false, $usenumbers = true)
{
	$charset = "abcdefghijklmnopqrstuvwxyz";
	if ($useupper)   $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	if ($usenumbers) $charset .= "0123456789";
	if ($usespecial) $charset .= "~@#%^*()_+-=|][";   // Note: using all special characters this reads: "~!@#$%^&*()_+`-={}|\\]?[\":;'><,./";
	if ($minlength > $maxlength) $length = mt_rand ($maxlength, $minlength);
	else                         $length = mt_rand ($minlength, $maxlength);
	for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
	return $key;
}



// Returns corresponding username if the email address exists, false otherwise.
function emailExist($email){
	global $conn;
	if(!get_magic_quotes_gpc()){
		$email = addslashes($email);
	}
	$q = "select username from ".DB_PREFIX."users where email = '$email' limit 1";
	$result = mysql_query($q,$conn);
	if (mysql_numrows($result) > 0) {
		$dbarray = mysql_fetch_array($result);
		return $dbarray['username'];
	} else {
		return false;
	}
}



// Returns true if the username has been taken by another user, false otherwise.
function usernameTaken($username){
	global $conn;
	if(!get_magic_quotes_gpc()){
		$username = addslashes($username);
	}
	$q = "select username from ".DB_PREFIX."users where username = '$username' limit 1";
	$result = mysql_query($q,$conn);
	return (mysql_numrows($result) > 0);
}



// put already submitted data back in form
function printField($fieldname) {
	if ($_POST[$fieldname] && strlen($_POST[$fieldname]) > 0) {
		print $_POST[$fieldname];
	}
}

// NOTHING after ?>