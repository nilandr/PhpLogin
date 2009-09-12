// from http://www.dustindiaz.com/top-ten-javascript
function setCookie( name, value, expires, path, domain, secure ) {
	var today = new Date();
	today.setTime( today.getTime() );
	if ( expires ) {
		expires = expires * 1000 * 60 * 60 * 24;
	}
	var expires_date = new Date( today.getTime() + (expires) );
	document.cookie = name+'='+escape( value ) +
		( ( expires ) ? ';expires='+expires_date.toGMTString() : '' ) + //expires.toGMTString()
		( ( path ) ? ';path=' + path : '' ) +
		( ( domain ) ? ';domain=' + domain : '' ) +
		( ( secure ) ? ';secure' : '' );
}

function doLogin(form) {
	// first encrypt pass using salt
	form['pass'].value = hex_hmac_sha1(form['salt'].value, form['pass_field'].value);
	// clear field
	fake = '';
	for (i = 0; i < form['pass_field'].value.length; i++) {
		fake = fake + '-';
	}
	form['pass_field'].value = fake;
	// then set cookie
	if (form['remember'].checked) {
		setCookie('c_pass', form['pass'].value, 100, '/');
	}
	// then encrypt pass again using session key
	form['pass'].value = hex_hmac_sha1(form['key'].value, form['pass'].value);
	return true;
}

function doRegister(form) {
	// encrypt pass using salt
	
	if(form['pass_field_1'].value.length > 0) {
		form['pass1'].value = hex_hmac_sha1(form['salt'].value, form['pass_field_1'].value);
	}
	
	if(form['pass_field_2'].value.length > 0) {
		form['pass2'].value = hex_hmac_sha1(form['salt'].value, form['pass_field_2'].value);
	}
	
	// pass_field_curr does not allways exist
	// must be encrypted with key AND salt
	if(form['pass_field_curr'] && form['pass_field_curr'].value.length > 0) {
		form['passcurr'].value = hex_hmac_sha1(form['key'].value, hex_hmac_sha1(form['salt'].value, form['pass_field_curr'].value));
	}
	
	// clear field
	
	fake = '';
	for (i = 0; i < form['pass_field_1'].value.length; i++) {
		fake = fake + '-';
	}
	form['pass_field_1'].value = fake;
	
	fake = '';
	for (i = 0; i < form['pass_field_2'].value.length; i++) {
		fake = fake + '-';
	}
	form['pass_field_2'].value = fake;

	fake = '';
	// pass_field_curr does not allways exist
	if (form['pass_field_curr']) {
		for (i = 0; i < form['pass_field_curr'].value.length; i++) {
			fake = fake + '-';
		}
	}
	form['pass_field_curr'].value = fake;
	
	return true;
}