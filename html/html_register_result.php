<html>
<head>
	<title>Result Page</title>
	<link rel="stylesheet" href="puls.css" type="text/css" />
</head>
<body>
<?php

if($_SESSION['regresult']) {

?>
	<h1>Registered!</h1>
	<p>Thank you <b><?php echo $_SESSION['reguname']; ?></b>, your information has been added to the database, you may now <a href="index.php">log in</a>.</p>
<?php

} else {

?>
<h1>Registration Failed</h1>
	<p>
		We're sorry, but an error has occurred and your registration for the username <b><?php echo $_SESSION['reguname']; ?></b> could not be completed.<br />
		Please <a href="register.php">try again</a> at a later time.
	</p>
<?php

}

?>
</body>
</html>