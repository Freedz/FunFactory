// nneonneo's AJAX shoutbox
// Version 1.22
shoutFile=escape(shoutFile);

var guest;

function $(el) {
	if (typeof el == 'string') el = document.getElementById(el);
	return el;
};

// Set off the AJAX call to load the chat form into the empty yShout div
function loadChat() {
	if ($("yshout").style.display=="none") return;
	if(checkDuplicates)
	{
		if(get_cookie("yShout_open"))
		{
			$("yshout").innerHTML="Shoutbox loaded in another window. Retrying...";
			setTimeout("loadChat()",Math.random()*1000+1000/*between 1 and 2 seconds*/);
			return;
		}
	}
	// onbeforeunload is IE specific, and is used because onunload doesn't fire immediately
	window.onbeforeunload = window.onunload = unloadChat;
	if ($("yshout")) {
		new ajax (yshout_php, { 
			postBody: 'reqtype=init&file=' + shoutFile,
			update: $('yshout'),
			onComplete: loadDone
		});
	}
	set_cookie("yShout_open","true",duplicateWait);
}

function unloadChat() {
	delete_cookie("yShout_open");
	request.abort();
}

// Re-apply Behaviour after the chat loads
function loadDone() {
	setTimeout("setupChat()", 5);
}

function setupChat() {
	if(!$("forum-name")) // do NOT refresh if the form didn't show up.
		return;
	startRefresh();
	if($("forum-name").disabled) guest=false;
	else guest=true;
}

function complex_escape(text) {
	if(window.textToEntities == undefined) {
		return text.replace(/&#/g, "&#38;#").php_to8bit().php_urlencode();
	} else {
		return escape(textToEntities(text.replace(/&#/g, "&#38;#"))).replace(/\+/g, "%2B");
	}
}

// Send the message
function doSend() {
	userdata='';
	if (guest) {
		username=complex_escape($("forum-name").value);
		if(username=='')
		{
			alert("Please enter a username.");
			return;
		}
		userdata='&username='+username;
		set_cookie("username",username,2*365*24*3600);
	}
	if (formValidate() && $("shout-text").value) {
		var toShout = complex_escape($("shout-text").value);
		floodControl();
		new ajax (yshout_php, {
			postBody: 'reqtype=shout&shout=' + toShout + '&file=' + shoutFile + userdata,
			update: $('shouts'),
			onComplete: shoutDone
		});
	}
}

function autoShout(theText) {
	new ajax (yshout_php, { 
			postBody: 'reqtype=autoshout&shout=' + theText + '&file=' + shoutFile,
			update: $('shouts'),
			onComplete: shoutDone
		});
}

function ajaxGet(args) {
	new ajax (yshout_php+'&file='+shoutFile+'&'+args, { 
			update: $('shouts'),
			onComplete: shoutDone
		});
}

function getURL(args) {
	return yshout_php+'&file='+shoutFile+'&'+args;
}

function goTo(args) {
	if(request) request.abort();
	document.location=getURL(args);
}

// Start refreshing the chat after a message has been sent
function shoutDone() {
	startRefresh();
}

var refreshSet = false;

function startRefresh() {
	if (!refreshSet) {
		refreshSet = true;
		schedRefresh();
	}
}

function schedRefresh() {
	if (refreshSet) {
		setTimeout("doRefresh()", refreshTime);
	}
}

// Validate the form to ensure that the fields are filled
function formValidate() {
	var shoutText = $("shout-text").value;

	var textValid = true;

	if (shoutText == "")
		textValid = false;

	if (!textValid) {
		$("shout-text").className="shout-invalid";
		$("shout-text").focus();
		return false;
	} else {
		$("shout-text").className="shout-valid-shout";
	}

	return true;
}

var request;
// This gets called each refresh; it reloads the shoutbox content.
function doRefresh() {
	if($("yshout").style.display == "none") {refreshSet = false; return;};
	set_cookie("yShout_open","true",duplicateWait);
	request=new ajax (yshout_php, { 
		postBody: 'reqtype=refresh&file=' + shoutFile,
		update: $('shouts'),
		onComplete: schedRefresh
	});
}

function floodControl() {
	$("shout-text").disabled = true;
	$("shout-button").disabled = true;
	$("shout-text").value = "";
	setTimeout("enableShout()", floodTime);
}

function enableShout() {
	$("shout-text").value = "";
	$("shout-text").disabled = false;
	$("shout-button").disabled = false;
	$("shout-text").focus();
}

function set_cookie( name, value, expires, path, domain, secure ) 
{
	// set time, it's in milliseconds
	var today = new Date();
	today.setTime( today.getTime() );
	
	/*
	if the expires variable is set, make the correct 
	expires time, the current script below will set 
	it for x number of days, to make it for hours, 
	delete * 24, for minutes, delete * 60 * 24
	*/
	if ( expires )
	{
		expires = expires * 1000;
	}
	var expires_date = new Date( today.getTime() + (expires) );
	
	document.cookie = name + "=" +escape( value ) +
	( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
	( ( path ) ? ";path=" + path : "" ) + 
	( ( domain ) ? ";domain=" + domain : "" ) +
	( ( secure ) ? ";secure" : "" );
}

// this function gets the cookie, if it exists
function get_cookie( name ) {
	var start = document.cookie.indexOf( name + "=" );
	var len = start + name.length + 1;
	if ( ( !start ) &&
	( name != document.cookie.substring( 0, name.length ) ) )
	{
	return null;
	}
	if ( start == -1 ) return null;
	var end = document.cookie.indexOf( ";", len );
	if ( end == -1 ) end = document.cookie.length;
	return unescape( document.cookie.substring( len, end ) );
}

function delete_cookie ( cookie_name )
{
	var cookie_date = new Date ( );  // current date & time
	cookie_date.setTime ( cookie_date.getTime() - 1 );
	document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}
