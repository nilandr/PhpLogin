<html>
<head>
	<title>Result Page</title>
	<link rel="stylesheet" href="puls.css" type="text/css" />
</head>
<body>
<?php

if($_SESSION['regresult']) {

?>
	<h1>Settings changed</h1>
	<p>Thank you <b><? echo $_SESSION['username']; ?></b>, your settings have been changed.<br />
	You may now <a href="index.php">return</a>.</p>
<?php

} else {

?>
	<h1>Settings change failed</h1>
	<p>
		We're sorry, but an error has occurred and your settings for the username <b><? echo $_SESSION['username']; ?></b> have not been changed.<br />
		Your settings remain unchanged. Please try again at a later time.<br />
		You may now <a href="index.php">return</a>.
	</p>
<?php

}

?>
</body>
</html>