<?php

// HTML code
// (replace (questionmark) with ?)
/*
<form name="register" action="<(questionmark)php print $HTTP_SERVER_VARS['PHP_SELF']; (questionmark)>" method="post" onsubmit="javascript:doRegister(this);">
	<table align="left" border="0" cellspacing="0" cellpadding="3">
		<tr><td>Username:</td><td><(questionmark)php print $_SESSION['username']; (questionmark)></td></tr>
		<tr><td>Current password:</td><td><input type="password" name="pass_field_curr" maxlength="30"><input type="hidden" name="passcurr" value="" /></td></tr>
		<tr><td>Password:</td><td><input type="password" name="pass_field_1" maxlength="30"><input type="hidden" name="pass1" value="" /></td></tr>
		<tr><td>Retype password:</td><td><input type="password" name="pass_field_2" maxlength="30"><input type="hidden" name="pass2" value="" /></td></tr>
		<tr><td>Email:</td><td><input type="text" name="email" value="<(questionmark)php printField('email'); (questionmark)>" maxlength="140"></td></tr>
		<tr>
			<td colspan="2" align="right">
				<input type="hidden" name="salt" value="<(questionmark)php print $salt; (questionmark)>" />
				<input type="hidden" name="key" value="<(questionmark)php print $_SESSION['key']; (questionmark)>" />
				<input type="submit" name="subform" value="Submit">
			</td>
		</tr>
	</table>
</form>
*/
?>
<html>
<head>
	<title>Change settings page</title>
	<script type="text/javascript" src="sha1.js"></script>
	<script type="text/javascript" src="login.js"></script>
	<link rel="stylesheet" href="puls.css" type="text/css" />
</head>
<body>
	<?php print $alert; ?>
	<h1>Change settings</h1>
<script language="JavaScript" type="text/javascript">
<!--
// converted using http://accessify.com/tools-and-wizards/developer-tools/html-javascript-convertor/
function writeJS(){
var str='';
str+='	<form name="register" action="<?php print $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post" onsubmit="javascript:doRegister(this);">';
str+='		<table align="left" border="0" cellspacing="0" cellpadding="3">';
str+='			<tr><td>Username:<\/td><td><?php print $_SESSION['username']; ?><\/td><\/tr>';
str+='			<tr><td>Current password:<\/td><td><input type="password" name="pass_field_curr" maxlength="30"><input type="hidden" name="passcurr" value="" \/><\/td><\/tr>';
str+='			<tr><td>Password:<\/td><td><input type="password" name="pass_field_1" maxlength="30"><input type="hidden" name="pass1" value="" \/><\/td><\/tr>';
str+='			<tr><td>Retype password:<\/td><td><input type="password" name="pass_field_2" maxlength="30"><input type="hidden" name="pass2" value="" \/><\/td><\/tr>';
str+='			<tr><td>Email:<\/td><td><input type="text" name="email" value="<?php printField('email'); ?>" maxlength="140"><\/td><\/tr>';
str+='			<tr>';
str+='				<td colspan="2" align="right">';
str+='					<input type="hidden" name="salt" value="<?php print $salt; ?>" \/>';
str+='					<input type="hidden" name="key" value="<?php print $_SESSION['key']; ?>" \/>';
str+='					<input type="submit" name="subform" value="Submit">';
str+='				<\/td>';
str+='			<\/tr>';
str+='		<\/table>';
str+='	<\/form>';
document.write(str);
}
writeJS();
//-->
</script>
<noscript>You need Javascript to use this page.</noscript>
</body>
</html>