<html>
<head>
	<title>Forgot login</title>
	<link rel="stylesheet" href="puls.css" type="text/css" />
</head>
<body>
	<?php print $alert; ?>
	<h1>Forgot login</h1>
	<form action="<? echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post">
	<table align="left" border="0" cellspacing="0" cellpadding="3">
		<tr><td>Email:</td><td><input type="text" name="email" value="<?php printField('email'); ?>" maxlength="30"></td></tr>
		<tr><td colspan="2" align="right"><input type="submit" name="subform" value="Submit"></td></tr>
	</table>
	</form>
</body>
</html>