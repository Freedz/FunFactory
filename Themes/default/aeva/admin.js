// Aeva Media
// © noisen.com / smf-media.com
// admin.js
//
// Users of this software are bound by the terms of the
// Aeva Media license. You can view it in the license_am.txt
// file, or online at http://noisen.com/license.php
//
// Support and updates for this software can be found at
// http://aeva.noisen.com and http://smf-media.com

function admin_prune_toggle(show, hide)
{
	document.getElementById(show+'_prune_opts').style.display = '';
	document.getElementById(hide+'_prune_opts').style.display = 'none';
}
function admin_toggle(id)
{
	if (document.getElementById('tr_expand_'+id).style.display == 'none')
	{
		document.getElementById('tr_expand_'+id).style.display = '';
		document.getElementById('toggle_img_'+id).src = smf_images_url+'/collapse.gif';
		document.getElementById('img_'+id).src = galurl+'sa=media;in='+id+';icon';
	}
	else
	{
		document.getElementById('tr_expand_'+id).style.display = 'none';
		document.getElementById('toggle_img_'+id).src = smf_images_url+'/expand.gif';
		document.getElementById('img_'+id).src = '';
	}
}
function admin_toggle_all()
{
	var all_tr = document.getElementsByTagName('tr');

	for (i = 0; i < all_tr.length; i++)
	{
		if (all_tr[i].id.substr(0, 9) != 'tr_expand')
			continue;
		var id = all_tr[i].id.substr(10);

		admin_toggle(id, document.getElementById('img_' + id) ? true : false);
	}
}
function doSubAction(url)
{
	getXMLDocument(url, doSubAction2);
}
function doSubAction2(XMLDoc)
{
	var ret = XMLDoc.getElementsByTagName('ret')[0].getElementsByTagName('succ')[0].firstChild.nodeValue;
	var id = XMLDoc.getElementsByTagName('ret')[0].getElementsByTagName('id')[0].firstChild.nodeValue;

	if (ret == 'true')
	{
		document.getElementById(id).style.display = 'none';
		if (document.getElementById('tr_expand_' + id))
			document.getElementById('tr_expand_' + id).style.display = 'none';
	}
}
function getPermAlbums(id_profile, args)
{
	sendXMLDocument(location.href + (typeof(args) != 'undefined' ? args : '') + ';sa=albums', 'prof=' + id_profile, getPermAlbum2);
}
function getPermAlbum2(XMLDoc)
{
	var id_profile = XMLDoc.getElementsByTagName('albums')[0].getElementsByTagName('id_profile')[0].firstChild.nodeValue;
	var albums = XMLDoc.getElementsByTagName('albums')[0].getElementsByTagName('album_string')[0].firstChild.nodeValue;
	document.getElementById('albums_td_' + id_profile).innerHTML = albums;
	document.getElementById('albums_' + id_profile).style.display = '';
	document.getElementById('albums_td_' + id_profile).style.display = '';
}
function permDelCheck(id, el, conf_text)
{
	if (!confirm(conf_text))
	{
		el.checked = '';
		return;
	}

	var opts = document.getElementsByName('del_prof')[0].getElementsByTagName('option');

	for (var i = 0; i < opts.length; i++)
		if (opts[i].value == id)
		{
			opts[i].style.display = el.checked ? 'none' : '';
			break;
		}
}
function aeva_prepareScriptUrl(sUrl)
{
	return sUrl.indexOf('?') == -1 ? sUrl + '?' : sUrl + (sUrl.charAt(sUrl.length - 1) == '?' || sUrl.charAt(sUrl.length - 1) == '&' || sUrl.charAt(sUrl.length - 1) == ';' ? '' : ';');
}
