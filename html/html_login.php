<?php

// HTML code
// (replace (questionmark) with ?)
/*
<form name="login" action="" method="post" onsubmit="javascript:doLogin(this);">
	<table align="left" border="0" cellspacing="0" cellpadding="3">
	<tr>
		<td>Username:</td>
		<td><input type="text" name="user" value="<(questionmark)php printField('user'); (questionmark)>" maxlength="30"></td></tr>
	<tr>
		<td>Password:</td>
		<td><input type="password" name="pass_field"></td></tr>
	<tr>
	<tr>
		<td colspan="2" align="left">
			<input type="checkbox" name="remember">
			<font size="2">Remember me next time</font>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<input type="hidden" name="pass" value="" />
			<input type="hidden" name="salt" value="<(questionmark)php print $salt; (questionmark)>" />
			<input type="hidden" name="key" value="<(questionmark)php print $_SESSION['key']; (questionmark)>" />
			<input type="submit" name="subform" value="Login">
		</td>
	</tr>
<(questionmark) php
if (ALLOW_JOIN) {
(questionmark)>
	<tr>
		<td colspan="2" align="left"><a href="register.php">Join</a></td>
	</tr>
<(questionmark)php
}

if (ALLOW_RESET) {
(questionmark)>
	<tr>
		<td colspan="2" align="left"><a href="forgot.php">Forgot password</a></td>
	</tr>
<(questionmark)php
}
(questionmark)>
</table>
</form>
*/

?>
<html>
<head>
	<title>Login Page</title>
	<script type="text/javascript" src="sha1.js"></script>
	<script type="text/javascript" src="login.js"></script>
	<link rel="stylesheet" href="puls.css" type="text/css" />
</head>
<body>
<?php print $alert; ?>
<h1>Login</h1>
<script language="JavaScript" type="text/javascript">
<!--
// converted using http://accessify.com/tools-and-wizards/developer-tools/html-javascript-convertor/
function writeJS(){
var str='';
str+='<form name="login" action="" method="post" onsubmit="javascript:doLogin(this);">';
str+='	<table align="left" border="0" cellspacing="0" cellpadding="3">';
str+='		<tr>';
str+='			<td>Username:<\/td>';
str+='			<td><input type="text" name="user" value="<?php printField('user'); ?>" maxlength="30"><\/td><\/tr>';
str+='		<tr>';
str+='			<td>Password:<\/td>';
str+='			<td><input type="password" name="pass_field"><\/td><\/tr>';
str+='		<tr>';
str+='		<tr>';
str+='			<td colspan="2" align="left">';
str+='				<input type="checkbox" name="remember">';
str+='				<font size="2">Remember me next time<\/font>';
str+='			<\/td>';
str+='		<\/tr>';
str+='		<tr>';
str+='			<td colspan="2" align="right">';
str+='				<input type="hidden" name="pass" value="" \/>';
str+='				<input type="hidden" name="salt" value="<?php print $salt; ?>" \/>';
str+='				<input type="hidden" name="key" value="<?php print $_SESSION['key']; ?>" \/>';
str+='				<input type="submit" name="subform" value="Login">';
str+='			<\/td>';
str+='		<\/tr>';
<?php
if (ALLOW_JOIN) {
?>
str+='		<tr>';
str+='			<td colspan="2" align="left"><a href="register.php">Join<\/a><\/td>';
str+='		<\/tr>';
<?php
}

if (ALLOW_RESET) {
?>
str+='		<tr>';
str+='			<td colspan="2" align="left"><a href="forgot.php">Forgot password<\/a><\/td>';
str+='		<\/tr>';
<?php
}
?>
str+='	<\/table>';
str+='<\/form>';
document.write(str);
}
writeJS();
//-->
</script>
<noscript>You need Javascript to use this page.</noscript>
</body>
</html>