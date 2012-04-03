// Aeva Media
// © noisen.com / smf-media.com
// am.js
//
// Users of this software are bound by the terms of the
// Aeva Media license. You can view it in the license_am.txt
// file, or online at http://noisen.com/license.php
//
// Support and updates for this software can be found at
// http://aeva.noisen.com and http://smf-media.com

if (typeof(is_chrome) == 'undefined')
{
	var ua = navigator.userAgent.toLowerCase();
	var is_chrome = ua.indexOf('chrome') != -1;
	var is_safari = ua.indexOf('applewebkit') != -1 && !is_chrome;
}
function selectText(box)
{
	box.focus();
	box.select();
}
function ajaxRating()
{
	var value = document.getElementById('rating').value;
	var url = document.getElementById('ratingForm').action + ';xml';
	document.getElementById('ratingElement').innerHTML = '<img src="' + (typeof(smf_default_theme_url) == "undefined" ? smf_theme_url : smf_default_theme_url) + '/images/aeva/loading.gif" border="0" alt="Loading" />';
	sendXMLDocument(url, 'rating=' + value, ajaxRating2);
}
function ajaxRating2(XMLDoc)
{
	var newElement = XMLDoc.getElementsByTagName('ratingObject')[0].firstChild.nodeValue;
	document.getElementById('ratingElement').innerHTML = newElement;
}
function aevaDelConfirm(txt)
{
	var sel = document.getElementById('modtype');
	return sel && sel.options[sel.selectedIndex].value == 'delete' ? confirm(txt) : true;
}
function aevaSwap(url, ie, io)
{
	toggle = typeof(toggle) == 'undefined' || !toggle ? 1 : 0;
	document.getElementById(typeof(ie) == 'undefined' ? 'quickReplyExpand' : ie).src = url + (toggle ? '/collapse.gif' : '/expand.gif');
	document.getElementById(typeof(io) == 'undefined' ? 'quickReplyOptions' : io).style.display = toggle ? 'block' : 'none';
	return false;
}