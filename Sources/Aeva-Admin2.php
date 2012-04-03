<?php
/****************************************************************
* Aeva Media													*
* � Noisen.com & SMF-Media.com									*
*****************************************************************
* Aeva-Admin2.php - maintenance and other admin areas			*
*****************************************************************
* Users of this software are bound by the terms of the			*
* Aeva Media license. You can view it in the license_am.txt		*
* file, or online at http://noisen.com/license.php				*
*																*
* Support and updates for this software can be found at			*
* http://aeva.noisen.com and http://smf-media.com				*
****************************************************************/

if (!defined('SMF'))
	die('Hacking attempt...');

/*
	This file handles Aeva Media's Maintenance & Bans sections

	void aeva_admin_maintenance()
		- Shows the index of maintenance section

	void aeva_admin_maintenance_regenerate()
		- Deletes and re-creates thumbnails and previews, one by one
		- Has effective load management to prevent overloading

	void aeva_admin_maintenance_recount()
		- Recounts all statistics

	void aeva_admin_maintenance_finderrors()
		- Tries to find several possible missing elements:
		- Thumbnail, preview or file (physically or in the DB), last comment or album

	void aeva_admin_maintenance_prune()
		- Ability to prune items

	void aeva_admin_maintenance_checkfiles()
		- Checks whether unneeded files are found in the data folders, ie they're in the files table but not used by the media table.
		- If found, gives the option to delete them.

	void aeva_admin_maintenance_checkorphans()
		- Checks whether orphan files are found in the data folders, ie they're not even in the files table.
		- If found, gives the option to delete them.

	void aeva_admin_bans()
		- Shows the current bans, also giving the link to edit/delete/add bans

	void aeva_admin_bans_add()
		- Adds a ban

	void aeva_admin_bans_edit()
		- Edits a ban

	void aeva_admin_bans_delete()
		- Deletes a ban
*/

// Maintenance home page
function aeva_admin_maintenance()
{
	global $txt, $scripturl, $context, $album;

	$context['aeva_maintenance_done'] = false;
	$context['aeva_maintenance_message'] = '';
	$album = $context['aeva_maintain_album'] = !empty($_GET['album']) ? (int) $_GET['album'] : 0;

	// Load the subs
	// array(
	//   'sa' => array('function', (bool) is_utility),
	// );
	// Use $context['aeva_maintenance_message'] for showing a message
	// $context['aeva_maintenance_done'] can have false (not shown), 'error' (red), ' pending'(yellow), true (green)
	// Title is fetched as $txt['aeva_admin_maintenance_'.sa];

	$sas = array(
		// Tasks
		'recount' => array('aeva_admin_maintenance_recount', false),
		'checkfiles' => array('aeva_admin_maintenance_checkfiles', false),
		'checkorphans' => array('aeva_admin_maintenance_checkorphans', false),
		'finderrors' => array('aeva_admin_maintenance_finderrors', false),
		'clear' => array('aeva_admin_maintenance_clear', 0),
		'regen' => array('aeva_admin_maintenance_regenerate', false, array('thumb', 'embed', 'preview', 'all')),
		// Utilities
		'prune' => array('aeva_admin_maintenance_prune', true),
	);
	if ($album)
		unset($sas['recount'], $sas['checkfiles'], $sas['clear'], $sas['finderrors']);

	// Construct the template array
	$context['aeva_dos'] = array();
	$end_url = ($album ? ';album=' . $album : '') . ';' . $context['session_var'] . '=' . $context['session_id'];
	foreach ($sas as $sa => $data)
		if ($data[1] === false)
		{
			// Any sub-tasks?
			if (isset($data[2]))
				foreach ($data[2] as $st)
					$context['aeva_dos'][$sa][] = array(
						'title' => $txt['aeva_admin_maintenance_' . $sa . '_' . $st],
						'href' => $scripturl . '?action=admin;area=aeva_maintenance;sa=' . $sa . ';st=' . $st . $end_url,
						'subtext' => isset($txt['aeva_admin_maintenance_' . $sa . '_' . $st . '_subtext']) ? $txt['aeva_admin_maintenance_' . $sa . '_' . $st . '_subtext'] : '',
					);
			else
				$context['aeva_dos']['tasks'][] = array(
					'title' => $txt['aeva_admin_maintenance_' . $sa],
					'href' => $scripturl . '?action=admin;area=aeva_maintenance;sa=' . $sa . $end_url,
					'subtext' => isset($txt['aeva_admin_maintenance_' . $sa . '_subtext']) ? $txt['aeva_admin_maintenance_' . $sa . '_subtext'] : '',
				);
		}
		elseif ($data[1])
			$context['aeva_dos']['utils'][] = array(
				'title' => $txt['aeva_admin_maintenance_' . $sa],
				'href' => $scripturl . '?action=admin;area=aeva_maintenance;sa=' . $sa . $end_url,
				'subtext' => isset($txt['aeva_admin_maintenance_' . $sa . '_subtext']) ? $txt['aeva_admin_maintenance_' . $sa . '_subtext'] : '',
			);

	if (isset($_REQUEST['sa'], $sas[$_REQUEST['sa']]))
	{
		$sas[$_REQUEST['sa']][0]();
		if ($sas[$_REQUEST['sa']][1])
			return;
	}

	$context['sub_template'] = 'aeva_admin_maintenance';
}

function aeva_sameDomain($dom)
{
	// Will only work on [a-z] top-domain level. Tough life, eh.
	$dom_filter = '~(?:.*://.*?\.)?([0-9a-z-]{2,}(?:\.com?)?\.[a-z]{2,4}).*~s';
	$dom1 = preg_replace($dom_filter, '$1', strtolower($_SERVER['SERVER_NAME']));
	$dom2 = preg_replace($dom_filter, '$1', strtolower($dom));
	return $dom1 == $dom2;
}

// Regenerates thumbnails and previews
function aeva_admin_maintenance_regenerate()
{
	global $amFunc, $amSettings, $context, $txt, $scripturl, $sourcedir;

	// This is needed for aeva_generate_embed_thumb()
	require_once($sourcedir . '/Aeva-Embed.php');

	$task = isset($_GET['st']) && in_array($_GET['st'], array('thumb', 'embed', 'preview', 'all')) ? $_GET['st'] : 'thumb';
	$ffmpeg_enabled = class_exists('ffmpeg_movie');
	$album = $context['aeva_maintain_album'];

	// Do the query!
	$request = $amFunc['db_query']('
		SELECT
			m.id_media, m.id_file, m.id_thumb, m.id_preview, f3.filename AS preview_name, f.filename AS file_name,
			f.directory AS file_dir, f2.directory AS thumb_dir, f3.directory AS preview_dir, m.album_id,
			m.type, m.embed_url, a.id_album AS album_icon
		FROM {db_prefix}aeva_media AS m
			LEFT JOIN {db_prefix}aeva_files AS f ON (m.id_file = f.id_file)
			LEFT JOIN {db_prefix}aeva_files AS f2 ON (m.id_thumb = f2.id_file)
			LEFT JOIN {db_prefix}aeva_files AS f3 ON (m.id_preview = f3.id_file)
			LEFT JOIN {db_prefix}aeva_albums AS a ON (m.id_thumb = a.icon)' . ($album ? '
		WHERE m.album_id = {int:album} OR a.id_album = {int:album}' : '') . '
		ORDER BY id_media ASC
		LIMIT {int:start}, {int:limit}',
		array(
			'start' => (int) $_REQUEST['start'],
			'limit' => $task == 'embed' ? 100 : 20,
			'album' => $album,
		),
		__FILE__,__LINE__
	);
	$total_done = (int) $_REQUEST['start'];
	$total_received = $amFunc['db_num_rows']($request);
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		// This needs to be cleaned
		aeva_emptyTmpFolder();
		unset($id_thumb, $id_preview);

		// Overloaded?
		if (aeva_timeSpent() > 5)
			break;

		$total_done++;
		$dest_file = $amSettings['data_dir_path'] . '/' . $row['file_dir'];
		$dest_preview = $amSettings['data_dir_path'] . '/' . (empty($row['preview_dir']) ? $row['file_dir'] : $row['preview_dir']);
		$dest_thumb = empty($row['thumb_dir']) || $row['thumb_dir'] == 'generic_images' ? $dest_preview : $amSettings['data_dir_path'] . '/' . $row['thumb_dir'];
		// If this is on the same domain, it's a thumbnail-less local video, so it shouldn't be rebuilt
		$can_rebuild_from_orig = $row['type'] == 'image' || ($row['type'] == 'embed' && !aeva_sameDomain($row['embed_url'])) || ($row['type'] == 'video' && $ffmpeg_enabled);

		// Delete the current files
		// Are we doing embed?
		if ($row['type'] == 'embed' && $task != 'preview')
		{
			// Regenerate the thumbnail (we don't need to delete the previous files, it's built in that function)
			if (!aeva_generate_embed_thumb($row['embed_url'], $row['album_id'], $row['id_thumb'], $dest_thumb, $row['id_preview']))
			{
				if (function_exists('aeva_foxy_remote_image'))
				{
					$id_thumb = aeva_foxy_remote_image($row['embed_url']);
					if (is_array($id_thumb))
						list (, $id_thumb, $id_preview) = $id_thumb;
				}
				else
					$id_thumb = 2;
			}
		}
		// Normal items? Skip if we're not in embed-only mode, or we're regenerating previews for audio/video
		// Don't regenerate if our thumbnail uses a generic icon... (Too suspicious!)
		elseif (($task != 'embed' || !$can_rebuild_from_orig) && ($can_rebuild_from_orig || ($task != 'preview' && $row['id_preview'] > 0)))
		{
			if ($can_rebuild_from_orig)
				aeva_deleteFiles($task == 'all' ? array($row['id_thumb'], $row['id_preview']) : $row['id_' . $task], true);
			// If we can't regenerate from the original file, only delete the thumbnail if we have a preview we can regenerate from.
			elseif ($task != 'preview' && !empty($row['id_preview']))
				aeva_deleteFiles($row['id_thumb'], true);
			// Otherwise it means we can regenerate neither preview nor thumbnail, so skip this item.
			else
				continue;

			$file = new aeva_media_handler;
			$encfn = $can_rebuild_from_orig ? aeva_getEncryptedFilename($row['file_name'], $row['id_file']) : aeva_getEncryptedFilename($row['preview_name'], $row['id_preview']);
			$file->init(($can_rebuild_from_orig ? $dest_file : $dest_preview) . '/' . $encfn);
			list ($fwidth, $fheight) = $file->getSize();

			// Regenerate the thumbnail
			$opts = array(
				'destination' => $dest_thumb,
				'filename' => $row['file_name'],
				'album' => $row['album_id'],
				'force_id_thumb' => $row['id_thumb'] > 4 ? $row['id_thumb'] : 0,
				'force_id_preview' => $can_rebuild_from_orig ? $row['id_preview'] : 0,
			);
			if ($task != 'preview' && ($can_rebuild_from_orig || !empty($row['id_preview'])))
				$id_thumb = aeva_createThumbFile($row['id_file'], $file, $opts);

			// Regenerate the preview if asked, and if we can read the contents of the original file. Force it if original is a video.
			if ($can_rebuild_from_orig && ($task == 'preview' || $task == 'all') && ($row['type'] == 'video' || (!empty($amSettings['max_preview_width']) && !empty($amSettings['max_preview_height']))))
			{
				$opts['destination'] = $dest_preview;
				$id_preview = aeva_createPreviewFile($row['id_file'], $file, $opts, $fwidth, $fheight);
			}

			$file->close();
		}
		else
			continue;

		// Modify the item
		$opts = array(
			'id' => $row['id_media'],
			'skip_log' => true,
		);
		if (!empty($id_thumb))
			$opts['id_thumb'] = $id_thumb;
		if (isset($id_preview))
			$opts['id_preview'] = $id_preview;
		if (!empty($id_thumb) || isset($id_preview))
			aeva_modifyItem($opts);

		if (!empty($row['album_icon']) && !empty($id_thumb))
		{
			// There should be no need to update this, now that id_thumb no longer changes...
			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_albums
				SET icon = {int:icon}
				WHERE id_album = {int:album}',
				array('icon' => $id_thumb, 'album' => $row['album_icon']),__FILE__,__LINE__);
		}
	}
	$amFunc['db_free_result']($request);

	// Are we done yet? Are we done yet?
	if ($total_received > 0 && ($total_done < ($amSettings['total_items'] + $amSettings['num_unapproved_items'])))
	{
		if ($album)
		{
			$request = $amFunc['db_query']('SELECT num_items FROM {db_prefix}aeva_albums WHERE id_album = {int:album}', array('album' => $album),__FILE__,__LINE__);
			list ($total_to_do) = $amFunc['db_fetch_row']($request);
			$amFunc['db_free_result']($request);
		}
		else
			$total_to_do = $amSettings['total_items'] + $amSettings['num_unapproved_items'];
		$context['aeva_maintenance_done'] = 'pending';
		$context['aeva_maintenance_message'] = sprintf($txt['aeva_admin_maintenance_operation_pending'], $total_done, $total_to_do);
		// Send the header
		aeva_refreshPage($scripturl . '?action=admin;area=aeva_maintenance;sa=regen' . ($album ? ';album=' . $album : '') . ';st=' . $_GET['st'] . ';start=' . $total_done . ';' . $context['session_var'] . '=' . $context['session_id']);
	}
	// We are done! We are done!!!
	else
		$context['aeva_maintenance_done'] = $total_received > 0;

	// If we didn't get the item count right, we might as well launch a recount...
	if ($total_received == 0)
		aeva_admin_maintenance_recount();
}

// Recounts totals
function aeva_admin_maintenance_recount()
{
	global $amFunc, $context;

	// Steps = 12
	// Recount total albums/unapproved albums
	// Recount total items and total items per album
	// Recount total comments and total comments per item
	// Recount unapproved items
	// Recount unapproved comments
	// Update id_last_media for each album
	// Update id_last_comment for each item
	// Recount members' total items
	// Recount members' total comments
	// Recount reported items
	// Recount reported comments
	// Reattribute current user names to their albums/pictures

	// Step 1
	$request = $amFunc['db_query']('
		SELECT COUNT(id_album) AS total, approved
		FROM {db_prefix}aeva_albums
		GROUP BY approved', array(),__FILE__,__LINE__);
	while ($row = $amFunc['db_fetch_assoc']($request))
		aeva_updateSettings($row['approved'] == 1 ? 'total_albums' : 'num_unapproved_albums', (int) $row['total']);
	$amFunc['db_free_result']($request);

	// Step 2
	$request = $amFunc['db_query']('
		SELECT COUNT(*) AS total_items, album_id
		FROM {db_prefix}aeva_media
		WHERE approved = 1
		GROUP BY album_id', array(),__FILE__,__LINE__);
	$done_albums = array();
	$total_items = 0;
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$total_items += $row['total_items'];
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_albums
			SET num_items = {int:items}
			WHERE id_album = {int:album}', array('items' => $row['total_items'], 'album' => $row['album_id']),__FILE__,__LINE__);
		$done_albums[] = $row['album_id'];
	}
	$amFunc['db_free_result']($request);
	$amFunc['db_query']('
		UPDATE {db_prefix}aeva_albums
		SET num_items = 0
		' . (!empty($done_albums) ? 'WHERE id_album NOT IN ({array_int:albums})' : ''),
		array(
			'albums' => $done_albums,
		),__FILE__,__LINE__);
	aeva_updateSettings('total_items', (int) $total_items);

	// Step 3
	$request = $amFunc['db_query']('
		SELECT COUNT(*) AS total_comments, id_media
		FROM {db_prefix}aeva_comments
		WHERE approved = 1
		GROUP BY id_media', array(),__FILE__,__LINE__);
	$total_comments = 0;
	$done_items = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$total_comments += $row['total_comments'];
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_media
			SET num_comments = {int:comments}
			WHERE id_media = {int:media}', array('comments' => $row['total_comments'], 'media' => $row['id_media']),__FILE__,__LINE__);
		$done_items[] = $row['id_media'];
	}
	$amFunc['db_free_result']($request);
	aeva_updateSettings('total_comments', (int) $total_comments);
	$amFunc['db_query']('
		UPDATE {db_prefix}aeva_media
		SET num_comments = 0
		' . (!empty($done_items) ? 'WHERE id_media NOT IN ({array_int:items})' : ''),
		array(
			'items' => $done_items,
		),__FILE__,__LINE__
	);

	// Step 4
	$request = $amFunc['db_query']('
		SELECT COUNT(*)
		FROM {db_prefix}aeva_media
		WHERE approved = 0', array(),__FILE__,__LINE__);
	list ($total_unapproved_items) = $amFunc['db_fetch_row']($request);
	$amFunc['db_free_result']($request);
	aeva_updateSettings('num_unapproved_items', (int) $total_unapproved_items);

	// Step 5
	$request = $amFunc['db_query']('
		SELECT COUNT(*)
		FROM {db_prefix}aeva_comments
		WHERE approved = 0', array(),__FILE__,__LINE__);
	list ($total_unapproved_comments) = $amFunc['db_fetch_row']($request);
	$amFunc['db_free_result']($request);
	aeva_updateSettings('num_unapproved_comments', (int) $total_unapproved_comments);

	// Step 6
	$request = $amFunc['db_query']('
		SELECT MAX(id_media) AS last_media, album_id
		FROM {db_prefix}aeva_media
		WHERE approved = 1
		GROUP BY album_id', array(),__FILE__,__LINE__);
	while ($row = $amFunc['db_fetch_assoc']($request))
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_albums
			SET id_last_media = {int:media}
			WHERE id_album = {int:album}', array('album' => $row['album_id'], 'media' => $row['last_media']),__FILE__,__LINE__);
	$amFunc['db_free_result']($request);

	// Step 7
	$request = $amFunc['db_query']('
		SELECT MAX(id_comment) AS last_comment, id_media
		FROM {db_prefix}aeva_comments
		WHERE approved = 1
		GROUP BY id_media', array(),__FILE__,__LINE__);
	while ($row = $amFunc['db_fetch_assoc']($request))
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_media
			SET id_last_comment = {int:comment}
			WHERE id_media = {int:media}', array('media' => $row['id_media'], 'comment' => $row['last_comment']),__FILE__,__LINE__);
	$amFunc['db_free_result']($request);

	// Step 8
	$request = $amFunc['db_query']('
		SELECT SUM(approved) AS total_media, id_member
		FROM {db_prefix}aeva_media
		GROUP BY id_member', array(),__FILE__,__LINE__);
	$done_mems = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$amFunc['db_query']('
			UPDATE {db_prefix}members
			SET aeva_items = {int:total}
			WHERE ID_MEMBER = {int:id}', array('id' => $row['id_member'], 'total' => $row['total_media']),__FILE__,__LINE__);
		$done_mems[] = $row['id_member'];
	}
	$amFunc['db_free_result']($request);
	$amFunc['db_query']('
		UPDATE {db_prefix}members
		SET aeva_items = 0' . (!empty($done_mems) ? '
		WHERE ID_MEMBER NOT IN ({array_int:mems})' : ''), array('mems' => $done_mems),__FILE__,__LINE__);

	// Step 9
	$request = $amFunc['db_query']('
		SELECT SUM(approved) AS total_comments, id_member
		FROM {db_prefix}aeva_comments
		GROUP BY id_member', array(),__FILE__,__LINE__);
	$done_mems = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$amFunc['db_query']('
			UPDATE {db_prefix}members
			SET aeva_comments = {int:total}
			WHERE ID_MEMBER = {int:id}', array('id' => $row['id_member'], 'total' => $row['total_comments']),__FILE__,__LINE__);
		$done_mems[] = $row['id_member'];
	}
	$amFunc['db_free_result']($request);
	$amFunc['db_query']('
		UPDATE {db_prefix}members
		SET aeva_comments = 0' . (!empty($done_mems) ? '
		WHERE ID_MEMBER NOT IN ({array_int:mems})' : ''),array('mems' => $done_mems),__FILE__,__LINE__);

	// Step 10
	$request = $amFunc['db_query']('
		SELECT COUNT(*)
		FROM {db_prefix}aeva_variables
		WHERE type = {string:type}', array('type' => 'item_report'),__FILE__,__LINE__);
	$total_reported_items = 0;
	list ($total_reported_items) = $amFunc['db_fetch_row']($request);
	$amFunc['db_free_result']($request);
	aeva_updateSettings('num_reported_items', (int) $total_reported_items);

	// Step 11
	$request = $amFunc['db_query']('
		SELECT COUNT(*)
		FROM {db_prefix}aeva_variables
		WHERE type = {string:type}', array('type' => 'comment_report'),__FILE__,__LINE__);
	$total_reported_comments = 0;
	list ($total_reported_comments) = $amFunc['db_fetch_row']($request);
	$amFunc['db_free_result']($request);
	aeva_updateSettings('num_reported_comments', (int) $total_reported_comments);

	// Step 12
	$request = $amFunc['db_query']('
		UPDATE {db_prefix}aeva_media AS m, {db_prefix}members AS mem
		SET m.member_name = mem.realName
		WHERE m.id_member = mem.id_member', array(), __FILE__,__LINE__);
	$request = $amFunc['db_query']('
		UPDATE {db_prefix}aeva_media AS m, {db_prefix}members AS mem
		SET m.last_edited_name = mem.realName
		WHERE m.last_edited_by = mem.id_member', array(), __FILE__,__LINE__);

	// Update weighted average ratings for all items
	aeva_updateWeighted();

	// Looks like we're done!
	$context['aeva_maintenance_done'] = true;
}

// Finds some errors
function aeva_admin_maintenance_finderrors()
{
	global $amFunc, $context, $txt, $scripturl, $amSettings, $galurl;

	$per_load = 250;
	$total = $amSettings['total_items'] + $amSettings['num_unapproved_items'];
	$errors = array();
	if (empty($_REQUEST['start']))
		$_SESSION['aeva_errors'] = array();
	if (isset($_SESSION['aeva_errors']))
		$errors = $_SESSION['aeva_errors'];

	// Do the hunky query to get the errors
	$request = $amFunc['db_query']('
		SELECT m.id_media, m.album_id, m.id_last_comment,
			m.id_file, f.filename AS file_name, f.directory AS file_dir,
			m.id_thumb, t.filename AS thumb_name, t.directory AS thumb_dir,
			m.id_preview, p.filename AS preview_name, p.directory AS preview_dir,
			IFNULL(f.id_file, {string:empty}) AS file_exists,
			IFNULL(t.id_file, {string:empty}) AS thumb_exists,
			IFNULL(p.id_file, {string:empty}) AS preview_exists,
			IFNULL(c.id_comment, {string:empty}) AS comment_exists, IFNULL(a.id_album, {string:empty}) AS album_exists
		FROM {db_prefix}aeva_media AS m
			LEFT JOIN {db_prefix}aeva_comments AS c ON (c.id_comment = m.id_last_comment)
			LEFT JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
			LEFT JOIN {db_prefix}aeva_files AS f ON (f.id_file = m.id_file)
			LEFT JOIN {db_prefix}aeva_files AS t ON (t.id_file = m.id_thumb)
			LEFT JOIN {db_prefix}aeva_files AS p ON (p.id_file = m.id_preview)
		ORDER BY m.id_media ASC
		LIMIT {int:start}, {int:per_page}', array('empty' => '', 'start' => (int) $_REQUEST['start'], 'per_page' => $per_load),__FILE__,__LINE__);

	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		// Check for missing files
		if ($row['id_file'] > 0 && empty($row['file_exists']))
			$errors[] = array(
				'type' => 'missing_db_file',
				'id' => $row['id_file'],
				'ref_id' => $row['id_media'],
			);
		if ($row['id_thumb'] > 4 && empty($row['thumb_exists']))
			$errors[] = array(
				'type' => 'missing_db_thumb',
				'id' => $row['id_thumb'],
				'ref_id' => $row['id_media'],
			);
		if ($row['id_preview'] > 4 && empty($row['preview_exists']))
			$errors[] = array(
				'type' => 'missing_db_preview',
				'id' => $row['id_preview'],
				'ref_id' => $row['id_media'],
			);
		if ($row['id_file'] > 0 && !empty($row['file_exists']) && !file_exists($amSettings['data_dir_path'].'/'.$row['file_dir'].'/'.aeva_getEncryptedFilename($row['file_name'], $row['id_file'])))
			$errors[] = array(
				'type' => 'missing_physical_file',
				'id' => $row['id_file'],
				'ref_id' => $row['id_media'],
			);
		if ($row['id_thumb'] > 4 && !empty($row['thumb_exists']) && !file_exists($amSettings['data_dir_path'].'/'.$row['thumb_dir'].'/'.aeva_getEncryptedFilename($row['thumb_name'], $row['id_thumb'], true)))
			$errors[] = array(
				'type' => 'missing_physical_thumb',
				'id' => $row['id_thumb'],
				'ref_id' => $row['id_media'],
			);
		if ($row['id_preview'] > 4 && !empty($row['preview_exists']) && !file_exists($amSettings['data_dir_path'].'/'.$row['preview_dir'].'/'.aeva_getEncryptedFilename($row['preview_name'], $row['id_preview'])))
			$errors[] = array(
				'type' => 'missing_physical_preview',
				'id' => $row['id_preview'],
				'ref_id' => $row['id_media'],
			);

		// Check for albums, comments
		if (empty($row['album_exists']))
			$errors[] = array(
				'type' => 'missing_album',
				'id' => $row['album_id'],
				'ref_id' => $row['id_media'],
			);
		if ($row['id_last_comment'] > 0 && empty($row['comment_exists']))
			$errors[] = array(
				'type' => 'missing_last_comment',
				'id' => $row['id_last_comment'],
				'ref_id' => $row['id_media'],
			);
	}
	$amFunc['db_free_result']($request);

	// Do we need to resume?
	if ($total - ((int) $_REQUEST['start'] + $per_load) > 0)
	{
		$context['aeva_maintenance_done'] = 'pending';
		$context['aeva_maintenance_message'] = sprintf($txt['aeva_admin_maintenance_finderror_pending'], (int) $_REQUEST['start'] + $per_load, $total, $scripturl . '?action=admin;area=aeva_maintenance;sa=finderrors;start=' . ((int) $_REQUEST['start'] + $per_load) . ';' . $context['session_var'] . '=' . $context['session_id']);
		$_SESSION['aeva_errors'] = $errors;
		return;
	}

	// Done with items... Now checking album access rights...
	$request = $amFunc['db_query']("
		SELECT id_album, name, parent, access, child_level
		FROM {db_prefix}aeva_albums AS a
		ORDER BY child_level, a_order", array(),__FILE__,__LINE__);

	$albums = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
		$albums[$row['id_album']] = array(
			'id' => $row['id_album'],
			'parent' => $row['parent'],
			'access' => explode(',', $row['access']),
			'child_level' => $row['child_level'],
		);
	$amFunc['db_free_result']($request);

	$changed_albums = array();
	foreach ($albums as $i => $a)
		if ($a['parent'] != 0)
			foreach ($a['access'] as $j => $acc)
				if (!in_array($acc, $albums[$a['parent']]['access']))
				{
					unset($albums[$i]['access'][$j]);
					$changed_albums[$i] = implode(',', $albums[$i]['access']);
				}

	if (count($changed_albums) > 0)
		foreach ($changed_albums as $i => $a)
		{
			$errors[] = array(
				'type' => 'parent_album_access',
				'id' => $i,
				'ref_id' => 0,
			);
			$amFunc['db_query']("
				UPDATE {db_prefix}aeva_albums
				SET access = {string:access}
				WHERE id_album = {int:album}",
				array(
					'album' => $i,
					'access' => $a,
				),__FILE__,__LINE__);
		}

	// Now, we will silently attribute big icons to albums that only have a small icon, where possible. (It's a quick query anyway...)
	// We take the album icon's parent item, and check its preview. If it's not empty, use it as the big icon. Otherwise, if it's empty but the item is a picture,
	// It means the file itself is small enough, so we use that. Otherwise, set the big icon to 0.
	$request = $amFunc['db_query']("
		UPDATE {db_prefix}aeva_albums AS a, {db_prefix}aeva_media AS m
		SET a.bigicon = IF(m.id_preview > 0, m.id_preview, IF(m.type = {string:image}, m.id_file, 0))
		WHERE a.bigicon = 0 AND a.icon != 0 AND m.id_thumb = a.icon", array('image' => 'image'),__FILE__,__LINE__);
	// Delete bigicon entries where the file's database entry doesn't exist. (Shouldn't happen, but I found one in my own gallery, so...)
	$request = $amFunc['db_query']("
		UPDATE {db_prefix}aeva_albums AS a
		LEFT JOIN {db_prefix}aeva_files AS m ON (m.id_file = a.bigicon)
		SET a.bigicon = 0
		WHERE (a.bigicon > 0 AND m.id_file IS NULL)", array(),__FILE__,__LINE__);

	// Time to compile the errors if any
	if (!empty($errors))
	{
		$_SESSION['aeva_errors'] = array();
		$context['aeva_maintenance_done'] = 'error';
		$context['aeva_maintenance_message'] = '<div style="font-weight: bold;">'.$txt['aeva_admin_finderrors_1'].'</div><ul style="margin-top: 0px; margin-bottom: 0px;">';
		foreach ($errors as $error)
			$context['aeva_maintenance_message'] .= '<li>'.sprintf($txt['aeva_admin_finderrors_'.$error['type']], $error['id'], $galurl . 'sa=item;in=' . $error['ref_id'], $error['ref_id']).'</li>';
		$context['aeva_maintenance_message'] .= '</ul>';
		return;
	}

	// If we've reached here, its all good!
	$context['aeva_maintenance_done'] = true;
	$context['aeva_maintenance_message'] = $txt['aeva_admin_finderrors_done'];
}

// Handles the pruning page
function aeva_admin_maintenance_prune()
{
	global $context, $amFunc, $txt, $scripturl, $user_info;

	// Load the albums
	if (empty($context['aeva_maintain_album']))
		aeva_getAlbums('', 0, false);

	// Pruning items?
	if (isset($_POST['submit_aeva']) && $_POST['pruning'] == 'item')
	{
		$where_query = array();
		$parameters = array();
		$joins = array();

		// Check for albums
		if (!isset($_REQUEST['all_albums']))
		{
			// No albums? huh dadadumdum
			if (!isset($_REQUEST['albums']) || empty($_REQUEST['albums']))
				fatal_lang_error('aeva_admin_no_albums');

			$albums = array();
			foreach ($_REQUEST['albums'] as $album)
				$albums[] = $album;

			$where_query[] = 'm.album_id IN ({string:albums})';
			$parameters['albums'] = implode(',',$albums);
		}

		// Check for x days old thing
		if ($_POST['days'] < 0)
			fatal_lang_error('aeva_admin_prune_invalid_days');
		$where_query[] = 'm.time_added < {int:min_time}';
		$parameters['min_time'] = time() - ((int) $_POST['days'] * 86400);

		// Maximum views?
		if (isset($_POST['max_views']) && !empty($_POST['max_views']) && $_POST['max_views'] > 0)
		{
			$where_query[] = 'm.views < {int:views}';
			$parameters['views'] = (int) $_POST['max_views'];
		}

		// Maximum comments?
		if (isset($_POST['max_coms']) && !empty($_POST['max_coms']) && $_POST['max_coms'] > 0)
		{
			$where_query[] = 'm.num_comments < {int:max_coms}';
			$parameters['max_coms'] = (int) $_POST['max_coms'];
		}

		// Last commented at?
		if (isset($_POST['last_comment_age']) && !empty($_POST['last_comment_age']) && $_POST['last_comment_age'] > 0)
		{
			$joins[] = 'INNER JOIN {db_prefix}aeva_comments AS c ON (c.id_comment = m.id_last_comment AND c.posted_on < {int:com_time})';
			$parameters['com_time'] = time() - ((int) $_POST['last_comment_age'] * 86400);
		}

		// Do the query and get the IDs
		$request = $amFunc['db_query']('
			SELECT m.id_media
			FROM {db_prefix}aeva_media AS m
				LEFT JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
				' . implode(' ', $joins) . '
			WHERE ' . implode(' AND ', $where_query),
			$parameters,__FILE__,__LINE__);
		$ids = array();
		while ($row = $amFunc['db_fetch_assoc']($request))
			$ids[] = $row['id_media'];
		$amFunc['db_free_result']($request);

		// Delete the items
		$deleted = aeva_deleteItems($ids, true, false);
		$opts = array(
			'type' => 'prune',
			'subtype' => 'item',
			'action_by' => array(
				'id' => $user_info['id'],
				'name' => $user_info['name'],
			),
			'extra_info' => array(
				'val8' => $deleted['items'],
			),
		);
		aeva_logModAction($opts);
		// Generate the reports and quit
		$context['aeva_maintenance_done'] = true;
		$context['aeva_maintenance_message'] = sprintf($txt['aeva_admin_prune_done_items'], $deleted['items'], $deleted['comments'], $deleted['files']);
		$context['sub_template'] = 'aeva_admin_maintenance';
		return;
	}

	// Maybe removing comments?
	if (isset($_POST['submit_aeva']) && $_POST['pruning'] = 'comments')
	{
		$where_query = array();
		$parameters = array();
		// Check for albums
		if (!isset($_REQUEST['all_albums']))
		{
			// No albums? huh dadadumdum
			if (empty($_REQUEST['albums']))
				fatal_lang_error('aeva_admin_no_albums');

			$albums = array();
			foreach ($_REQUEST['albums'] as $album)
				$albums[] = $album;

			$where_query[] = 'id_album IN ({string:albums})';
			$parameters['albums'] = implode(',',$albums);
		}
		// Check for x days old thing
		$where_query[] = 'posted_on < {int:min_time}';
		$parameters['min_time'] = time() - ((int) $_POST['days_com'] * 86400);

		// Do the query
		$request = $amFunc['db_query']('
			SELECT id_comment
			FROM {db_prefix}aeva_comments
			WHERE ' . implode(' AND ', $where_query),
			$parameters,__FILE__,__LINE__);
		$ids = array();
		while ($row = $amFunc['db_fetch_assoc']($request))
			$ids[] = $row['id_comment'];
		$amFunc['db_free_result']($request);

		// Delete the comments
		$deleted = aeva_deleteComments($ids, false, false);
		$opts = array(
			'type' => 'prune',
			'subtype' => 'comment',
			'action_by' => array(
				'id' => $user_info['id'],
				'name' => $user_info['name'],
			),
			'extra' => array(
				'val8' => $deleted['items'],
			),
		);
		aeva_logModAction($opts);
		// Generate the reports and quit
		$context['aeva_maintenance_done'] = true;
		$context['aeva_maintenance_message'] = sprintf($txt['aeva_admin_prune_done_comments'], $deleted);
		$context['sub_template'] = 'aeva_admin_maintenance';
		return;
	}

	// Maybe he/she hasn't submitted, show them the cool page
	$context['sub_template'] = 'aeva_admin_maintenance_prune';
}

// Rename all thumbnails (item & gallery icon)
function aeva_admin_maintenance_clear()
{
	global $amFunc, $context, $txt, $amSettings, $scripturl;

	$start = isset($_REQUEST['start']) ? (int) $_REQUEST['start'] : 0;
	$per_load = 300;

	if (empty($_REQUEST['total']))
	{
		$request = $amFunc['db_query']('
			SELECT COUNT(f.id_file)
			FROM {db_prefix}aeva_files AS f
			LEFT JOIN {db_prefix}aeva_media AS m ON (m.id_thumb = f.id_file)
			LEFT JOIN {db_prefix}aeva_albums AS a ON (a.icon = f.id_file)
			WHERE f.id_file > 4 AND (m.id_thumb > 0 OR a.icon > 0)',
			array(),__FILE__,__LINE__);
		list ($total) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);
	}
	else
		$total = (int) $_REQUEST['total'];

	$request = $amFunc['db_query']('
		SELECT f.id_file, f.directory, f.filename
		FROM {db_prefix}aeva_files AS f
		LEFT JOIN {db_prefix}aeva_media AS m ON (m.id_thumb = f.id_file)
		LEFT JOIN {db_prefix}aeva_albums AS a ON (a.icon = f.id_file)
		WHERE f.id_file > 4 AND (m.id_thumb > 0 OR a.icon > 0)
		LIMIT ' . $start . ',' . $per_load,
		array(),__FILE__,__LINE__);
	$items = $ids = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$ids[$row['id_file']] = $row['id_file'];
		$items[$row['id_file']] = $row;
		$items[$row['id_file']]['dir'] = $amSettings['data_dir_path'] . '/' . $row['directory'] . '/';
	}
	$amFunc['db_free_result']($request);
	$ids = array_unique($ids);

	foreach ($items as $id => $trucs)
	{
		if (isset($ids[$id]))
		{
			// Get both encrypted and unencrypted filename...
			$a = aeva_getEncryptedFilename($trucs['filename'], $id, false, true);
			// And rename them if needed.
			if (empty($amSettings['clear_thumbnames']))
			{
				if (file_exists($trucs['dir'] . $a[0]))
					rename($trucs['dir'] . $a[0], $trucs['dir'] . $a[1]);
			}
			else
			{
				if (file_exists($trucs['dir'] . $a[1]))
					rename($trucs['dir'] . $a[1], $trucs['dir'] . $a[0]);
			}
		}
	}

	// Do we need to resume?
	if ($start + $per_load < $total)
	{
		$context['aeva_maintenance_done'] = 'pending';
		$context['aeva_maintenance_message'] = sprintf($txt['aeva_admin_maintenance_clear_pending'], $start + $per_load, $total, $scripturl . '?action=admin;area=aeva_maintenance;sa=clear;start=' . ((int) $_REQUEST['start'] + $per_load) . ';total=' . $total . ';' . $context['session_var'] . '=' . $context['session_id']);
		return;
	}

	$context['aeva_maintenance_done'] = true;
	$context['aeva_maintenance_message'] = $txt['aeva_admin_maintenance_clear_done'];
}

// Checks for extra/wasted files
function aeva_admin_maintenance_checkfiles()
{
	global $amFunc, $context, $txt, $amSettings, $scripturl;

	// Empty the tmp folder no matter what...
	aeva_emptyTmpFolder();

	// Find file table entries that aren't used in the media table (neither as a thumbnail, preview, full file or icon)
	$extra_size = 0;
	$extra_items = array();
	$request = $amFunc['db_query']('
		SELECT f.id_file, f.filename, f.directory, f.filesize
		FROM {db_prefix}aeva_files AS f
			LEFT JOIN {db_prefix}aeva_media AS m ON (f.id_file = m.id_file OR f.id_file = m.id_thumb OR f.id_file = m.id_preview)
			LEFT JOIN {db_prefix}aeva_albums AS a ON (a.id_album = f.id_album)
		WHERE (m.id_media IS NULL AND a.icon != f.id_file AND a.bigicon != f.id_file) OR (f.id_album > 0 AND a.id_album IS NULL)
		AND f.id_file > 4',
		array(),__FILE__,__LINE__);
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$extra_size += $row['filesize'];
		$dir = $amSettings['data_dir_path'].'/'.$row['directory'].'/';
		$both = aeva_getEncryptedFilename($row['filename'], $row['id_file'], false, true);
		$extra_items[$row['id_file']] = !file_exists($dir.$both[0]) ? (!file_exists($dir.$both[1]) ? $dir . '???' : $dir.$both[1]) : $dir.$both[0];
	}

	if (isset($_REQUEST['delete']))
	{
		$total_deleted = 0;
		foreach ($extra_items as $id_file => $file_dest)
		{
			$amFunc['db_query']("
				DELETE FROM {db_prefix}aeva_files
				WHERE id_file = {int:id}",array('id' => $id_file),__FILE__,__LINE__);
			@unlink($file_dest);
			$total_deleted++;
		}
		$context['aeva_maintenance_done'] = true;
		$context['aeva_maintenance_message'] = sprintf($txt['aeva_admin_maintenance_checkfiles_done'], $total_deleted, round($extra_size/1024));
	}
	else
	{
		if (empty($extra_items))
		{
			$context['aeva_maintenance_done'] = true;
			$context['aeva_maintenance_message'] = $txt['aeva_admin_maintenance_checkfiles_no_files'];
		}
		else
		{
			$context['aeva_maintenance_done'] = 'error';
			$context['aeva_maintenance_message'] = sprintf($txt['aeva_admin_maintenance_checkfiles_found'], count($extra_items), round($extra_size/1024), $scripturl . '?action=admin;area=aeva_maintenance;sa=checkfiles;delete;' . $context['session_var'] . '=' . $context['session_id']);
			$context['aeva_maintenance_message'] .= '<ul class="normallist margintop"><li class="largepadding">' . implode('</li><li class="largepadding">', $extra_items) . '</li></ul>';
		}
	}
}

function aeva_cleanTree($directory, $phase, $start_from = '')
{
	global $orphans, $cancel_scan, $not_there_yet;

	if ($cancel_scan)
		return;

	if ($handle = opendir($directory))
	{
		while (($file = readdir($handle)) !== false)
		{
			if ($file == '.' || $file == '..')
				continue;

			$dirfile = $directory . '/' . $file;

			if ($not_there_yet)
			{
				if ($dirfile == $start_from)
					$not_there_yet = false;
			}
			elseif (aeva_timeSpent() > 10)
			{
				$cancel_scan = $dirfile;
				break;
			}

			if (is_dir($dirfile))
			{
				if ($file != 'generic_images' && $file != 'ftp' && $file != 'tmp' && (!$not_there_yet || $dirfile == substr($start_from, 0, strlen($dirfile))))
					aeva_cleanTree($dirfile, $phase, $start_from);
			}
			elseif ($file != 'index.php' && !$not_there_yet)
			{
				// If we're currently searching for orphans, delete file if it is one.
				if ($phase == 2 && substr($file, 0, 19) != 'temp_orphans_check_')
				{
					$orphans[] = $dirfile;
					unlink($dirfile);
				}
				// If we're done searching for orphans, rename legitimate files back to their correct name.
				elseif ($phase == 3 && substr($file, 0, 19) == 'temp_orphans_check_')
					rename($dirfile, $directory . '/' . substr($file, 19));
			}
		}
		closedir($handle);
	}
}

// Checks for orphans - files that are not used by the database, at all.
function aeva_admin_maintenance_checkorphans()
{
	global $amFunc, $context, $txt, $amSettings, $scripturl, $orphans, $cancel_scan;

	// Empty the tmp folder no matter what...
	aeva_emptyTmpFolder();
	$context['aeva_maintenance_done'] = 'pending';
	$album = isset($context['aeva_maintain_album']) ? $context['aeva_maintain_album'] : 0;
	$url_album = $album ? ';album=' . $album : '';

	// Start off by deleting temp variables, in case we're relaunching the process.
	if (!isset($_GET['phase']))
	{
		$_SESSION['aeva_orphans'] = array();

		// This code is only there to clean up data from earlier SMG2 betas. There is no need to execute it on regular copies of Aeva Media.
		$amFunc['db_query']('
			DELETE FROM {db_prefix}aeva_settings
			WHERE name IN ({string:notouch}, {string:unk}, {string:orphans})',
			array('notouch' => 'notouch', 'unk' => 'unknown_files', 'orphans' => 'orphans'), __FILE__,__LINE__
		);
		unset($amSettings['notouch'], $amSettings['orphans']);
		$amFunc['db_query']('OPTIMIZE TABLE {db_prefix}aeva_settings', array(), __FILE__,__LINE__);
		$request = $amFunc['db_query']('SELECT COUNT(DISTINCT id_file) FROM {db_prefix}aeva_files WHERE ' . ($album ? 'id_album = {int:album}' : 'id_file > 4'), array('album' => $album),__FILE__,__LINE__);
		list ($total_files) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);
		aeva_updateSettings('total_files', $total_files, true);
		$context['aeva_maintenance_message'] = 'Phase 1/3 - ' . sprintf($txt['aeva_admin_maintenance_operation_pending'], 0, $amSettings['total_files']);
		aeva_refreshPage($scripturl . '?action=admin;area=aeva_maintenance;sa=checkorphans' . $url_album . ';phase=1;start=0;' . $context['session_var'] . '=' . $context['session_id']);
		return;
	}

	$orphans = isset($_SESSION['aeva_orphans']) ? $_SESSION['aeva_orphans'] : array();
	$cancel_scan = false;

	$path = $amSettings['data_dir_path'];
	if ($album && ($_GET['phase'] == 2 || $_GET['phase'] == 3))
	{
		$request = $amFunc['db_query']('
			SELECT directory
			FROM {db_prefix}aeva_albums
			WHERE id_album = {int:album}
			LIMIT 1', array('album' => $album),__FILE__,__LINE__);
		list ($path_dir) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);
		$path .= '/' . $path_dir;
	}

	// Phase 1: Get the list of files from the database, and add a suffix to them.
	if ($_GET['phase'] == 1)
	{
		$start = isset($_GET['start']) ? (int) $_GET['start'] : 0;
		$request = $amFunc['db_query']('
			SELECT f.id_file, f.filename, f.directory, (m.id_thumb > 0 OR a.icon > 0) AS is_thumb
			FROM {db_prefix}aeva_files AS f
			LEFT JOIN {db_prefix}aeva_media AS m ON (m.id_thumb = f.id_file)
			LEFT JOIN {db_prefix}aeva_albums AS a ON (a.icon = f.id_file)
			WHERE f.id_file > 4' . ($album ? '
			AND (f.id_album = {int:album} OR a.id_album = {int:album})' : '') . '
			GROUP BY f.id_file
			LIMIT ' . $start . ',500', array('album' => $album),__FILE__,__LINE__);
		$items_left = $amFunc['db_num_rows']($request);
		$items_done = 0;

		while ($row = $amFunc['db_fetch_assoc']($request))
		{
			$dir = $amSettings['data_dir_path'] . '/' . $row['directory'] . '/';
			$notouch = aeva_getEncryptedFilename($row['filename'], $row['id_file'], (bool) $row['is_thumb']);
			if (file_exists($dir . $notouch) && !@rename($dir . $notouch, $dir . 'temp_orphans_check_' . $notouch))
			{
				$context['aeva_maintenance_done'] = 'error';
				$context['aeva_maintenance_message'] = 'Renaming operation failed. Please check your file permission settings.';
				return;
			}
			$items_done++;

			if (aeva_timeSpent() > 5)
				break;
		}
		$amFunc['db_free_result']($request);

		// Let the server breathe -- relaunch the script.
		$context['aeva_maintenance_message'] = sprintf($txt['aeva_admin_maintenance_operation_phase'], 1, 3) . ' - ' . sprintf($txt['aeva_admin_maintenance_operation_pending'], $start + $items_done, $amSettings['total_files']);
		// Send the header
		aeva_refreshPage($scripturl . '?action=admin;area=aeva_maintenance;sa=checkorphans' . $url_album . ';phase=' . ($items_left < 500 && $items_done == $items_left ? '2' : '1;start=' . ($start + $items_done)) . ';' . $context['session_var'] . '=' . $context['session_id']);
		return;
	}

	// Phase 2: Go through the folders and delete those that don't have the suffix.
	if ($_GET['phase'] == 2)
	{
		$start = isset($_GET['start']) ? base64_decode($_GET['start']) : '';
		$not_there_yet = $start == '';
		$items_done = 0;

		aeva_cleanTree($path, 2, $start);

		$_SESSION['aeva_orphans'] = $orphans;

		// Let the server breathe -- relaunch the script.
		$context['aeva_maintenance_message'] = sprintf($txt['aeva_admin_maintenance_operation_phase'], 2, 3) . ' - ' . $txt['aeva_admin_maintenance_operation_pending_raw'];
		// Send the header
		aeva_refreshPage($scripturl . '?action=admin;area=aeva_maintenance;sa=checkorphans' . $url_album . ';phase=' . ($cancel_scan ? '2;start=' . base64_encode($cancel_scan) : '3') . ';' . $context['session_var'] . '=' . $context['session_id']);
		return;
	}

	// Phase 3: Rename legitimate files back to their correct name.
	if ($_GET['phase'] == 3)
	{
		$start = isset($_GET['start']) ? base64_decode($_GET['start']) : '';
		$not_there_yet = $start == '';
		$items_done = 0;

		aeva_cleanTree($path, 3, $start);

		// Let the server breathe -- relaunch the script.
		$context['aeva_maintenance_message'] = sprintf($txt['aeva_admin_maintenance_operation_phase'], 3, 3) . ' - ' . $txt['aeva_admin_maintenance_operation_pending_raw'];
		// Send the header
		aeva_refreshPage($scripturl . '?action=admin;area=aeva_maintenance;sa=checkorphans' . $url_album . ';phase=' . ($cancel_scan ? '3;start=' . base64_encode($cancel_scan) : 'done') . ';' . $context['session_var'] . '=' . $context['session_id']);
		return;
	}

	if ($_GET['phase'] == 'done')
	{
		if (empty($orphans))
		{
			$context['aeva_maintenance_done'] = true;
			$context['aeva_maintenance_message'] = $txt['aeva_admin_maintenance_checkorphans_no_files'];
		}
		else
		{
			$context['aeva_maintenance_done'] = 'error';
			$context['aeva_maintenance_message'] = sprintf($txt['aeva_admin_maintenance_checkorphans_done'], count($orphans));
			$context['aeva_maintenance_message'] .= '<ul class="normallist margintop"><li class="largepadding">' . implode('</li><li class="largepadding">', $orphans) . '</li></ul>';
		}
		unset($_SESSION['aeva_orphans']);
	}
}

// Handles the ban homepage
function aeva_admin_bans()
{
	global $amFunc, $context, $txt, $galurl, $scripturl;

	// Sub-actions
	$sa = array(
		'add' => array('aeva_admin_bans_add', false),
		'edit' => array('aeva_admin_bans_edit', false),
		'delete' => array('aeva_admin_bans_delete', true),
	);
	if (isset($_REQUEST['sa'], $sa[$_REQUEST['sa']]))
		if (!$sa[$_REQUEST['sa']][1])
			return $sa[$_REQUEST['sa']][0]();
		else
			$sa[$_REQUEST['sa']][0]();

	// Load the bans

	// Get the count
	$request = $amFunc['db_query']('
		SELECT COUNT(*)
		FROM {db_prefix}aeva_variables
		WHERE type = {string:ban}',
		array('ban' => 'ban'),__FILE__,__LINE__);
	list ($total_logs) = $amFunc['db_fetch_row']($request);
	$amFunc['db_free_result']($request);

	// Get the logs
	$request = $amFunc['db_query']('
		SELECT v.id, v.val1, v.val2, v.val3, v.val4, mem.realName AS real_name
		FROM {db_prefix}aeva_variables AS v
			INNER JOIN {db_prefix}members AS mem ON (mem.ID_MEMBER = v.val1)
		WHERE v.type = {string:ban}
		ORDER BY v.val2 DESC
		LIMIT {int:start}, {int:limit}',
		array(
			'ban' => 'ban',
			'start' => (int) $_REQUEST['start'],
			'limit' => 20,
		),__FILE__,__LINE__);
	$context['aeva_bans'] = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$context['aeva_bans'][] = array(
			'id' => $row['id'],
			'banned' => array(
				'id' => $row['val1'],
				'name' => $row['real_name'],
			),
			'banned_on' => $amFunc['time_format']($row['val4']),
			'expires_on' => $row['val3'] > 0 ? $amFunc['time_format']($row['val3']) : $txt['aeva_never'],
			'type_int' => $row['val2'],
			'type_txt' => $txt['aeva_admin_ban_type_'.$row['val2']],
		);
	}
	$amFunc['db_free_result']($request);

	// Get the index
	$_REQUEST['start'] = empty($_REQUEST['start']) ? 0 : (int) $_REQUEST['start'];
	$context['aeva_page_index'] = $amFunc['construct_page_index']($scripturl . '?action=admin;area=aeva_bans;' . $context['session_var'] . '=' . $context['session_id'], $_REQUEST['start'], $total_logs, 20);

	// Finish it off
	$context['sub_template'] = 'aeva_admin_bans';
}

// Adds a ban
function aeva_admin_bans_add()
{
	global $amFunc, $context, $txt, $scripturl, $settings;

	// Any "u"s we are getting?
	$context['aeva_curr_members'] = array();
	if (isset($_REQUEST['u']))
	{
		// Get the members
		$request = $amFunc['db_query']('
			SELECT ID_MEMBER AS id_member, realName AS real_name
			FROM {db_prefix}members
			WHERE ID_MEMBER = {int:mem}',
			array(
				'mems' => (int) $_REQUEST['u'],
			),__FILE__,__LINE__);

		while ($row = $amFunc['db_fetch_assoc']($request))
			$context['aeva_curr_members'][] = '"'.$row['real_name'].'"';

		$amFunc['db_free_result']($request);
	}
	$context['aeva_curr_members'] = implode(',',$context['aeva_curr_members']);

	// Construct the form
	$context['aeva_form_url'] = $scripturl . '?action=admin;area=aeva_bans;sa=add;' . $context['session_var'] . '=' . $context['session_id'];
	$context['aeva_form'] = array(
		'banning' => array(
			'fieldname' => 'banning',
			'type' => 'text',
			'value' => $context['aeva_curr_members'],
			'label' => $txt['aeva_admin_banning'] . ' <a href="' . $scripturl . '?action=findmember;input=banning;' . $context['session_var'] . '=' . $context['session_id'] . '" onclick="return reqWin(this.href, 350, 400);" ><img src="' . $settings['images_url'] . '/icons/assist.gif" alt="findmember" border="0" /></a>',
			'custom' => 'id="banning"',
		),
		'type' => array(
			'fieldname' => 'type',
			'type' => 'radio',
			'options' => array(
				1 => $txt['aeva_admin_ban_type_1'],
				2 => $txt['aeva_admin_ban_type_2'],
				3 => $txt['aeva_admin_ban_type_3'],
				4 => $txt['aeva_admin_ban_type_4'],
			),
			'label' => $txt['aeva_admin_ban_type'],
		),
		'expires_on' => array(
			'fieldname' => 'expires_on',
			'type' => 'small_text',
			'label' => $txt['aeva_admin_expires_on'],
			'subtext' => $txt['aeva_admin_expires_on_help'],
		),
	);
	$context['sub_template'] = 'aeva_form';

	// Adding?
	if (isset($_POST['submit_aeva']))
	{
		// Divvy out the usernames, remove extra space.
		$mems = strtr(addslashes($amFunc['htmlspecialchars'](stripslashes($_POST['banning']), ENT_QUOTES)), array('&quot;' => '"'));
		preg_match_all('~"([^"]+)"~', $mems, $matches);
		$mems = array_merge($matches[1], explode(',', preg_replace('~"([^"]+)"~', '', $mems)));
		for ($k = 0, $n = count($mems); $k < $n; $k++)
		{
			$who[$k] = trim($mems[$k]);
			if (strlen($mems[$k]) == 0)
				unset($mems[$k]);
		}
		if (empty($mems))
			fatal_lang_error('aeva_admin_bans_mems_empty');
		$mems = $mems[0];

		// Get the ID
		$request = $amFunc['db_query']('
			SELECT ID_MEMBER AS id_member
			FROM {db_prefix}members
			WHERE realName = {string:name} OR memberName = {string:name}',
			array(
				'name' => $mems,
			),__FILE__,__LINE__);
		list ($id_mem) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);

		if (!isset($id_mem) || $id_mem == 0)
			fatal_lang_error('aeva_admin_bans_mems_not_found');

		$request = $amFunc['db_query']('
			SELECT id
			FROM {db_prefix}aeva_variables
			WHERE type = {string:ban}
			AND val1 = {int:id_member}',
			array(
				'ban' => 'ban',
				'id_member' => $id_mem
			),__FILE__,__LINE__);

		if ($amFunc['db_num_rows']($request) > 0)
			fatal_lang_error('aeva_admin_already_banned');
		$amFunc['db_free_result']($request);

		// Let's translate the expires_on
		$expires_on = (int) $_POST['expires_on'];
		if ($expires_on > 0)
			$expires_on = time() + ($expires_on * 86400);

		// Type
		$type = (int) $_POST['type'];
		if ($type < 1 || $type > 4)
			$type = 1;

		// Insert it
		$amFunc['db_insert'](
			'{db_prefix}aeva_variables',
			array('type', 'val1', 'val2', 'val3', 'val4'),
			array('ban', $id_mem, $type, $expires_on, time()),
			__FILE__,__LINE__);

		// Log it
		$opts = array(
			'type' => 'ban',
			'subtype' => 'add',
			'action_on' => array(
				'id' => $id_mem,
				'name' => $mems,
			),
			'action_by' => array(
				'id' => $context['user']['id'],
				'name' => $context['user']['name'],
			),
			'extra_info' => array(
				'val8' => $type,
				'val9' => $expires_on,
			),
		);
		aeva_logModAction($opts);

		redirectexit($scripturl . '?action=admin;area=aeva_bans;' . $context['session_var'] . '=' . $context['session_id']);
	}
}

// Deletes a ban entry
function aeva_admin_bans_delete()
{
	global $amFunc, $user_info;

	// Let's get some important data
	$request = $amFunc['db_query']('
		SELECT v.val1, v.val2, mem.realName AS real_name
		FROM {db_prefix}aeva_variables AS v
			LEFT JOIN {db_prefix}members AS mem ON (mem.ID_MEMBER = v.val1)
		WHERE id = {int:id}
		AND type = {string:type}',
		array(
			'id' => (int) $_REQUEST['in'],
			'type' => 'ban',
		),__FILE__,__LINE__);
	if ($amFunc['db_num_rows']($request) == 0)
		return;
	list ($id_mem, $type, $mem_name) = $amFunc['db_fetch_row']($request);
	$amFunc['db_free_result']($request);

	// Delete it
	$amFunc['db_query']('
		DELETE FROM {db_prefix}aeva_variables
		WHERE id = {int:id}
		AND type = {string:type}',
		array(
			'id' => (int) $_REQUEST['in'],
			'type' => 'ban',
		),__FILE__,__LINE__);

	// Log it
	$opts = array(
		'type' => 'ban',
		'subtype' => 'delete',
		'action_on' => array(
			'id' => $id_mem,
			'name' => $mem_name,
		),
		'action_by' => array(
			'id' => $user_info['id'],
			'name' => $user_info['name'],
		),
		'extra_info' => array(
			'val8' => $type,
		),
	);
	aeva_logModAction($opts);
}

// Edits a ban entry
function aeva_admin_bans_edit()
{
	global $amFunc, $context, $txt, $scripturl, $settings;

	// Get this item's data
	$request = $amFunc['db_query']('
		SELECT v.val1, v.val2, v.val3, v.val4, mem.realName AS real_name
		FROM {db_prefix}aeva_variables AS v
			INNER JOIN {db_prefix}members AS mem ON (v.val1 = mem.ID_MEMBER)
		WHERE type = {string:type}
		AND id = {int:id}',
		array(
			'type' => 'ban',
			'id' => (int) $_REQUEST['in'],
		),__FILE__,__LINE__);
	if ($amFunc['db_num_rows']($request) == 0)
		fatal_lang_error('aeva_ban_not_found');
	$ban = $amFunc['db_fetch_assoc']($request);
	$amFunc['db_free_result']($request);

	// Construct the form
	$context['aeva_form_url'] = $scripturl . '?action=admin;area=aeva_bans;sa=edit;in=' . $_REQUEST['in'] . ';' . $context['session_var'] . '=' . $context['session_id'];
	$context['aeva_form'] = array(
		'banning' => array(
			'fieldname' => 'banning',
			'type' => 'text',
			'value' => $ban['real_name'],
			'label' => $txt['aeva_admin_banning'],
			'custom' => 'id="banning"',
		),
		'type' => array(
			'fieldname' => 'type',
			'type' => 'radio',
			'options' => array(
				1 => array($txt['aeva_admin_ban_type_1'], $ban['val2'] == 1),
				2 => array($txt['aeva_admin_ban_type_2'], $ban['val2'] == 2),
				3 => array($txt['aeva_admin_ban_type_3'], $ban['val2'] == 3),
				4 => array($txt['aeva_admin_ban_type_4'], $ban['val2'] == 4),
			),
			'label' => $txt['aeva_admin_ban_type'],
		),
		'expires_on' => array(
			'fieldname' => 'expires_on',
			'type' => 'small_text',
			'label' => $txt['aeva_admin_expires_on'],
			'value' => $ban['val3'] > 0 ? round(($ban['val3'] - $ban['val4']) / 86400) : 0,
			'subtext' => $txt['aeva_admin_expires_on_help'],
		),
	);
	$context['sub_template'] = 'aeva_form';

	// Adding?
	if (isset($_POST['submit_aeva']))
	{
		// Divvy out the usernames, remove extra space.
		$mems = strtr(addslashes($amFunc['htmlspecialchars'](stripslashes($_POST['banning']), ENT_QUOTES)), array('&quot;' => '"'));
		preg_match_all('~"([^"]+)"~', $mems, $matches);
		$mems = array_merge($matches[1], explode(',', preg_replace('~"([^"]+)"~', '', $mems)));
		for ($k = 0, $n = count($mems); $k < $n; $k++)
		{
			$who[$k] = trim($mems[$k]);
			if (strlen($mems[$k]) == 0)
				unset($mems[$k]);
		}
		$mems = $mems[0];

		// Get the ID
		$request = $amFunc['db_query']('
			SELECT ID_MEMBER AS id_member
			FROM {db_prefix}members
			WHERE realName = {string:name} OR memberName = {string:name}',
			array(
				'name' => $mems,
			),__FILE__,__LINE__);
		list ($id_mem) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);

		// Let's translate the expires_on
		$expires_on = (int) $_POST['expires_on'];
		if ($expires_on > 0)
			$expires_on = time() + ($expires_on * 86400);

		// Type
		$type = (int) $_POST['type'];
		if ($type < 1 || $type > 4)
			$type = 1;

		// Insert it
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_variables
			SET val1 = {int:mem},
			val2 = {int:type},
			val3 = {int:expires_on}
			WHERE id = {int:id}',
			array(
				'mem' => $id_mem,
				'type' => $type,
				'expires_on' => $expires_on,
				'id' => (int) $_REQUEST['in'],
			),__FILE__,__LINE__);

		redirectexit($scripturl . '?action=admin;area=aeva_bans;' . $context['session_var'] . '=' . $context['session_id']);
	}
}

?>