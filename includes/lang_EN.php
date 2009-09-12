<?php

// English laguage file
// Contains all text wich is not in the HTML files

$ALERT['PASS_NO'] = 'Please fill in a password.';
$ALERT['PASS_CURR_NO'] = 'Please fill in your current password.';
$ALERT['PASS_CURR_WRONG'] = 'Your current password is not correct.';
$ALERT['PASS_DIFF'] = 'Retyped password is different from first password.';
$ALERT['PASS_TOLONG'] = 'Sorry, the password is longer than 30 characters, please shorten it.';
$ALERT['PASS_TOSHORT'] = 'Sorry, the password is shorter than 6 characters, please lengthen it.';

$ALERT['USER_NO'] = 'Please fill in a username.';
$ALERT['USER_TOLONG'] = 'Sorry, the username is longer than 30 characters, please shorten it.';
$ALERT['USER_TOSHORT'] = 'Sorry, the username is shorter than 6 characters, please lengthen it.';
$ALERT['USER_TAKEN'] = 'Sorry, this username is already taken, please pick another one.';

$ALERT['EMAIL_NO'] = 'Please fill in an email address.';
$ALERT['EMAIL_TOLONG'] = 'Sorry, the email address is longer than 140 characters, please shorten it.';
$ALERT['EMAIL_INVALID'] = 'Sorry, this is not a valid email address.';
$ALERT['EMAIL_TAKEN'] = 'Sorry, this email address is already taken, please use another one.';
$ALERT['EMAIL_NOTEXIST'] = 'This is email address does not exist in our database.';
$ALERT['EMAIL_ALREADYSENT'] = 'An email containing directions on how to obtain a new password has already been sent to this email address.';
$ALERT['EMAIL_SENT_FORGOT'] = 'An email containing directions on how to obtain a new password has been sent to the specified email address.';
$ALERT['EMAIL_SENT_ERROR'] = 'An error occured. The email has not been sent.';

$ALERT['PAGE_UNAV'] = 'Sorry, this page is currently not available.';
$ALERT['ERROR'] = 'Sorry, can\'t do...';
$ALERT['CAPTCHA'] = 'You did not fill in the right Captcha code';

$MAILTEXT['FORGOT_SUBJECT'] = 'Password retrieval information';
$MAILTEXT['FORGOT_BODY'] = "Click this link to set a new password:\r\n"; // This string is enclosed in double-quotes, so you can use \r\n to start a new line.
$MAILTEXT['FORGOT_FOOTER'] = "Have a nice day.";

?>