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
include_once("includes/check.php");

// Delete cookies
// (the time must be in the past)
if(isset($_COOKIE['c_name']) && isset($_COOKIE['c_pass'])){
   setcookie("c_name", "", time()-60*60*24*100, "/");
   setcookie("c_pass", "", time()-60*60*24*100, "/");
}

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (isset($_COOKIE[session_name()])) {
   setcookie(session_name(), '', time()-60*60*24*100, '/');
}

// Finally, destroy the session.
@session_destroy(); // @ to suppress errors

// html
include_once(HTML_PATH."html_logout.php");
?>