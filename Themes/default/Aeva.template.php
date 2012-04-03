<?php
/****************************************************************
* Aeva Media													*
* © Noisen.com & SMF-Media.com									*
*****************************************************************
* Aeva.template.php												*
*****************************************************************
* Users of this software are bound by the terms of the			*
* Aeva Media license. You can view it in the license_am.txt		*
* file, or online at http://noisen.com/license.php				*
*																*
* Support and updates for this software can be found at			*
* http://aeva.noisen.com and http://smf-media.com				*
****************************************************************/

function template_aeva_above()
{
	global $context, $txt, $amSettings, $scripturl, $settings, $shown_linktree;

	// SMF 2.0 (Apr '09 revs) shows linktrees automatically
	if (empty($shown_linktree) && !isset($_REQUEST['noh']))
		theme_linktree();

	// Show Aeva Media tabs, except if not inside the gallery itself or if uploading via a popup
	if (empty($context['current_board']) && !isset($_REQUEST['noh']))
	{
		echo '
	<div class="titlebg aeva_header aeva_rounded">
		<h3>', !isset($context['aeva_header']['data']['title']) ? $txt['aeva_title'] : $context['aeva_header']['data']['title'], '</h3>
		<ul class="smalltext" id="aeva_tabs">';

		if (isset($context['aeva_header']['tabs']))
			foreach ($context['aeva_header']['tabs'] as $tab)
				echo '
			<li', $tab['active'] ? ' class="selected"' : '', '>', !empty($tab['icon']) ? '<img src="' . $settings['images_aeva'] . '/' . $tab['icon'] . '" alt="" style="vertical-align: text-bottom" />&nbsp;' : '', '<a href="', $tab['url'], '">', $tab['title'], '</a></li>';

		echo '
		</ul>
	</div>';
	}

	// Any unapproved stuff?
	if (aeva_allowedTo('moderate') && (!empty($amSettings['num_unapproved_items']) || !empty($amSettings['num_unapproved_comments']) || !empty($amSettings['num_unapproved_albums'])))
	{
		echo '
	<div class="unapproved_notice">';
		if (!empty($amSettings['num_unapproved_items']))
			printf($txt['aeva_unapproved_items_notice'] . '<br />', $scripturl.'?action=media;area=moderate;sa=submissions;filter=items;'.$context['session_var'].'='.$context['session_id'], $amSettings['num_unapproved_items']);
		if (!empty($amSettings['num_unapproved_comments']))
			printf($txt['aeva_unapproved_coms_notice'] . '<br />', $scripturl.'?action=media;area=moderate;sa=submissions;filter=coms;'.$context['session_var'].'='.$context['session_id'], $amSettings['num_unapproved_comments']);
		if (!empty($amSettings['num_unapproved_albums']))
			printf($txt['aeva_unapproved_albums_notice'], $scripturl.'?action=media;area=moderate;sa=submissions;filter=albums;'.$context['session_var'].'='.$context['session_id'], $amSettings['num_unapproved_albums']);
		echo '</div>';
	}

	// Any reported stuff?
	if (aeva_allowedTo('moderate') && (!empty($amSettings['num_reported_items']) || !empty($amSettings['num_reported_comments'])))
	{
		echo '
	<div class="unapproved_notice">';
		if (!empty($amSettings['num_reported_items']))
			printf($txt['aeva_reported_items_notice'] . '<br />', $scripturl.'?action=media;area=moderate;sa=reports;items;'.$context['session_var'].'='.$context['session_id'], $amSettings['num_reported_items']);
		if (!empty($amSettings['num_reported_comments']))
			printf($txt['aeva_reported_comments_notice'] . '<br />', $scripturl.'?action=media;area=moderate;sa=reports;comments;'.$context['session_var'].'='.$context['session_id'], $amSettings['num_reported_comments']);
		echo '</div>';
	}

	// Any further data to show?
	if (!empty($context['aeva_header']['data']['description']))
	{
		if ($context['is_smf2'])
			echo '
	<div class="cat_bar cat_heading">
		<h3 class="catbg">
			', !isset($context['aeva_header']['data']['title']) ? $txt['aeva_title'] : $context['aeva_header']['data']['title'], '
		</h3>
	</div>
	<p class="windowbg description">
		', $context['aeva_header']['data']['description'], '
	</p>';
		else
			echo '
	<div class="subheader">
		<h4 class="catbg" style="margin: 0">', !isset($context['aeva_header']['data']['title']) ? $txt['aeva_title'] : $context['aeva_header']['data']['title'], '</h4>
		<p class="windowbg smalltext">', $context['aeva_header']['data']['description'], '</p>
	</div>';
	}

	template_aeva_show_subtabs();
}

function template_aeva_admin_above()
{
	template_aeva_show_subtabs();
}

function template_aeva_admin_below()
{
}

function template_aeva_admin_enclose_table_above()
{
	echo '
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td>';
}

function template_aeva_admin_enclose_table_below()
{
	echo '
				</td>
			</tr>
		</table>';
}

function template_aeva_show_subtabs()
{
	global $context;

	// area-tabs maybe?
	if (!empty($context['aeva_header']['areatabs']))
	{
		$buttons = array();
		foreach ($context['aeva_header']['areatabs'] as $tab)
			$buttons[] = array(
				'text' => $tab['title'],
				'url' => $tab['url'],
				'custom' => $tab['active'] ? ' class="currentbutton"' : '',
			);
		aeva_button_strip($buttons, 'top');
	}

	// sub-tabs maybe?
	if (!empty($context['aeva_header']['subtabs']))
	{
		$buttons = array();
		foreach ($context['aeva_header']['subtabs'] as $tab)
			$buttons[] = array(
				'text' => $tab['title'],
				'url' => $tab['url'],
				'custom' => $tab['active'] ? ' class="currentbutton"' : '',
			);
		aeva_button_strip($buttons);
	}
}

function aeva_button_strip(&$buttons, $direction = 'bottom', $a_la_smf2 = false)
{
	global $context, $settings;

	if ($context['is_smf2'] && $a_la_smf2 && substr($settings['theme_url'], -8) == '/default')
		echo '
		<div class="buttonlist align_right" style="overflow: auto">', template_button_strip($buttons, $direction), '
		</div>';
	elseif ($context['is_smf2'])
		echo '
		<div style="margin-left: 10px; overflow: auto">', template_button_strip($buttons, $direction), '
		</div>';
	else
		echo '
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>', template_button_strip($buttons, $direction), '</tr>
		</table>';
}

function template_aeva_home()
{
	global $context, $amSettings, $txt, $galurl, $scripturl, $settings;

	$has_albums = count($context['aeva_albums']) > 0;
	$can_rss = $context['aeva_foxy'] && function_exists('aeva_foxy_rss');

	// The Albums!
	echo '
<div id="home">', !empty($context['aeva_welcome']) ? '
	<div id="aeva_welcome">' . $context['aeva_welcome'] . '</div>' : '', '
	<div id="aeva_toplinks" class="cat_bar">
		<h3 class="catbg">
			<img src="'.$settings['images_aeva'].'/house.png" alt="" style="vertical-align: -3px" /> <b>'.$txt['aeva_home'].'</b>', $context['show_albums_link'] ? ' -
			<img src="'.$settings['images_aeva'].'/album.png" alt="" style="vertical-align: -3px" /> <b><a href="'.$galurl.'sa=vua">'.$txt['aeva_albums'].'</a></b>' : '', $context['aeva_foxy'] ? ' -
			<img src="'.$settings['images_aeva'].'/playlist.png" alt="" style="vertical-align: -3px" /> <b><a href="'.$galurl.'sa=playlists">'.$txt['aeva_playlists'].'</a></b>' : '', '
		</h3>
	</div>';

	$context['aeva_windowbg'] = '';
	if ($has_albums)
		aeva_listChildren($context['aeva_albums']);

	echo "\n";

	// OK Now side stuff
	// Recent items?
	if (!empty($context['recent_items']))
	{
		echo '
	<div class="cat_bar cat_heading">
		<h3 class="catbg">
			', $txt['aeva_recent_items'], $can_rss ?
			' <a href="'.$galurl.'sa=rss"><img src="'.$settings['images_aeva'].'/rss.png" alt="RSS" class="aeva_vera" /></a>' : '', '
		</h3>
	</div>';

		$view = isset($_REQUEST['fw']) ? 'file' : 'normal';
		// Page index and sorting things
		$sort_list = array('m.id_media' => 0, 'm.time_added' => 1, 'm.title' => 2, 'm.views' => 3, 'm.weighted' => 4);
		echo '
	<div class="titlebg sort_options">
		<div class="view_options">
			', $txt['aeva_items_view'], ': ', $view == 'normal' ? '<b>' . $txt['aeva_view_normal'] . '</b> <a href="' . $galurl . 'fw;'. $context['aeva_urlmore'] . '">' . $txt['aeva_view_filestack'] . '</a>' : '<a href="' . $galurl . $context['aeva_urlmore'] . '">' . $txt['aeva_view_normal'] . '</a> <b>' . $txt['aeva_view_filestack'] . '</b>', '
		</div>
		', $txt['aeva_sort_by'], ':';
		$sort = empty($sort_list[$context['aeva_sort']]) ? 0 : $sort_list[$context['aeva_sort']];
		for ($i = 0; $i < 5; $i++)
			echo $sort == $i ? ' <b>' . $txt['aeva_sort_by_'.$i] . '</b>' :
		' <a href="'.$galurl.'sort=' . $i . ($view == 'normal' ? '' : ';fw') . '">' . $txt['aeva_sort_by_'.$i] . '</a>';
		echo '
		| ', $txt['aeva_sort_order'], ':',
		($context['aeva_asc'] ? ' <b>' . $txt['aeva_sort_order_asc'] . '</b>' : ' <a href="' . $galurl . (isset($_REQUEST['sort']) ? 'sort='.$_REQUEST['sort'].';' : '') . 'asc' . ($view == 'normal' ? '' : ';fw') . '">' . $txt['aeva_sort_order_asc'] . '</a>'),
		(!$context['aeva_asc'] ? ' <b>' . $txt['aeva_sort_order_desc'] . '</b>' : ' <a href="' . $galurl . (isset($_REQUEST['sort']) ? 'sort=' . $_REQUEST['sort'].';' : '') . 'desc' . ($view == 'normal' ? '' : ';fw') . '">'.$txt['aeva_sort_order_desc'].'</a>'), '
	</div>
	<div id="recent_pics">',
		$view == 'normal' ? aeva_listItems($context['recent_items']) : aeva_listFiles($context['recent_items']), '
	</div>
	<div class="pagelinks">
		', $txt['aeva_pages'], ': ', $context['aeva_page_index'], '
	</div>';
	}

	// Random items?
	if (!empty($context['random_items']))
	{
		echo '
	<div class="cat_bar cat_heading">
		<h3 class="catbg">', $txt['aeva_random_items'], '</h3>
	</div>
	<div id="random_pics">',
		$view == 'normal' ? aeva_listItems($context['random_items']) : aeva_listFiles($context['random_items']), '
	</div>';
	}

	// Recent comments!
	if (!empty($context['recent_comments']))
	{
		echo '
	<div', !empty($context['recent_albums']) ? ' class="recent_comments"' : '', '>
		<div class="cat_bar cat_heading">
			<h3 class="catbg">
				', $txt['aeva_recent_comments'], $can_rss ?
				' <a href="'.$galurl.'sa=rss;type=comments"><img src="'.$settings['images_aeva'].'/rss.png" alt="RSS" class="aeva_vera" /></a>' : '', '
			</h3>
		</div>
		<div class="windowbg smalltext">
			<span class="topslice"><span></span></span>
			<div style="padding: 0 8px; line-height: 1.4em">';

		foreach ($context['recent_comments'] as $i)
			echo '
				<div>', $txt['aeva_comment_in'], ' <a href="', $i['url'], '">', $i['media_title'], '</a> ', $txt['aeva_by'],
				' ', $i['member_link'], ' ', is_numeric($i['posted_on'][0]) ? $txt['aeva_on_date'] . ' ' : '', $i['posted_on'], '</div>';

		echo '
			</div>
			<span class="botslice"><span></span></span>
		</div>
	</div>';
	}

	// Recent albums!
	if (!empty($context['recent_albums']))
	{
		echo '
	<div', !empty($context['recent_comments']) ? ' class="recent_albums"' : '', '>
		<div class="cat_bar cat_heading">
			<h3 class="catbg">', $txt['aeva_recent_albums'], '</h3>
		</div>
		<div class="windowbg smalltext">
			<span class="topslice"><span></span></span>
			<div style="padding: 0 8px; line-height: 1.4em">';

		foreach ($context['recent_albums'] as $i)
			echo '
				<div><a href="', $scripturl, '?action=media;sa=album;in=', $i['id'], '">', $i['name'], '</a> (',
		$i['num_items'], ')', !empty($i['owner_id']) ? ' ' . $txt['aeva_by'] . ' <a href="' . $scripturl . '?action=profile;u=' . $i['owner_id'] . ($context['is_smf2'] ? ';area' : ';sa') . '=aeva">' . $i['owner_name'] . '</a>' : '', '</div>';

		echo '
			</div>
			<span class="botslice"><span></span></span>
		</div>
	</div>';
	}

	// Fix
	if (!empty($context['recent_comments']) && !empty($context['recent_albums']))
		echo '<br style="clear: both" />';

	// Show some general stats'n'stuff below
	echo '
	<div class="cat_bar cat_heading">
		<h3 class="catbg">
			<img alt="" src="', $settings['images_aeva'], '/chart_bar.png" class="vam" />&nbsp;<a href="', $galurl, 'sa=stats">', $txt['aeva_stats'], '</a>
		</h3>
	</div>
	<div class="windowbg smalltext">
		<span class="topslice"><span></span></span>
		<div style="padding: 0 8px; line-height: 1.4em">
			<table cellpadding="0" cellspacing="0" width="100%"><tr><td>
			<div>', $txt['aeva_total_items'], ': ', $amSettings['total_items'], '</div>
			<div>', $txt['aeva_total_albums'], ': ', $amSettings['total_albums'], '</div>
			<div>', $txt['aeva_total_comments'], ': ', $amSettings['total_comments'], '</div>', aeva_allowedTo('manage') ? '
			' . show_stat($txt['aeva_reported_items'], $amSettings['num_reported_items']) : '', '
			</td>';

	if (aeva_allowedTo('moderate'))
	{
		echo '
			<td style="text-align: right">
			', show_stat($txt['aeva_unapproved_items'], $amSettings['num_unapproved_items']), '
			', show_stat($txt['aeva_unapproved_albums'], $amSettings['num_unapproved_albums']), '
			', show_stat($txt['aeva_unapproved_comments'], $amSettings['num_unapproved_comments']), aeva_allowedTo('manage') ? '
			' . show_stat($txt['aeva_reported_comments'], $amSettings['num_reported_comments']) : '', '
			</td>';
	}
	echo '</tr></table>
		</div>
		<span class="botslice"><span></span></span>
	</div>
</div>';
}

function show_stat($intro, $number)
{
	return '<div>' . ($number > 0 ? '<b>' : '') . $intro . ': ' . $number . ($number > 0 ? '</b>' : '') . '</div>';
}

function show_prevnext($id, $url)
{
	global $galurl;

	echo '<div class="aea" style="width: ', $url[1], 'px; height: ', $url[2], 'px; background: url(', $url[0], ') 0 0">',
			$id ? '<a href="' . $galurl . 'sa=item;in=' . $id . '">&nbsp;</a></div>' : '&nbsp;</div>';
}

function template_aeva_viewItem()
{
	global $galurl, $context, $amSettings, $txt, $scripturl, $settings, $boardurl, $user_info, $amFunc;

	$item = $context['item_data'];

	if (isset($_REQUEST['noh']) && $context['aeva_foxy'])
		aeva_foxy_add_smg_tag();

	// Show the item and info boxes
	echo '
	<div id="viewitem">';

	if (empty($amSettings['prev_next'])) // 3 items
		echo '
		<table cellspacing="0" cellpadding="2" border="0" class="mg_prevnext windowbg" width="100%">
			<tr class="mg_prevnext_pad">
				<td rowspan="2">', (int) $item['prev'] > 0 ? '<a href="'.$galurl.'sa=item;in='.$item['prev'].'">&laquo;</a>' : '&laquo;', '</td>
				<td width="33%">', (int) $item['prev'] > 0 ? show_prevnext($item['prev'], $item['prev_thumb']) : $txt['aeva_prev'], '</td>
				<td width="34%" class="windowbg2">', show_prevnext(0, $item['current_thumb']), '</td>
				<td width="33%">', (int) $item['next'] > 0 ? show_prevnext($item['next'], $item['next_thumb']) : $txt['aeva_next'], '</td>
				<td rowspan="2">', (int) $item['next'] > 0 ? '<a href="'.$galurl.'sa=item;in='.$item['next'].'">&raquo;</a>' : '&raquo;', '</td>
			</tr>
			<tr class="smalltext">
				<td>', (int) $item['prev'] > 0 ? '<a href="'.$galurl.'sa=item;in='.$item['prev'].'">'.$item['prev_title'].'</a>' : '', '</td>
				<td class="windowbg2">'.$item['current_title'].'</td>
				<td>', (int) $item['next'] > 0 ? '<a href="'.$galurl.'sa=item;in='.$item['next'].'">'.$item['next_title'].'</a>' : '', '</td>
			</tr>
		</table>';
	elseif ($amSettings['prev_next'] == 1) // 5 items
		echo '
		<table cellspacing="0" cellpadding="3" border="0" class="mg_prevnext windowbg" width="100%">
			<tr class="mg_prevnext_pad">
				<td rowspan="2">', (int) $item['prev_page'] > 0 ? '<a href="'.$galurl.'sa=item;in='.$item['prev_page'].'">&laquo;</a>' : '&laquo;', '</td>
				<td width="20%">', (int) $item['prev2'] > 0 ? show_prevnext($item['prev2'], $item['prev2_thumb']) : '', '</td>
				<td width="20%">', (int) $item['prev'] > 0 ? show_prevnext($item['prev'], $item['prev_thumb']) : '', '</td>
				<td width="20%" class="windowbg2">', show_prevnext(0, $item['current_thumb']), '</td>
				<td width="20%">', (int) $item['next'] > 0 ? show_prevnext($item['next'], $item['next_thumb']) : '', '</td>
				<td width="20%">', (int) $item['next2'] > 0 ? show_prevnext($item['next2'], $item['next2_thumb']) : '', '</td>
				<td rowspan="2">', (int) $item['next_page'] > 0 ? '<a href="'.$galurl.'sa=item;in='.$item['next_page'].'">&raquo;</a>' : '&raquo;', '</td>
			</tr>
			<tr class="smalltext">
				<td>', (int) $item['prev2'] > 0 ? '<a href="'.$galurl.'sa=item;in='.$item['prev2'].'">'.$item['prev2_title'].'</a>' : '', '</td>
				<td>', (int) $item['prev'] > 0 ? '<a href="'.$galurl.'sa=item;in='.$item['prev'].'">'.$item['prev_title'].'</a>' : '', '</td>
				<td class="windowbg2">'.$item['current_title'].'</td>
				<td>', (int) $item['next'] > 0 ? '<a href="'.$galurl.'sa=item;in='.$item['next'].'">'.$item['next_title'].'</a>' : '', '</td>
				<td>', (int) $item['next2'] > 0 ? '<a href="'.$galurl.'sa=item;in='.$item['next2'].'">'.$item['next2_title'].'</a>' : '', '</td>
			</tr>
		</table>';
	elseif ($amSettings['prev_next'] == 2) // Text links
		echo '
		<div class="mg_prev">', (int) $item['prev'] > 0 ? '&laquo; <a href="'.$galurl.'sa=item;in='.$item['prev'].'">'.$txt['aeva_prev'].'</a>' : '&laquo; '.$txt['aeva_prev'], '</div>
		<div class="mg_next">', (int) $item['next'] > 0 ? '<a href="'.$galurl.'sa=item;in='.$item['next'].'">'.$txt['aeva_next'].'</a> &raquo;' : $txt['aeva_next'].' &raquo;', '</div>';
	else // Browsing disabled
		echo '
		<br />';

	echo '
		<div class="tborder">
			<div class="titlebg info mg_title"><strong>', $item['title'], '</strong></div>
		</div>';

	$desc_len = strlen($item['description']);
	echo '
		<div id="itembox">', $item['embed_object'], $item['is_resized'] ? '
			<div class="mg_subtext" style="padding-top: 6px">' . $txt['aeva_resized'] . '</div>' : '', '
		</div>', !empty($item['description']) ? '
		<div class="mg_item_desc" style="margin: auto; text-align: ' . ($desc_len > 200 ? 'justify' : 'center') . '; width: ' . ($desc_len > 800 ? '90%' : max($item['preview_width'], 400) . 'px') . '">' . $item['description'] . '</div>
		<br />' : '', $context['is_smf2'] ? '

		<div class="clear"></div>' : '<br style="clear: both" />';

	if ($context['aeva_size_mismatch'])
		echo '
		<div class="unapproved_yet">', $txt['aeva_size_mismatch'], '</div>';

	if (!$item['approved'] && ($item['member']['id'] == $user_info['id']) && !aeva_allowedTo('moderate') && !aeva_allowedTo('auto_approve_item'))
		echo '
		<div class="unapproved_yet">', $txt['aeva_will_be_approved'], '</div>';

	if (!$item['approved'] && (aeva_allowedTo('moderate') || aeva_allowedTo('auto_approve_item')))
		echo '
		<div class="unapproved_yet">', $txt['aeva_approve_this'], '</div>';

	echo '

		<table cellspacing="0" cellpadding="4" border="0" width="100%">
		<tr>
			<td width="25%" class="titlebg" style="padding: 7px 0 5px 8px; border-radius: 8px 0 0 0"><h3>', $txt['aeva_poster_info'], '</h3></td>
			<td class="titlebg" style="padding: 7px 0 5px 8px; border-radius: 0 8px 0 0"><h3>', $txt['aeva_item_info'], '</h3></td>
		</tr><tr>
		<td valign="top" class="windowbg">', empty($item['member']['id']) ? '
			<h4>' . $txt['guest'] . '</h4>' : '
			<h4>' . $item['member']['link'] . '</h4>
			<ul class="smalltext info_list">' . (!empty($item['member']['group']) ? '
				<li>' . $item['member']['group'] . '</li>' : '') . (!empty($item['member']['avatar']['image']) ? '
				<li>' . $item['member']['avatar']['image'] . '</li>' : '') . '
				<li>' . $txt['aeva_total_items'] . ': ' . $item['member']['aeva']['total_items'] . '</li>
				<li>' . $txt['aeva_total_comments'] . ': ' . $item['member']['aeva']['total_comments'] . '</li>', '
			</ul>
		</td>
		<td valign="top" class="windowbg2"', $amSettings['show_extra_info'] == 1 ? ' rowspan="2"' : '', '>
			<table cellspacing="0" cellpadding="3" border="0" width="100%">
			<tr><td class="info smalltext">', $txt['aeva_posted_on'], '</td><td class="info">', timeformat($item['time_added']), '</td></tr>';

	if ($item['type'] != 'embed')
		echo !empty($item['width']) && !empty($item['height']) ? '
			<tr><td class="info smalltext">' . $txt['aeva_width'] . '&nbsp;&times;&nbsp;' . $txt['aeva_height'] . '</td><td class="info">' . $item['width'] . '&nbsp;&times;&nbsp;' . $item['height'] . '</td></tr>' : '', '
			<tr><td class="info smalltext">', $txt['aeva_filesize'], '</td><td class="info">', $item['filesize'], ' ', $txt['aeva_kb'], '</td></tr>
			<tr><td class="info smalltext">', $txt['aeva_filename'], '</td><td class="info">', $item['filename'], '</td></tr>';

	if ((!empty($item['keyword_list']) && implode('', $item['keyword_list']) != '') || !empty($item['keywords']))
	{
		echo '
			<tr><td class="info smalltext">', $txt['aeva_keywords'], '</td><td class="info">';
		$tag_list = '';
		if (!empty($item['keyword_list']))
		{
			foreach ($item['keyword_list'] as $tag)
				if (!empty($tag))
					$tag_list .= '<b><a href="' . $galurl . 'sa=search;search=' . urlencode($tag) . ';sch_kw">' . $tag . '</a></b>, ';
		}
		else
			echo $item['keywords'];
		echo substr($tag_list, 0, strlen($tag_list) - 2) . '</td></tr>';
	}

	echo '
			<tr><td class="info smalltext">', $txt['aeva_views'], '</td><td class="info">', $item['views'], '</td></tr>', !empty($item['downloads']) ? '
			<tr><td class="info smalltext">' . $txt['aeva_downloads'] . '</td><td class="info">' . $item['downloads'] . '</td></tr>' : '', '
			<tr><td class="info smalltext">', $txt['aeva_rating'], '</td><td class="info" id="ratingElement">', template_aeva_rating_object($item), '</td></tr>',
			!empty($item['num_comments']) ? '
			<tr><td class="info smalltext">' . $txt['aeva_comments'] . '</td><td class="info">' . $item['num_comments'] . '</td></tr>' : '', !empty($item['last_edited']) ? '
			<tr><td class="info smalltext">' . $txt['aeva_last_edited'] . '</td><td class="info">' . $item['last_edited'] . ($item['last_edited_by'] !== -2 ? ' ' . $txt['aeva_by'] . ' ' . $item['last_edited_by'] : '') . '</td></tr>' : '';

	foreach ($item['custom_fields'] as $field)
	{
		if (!empty($field['value']))
		{
			echo '
			<tr>
				<td class="info smalltext">', $field['name'], '</td>
				<td class="info">';
			if ($field['searchable'])
			{
				$build_list = '';
				foreach ($field['value'] as $val)
					$build_list .= '<a href="' . $galurl . 'sa=search;search=' . urlencode($val) . ';fields[]=' . $field['id'] . '">' . $amFunc['htmlspecialchars']($val) . '</a>, ';
				echo substr($build_list, 0, -2);
				unset($build_list);
			}
			else
				echo substr($field['value'], 0, 7) == 'http://' ? '<a href="' . $field['value'] . '">' . $amFunc['htmlspecialchars']($field['value']) . '</a>' : $field['value'];
			echo '</td>
			</tr>';
		}
	}

	if ($amSettings['show_linking_code'])
	{
		echo '
			<tr>
				<td class="info smalltext">', $txt['aeva_embed_bbc'], '</td>
				<td class="info">
					<input id="bbc_embed" type="text" size="56" value="[smg id=' . $item['id_media'] . ($item['type'] == 'image' ? '' : ' type=av') . ']" onclick="return selectText(this);" readonly="readonly" />
					<a href="', $scripturl, '?action=media;sa=smgtaghelp" onclick="return reqWin(this.href, 600, 400);"><img alt="" src="', $settings['images_url'], '/helptopics.gif" class="vam" border="0" /></a>
				</td>
			</tr>';

		// Don't show html/direct links if the helper file was deleted
		if ($amSettings['show_linking_code'] == 1)
		{
			if (strpos($item['embed_object'], 'swfobject.embedSWF') === false)
				echo '
			<tr>
				<td class="info smalltext">', $txt['aeva_embed_html'], '</td><td class="info">
					<input id="html_embed" type="text" size="60" value="', $item['type'] == 'image' ?
						htmlspecialchars('<img src="' . $boardurl . '/MGalleryItem.php?id=' . $item['id_media'] . '" alt="" />') :
						htmlspecialchars(trim(preg_replace('/[\t\r\n]+/', ' ', $item['embed_object']))), '" onclick="return selectText(this);" readonly="readonly" />
				</td>
			</tr>';
			if ($item['type'] != 'embed')
				echo '
			<tr>
				<td class="info smalltext">' . $txt['aeva_direct_link'] . '</td>
				<td class="info">
					<input id="direct_link" type="text" size="60" value="' . $boardurl . '/MGalleryItem.php?id=' . $item['id_media'] . '" onclick="return selectText(this);" readonly="readonly" />
				</td>
			</tr>';
		}
	}
	echo '
			</table>
		</td></tr>';

	if ($amSettings['show_extra_info'] == 1)
	{
		echo '
		<tr><td valign="bottom" class="windowbg">
			<div class="titlebg" style="margin: 0 -4px 2px -4px; padding: 7px 0 5px 8px"><h3>', $txt['aeva_extra_info'], '</h3></div>';

		if (empty($item['extra_info']))
			echo '
			<div class="info">', $txt['aeva_exif_not_available'], '</div>';
		else
		{
			echo $amSettings['use_lightbox'] ? '
			<div class="info"><img alt="" src="' . $settings['images_aeva'] . '/magnifier.png" class="vam" /> <a href="#" onclick="return hs.htmlExpand(this);">'
			. $txt['aeva_exif_entries'] . '</a> (' . count($item['extra_info']) . ')
			<div class="highslide-maincontent">
				<div class="title_bar"><h3 class="titlebg ae_header" style="margin-bottom: 8px">' . $txt['aeva_extra_info'] . '</h3></div>' : '', '
				<div class="smalltext exif">';

			foreach ($item['extra_info'] as $info => $data)
				if (!empty($data))
					echo '
					<div class="info"><b>', $txt['aeva_exif_'.$info], '</b>: ', $data, '</div>';
			echo '
				</div>
			</div>', $amSettings['use_lightbox'] ? '</div>' : '';
		}
		echo '
		</td></tr>';
	}

	echo '
		<tr><td align="center" colspan="2" class="titlebg info images" style="line-height: 16px; vertical-align: text-bottom; border-radius: 0 0 8px 8px">', $item['can_report'] ? '
			<a href="'.$galurl.'sa=report;type=item;in='.$item['id_media'].'"' . ($amSettings['use_lightbox'] ? ' onclick="return hs.htmlExpand(this);"' : '') . '><img alt="" src="'.$settings['images_aeva'].'/report.png" />&nbsp;' . $txt['aeva_report_this_item'] . '</a>' : '';

	if ($item['can_report'] && $amSettings['use_lightbox'])
		echo '
			<div class="highslide-maincontent">
				<form action="'.$galurl.'sa=report;type=item;in='.$item['id_media'].'" method="post">
					<h3>'.$txt['aeva_reporting_this_item'].'</h3>
					<hr />'.$txt['aeva_reason'].'<br />
					<textarea cols="" rows="8" style="width: 98%" name="reason"></textarea>
					<p class="mgra"><input type="submit" value="'.$txt['aeva_submit'].'" class="aeva_ok" name="submit_aeva" /> <input type="button" onclick="return hs.close(this);" value="'.$txt['aeva_close'].'" class="aeva_cancel" /></p>
				</form>
			</div>';

	if ($item['can_edit'])
		echo '
			<a href="'.$galurl.'sa=post;in='.$item['id_media'].'"><img alt="" src="'.$settings['images_aeva'].'/camera_edit.png" />&nbsp;' . $txt['aeva_edit_this_item'] . '</a>
			<a href="'.$galurl.'sa=delete;in='.$item['id_media'].'"' . ($amSettings['use_lightbox'] ? ' onclick="return hs.htmlExpand(this);"' : ' onclick="return confirm(\''.$txt['aeva_confirm'].'\')"') . '><img alt="" src="'.$settings['images_aeva'].'/delete.png" />&nbsp;' . $txt['aeva_delete_this_item'] . '</a>';

	if ($item['can_edit'] && $amSettings['use_lightbox'])
		echo '
			<div class="highslide-maincontent">
				<form action="'.$galurl.'sa=delete;in='.$item['id_media'].'" method="post">
					<h3>'.$txt['aeva_delete_this_item'].'</h3>
					<hr />'.$txt['aeva_confirm'].'
					<p class="mgra"><input type="submit" value="' . $txt['aeva_yes'] . '" class="aeva_ok" /> <input type="button" onclick="return hs.close(this);" value="'.$txt['aeva_no'].'" class="aeva_cancel" /></p>
				</form>
			</div>';

	echo
		aeva_allowedTo('download_item') && $item['type'] != 'embed' ? '
			<a href="'.$galurl.'sa=media;in='.$item['id_media'].';dl"><img alt="" src="'.$settings['images_aeva'].'/download.png" />&nbsp;' . $txt['aeva_download_this_item'] . '</a>' : '';

	if ($item['can_edit'] && !empty($context['aeva_move_albums']))
		echo '
			<a href="'.$galurl.'sa=move;in='.$item['id_media'].'" '.($amSettings['use_lightbox'] ? 'onclick="return hs.htmlExpand(this);"' : '').'><img alt="" src="'.$settings['images_aeva'].'/arrow_out.png" />&nbsp;' . $txt['aeva_move_item'] . '</a>';

	if ($item['can_edit'] && $amSettings['use_lightbox'])
	{
		echo '
			<div class="highslide-maincontent">
				<h3>', $txt['aeva_moving_this_item'], '</h3>
				<h2>', $txt['aeva_album'], ': ', $item['album_name'], '</h2>
				<hr />
				<form action="', $galurl, 'sa=move;in=', $item['id_media'], '" method="post">
					', $txt['aeva_album_to_move'], ': <select name="album">';

			foreach ($context['aeva_move_albums'] as $album => $name)
			{
				if ($name[2] === '')
					echo '</optgroup>';
				elseif ($name[2] == 'begin')
					echo '<optgroup label="', $name[0], '">';
				else
					echo '<option value="', $album, '"', $name[1] ? ' disabled="disabled"' : '', '>', $name[0], '</option>';
			}

			echo '
					</select>
					<p class="mgra"><input type="submit" value="', $txt['aeva_submit'], '" class="aeva_ok" name="submit_aeva" /> <input type="button" onclick="return hs.close(this);" value="', $txt['aeva_close'], '" class="aeva_cancel" /></p>
				</form>
			</div>';
	}

	$un = $item['approved'] ? 'un' : '';
	if ($item['can_approve'])
		echo '
			<a href="', $galurl, 'sa=', $un, 'approve;in=', $item['id_media'], '"><img alt="" src="', $settings['images_aeva'], '/', $un, 'tick.png" />&nbsp;', $txt['aeva_admin_' . $un . 'approve'], '</a>';

	echo '
		</td></tr>
		</table>';

	if (isset($item['playlists'], $item['playlists']['current']))
		aeva_foxy_show_playlists($item['id_media'], $item['playlists']);

	// Comments!
	echo '
		<table cellspacing="1" cellpadding="8" border="0" class="bordercolor" width="100%" id="mg_coms">
		<tr><td class="titlebg aeva_header" colspan="4" style="padding: 0 6px" valign="middle">
			<span class="comment_header">', $context['aeva_foxy'] && function_exists('aeva_foxy_rss') ? '
				<a href="'.$galurl.'sa=rss;item='.$item['id_media'].';type=comments" style="text-decoration: none"><img src="'.$settings['images_aeva'].'/rss.png" alt="RSS" />&nbsp;' . $txt['aeva_comments'] . '</a>' : '
				' . $txt['aeva_comments'], '
			</span>
			<span class="smalltext comment_sort_options">
				', empty($item['comments']) ? $txt['aeva_no_comments'] : $txt['aeva_sort_order_com'] . ' -
				<a href="' . $galurl . 'sa=item;in=' . $item['id_media'] . (isset($_REQUEST['start']) ? ';start=' . $_REQUEST['start'] : '') . '">' . $txt['aeva_sort_order_asc'] . '</a>
				<a href="' . $galurl . 'sa=item;in=' . $item['id_media'] . ';com_desc' . (isset($_REQUEST['start']) ? ';start=' . $_REQUEST['start'] : '') . '">' . $txt['aeva_sort_order_desc'] . '</a>', '
			</span>
		</td></tr>
		</table>', empty($item['comments']) ? '' : '
		<div class="pagelinks">' . $txt['aeva_pages'] . ': ' . $item['com_page_index'] . '</div>';

	$alternative = false;
	foreach ($item['comments'] as $c)
	{
		$alternative = !$alternative;
		echo '
		<div class="windowbg', $alternative ? '' : '2', '">
			<span class="topslice"><span></span></span>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding: 0 10px" class="tlf"><tr>
			<td width="20%"', $c['is_edited'] ? ' rowspan="2"' : '', ' valign="top">', empty($c['member']['id']) ? '
				<h4>' . $txt['guest'] . '</h4>' : '
				<h4>' . $c['member_link'] . '</h4>
				<ul class="smalltext info_list">' . (!empty($c['member']['group']) ? '
					<li>' . $c['member']['group'] . '</li>' : '') . (!empty($c['member']['avatar']['image']) ? '
					<li>' . $c['member']['avatar']['image'] . '</li>' : '') . '
					<li>' . $txt['aeva_total_items'] . ': ' . $c['member']['aeva']['total_items'] . '</li>
					<li>' . $txt['aeva_total_comments'] . ': ' . $c['member']['aeva']['total_comments'] . '</li>
				</ul>', '
			</td>
			<td valign="top"', $c['approved'] ? '' : ' class="unapp"', '>
				<a name="com', $c['id_comment'], '"></a>
				<div class="mgc_main">
					', $txt['aeva_comment'], ' <a href="#com', $c['id_comment'], '" rel="nofollow">#', $c['counter'], '</a> - ',
				is_numeric($c['posted_on'][0]) ? $txt['aeva_posted_on_date'] : $txt['aeva_posted_on'], ' ', $c['posted_on'], '
				</div>';

		if ($c['can_edit'] || $c['can_report'])
			echo '
				<div class="mgc_icons">', $c['can_edit'] ? '
					<a href="'.$galurl.'sa=edit;type=comment;in='.$c['id_comment'].'"><img alt="" src="'.$settings['images_aeva'].'/comment_edit.png" /> '.$txt['aeva_edit_this_item'].'</a>' : '', $c['can_delete'] ? '
					<a href="'.$galurl.'sa=delete;type=comment;in='.$c['id_comment'].'" onclick="return confirm(\''.$txt['aeva_confirm'].'\')"><img alt="" src="'.$settings['images_aeva'].'/delete.png" /> '.$txt['aeva_delete_this_item'].'</a> ' : '', $c['can_report'] ? '
					<a href="'.$galurl.'sa=report;type=comment;in='.$c['id_comment'].'"><img alt="" src="'.$settings['images_aeva'].'/report.png" /> '.$txt['aeva_report_this_item'].'</a>' : '', !$c['approved'] && $c['can_delete'] ? '
					<a href="'.$scripturl.'?action=media;area=moderate;sa=submissions;do=approve;in='.$c['id_comment'].';type=coms;' . $context['session_var'] . '='.$context['session_id'].'"><img alt="" src="'.$settings['images_aeva'].'/tick.png" title="'.$txt['aeva_admin_approve'].'" /> '.$txt['aeva_admin_approve'].'</a>' : '', '
				</div>';

		echo '
				<div class="mgc_post">
					', $c['message'], '
				</div>
			</td></tr>', $c['is_edited'] ? '
			<tr><td valign="bottom">
				<div class="mgc_last_edit">' . $txt['aeva_last_edited'] . ': ' . $c['last_edited']['on'] .
				($c['last_edited']['id'] > -2 ? ' ' . strtolower($txt['aeva_by']) . ' ' . $c['last_edited']['link'] : '') . '</div>
			</td></tr>' : '', '
			</table>
			<span class="botslice"><span></span></span>
		</div>';
	}
	if (!empty($item['comments']))
		echo '
		<div class="pagelinks">' . $txt['aeva_pages'] . ': ' . $item['com_page_index'] . '</div>';

	if (aeva_allowedTo('comment'))
		echo '
		<div id="quickreplybox" style="padding-top: 4px">
			<div class="cat_bar">
				<h3 class="catbg">
					<span class="ie6_header floatleft"><a href="#" onclick="return aevaSwap(\'', $settings['images_url'], '\');">
						<img src="', $settings['images_url'], '/expand.gif" alt="+" id="quickReplyExpand" class="icon" />
					</a>
					<a href="#" onclick="return aevaSwap(\'', $settings['images_url'], '\');">', $txt['aeva_comment_this_item'], '</a>
					</span>
				</h3>
			</div>
			<div id="quickReplyOptions" style="display: none">
				<span class="upperframe"><span></span></span>
				<div class="roundframe">
					<form action="'.$galurl.'sa=comment;in='.$item['id_media'].'" method="post">
						<div>
							<h3>'.$txt['aeva_commenting_this_item'].'</h3>
							<img alt="" src="'.$settings['images_aeva'].'/comment.png" align="middle" /> <a href="' . $galurl . 'sa=comment;in=' . $item['id_media'] . '">' . $txt['aeva_switch_fulledit'] . '</a>
						</div>
						<textarea name="comment" cols="" rows="8" style="width: 95%"></textarea>
						<p class="mgra"><input type="submit" value="'.$txt['aeva_submit'].'" name="submit_aeva" class="aeva_ok" /> <input type="button" onclick="return hs.close(this);" value="'.$txt['aeva_close'].'" class="aeva_cancel" /></p>
					</form>
				</div>
				<span class="lowerframe"><span></span></span>
			</div>
		</div>';

	echo '
	</div>';
}

function template_aeva_done()
{
	// Template to show some "done" kind of things, uses $context['aeva_done_txt'] as its context to show
	global $context;
	echo '
		<div style="font-size: 1.2em">
			<table border="0" width="100%" height="100px">
				<tr class="windowbg2">
					<td align="center">', $context['aeva_done_txt'], '</td>
				</tr>
			</table>
		</div>';
}

function template_aeva_form()
{
	// This is a pretty global template used for forms like reporting, commenting, adding, editing etc.
	global $amSettings, $context, $txt, $galurl;
	static $chk = 1, $colspan = 0;

	echo '
	<form action="', $context['aeva_form_url'], '" method="post" enctype="multipart/form-data" id="aeva_form" name="aeva_form" onsubmit="submitonce(this);">
		<table border="0" width="100%" cellspacing="1" cellpadding="8" class="bordercolor"', !empty($context['aeva_form']) && isset($context['aeva_form']['whitespace']) ? ' style="margin-top: 12px"' : '', '>';

	// Form headers
	if (isset($context['aeva_form_headers']))
		foreach ($context['aeva_form_headers'] as $h)
			if (!isset($h[1]) || $h[1])
				echo '
			<tr class="windowbg2"><td colspan="2" align="center">', $h[0], '</td></tr>';

	// The form itself.
	$show_at_end = '';
	foreach ($context['aeva_form'] as $e)
	{
		if (!isset($e['perm']) || $e['perm'])
		{
			if (isset($e['skip']))
			{
				$show_at_end .= '
					<input type="hidden" name="' . $e['fieldname'] . '" value="' . $e['value'] . '" />';
				continue;
			}

			if ($e['type'] == 'hr')
			{
				echo '
			<tr><td colspan="2" style="padding: 0"></td></tr>
			<tr><td colspan="2" style="padding: 1px 0 0 0; border-top: 1px dotted #aaa"></td></tr>';
				continue;
			}

			if ($e['type'] == 'title')
			{
				if (isset($e['class']))
					echo '
			<tr><td colspan="2" style="padding: 3px" class="' . $e['class'] . '"><h3 style="margin: 0">' . $e['label'] . '</h3></td></tr>';
				elseif ($context['is_smf2'])
					echo '
			<tr><td colspan="2" style="padding: 3px 0 0 0"><div class="title_bar"><h3 class="titlebg">' . $e['label'] . '</h3></div></td></tr>';
				else
					echo '
			<tr><td colspan="2" style="padding: 3px" class="titlebg"><h3 style="margin: 0">' . $e['label'] . '</h3></td></tr>';
				continue;
			}

			// If there's a text editor in the form, adjust the name/description column width accordingly.
			if ($colspan < 2)
				$alt = empty($alt) ? '2' : '';
			$valign = $e['type'] == 'textbox' || $e['type'] == 'select' || substr($e['type'], 0, 5) == 'check';

			echo '
			<tr>', !empty($e['skip_left']) || --$colspan > 0 ? '' : '
				<td width="' . (isset($context['post_box_name']) ? ($context['post_box_name'] == 'desc' ? '35' : '10') : '50') . '%" class="windowbg' . $alt . '"' .
				($valign ? ' valign="top"' : '') . (!empty($e['colspan']) && ($colspan = $e['colspan']) ? ' rowspan="2"' : '') . '>' . $e['label'] . (!empty($e['subtext']) ? '<div class="mg_subtext">' . $e['subtext'] . '</div>' : '') . '</td>', '
				<td class="windowbg' . $alt . '"' . (!empty($e['skip_left']) ? ' colspan="2"' : '') . '>';

			if ($e['type'] != 'title')
				switch($e['type'])
				{
					case 'text';
						echo '<input type="text"', isset($e['value']) ? ' value="'.$e['value'].'"' : '', ' name="', $e['fieldname'], '" tabindex="', $context['tabindex']++, '" size="', !empty($e['size']) ? $e['size'] : 50, '"', isset($e['custom']) ? ' ' . $e['custom'] : '', ' />';
					break;
					case 'textbox';
						if (isset($context['post_box_name']) && $context['post_box_name'] == $e['fieldname'])
						{
							echo '<div id="bbcBox_message"></div><div id="smileyBox_message"></div>';
							template_aeva_text_editor();
						}
						else
							echo '<textarea name="', $e['fieldname'], '" tabindex="', $context['tabindex']++, '"', isset($e['custom']) ? ' ' . $e['custom'] : '', '>', isset($e['value']) ? $e['value'] : '', '</textarea>';
					break;
					case 'file';
						echo '<input type="file" name="', $e['fieldname'], '" tabindex="', $context['tabindex']++, '" size="51"', isset($e['custom']) ? ' ' . $e['custom'] : '', ' />', isset($e['add_text']) ? ' ' . $e['add_text'] : '';
					break;
					case 'hidden';
						echo '<input type="hidden" name="', $e['fieldname'], '" value="', $e['value'], '"', isset($e['custom']) ? ' ' . $e['custom'] : '', ' />';
					break;
					case 'small_text';
						echo '<input type="text"', isset($e['value']) ? ' value="'.$e['value'].'"' : '', ' name="', $e['fieldname'], '" tabindex="', $context['tabindex']++, '" size="10"', isset($e['custom']) ? ' ' . $e['custom'] : '', ' />';
					break;
					case 'select';
						echo '<select name="', $e['fieldname'], isset($e['multi']) && $e['multi'] === true ? '[]' : '', '" tabindex="', $context['tabindex']++, '"',
							isset($e['multi']) && $e['multi'] === true ? ' multiple="multiple"' . (!empty($e['size']) ? ' size="' . $e['size'] . '"' : '') : '',
							isset($e['custom']) ? ' ' . $e['custom'] : '', '>';
						foreach ($e['options'] as $value => $name)
						{
							if (is_array($name) && isset($name[2]) && ($name[2] === '' || $name[2] === 'begin'))
								echo $name[2] == 'begin' ? '<optgroup label="' . $name[0] . '">' : '</optgroup>';
							else
								echo '<option value="', $value, '"', is_array($name) && isset($name[1]) && $name[1] == true ? ' selected="selected"' : '', is_array($name) && isset($name[2]) ? $name[2] : '', '>', is_array($name) ? $name[0] : $name, '</option>';
						}
						echo '</select>';
					break;
					case 'radio';
						foreach ($e['options'] as $value => $name)
							echo '<div><input id="radio', $chk, '" name="', $e['fieldname'], '" tabindex="', $context['tabindex']++, '" value="', $value, '"', is_array($name) && isset($name[1]) && $name[1] === true ? ' checked="checked"' : '', ' type="radio"', isset($e['custom']) ? ' ' . $e['custom'] : '', ' /><label for="radio', $chk++, '"> ', is_array($name) ? $name[0] : $name, '</label></div>';
					break;
					case 'yesno';
						echo '<div><select name="', $e['fieldname'], '" tabindex="', $context['tabindex']++, '"><option value="1"', !empty($e['value']) ? ' selected="selected"' : '', ' style="color: green">', $txt['aeva_yes'], '</option><option value="0"', empty($e['value']) ? ' selected="selected"' : '', ' style="color: red">', $txt['aeva_no'], '</option></select></div>';
					break;
					case 'passwd';
						echo '<input name="', $e['fieldname'], '" tabindex="', $context['tabindex']++, '" value="', isset($e['value']) ? $e['value'] : '', '" type="password"', isset($e['custom']) ? ' ' . $e['custom'] : '', ' />';
					break;
					case 'checkbox';
					case 'checkbox_line';
						foreach ($e['options'] as $opt => $label)
						{
							if (!is_array($label) && $label == 'sep')
								echo '<hr />';
							else
								echo '<div', $e['type'] == 'checkbox_line' ? ' class="aeva_ich' . (!empty($e['skip_left']) ? '2' : '') . '"' : '', '><input type="checkbox" id="chk', $chk, '" name="', is_array($label) ?
									(!isset($label['force_name']) ? $e['fieldname'] . (isset($e['multi']) && $e['multi'] === true ? '[]' : '') : $label['force_name']) : $label,
									'" tabindex="', $context['tabindex']++, '" value="', $opt, '"', is_array($label) && isset($label[1]) && $label[1] === true ? ' checked="checked"' : '', is_array($label) && !empty($label['disabled']) ? ' disabled="disabled"' : '',
									is_array($label) && isset($label['custom']) ? ' ' . $label['custom'] : '', ' /><label for="chk', $chk++, '">&nbsp;&nbsp;', is_array($label) ? $label[0] : $label, '</label></div>';
						}
					break;
					case 'checkbox_dual'; // This one is for album creation only... ;)
						echo '<table cellpadding="4" cellspacing="0" border="0" width="100%"><thead><tr><th>', $txt['aeva_access_read'], '</th><th>', $txt['aeva_access_write'], '</th><th></th></tr></thead>';
						foreach ($e['options'] as $opt => $label)
						{
							echo '<tr>';
							if (!is_array($label))
								echo '<td colspan="3" style="padding: 1px 0 0 0; border-top: 1px dotted #aaa"></td>';
							else
							{
								for ($i = 0; $i < 2; $i++)
									echo '<td width="15" align="center"><input type="checkbox" id="chk', $chk++, '" name="',
										$opt === 'check_all' ? 'check_all_' . ($i+1) : $e['fieldname'][$i] . '[]',
										'" tabindex="', $context['tabindex']++, '" value="', $opt, '"',
										isset($label[$i+1]) && $label[$i+1] === true ? ' checked="checked"' : '',
										$opt == -1 && $i == 1 ? ' disabled="disabled"' : '',
										isset($label['custom']) ? ' ' . str_replace('$1', $e['fieldname'][$i], $label['custom']) : '', ' /></td>';
								echo '<td><label for="chk', $chk-2, '">', $label[0], '</label></td>';
							}
							echo '</tr>';
						}
						echo '</table>';
					break;
					case 'link';
						echo '<a href="', $e['link'], '">', $e['text'], '</a>', !empty($e['add_text']) ? ' ' . $e['add_text'] : '';
					break;
					case 'info';
						echo $e['value'];
					break;
				}

			echo !empty($e['next']) ? $e['next'] : '', '
				</td>
			</tr>';
		}
	}

	// End the form.
	echo '
			<tr>
				<td class="windowbg', empty($alt) ? '2' : '', '" colspan="2" align="right">', $show_at_end, !empty($context['aeva_form']['silent']) ? '
					<input type="submit" value="' . $txt['aeva_silent_update'] .  '" name="silent_update" tabindex="' . $context['tabindex']++ . '" class="button_submit" />' : '', '
					<input type="submit" value="', $txt['aeva_submit'], '" name="submit_aeva" tabindex="', $context['tabindex']++, '" class="button_submit" />
				</td>
			</tr>
		</table>
	</form>';

	if (!empty($context['aeva_extra_data']))
		echo $context['aeva_extra_data'];
}

function template_aeva_viewAlbum()
{
	global $context, $txt, $galurl, $scripturl, $amSettings, $settings, $user_info;

	$album_data = &$context['album_data'];

	// Show some album data
	echo '
	<div id="albums">
		<table cellpadding="6" cellspacing="0" border="0" width="100%" class="windowbg2">
		<tr><td class="windowbg" valign="top" width="2%" rowspan="2">';
	// If the big icon is too... big, then we can't round its corners. Ah well.
	if ($album_data['bigicon_resized'])
		echo '<img src="', $galurl, 'sa=media;in=', $album_data['id'], ';bigicon" width="', $album_data['bigicon'][0], '" height="', $album_data['bigicon'][1], '" alt="" />';
	else
		echo '<div class="aea" style="width: ', $album_data['bigicon'][0], 'px; height: ', $album_data['bigicon'][1], 'px; background: url(', $galurl, 'sa=media;in=', $album_data['id'], ';bigicon) 0 0;">&nbsp;</div>';
	echo '</td>
		<td style="padding: 12px 12px 6px 12px">
			<div class="mg_large mg_pb4">', !empty($album_data['passwd']) ? aeva_lockedAlbum($album_data['passwd'], $album_data['id'], $album_data['owner']) : '',
			$album_data['name'], $context['aeva_foxy'] && function_exists('aeva_foxy_rss') ? '&nbsp;&nbsp;&nbsp;<span class="title_rss">
			<a href="' . $galurl . 'sa=rss;album=' . $album_data['id'] . '"><img src="' . $settings['images_aeva'] . '/rss.png" alt="RSS" class="aeva_vera" /> ' . $txt['aeva_items'] . '</a>
			<a href="' . $galurl . 'sa=rss;album=' . $album_data['id'] . ';type=comments"><img src="' . $settings['images_aeva'] . '/rss.png" alt="RSS" class="aeva_vera" /> ' . $txt['aeva_comments'] . '</a></span>' : '', '</div>
			<div>', $album_data['type2'], !empty($album_data['owner']['id']) ? '
			- ' . $txt['aeva_owner'] . ': ' . aeva_profile($album_data['owner']['id'], $album_data['owner']['name']) : '', '
			- ', $album_data['num_items'] == 0 ? $txt['aeva_no_items'] : $album_data['num_items'] . ' ' . $txt['aeva_lower_item' . ($album_data['num_items'] == 1 ? '' : 's')], !empty($album_data['last_item']) ? ' - ' . $txt['aeva_latest_item'] . ': <a href="'.$galurl.'sa=item;in='.$album_data['last_item'].'">'.$album_data['last_item_title'].'</a> (' . $album_data['last_item_date'] . ')' : '', '</div>', !empty($album_data['description']) ? '
			<div class="mg_desc">' . $album_data['description'] . '</div>' : '', $album_data['hidden'] ? '
			<div class="mg_hidden">' . $txt['aeva_album_is_hidden'] . '</div>' : '', '
		</td></tr>
		<tr><td valign="bottom">';

	$can_moderate_here = aeva_allowedTo('moderate') || (!$user_info['is_guest'] && $user_info['id'] == $album_data['owner']['id']);
	$can_approve_here = $can_moderate_here || aeva_allowedTo('auto_approve_item');
	$can_add_playlist = !empty($context['aeva_my_playlists']);
	if ($can_edit_items = ($can_moderate_here || $context['aeva_can_add_item'] || $context['aeva_can_multi_upload']) || aeva_allowedTo('multi_download') || aeva_allowedTo('access_unseen'))
	{
		echo '
			<div class="buttonlist data">
				<ul>';

		if ($context['aeva_can_add_item'])
			echo '
					<li><a href="', $galurl, 'sa=post;album=', $album_data['id'], '"><span><img alt="" src="', $settings['images_aeva'], '/camera_add.png" /> ', $txt['aeva_add_item'], '</span></a></li>';

		if ($context['aeva_can_multi_upload'])
			echo '
					<li><a href="', $galurl, 'sa=mass;album=', $album_data['id'], '"><span><img alt="" src="', $settings['images_aeva'], '/camera_mass.png" /> ', $txt['aeva_multi_upload'], '</span></a></li>';

		if ($can_moderate_here)
		{
			echo '
					<li><a href="', $galurl, 'area=mya;sa=edit;in=', $album_data['id'], '"><span><img alt="" src="', $settings['images_aeva'], '/folder_edit.png" title="', $txt['aeva_admin_edit'], '" /> ', $txt['aeva_admin_edit'], '</span></a></li>';
			if ($user_info['is_admin'])
				echo '
					<li><a href="', $scripturl, '?action=admin;area=aeva_maintenance;sa=index;album=', $album_data['id'], ';', $context['session_var'], '=', $context['session_id'], '"><span><img alt="" src="', $settings['images_aeva'], '/maintain.gif" title="', $txt['aeva_admin_labels_maintenance'], '" /> ', $txt['aeva_admin_labels_maintenance'], '</span></a></li>';
			if (aeva_allowedTo('moderate') && $album_data['approved'] == 0)
				echo '
					<li><a href="', $scripturl, '?action=media;area=moderate;sa=submissions;do=approve;type=albums;in=', $album_data['id'], ';', $context['session_var'], '=', $context['session_id'], '"><span><img alt="" src="', $settings['images_aeva'], '/tick.png" title="', $txt['aeva_admin_approve'], '" /> ', $txt['aeva_admin_approve'], '</span></a></li>';
		}

		if (aeva_allowedTo('multi_download'))
			echo '
					<li><a href="', $galurl, 'sa=massdown;album=', $album_data['id'], '"><span><img alt="" src="', $settings['images_aeva'], '/download.png" title="', $txt['aeva_multi_download'], '" /> ', $txt['aeva_multi_download'], '</span></a></li>';

		if (aeva_allowedTo('access_unseen'))
			echo '
					<li><a href="', $galurl, 'sa=album;in=', $album_data['id'], ';markseen;', $context['session_var'], '=', $context['session_id'], '"><span><img alt="" src="', $settings['images_aeva'], '/eye.png" title="', $txt['aeva_mark_album_as_seen'], '" /> ', $txt['aeva_mark_album_as_seen'], '</span></a></li>';

		echo '
				</ul>
			</div>';
	}
	$can_edit_items |= $can_add_playlist;

	echo '
		</td></tr>
		</table>';

	// Show their Sub-Albums
	if (!empty($context['aeva_sub_albums']))
	{
		echo '
		<div class="titlebg" style="padding: 4px">', $txt['aeva_sub_albums'], $context['aeva_foxy'] && function_exists('aeva_foxy_rss') ? '&nbsp;&nbsp;&nbsp;<span class="title_rss">
			<a href="' . $galurl . 'sa=rss;album=' . $album_data['id'] . ';children"><img src="' . $settings['images_aeva'] . '/rss.png" alt="RSS" class="aeva_vera" /> ' . $txt['aeva_items'] . '</a>
			<a href="' . $galurl . 'sa=rss;album=' . $album_data['id'] . ';children;type=comments"><img src="' . $settings['images_aeva'] . '/rss.png" alt="RSS" class="aeva_vera" /> ' . $txt['aeva_comments'] . '</a></span>' : '', '</div>';
		aeva_listChildren($context['aeva_sub_albums']);
	}

	if ($context['no_items'] || empty($context['aeva_items']))
	{
		echo '
		<p class="windowbg2 notice">
			', $txt['aeva_no_listing'], '
		</p>
	</div>';
		return;
	}

	// Page index and sorting things
	$sort_list = array('m.id_media' => 0, 'm.time_added' => 1, 'm.title' => 2, 'm.views' => 3, 'm.weighted' => 4);
	echo ($can_edit_items ? '
	<form action="' . $scripturl . '?action=media;sa=quickmod;in=' . $album_data['id'] . '" method="post" enctype="multipart/form-data" id="aeva_form" name="aeva_form" onsubmit="submitonce(this);">' : '') . '
		<div class="titlebg sort_options">
			<div class="view_options">
				', $txt['aeva_items_view'], ': ', $album_data['view'] == 'normal' ? '<b>' . $txt['aeva_view_normal'] . '</b> <a href="' . $galurl . 'sa=album;in=' . $album_data['id'] . ';fw;'. $context['aeva_urlmore'] . '">' . $txt['aeva_view_filestack'] . '</a>' : '<a href="' . $galurl . 'sa=album;in=' . $album_data['id'] . ';nw;' . $context['aeva_urlmore'] . '">' . $txt['aeva_view_normal'] . '</a> <b>' . $txt['aeva_view_filestack'] . '</b>', '
			</div>
			', $txt['aeva_sort_by'], ':';
	$sort = empty($sort_list[$context['aeva_sort']]) ? 0 : $sort_list[$context['aeva_sort']];
	for ($i = 0; $i < 5; $i++)
		echo $sort == $i ? ' <b>' . $txt['aeva_sort_by_'.$i] . '</b>' :
			' <a href="'.$galurl.'sa=album;in='.$album_data['id'] . ';sort=' . $i . ($album_data['view'] == 'normal' ? ';nw' : ';fw') . '">' . $txt['aeva_sort_by_'.$i] . '</a>';
	echo '
			| ', $txt['aeva_sort_order'], ':',
		($context['aeva_asc'] ? ' <b>' . $txt['aeva_sort_order_asc'] . '</b>' : ' <a href="'.$galurl.'sa=album;in='.$album_data['id'].(isset($_REQUEST['sort']) ? ';sort='.$_REQUEST['sort'] : '').';asc;' . ($album_data['view'] == 'normal' ? 'nw' : 'fw') . '">' . $txt['aeva_sort_order_asc'] . '</a>'),
		(!$context['aeva_asc'] ? ' <b>' . $txt['aeva_sort_order_desc'] . '</b>' : ' <a href="'.$galurl.'sa=album;in='.$album_data['id'] . (isset($_REQUEST['sort']) ? ';sort=' . $_REQUEST['sort'] : '').';desc;' . ($album_data['view'] == 'normal' ? 'nw' : 'fw') . '">'.$txt['aeva_sort_order_desc'].'</a>'), '
		</div>
		<div class="pagelinks page_index">
			', $txt['aeva_pages'], ': ', $context['aeva_page_index'], '
		</div>',
		$album_data['view'] == 'normal' ? aeva_listItems($context['aeva_items'], true, '', 0, $can_edit_items) : aeva_listFiles($context['aeva_items'], $can_edit_items), '
		<div class="pagelinks page_index" style="margin-top: 8px">', $can_edit_items ? '
			<div class="aeva_quickmod_bar">
				<input type="checkbox" id="check_all" onclick="invertAll(this, this.form, \'mod_item[\');" /> <label for="check_all">' . $txt[$context['is_smf2'] ? 'check_all' : 737] . '</label>&nbsp;
				<select name="aeva_modtype" id="modtype" tabindex="' . $context['tabindex']++ . '"' . ($can_add_playlist ? ' onchange="document.getElementById(\'aeva_my_playlists\').style.display = (this.value == \'playlist\') ? \'block\' : \'none\';"' : '') . '>' . ($can_approve_here ? '
					<option value="move">' . $txt['aeva_move_item'] . '</option>
					<option value="approve">' . $txt['aeva_admin_approve'] . '</option>
					<option value="unapprove">' . $txt['aeva_admin_unapprove'] . '</option>' : '') . '
					<option value="delete">' . $txt['aeva_delete_this_item'] . '</option>' . ($can_add_playlist ? '
					<option value="playlist">' . $txt['aeva_add_to_playlist'] . '</option>' : '') . '
				</select>' : '';
		if ($can_edit_items && $can_add_playlist)
		{
			echo '
				<select name="aeva_playlist" id="aeva_my_playlists" style="display: none">';
			foreach ($context['aeva_my_playlists'] as $p)
				echo '
					<option value="' . $p['id'] . '">' . $p['name'] . '</option>';
			echo '
				</select>';
		}
		echo $can_edit_items ? '
				<input type="hidden" name="' . ($context['session_var'] === 'sesc' ? 'sc' : $context['session_var']) . '" value="' . $context['session_id'] . '" />
				<input type="submit" value="' . $txt['aeva_submit'] . '" name="submit_aeva" tabindex="' . $context['tabindex']++ . '" class="button_submit" style="margin: 0; padding: 1px 3px" onclick="return aevaDelConfirm(\'' . $txt['aeva_confirm'] . '\');" />
			</div>' : '', '
			', $txt['aeva_pages'], ': ', $context['aeva_page_index'], '
		</div>', $can_edit_items ? '
	</form>' : '', '
	</div>';
}

function template_aeva_unseen()
{
	global $context, $txt, $galurl, $scripturl;

	echo '
	<div class="pagelinks align_left page_index">
		', $txt['aeva_pages'], ': ', $context['aeva_page_index'], '
	</div>';

	if (!empty($context['aeva_items']))
	{
		$mark_seen = array();
		if (strpos($context['aeva_page_index'], '<a') !== false)
			$mark_seen['pageseen'] = array('text' => 'aeva_page_seen', 'image' => 'markread.gif', 'lang' => true, 'url' => $galurl . 'sa=unseen;' . (isset($_GET['start']) ? 'start=' . $_GET['start'] . ';' : '') . 'pageseen=' . implode(',', array_keys($context['aeva_items'])) . ';' . $context['session_var'] . '=' . $context['session_id']);
		$mark_seen['markseen'] = array('text' => 'aeva_mark_as_seen', 'image' => 'markread.gif', 'lang' => true, 'url' => $galurl . 'sa=unseen;markseen;' . $context['session_var'] . '=' . $context['session_id']);
		aeva_button_strip($mark_seen, 'top', true);
	}

	echo '
	<div id="unseen_items" style="clear: both">', !empty($context['aeva_items']) ? aeva_listItems($context['aeva_items']) : '<br /><div class="notice">' . $txt['aeva_no_listing'] . '</div>', '
	</div>
	<div class="pagelinks align_left page_index">
		', $txt['aeva_pages'], ': ', $context['aeva_page_index'], '
	</div>';
}

function template_aeva_search_searching()
{
	global $txt, $galurl, $scripturl, $context, $settings;

	echo '
	<br />
	<form action="', $galurl, 'sa=search" method="post">
		<div class="windowbg2">
			<span class="topslice"><span></span></span>
			<div style="padding: 2px 8px" align="center">', $txt['aeva_search_for'], ': <input type="text" name="search" size="50" /></div>
			<span class="botslice"><span></span></span>
		</div>
		<div class="windowbg">
			<span class="topslice"><span></span></span>
			<table border="0" width="100%" cellspacing="1" cellpadding="8">
			<tr>
				<td ', !empty($context['custom_fields']) ? 'valign="top" width="50%" align="right"' : 'colspan="2" align="center"', '>
					<label for="seala1">', $txt['aeva_search_in_title'], '</label> <input type="checkbox" name="sch_title" checked="checked" id="seala1" /><br />
					<label for="seala2">', $txt['aeva_search_in_description'], '</label> <input type="checkbox" name="sch_desc" id="seala2" /><br />
					<label for="seala3">', $txt['aeva_search_in_kw'], '</label> <input type="checkbox" name="sch_kw" id="seala3" /><br />
					<label for="seala4">', $txt['aeva_search_in_album_name'], '</label> <input type="checkbox" name="sch_an" id="seala4" />';

	if (!empty($context['custom_fields']))
	{
		echo '
				</td>
				<td width="50%" valign="top" align="left">';

		$kl = 1;
		foreach ($context['custom_fields'] as $field)
			echo '
					<input type="checkbox" name="fields[]" value="', $field['id'], '" id="cusla', $kl, '" /> <label for="cusla', $kl++, '">', sprintf($txt['aeva_search_in_cf'], '<i>' . $field['name'] . '</i>'), '</label><br />';
	}

	echo '
				</td>
			</tr>
			<tr>
				<td width="50%" valign="top" align="right">', $txt['aeva_search_in_album'], '</td>
				<td width="50%" valign="top" align="left">
					<select name="sch_album">
						<option value="0">', $txt['aeva_search_in_all_albums'], '</option>';

	foreach ($context['aeva_albums'] as $id => $name)
		echo '<option value="', $id, '">', $name, '</option>';

	echo '
					</select>
				</td>
			</tr>
			<tr>
				<td width="50%" align="right">', $txt['aeva_search_by_mem'], '<div class="mg_subtext">', $txt['aeva_search_by_mem_sub'], '</div></td>
				<td width="50%" align="left"><input name="sch_mem" id="sch_mem" type="text" size="25" /> <a href="', $scripturl, '?action=media;action=findmember;input=sch_mem;' . $context['session_var'] . '=', $context['session_id'], '" onclick="return reqWin(this.href, 350, 400);"><img alt="" src="', $settings['images_url'], '/icons/assist.gif" class="aeva_vera" /></a></td>
			</tr>
			<tr>
				<td colspan="2" align="right"><input type="submit" name="submit_aeva" value="', $txt['aeva_submit'], '" /></td>
			</tr>
			</table>
			<span class="botslice"><span></span></span>
		</div>
	</form>';
}

function template_aeva_search_results()
{
	global $context, $txt, $scripturl;

	echo '
	<div style="padding: 5px"><b>', $context['aeva_total_results'], '</b> ', $txt['aeva_search_results_for'], ' <b>', $context['aeva_searching_for'], '</b></div>';

	if (!empty($context['aeva_foxy_rendered_search']))
		echo $context['aeva_foxy_rendered_search'];
	else
		echo $context['aeva_page_index'], '
	<div id="search_items">',
	aeva_listItems($context['aeva_items']), '
	</div>', $context['aeva_page_index'], $context['is_smf2'] ? '
	<div class="clear"></div>' : '
	<br style="clear: both" />';
}

function template_aeva_viewUserAlbums()
{
	global $txt, $context, $scripturl, $galurl, $amSettings, $settings;

	// The Albums!
	echo '
	<div id="aeva_toplinks" class="cat_bar">
		<h3 class="catbg">
			<img src="'.$settings['images_aeva'].'/house.png" alt="" style="vertical-align: -3px" /> <b><a href="'.$galurl.'">'.$txt['aeva_home'].'</a></b> -
			<img src="'.$settings['images_aeva'].'/album.png" alt="" style="vertical-align: -3px" /> <b>'.$txt['aeva_albums'].'</b>', $context['aeva_foxy'] ? ' -
			<img src="'.$settings['images_aeva'].'/playlist.png" alt="" style="vertical-align: -3px" /> <b><a href="'.$galurl.'sa=playlists">'.$txt['aeva_playlists'].'</a></b>' : '', '
		</h3>
	</div>';

	$colspan = (isset($amSettings['album_columns']) ? max(1, (int) $amSettings['album_columns']) : 1) * 2;
	echo '
	<div class="pagelinks" style="padding: 0">', $txt['aeva_pages'], ': ', $context['aeva_page_index'], '</div>';

	$can_rss = $context['aeva_foxy'] && function_exists('aeva_foxy_rss');
	foreach ($context['aeva_user_albums'] as $id => $album)
	{
		$first = current($album);
		echo '
	<div class="title_bar cat_heading">
		<h3 class="titlebg">', empty($first['owner']['id']) ? '' : $txt['aeva_owner'] . ': ' . aeva_profile($id, $first['owner']['name']), $can_rss ?
		' <a href="' . $galurl . 'sa=rss;user=' . $id . ';albums"><img src="' . $settings['images_aeva'] . '/rss.png" alt="RSS" class="aeva_vera" /></a>' : '', '</h3>
	</div>';

		aeva_listChildren($album);
	}
	echo '
	<div class="pagelinks">', $txt['aeva_pages'], ': ', $context['aeva_page_index'], '</div>';
}

function template_aeva_album_cp()
{
	global $txt, $scripturl, $galurl, $context, $settings, $alburl, $user_info;

	echo '
		<table cellpadding="6" cellspacing="1" border="0" width="100%" class="bordercolor">
			<tr class="titlebg">
				<td width="2%">&nbsp;</td>
				<td width="15%">', $txt['aeva_owner'], '</td>
				<td width="55%">', $txt['aeva_name'], '</td>
				<td width="28%">', $txt['aeva_admin_moderation'], '</td>
			</tr>', !empty($context['aeva_my_albums']) ? '
			<tr class="windowbg2">
				<td colspan="4"><a href="javascript:admin_toggle_all();">' . $txt['aeva_toggle_all'] . '</a></td>
			</tr>' : '';

	if ($context['aeva_moving'] !== false)
		echo '
			<tr class="windowbg3">
				<td colspan="4">', $txt['aeva_admin_moving_album'], ': ', $context['aeva_my_albums'][$context['aeva_moving']]['name'], ' <a href="', rtrim($alburl, ';'), '">[', $txt['aeva_admin_cancel_moving'], ']</a></td>
			</tr>';

	$can_manage = aeva_allowedTo('manage');
	$can_moderate = aeva_allowedTo('moderate');
	foreach ($context['aeva_my_albums'] as $album)
	{
		echo '
			<tr class="windowbg', $album['featured'] ? '' : '2', '">
				<td><a href="javascript:admin_toggle('.$album['id'].', true);"><img alt="" src="', $settings['images_url'], '/expand.gif" id="toggle_img_', $album['id'], '" /></a></td>
				<td>', !empty($album['owner']['id']) ? $album['owner']['name'] : '', '</td>
				<td', !$album['approved'] ? ' class="unapp"' : '', ' style="padding-left: ', 5 + 30 * $album['child_level'], 'px',
				$context['aeva_moving'] !== false && ($context['aeva_moving'] == $album['id'] || $context['aeva_moving'] == $album['parent']) ? '; font-weight: bold' : '', '">';

		$show_move = $context['aeva_moving'] !== false && $context['aeva_moving'] != $album['id'] && $context['aeva_moving'] != $album['parent'];
		if ($show_move)
			echo '
				', $album['move_links']['before'], '
				', $album['move_links']['after'];

		if (!empty($album['featured']))
			echo '
				<img alt="" src="', $settings['images_aeva'], '/star.gif" title="', $txt['aeva_featured_album'], '" />';

		echo '
				<a href="', $galurl, 'sa=album;in=', $album['id'], '">', $album['name'], '</a>', $show_move ? '
				' . $album['move_links']['child_of'] : '', '
				</td>
				<td class="text_margins" style="white-space: nowrap">';

		if ($can_manage || $album['owner']['id'] == $user_info['id'])
			echo '
					<img alt="" src="', $settings['images_aeva'], '/folder_edit.png" title="', $txt['aeva_admin_edit'], '" />&nbsp;<a href="', $alburl, 'sa=edit;in=', $album['id'], '">'.$txt['aeva_admin_edit'].'</a>
					<img alt="" src="', $settings['images_aeva'], '/folder_delete.png" title="', $txt['aeva_admin_delete'], '" />&nbsp;<a href="', $alburl, 'sa=delete;in=', $album['id'], '" onclick="return confirm(\'', $txt['aeva_admin_album_confirm'], '\');">'.$txt['aeva_admin_delete'].'</a>
					<img alt="" src="', $settings['images_aeva'], '/arrow_inout.png" title="', $txt['aeva_admin_move'], '" />&nbsp;<a href="' . $alburl . 'move='.$album['id'] . '">' . $txt['aeva_admin_move'] . '</a>', $album['approved'] == 0 && $can_moderate ? '
					<img alt="" src="'.$settings['images_aeva'].'/tick.png" title="'.$txt['aeva_admin_approve'].'" />&nbsp;<a href="'.$scripturl.'?action=media;area=moderate;sa=submissions;do=approve;type=albums;in='.$album['id'].'">'.$txt['aeva_admin_approve'].'</a>' : '';

		echo '
				</td>
			</tr>
			<tr class="windowbg" style="display: none" id="tr_expand_', $album['id'], '">
				<td colspan="4">
					<img alt="" src="" id="img_', $album['id'], '" style="float: left; margin-right: 8px" />
					<div>', $txt['aeva_items'], ': ', $album['num_items'], '</div>', !empty($album['description']) ? '
					<div>' . $txt['aeva_add_desc'] . ': ' . $album['description'] . '</div>' : '', !empty($album['owner']['id']) ? '
					<div>' . $txt['aeva_owner'] . ': ' . aeva_profile($album['owner']['id'], $album['owner']['name']) . '</div>' : '';

		echo '
				</td>
			</tr>';
	}
	echo '
		</table>';
}

function template_aeva_stats()
{
	global $txt, $galurl, $context, $scripturl, $settings;

	$stats = $context['aeva_stats'];

	// Show the general stats
	echo '
		<table cellpadding="4" cellspacing="1" width="100%" border="0" class="bordercolor" style="margin-top: 10px">
			<tr>
				<td class="titlebg2" colspan="2" align="center"><img alt="" src="', $settings['images_aeva'], '/chart_pie.png" class="vam" /> ', $txt['aeva_gen_stats'], '</td>
			</tr>
			<tr>
				<td width="50%" class="windowbg2">
					<table cellpadding="4" cellspacing="0" width="100%">
						<tr>
							<td><img alt="" src="', $settings['images_aeva'], '/images.png" class="vam" /> ', $txt['aeva_total_items'], '</td>
							<td align="right">', $stats['total_items'], '</td>
						</tr>
						<tr>
							<td><img alt="" src="', $settings['images_aeva'], '/comments.png" class="vam" /> ', $txt['aeva_total_comments'], '</td>
							<td align="right">', $stats['total_comments'], '</td>
						</tr>
						<tr>
							<td><img alt="" src="', $settings['images_aeva'], '/folder_image.png" class="vam" /> ', $txt['aeva_total_albums'], '</td>
							<td align="right">', $stats['total_albums'], '</td>
						</tr>
						<tr>
							<td><img alt="" src="', $settings['images_aeva'], '/group.png" class="vam" /> ', $txt['aeva_total_featured_albums'], '</td>
							<td align="right">', $stats['total_featured_albums'], '</td>
						</tr>
					</table>
				</td>
				<td class="windowbg2">
					<table cellpadding="4" cellspacing="0" width="100%">
						<tr>
							<td><img alt="" src="', $settings['images_aeva'], '/images.png" class="vam" /> ', $txt['aeva_avg_items'], '</td>
							<td align="right">', $stats['avg_items'], '</td>
						</tr>
						<tr>
							<td><img alt="" src="', $settings['images_aeva'], '/comments.png" class="vam" /> ', $txt['aeva_avg_comments'], '</td>
							<td align="right">', $stats['avg_comments'], '</td>
						</tr>
						<tr>
							<td><img alt="" src="', $settings['images_aeva'], '/user.png" class="vam" /> ', $txt['aeva_total_item_contributors'], '</td>
							<td align="right">', $stats['total_item_posters'], '</td>
						</tr>
						<tr>
							<td><img alt="" src="', $settings['images_aeva'], '/user_comment.png" class="vam" /> ', $txt['aeva_total_commentators'], '</td>
							<td align="right">', $stats['total_commentators'], '</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="titlebg" width="50%" align="center"><img alt="" src="', $settings['images_aeva'], '/user.png" class="vam" /> ', $txt['aeva_top_uploaders'], '</td>
				<td class="titlebg" align="center"><img alt="" src="', $settings['images_aeva'], '/user_comment.png" class="vam" /> ', $txt['aeva_top_commentators'], '</td>
			</tr>
			<tr>
				<td valign="top" class="windowbg2">
					<table cellpadding="4" cellspacing="0" width="100%">';

	foreach ($stats['top_uploaders'] as $uploader)
		echo '
						<tr>
							<td align="left" width="60%">', aeva_profile($uploader['id'], $uploader['name']), '</td>
							<td width="20%"><div class="aeva_statsbar2" style="width: ', $uploader['percent'], 'px;"></div></td>
							<td align="right">', $uploader['total_items'], '</td>
						</tr>';

	if (empty($stats['top_uploaders']))
		echo '
						<tr>
							<td align="center">', $txt['aeva_no_uploaders'], '</td>
						</tr>';
	echo '
					</table>
				</td>
				<td valign="top" class="windowbg2">
					<table cellpadding="4" cellspacing="0" width="100%">';

	foreach ($stats['top_commentators'] as $uploader)
		echo '
						<tr>
							<td align="left" width="60%">', aeva_profile($uploader['id'], $uploader['name']), '</td>
							<td width="20%"><div class="aeva_statsbar" style="width: ', $uploader['percent'], 'px;"></div></td>
							<td align="right">', $uploader['total_comments'], '</td>
						</tr>';

	if (empty($stats['top_commentators']))
		echo '
						<tr>
							<td align="center">', $txt['aeva_no_commentators'], '</td>
						</tr>';

	echo '
					</table>
				</td>
			</tr>
			<tr>
				<td class="titlebg" width="50%" align="center"><img alt="" src="', $settings['images_aeva'], '/folder_image.png" class="vam" /> ', $txt['aeva_top_albums_items'], '</td>
				<td class="titlebg" align="center"><img alt="" src="', $settings['images_aeva'], '/folder_table.png" class="vam" /> ', $txt['aeva_top_albums_comments'], '</td>
			</tr>
			<tr>
				<td valign="top" class="windowbg2">
					<table cellpadding="4" cellspacing="0" width="100%">';

	foreach ($stats['top_albums_items'] as $album)
		echo '
						<tr>
							<td align="left" width="60%"><a href="', $galurl, 'sa=album;in=', $album['id'], '">', $album['name'], '</a></td>
							<td width="20%"><div class="aeva_statsbar" style="width: ', $album['percent'], 'px;"></div></td>
							<td align="right">', $album['num_items'], '</td>
						</tr>';

	if (empty($stats['top_albums_items']))
		echo '
						<tr>
							<td align="center">', $txt['aeva_no_albums'], '</td>
						</tr>';

	echo '
					</table>
				</td>
				<td valign="top" class="windowbg2">
					<table cellpadding="4" cellspacing="0" width="100%">';

	foreach ($stats['top_albums_comments'] as $album)
		echo '
						<tr>
							<td align="left" width="60%"><a href="', $galurl, 'sa=album;in=', $album['id'], '">', $album['name'], '</a></td>
							<td width="20%"><div class="aeva_statsbar2" style="width: ', $album['percent'], 'px;"></div></td>
							<td align="right">', $album['num_comments'], '</td>
						</tr>';

	if (empty($stats['top_albums_comments']))
		echo '
						<tr>
							<td align="center">', $txt['aeva_no_albums'], '</td>
						</tr>';

	echo '
					</table>
				</td>
			</tr>
			<tr>
				<td class="titlebg" width="50%" align="center"><img alt="" src="', $settings['images_aeva'], '/images.png" class="vam" /> ', $txt['aeva_top_items_views'], '</td>
				<td class="titlebg" align="center"><img alt="" src="', $settings['images_aeva'], '/comments.png" class="vam" /> ', $txt['aeva_top_items_comments'], '</td>
			</tr>
			<tr>
				<td valign="top" class="windowbg2">
					<table cellpadding="4" cellspacing="0" width="100%">';

	foreach ($stats['top_items_views'] as $item)
		echo '
						<tr>
							<td align="left" width="60%"><a href="', $galurl, 'sa=item;in=', $item['id'], '">', $item['title'], '</a></td>
							<td width="20%"><div class="aeva_statsbar2" style="width: ', $item['percent'], 'px;"></div></td>
							<td align="right">', $item['views'], '</td>
						</tr>';

	if (empty($stats['top_items_views']))
		echo '
						<tr>
							<td align="center">', $txt['aeva_no_items'], '</td>
						</tr>';

	echo '
					</table>
				</td>
				<td valign="top" class="windowbg2">
					<table cellpadding="4" cellspacing="0" width="100%">';

	foreach ($stats['top_items_com'] as $item)
		echo '
						<tr>
							<td align="left" width="60%"><a href="', $galurl, 'sa=item;in=', $item['id'], '">', $item['title'], '</a></td>
							<td width="20%"><div class="aeva_statsbar" style="width: ', $item['percent'], 'px;"></div></td>
							<td align="right">', $item['num_com'], '</td>
						</tr>';

	if (empty($stats['top_items_com']))
		echo '
						<tr>
							<td align="center">', $txt['aeva_no_items'], '</td>
						</tr>';

	echo '
					</table>
				</td>
			</tr>
			<tr>
				<td class="titlebg" width="50%" align="center"><img alt="" src="', $settings['images_aeva'], '/chart_pie.png" class="vam" /> ', $txt['aeva_top_items_rating'], '</td>
				<td class="titlebg" align="center"><img alt="" src="', $settings['images_aeva'], '/star.gif" class="vam" /> ', $txt['aeva_top_items_voters'], '</td>
			</tr>
			<tr>
				<td valign="top" class="windowbg2">
					<table cellpadding="4" cellspacing="0" width="100%">';

	foreach ($stats['top_items_rating'] as $item)
		echo '
						<tr>
							<td align="left" width="60%"><a href="', $galurl, 'sa=item;in=', $item['id'], '">', $item['title'], '</a></td>
							<td width="20%"><div class="aeva_statsbar" style="width: ', $item['percent'], 'px;"></div></td>
							<td align="right">', $item['rating'], '</td>
						</tr>';

	if (empty($stats['top_items_rating']))
		echo '
						<tr>
							<td align="center">', $txt['aeva_no_items'], '</td>
						</tr>';
	echo '
					</table>
				</td>
				<td valign="top" class="windowbg2">
					<table cellpadding="4" cellspacing="0" width="100%">';

	foreach ($stats['top_items_voters'] as $item)
		echo '
						<tr>
							<td align="left" width="60%"><a href="', $galurl, 'sa=item;in=', $item['id'], '">', $item['title'], '</a></td>
							<td width="20%"><div class="aeva_statsbar2" style="width: ', $item['percent'], 'px;"></div></td>
							<td align="right">', $item['voters'], '</td>
						</tr>';

	if (empty($stats['top_items_voters']))
		echo '
						<tr>
							<td align="center">', $txt['aeva_no_items'], '</td>
						</tr>';
	echo '
					</table>
				</td>
			</tr>
		</table>';
}

function template_aeva_below()
{
	if (!isset($_REQUEST['noh']))
		echo '<div class="smalltext" style="margin-top: 20px" align="center">', aeva_copyright(), '</div>';
}

function template_aeva_admin_submissions()
{
	global $context, $txt, $scripturl, $galurl, $settings, $amSettings;

	$filter = $context['aeva_filter'];

	// Show some extra info
	echo '
		<form action="', $galurl, 'area=moderate;sa=submissions;type=', $filter, '" method="post">
			<table cellpadding="6" cellspacing="1" border="0" width="100%" class="bordercolor">
				<tr class="windowbg2">
					<td>', $txt['aeva_admin_total_submissions'], ': ', $context['aeva_total'], '</td>
				</tr>
				<tr class="windowbg2">
					<td>', $txt['aeva_pages'], ': ', $context['aeva_page_index'], '</td>
				</tr>
			</table>';

	// Show the actual submissions
	echo '
			<table cellpadding="6" cellspacing="1" border="0" width="100%" class="bordercolor" id="approvals">
				<tr class="titlebg">
					<td width="2%">&nbsp;</td>
					<td>', $txt['aeva_name'], '</td>
					<td>', $txt['aeva_posted_by'], '</td>
					<td>', $txt['aeva_admin_moderation'], '</td>', $filter != 'albums' ? '
					<td>' . $txt['aeva_posted_on'] . '</td>' : '', '
					<td width="4%"><input type="checkbox" name="checkAll" id="checkAll" onclick="invertAll(this, this.form, \'items[]\');" /></td>
				</tr>', !empty($context['aeva_item']) ? '
				<tr class="windowbg2">
					<td colspan="' . ($filter == 'albums' ? 5 : 6) . '"><a href="javascript:admin_toggle_all();">' . $txt['aeva_toggle_all'] . '</a></td>
				</tr>' : '';
	$alt = false;
	foreach ($context['aeva_items'] as $item)
	{
		echo '
				<tr class="windowbg', $alt ? '2' : '', '" id="' . $item['id'] . '">
					<td><a href="javascript:admin_toggle('.$item['id'].', false);"><img alt="" src="', $settings['images_url'], '/expand.gif" id="toggle_img_', $item['id'], '" /></a></td>
					<td><a href="', $item['item_link'], '">', $item['title'], '</a></td>
					<td>', $item['poster'], '</td>
					<td><img alt="" src="'.$settings['images_aeva'].'/tick.png" title="'.$txt['aeva_admin_approve'].'" /> <a href="javascript:doSubAction(\'', $scripturl, '?action=media;area=moderate;sa=submissions;do=approve;in=', $item['id'], ';type=', $filter, ';' . $context['session_var'] . '=', $context['session_id'], ';xml\');">'.$txt['aeva_admin_approve'].'</a>
						<img alt="" src="'.$settings['images_aeva'].'/folder_edit.png" title="'.$txt['aeva_admin_edit'].'" /> <a href="', $item['edit_link'], '">'.$txt['aeva_admin_edit'].'</a>
						<img alt="" src="'.$settings['images_aeva'].'/folder_delete.png" title="'.$txt['aeva_admin_delete'].'" /> <a href="javascript:doSubAction(\'', $item['del_link'], ';xml\');" onclick="return confirm(\'', $txt['aeva_confirm'], '\');">'.$txt['aeva_admin_delete'].'</a>
						', $filter == 'items' ? '<a href="'. $galurl .'sa=media;in='.$item['id'].';preview"' . ($amSettings['use_lightbox'] ? ' class="hs" onclick="return hs.expand(this);"' : '') . '><img src="'.$settings['images_aeva'].'/magnifier.png" alt="view" /> '.$txt['aeva_admin_view_image'].'</a>' : '', '
					</td>', $filter != 'albums' ? '
					<td>' . $item['posted_on'] . '</td>' : '', '
					<td><input type="checkbox" name="items[]" value="', $item['id'], '" id="items[]" /></td>
				</tr>
				<tr id="tr_expand_' . $item['id'] . '" class="windowbg', $alt ? '2' : '', '" style="display: none">
					<td colspan="', $filter == 'albums' ? 4 : 5, '">
						', !empty($item['description']) ? '<div>' . $txt['aeva_add_desc'] .' : '. $item['description'] . '</div>' : '',
						!empty($item['keywords']) ? '<div>'.$txt['aeva_keywords'].' : ' . $item['keywords'] . '</div>' : '', '
					</td>
				</tr>';
		$alt = !$alt;
	}

	echo '
				<tr class="windowbg', $alt ? '' : '2', '">
					<td colspan="', $filter == 'albums' ? 5 : 6, '" align="right">
						', $txt['aeva_admin_wselected'], ' :
						<select name="do">
							<option value="approve">', $txt['aeva_admin_approve'], '</option>
							<option value="delete">', $txt['aeva_admin_delete'], '</option>
						</select>&nbsp;
						<input type="submit" name="submit_aeva" value="', $txt['aeva_submit'], '" />
					</td>
				</tr>
			</table>
		</form>';
}

// Maintenance homepage
function template_aeva_admin_maintenance()
{
	global $txt, $context;

	// Maintenance headers
	if ($context['aeva_maintenance_done'] !== false)
	{
		if ($context['aeva_maintenance_done'] === true)
			$color = 'green';
		elseif ($context['aeva_maintenance_done'] == 'pending')
			$color = 'orange';
		else
			$color = 'red';

		echo '<div class="windowbg2" style="border: 1px dashed '.$color.'; color: '.$color.'; padding: 1ex 2ex; margin: 1ex">', !empty($context['aeva_maintenance_message']) ? $context['aeva_maintenance_message'] : $txt['aeva_maintenance_done'], '</div>';
	}

	echo '
		<table cellpadding="6" cellspacing="1" border="0" width="100%" class="bordercolor">';

	foreach ($context['aeva_dos'] as $type => $contents)
	{
		echo '
			<tr>
				<td class="titlebg">', $txt['aeva_admin_maintenance_' . $type], '</td>
			</tr>
			<tr class="windowbg2">
				<td>
					<ul style="margin: 0">';

		$count = count($contents);
		foreach ($contents as $counter => $task)
		{
			echo '
						<li>
							<a href="', $task['href'], '">', $task['title'], '</a>', !empty($task['subtext']) ? '<div class="mg_subtext">' . $task['subtext'] . '</div>' : '';
			if ($count > $counter + 1)
				echo '
							<hr />';
			echo '
						</li>';
		}

		echo '
					</ul>
				</td>
			</tr>';
	}

	echo '
		</table>';
}

// Prune page template
function template_aeva_admin_maintenance_prune()
{
	global $context, $scripturl, $txt;

	echo '
		<form action="', $scripturl, '?action=admin;area=aeva_maintenance;sa=prune;', $context['session_var'], '=', $context['session_id'], '" method="post">
			<table cellpadding="6" cellspacing="0" border="0" class="tborder" width="100%">
				<tr>
					<td class="titlebg">', $txt['aeva_pruning'], '</td>
				</tr>
				<tr>
					<td class="windowbg2">
						<label for="pr1"><input type="radio" id="pr1" name="pruning" value="item" onclick="admin_prune_toggle(\'item\',\'com\');" checked="checked" /> ', $txt['aeva_items'], '</label><br />
						<label for="pr2"><input type="radio" id="pr2" name="pruning" value="comments" onclick="admin_prune_toggle(\'com\', \'item\');" /> ', $txt['aeva_comments'], '</label>
					</td>
				</tr>
				<tr id="item_prune_opts">
					<td style="padding: 0; margin: 0; border: 0">
						<table cellpadding="6" cellspacing="0" border="0" class="tborder" width="100%">
							<tr class="catbg">
								<td height="25">', $txt['aeva_items'], '</td>
							</tr>
							<tr class="windowbg2">
								<td><div class="mg_subtext">', $txt['aeva_admin_maintenance_prune_item_help'], '</div></td>
							</tr>
							<tr class="windowbg2">
								<td><input type="text" size="4" name="days" value="60" /> ', $txt['aeva_admin_maintenance_prune_days'], '</td>
							</tr>
							<tr class="windowbg2">
								<td><hr /></td>
							</tr>
							<tr class="windowbg2">
								<td>', $txt['aeva_admin_maintenance_prune_max_views'], ' <input type="text" size="4" name="max_views" /></td>
							</tr>
							<tr class="windowbg2">
								<td>', $txt['aeva_admin_maintenance_prune_max_coms'], ' <input type="text" size="4" name="max_coms" /></td>
							</tr>
							<tr class="windowbg2">
								<td>', $txt['aeva_admin_maintenance_prune_last_comment_age'], ' <input type="text" size="4" name="last_comment_age" /> ', isset($txt['days_word']) ? $txt['days_word'] : $txt[579], '</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr id="com_prune_opts" style="display: none">
					<td style="padding: 0; margin: 0; border: 0">
						<table cellpadding="6" cellspacing="0" border="0" class="tborder" width="100%">
							<tr class="catbg">
								<td height="25">', $txt['aeva_comments'], '</td>
							</tr>
							<tr class="windowbg2">
								<td><div class="mg_subtext">', $txt['aeva_admin_maintenance_prune_com_help'], '</div></td>
							</tr>
							<tr class="windowbg2">
								<td><input type="text" size="4" name="days_com" value="60" /> ', $txt['aeva_admin_maintenance_prune_days'], '</td>
							</tr>
						</table>
					</td>
				</tr>';

	if (!empty($context['aeva_album_list']))
	{
		echo '
				<tr class="catbg">
					<td height="25">', $txt['aeva_albums'], '</td>
				</tr>
				<tr>
					<td class="windowbg2"><input type="checkbox" name="all_albums" /> ', $txt['aeva_all_albums'], '</td>
				</tr>
				<tr>
					<td class="windowbg2">
						<select name="albums[]" multiple="multiple" size="9">';

		foreach ($context['aeva_album_list'] as $list)
			echo '
							<option value="', $list, '">&nbsp;', str_repeat('&#150;', $context['aeva_albums'][$list]['child_level']), $context['aeva_albums'][$list]['child_level'] ? ' ' : '', $context['aeva_albums'][$list]['name'], '&nbsp;</option>';

		echo '
						</select>
					</td>
				</tr>';
	}
	elseif (!empty($context['aeva_maintain_album']))
		echo '
				<tr style="display: none"><td><input type="hidden" name="albums[]" value="' . $context['aeva_maintain_album'] . '" /></td></tr>';

	echo '
				<tr>
					<td class="windowbg2" align="center"><input type="submit" value="', $txt['aeva_submit'], '" name="submit_aeva" onclick="return confirm(\'', $txt['aeva_confirm'], '\');" /></td>
				</tr>
			</table>
		</form>';
}

function template_aeva_admin_modlog()
{
	global $context, $scripturl, $galurl, $txt;

	echo '
	<form action="', $galurl, 'area=moderate;sa=modlog;', $context['session_var'], '=', $context['session_id'], '" method="post">
		<table cellpadding="6" cellspacing="0" border="0" class="bordercolor" width="100%">', !empty($context['aeva_logs']) ? '
			<tr>
				<td class="windowbg2" align="right">
					<input type="submit" name="delete" value="'.$txt['aeva_admin_rm_selected'].'" style="margin-right: 10px" onclick="return confirm(\''.$txt['aeva_confirm'].'\');" /><input type="submit" name="delete_all" value="'.$txt['aeva_admin_rm_all'].'" style="margin-right: 10px" onclick="return confirm(\''.$txt['aeva_confirm'].'\');" />
				</td>
			</tr>' : '', '
			<tr>
				<td class="catbg">
					', $txt['aeva_pages'], ': ', $context['aeva_page_index'], '
				</td>
			</tr>
		</table>
		<table cellpadding="6" cellspacing="0" border="0" class="bordercolor" width="100%">
			<tr>
				<td class="titlebg" width="5%">&nbsp;</td>
				<td class="titlebg">', $txt['aeva_action'], '</td>
				<td class="titlebg">', $txt['aeva_time'], '</td>
				<td class="titlebg">', $txt['aeva_member'], '</td>
			</tr>';

	foreach ($context['aeva_logs'] as $log)
	{
		echo '
			<tr class="windowbg2">
				<td valign="middle" width="5%"><input type="checkbox" name="to_delete[]" value="'.$log['id'].'" /></td>
				<td class="smalltext">', $log['text'], '</td>
				<td class="smalltext">', $log['time'], '</td>
				<td class="smalltext"><a href="'.$log['action_by_href'].'">'.$log['action_by_name'].'</a></td>
			</tr>';
	}

	echo '
			<tr>
		</table>
	</form>
	<form action="', $galurl, 'area=moderate;sa=modlog;', $context['session_var'], '=', $context['session_id'], '" method="post">
		<table cellpadding="10" cellspacing="0" border="0" class="bordercolor" width="100%">
			<tr class="titlebg">
				<td>
					', $txt['aeva_admin_modlog_qsearch'], ' : <input type="text" name="qsearch_mem" size="15" /> <input type="submit" name="qsearch_go" value="', $txt['aeva_submit'], '" />
				</td>
			</tr>
		</table>
	</form>';
}

function template_aeva_admin_reports()
{
	// Shows the reports page
	global $galurl, $scripturl, $context, $txt, $settings, $amSettings;

	echo '

		<table cellpadding="6" cellspacing="1" border="0" width="100%" class="bordercolor">
			<tr class="titlebg">
				<td width="2%">&nbsp;</td>
				<td>', $txt['aeva_admin_reported_item'], '</td>
				<td>', $txt['aeva_admin_reported_by'], '</td>
				<td>', $txt['aeva_admin_reported_on'], '</td>
				<td>', $txt['aeva_admin_moderation'], '</td>
			</tr>', !empty($context['aeva_reports']) ? '
			<tr class="windowbg2">
				<td colspan="5"><a href="javascript:admin_toggle_all();">' . $txt['aeva_toggle_all'] . '</a></td>
			</tr>' : '';

	foreach ($context['aeva_reports'] as $report)
	{
		echo '
			<tr class="windowbg2">
				<td><a href="javascript:admin_toggle('.$report['id_report'].');"><img alt="" src="', $settings['images_url'], '/expand.gif" id="toggle_img_'.$report['id_report'].'" /></a></td>
				<td><a href="', $galurl, 'sa=item;in='.($context['aeva_report_type'] == 'comment' ? $report['id2'].'#com'.$report['id'] : $report['id']).'">'.$report['title'].'</a></td>
				<td>', aeva_profile($report['reported_by']['id'], $report['reported_by']['name']), '</td>
				<td>', $report['reported_on'], '</td>
				<td><a href="', $scripturl, '?action=media;area=moderate;sa=reports;do=delete;items;in=', $report['id_report'], ';' . $context['session_var'] . '=', $context['session_id'], '">', $txt['aeva_admin_del_report'], '</a>
				<br /><a href="', $scripturl, '?action=media;area=moderate;sa=reports;items;do=deleteitem;in=', $report['id_report'], ';' . $context['session_var'] . '=', $context['session_id'], '" onclick="return confirm(\'' . $txt['quickmod_confirm'] . '\');">', $txt['aeva_admin_del_report_item'], '</a></td>
			</tr>
			<tr class="windowbg" id="tr_expand_'.$report['id_report'].'" style="display: none">
				<td colspan="5">
					', $txt['aeva_posted_by'], ': ', aeva_profile($report['posted_by']['id'], $report['posted_by']['name']), '<br />
					', $txt['aeva_posted_on'], ': ', $report['posted_on'], '<br />
					', $txt['aeva_admin_report_reason'], ': ', $report['reason'], '
				</td>
			</tr>';
	}

	echo '
		</table>';
}

// The main ban page
function template_aeva_admin_bans()
{
	global $txt, $scripturl, $context;

	echo '

		<table cellpadding="6" cellspacing="1" border="0" width="100%" class="bordercolor">
			<tr class="titlebg">
				<td>', $txt['aeva_admin_banned'], '</td>
				<td>', $txt['aeva_admin_banned_on'], '</td>
				<td>', $txt['aeva_admin_expires_on'], '</td>
				<td>', $txt['aeva_admin_ban_type'], '</td>
				<td>', $txt['aeva_admin_moderation'], '</td>
			</tr>
			<tr class="windowbg2">
				<td colspan="5">', $txt['aeva_pages'], ': ', $context['aeva_page_index'], '</td>
			</tr>';

	foreach ($context['aeva_bans'] as $ban)
	{
		echo '
			<tr class="windowbg2">
				<td>', aeva_profile($ban['banned']['id'], $ban['banned']['name']), '</td>
				<td>', $ban['banned_on'], '</td>
				<td>', $ban['expires_on'], '</td>
				<td>', $ban['type_txt'], '</td>
				<td><a href="', $scripturl, '?action=admin;area=aeva_bans;sa=edit;in=', $ban['id'], ';' . $context['session_var'] . '=', $context['session_id'], '">', $txt['aeva_admin_edit'], '</a>/<a href="', $scripturl, '?action=admin;area=aeva_bans;sa=delete;in=', $ban['id'], ';' . $context['session_var'] . '=', $context['session_id'], '">', $txt['aeva_admin_delete'], '</a></td>
			</tr>';
	}

	echo '
		</table>';
}

// The admin "about" page
function template_aeva_admin_about()
{
	global $txt, $scripturl, $context, $amSettings;

	if (!empty($context['aeva_readme_file']))
	{
		echo '
		<div class="windowbg2" style="margin-top: 8px">
			<span class="topslice"><span></span></span>
			<div class="readme">
				', $context['aeva_readme_file'], '
			</div>
			<span class="botslice"><span></span></span>
		</div>';
		return;
	}

	echo '
		<table cellpadding="6" cellspacing="1" border="0" width="100%" class="bordercolor"', $context['is_smf2'] ? ' style="margin-top: 1ex"' : '', '>
			<tr class="titlebg">
				<td>', $txt['aeva_admin_credits'], ' <span class="smalltext" style="font-weight: normal">~ ', $txt['aeva_admin_credits_thanks'], '</span></td>
			</tr>';

	foreach ($context['aeva_credits'] as $credit)
		echo '
			<tr class="windowbg2">
				<td>', $credit['name'], !empty($credit['nickname']) ? ' ' . $txt['aeva_aka'] . ' ' . $credit['nickname'] : '', !empty($credit['site']) ? ' - <a href="' . $credit['site'] . '">' . $credit['site'] . '</a>' : '', ' - ', $credit['position'], '</td>
			</tr>';

	echo '
		</table>

		<table border="0" width="100%" style="margin-top: 8px">
			<tr><td valign="top">
				<table cellpadding="0" cellspacing="1" border="0" width="100%" class="bordercolor">
					<tr><td class="catbg" style="padding: 6px" align="center">', $txt['aeva_admin_about_header'], '</td></tr>
					<tr><td height="207">
						<table cellpadding="3" cellspacing="1" border="0" width="100%" class="windowbg" height="172">
							<tr>
								<td class="windowbg" width="50%">', $txt['aeva_admin_smf_ver'], ': ', $context['aeva_data']['smf'], '</td>
								<td class="windowbg" width="50%">', $txt['aeva_admin_php_ver'], ': ', $context['aeva_data']['php'], '</td>
							</tr>
							<tr>
								<td colspan="2" class="windowbg">', $txt['aeva_admin_safe_mode' . ($context['aeva_data']['safe_mode'] ? '' : '_none')], '</td>
							</tr>
							<tr>
								<td colspan="2" class="windowbg">', $txt['aeva_admin_ffmpeg'], ': ', $context['aeva_data']['ffmpeg'], '</td>
							</tr>
							<tr>
								<td colspan="2" class="windowbg">', $txt['aeva_gd2'], ': ', $context['aeva_data']['gd'], '</td>
							</tr>
							<tr>
								<td colspan="2" class="windowbg">', $txt['aeva_imagemagick'], ': ', $context['aeva_data']['imagemagick'], '
								(', $txt['aeva_imagick'], ': ', $context['aeva_data']['imagick'], ' -
								', $txt['aeva_MW'], ': ', $context['aeva_data']['magickwand'], ')</td>
							</tr>
							<tr>
								<td colspan="2" class="catbg" align="center">', aeva_copyright(), '</td>
							</tr>
							<tr>
								<td colspan="2" class="windowbg2">', $txt['aeva_admin_installed_on'], ': ', timeformat($amSettings['installed_on']), '</td>
							</tr>
							<tr>
								<td class="windowbg2">', $txt['aeva_version'], ': <span id="curVer">', $amSettings['version'], '</span></td>
								<td class="windowbg2"></td>
							</tr>
						</table>
					</td></tr>
				</table>
			</td></tr>
		</table>

		<table cellpadding="6" cellspacing="1" border="0" width="100%" class="bordercolor" style="margin-top: 8px">
			<tr class="titlebg">
				<td>', $txt['aeva_admin_thanks'], '</td>
			</tr>
			<tr class="windowbg2">
				<td class="smalltext">';

	foreach ($context['aeva_thanks'] as $credit)
		echo '
					', isset($credit['site']) ? '<a href="' . $credit['site'] . '">' . $credit['name'] . '</a>' : $credit['name'], ' - ', $credit['position'], '<br />';

	echo '
				</td>
			</tr>
			<tr class="titlebg">
				<td>', $txt['aeva_admin_about_modd'], '</td>
			</tr>';

	$managers = array();
	$moderators = array();
	if (isset($context['aeva_admins']['managers']))
		foreach ($context['aeva_admins']['managers'] as $m)
			$managers[] = $m['link'];
	if (isset($context['aeva_admins']['moderators']))
		foreach ($context['aeva_admins']['moderators'] as $m)
			$moderators[] = $m['link'];
	echo '
			<tr class="windowbg2">
				<td>
					', !empty($managers) ? '<div>'.$txt['aeva_admin_managers'].': '.implode(', ', $managers).'</div>' : '',
					!empty($moderators) ? '<div>'.$txt['aeva_admin_moderators'].': '.implode(', ', $moderators).'</div>' : '', '
				</td>
			</tr>
		</table>';
}

function template_aeva_text_editor()
{
	global $context, $settings;

	if ($context['is_smf2'] && function_exists('template_control_richedit_buttons'))
		echo '
	<div>', template_control_richedit($context['post_box_name'], 'smileyBox_message', 'bbcBox_message'), '</div>';
	elseif ($context['is_smf2'])
		echo '
	<div>', template_control_richedit($context['post_box_name'], array('bbc', 'smileys', 'message')), '</div>';
	else
		echo '
	<table cellpadding="0" cellspacing="0" border="0">
		', theme_postbox($context['post_box_value']), '
	</table>';
}

function template_aeva_multiUpload_xml()
{
	global $context, $txt;

	// Prepare the items
	$item_array = array();
	foreach ($context['items'] as $item)
		$item_array[] = $item['id'] . ',' . $item['title'];

	// Prepare the errors
	$error_array = array();
	$error_list = array(
		'file_not_found' => 'upload_failed', 'dest_not_found' => 'upload_failed', 'size_too_big' => 'upload_file_too_big',
		'width_bigger' => 'error_width', 'height_bigger' => 'error_height', 'invalid_extension' => 'invalid_extension', 'dest_empty' => 'dest_failed',
	);

	foreach ($context['errors'] as $error)
	{
		$message = isset($error_list[$error['code']]) ? $txt['aeva_' . $error_list[$error['code']]] : $txt['aeva_upload_failed'];
		$error_array[] = $error['fname'] . ' - ' . (isset($error['context']) ? sprintf($message, $error['context']) : $message);
	}

	// Output it
	echo implode(';', $item_array), '|', implode(';', $error_array);
}

function template_aeva_multiUpload()
{
	global $context, $txt, $galurl, $amSettings, $settings, $boardurl;

	echo '
	<table cellpadding="6" cellspacing="0" border="0" width="100%">
		<tr class="titlebg">
			<td>', $txt['aeva_multi_upload'], '</td>
		</tr>
		<tr class="windowbg">
			<td>
				<ul class="normallist">
					<li>', $txt['aeva_max_file_size'], ': ', $txt['aeva_image'], ' - ', $context['aeva_max_file_size']['image'], ' ', $txt['aeva_kb'], ', ', $txt['aeva_video'], ' - ', $context['aeva_max_file_size']['video'], ' ', $txt['aeva_kb'], ', ', $txt['aeva_audio'], ' - ', $context['aeva_max_file_size']['audio'], ' ', $txt['aeva_kb'], ', ', $txt['aeva_doc'], ' - ', $context['aeva_max_file_size']['doc'], ' ', $txt['aeva_kb'], '
					<li>', $txt['aeva_needs_js_flash'], '</li>
				</ul>
			</td>
		</tr>
		<tr class="windowbg2">
			<td>
				', $txt['aeva_add_allowedTypes'], ':
				<ul class="normallist">';

	foreach ($context['allowed_types'] as $k => $v)
		echo '
					<li><b>', $txt['aeva_filetype_'.$k], '</b>: ', str_replace('*.', '', implode(', ', $v)), '</li>';

	echo '
				</ul>
			</td>
		</tr>
		<tr class="windowbg2">
			<td align="center">
				<form action="', $boardurl, '">
					<strong>1</strong>. ', $txt['aeva_sort_order'], ' &ndash;
					<select id="sort_order" name="sort_order">
						<option value="1" selected="selected">', $txt['aeva_sort_order_filename'], '</option>
						<option value="2">', $txt['aeva_sort_order_filedate'], '</option>
						<option value="3">', $txt['aeva_sort_order_filesize'], '</option>
					</select>
				</form>
			</td>
		<tr class="windowbg2">
			<td>
				<form action="', $context['aeva_submit_url'], '" id="upload_form" method="post">
					<div id="mu_container" style="text-align: center">
						<p>
							<strong>2</strong>. <span id="browse" style="position: absolute; z-index: 2"></span>
							<span id="browseBtnSpan" style="z-index: 1"><a id="browseBtn" href="#">', $txt['aeva_selectFiles'], '</a></span> |
							<strong>3</strong>. <a id="upload" href="#">', $txt['aeva_upload'], '</a>
						</p>
						<div>
							<strong id="overall_title" class="overall-title">', $txt['aeva_overall_prog'], '</strong><br />
							<img alt="" src="', $settings['images_aeva'], '/bar.gif" class="progress overall-progress" id="overall_progress" /> <strong id="overall_prog_perc">0%</strong>
						</div>
						<div>
							<strong class="current-title" id="current_title">', $txt['aeva_curr_prog'], '</strong><br />
							<img alt="" src="', $settings['images_aeva'], '/bar.gif" class="progress2 current-progress" id="current_progress" /> <strong id="current_prog_perc">0%</strong>
						</div>
						<div class="current-text" id="current_text"></div>
					</div>
					<div>
						<div>
							<ul id="current_list">
								<li id="remove_me" style="visibility: hidden"></li>
							</ul>
						</div>
						<br style="clear: both;" />
						<div style="text-align: center;" id="mu_items"><input type="submit" name="aeva_submit" value="', $txt['aeva_submit'], '" /></div>
					</div>
				</form>
			</td>
		</tr>
		<tr id="mu_items_tr" style="display: none" class="titlebg">
			<td>', $txt['aeva_errors'], '</td>
		</tr>
		<tr id="mu_items_tr2" style="display: none" class="windowbg2">
			<td id="mu_items_error" style="color: red;">
			</td>
		</tr>
	</table>';
}

function template_aeva_admin_perms()
{
	global $txt, $context, $scripturl, $settings, $smcFunc;

	if ($context['is_smf2'])
		echo '
	<div class="title_bar">
		<h3 class="titlebg"><span title="', $txt['aeva_permissions_help'], '"><img src="', $settings['images_url'], '/helptopics.gif" alt="Help" align="top" /></span> ', $txt['aeva_admin_labels_perms'], '</h3>
	</div>
	<div class="information">
		', $txt['aeva_admin_perms_desc'], '
	</div>';

	echo '

	<form method="post" action="', $context['base_url'], '">
		<table width="75%" align="center" border="0" cellpadding="3" cellspacing="1" class="tborder" style="margin-top: 2ex;">
			<tr class="windowbg2">
				<td colspan="3">', sprintf($txt['aeva_admin_perms_warning'], $scripturl . '?action=admin;' . ($context['is_smf2'] ? 'area=permissions;' . $context['session_var'] : 'sa=permissions;sesc') . '=' . $context['session_id']), '</td>
			</tr>
			<tr class="catbg">
				<td width="50%">', $txt['aeva_admin_prof_name'], '</td>
				<td width="25%">', $txt['aeva_albums'], '</td>
				<td width="25%">', $txt['aeva_delete_this_item'], '</td>
			</tr>';

	$alt = false;
	foreach ($context['aeva_profiles'] as $prof)
	{
		$alt = !$alt;
		echo '
			<tr class="windowbg', $alt ? '2' : '', '">
				<td><a href="', $context['base_url'], ';sa=view;in=', $prof['id'], '">', $prof['name'], '</a></td>
				<td><a href="javascript:getPermAlbums(', $prof['id'], ');">', $prof['albums'], '</a></td>
				<td', !empty($prof['undeletable']) ? ' title="' . $txt['aeva_permissions_undeletable'] . '"' : '', '><input name="delete_prof_', $prof['id'], '" type="checkbox" onclick="return permDelCheck(', $prof['id'], ', this, \'', $txt['aeva_confirm'], '\');"', !empty($prof['undeletable']) ? ' disabled="disabled"' : '', ' /></td>
			</tr>
			<tr class="windowbg', $alt ? '2' : '', '" id="albums_' . $prof['id'] . '" style="display: none">
				<td colspan="3" id="albums_td_' . $prof['id'] . '"></td>
			</tr>';
	}

	echo '
			<tr class="windowbg', $alt ? '' : '2', '">
				<td colspan="2">', $txt['aeva_admin_prof_del_switch'], '<br /><span class="smalltext">', $txt['aeva_admin_prof_del_switch_help'], '</span></td>
				<td>
					<select name="del_prof">
						<option value=""></option>';

	foreach ($context['aeva_profiles'] as $prof)
		echo '
						<option value="', $prof['id'], '">', $prof['name'], '</option>';

	echo '
					</select>
				</td>
			</tr>
			<tr class="windowbg', $alt ? '2' : '', '">
				<td colspan="3" align="right"><input type="submit" name="aeva_delete_profs" value="', $txt['aeva_delete_this_item'], '" /></td>
			</tr>
		</table>
	</form>

	<form method="post" action="', $context['base_url'], ';sa=add">
		<table width="75%" align="center" border="0" cellpadding="3" cellspacing="1" class="tborder" style="margin-top: 2ex;">
			<tr class="titlebg">
				<td>', $txt['aeva_admin_profile_add'], '</td>
			</tr>
			<tr class="windowbg2">
				<td>', $txt['aeva_admin_prof_name'], ' : <input type="text" name="name" /></td>
			</tr>
			<tr class="windowbg">
				<td align="right"><input type="submit" name="submit_aeva" value="', $txt['aeva_admin_create_prof'], '" /></td>
			</tr>
		</table>
	</form>';
}
function template_aeva_admin_perms_view()
{
	global $txt, $context, $scripturl;

	echo '
		<form action="', $context['base_url'], ';sa=quick;profile=', $context['aeva_profile']['id'], '" method="post">
			<table width="75%" align="center" border="0" cellpadding="3" cellspacing="1" class="tborder" style="margin-top: 2ex;">
				<tr class="catbg">
					<td colspan="5">', $txt['aeva_perm_profile'], ' : "', $context['aeva_profile']['name'], '"</td>
				</tr>
				<tr class="titlebg">
					<td width="40%">', $txt['aeva_admin_membergroups'], '</td>
					<td width="20%">', $txt['aeva_admin_members'], '</td>
					<td width="25%">', $txt['aeva_admin_labels_perms'], '</td>
					<td width="10%">', $txt['aeva_edit_this_item'], '</td>
					<td width="5%"><input type="checkbox" name="checkAll" id="checkAll" onclick="invertAll(this, this.form, \'groups[]\');" /></td>
				</tr>';

	$alt = false;
	$membergroup_string = '';
	foreach ($context['membergroups'] as $id => $group)
	{
		$alt = !$alt;
		echo '
				<tr class="windowbg', $alt ? '2' : '', '">
					<td>', $group['name'], '</td>
					<td>', $context['is_smf2'] && $id > 0 ? '<a href="' . $scripturl . '?action=moderate;area=viewgroups;sa=members;group=' . $id . '">' . $group['num_members'] . '</a>' : $group['num_members'], '</td>
					<td>', isset($group['perms']) ? $group['perms'] : 0, '</td>
					<td><a href="', $context['base_url'], ';sa=edit;in=', $context['aeva_profile']['id'], ';group=', $id, '">', $txt['aeva_edit_this_item'], '</a></td>
					<td><input type="checkbox" name="groups[]" value="', $id, '" id="groups[]" /></td>
				</tr>';
		$membergroup_string .= "\n" . '<option value="' . $id . '">' . $group['name'] . '</option>';
	}

	echo '
				<tr class="windowbg', $alt ? '' : '2', '">
					<td colspan="4" align="right" style="margin-top: 2px">
						<div style="margin-bottom: 1ex">', $txt['aeva_admin_wselected'], '</div>
						', $txt['aeva_admin_set_mg_perms'], ' :
							<select name="copy_membergroup">
								<option value=""></option>', $membergroup_string, '
							</select><br /><br />
						<select name="with_selected">
							<option value="apply">', $txt['aeva_admin_apply_perm'], '</option>
							<option value="clear">', $txt['aeva_admin_clear_perm'], '</option>
						</select>&nbsp;
						<select name="selected_perm">
							<option value=""></option>';

	foreach ($context['aeva_album_permissions'] as $perm)
		echo '
							<option value="', $perm, '">', $txt['permissionname_aeva_' . $perm], '</option>';

	echo '
						</select>
					</td>
					<td width="16%" valign="bottom">
						<input type="submit" name="submit" value="', $txt['aeva_submit'], '" />
					</td>
				</tr>
			</table>';
}

// Membergroup quota template
function template_aeva_admin_quotas()
{
	global $txt, $context, $scripturl;

	if ($context['is_smf2'])
		echo '
	<div class="title_bar">
		<h3 class="titlebg">', $txt['aeva_admin_labels_quotas'], '</h3>
	</div>
	<div class="information">
		', $txt['aeva_admin_quotas_desc'], '
	</div>';

	echo '

	<form method="post" action="', $scripturl, '?action=admin;area=aeva_quotas;', $context['session_var'], '=', $context['session_id'], '">
		<table width="75%" align="center" border="0" cellpadding="3" cellspacing="1" class="tborder" style="margin-top: 2ex;">
			<tr class="catbg">
				<td width="50%">', $txt['aeva_admin_prof_name'], '</td>
				<td width="25%">', $txt['aeva_albums'], '</td>
				<td width="25%">', $txt['aeva_delete_this_item'], '</td>
			</tr>';

	$alt = false;
	foreach ($context['aeva_profiles'] as $prof)
	{
		$alt = !$alt;
		echo '
			<tr class="windowbg', $alt ? '2' : '', '">
				<td><a href="', $scripturl, '?action=admin;area=aeva_quotas;sa=view;in=', $prof['id'], ';', $context['session_var'], '=', $context['session_id'], '">', $prof['name'], '</a></td>
				<td><a href="javascript:getPermAlbums(', $prof['id'], ', \';prof=', $prof['id'], ';xml\');">', $prof['albums'], '</a></td>
				<td><input name="delete_prof_', $prof['id'], '" type="checkbox" onclick="return permDelCheck(', $prof['id'], ', this, \'', $txt['aeva_confirm'], '\');"', !empty($prof['undeletable']) ? ' disabled="disabled"' : '', ' /></td>
			</tr>
			<tr class="windowbg', $alt ? '2' : '', '" id="albums_' . $prof['id'] . '" style="display: none">
				<td colspan="3" id="albums_td_' . $prof['id'] . '"></td>
			</tr>';
	}

	if (!empty($context['aeva_profiles']))
	{
		echo '
				<tr class="windowbg', $alt ? '' : '2', '">
					<td colspan="2">', $txt['aeva_admin_prof_del_switch'], '<br /><span class="smalltext">', $txt['aeva_admin_prof_del_switch_help'], '</span></td>
					<td>
						<select name="del_prof">
							<option value=""></option>';
		foreach ($context['aeva_profiles'] as $prof)
			echo '
							<option value="', $prof['id'], '">', $prof['name'], '</option>';
		echo '
						</select>
					</td>
				</tr>
				<tr class="windowbg', $alt ? '2' : '', '">
					<td colspan="3" align="right"><input type="submit" name="aeva_delete_profs" value="', $txt['aeva_delete_this_item'], '" /></td>
				</tr>';
	}

	echo '
		</table>
	</form>';

		echo '
	<form method="post" action="', $scripturl, '?action=admin;area=aeva_quotas;sa=add;', $context['session_var'], '=', $context['session_id'], '">
		<table width="75%" align="center" border="0" cellpadding="3" cellspacing="1" class="tborder" style="margin-top: 2ex;">
			<tr class="titlebg">
				<td>', $txt['aeva_admin_profile_add'], '</td>
			</tr>
			<tr class="windowbg2">
				<td>', $txt['aeva_admin_prof_name'], ' : <input type="text" name="name" /></td>
			</tr>
			<tr class="windowbg">
				<td align="right"><input type="submit" name="submit_aeva" value="', $txt['aeva_admin_create_prof'], '" /></td>
			</tr>
		</table>
	</form>';
}

// Viewing a profile
function template_aeva_admin_quota_view()
{
	global $txt, $context, $scripturl;

	echo '
		<table width="75%" align="center" border="0" cellpadding="3" cellspacing="1" class="tborder" style="margin-top: 2ex;">
			<tr class="catbg">
				<td colspan="4">', $txt['aeva_quota_profile'], ' : "', $context['aeva_profile']['name'], '"</td>
			</tr>
			<tr class="titlebg">
				<td width="65%">', $txt['aeva_admin_membergroups'], '</td>
				<td width="20%">', $txt['aeva_admin_members'], '</td>
				<td width="15%">', $txt['aeva_edit_this_item'], '</td>
			</tr>';
	$alt = false;
	foreach ($context['membergroups'] as $id => $group)
	{
		$alt = !$alt;
		echo '
			<tr class="windowbg', $alt ? '2' : '', '">
				<td>', $group['name'], '</td>
				<td>', $context['is_smf2'] && $id > 0 ? '<a href="' . $scripturl . '?action=moderate;area=viewgroups;sa=members;group=' . $id . '">' . $group['num_members'] . '</a>' : $group['num_members'], '</td>
				<td><a href="', $scripturl, '?action=admin;area=aeva_quotas;sa=edit;in=', $context['aeva_profile']['id'], ';group=', $id, ';', $context['session_var'], '=', $context['session_id'], '">', $txt['aeva_edit_this_item'], '</a></td>
			</tr>';
	}
	echo '
		</table>';
}

// Custom fields template
function template_aeva_admin_fields()
{
	global $txt, $galurl, $scripturl, $context;

	echo '
		<table width="100%" align="center" border="0" cellpadding="3" cellspacing="1" class="bordercolor">
			<tr class="titlebg">
				<td colspan="3">', $txt['aeva_cf'], '</td>
			</tr>
			<tr class="catbg">
				<td width="50%">', $txt['aeva_cf_name'], '</td>
				<td width="25%">', $txt['aeva_cf_type'], '</td>
				<td width="25%">', $txt['aeva_admin_moderation'], '</td>
			</tr>
			<tr class="windowbg2">
				<td colspan="3"><a href="', $scripturl, '?action=admin;area=aeva_fields;sa=edit;', $context['session_var'], '=', $context['session_id'], '">', $txt['aeva_cf_add'], '</a></td>
			</tr>';
	$alt = false;
	foreach ($context['custom_fields'] as $field)
	{
		echo '
			<tr class="windowbg', $alt ? '2' : '', '">
				<td>', $field['name'], '</td>
				<td>', $txt['aeva_cf_' . $field['type']], '</td>
				<td><a href="', $scripturl, '?action=admin;area=aeva_fields;sa=edit;in=', $field['id'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['aeva_edit_this_item'], '</a> / <a href="', $scripturl, '?action=admin;area=aeva_fields;delete=', $field['id'], ';', $context['session_var'], '=', $context['session_id'], '" onclick="return confirm(\'', $txt['aeva_confirm'], '\');">', $txt['aeva_delete_this_item'], '</a></td>
			</tr>';
		$alt = !$alt;
	}
	echo '
		</table>';
}

// Profile summary template
function template_aeva_profile_summary()
{
	global $txt, $galurl, $context, $settings, $scripturl, $user_info, $galurl;

	$member = &$context['aeva_member'];
	$can_rss = $context['aeva_foxy'] && function_exists('aeva_foxy_rss');

	echo '
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="bordercolor">
			<tr>
				<td class="titlebg"><img src="', $settings['images_url'], '/admin/mgallery.png" alt="" border="0" />&nbsp;&nbsp;', $txt['aeva_profile_sum_pt'], '</td>
			</tr>
			<tr>
				<td class="windowbg smalltext" style="padding: 2ex;">', $txt['aeva_profile_sum_desc'], '</td>
			</tr>
			<tr>
				<td class="titlebg">', $txt['aeva_profile_stats'], '</td>
			</tr>
			<tr>
				<td class="windowbg2">
					', $can_rss ? '<a href="' . $galurl . 'sa=rss;user=' . $member['id'] . '"><img src="' . $settings['images_aeva'] . '/rss.png" alt="RSS" class="aeva_vera" /></a>' : '', ' <a href="', $scripturl, '?action=profile;u=', $member['id'], $context['is_smf2'] ? ';area' : ';sa', '=aevaitems">', $txt['aeva_total_items'], '</a>: ', $member['items'], '<br />
					', $can_rss ? '<a href="' . $galurl . 'sa=rss;user=' . $member['id'] . ';type=comments"><img src="' . $settings['images_aeva'] . '/rss.png" alt="RSS" class="aeva_vera" /></a>' : '', ' <a href="', $scripturl, '?action=profile;u=', $member['id'], $context['is_smf2'] ? ';area' : ';sa', '=aevacoms">', $txt['aeva_total_comments'], '</a>: ', $member['coms'], '<br />
					', $txt['aeva_avg_items'], ': ', $member['avg_items'], '<br />
					', $txt['aeva_avg_comments'], ': ', $member['avg_coms'], '<br />
				</td>
			</tr>';

	if (!empty($member['user_albums']))
	{
		$can_moderate = aeva_allowedTo('moderate');

		echo '
			<tr>
				<td class="titlebg">', $txt['aeva_albums'], $can_rss ? ' <a href="' . $galurl . 'sa=rss;user=' . $member['id'] . ';albums"><img src="' . $settings['images_aeva'] . '/rss.png" alt="RSS" class="aeva_vera" /></a>' : '', '</td>
			</tr>
			<tr>
				<td>';

		aeva_listChildren($member['user_albums']);

		echo '
				</td>
			</tr>';
	}

	echo '
		</table>';

	if (!empty($member['recent_items']))
	{
		echo '
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="bordercolor margintop">
			<tr>
				<td class="titlebg">', $txt['aeva_recent_items'], '</td>
			</tr>
		</table>

		<div id="home">
			<div id="recent_items">',
				aeva_listItems($member['recent_items']), '
			</div>
		</div>';
	}

	if (!empty($member['top_albums']))
	{
		echo '
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="bordercolor margintop">
			<tr>
				<td class="titlebg">', $txt['aeva_top_albums'], '</td>
			</tr>
			<tr>
				<td style="padding: 0px;">
					<table cellpadding="6" cellspacing="0" width="100%" border="0">';

		foreach ($member['top_albums'] as $album)
			echo '
						<tr>
							<td class="windowbg2" width="50%"><a href="', $galurl, 'sa=album;in=', $album['id'], '">', $album['name'], '</a></td>
							<td class="windowbg2" width="40%"><div class="aeva_statsbar" style="width: ', $album['percent'], 'px;"></div></td>
							<td class="windowbg2" width="10%">', $album['total_items'], '</td>
						</tr>';

		echo '
					</table>
				</td>
			</tr>
		</table>';
	}
	template_aeva_below();
}

// Template for viewing all items from a single member
function template_aeva_profile_viewitems()
{
	global $context, $txt, $galurl, $settings;

	echo '
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="bordercolor">
			<tr>
				<td class="titlebg"><img src="', $settings['images_url'], '/admin/mgallery.png" alt="" border="0" />&nbsp;&nbsp;', $txt['aeva_profile_viewitems_pt'], '</td>
			</tr>
			<tr>
				<td class="windowbg smalltext" style="padding: 2ex;">', $txt['aeva_profile_viewitems_desc'], '</td>
			</tr>
		</table>

		<div id="home">
			<div class="pagelinks">', $txt['aeva_pages'], ': ', $context['page_index'], '</div>
			<div id="recent_items">',
				aeva_listItems($context['aeva_items']), '
			</div>
			<div class="pagelinks">', $txt['aeva_pages'], ': ', $context['page_index'], '</div>
		</div>';
	template_aeva_below();
}

// Template for viewing all items from a single member
function template_aeva_profile_viewcoms()
{
	global $context, $txt, $settings;

	echo '
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="bordercolor">
			<tr>
				<td class="titlebg"><img src="', $settings['images_url'], '/admin/mgallery.png" alt="" border="0" />&nbsp;&nbsp;', $txt['aeva_profile_viewcoms_pt'], '</td>
			</tr>
			<tr>
				<td class="windowbg smalltext" style="padding: 2ex;">', $txt['aeva_profile_viewcoms_desc'], '</td>
			</tr>
		</table>

		<div class="pagelinks">', $txt['aeva_pages'], ': ', $context['page_index'], '</div>
		<div>';

	// Recent comments!
	if (!empty($context['aeva_coms']))
	{
		foreach ($context['aeva_coms'] as $i)
			echo '
		<div class="smalltext" style="padding: 8px">
			', $txt['aeva_comment_in'], ' <a href="', $i['url'], '"><b>', $i['media_title'], '</a></b> - ',
			$txt['aeva_posted_on' . (is_numeric($i['posted_on'][0]) ? '_date' : '')], ' ', $i['posted_on'], '
			<blockquote class="windowbg comment_preview">', parse_bbc($i['msg']), '</blockquote>
		</div>';
	}

	echo '
		</div>
		<div class="pagelinks">', $txt['aeva_pages'], ': ', $context['page_index'], '</div>';
	template_aeva_below();
}

// Template for viewing all votes from a single member
function template_aeva_profile_viewvotes()
{
	global $context, $txt, $settings, $scripturl, $amFunc;

	echo '
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="bordercolor">
			<tr>
				<td class="titlebg"><img src="', $settings['images_url'], '/admin/mgallery.png" alt="" border="0" />&nbsp;&nbsp;', $txt['aeva_profile_viewvotes_pt'], '</td>
			</tr>
			<tr>
				<td class="windowbg smalltext" style="padding: 2ex;">', $txt['aeva_profile_viewvotes_desc'], '</td>
			</tr>
		</table>

		<div class="pagelinks">', $txt['aeva_pages'], ': ', $context['page_index'], '</div>
		<div style="padding: 4px 0">';

	if (!empty($context['aeva_ratingLogs']))
	{
		echo '<div class="cat_bar"><h3 class="catbg2" style="margin: 8px 0">' . $context['aeva_voter_name'] . '</h3></div>';

		foreach ($context['aeva_ratingLogs'] as $log)
		{
			echo ' <img src="' . $settings['images_aeva'] . '/star' . $log['star'] . '.gif" class="aeva_vera" alt="' . $log['star'] . '" />';
			echo '&nbsp;&nbsp;<b><a href="' . $scripturl . '?action=media;sa=item;in=' . $log['id_media'] . '">' . $log['title'] . '</a></b>';
			echo ' (<a href="' . $scripturl . '?action=media;sa=album;in=' . $log['album_id'] . '">' . $log['name'] . '</a>)';
			if (!empty($log['messages']))
				echo ' (' . $log['messages'] . ' <a href="' . $scripturl . '?topic=' . $log['id_topic'] . '.0">' . $txt['aeva_post' . ($log['messages'] > 1 ? 's' : '') . '_noun'] . '</a>)';
			echo '<br />';
		}
		echo '<br /><div class="cat_bar"><h3 class="catbg">' . $txt['aeva_voter_list'] . '</h3></div>';
		foreach ($context['aeva_otherVoters'] as $row)
			echo '<br /><a href="' . $scripturl . '?action=profile;u=' . $row['id_member'] . ($context['is_smf2'] ? ';area' : ';sa') . '=aevavotes">' . $row['real_name'] . '</a> (' . $row['co'] . ' ' . $txt['aeva_vote' . ($row['co'] > 1 ? 's' : '') . '_noun'] . ')';
	}

	echo '
		</div>
		<div class="pagelinks">', $txt['aeva_pages'], ': ', $context['page_index'], '</div>';
	template_aeva_below();
}

// Who rated what list
function template_aeva_whoRatedWhat()
{
	global $context, $txt, $settings, $galurl;

	echo '
		<table cellpadding="6" cellspacing="1" border="0" width="100%" class="bordercolor">
			<tr>
				<td colspan="3" align="center" class="windowbg2">', $txt['aeva_who_rated_what'], ' (<a href="', $galurl, 'sa=item;in=', $context['item']['id_media'], '">', $context['item']['title'], '</a>)</td>
			</tr>
			<tr>
				<td class="titlebg" width="60%">', $txt['aeva_member'], '</td>
				<td class="titlebg" width="15%">', $txt['aeva_rating'], '</td>
				<td class="titlebg" width="25%">', $txt['aeva_date'], '</td>
			</tr>
			<tr>
				<td class="windowbg2" colspan="3">', $txt['aeva_pages'], ': ', $context['page_index'], '</td>
			</tr>';

		foreach ($context['item']['rating_logs'] as $log)
		{
			echo '
				<tr>
					<td class="windowbg2"><a href="', $log['member_link'], '">', $log['member_name'], '</a></td>
					<td class="windowbg2">', str_repeat('<img src="' . $settings['images_url'] . '/star.gif" border="0" alt="*" />', $log['rating']), '</td>
					<td class="windowbg2">', $log['time'], '</td>
				</tr>';
		}
	echo '
		</table>';
}

// FTP Import template
function template_aeva_admin_ftpimport()
{
	global $context, $scripturl, $txt, $settings;

	$albumOpts_str = '
	<option value="0">----</option>';

	foreach ($context['aeva_album_list'] as $list)
		$albumOpts_str .= '
	<option value="' . $list . '">' . str_repeat('-', $context['aeva_albums'][$list]['child_level']) . ' [' . $context['aeva_albums'][$list]['owner']['name'] . '] ' . $context['aeva_albums'][$list]['name'] . '</option>';

	if ($context['is_smf2'])
		echo '
	<div class="title_bar">
		<h3 class="titlebg">', $txt['aeva_admin_labels_ftp'], '</h3>
	</div>
	<div class="information">
		', $txt['aeva_admin_ftp_desc'], '
	</div>';

	echo '

	<form action="', $scripturl, '?action=admin;area=aeva_ftp;', $context['session_var'], '=', $context['session_id'], '" method="post">
		<table cellpadding="4" cellspacing="1" border="0" class="bordercolor" width="100%">
			<tr>
				<td class="windowbg smalltext" style="padding: 10px">', $txt['aeva_admin_ftp_help'], '</td>
			</tr>
			<tr>
				<td class="catbg">', $txt['aeva_admin_ftp_files'], '</td>
			</tr>';

	if ($context['is_halted'])
		echo '
			<tr>
				<td class="unapproved_yet">', sprintf($txt['aeva_admin_ftp_halted'], $context['ftp_done'], $context['total_files']), '</td>
			</tr>';

	foreach ($context['ftp_folder_list'] as $folder)
	{
		echo '
			<tr>
				<td class="windowbg2 smalltext" style="padding-left: ', (30 * $context['ftp_map'][$folder]['child_level']), 'px">
					&nbsp;<img src="', $settings['images_aeva'], '/album.png" alt="folder" border="0" /> ', $context['ftp_map'][$folder]['fname'], ' (', count($context['ftp_map'][$folder]['files']), ' ', $txt['aeva_files'], ')
					&nbsp;<select name="aeva_folder_', $folder, '">', $albumOpts_str, '</select>
				</td>
			</tr>';

		foreach ($context['ftp_map'][$folder]['files'] as $file)
			echo '
			<tr>
				<td class="windowbg2 smalltext" style="padding-left: ', (30 * ($context['ftp_map'][$folder]['child_level'] + 1)), 'px">', $file[0], ' (', round($file[1] / 1024), ' ', $txt['aeva_kb'], ')</td>
			</tr>';
	}

	echo '
			<tr>
				<td class="windowbg2" align="center">
					<input type="submit" name="aeva_submit" value="', $txt['aeva_submit'], '" />
					<input type="hidden" name="aeva_folder" value="pass" />
				</td>
			</tr>
		</table>
	</form>';
}

// Filestack view for gallery
function aeva_listFiles($items, $can_moderate = false)
{
	global $galurl, $scripturl, $context, $txt, $settings, $user_info;

	$can_moderate_one = $can_moderate_here = aeva_allowedTo('moderate');
	if (!$can_moderate_one)
		foreach ($items as $item)
			$can_moderate_one |= $item['poster_id'] == $user_info['id'];

	echo '
		<table cellpadding="4" cellspacing="1" border="0" style="width: 100%" class="bordercolor">
			<tr class="catbg">
				<td style="height: 25px">', $txt['aeva_name'], '</td>
				<td>', $txt['aeva_posted_on'], '</td>
				<td>', $txt['aeva_views'], '</td>
				<td>', $txt['aeva_comments'], '</td>
				<td>', $txt['aeva_rating'], '</td>', $can_moderate && $can_moderate_one ? '
				<td width="5%"></td>' : '', '
			</tr>';

	$alt = false;
	foreach ($items as $item)
	{
		$check = $can_moderate && ($can_moderate_here || $item['poster_id'] == $user_info['id']) ? '
				<td valign="bottom"><input type="checkbox" name="mod_item[' . $item['id'] . ']" /></td>' : '';
		echo '
			<tr class="windowbg', $alt ? '2' : '', $item['approved'] ? '' : ' unapp', '">
				<td>
					<strong><a href="', $galurl, 'sa=item;in=', $item['id'], '">', trim($item['title']) == '' ? '...' : $item['title'], '</a></strong>', empty($context['aeva_album']) || $item['poster_id'] != $context['aeva_album']['owner']['id'] ? '
					' . strtolower($txt['aeva_posted_by']) . ' ' . aeva_profile($item['poster_id'], $item['poster_name']) : '', empty($context['aeva_album']) ? '
					' . $txt['aeva_in_album'] . ' <a href="' . $galurl . 'sa=album;id=' . $item['id_album'] . '">' . $item['album_name'] . '</a>' : '', '
				</td>
				<td>', $item['posted_on'], '</td>
				<td>', !empty($item['views']) ? $item['views'] : '', '</td>
				<td>', !empty($item['comments']) ? $item['comments'] : '', '</td>
				<td>', !empty($item['rating']) ? $item['rating'] . ' <span class="smalltext">(' . $item['voters'] . ' ' . $txt['aeva_vote' . ($item['voters'] > 1 ? 's' : '') . '_noun'] . ')</span>' : '', '</td>',
				$check, !empty($item['desc']) ? '
			</tr>
			<tr class="windowbg' . ($alt ? '2' : '') . ($item['approved'] ? '' : ' unapp') . '">
				<td colspan="' . ($check ? '6' : '5') . '">
					<div class="mg_desc" style="padding: 8px">' . parse_bbc($item['desc']) . '</div>
				</td>' : '', '
			</tr>';
		$alt = !$alt;
	}
	echo '
		</table>';
}

function template_aeva_playlist()
{
	global $context;

	if (!empty($context['aeva_foxy_rendered_playlist']))
		echo $context['aeva_foxy_rendered_playlist'];
}

function template_aeva_rating_object($item)
{
	global $context, $settings, $txt, $galurl;

	$object = ($item['can_rate'] ? '
				<form action="'.$galurl.'sa=item;in='.$item['id_media'].'" method="post" id="ratingForm">' : '') . '
					' . ($item['voters'] > 0 ? str_repeat('<img alt="" src="'.$settings['images_url'].'/star.gif" />', round($item['avg_rating'])) . ' ' . round($item['avg_rating'], 2) . ' (' . (aeva_allowedTo('whoratedwhat') ? '<a href="' . $galurl . 'sa=whoratedwhat;in=' . $item['id_media'] . '">' : '') . $item['voters'] . ' ' . $txt['aeva_vote' . ($item['voters'] > 1 ? 's' : '') . '_noun'] . (aeva_allowedTo('whoratedwhat') ? '</a>' : '') . ')' : '') .
					(!empty($item['weighted']) ? ' (' . $txt['aeva_weighted_mean'] . ': ' . sprintf('%01.2f', $item['weighted']) . ')' : '');

	if ($item['can_rate'])
		$object .= '
					<select name="rating" id="rating">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
					<input type="button" value="'.$txt['aeva_rate_it'].'" onclick="ajaxRating();"/>
				</form>';

	return $object;
}

function template_aeva_xml_rated()
{
	global $context, $txt;

	echo '<?xml version="1.0" encoding="', $context['character_set'], '"?', '>
<ratingObject><![CDATA[', template_aeva_rating_object($context['item_data']), ']]></ratingObject>';
}

?>