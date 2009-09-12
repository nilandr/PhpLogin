<?php

// Original code from evolt.org by jpmaster77
// http://evolt.org/php_login_script_with_remember_me_feature

// ### check login start ###
session_start();
session_regenerate_id(true); // Generate new session id and delete old (PHP >= 5 only)
include_once("includes/check.php");
// ### check login end ###
?>

<html>
<title>Biep en Lu login test</title>
<body>

Logged in as <? print $_SESSION['username'] ?>, <a href="change.php">change settings</a> or <a href="logout.php">logout</a>.

</body>
</html>