<?php
/****************************************************************
* Aeva Media													*
* © Noisen.com & SMF-Media.com									*
*****************************************************************
* Aeva-ModCP.php - moderation control panel						*
*****************************************************************
* Users of this software are bound by the terms of the			*
* Aeva Media license. You can view it in the license_am.txt		*
* file, or online at http://noisen.com/license.php				*
*																*
* Support and updates for this software can be found at			*
* http://aeva.noisen.com and http://smf-media.com				*
****************************************************************/

/*
	This file handles the moderation panel of the gallery.

	void aeva_modCP()
		- Handles the homepage of modcp

	void aeva_modCP_submissions()
		- Shows the submissions index
		- Shows items, comments as well as albums

	void aeva_modCP_submissions_approve()
		- Approves an submitted item, comment or album

	void aeva_modCP_submissions_delete()
		- Deletes an unapproved item

	void aeva_modCP_reports()
		- Shows the reported items and comments along with their reason

	void aeva_modCP_reports_delete()
		- Deletes a report

	void aeva_modCP_reports_deleteItem()
		- Deletes a reported item

	void aeva_modCP_modLog()
		- Shows the complete moderation log
		- Also gives them an option to delete entries
*/

// Home of our wonderful moderation center
function aeva_modCP()
{
	global $context, $sourcedir;

	// Let's repeat the Admin's about page.....
	require_once($sourcedir . '/Aeva-Admin.php');
	aeva_admin_about();
}

// Handles the submissions area as well as the homepage of it
function aeva_modCP_submissions()
{
	global $amFunc, $txt, $context, $amSettings, $scripturl, $galurl, $sourcedir;

	// Handle the subsections
	$do = array(
		'approve' => array('aeva_modCP_submissions_approve', false),
		'delete' => array('aeva_modCP_submissions_delete', false),
	);

	if (isset($_REQUEST['do'], $do[$_REQUEST['do']]))
		if ($do[$_REQUEST['do']][1] === true)
			return $do[$_REQUEST['do']][0]();
		else
			$do[$_REQUEST['do']][0]();

	require_once($sourcedir.'/Aeva-Subs.php');
	aeva_addHeaders(true);

	// Sub-Template
	$context['sub_template'] = 'aeva_admin_submissions';

	// Let's get the data we need
	$filter = isset($_REQUEST['filter']) && in_array($_REQUEST['filter'], array('items', 'coms', 'albums')) ? $_REQUEST['filter'] : (isset($_REQUEST['type']) && in_array($_REQUEST['type'], array('items', 'coms', 'albums')) ? $_REQUEST['type'] : 'items');
	$per_page = 20;
	if ($filter == 'items')
	{
		$request = $amFunc['db_query']('
			SELECT m.id_media AS id, m.title, m.time_added AS posted_on, m.id_member, mem.realName AS member_name, m.description, m.keywords
			FROM {db_prefix}aeva_media AS m
				LEFT JOIN {db_prefix}members AS mem ON (mem.ID_MEMBER = m.id_member)
			WHERE m.approved = 0
			LIMIT {int:start}, {int:per_page}', array('start' => (int) $_REQUEST['start'], 'per_page' => $per_page),__FILE__,__LINE__);
		$del_link = $galurl . 'area=moderate;sa=submissions;do=delete;in=%s;type=items;' . $context['session_var'] . '='.$context['session_id'];
		$edit_link = $galurl . 'sa=post;in=%s';
		$view_link = $galurl . 'sa=item;in=%s';
		$total = $amSettings['num_unapproved_items'];
	}
	elseif ($filter == 'albums')
	{
		$request = $amFunc['db_query']('
			SELECT a.id_album AS id, a.name AS title, a.album_of AS id_member, mem.realName AS member_name, a.description
			FROM {db_prefix}aeva_albums AS a
				LEFT JOIN {db_prefix}members AS mem ON (mem.ID_MEMBER = a.album_of)
			WHERE a.approved = 0
			LIMIT {int:start}, {int:per_page}', array('start' => (int) $_REQUEST['start'], 'per_page' => $per_page),__FILE__,__LINE__);
		$del_link = $galurl . 'area=moderate;sa=submissions;do=delete;in=%s;type=albums;' . $context['session_var'] . '='.$context['session_id'];
		$edit_link = $galurl . 'area=mya;sa=edit;in=%s';
		$view_link = $galurl . 'sa=album;in=%s';
		$total = $amSettings['num_unapproved_albums'];
	}
	elseif ($filter == 'coms')
	{
		$request = $amFunc['db_query']('
			SELECT c.id_comment AS id, m.title, c.id_member, mem.realName AS member_name, c.posted_on, c.id_media AS id2, c.message AS description
			FROM {db_prefix}aeva_comments AS c
				INNER JOIN {db_prefix}aeva_media AS m ON (c.id_media = m.id_media)
				LEFT JOIN {db_prefix}members AS mem ON (mem.ID_MEMBER = c.id_member)
			WHERE c.approved = 0
			LIMIT {int:start}, {int:per_page}', array('start' => (int) $_REQUEST['start'], 'per_page' => $per_page),__FILE__,__LINE__);
		$del_link = $galurl . 'area=moderate;sa=submissions;do=delete;in=%s;type=coms;' . $context['session_var'] . '='.$context['session_id'];
		$edit_link = $galurl . 'sa=edit;type=comment;in=%s';
		$view_link = $galurl . 'sa=item;in=%s#com%s';
		$total = $amSettings['num_unapproved_comments'];
	}

	// Fetch the data
	$context['aeva_items'] = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$context['aeva_items'][] = array(
			'id' => $row['id'],
			'item_link' => $filter == 'coms' ? sprintf($view_link, $row['id2'], $row['id']) : sprintf($view_link, $row['id']),
			'title' => $row['title'],
			'edit_link' => sprintf($edit_link, $row['id']),
			'del_link' => sprintf($del_link, $row['id']),
			'poster' => aeva_profile($row['id_member'], $row['member_name']),
			'posted_on' => $filter != 'albums' ? timeformat($row['posted_on']) : 0,
			'description' => !empty($row['description']) ? $amFunc['parse_bbc']($row['description']) : '',
			'keywords' => !empty($row['keywords']) ? implode(', ', explode(',', $row['keywords'])) : '',
		);
	}
	$amFunc['db_free_result']($request);

	// Page index
	$_REQUEST['start'] = empty($_REQUEST['start']) ? 0 : (int) $_REQUEST['start'];
	$context['aeva_page_index'] = $amFunc['construct_page_index']($scripturl . '?action=media;area=moderate;sa=submissions;filter=' . $filter . ';' . $context['session_var'] . '=' . $context['session_id'], $_REQUEST['start'], $total, $per_page);

	// We're done!
	$context['aeva_filter'] = $filter;
	$context['aeva_total'] = $total;

	// Get the subtabs
	$context['aeva_header']['subtabs'] = array(
		'items' => array('title' => 'aeva_items', 'url' => $scripturl.'?action=media;area=moderate;sa=submissions;filter=items;' . $context['session_var'] . '='.$context['session_id'], 'active' => $filter == 'items'),
		'comments' => array('title' => 'aeva_comments', 'url' => $scripturl.'?action=media;area=moderate;sa=submissions;filter=coms;' . $context['session_var'] . '='.$context['session_id'], 'active' => $filter == 'coms'),
		'albums' => array('title' => 'aeva_albums', 'url' => $scripturl.'?action=media;area=moderate;sa=submissions;filter=albums;' . $context['session_var'] . '=' . $context['session_id'], 'active' => $filter == 'albums'),
	);

	// HTML headers
	$context['html_headers'] .= '
	<script type="text/javascript" src="'.aeva_theme_url('admin.js').'"></script>';
}

// Approves an unapproved item
function aeva_modCP_submissions_approve()
{
	global $amFunc, $user_info, $context, $galurl;

	$items = isset($_POST['items']) && isset($_POST['submit_aeva']) && is_array($_POST['items']) ? $_POST['items'] : array((int) @$_REQUEST['in']);
	$type = $_REQUEST['type'];

	if (isset($_REQUEST['xml']))
		header('Content-Type: text/xml; charset=ISO-8859-1');

	if (!in_array($type, array('albums', 'items', 'coms')))
	{
		if (isset($_REQUEST['xml']))
		{
			echo '<?xml version="1.0" encoding="ISO-8859-1"?', '>
<ret>
	<id>', $items[0], '</id>
	<succ>false</succ>
</ret>';
			die;
		}
		return false;
	}

	// Approving an album?
	if ($type == 'albums')
	{
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_albums
			SET approved = 1
			WHERE id_album IN ({array_int:albums})',
			array(
				'albums' => $items,
			),__FILE__,__LINE__);

		// Log it
		$request = $amFunc['db_query']('
			SELECT id_album, name
			FROM {db_prefix}aeva_albums
			WHERE id_album IN ({array_int:albums})',
			array(
				'albums' => $items,
			),__FILE__,__LINE__);

		while (list ($id, $name) = $amFunc['db_fetch_row']($request))
		{
			$opts = array(
				'type' => 'approval',
				'subtype' => 'approved',
				'action_on' => array(
					'id' => $id,
					'name' => $name,
				),
				'action_by' => array(
					'id' => $user_info['id'],
					'name' => $user_info['name'],
				),
				'extra_info' => array(
					'val8' => 'album',
				),
			);
			aeva_logModAction($opts);
			aeva_increaseSettings('total_albums');
			aeva_increaseSettings('num_unapproved_albums', -1);
		}
		$amFunc['db_free_result']($request);
	}
	// Maybe a item?
	elseif ($type == 'items')
	{
		// Fetch some data
		$request = $amFunc['db_query']('
			SELECT m.album_id, a.id_last_media, m.id_media, m.title, m.id_member
			FROM {db_prefix}aeva_media AS m
				INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
			WHERE m.id_media IN ({array_int:id})
			AND m.approved = 0',
			array(
				'id' => $items,
			),__FILE__,__LINE__);

		while (list ($album, $id_last_media, $id, $name, $id_member) = $amFunc['db_fetch_row']($request))
		{
			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_media
				SET approved = 1
				WHERE id_media = {int:id}',
				array('id' => $id),__FILE__,__LINE__);

			// Update the album's stats
			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_albums
				SET num_items = num_items + 1' . ($id_last_media < $id ? ', id_last_media = {int:id}' : '') . '
				WHERE id_album = {int:album}',
				array(
					'album' => $album,
					'id' => $id,
				),__FILE__,__LINE__);

			// Update the uploader's stats
			$amFunc['db_query']('
				UPDATE {db_prefix}members
				SET aeva_items = aeva_items + 1
				WHERE ID_MEMBER = {int:member}',
				array(
					'member' => $id_member,
				),__FILE__,__LINE__);

			// log it
			$opts = array(
				'type' => 'approval',
				'subtype' => 'approved',
				'action_on' => array(
					'id' => $id,
					'name' => $name,
				),
				'action_by' => array(
					'id' => $user_info['id'],
					'name' => $user_info['name'],
				),
				'extra_info' => array(
					'val8' => 'item',
				),
			);
			aeva_logModAction($opts);
			aeva_increaseSettings('total_items');
			aeva_increaseSettings('num_unapproved_items', -1);
		}
		$amFunc['db_free_result']($request);
	}
	// It has to be a comment then!
	else
	{
		// Fetch the media id -- we need to check for moderator/admin rights
		$request = $amFunc['db_query']('
			SELECT c.id_media, m.id_last_comment, c.id_comment, m.title, a.album_of, c.id_member
			FROM {db_prefix}aeva_comments AS c
				INNER JOIN {db_prefix}aeva_media AS m ON (m.id_media = c.id_media)
				INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = c.id_album)
			WHERE c.id_comment IN ({array_int:id})
			AND c.approved = 0',
			array(
				'id' => $items,
			),__FILE__,__LINE__);

		while (list ($item, $id_last_comment, $id, $name, $owner, $id_member) = $amFunc['db_fetch_row']($request))
		{
			// Approve it
			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_comments
				SET approved = 1
				WHERE id_comment = {int:id}',
				array('id' => $id),__FILE__,__LINE__);

			// Update the item's stats
			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_media
				SET num_comments = num_comments + 1' . ($id_last_comment < $id ? ', id_last_comment = {int:id}' : '') . '
				WHERE id_media = {int:media}',
				array(
					'id' => $id,
					'media' => $item,
				),__FILE__,__LINE__);

			// Update the uploader's stats
			$amFunc['db_query']('
				UPDATE {db_prefix}members
				SET aeva_comments = aeva_comments + 1
				WHERE ID_MEMBER = {int:member}',
				array(
					'member' => $id_member,
				),__FILE__,__LINE__);

			$opts = array(
				'type' => 'approval',
				'subtype' => 'approved',
				'action_on' => array(
					'id' => $id,
					'name' => $name,
				),
				'action_by' => array(
					'id' => $user_info['id'],
					'name' => $user_info['name'],
				),
				'extra_info' => array(
					'val8' => 'comment',
					'val9' => $item,
				),
			);
			aeva_logModAction($opts);
			aeva_increaseSettings('total_comments');
			aeva_increaseSettings('num_unapproved_comments', -1);
		}
		$amFunc['db_free_result']($request);
	}

	// Everything done :)
	if (isset($_REQUEST['xml']))
	{
		echo '<?xml version="1.0" encoding="ISO-8859-1"?', '>
<ret>
	<id>', $items[0], '</id>
	<succ>true</succ>
</ret>';
		die;
	}

	redirectexit($galurl . 'area=moderate;sa=submissions;filter=' . $type);
}

// Basically deletes a item or a comment.
function aeva_modCP_submissions_delete()
{
	global $user_info, $amFunc, $context, $galurl, $sourcedir;

	$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';

	$request = $amFunc['db_query']($type == 'albums' ? '
		SELECT id_album, name AS title
		FROM {db_prefix}aeva_albums
		WHERE id_album IN ({array_int:id})' : '
		SELECT m.id_media, m.title' . ($type == 'coms' ? ', c.id_comment' : '') . '
		FROM {db_prefix}aeva_media AS m
			' . ($type == 'coms' ? 'INNER JOIN {db_prefix}aeva_comments AS c ON (c.id_media = m.id_media)' : '') . '
		WHERE ' . ($type == 'coms' ? 'c.id_comment' : 'm.id_media') . ' IN ({array_int:id})',
		array(
			'id' => isset($_POST['items']) && isset($_POST['submit_aeva']) && is_array($_POST['items']) ? $_POST['items'] : array((int) $_REQUEST['in']),
		),__FILE__,__LINE__);

	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		if ($type == 'coms')
			aeva_deleteComments($row['id_comment'], false);
		elseif ($type == 'items')
			aeva_deleteItems($row['id_media'], true, false);
		elseif ($type == 'albums')
		{
			require_once($sourcedir . '/Aeva-Gallery2.php');
			aeva_deleteAlbum($row['id_album'], true);
		}

		$opts = array(
			'type' => 'approval',
			'subtype' => 'delete',
			'action_on' => array(
				'id' => $row['id_' . ($type == 'albums' ? 'album' : ($type == 'coms' ? 'comment' : 'media'))],
				'name' => $row['title'],
			),
			'action_by' => array(
				'id' => $user_info['id'],
				'name' => $user_info['name'],
			),
			'extra_info' => array(
				'val8' => $type == 'albums' ? 'album' : ($type == 'coms' ? 'comment' : 'item'),
			),
		);
		aeva_logModAction($opts);
	}

	if (isset($_REQUEST['xml']))
	{
		header('Content-Type: text/xml; charset=ISO-8859-1');
		echo '<?xml version="1.0" encoding="ISO-8859-1"?', '>
<ret>
	<id>', (int) $_REQUEST['in'], '</id>
	<succ>true</succ>
</ret>';
		die;
	}

	redirectexit($galurl . 'area=moderate;sa=submissions;filter=' . $type);
}

// Handles the reported items page
function aeva_modCP_reports()
{
	global $amFunc, $context, $scripturl, $galurl, $txt, $amSettings;

	// DOs
	$do = array(
		'delete' => array('aeva_modCP_reports_delete', false),
		'deleteitem' => array('aeva_modCP_reports_deleteItem', false),
	);
	if (isset($_REQUEST['do'], $do[$_REQUEST['do']]))
		if ($do[$_REQUEST['do']][1])
			return $do[$_REQUEST['do']][0]();
		else
			$do[$_REQUEST['do']][0]();

	$type = isset($_REQUEST['comments']) ? 'comment' : 'item';

	$txt['aeva2_items'] = $txt['aeva_items'] . ' (' . $amSettings['num_reported_items'] . ')';
	$txt['aeva2_comments'] = $txt['aeva_comments'] . ' (' . $amSettings['num_reported_comments'] . ')';

	// Header tabs
	$context['aeva_header']['subtabs'] = array(
		'items' => array('title' => 'aeva2_items', 'url' => $scripturl.'?action=media;area=moderate;sa=reports;items;' . $context['session_var'] . '='.$context['session_id'], 'active' => $type == 'item'),
		'comments' => array('title' => 'aeva2_comments', 'url' => $scripturl.'?action=media;area=moderate;sa=reports;comments;' . $context['session_var'] . '='.$context['session_id'], 'active' => $type == 'comment'),
	);

	// Load all the reports
	$request = $amFunc['db_query']('
		SELECT v.id, v.val1, v.val2, v.val3, v.val4, mem.realName AS real_name, m.title, m.id_member, m.time_added, mem2.realName AS real_name2, m.id_media
		FROM {db_prefix}aeva_variables AS v
			LEFT JOIN {db_prefix}members AS mem ON (mem.ID_MEMBER = v.val1)' . ($type == 'comment' ? '
			INNER JOIN {db_prefix}aeva_comments AS c ON (c.id_comment = v.val4)
			INNER JOIN {db_prefix}aeva_media AS m ON (m.id_media = c.id_media)' : '
			INNER JOIN {db_prefix}aeva_media AS m ON (m.id_media = v.val4)') . '
			LEFT JOIN {db_prefix}members AS mem2 ON (mem2.ID_MEMBER = m.id_member)
		WHERE v.type = {string:type}
		ORDER BY v.val3 ASC
		LIMIT {int:start}, {int:per_page}',
		array(
			'type' => $type.'_report',
			'start' => isset($_REQUEST['start']) ? (int) $_REQUEST['start'] : 0,
			'per_page' => 20,
		),__FILE__,__LINE__);
	$context['aeva_reports'] = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$context['aeva_reports'][] = array(
			'id_report' => $row['id'],
			'id' => $row['val4'],
			'id2' => $row['id_media'],
			'name' => $row['title'],
			'reported_on' => $amFunc['time_format']($row['val2']),
			'reason' => $amFunc['parse_bbc']($row['val3']),
			'reported_by' => array(
				'id' => $row['val1'],
				'name' => $row['real_name'],
			),
			'posted_by' => array(
				'id' => $row['id_member'],
				'name' => $row['real_name2'],
			),
			'posted_on' => $amFunc['time_format']($row['time_added']),
			'title' => $row['title'],
		);
	}
	$amFunc['db_free_result']($request);

	// page index
	$_REQUEST['start'] = empty($_REQUEST['start']) ? 0 : (int) $_REQUEST['start'];
	$context['aeva_page_index'] = $amFunc['construct_page_index']($scripturl . '?action=media;area=moderate;sa=reports;' . (isset($_REQUEST['comments']) ? 'comments' : '')
		. $context['session_var'] . '=' . $context['session_id'], $_REQUEST['start'], $amSettings[$type == 'comment' ? 'num_reported_comments' : 'num_reported_items'], 20);
	$context['aeva_report_type'] = $type;

	$context['sub_template'] = 'aeva_admin_reports';
	// HTML headers
	$context['html_headers'] .= '
	<script type="text/javascript" src="'.aeva_theme_url('admin.js').'"></script>';
}

// Deletes a report
function aeva_modCP_reports_delete()
{
	global $amFunc, $user_info;

	// Fetch the report
	$request = $amFunc['db_query']('
		SELECT id, val4, val5, type
		FROM {db_prefix}aeva_variables
		WHERE id = {int:report}
		AND (type = {string:item} OR type = {string:comment})',
		array('report' => (int) $_GET['in'], 'item' => 'item_report', 'comment' => 'comment_report'),__FILE__,__LINE__);
	if ($amFunc['db_num_rows']($request) == 0)
		fatal_lang_error('aeva_report_not_found');
	$report = $amFunc['db_fetch_assoc']($request);
	$amFunc['db_free_result']($request);

	// Let's remove it!
	$amFunc['db_query']('
		DELETE FROM {db_prefix}aeva_variables
		WHERE id = {int:id}',
		array('id' => $report['id']),__FILE__,__LINE__);

	// Update the settings
	aeva_increaseSettings($report['type'] == 'comment_report' ? 'num_reported_comments' : 'num_reported_items', -1);

	// Log the action
	$opts = array(
		'type' => 'report',
		'subtype' => 'delete_report',
		'action_on' => array(
			'id' => $report['val4'],
			'name' => $report['val5'],
		),
		'action_by' => array(
			'id' => $user_info['id'],
			'name' => $user_info['name'],
		),
		'extra_info' => array(
			'val8' => $report['type'],
		),
	);
	aeva_logModAction($opts);
}

// Deletes a reported item
function aeva_modCP_reports_deleteItem()
{
	global $amFunc, $user_info;

	// Get the item which we need to delete
	$request = $amFunc['db_query']('
		SELECT id, val4, val5, type
		FROM {db_prefix}aeva_variables
		WHERE id = {int:report}
		AND (type = {string:item} OR type = {string:comment})',
		array('report' => (int) $_GET['in'], 'item' => 'item_report', 'comment' => 'comment_report'),__FILE__,__LINE__);
	if ($amFunc['db_num_rows']($request) == 0)
		fatal_lang_error('aeva_report_not_found');
	$report = $amFunc['db_fetch_assoc']($request);
	$amFunc['db_free_result']($request);

	// Delete the item
	if ($report['type'] == 'comment_report')
		aeva_deleteComments($report['val5'], false);
	else
		aeva_deleteItems($report['val4'], true, false);

	// Log it
	$opts = array(
		'type' => 'report',
		'subtype' => 'delete_item',
		'action_on' => array(
			'id' => $report['val4'],
			'name' => $report['val5'],
		),
		'action_by' => array(
			'id' => $user_info['id'],
			'name' => $user_info['name'],
		),
		'extra_info' => array(
			'val8' => $report['type'],
		),
	);
	aeva_logModAction($opts);
}

// Handles the moderation log
function aeva_modCP_modLog()
{
	global $amFunc, $context, $scripturl, $galurl, $txt, $amSettings;

	// Deleting something?
	if (isset($_POST['delete']) && !empty($_POST['delete']))
	{
		$logs = is_array($_POST['to_delete']) ? $_POST['to_delete'] : array($_POST['to_delete']);
		if (empty($logs))
			break;
		$amFunc['db_query']('
			DELETE FROM {db_prefix}aeva_variables
			WHERE id IN ({array_int:logs})
			AND type = {string:type}', array('type' => 'mod_log', 'logs' => $logs),__FILE__,__LINE__);
	}
	if (isset($_POST['delete_all']))
		$amFunc['db_query']('
			DELETE FROM {db_prefix}aeva_variables
			WHERE type = {string:type}', array('type' => 'mod_log'),__FILE__,__LINE__);

	// Quick search by member?
	if (isset($_POST['qsearch_mem']) && !empty($_POST['qsearch_mem']))
	{
		$request = $amFunc['db_query']('
			SELECT ID_MEMBER, realName
			FROM {db_prefix}members
			WHERE memberName = {string:name} OR realName = {string:name}
			LIMIT 1', array('name' => $_POST['qsearch_mem']),__FILE__,__LINE__);
		if ($amFunc['db_num_rows']($request) > 0)
			list ($id_member, $member_name) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);
	}

	if (isset($_REQUEST['qsearch']) && !isset($id_member))
	{
		$request = $amFunc['db_query']('
			SELECT ID_MEMBER, realName
			FROM {db_prefix}members
			WHERE id_member = {int:id_member}
			LIMIT 1', array('id_member' => (int) $_REQUEST['qsearch']),__FILE__,__LINE__);
		if ($amFunc['db_num_rows']($request) > 0)
			list ($id_member, $member_name) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);
	}

	$id_member = empty($id_member) ? 0 : $id_member;
	$member_name = empty($member_name) ? '' : $member_name;

	// Get the total logs
	$request = $amFunc['db_query']('
		SELECT COUNT(id)
		FROM {db_prefix}aeva_variables
		WHERE type = {string:type}' . (!empty($id_member) ? '
		AND val5 = {int:id_member}' : ''),
		array(
			'type' => 'mod_log',
			'id_member' => (int) $id_member,
		),__FILE__,__LINE__
	);
	list ($total_logs) = $amFunc['db_fetch_row']($request);
	$amFunc['db_free_result']($request);

	// Get the logs now
	$request = $amFunc['db_query']('
		SELECT *
		FROM {db_prefix}aeva_variables
		WHERE type = {string:type}' . (!empty($id_member) ? '
		AND val5 = {int:id_member}' : '') . '
		ORDER BY id DESC
		LIMIT {int:start}, {int:limit}',
		array(
			'type' => 'mod_log',
			'id_member' => (int) $id_member,
			'start' => isset($_REQUEST['start']) ? (int) $_REQUEST['start'] : 0,
			'limit' => 30
		),__FILE__,__LINE__);
	$context['aeva_logs'] = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		// Get their action href and type
		$href = '';
		$type = '';
		switch($row['val1'])
		{
			case 'approval':
				switch($row['val8'])
				{
					case 'item':
						if ($row['val2'] == 'approved')
							$text = sprintf($txt['aeva_admin_modlog_approval_item'], $galurl.'sa=item;in='.$row['val3'], $row['val4']);
						elseif ($row['val2'] == 'unapproved')
							$text = sprintf($txt['aeva_admin_modlog_approval_ua_item'], $galurl . 'sa=item;in='.$row['val3'], $row['val4']);
						else
							$text = sprintf($txt['aeva_admin_modlog_approval_del_item'], $row['val4']);
					break;
					case 'comment':
						if ($row['val2'] == 'approved')
							$text = sprintf($txt['aeva_admin_modlog_approval_com'], $galurl.'sa=item;in='.$row['val9'].'#com'.$row['val3'], $row['val4']);
						else
							$text = sprintf($txt['aeva_admin_modlog_approval_del_com'], $row['val4']);
					break;
					case 'album':
						if ($row['val2'] == 'approved')
							$text = sprintf($txt['aeva_admin_modlog_approval_album'], $galurl.'sa=album;in='.$row['val3'], $row['val4']);
						else
							$text = sprintf($txt['aeva_admin_modlog_approval_del_album'], $row['val4']);
					break;
				}
			break;
			case 'delete':
				$text = sprintf($txt['aeva_admin_modlog_delete_'.$row['val2']], $row['val4']);
			break;
			case 'report':
				$text = sprintf($txt['aeva_admin_modlog_'.$row['val2'].'_'.$row['val8']], $row['val3']);
			break;
			case 'ban':
				$text = sprintf($txt['aeva_admin_modlog_ban_'.$row['val2']], $scripturl . '?action=profile;u=' . $row['val3'], $row['val4']);
			break;
			case 'prune':
				$text = sprintf($txt['aeva_admin_modlog_prune_'.$row['val2']], $row['val8']);
			break;
			case 'move';
				$album1 = explode(',', $row['val8']);
				$album2 = explode(',', $row['val9']);
				$text = sprintf($txt['aeva_admin_modlog_move'], $galurl.'sa=item;in='.$row['val3'], $row['val4'], $galurl.'sa=album;in='.$album2[0], $album2[1], $galurl.'sa=album;in='.$album1[0], $album1[1]);
			break;
		}
		$context['aeva_logs'][] = array(
			'id' => $row['id'],
			'text' => $text,
			'action_by_href' => $scripturl.'?action=profile;u='.$row['val5'],
			'action_by_name' => $row['val6'],
			'time' => $amFunc['time_format']($row['val7']),
		);
	}
	$amFunc['db_free_result']($request);
	$total_logs = (int) $total_logs;

	// Page index
	$_REQUEST['start'] = empty($_REQUEST['start']) ? 0 : (int) $_REQUEST['start'];
	$context['aeva_page_index'] = $amFunc['construct_page_index']($scripturl . '?action=media;area=moderate;sa=modlog;' . (!empty($id_member) ? 'qsearch=' . $id_member . ';' : '')
		. $context['session_var'] . '=' . $context['session_id'], $_REQUEST['start'], $total_logs, 30);

	if (!empty($id_member))
		$context['aeva_filter'] = sprintf($txt['aeva_admin_modlog_filter'], $scripturl . '?action=profile;u=' . $id_member, $member_name);

	// Sub-template
	$context['sub_template'] = 'aeva_admin_modlog';

	// HTML headers
	$context['html_headers'] .= '
	<script type="text/javascript" src="'.aeva_theme_url('admin.js').'"></script>';
}

?>