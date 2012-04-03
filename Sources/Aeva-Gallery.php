<?php
/****************************************************************
* Aeva Media													*
* � Noisen.com & SMF-Media.com									*
*****************************************************************
* Aeva-Gallery.php - main gallery-related actions				*
*****************************************************************
* Users of this software are bound by the terms of the			*
* Aeva Media license. You can view it in the license_am.txt		*
* file, or online at http://noisen.com/license.php				*
*																*
* Support and updates for this software can be found at			*
* http://aeva.noisen.com and http://smf-media.com				*
****************************************************************/

if (!defined('SMF'))
	die('Hacking Attempt...');

/*
	The core and heart of Aeva Media, it handles all the actions and requests.

	void aeva_initGallery(string gal_url = null)
		- Initializes and handles the gallery. Calls the function corresponding to your request
		- Accessed by ?action=media
		- $gal_url can be used to customize the gallery's URL for external integration

	void aeva_home()
		- Handles the Aeva Media homepage
		- Called when no valid sub-action is found

	void aeva_viewAlbum()
		- Accessed by ;sa=album;in=x
		- Handles the viewing of a single album

	void aeva_viewItem()
		- Accessed by ;sa=item;in=x
		- Handles the viewing of a single item

	void aeva_mgComment()
		- Accessed by ;sa=comment;in=x
		- Handles the commenting of an item

	void aeva_mgReport()
		- Accessed by ;sa=report;in=x
		- Handles reporting of an item

	void aeva_mgPost()
		- Accessed by ;sa=post;(id/album)=x
		- Handles adding/editing an item
		- If an id is specified, it means we're editing
		- If album is specified, it means we're adding

	void aeva_mgEdit()
		- Accessed by ;sa=edit;type=comment;in=x
		- Currently only handles editing of comments

	void aeva_mgEditCom()
		- Accessed by aeva_mgEdit function to edit a comment

	void aeva_delete()
		- Accessed by ;sa=delete;type=(item/comment);in=x
		- Deletes an item or comment

	void aeva_mgApprove()
		- Accessed by ;sa=(approve/unapprove);in=x
		- Approves/Unapproves an item

	void aeva_addView()
		- Adds a view count to an embedded video (through Ajax)

	void aeva_getMedia()
		- Accessed by ;sa=media;in=x(;type=(thumb/preview/icon))
		- Outputs a file, either as an embedded item, or downloadable
*/

function aeva_initGallery($gal_url = null)
{
	global $sourcedir, $amFunc, $amSettings, $user_info, $galurl, $scripturl, $galurl2, $txt, $context, $settings;

	// Call the important file
	require_once($sourcedir . '/Aeva-Subs.php');

	// Load stuff
	aeva_loadSettings($gal_url, true, true);

	// If you are not allowed to enter......What are you doing here?
	if (!aeva_allowedTo('access') && (!isset($_REQUEST['sa']) || $_REQUEST['sa'] != 'media'))
		fatal_lang_error('aeva_accessDenied', !empty($amSettings['log_access_errors']));

	// Is the user banned?
	aeva_is_not_banned();

	// For compatibility with earlier URLs...
	if ($_REQUEST['action'] == 'mgallery')
		$_REQUEST['action'] = 'media';

	// Load album before calling the function
	// !!! Temp stuff... Need a better way to do this
	$context['aeva_act'] = isset($_REQUEST['area']) ? $_REQUEST['area'] : (isset($_REQUEST['sa']) ? $_REQUEST['sa'] : '');
	$context['aeva_sa'] = isset($_REQUEST['do']) ? $_REQUEST['do'] : '';

	// In case I (or you) forgot to change an ;id= variable...
	if (isset($_REQUEST['in']) && !isset($_REQUEST['id']))
		$_REQUEST['id'] = $_GET['id'] = $_REQUEST['in'];
	// This one should prevent broken links from outside your gallery
	elseif (isset($_REQUEST['id']) && !isset($_REQUEST['in']))
		$_REQUEST['in'] = $_GET['in'] = $_REQUEST['id'];

	aeva_loadAlbum();

	// Load all our areas
	$areas = array(
		'home' => array(
			'title' => $txt['aeva_home'],
			'icon' => 'house.png',
			'href' => $galurl2,
			'function' => 'aeva_home',
			'default' => true,
		),
		'album' => array('function' => 'aeva_viewAlbum'),
		'item' => array('function' => 'aeva_viewItem'),
		'media' => array('function' => 'aeva_getMedia'),
		'admin' => array(
			'title' => $txt['aeva_admin'],
			'icon' => 'cog.png',
			'href' => $scripturl . '?action=admin;area=aeva_about;' . $context['session_var'] . '=' . $context['session_id'],
			'enabled' => aeva_allowedTo('manage'),
		),
		'post' => array(
			'enabled' => !$user_info['is_guest'],
			'function' => 'aeva_mgPost',
		),
		'comment' => array(
			'enabled' => aeva_allowedTo('comment'),
			'function' => 'aeva_mgComment',
		),
		'report' => array('function' => 'aeva_mgReport'),
		'delete' => array('function' => 'aeva_delete'),
		'edit' => array('function' => 'aeva_mgEdit'),
		'approve' => array('function' => 'aeva_mgApprove'),
		'unapprove' => array('function' => 'aeva_mgApprove'),
		'stats' => array(
			'file' => 'Aeva-Gallery2.php',
			'function' => 'aeva_mgStats',
		),
		'unseen' => array(
			'title' => $txt['aeva_unseen'],
			'icon' => 'eye.png',
			'enabled' => aeva_allowedTo('access_unseen'),
			'file' => 'Aeva-Gallery2.php',
			'function' => 'aeva_unseen',
		),
		'search' => array(
			'title' => $txt['aeva_search'],
			'icon' => 'magnifier.png',
			'enabled' => aeva_allowedTo('search'),
			'file' => 'Aeva-Gallery2.php',
			'function' => 'aeva_mgSearch',
		),
		'vua' => array(
			'file' => 'Aeva-Gallery2.php',
			'function' => 'aeva_listAlbums',
		),
		'move' => array(
			'file' => 'Aeva-Gallery2.php',
			'function' => 'aeva_moveItems',
		),
		'mya' => array(
			'title' => $txt['aeva_my_user_albums'],
			'description' => $txt['aeva_user_albums_desc'],
			'icon' => 'user.png',
			'enabled' => aeva_allowedTo('add_user_album'),
			'file' => 'Aeva-Gallery2.php',
			'function' => 'aeva_albumCP',
			'url_index' => 'area',
			'sub_url_index' => 'sa',
			'sub_areas' => array(
				'add' => array(
					'enabled' => aeva_allowedTo('add_user_album'),
					'title' => 'aeva_admin_add_album',
				),
			),
		),
		'mass' => array(
			'enabled' => aeva_allowedTo('multi_upload'),
			'file' => 'Aeva-Gallery2.php',
			'function' => 'aeva_massUpload',
		),
		'whoratedwhat' => array(
			'enabled' => aeva_allowedTo('whoratedwhat'),
			'file' => 'Aeva-Gallery2.php',
			'function' => 'aeva_whoRatedWhat',
		),
		'smgtaghelp' => array(
			'file' => 'Aeva-Gallery2.php',
			'function' => 'aeva_tagHelper',
		),
		'moderate' => array(
			'title' => $txt['aeva_modcp'],
			'description' => $txt['aeva_modcp_desc'],
			'enabled' => aeva_allowedTo('moderate'),
			'file' => 'Aeva-ModCP.php',
			'function' => 'aeva_modCP',
			'url_index' => 'area',
			'sub_url_index' => 'sa',
			'icon' => 'report.png',
			'sub_areas' => array(
				'about' => array('enabled' => true, 'title' => 'aeva_admin_labels_about', 'default' => true),
				'readme' => array('enabled' => true, 'title' => 'aeva_admin_readme'),
				'changelog' => array('enabled' => true, 'title' => 'aeva_admin_changelog'),
				'submissions' => array(
					'enabled' => true,
					'skip_main_func' => true,
					'title' => 'aeva_admin_labels_submissions',
					'description' => $txt['aeva_admin_subs_desc'],
					'function' => 'aeva_modCP_submissions',
				),
				'reports' => array(
					'enabled' => true,
					'skip_main_func' => true,
					'title' => 'aeva_admin_labels_reports',
					'description' => $txt['aeva_admin_reports_desc'],
					'function' => 'aeva_modCP_reports',
				),
				'modlog' => array(
					'enabled' => true,
					'skip_main_func' => true,
					'title' => 'aeva_admin_labels_modlog',
					'description' => $txt['aeva_admin_modlog_desc'],
					'function' => 'aeva_modCP_modLog',
				),
			),
		),
		'massdown' => array(
			'enabled' => aeva_allowedTo('multi_download'),
			'file' => 'Aeva-Gallery2.php',
			'function' => 'aeva_massDownload',
			'sub_areas' => array(
				'create' => array(
					'file' => 'Aeva-Gallery2.php',
					'function' => 'aeva_massDownloadCreate',
					'skip_main_func' => true,
				),
			),
		),
		'playlists' => array(
			'enabled' => $context['aeva_foxy'],
			'file' => 'Aeva-Foxy.php',
			'function' => 'aeva_foxy_playlist',
		),
		'quickmod' => array(
			'file' => 'Aeva-Gallery.php',
			'function' => 'aeva_quickmodAlbum',
		),
		'rss' => array(
			'enabled' => $context['aeva_foxy'],
			'file' => 'Aeva-Foxy.php',
			'function' => 'aeva_foxy_rss',
		),
		'addview' => array('function' => 'aeva_addView'),
	);

	if (!isset($_REQUEST['xml']))
	{
		$context['template_layers'][] = 'aeva';

		// Start the linktree
		$context['linktree'] = array();
		$amFunc['add_linktree']($scripturl, $context['forum_name']);
		if (empty($context['current_board']))
			$amFunc['add_linktree']($galurl2, $txt['aeva_gallery']);

		// Some CSS and JS we'll be using
		$context['html_headers'] .= '
	<link rel="stylesheet" type="text/css" href="' . aeva_theme_url('am.css') . '" />' . (isset($_REQUEST['sa']) && $_REQUEST['sa'] == 'mass' ? '
	<link rel="stylesheet" type="text/css" href="' . aeva_theme_url('up.css') . '" />' : '') . '
	<script type="text/javascript" src="' . aeva_theme_url('am.js') . '"></script>';

		if (($context['browser']['is_firefox'] && $pfx = 'moz') || ($context['browser']['is_safari'] && $pfx = 'webkit'))
			$context['html_headers'] .= '
	<style type="text/css">
		.pics td { -' . $pfx . '-border-radius: 5px; }
		.aeva_rounded { -' . $pfx . '-border-radius: 5px; }
	</style>';
	}

	$context['aeva_header'] = array(
		'tabs' => array(),
		'areatabs' => array(),
		'subtabs' => array(),
		'data' => array(),
	);
	$data = array();
	$data['files'] = array();
	$data['functions'] = array();
	$context['aeva_sa'] = $context['aeva_act'] = '';

	// Determine the sub-action... Load all of the functions we need
	foreach ($areas as $area => $details)
	{
		// Not enabled?
		if (isset($areas[$area]['enabled']) && empty($areas[$area]['enabled']))
		{
			unset($areas[$area]);
			continue;
		}

		// Load the action... Is it this one?
		$urlvar = isset($details['url_index']) ? (isset($_REQUEST[$details['url_index']]) ? $_REQUEST[$details['url_index']] : '') : (isset($_REQUEST['sa']) ? $_REQUEST['sa'] : '');

		if (!empty($urlvar) && $urlvar == $area)
		{
			// Make sure we don't load anything else
			$data['functions'] = array();
			if (!empty($areas[$area]['file']))
				$data['files'][$area] = $sourcedir . '/' . $areas[$area]['file'];
			if (!empty($areas[$area]['function']))
				$data['functions'][$area] = $areas[$area]['function'];
			$areas[$area]['current'] = $area;
			$context['aeva_act'] = $urlvar;
		}

		// Sub-actions?
		if (!empty($details['sub_areas']) && !empty($areas[$area]['current']))
		{
			$surlvar = isset($details['sub_url_index']) ? (isset($_REQUEST[$details['sub_url_index']]) ? $_REQUEST[$details['sub_url_index']] : '') : (isset($_REQUEST['do']) ? $_REQUEST['do'] : '');

			// Add them to the tab data
			foreach ($areas[$area]['sub_areas'] as $sa => $sadetails)
			{
				// Not enabled? Skip off...
				if (empty($areas[$area]['sub_areas'][$sa]['enabled']))
				{
					unset($areas[$area]['sub_areas'][$sa]['enabled']);
					continue;
				}

				if (!empty($sadetails['title']))
					$context['aeva_header']['areatabs'][$sa] = array(
						'title' => $sadetails['title'],
						'active' => $surlvar == $sa || (empty($surlvar) && !empty($sadetails['default'])),
						'url' => isset($areas[$area]['href']) ? $areas[$area]['href'] : $galurl . (isset($areas[$area]['url_index']) ? $areas[$area]['url_index'] : 'sa') . '=' . $area . ';' . (isset($details['sub_url_index']) ? $details['sub_url_index'] : 'do') . '=' . $sa,
					);
			}

			if (!empty($surlvar) || isset($areas[$area]['sub_areas']))
			{
				// Do we need to skip the main init function?
				if (!empty($areas[$area]['sub_areas'][$surlvar]['skip_main_func']))
					unset($data['functions'][$area]);

				if (!empty($areas[$area]['sub_areas'][$surlvar]['function']))
					$data['functions'][] = $areas[$area]['sub_areas'][$surlvar]['function'];

				$context['aeva_sa'] = $surlvar;
			}
		}

		if (!empty($areas[$area]['default']) && empty($data['functions']) && empty($urlvar))
			$data['functions'][] = $areas[$area]['function'];

		// Got any tab data to implement?
		if (!empty($details['description']) && !empty($areas[$area]['current']))
			$context['aeva_header']['data']['description'] = isset($current_sa) && isset($details['sub_areas'][$current_sa]['description']) ? $details['sub_areas'][$current_sa]['description'] : $details['description'];

		// Tab it...:P
		if (empty($areas[$area]['title']))
			continue;

		$context['aeva_header']['tabs'][$area] = array(
			'title' => $areas[$area]['title'],
			'url' => isset($areas[$area]['href']) ? $areas[$area]['href'] : $galurl . (isset($areas[$area]['url_index']) ? $areas[$area]['url_index'] : 'sa') . '=' . $area,
			'active' => !empty($areas[$area]['current']),
			'icon' => !empty($areas[$area]['icon']) ? $areas[$area]['icon'] : '',
		);
	}

	// Are we empty?
	if (empty($data['functions']))
		fatal_lang_error('aeva_accessDenied', !empty($amSettings['log_access_errors']));

	// Call the files and function
	foreach ($data['files'] as $file)
		require_once($file);
	foreach ($data['functions'] as $func)
		call_user_func($func);
}

function aeva_home()
{
	// This function loads up Aeva Media's home page
	global $galurl, $txt, $amFunc, $context, $amSettings, $user_info;

	// Templates
	$context['sub_template'] = 'aeva_home';

	$context['aeva_current'] = 'home';
	$context['aeva_welcome'] = parse_bbc(!empty($amSettings['welcome']) ? $amSettings['welcome'] : (isset($txt['aeva_welcome']) ? $txt['aeva_welcome'] : $txt['aeva_default_welcome']));

	if ($user_info['is_admin'])
	{
		$is_dir = aeva_foolProof();
		if ($is_dir !== 1)
			$context['aeva_welcome'] .= '<br /><br /><div style="color: red">' . $txt[$is_dir ? 'aeva_admin_album_dir_failed' : 'aeva_not_a_dir'] . '</div>';;
	}

	// Load the albums
	aeva_getAlbums('a.featured = 1', 1, true, true, '', false, true, true);
	$delete = array();
	foreach ($context['aeva_albums'] as $id => $album)
		if (!empty($album['parent']) && !empty($context['aeva_albums'][$album['parent']]) && $context['aeva_albums'][$album['parent']]['featured'])
			$delete[] = $id;
	if (!empty($delete))
		foreach ($delete as $id)
			unset($context['aeva_albums'][$id]);
	unset($delete);

	// This query could be cached later on...
	$result = $amFunc['db_query']('
		SELECT id_album
		FROM {db_prefix}aeva_albums AS a
		WHERE approved = 1
		AND featured = 0
		LIMIT 1',array(),__FILE__,__LINE__);
	$context['show_albums_link'] = $amFunc['db_num_rows']($result) > 0;
	$amFunc['db_free_result']($result);

	// Load up some side stuff, only when required
	$context['recent_items'] = array();
	$context['recent_comments'] = array();
	$context['random_items'] = array();
	$context['recent_albums'] = array();

	if (!empty($amSettings['recent_item_limit']) && $amSettings['recent_item_limit'] > 0)
	{
		// Get some variables ready
		$start = isset($_REQUEST['start']) ? (int) $_REQUEST['start'] : 0;
		$per_page = max(1, min(200, (int) $amSettings['recent_item_limit']));

		// Count the number of items this user can see... (excluding unbrowsable & unallowed albums)
		$request = $amFunc['db_query']('
			SELECT COUNT(id_media)
			FROM {db_prefix}aeva_media AS m
			INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
			WHERE {query_see_album}
			LIMIT 1', array(),__FILE__,__LINE__
		);
		list ($count_items) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);
		$sort = aeva_sortBox(false, $count_items, $start, $per_page);
		$context['recent_items'] = aeva_getMediaItems($start, $per_page, $sort);
		aeva_addHeaders(true);
	}
	if (!empty($amSettings['random_item_limit']) && $amSettings['random_item_limit'] > 0)
	{
		$context['random_items'] = aeva_getMediaItems(0, $amSettings['random_item_limit'], 'RAND()');
		aeva_addHeaders(true);
	}
	if (!empty($amSettings['recent_comments_limit']) && $amSettings['recent_comments_limit'] > 0)
		$context['recent_comments'] = aeva_getMediaComments(0, $amSettings['recent_comments_limit']);
	if (!empty($amSettings['recent_albums_limit']) && $amSettings['recent_albums_limit'] > 0)
		$context['recent_albums'] = aeva_getMediaAlbums(0, $amSettings['recent_albums_limit']);

	// Page title
	$context['aeva_header']['data']['title'] = $txt['aeva_home'];
	$context['page_title'] = $txt['aeva_gallery'];
}

function aeva_sortBox($current_album, $count_items, $start, $per_page, $persort = 'm.id_media DESC')
{
	global $amFunc, $amSettings, $context, $galurl;

	$context['aeva_urlmore'] = (isset($_REQUEST['sort']) ? 'sort=' . (int) $_REQUEST['sort'] . ';' : '') . (isset($_REQUEST['asc']) ? 'asc;' : '') . (isset($_REQUEST['desc']) ? 'desc;' : '');

	$sort = preg_match('~^(m\.[a-z_]+) (A|DE)SC$~', $persort, $dt) ? $persort : 'm.id_media DESC';

	$context['aeva_sort'] = $dt[1];
	$context['aeva_asc'] = $dt[2] == 'A';

	if (!empty($context['aeva_urlmore']))
	{
		$sort_list = array('m.id_media', 'm.time_added', 'm.title', 'm.views', 'm.weighted');
		$context['aeva_sort'] = $sort = isset($_REQUEST['sort']) ? $sort_list[max(0, min(4, (int) $_REQUEST['sort']))] : $dt[1];
		$context['aeva_asc'] = isset($_REQUEST['asc']) && !isset($_REQUEST['desc']) ? true : (in_array($sort, array('m.time_added', 'm.title')) && !isset($_REQUEST['desc']) ? true : false);
		$sort .= $context['aeva_asc'] ? ' ASC' : ' DESC';
	}

	$context['aeva_urlmore'] .= $current_album ? ($current_album['view'] == 'normal' ? 'nw' : 'fw') : (isset($_REQUEST['fw']) ? 'fw' : 'nw');
	$pageIndexURL = $current_album ? $galurl . 'sa=album;in=' . $current_album['id'] . ';' : $galurl;

	// Construct the page index
	$context['aeva_page_index'] = $amFunc['construct_page_index']($pageIndexURL . $context['aeva_urlmore'], $start, $count_items, $per_page);

	// For templates (stack change...)
	$context['aeva_urlmore'] = substr($context['aeva_urlmore'], 0, -3);
	return $sort;
}

function aeva_viewAlbum()
{
	// This function's job is to handle stuff when someone is viewing a album.
	global $amFunc, $context, $txt, $amSettings, $user_info, $galurl, $scripturl;

	$album = isset($_REQUEST['in']) ? (int) $_REQUEST['in'] : 0;
	$current_album = &$context['aeva_album'];

	if (empty($album) || empty($current_album))
		fatal_lang_error('aeva_album_denied', !empty($amSettings['log_access_errors']));
	if (!empty($current_album['hidden']) && !aeva_allowedTo('moderate') && ($user_info['is_guest'] || $current_album['owner']['id'] !== $user_info['id']))
		fatal_lang_error('aeva_album_denied', !empty($amSettings['log_access_errors']));

	if (isset($_REQUEST['markseen']))
	{
		checkSession('get');
		$request = $amFunc['db_query']('
			SELECT m.id_media
			FROM {db_prefix}aeva_media AS m
				INNER JOIN {db_prefix}aeva_albums AS a ON (m.album_id = a.id_album)
				LEFT JOIN {db_prefix}aeva_log_media AS lm ON (lm.id_media = m.id_media AND lm.id_member = {int:user})
				LEFT JOIN {db_prefix}aeva_log_media AS lm_all ON (lm_all.id_media = 0 AND lm_all.id_member = {int:user})
			WHERE {query_see_album}
			AND IFNULL(lm.time, IFNULL(lm_all.time, 0)) < m.log_last_access_time
			AND a.id_album = {int:album}' . (!aeva_allowedTo('moderate') ? '
			AND m.approved = 1' : ''), array('album' => $album, 'user' => $user_info['id']), __FILE__,__LINE__);
		list ($total_items) = $amFunc['db_num_rows']($request);
		while ($row = $amFunc['db_fetch_row']($request))
			if ((int) $row[0] > 0)
				aeva_markSeen((int) $row[0], 'force_insert');
		$amFunc['db_free_result']($request);
		aeva_resetUnseen($user_info['id']);
	}
	else
	{
		// How many unseen items in this album?
		$request = $amFunc['db_query']('
			SELECT COUNT(m.id_media)
			FROM {db_prefix}aeva_media AS m
				INNER JOIN {db_prefix}aeva_albums AS a ON (m.album_id = a.id_album)
				LEFT JOIN {db_prefix}aeva_log_media AS lm ON (lm.id_media = m.id_media AND lm.id_member = {int:user})
				LEFT JOIN {db_prefix}aeva_log_media AS lm_all ON (lm_all.id_media = 0 AND lm_all.id_member = {int:user})
			WHERE {query_see_album}
			AND IFNULL(lm.time, IFNULL(lm_all.time, 0)) < m.log_last_access_time
			AND a.id_album = {int:album}' . (!aeva_allowedTo('moderate') ? '
			AND m.approved = 1' : '') . '
			LIMIT 1', array('album' => $album, 'user' => $user_info['id']), __FILE__,__LINE__);
		list ($total_items) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);
	}

	if (empty($total_items) && !$user_info['is_guest'])
	{
		// Quick test to see if we should optimize the log_media table...
		$request = $amFunc['db_query']('
			SELECT id_media FROM {db_prefix}aeva_log_media WHERE id_media > 0 AND id_member = {int:user} LIMIT 1',
			array('user' => $user_info['id']),__FILE__,__LINE__);
		list ($remaining) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);

		if (empty($remaining))
			aeva_markAllSeen();
	}

	$context['aeva_header']['data']['title'] = $txt['aeva_album'];
	$current_album['type2'] = $current_album['featured'] ? $txt['aeva_featured_album'] : $txt['aeva_album'];

	$context['aeva_can_add_item'] = $current_album['can_upload'] && aeva_allowedTo(array('moderate', 'add_videos', 'add_embeds', 'add_audios', 'add_images', 'add_docs'), true);
	$context['aeva_can_multi_upload'] = $context['aeva_can_add_item'] && aeva_allowedTo('multi_upload');

	// Load the sub-albums
	aeva_getAlbums('a.master = ' . $current_album['master'], 1, true, true, '', false, true, true);
	$context['aeva_sub_albums'] = array();
	foreach ($context['aeva_album_list'] as $album)
		if ($context['aeva_albums'][$album]['parent'] == $current_album['id'])
			$context['aeva_sub_albums'][$album] = $context['aeva_albums'][$album];
	$master_album = &$context['aeva_albums'][$current_album['master']];

	// What is the view eh?
	$current_album['view'] = isset($_REQUEST['nw']) ? 'normal' : (isset($_REQUEST['fw']) ? 'filestack' : (!empty($current_album['options']['view']) ? $current_album['options']['view'] : 'normal'));

	// Get some variables ready
	$start = isset($_REQUEST['start']) ? (int) $_REQUEST['start'] : 0;
	$per_page = max(1, min(200, (int) $amSettings['num_items_per_page']));
	$sort = aeva_sortBox($current_album, $current_album['num_items'], $start, $per_page, isset($current_album['options'], $current_album['options']['sort']) ? $current_album['options']['sort'] : 'm.id_media DESC');
	if ($context['aeva_foxy'] && function_exists('aeva_foxy_my_playlists'))
		$context['aeva_my_playlists'] = aeva_foxy_my_playlists();

	// Load the items, finally!
	$context['no_items'] = false;
	$context['aeva_items'] = aeva_getMediaItems($start, $per_page, $sort, false);

	// Make the linktree
	$amFunc['add_linktree']($galurl . 'sa=vua', $txt['aeva_albums']);
	if (!empty($master_album['owner']['id']))
		$amFunc['add_linktree']($scripturl . '?action=profile;u=' . $master_album['owner']['id'] . ($context['is_smf2'] ? ';area' : ';sa') . '=aeva', $master_album['owner']['name']);

	$parents = array_reverse(aeva_getAlbumParents($current_album['id'], $current_album['master']));
	foreach ($parents as $p)
		$amFunc['add_linktree']($galurl . 'sa=album;in=' . $p['id'], $p['name']);

	// Finish this by loading the template and page title
	$context['album_data'] = $current_album;
	$context['sub_template'] = 'aeva_viewAlbum';
	$context['page_title'] = $current_album['name'];

	aeva_addHeaders(true, empty($current_album['options']['autosize']) || $current_album['options']['autosize'] == 'yes');
}

function aeva_PrevNextThumb($myurl, &$prev)
{
	global $galurl, $amSettings;

	return array(!empty($prev[3]) && !empty($prev[2]) && !empty($amSettings['clear_thumbnames']) ?
		$myurl . '/' . str_replace('%2F', '/', urlencode($prev[3])) . '/' . aeva_getEncryptedFilename($prev[4], $prev[2], true)
		: $galurl . 'sa=media;in=' . $prev[0] . ';thumb', $prev[5], $prev[6]);
}

function aeva_viewItem()
{
	// Funtion which comes in role when you'are viewing a single item
	global $amFunc, $scripturl, $galurl, $txt, $amSettings, $user_info, $context, $db_prefix, $memberContext, $settings, $boarddir, $sourcedir;

	// Item's id
	$item = isset($_REQUEST['in']) ? (int) $_REQUEST['in'] : 0;
	if (empty($item))
		fatal_lang_error('aeva_item_not_found', !empty($amSettings['log_access_errors']));

	$reload_data = false;
	// Get the item info!
	$item_data = aeva_getItemData($item);
	$item_data['last_edited_by'] = !empty($item_data['last_edited_by']) && $item_data['last_edited_by'] != $item_data['id_member'] ? $item_data['last_edited_by'] : -2;
	$path = $amSettings['data_dir_path'] . '/' . $item_data['directory'] . '/' . aeva_getEncryptedFilename($item_data['filename'], $item_data['id_file']);
	$cur_filesize = @filesize($path);
	$context['aeva_size_mismatch'] = $item_data['filesize'] != $cur_filesize && !empty($item_data['filesize']) && $cur_filesize !== false;

	// Get per-album settings
	$peralbum = unserialize($item_data['options']);
	unset($item_data['options']);
	$peralbum['outline'] = !empty($peralbum['outline']) && in_array($peralbum['outline'], array('drop-shadow', 'rounded-white')) ? $peralbum['outline'] : 'drop-shadow';
	$peralbum['autosize'] = !empty($peralbum['autosize']) && $peralbum['autosize'] == 'no' ? 'no' : 'yes';
	$amSettings['use_lightbox'] &= empty($peralbum['lightbox']) || $peralbum['lightbox'] == 'yes';
	$context['aeva_has_preview'] = (bool) $item_data['has_preview'];
	$amSettings['show_linking_code'] = empty($amSettings['show_linking_code']) || ($item_data['type'] == 'unknown') ? 0 : (1 + (file_exists($boarddir . '/MGalleryItem.php') ? 0 : 1));

	// If we got so far, the user can see this item, so mark it as seen if it's new!
	if ($item_data['is_new'] && aeva_markSeen($item_data['id_media']))
		aeva_resetUnseen($user_info['id']);

	if (isset($_REQUEST['noh']) && $context['aeva_foxy'])
		aeva_foxy_insert_tag($item_data['id_media'], str_replace(array("'", '"'), array('\\\'', '\\\'\\\''), un_htmlspecialchars($item_data['title'])), $item_data);

	// Handle rating and stuff
	// Any previous rates?
	$request = $amFunc['db_query']('
		SELECT rating
		FROM {db_prefix}aeva_log_ratings
		WHERE id_member = {int:user_id}
		AND id_media = {int:media_id}',
		array('user_id' => $user_info['id'], 'media_id' => $item_data['id_media']),__FILE__,__LINE__);
	// Allowed to re-rate? OK then re-rate the item!
	$row = $amFunc['db_fetch_assoc']($request);
	if ($amFunc['db_num_rows']($request) > 0)
	{
		$item_data['user_rated'] = true;
		$item_data['user_rating'] = $row['rating'];
	}
	else
	{
		$item_data['user_rated'] = false;
		$item_data['user_rating'] = 0;
	}
	$amFunc['db_free_result']($request);

	// Any rating being sent?
	if (isset($_POST['rating']))
	{
		// Make sure the user is allowed to rate
		if (!aeva_allowedTo('rate_items'))
			fatal_lang_error('aeva_rate_denied');

		// Make sure it is valid
		$rating = (int) $_POST['rating'];
		if (!is_numeric($rating) || $rating < 0 || $rating > 5)
			fatal_lang_error('aeva_invalid_rating');

		// Re-Rating?
		if ($item_data['user_rated'])
		{
			if ($amSettings['enable_re-rating'] == '0')
				fatal_lang_error('aeva_re-rating_denied');

			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_media
				SET rating = rating - {int:rating}
				WHERE id_media = {int:media}',array('rating' => $row['rating'], 'media' => $item_data['id_media']),__FILE__,__LINE__);

			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_media
				SET rating = rating + {int:rating}
				WHERE id_media = {int:media}',array('rating' => $rating, 'media' => $item_data['id_media']),__FILE__,__LINE__);

			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_log_ratings
				SET rating = {int:rating}
				WHERE id_member = {int:member}
					AND id_media = {int:media}',array('rating' => $rating, 'member' => $user_info['id'], 'media' => $item_data['id_media']),__FILE__,__LINE__);
		}
		else
		{
			// OK Insert a new rating
			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_media
				SET rating = rating + {int:rating}, voters = voters + 1
				WHERE id_media = {int:media}',
				array('rating' => $rating, 'media' => $item_data['id_media']),__FILE__,__LINE__);

			$amFunc['db_insert'](
				$db_prefix . 'aeva_log_ratings',
				array('id_media', 'id_member', 'rating', 'time'),
				array($item_data['id_media'], $user_info['id'], $rating, time()),
				__FILE__,__LINE__);
		}
		aeva_updateWeighted();

		// Get the item info!
		$item_data = aeva_getItemData($item);

		$request = $amFunc['db_query']('
			SELECT rating
			FROM {db_prefix}aeva_log_ratings
			WHERE id_member = {int:user_id}
			AND id_media = {int:media_id}',
			array('user_id' => $user_info['id'], 'media_id' => $item_data['id_media']),__FILE__,__LINE__);
		// Allowed to re-rate? OK then re-rate the item!
		$row = $amFunc['db_fetch_assoc']($request);
		if ($amFunc['db_num_rows']($request) > 0)
		{
			$item_data['user_rated'] = true;
			$item_data['user_rating'] = $row['rating'];
		}
		else
		{
			$item_data['user_rated'] = false;
			$item_data['user_rating'] = 0;
		}
		$amFunc['db_free_result']($request);
	}

	// Rating an item
	$item_data['avg_rating'] = $item_data['voters'] > 0 ? ($item_data['rating']/$item_data['voters']) : 0;
	$item_data['can_rate'] = aeva_allowedTo('rate_items') && (!$item_data['user_rated'] || $amSettings['enable_re-rating'] == '1');

	// XML?
	if (isset($_REQUEST['xml'], $_POST['rating']))
	{
		$context['item_data'] = $item_data;
		$context['sub_template'] = 'aeva_xml_rated';
		return true;
	}

	// Playlists
	if ($context['aeva_foxy'])
		$item_data['playlists'] = aeva_foxy_item_page_playlists($item_data['id_media']);

	$item_data['keyword_list'] = aeva_getTags($item_data['keywords']);

	// Comments........
	$start = isset($_REQUEST['start']) ? (int) $_REQUEST['start'] : 0;
	$per_page = 20;
	$sort = isset($_REQUEST['com_desc']) ? 'DESC' : 'ASC';

	$pageIndexURL = $galurl.'sa=item;in='.$item_data['id_media'];
	if (isset($_REQUEST['com_desc']))
		$pageIndexURL .= ';com_desc';
	$item_data['com_page_index'] = $amFunc['construct_page_index']($pageIndexURL, $start, $item_data['num_comments'], $per_page);

	// Comment query!
	$result = $amFunc['db_query']('
		SELECT
			com.id_comment, com.id_member, com.id_media, com.message, com.posted_on,
			com.last_edited, com.last_edited_by, com.last_edited_name, com.approved
		FROM {db_prefix}aeva_comments AS com
		WHERE com.id_media = {int:media}
		{raw:approvals}
		ORDER BY com.id_comment {raw:sort}
		LIMIT {int:start},{int:per_page}',
		array('media' => $item_data['id_media'], 'sort' => $sort, 'per_page' => $per_page, 'approvals' => !aeva_allowedTo('moderate') ? 'AND (com.approved = 1 OR com.id_member = '.$user_info['id'].')' : '', 'start' => $start),__FILE__,__LINE__);
	$item_data['comments'] = array();
	$item_data['no_comments'] = false;
	$members = array();
	$counter = $start;

	// Include lightbox here to avoid further issues
	if ($amSettings['use_lightbox'])
	{
		$context['mg_headers_sent'] = true;
		$context['html_headers'] .= '
	<link rel="stylesheet" type="text/css" href="'.aeva_theme_url('hs.css').'" media="screen" />' . aeva_initLightbox($peralbum['autosize'], $peralbum);
	}

	if ($amFunc['db_num_rows']($result) > 0)
	{
		if ($sort == 'DESC')
			$counter = $item_data['num_comments'] + 1;
		// Build the array
		while ($row = $amFunc['db_fetch_assoc']($result))
		{
			$counter += ($sort == 'DESC' ? -1 : 1);
			$item_data['comments'][$row['id_comment']] = array(
				'id_comment' => $row['id_comment'],
				'members' => $row['id_member'],
				'member' => array('id' => 0),
				'message' => $amFunc['parse_bbc']($row['message']),
				'posted_on' => $amFunc['time_format']($row['posted_on']),
				'is_edited' => !empty($row['last_edited']) && $row['last_edited'] != '0',
				'last_edited' => array(
					'id' => $row['last_edited_by'] != $row['id_member'] ? $row['last_edited_by'] : -2,
					'name' => $row['last_edited_name'],
					'link' => $row['last_edited_by'] != $row['id_member'] ? aeva_profile($row['last_edited_by'], $row['last_edited_name']) : '',
					'on' => $amFunc['time_format']($row['last_edited']),
				),
				'counter' => $counter,
				'can_edit' => aeva_allowedTo('moderate') || (aeva_allowedTo('edit_own_com') && $row['id_member'] == $user_info['id']),
				'can_report' => aeva_allowedTo('report_com'),
				'approved' => $row['approved'],
			);
			$item_data['comments'][$row['id_comment']]['can_delete'] = $item_data['comments'][$row['id_comment']]['can_edit'] || (aeva_allowedTo('moderate_own_albums') && $item_data['id_member'] == $user_info['id']);
		}
		foreach ($item_data['comments'] as $mem)
			$members[] = $mem['members'];

		$confirmed_members = loadMemberData(array_unique($members));

		foreach ($item_data['comments'] as $k => $com)
		{
			if (!$confirmed_members || !in_array($com['members'], $confirmed_members))
				continue;
			loadMemberContext($item_data['comments'][$k]['members']);
			$item_data['comments'][$k]['member'] = $co = $memberContext[$com['members']];
			$item_data['comments'][$k]['member_link'] = aeva_profile($co['id'], $co['name']);
		}
	}
	else
		$item_data['no_comments'] = true;

	$amFunc['db_free_result']($result);

	// Done with comments, now prepare the item's data itself

	// Get some variables ready (just as in aeva_viewAlbum)
	$urlmore = (isset($_REQUEST['sort']) ? ';sort=' . (int) $_REQUEST['sort'] : '') . (isset($_REQUEST['asc']) ? ';asc' : '') . (isset($_REQUEST['desc']) ? ';desc' : '');
	$persort = !empty($peralbum['sort']) ? $peralbum['sort'] : 'm.id_media DESC';
	$sort = preg_match('~^m\.([a-z_]+) (A|DE)SC$~', $persort, $dt) ? $persort : 'm.id_media DESC';
	$context['aeva_sort'] = !empty($dt[1]) ? $dt[1] : 'id_media';
	$context['aeva_asc'] = !empty($dt[2]) && $dt[2] == 'A';

	if (!empty($urlmore))
	{
		$sort_list = array('id_media', 'time_added', 'title', 'views', 'weighted');
		$sort = isset($_REQUEST['sort']) ? $sort_list[max(0, min(4, (int) $_REQUEST['sort']))] : $dt[1];
		$m_asc = isset($_REQUEST['asc']) && !isset($_REQUEST['desc']) ? true : (in_array($sort, array('m.time_added', 'm.title')) && !isset($_REQUEST['desc']) ? true : false);
		$sort .= $m_asc ? ' ASC' : ' DESC';
	}

	// Get the next and previous item link
	$item_data['next'] = $item_data['prev'] = 0;
	$item_data['next2'] = $item_data['prev2'] = 0;
	$myurl = $amSettings['data_dir_url'];

	// Get the complete list of pictures in this album...
	$request = $amFunc['db_query']('
		SELECT m.id_media, m.title, t.id_file, t.directory, t.filename, t.width, t.height
		FROM {db_prefix}aeva_media AS m
		LEFT JOIN {db_prefix}aeva_files AS t ON (t.id_file = m.id_thumb)
		WHERE m.album_id = {int:current_album} {raw:approvals}
		ORDER BY ' . $sort,
		array(
			'current_album' => $item_data['album_id'],
			'approvals' => !aeva_allowedTo('moderate') ? 'AND (approved = 1 OR id_member = '.$user_info['id'].')' : ''
		),__FILE__,__LINE__);

	// And fetch the ones just before and just after the current one.
	$cur = -1;
	$prevnext = array();
	while ($row = $amFunc['db_fetch_row']($request))
	{
		if ($row[0] == $item_data['id_media'])
			$cur = count($prevnext);
		$prevnext[] = $row;
	}
	$amFunc['db_free_result']($request);

	// Try to keep prev/next titles on a single line
	$mtl = 20;
	$item_data['current_title'] = aeva_cutString($item_data['title'], $mtl);
	$item_data['current_thumb'] = aeva_PrevNextThumb($myurl, $prevnext[$cur]);
	$item_data['prev_page'] = $cur > 1 ? $prevnext[max(0, $cur-5)][0] . $urlmore : 0;
	$item_data['prev2'] = $cur > 1 ? $prevnext[$cur-2][0] . $urlmore : 0;
	$item_data['prev2_title'] = $cur > 1 ? aeva_cutString($prevnext[$cur-2][1], $mtl) : '';
	$item_data['prev2_thumb'] = $cur <= 1 ? '' : aeva_PrevNextThumb($myurl, $prevnext[$cur-2]);
	$item_data['prev'] = $cur > 0 ? $prevnext[$cur-1][0] . $urlmore : 0;
	$item_data['prev_title'] = $cur > 0 ? aeva_cutString($prevnext[$cur-1][1], $mtl) : '';
	$item_data['prev_thumb'] = $cur <= 0 ? '' : aeva_PrevNextThumb($myurl, $prevnext[$cur-1]);
	$maxc = count($prevnext) - 1;
	$item_data['next'] = $cur < $maxc ? $prevnext[$cur+1][0] . $urlmore : 0;
	$item_data['next_title'] = $cur < $maxc ? aeva_cutString($prevnext[$cur+1][1], $mtl) : '';
	$item_data['next_thumb'] = $cur >= $maxc ? '' : aeva_PrevNextThumb($myurl, $prevnext[$cur+1]);
	$item_data['next2'] = $cur < $maxc - 1 ? $prevnext[$cur+2][0] . $urlmore : 0;
	$item_data['next2_title'] = $cur < $maxc - 1 ? aeva_cutString($prevnext[$cur+2][1], $mtl) : '';
	$item_data['next2_thumb'] = $cur >= $maxc - 1 ? '' : aeva_PrevNextThumb($myurl, $prevnext[$cur+2]);
	$item_data['next_page'] = $cur < $maxc ? $prevnext[min($maxc, $cur+5)][0] . $urlmore : 0;
	unset($prevnext);

	if ($context['aeva_album']['hidden'])
		$amSettings['prev_next'] = -1;

	$item_data['description'] = empty($item_data['description']) ? '' : $amFunc['parse_bbc']($item_data['description']);

	// We need to get the embed object now
	$item_data['extra_info'] = array();

	if ($item_data['type'] == 'embed')
	{
		$item_data['is_resized'] = !empty($item_data['id_preview']);
		if (!$amSettings['enable_cache'] || !($item_data['embed_object'] = $amFunc['cache_get_data']('aeva-embed-link-'.$item_data['embed_url'], 1200)))
		{
			require_once($sourcedir .'/Aeva-Embed.php');

			$item_data['embed_object'] = aeva_embed_video($item_data['embed_url'], $item_data['id_media'], $item_data['id_preview']);
			$amFunc['cache_put_data']('aeva-embed-link-'.$item_data['embed_url'], $item_data['embed_object'], 1200);
		}
	}
	else
	{
		if ($amSettings['enable_cache'] && ($temp_data = $amFunc['cache_get_data']('aeva-file-info-'.$item_data['id_file'].'-'.$item_data['filename'], 1200)))
		{
			$item_data['embed_object'] = $temp_data['embed_object'];
			$item_data['extra_info'] = $temp_data['extra_info'];
			$item_data['is_resized'] = $temp_data['is_resized'];
			$skip_build = $temp_data['embed_object'] != 'no_cache';
		}

		if (empty($skip_build))
		{
			$file = new aeva_media_handler;
			$file->init($path, null, null, $amSettings['show_extra_info'] == 1);

			$item_data['embed_object'] = aeva_embedObject($file,
				$item_data['id_media'], $item_data['type'] == 'video' ? $item_data['width'] : $item_data['preview_width'],
				$item_data['type'] == 'video' ? $item_data['height'] : $item_data['preview_height'], $item_data['title']
			);

			if ($amSettings['show_extra_info'] == 1)
			{
				if (empty($item_data['exif']))
				{
					$xtra_info = $file->getInfo();

					// Attempt to update it
					if (!empty($xtra_info))
						$amFunc['db_query']('
							UPDATE {db_prefix}aeva_files
							SET exif = {string:exif}
							WHERE id_file = {int:file}',
							array(
								'exif' => serialize($xtra_info),
								'file' => $item_data['id_file'],
							),__FILE__,__LINE__
						);
				}
				else
					$xtra_info = unserialize($item_data['exif']);

				foreach ($xtra_info as $key => $value)
				{
					if (isset($amSettings['show_info_'.$key]) && $amSettings['show_info_'.$key] == 1)
						$item_data['extra_info'][$key] = $value;
				}
			}
			$item_data['is_resized'] = $item_data['type'] == 'image' && ($item_data['preview_width'] != $item_data['width'] || $item_data['preview_height'] != $item_data['height']);
			$file->close();

			// Cache it if we should
			if ($amSettings['enable_cache'])
			{
				$cache = array(
					'embed_object' => strpos($item_data['embed_object'], 'swfobject.embedSWF') === false ? $item_data['embed_object'] : 'no_cache',
					'extra_info' => $item_data['extra_info'],
					'is_resized' => $item_data['is_resized']
				);
				$amFunc['cache_put_data']('aeva-file-info-'.$item_data['id_file'].'-'.$item_data['filename'], $cache, 1200);
			}
		}
	}

	if (isset($item_data['extra_info']))
	{
		if (isset($item_data['extra_info']['datetime']) && (preg_match('/(\d{4}).(\d{2}).(\d{2}) (\d{2}).(\d{2}).(\d{2})/', $item_data['extra_info']['datetime'], $dt) > 0) && $dt[1] != 1970)
			$item_data['extra_info']['datetime'] = timeformat(mktime($dt[4], $dt[5], $dt[6], $dt[2], $dt[3], $dt[1]));
		if (isset($item_data['extra_info']['duration']))
		{
			$seconds = (int) $item_data['extra_info']['duration'];
			$item_data['extra_info']['duration'] = ($seconds > 3600 ? floor($seconds / 3600) . ':' : '') . ($seconds > 60 ? sprintf('%02d:%02d', floor(($seconds % 3600) / 60), $seconds % 60) : $seconds . 's');
		}
		if (isset($item_data['extra_info']['bit_rate']))
			$item_data['extra_info']['bit_rate'] = floor($item_data['extra_info']['bit_rate'] / 1000) . ' kbps';
	}

	// Load the member's data
	$confirmed_member = loadMemberData($item_data['id_member']);
	if ($confirmed_member)
		loadMemberContext($item_data['id_member']);
	$item_data['member'] = $confirmed_member ? $memberContext[$item_data['id_member']] : 0;

	// Linktree
	$item_data['album_parents'] = aeva_getAlbumParents($item_data['album_id'], $item_data['master']);
	if (!empty($item_data['album_parents']))
	{
		$parents = array_reverse($item_data['album_parents']);
		foreach ($parents as $p)
			if (!$p['hidden'] || $p['owner'] == $user_info['id'])
				$amFunc['add_linktree']($galurl . 'sa=album;in=' . $p['id'], $p['name']);
	}
	$amFunc['add_linktree']($galurl.'sa=item;in='.$item_data['id_media'],$item_data['title']);

	// Page headers
	$context['aeva_header']['data']['title'] = $txt['aeva_type_' . $item_data['type']];
	$context['page_title'] = $item_data['title'];

	// Filesize
	$item_data['filesize'] = floor($item_data['filesize']/1024);

	// Last edited?
	$item_data['last_edited'] = !empty($item_data['last_edited']) && $item_data['last_edited'] != '0' ? $amFunc['time_format']($item_data['last_edited']) : '';
	$item_data['last_edited_by'] = !empty($item_data['last_edited']) && $item_data['last_edited'] != '0' && $item_data['last_edited_by'] !== -2 ? aeva_profile($item_data['last_edited_by'], $item_data['last_edited_name']) : -2;

	// Edit and report?
	$item_data['can_edit'] = aeva_allowedTo('moderate') || (aeva_allowedTo('edit_own_item') && $item_data['id_member'] == $user_info['id']);
	$item_data['can_report'] = aeva_allowedTo('report_item');

	$item_data['can_approve'] = aeva_allowedTo('moderate') || (aeva_allowedTo('auto_approve_item') && $item_data['id_member'] == $user_info['id']);

	// Moveable/Commentable albums?
	if ($amSettings['use_lightbox'])
	{
		$allowed_albums = albumsAllowedTo('add_' . $item_data['type'] . 's');
		// This one only selects the user's own albums... Would this save processing time for admins with large galleries?
		//	aeva_getAlbums(aeva_allowedTo('moderate') ? 'a.album_of = ' . (int) $user_info['id'] : (empty($allowed_albums) ? '1=0' : 'a.id_album IN (' . implode(',', $allowed_albums) . ')'), 1, false, 'a.album_of, a.child_level, a.a_order');
		aeva_getAlbums(aeva_allowedTo('moderate') ? '' : (empty($allowed_albums) ? '1=0' : 'a.id_album IN (' . implode(',', array_keys($allowed_albums)) . ')'), 1, false, 'a.album_of, a.child_level, a.a_order');
		$sep = $prev_owner = -1;
		foreach ($context['aeva_album_list'] as $k => $list)
		{
			$new_owner = $context['aeva_albums'][$list]['owner']['id'];
			if ($prev_owner != $new_owner)
			{
				if ($prev_owner > -1)
					$albums['sep' . ++$sep] = array('', false, '');
				$albums['sep' . ++$sep] = array($context['aeva_albums'][$list]['owner']['name'], false, 'begin');
				$prev_owner = $new_owner;
			}
			$albums[$list] = array(str_repeat('-', $context['aeva_albums'][$list]['child_level']).' '.aeva_cutString($context['aeva_albums'][$list]['name'], 42), $list == $item_data['album_id'], null);
		}
		$albums['sep' . ++$sep] = array('', false, '');
		$context['aeva_move_albums'] = &$albums;
	}

	// Custom fields?
	$item_data['custom_fields'] = aeva_loadCustomFields($item_data['id_media']);

	// End it!
	$context['item_data'] = $item_data;
	$context['sub_template'] = 'aeva_viewItem';
}

function aeva_mgComment()
{
	global $context, $scripturl, $galurl, $amFunc, $amSettings, $txt, $db_prefix, $user_info, $sourcedir;

	// Get the item info
	$request = $amFunc['db_query']('
		SELECT m.id_media, m.title, m.album_id, a.master
		FROM {db_prefix}aeva_media AS m
		LEFT JOIN {db_prefix}aeva_albums AS a ON (m.album_id = a.id_album)
		WHERE m.id_media = {int:media}
		AND m.approved = 1',
		array('media' => (int) $_REQUEST['in']),__FILE__,__LINE__);
	if ($amFunc['db_num_rows']($request) == 0)
		fatal_lang_error('aeva_item_not_found', !empty($amSettings['log_access_errors']));
	$item_data = $amFunc['db_fetch_assoc']($request);
	$amFunc['db_free_result']($request);
	$context['aeva_show_approval'] = false;

	// The form!
	$context['aeva_form'] = array(
		'msg' => array(
			'label' => $txt['aeva_message'],
			'fieldname' => 'comment',
			'type' => 'textbox',
			'custom' => 'rows="8" style="width: 98%"',
		),
	);
	$context['aeva_form_headers'] = array(
		array($txt['aeva_commenting'].' : <a href="'.$galurl.'sa=item;in='.$item_data['id_media'].'">'.$item_data['title'].'</a>'),
		array($txt['aeva_com_will_be_approved'], !aeva_allowedTo('auto_approve_com') && !aeva_allowedTo('moderate')),
	);
	$context['aeva_form_url'] = $galurl.'sa=comment;in='.$item_data['id_media'];

	// Editor
	aeva_createTextEditor('comment', 'aeva_form');

	// Commenting?
	if (isset($_POST['submit_aeva']))
	{
		// WYSIWYG?
		if (!empty($_REQUEST['comment_mode']) && isset($_POST['comment']))
		{
			require_once($sourcedir . '/Subs-Editor.php');
			$_POST['comment'] = un_htmlspecialchars(html_to_bbc($_POST['comment']));
		}

		require_once($sourcedir . '/Subs-Post.php');
		$comment = $amFunc['htmlspecialchars'](aeva_utf2entities($_POST['comment'], false, 0));
		preparsecode($comment);
		if (empty($comment))
			fatal_lang_error('aeva_comment_left_empty');
		// Approval stuff
		$approved = aeva_allowedTo('auto_approve_com') || aeva_allowedTo('moderate') ? 1 : 0;

		// Everything fine we guess, let's insert it!
		$amFunc['db_insert'](
			$db_prefix . 'aeva_comments',
			array('id_member', 'id_media', 'id_album', 'message', 'posted_on', 'approved'),
			array($user_info['id'], $item_data['id_media'], $item_data['album_id'], $comment, time(), $approved),
			__FILE__,__LINE__);
		$id_comment = $amFunc['db_insert_id']('{db_prefix}aeva_comments', 'id_comment');

		if ($approved == 1)
		{
			$amFunc['db_query']('
				UPDATE {db_prefix}members
				SET aeva_comments = aeva_comments + 1
				WHERE ID_MEMBER = {int:mem}',array('mem' => $user_info['id']),__FILE__,__LINE__);

			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_media
				SET num_comments = num_comments + 1, log_last_access_time = {int:time}, id_last_comment = {int:comment}
				WHERE id_media = {int:id}',array('id' => $item_data['id_media'], 'time' => time(), 'comment' => $id_comment),__FILE__,__LINE__);
		}

		aeva_resetUnseen();
		aeva_increaseSettings($approved == 1 ? 'total_comments' : 'num_unapproved_comments');
		redirectexit($galurl.'sa=item;in='.$item_data['id_media'].'#com'.$id_comment);
	}
	else
		$context['sub_template'] = 'aeva_form';

	// Linktree
	$parents = aeva_getAlbumParents($item_data['album_id'], $item_data['master']);
	if (!empty($parents))
	{
		$parents = array_reverse($parents);
		foreach ($parents as $p)
			$amFunc['add_linktree']($galurl . 'sa=album;in=' . $p['id'], $p['name']);
	}
	$amFunc['add_linktree']($galurl.'sa=item;in='.$item_data['id_media'],$item_data['title']);
	$amFunc['add_linktree']($galurl.'sa=comment;in='.$item_data['id_media'],$txt['aeva_commenting']);

	// End it up!
	$context['item_data'] = $item_data;
	$context['page_title'] = $txt['aeva_commenting'];
	$context['aeva_header']['data']['title'] = $txt['aeva_commenting'];
}

function aeva_mgReport()
{
	// Handles reporting of comments/items
	global $amFunc, $txt, $galurl, $scripturl, $db_prefix, $user_info, $context, $sourcedir;

	$type = $_GET['type'] == 'comment' ? 'com' : 'item';

	if (!aeva_allowedTo('report_'.$type))
		fatal_lang_error('aeva_'.$type.'_report_denied');

	// Get its data
	if ($type == 'com')
		$query = '
		SELECT com.id_comment, mem.realName AS member_name, m.title, m.id_media, com.id_member, com.message, com.id_album, a.master
		FROM {db_prefix}aeva_comments AS com
		INNER JOIN {db_prefix}aeva_media AS m ON (m.id_media = com.id_media)
		LEFT JOIN {db_prefix}members AS mem ON (mem.ID_MEMBER = com.id_member)
		LEFT JOIN {db_prefix}aeva_albums AS a ON (com.id_album = a.id_album)
		WHERE com.id_comment = {int:id}';
	else
		$query = '
		SELECT m.id_media, m.title, m.album_id AS id_album, a.master
		FROM {db_prefix}aeva_media AS m
		LEFT JOIN {db_prefix}aeva_albums AS a ON (m.album_id = a.id_album)
		WHERE id_media = {int:id}';

	$request = $amFunc['db_query']($query, array('id' => (int) $_GET['in']),__FILE__,__LINE__);

	if ($amFunc['db_num_rows']($request) == 0)
		fatal_lang_error('aeva_'.$type.'_not_found');
	$dat = $amFunc['db_fetch_assoc']($request);
	$amFunc['db_free_result']($request);

	$context['aeva_reported'] = false;

	$reporting_title = $type == 'com' ? $txt['aeva_comment'].': <a href="'.$galurl.'sa=item;in='.$dat['id_media'].'#com'.$dat['id_comment'].'">'.$dat['title'].'</a> '.$txt['aeva_by'].' <a href="'.$scripturl.'?action=profile;u='.$dat['id_member'].'">'.$dat['member_name'].'</a>'
		: '<a href="'.$galurl.'sa=item;in='.$dat['id_media'].'">'.$dat['title'].'</a>';

	$context['sub_template'] = 'aeva_form';

	// load up the form!
	$context['aeva_form'] = array(
		'whitespace' => array(
			'perm' => false,
		),
		'title' => array(
			'label' => $reporting_title,
			'type' => 'title',
		),
		'reason' => array(
			'label' => $txt['aeva_reason'],
			'type' => 'textbox',
			'fieldname' => 'reason',
			'custom' => 'rows="8" style="width: 98%"',
		),
	);
	$context['aeva_form_url'] = $galurl.'sa=report;type='.($type == 'com' ? 'comment;in='.$dat['id_comment'] : 'item;in='.$dat['id_media']);

	// Reporting?
	if (isset($_POST['submit_aeva']))
	{
		require_once($sourcedir . '/Subs-Post.php');
		$reason = $amFunc['htmlspecialchars']($_POST['reason']);
		preparsecode($reason);
		if (empty($reason))
			fatal_lang_error('aeva_report_left_empty');

		$amFunc['db_insert'](
			$db_prefix . 'aeva_variables',
			$type == 'com' ? array('type','val1','val2','val3', 'val4') : array('type','val1','val2','val3', 'val4', 'val5'),
			$type == 'com' ? array('comment_report', $user_info['id'], time(), $reason, $dat['id_comment']) :
				array('item_report', $user_info['id'], time(), $reason, $dat['id_media'], $dat['title']),
			__FILE__,__LINE__);
		aeva_increaseSettings($type == 'com' ? 'num_reported_comments' : 'num_reported_items');
		$context['sub_template'] = 'aeva_done';
		$return = $scripturl . '?action=media;' . ($type == 'com' ? 'sa=item;in=' . $dat['id_media'] : 'sa=album;in=' . $dat['id_album']);
		$context['aeva_done_txt'] = sprintf($txt['aeva_reported'], $return);
	}

	// Linktree
	$parents = array_reverse(aeva_getAlbumParents($dat['id_album'], $dat['master']));
	foreach ($parents as $p)
		$amFunc['add_linktree']($galurl.'sa=album;in='.$p['id'],$p['name']);
	$amFunc['add_linktree']($galurl.'sa=item;in='.$dat['id_media'],$dat['title']);

	$context['page_title'] = $txt['aeva_reporting'];
	$context['aeva_header']['data']['title'] = $txt['aeva_reporting'];
}

// Handles adding/editing of items
function aeva_mgPost()
{
	global $amFunc, $amSettings, $txt, $galurl, $context, $user_info, $options, $modSettings, $sourcedir;

	$editing = false;
	$context['page_title'] = $txt['aeva_add_item'];

	// Are we editing or adding?
	if (isset($_REQUEST['album']))
		$id = (int) $_REQUEST['album'];
	elseif (!empty($_REQUEST['in']))
	{
		$id = (int) $_REQUEST['in'];
		$editing = true;
	}
	else
	{
		$request = $amFunc['db_query']('
			SELECT m.album_id
			FROM {db_prefix}aeva_media AS m
			INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
			WHERE {query_see_album} AND m.id_member = {int:me}
			ORDER BY m.id_media DESC
			LIMIT 1', array('me' => $user_info['id']),__FILE__,__LINE__);

		if ($amFunc['db_num_rows']($request) == 0)
			$latest_album = 0;
		else
			list ($latest_album) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);

		$id = 0;
		$allowed_albums = albumsAllowedTo(array('add_images', 'add_videos', 'add_audios', 'add_docs', 'add_embeds'), true);
		aeva_getAlbums(aeva_allowedTo('moderate') ? '' : (empty($allowed_albums) ? '1=0' : 'a.id_album IN (' . implode(',', array_keys($allowed_albums)) . ')'), 1);
		$q = @$allowed_albums[$latest_album]['quota'];
		$albums = array();
		$context['html_headers'] .= '
	<script type="text/javascript"><!-- // --><![CDATA[
		function updateQuota(i, v, a, d)
		{
			document.getElementById("aeva_i_quota").innerHTML = i;
			document.getElementById("aeva_v_quota").innerHTML = v;
			document.getElementById("aeva_a_quota").innerHTML = a;
			document.getElementById("aeva_d_quota").innerHTML = d;
		}
	// ]]></script>';

		foreach ($context['aeva_album_list'] as $list)
		{
			$albums[$list] = array(
				str_repeat('&nbsp;&nbsp;&nbsp;', $context['aeva_albums'][$list]['child_level']) . $context['aeva_albums'][$list]['name'],
				$list == $latest_album,
				' onclick="updateQuota(' . $q['image'] . ', ' . $q['video'] . ', ' . $q['audio'] . ', ' . $q['doc'] . ');"');
		}
	}

	$max_php_size = (int) min(aeva_getPHPSize('upload_max_filesize'), aeva_getPHPSize('post_max_size'));

	$context['html_headers'] .= '
	<script type="text/javascript"><!-- // --><![CDATA[
		function aeva_testImage()
		{
			if (document.aeva_form.file.files) // Firefox 3 or Webkit?
				document.getElementById("file_warning").innerHTML = document.aeva_form.file.files.item(0).fileSize > ' . $max_php_size . ' ?
					"' . sprintf($txt['aeva_file_too_large_php'], round($max_php_size/1048576, 1)) . '" : "";
		}
	// ]]></script>';

	// Load the data
	$data = array();

	// If we're uploading a new item, load the album's data
	if (!$editing)
	{
		$still_unapproved = !aeva_allowedTo('auto_approve_item');
		$has_a = isset($context['aeva_album']);

		// Some side data to prevent errors
		$data = array(
			'id_album' => $has_a ? $context['aeva_album']['id'] : 0,
			'master' => $has_a ? $context['aeva_album']['master'] : 0,
			'featured' => $has_a ? $context['aeva_album']['featured'] : 0,
			'album_owner' => $has_a ? $context['aeva_album']['owner']['id'] : 0,
			'album_name' => $has_a ? $context['aeva_album']['name'] : '',
			'id_media' => 0,
			'title' => '',
			'description' => '',
			'keywords' => '',
			'id_file' => 0,
			'id_thumb' => 0,
			'id_preview' => 0,
			'item_member' => 0,
			'media_type' => 'image',
			'folder' => '',
			'embed_url' => '',
		);

		// Do some checking. If upload is disallowed, or album id isn't specified and no albums can be uploaded to, send an error.
		if ($has_a ? !$context['aeva_album']['can_upload'] : count($albums) == 0)
			fatal_lang_error('aeva_add_not_allowed');
	}
	else
	{
		// Load this item's data
		$request = $amFunc['db_query']('
			SELECT
				m.id_media, m.id_file, m.id_thumb, m.id_preview, m.description, m.keywords, m.title, m.time_added, m.type,
				m.id_member, m.album_id, a.featured, a.album_of, m.embed_url, m.approved, f.directory, a.master
			FROM {db_prefix}aeva_media AS m
				INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
				LEFT JOIN {db_prefix}aeva_files AS f ON (IF(m.id_file = 0, m.id_thumb = f.id_file, m.id_file = f.id_file))
			WHERE m.id_media = {int:id}',
			array('id' => $id),__FILE__,__LINE__);
		if ($amFunc['db_num_rows']($request) == 0)
			fatal_lang_error('aeva_item_not_found', !empty($amSettings['log_access_errors']));

		// Arrange it
		$row = $amFunc['db_fetch_assoc']($request);
		$amFunc['db_free_result']($request);
		$still_unapproved = !$row['approved'];

		$data = array(
			'album_name' => '',
			'id_album' => $row['album_id'],
			'master' => $row['master'],
			'album_owner' => $row['album_of'],
			'featured' => $row['featured'],
			'id_media' => $row['id_media'],
			'id_file' => $row['id_file'],
			'id_thumb' => $row['id_thumb'],
			'id_preview' => $row['id_preview'],
			'title' => $row['title'],
			'description' => $row['description'],
			'item_member' => $row['id_member'],
			'media_type' => $row['type'],
			'folder' => $row['directory'],
			'embed_url' => $row['embed_url'],
			'keywords' => $row['keywords'],
			'time_added' => $row['time_added'],
		);

		// Can you edit it?
		if (!aeva_allowedTo('moderate') && (!aeva_allowedTo('edit_own_item') || $data['item_member'] != $context['user']['id']))
			fatal_lang_error('aeva_edit_denied');
	}

	// Create the text editor
	aeva_createTextEditor('desc', 'aeva_form', false, empty($data['description']) ? '' : $data['description']);

	$can_auto_approve = aeva_allowedTo(array('auto_approve_item', 'moderate'), true);
	$will_be_unapproved = $editing ? (!empty($amSettings['item_edit_unapprove']) || $still_unapproved) && !$can_auto_approve : !$can_auto_approve;

	// Load the limits
	aeva_loadQuotas(empty($albums) ? array() : array('image' => $q['image'], 'audio' => $q['audio'], 'video' => $q['video'], 'doc' => $q['doc']));

	require_once($sourcedir . '/Subs-Post.php');
	$data['title'] = un_preparsecode($data['title']);
	$data['description'] = un_preparsecode($data['description']);

	// Construct the form
	$context['aeva_form'] = array(
		'note' => array(
			'label' => $txt['aeva_will_be_approved'],
			'class' => 'windowbg',
			'perm' => $will_be_unapproved,
			'type' => 'title',
		),
		'item' => array(
			'label' => sprintf($txt['aeva_editing_item'], $galurl.'sa=item;in='.$data['id_media'], $data['title']),
			'class' => 'windowbg',
			'perm' => $editing,
			'type' => 'title',
		),
		'max_file_size' => array(
			'label' => $txt['aeva_max_file_size'] . ': ' . $txt['aeva_image'] . ' - <span id="aeva_i_quota">' . $context['aeva_max_file_size']['image'] . '</span> ' . $txt['aeva_kb'] . ', ' . $txt['aeva_video'] . ' - <span id="aeva_v_quota">' . $context['aeva_max_file_size']['video'] . '</span> ' . $txt['aeva_kb'] . ', ' . $txt['aeva_audio'] . ' - <span id="aeva_a_quota">' . $context['aeva_max_file_size']['audio'] . '</span> ' . $txt['aeva_kb'] . ', ' . $txt['aeva_doc'] . ' - <span id="aeva_d_quota">' . $context['aeva_max_file_size']['doc'] . '</span> ' . $txt['aeva_kb'],
			'class' => 'windowbg',
			'type' => 'title',
		),
		'album' => array(
			'label' => sprintf($txt['aeva_what_album'], $galurl.'sa=album;in='.$data['id_album'], $data['album_name']),
			'class' => 'windowbg',
			'perm' => !$editing,
			'type' => 'title',
		),
		'title' => array(
			'label' => $txt['aeva_add_title'],
			'fieldname' => 'title',
			'type' => 'text',
			'value' => $data['title'],
			'custom' => 'maxlength="255"',
		),
		'desc' => array(
			'label' => $txt['aeva_add_desc'],
			'subtext' => $txt['aeva_add_desc_subtxt'],
			'fieldname' => 'desc',
			'type' => 'textbox',
			'value' => $data['description'],
		),
		'file' => array(
			'label' => $txt['aeva_add_file'],
			'fieldname' => 'file',
			'type' => 'file',
			'subtext' => $editing ? $txt['aeva_edit_file_subtext'] : '',
			// Note for later: Opera accepts multiple uploads with <name="file" min="1" max="99"> and Webkit does too, with <name="file[]" multiple>
			'custom' => 'onchange="aeva_testImage();"',
			'add_text' => '<div id="file_warning"></div>',
			'perm' => !empty($allowed_albums) || aeva_allowedTo(array('moderate', 'add_audios', 'add_videos', 'add_images', 'add_docs'), true),
		),
		'embed' => array(
			'label' => $txt['aeva_add_embed'],
			'fieldname' => 'embed_url',
			'type' => 'text',
			'subtext' => $editing ? $txt['aeva_embed_sub_edit'] : $txt['aeva_add_embed_sub'],
			'perm' => !empty($allowed_albums) || aeva_allowedTo(array('moderate', 'add_embeds'), true),
			'value' => $data['embed_url'],
		),
		'keywords' => array(
			'label' => $txt['aeva_add_keywords'],
			'fieldname' => 'keywords',
			'type' => 'text',
			'value' => $data['keywords'],
		),
		'thumbnail' => array(
			'label' => $txt['aeva_force_thumbnail'],
			'fieldname' => 'thumbnail',
			'type' => 'file',
			'subtext' => $txt['aeva_force_thumbnail_subtxt'] . ($editing ? $txt['aeva_force_thumbnail_edit'] : ''),
			'add_text' => $editing ? '<p><img alt="" src="'.$galurl.'sa=media;in='.$data['id_media'].';thumb" style="padding-left: 4px" /></p>' : '',
			'colspan' => aeva_allowedTo('moderate') || $data['album_owner'] == $context['user']['id'] ? 2 : 0,
		),
		'as_icon' => array(
			'label' => '',
			'type' => 'checkbox',
			'options' => array(array($txt['aeva_use_as_album_icon'], 'force_name' => 'as_icon')),
			'perm' => aeva_allowedTo('moderate') || $data['album_owner'] == $context['user']['id'],
		),
		'session' => array(
			'fieldname' => $context['session_var'] == 'sesc' ? 'sc' : $context['session_var'],
			'type' => 'hidden',
			'value' => $context['session_id'],
			'skip' => true
		),
	);
	$context['aeva_form_url'] = $galurl . 'sa=post;' . ($editing ? 'in' : 'album') . '=' . $id;

	if (isset($_REQUEST['noh']) && $context['aeva_foxy'])
	{
		$context['aeva_form_url'] = 'http' . (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off' ? '' : 's') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$context['aeva_form'][] = array('fieldname' => 'noh', 'type' => 'hidden', 'value' => $_REQUEST['noh'], 'skip' => true);
	}

	if ($id == 0)
	{
		unset($context['aeva_form']['album']['class']);
		$context['aeva_form']['album']['label'] = $txt['aeva_what_album_select'];
		$context['aeva_form']['album']['type'] = 'select';
		$context['aeva_form']['album']['fieldname'] = 'album';
		$context['aeva_form']['album']['options'] = $albums;
	}
	if ($editing && aeva_allowedTo('moderate'))
		$context['aeva_form']['silent'] = array('perm' => false);

	$context['sub_template'] = 'aeva_form';

	// Custom field stuff...
	// Load the fields....
	$parents = aeva_getAlbumParents($data['id_album'], $data['master'], true);
	$fields = aeva_loadCustomFields(empty($data['id_media']) ? null : $data['id_media'], array_merge((array) $data['id_album'], $parents));

	// Add them to the form
	foreach ($fields as $field)
	{
		if ($field['type'] == 'checkbox')
			$field['value'] = explode(', ', $field['value']);

		// Options...
		$options = array(
			'' => array('', false),
		);
		if (in_array($field['type'], array('checkbox', 'radio', 'select')))
			foreach ($field['options'] as $option)
				$options[$option] = array($option, $field['type'] == 'checkbox' ? in_array($option, $field['value']) : $option == $field['raw_value']);

		if ($field['type'] == 'checkbox' || $field['type'] == 'radio')
			unset($options['']);

		$subtexts = array($field['desc']);
		if ($field['required'])
			$subtexts[] = $txt['aeva_cf_required'];
		if ($field['bbc'])
			$subtexts[] = $txt['aeva_cf_bbc'];
		if (empty($field['desc']))
			unset($subtexts[0]);

		$context['aeva_form'][$field['id']] = array(
			'fieldname' => 'custom_field[' . $field['id'] . ']',
			'label' => $field['name'],
			'multi' => $field['type'] == 'checkbox',
			'type' => $field['type'],
			'options' => $options,
			'subtext' => implode('<br />', $subtexts),
			'value' => $field['raw_value'],
		);
	}

	// Submitting?
	if (isset($_POST['submit_aeva']) || isset($_POST['silent_update']))
	{
		$silent = isset($_POST['silent_update']) && aeva_allowedTo('moderate');

		// Check the session
		checkSession();

		// WYSIWYG?
		if (!empty($_REQUEST['desc_mode']) && isset($_REQUEST['desc']))
		{
			require_once($sourcedir . '/Subs-Editor.php');

			$_REQUEST['desc'] = html_to_bbc($_REQUEST['desc']);

			// We need to unhtml it now as it gets done shortly.
			$_REQUEST['desc'] = un_htmlspecialchars($_REQUEST['desc']);

			// We need this for everything else.
			$_POST['desc'] = $_REQUEST['desc'];
		}

		// Get the data
		$name = $amFunc['htmlspecialchars']($_POST['title']);
		$name = aeva_utf2entities($name, false, 255 + strlen($name) - strlen($_POST['title']), false, false, true, true, 255);
		$desc = aeva_utf2entities($amFunc['htmlspecialchars']($_POST['desc']), false, 0, false, false);
		preparsecode($name);
		preparsecode($desc);

		$embed_url = !empty($_POST['embed_url']) ? $amFunc['htmlspecialchars']($_POST['embed_url']) : '';
		$kw = $amFunc['htmlspecialchars']($_POST['keywords']);

		// Are we embedding or adding a file?
		// Remove the $embed_url != $data['embed_url'] branch to re-create remote thumbnails from scratch when editing item.
		if (!empty($_POST['embed_url']) && $embed_url != $data['embed_url'] && aeva_allowedTo('add_embeds'))
			$embedding = true;
		elseif (!empty($_FILES['file']['name']) && aeva_allowedTo(array('moderate', 'add_audios', 'add_videos', 'add_images', 'add_docs'), true))
			$embedding = false;
		elseif (!$editing)
			fatal_lang_error(empty($_FILES['file']['name']) ? 'aeva_file_not_specified' : 'aeva_add_not_allowed');

		$force_thumbnail = !empty($_FILES['thumbnail']['name']);

		// Custom fields...
		$field_inserts = array();
		foreach ($fields as $field)
		{
			$value = isset($_POST['custom_field'][$field['id']]) && (is_array($_POST['custom_field'][$field['id']]) || trim($_POST['custom_field'][$field['id']]) != '') ? $_POST['custom_field'][$field['id']] : '';
			preparsecode($value);

			// Do the value checks
			if ($field['type'] == 'checkbox')
			{
				foreach ($value as $val)
					if (!in_array($val, $field['options']))
						fatal_error(sprintf($txt['aeva_cf_invalid'], $field['name']));

				// Nothing set?
				if (empty($value) && $field['required'])
					fatal_error(sprintf($txt['aeva_cf_empty'], $field['name']));
				elseif (empty($value))
					continue;

				// Set the proper value
				$value = implode(', ', $value);
			}
			elseif (in_array($field['type'], array('radio', 'select')))
			{
				if (empty($value) && $field['required'])
					fatal_error(sprintf($txt['aeva_cf_empty'], $field['name']));
				elseif (empty($value))
					continue;
				elseif (!in_array($value, $field['options']))
					fatal_error(sprintf($txt['aeva_cf_invalid'], $field['name']));
			}
			elseif (empty($value) && $field['required'])
				fatal_error(sprintf($txt['aeva_cf_empty'], $field['name']));
			else
				$value = $amFunc['htmlspecialchars']($value);

			// Add it to the array...
			$field_inserts[$field['id']] = $value;
		}

		// If we're not embedding, create the file
		if (isset($embedding) && !$embedding)
		{
			$fame = $_FILES['file']['name'];
			$fame_ext = aeva_getExt($fame);
			$mimelist = aeva_extList();
			foreach ($mimelist as $mim1 => $mim2)
				if (isset($mim2[$fame_ext]))
					$data['media_type'] = $mim1;

			if (empty($name))
				$name = preg_replace('/[;|\s\._-]+/', ' ', substr($fame, 0, strlen($fame) - strlen($fame_ext) - 1));

			$fame = aeva_utf2entities($fame);
			$name = aeva_utf2entities($name);

			// Delete any old file if editing
			if ($editing)
				aeva_deleteFiles(array($data['id_file'], $data['id_thumb'], $data['id_preview']), true);

			$fileOpts = array(
				'filepath' => $_FILES['file']['tmp_name'],
				'filename' => $fame,
				'album' => $data['id_album'],
				'skip_thumb' => $force_thumbnail,
				'skip_preview' => $force_thumbnail && ($data['id_preview'] == 0),
				'destination' => empty($data['folder']) || substr($data['folder'], 0, 7) != 'albums/' ? aeva_getSuitableDir($data['id_album']) : $amSettings['data_dir_path'] . '/' . $data['folder'],
				'is_uploading' => true,
				'force_id_file' => $data['id_file'],
				'force_id_thumb' => $data['id_thumb'] > 4 ? $data['id_thumb'] : 0,
				'force_id_preview' => $data['id_preview'],
			);

			// Create it
			$ret = aeva_createFile($fileOpts);
			if (isset($ret['error']))
			{
				$errors = array(
					'file_not_found' => 'upload_failed',
					'dest_not_found' => 'upload_failed',
					'size_too_big' => 'upload_file_too_big',
					'width_bigger' => 'error_width',
					'height_bigger' => 'error_height',
					'invalid_extension' => 'invalid_extension',
					'dest_empty' => 'dest_failed',
				);
				$error = isset($errors[$ret['error']]) ? $errors[$ret['error']] : 'upload_failed';
				fatal_lang_error('aeva_' . $error, true, $ret['error_context']);
			}
			else
			{
				$id_file = $ret['file'];
				$id_thumb = empty($ret['thumb']) ? 0 : $ret['thumb'];
				$id_preview = empty($ret['preview']) ? 0 : $ret['preview'];
				$time = empty($ret['time']) ? 0 : $ret['time'];
			}

			$embed_url = '';
		}
		elseif (!empty($embedding))
		{
			require_once($sourcedir . '/Aeva-Embed.php');

			if ($editing)
				aeva_deleteFiles($data['id_thumb'], true);

			$link = aeva_check_embed_link($embed_url);
			if ($link === false)
				fatal_lang_error('aeva_invalid_embed_link');
			// Did auto-embed send us back an embeddable link? C'mon, use it!
			if (!is_array($link) && $link !== true)
				$embed_url = $link;

			if (empty($name))
				$name = $link === true || is_array($link) ?
					urldecode(preg_replace('/[;|\s\._-]+/', ' ', substr(strrchr($embed_url, '/'), 1))) :
					urldecode(preg_replace(array('~\[url[^]]*]~', '~\[/url]~', '~[;|\s\._]+~'), array('', '', ' '), $link));
			if (empty($name))
				$name = basename(urldecode(rtrim($embed_url, '/')));

			$id_file = 0;
			$id_thumb = 0;
			$id_preview = 0;
			if (is_array($link))
			{
				$id_thumb = $link[1];
				$id_preview = $link[2];
			}
			elseif (!$force_thumbnail)
				$id_thumb = aeva_generate_embed_thumb($embed_url, $data['id_album'], $data['id_thumb'], !$data['id_thumb'] ? '' : $amSettings['data_dir_path'] . '/' . $data['folder']);
			$time = 0;
		}
		elseif ($editing)
		{
			$id_file = $data['id_file'];
			$id_thumb = $data['id_thumb'];
			$id_preview = $data['id_preview'];
			$embed_url = $data['embed_url'];
			$time = 0;
		}

		// Force a "manual" thumbnail?
		if ($force_thumbnail)
		{
			$file = new aeva_media_handler;
			$file->init($_FILES['thumbnail']['tmp_name']);
			$file->force_mime = $file->getMimeFromExt($_FILES['thumbnail']['name']);
			$sizes = $file->getSize();

			// Force creating a preview for non-image files because we won't have the "main" file available when regenerating
			$preview_needed = $data['media_type'] != 'image' || ($sizes[0] > $amSettings['max_thumb_width']) || ($sizes[1] > $amSettings['max_thumb_height']);
			aeva_deleteFiles($preview_needed ? array($data['id_thumb'], $data['id_preview']) : array($data['id_thumb']), true);

			$opts = array(
				'destination' => empty($data['folder']) ? aeva_getSuitableDir($data['id_album']) : $amSettings['data_dir_path'] . '/' . $data['folder'],
				'filename' => mt_rand() . '_' . $_FILES['thumbnail']['name'],
				'album' => $data['id_album'],
				'force_id_thumb' => $data['id_thumb'],
				'force_id_preview' => $data['id_preview'],
			);
			$tmpfn = substr($opts['filename'], 0, -strlen(aeva_getExt($opts['filename']))-1);
			$id_thumb = aeva_createThumbFile($tmpfn, $file, $opts);

			if ($preview_needed)
				$id_preview = aeva_createPreviewFile($tmpfn, $file, $opts, 99999, 99999);
			$file->close();
		}

		// Get the array ready for creating/modifying
		$options = array(
			'id' => $id,
			'title' => empty($name) ? date('d m Y, G:i') : $name,
			'description' => $desc,
			'album' => $data['id_album'],
			'keywords' => $kw,
			'id_file' => $id_file,
			'id_thumb' => $id_thumb,
			'id_preview' => $id_preview,
			'time' => $time,
			'embed_url' => $embed_url,
			'id_member' => $user_info['id'],
			'mem_name' => $user_info['name'],
			'approved' => $will_be_unapproved ? 0 : ($still_unapproved ? 0 : 1),
		);

		if (isset($_POST['as_icon']) && $id_thumb > 0 && $context['aeva_form']['as_icon']['perm'])
		{
			// Retrieve the current icon for this item's album
			$request = $amFunc['db_query']('
				SELECT a.icon, a.bigicon
				FROM {db_prefix}aeva_files AS f
				INNER JOIN {db_prefix}aeva_media AS m ON (f.id_file = m.id_thumb)
				INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = f.id_album)
				WHERE m.id_media = {int:id}
				LIMIT 1',
				array('id' => $id),__FILE__,__LINE__);
			list ($album_icon, $big_icon) = $amFunc['db_fetch_row']($request);
			$amFunc['db_free_result']($request);

			if ($album_icon > 4)
			{
				// Is this icon associated to an existing item thumbnail?
				$request = $amFunc['db_query']('
					SELECT f.filename, f.directory, m.id_media
					FROM {db_prefix}aeva_files AS f
					LEFT JOIN {db_prefix}aeva_media AS m ON (m.id_thumb = f.id_file)
					WHERE f.id_file = {int:album_icon}
					LIMIT 1',
					array('album_icon' => $album_icon),__FILE__,__LINE__);
				list ($icon_filename, $icon_dir, $media_file) = $amFunc['db_fetch_row']($request);
				$amFunc['db_free_result']($request);

				// If the current album icon is not associated to an item's thumbnail, delete it.
				if (empty($media_file) && !empty($icon_filename))
				{
					@unlink($amSettings['data_dir_path'] . '/' . $icon_dir . '/' . aeva_getEncryptedFilename($icon_filename, $album_icon, true));
					$request = $amFunc['db_query']('
						DELETE FROM {db_prefix}aeva_files
						WHERE id_file = {int:file}',
						array('file' => $album_icon),__FILE__,__LINE__);
				}
			}

			if ($big_icon > 0)
			{
				// Same with the preview-size icon...
				$request = $amFunc['db_query']('
					SELECT f.filename, f.directory, m.id_media
					FROM {db_prefix}aeva_files AS f
					LEFT JOIN {db_prefix}aeva_media AS m ON (m.id_preview = f.id_file)
					WHERE f.id_file = {int:bigicon}
					LIMIT 1',
					array('bigicon' => $big_icon),__FILE__,__LINE__);
				list ($icon_filename, $icon_dir, $media_file) = $amFunc['db_fetch_row']($request);
				$amFunc['db_free_result']($request);

				// If the current album icon is not associated to an item's thumbnail, delete it.
				if (empty($media_file) && !empty($icon_filename))
				{
					@unlink($amSettings['data_dir_path'] . '/' . $icon_dir . '/' . aeva_getEncryptedFilename($icon_filename, $big_icon));
					$request = $amFunc['db_query']('
						DELETE FROM {db_prefix}aeva_files
						WHERE id_file = {int:file}',
						array('file' => $big_icon),__FILE__,__LINE__);
				}
			}

			$request = $amFunc['db_query']('
				UPDATE {db_prefix}aeva_albums
				SET icon = {int:icon}, bigicon = {int:bigicon}
				WHERE id_album = {int:id_album}',
				array('icon' => $id_thumb, 'bigicon' => empty($id_preview) && !empty($id_file) ? (int) $id_file : (int) $id_preview, 'id_album' => $data['id_album']),__FILE__,__LINE__);

			$options['skip_log'] = true;
		}

		if ($editing)
		{
			if ($silent || (isset($modSettings['edit_wait_time']) && (time() - $data['time_added'] <= $modSettings['edit_wait_time'])))
				$options['skip_log'] = true;

			aeva_modifyItem($options);
		}
		else
		{
			$id = aeva_createItem($options);

			if ($context['aeva_foxy'])
				aeva_foxy_notify_items($data['id_album'], array($id));
		}

		if (!$silent)
		{
			aeva_markSeen($id, $editing ? '' : 'force_insert');
			aeva_resetUnseen();
		}

		// Add the custom fields data
		foreach ($field_inserts as $id_field => $value)
		{
			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_field_data
				SET value = {string:value}
				WHERE id_field = {int:id_field}
					AND id_media = {int:id_media}',
				array(
					'id_field' => $id_field,
					'value' => $value,
					'id_media' => $id,
				),__FILE__,__LINE__
			);
			if ($amFunc['db_affected_rows']() == 0)
				$amFunc['db_insert'](
					'{db_prefix}aeva_field_data',
					array('id_field', 'id_media', 'value'),
					array($id_field, $id, $value),
					__FILE__,__LINE__, true
				);
		}

		redirectexit($galurl . 'sa=item;in=' . $id . (isset($_POST['noh']) && $context['aeva_foxy'] ? ';noh=' . $_POST['noh'] : ''));
	}
}

function aeva_mgEdit()
{
	global $galurl2;

	if (!empty($_GET['type']) && $_GET['type'] == 'comment')
		aeva_mgEditCom();
	else
		redirectexit($galurl2);
}

function aeva_mgEditCom()
{
	global $scripturl, $txt, $context, $galurl, $amFunc, $user_info, $modSettings, $sourcedir;

	// Load comment data
	$request = $amFunc['db_query']('
		SELECT com.id_comment, com.id_member, mem.realName AS member_name, m.id_media, m.title, com.message, m.album_id, com.posted_on, a.master
		FROM {db_prefix}aeva_comments AS com
		INNER JOIN {db_prefix}aeva_media AS m ON (com.id_media = m.id_media)
		LEFT JOIN {db_prefix}members AS mem ON (mem.ID_MEMBER = com.id_member)
		LEFT JOIN {db_prefix}aeva_albums AS a ON (m.album_id = a.id_album)
		WHERE com.id_comment = {int:comment}',
		array('comment' => (int) $_GET['in']),__FILE__,__LINE__);

	if ($amFunc['db_num_rows']($request) == 0)
		fatal_lang_error('aeva_com_not_found');
	$com_data = $amFunc['db_fetch_assoc']($request);
	$amFunc['db_free_result']($request);

	// Are you allowed to access?
	if (!aeva_allowedTo('moderate') && (!aeva_allowedTo('edit_own_com') || $com_data['id_member'] != $user_info['id']))
		fatal_lang_error('aeva_com_edit_denied');

	// The form!
	$context['aeva_form'] = array(
		'msg' => array(
			'label' => $txt['aeva_message'],
			'type' => 'textbox',
			'fieldname' => 'comment',
			'value' => $com_data['message'],
		),
	);
	$context['aeva_form_headers'] = array(
		array($txt['aeva_editing_com'].' : <a href="'.$galurl.'sa=item;in='.$com_data['id_media'].'#com'.$com_data['id_comment'].'">'.$com_data['title'].'</a> '.$txt['aeva_by'].' <a href="'.$scripturl.'?action=profile;u='.$com_data['id_member'].'">'.$com_data['member_name'].'</a>'),
	);
	$context['aeva_form_url'] = $galurl.'sa=edit;type=comment;in='.$com_data['id_comment'];

	// Editor
	aeva_createTextEditor('comment', 'aeva_form', false, $com_data['message']);

	// Submitting the edits?
	if (isset($_POST['submit_aeva']))
	{
		// WYSIWYG?
		if (!empty($_REQUEST['comment_mode']) && isset($_REQUEST['comment']))
		{
			require_once($sourcedir . '/Subs-Editor.php');

			$_REQUEST['comment'] = html_to_bbc($_REQUEST['comment']);

			// We need to unhtml it now as it gets done shortly.
			$_REQUEST['comment'] = un_htmlspecialchars($_REQUEST['comment']);

			// We need this for everything else.
			$_POST['comment'] = $_REQUEST['comment'];
		}
		$new_message = $amFunc['htmlspecialchars'](aeva_utf2entities($_POST['comment'], false, 0));
		if (empty($new_message))
			fatal_lang_error('aeva_comment_left_empty');

		$skip_log = isset($modSettings['edit_wait_time']) && (time() - $com_data['posted_on'] <= $modSettings['edit_wait_time']);

		// Seems fine, update it then!
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_comments
			SET message = {string:message}' . ($skip_log ? '' : ', last_edited = {int:time}, last_edited_name = {string:name}, last_edited_by = {string:user_id}') . '
			WHERE id_comment = {int:id}',
			array(
				'message' => $new_message, 'time' => time(), 'name' => $user_info['name'], 'user_id' => $user_info['id'], 'id' => $com_data['id_comment']
			),__FILE__,__LINE__);

		redirectexit($galurl.'sa=item;in='.$com_data['id_media'].'#com'.$com_data['id_comment']);
	}
	else
		$context['sub_template'] = 'aeva_form';

	// Linktree
	$parents = aeva_getAlbumParents($com_data['album_id'], $com_data['master']);
	if (!empty($parents))
	{
		$parents = array_reverse($parents);
		foreach ($parents as $p)
			$amFunc['add_linktree']($galurl.'sa=album;in='.$p['id'],$p['name']);
	}
	$amFunc['add_linktree']($galurl.'sa=item;in='.$com_data['id_media'],$com_data['title']);
	$amFunc['add_linktree']($galurl.'sa=comment;in='.$com_data['id_media'],$txt['aeva_editing_com']);
}

// A common function to delete comments and items
function aeva_delete()
{
	global $galurl, $amFunc, $amSettings, $user_info, $db_prefix, $txt;

	if (empty($_GET['type']))
	{
		// Load the item
		$request = $amFunc['db_query']('
			SELECT m.id_media, m.id_member, m.album_id, a.album_of
			FROM {db_prefix}aeva_media AS m
			INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
			WHERE m.id_media = {int:id} LIMIT 1', array('id' => (int) $_GET['in']),__FILE__,__LINE__);
		if ($amFunc['db_num_rows']($request) == 0)
			fatal_lang_error('aeva_item_not_found', !empty($amSettings['log_access_errors']));
		$item_data = $amFunc['db_fetch_assoc']($request);
		$amFunc['db_free_result']($request);
		if (!aeva_allowedTo('moderate') && (!aeva_allowedTo('moderate_own_albums') || $item_data['album_of'] != $user_info['id']) && (!aeva_allowedTo('edit_own_item') || $item_data['id_member'] != $user_info['id']))
			fatal_lang_error('aeva_delete_denied');
		// Delete it
		aeva_deleteItems($item_data['id_media']);

		redirectexit($galurl.'sa=album;in='.$item_data['album_id']);
	}
	elseif ($_GET['type'] == 'comment')
	{
		$request = $amFunc['db_query']('
			SELECT c.id_comment, c.id_media, c.id_member, a.album_of
			FROM {db_prefix}aeva_comments AS c
			INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = c.id_album)
			WHERE c.id_comment = {int:comment} LIMIT 1',
			array('comment' => (int) $_GET['in']),__FILE__,__LINE__);
		if ($amFunc['db_num_rows']($request) == 0)
			fatal_lang_error('aeva_com_not_found');
		$com_data = $amFunc['db_fetch_assoc']($request);
		$amFunc['db_free_result']($request);
		if (!aeva_allowedTo('moderate') && (!aeva_allowedTo('moderate_own_albums') || $item_data['album_of'] != $user_info['id']) && (!aeva_allowedTo('edit_own_com') || $com_data['id_member'] != $user_info['id']))
			fatal_lang_error('aeva_delete_denied');
		// Delete it
		aeva_deleteComments($com_data['id_comment']);

		redirectexit($galurl.'sa=item;in='.$com_data['id_media']);
	}
	else
		fatal_lang_error('aeva_accessDenied', !empty($amSettings['log_access_errors']));

	// The item has been deleted, it shall rest in peace :P
}

// Quick moderation inside album pages...
function aeva_quickmodAlbum()
{
	global $galurl, $amFunc, $amSettings, $user_info, $db_prefix, $txt, $sourcedir;

	checkSession('post');

	if (!empty($_POST['mod_item']))
		$items = array_keys((array) $_POST['mod_item']);
	if (empty($items))
		fatal_lang_error('aeva_item_not_found', !empty($amSettings['log_access_errors']));

	// Load the items
	$request = $amFunc['db_query']('
		SELECT m.id_media, m.id_member, m.album_id, m.title
		FROM {db_prefix}aeva_media AS m
		WHERE id_media IN ({array_int:ids})', array('ids' => $items),__FILE__,__LINE__);
	$item_data = array();
	$can_moderate = aeva_allowedTo('moderate');
	$can_edit_own = aeva_allowedTo('edit_own_item');
	$can_approve = $can_moderate || aeva_allowedTo('auto_approve_item');
	while ($row = $amFunc['db_fetch_assoc']($request))
		if ($can_moderate || ($can_edit_own && $row['id_member'] == $user_info['id']))
			$item_data[$row['id_media']] = $row;
	$amFunc['db_free_result']($request);
	if (empty($item_data) || empty($_POST['aeva_modtype']))
		fatal_lang_error('aeva_item_not_found', !empty($amSettings['log_access_errors']));

	// Delete them
	if ($_POST['aeva_modtype'] == 'delete')
		aeva_deleteItems(array_keys($item_data));
	elseif ($_POST['aeva_modtype'] == 'move')
	{
		unset($_POST['submit_aeva']);
		$_POST['ids'] = array_keys($item_data);
		require_once($sourcedir . '/Aeva-Gallery2.php');
		aeva_moveItems();
		return;
	}
	elseif ($_POST['aeva_modtype'] == 'approve' && $can_approve)
	{
		foreach ($item_data as $id => $item)
			$item_data[$id] = $item['title'];
		aeva_approveItems($item_data, 1);
	}
	elseif ($_POST['aeva_modtype'] == 'unapprove' && $can_approve)
	{
		foreach ($item_data as $id => $item)
			$item_data[$id] = $item['title'];
		aeva_approveItems($item_data, 0);
	}
	elseif ($_POST['aeva_modtype'] == 'playlist' && aeva_allowedTo('add_playlists'))
	{
		$_POST['add_to_playlist'] = $_POST['aeva_playlist'];
		aeva_foxy_item_page_playlists(array_keys($item_data));
		redirectexit($galurl . 'sa=playlists;in=' . (int) $_POST['aeva_playlist']);
	}

	redirectexit($galurl . 'sa=album;in=' . (int) $_GET['in']);
}

// A common function to approve/unapprove items
function aeva_mgApprove()
{
	global $galurl, $amFunc, $amSettings, $user_info, $db_prefix, $txt;

	$approval = isset($_GET['sa']) && $_GET['sa'] == 'approve' ? 1 : 0;
	if (empty($_GET['type']))
	{
		// Load the item, and check whether it's the last item in the album...
		$request = $amFunc['db_query']('
			SELECT m.id_media, m.id_member, m.album_id, m.title, a.id_last_media
			FROM {db_prefix}aeva_media AS m
				INNER JOIN {db_prefix}aeva_albums AS a ON (m.album_id = a.id_album)
			WHERE id_media = {int:id} LIMIT 1', array('id' => (int) $_GET['in']),__FILE__,__LINE__);
		if ($amFunc['db_num_rows']($request) == 0)
			fatal_lang_error('aeva_item_not_found', !empty($amSettings['log_access_errors']));
		$item_data = $amFunc['db_fetch_assoc']($request);
		$amFunc['db_free_result']($request);

		if (!aeva_allowedTo('moderate') && (!aeva_allowedTo('auto_approve_item') || $item_data['id_member'] != $user_info['id']))
			fatal_lang_error('aeva_accessDenied', !empty($amSettings['log_access_errors']));

		aeva_approveItems(array($item_data['id_media'] => $item_data['title']), $approval);
		redirectexit($galurl.'sa=item;in='.$item_data['id_media']);
	}
	else
		fatal_lang_error('aeva_accessDenied', !empty($amSettings['log_access_errors']));
}

function aeva_addView()
{
	global $amFunc, $context, $user_info;

	if (!isset($_REQUEST['in']))
		die('Hacking attempt...');
	$id = (int) $_REQUEST['in'];

	// Update media item view count.
	$amFunc['db_query']('
		UPDATE {db_prefix}aeva_media
		SET views = views + 1
		WHERE id_media = {int:media}',
		array('media' => $id),__FILE__,__LINE__);

	if (aeva_markSeen($id))
		aeva_resetUnseen($user_info['id']);

	echo '<?xml version="1.0" encoding="', $context['character_set'], '"?', '>';
	obExit(false);
}

function aeva_getMedia()
{
	global $settings, $amFunc, $amSettings, $context;

	if (isset($_REQUEST['dl']) && !aeva_allowedTo('download_item'))
		fatal_lang_error('aeva_accessDenied', !empty($amSettings['log_access_errors']));

	if (!isset($_REQUEST['in']))
		die('Hacking attempt...');

	$type = current(array_intersect(array('thumb', 'thumba', 'preview', 'icon', 'bigicon', 'main'), array_keys($_REQUEST)));
	$type = $type === false ? 'main' : $type;

	// Get the file's data
	$id = (int) $_REQUEST['in'];

	// If you can't access... Forget it
	if (!aeva_allowedTo('access'))
	{
		$path = $settings['theme_dir'] . '/images/aeva/denied.png';
		$filename = 'denied.png';
		$is_new = false;
	}
	else
		list ($path, $filename, $is_new) = aeva_getMediaPath($id, $type);

	if (!$path)
	{
		header('HTTP/1.0 404 Not Found');
		die('Error! File not found');
	}

	// Update media item view count.
	if ($type == 'preview' || isset($_REQUEST['v']))
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_media
			SET views = views + 1
			WHERE id_media = {int:media}',
			array('media' => $id),__FILE__,__LINE__);

	if (!isset($_REQUEST['dl']))
	{
		$media = new aeva_media_handler;
		$media->init($path);

		$mime = $media->getMimeType();
		$media->close();
	}

	$range = '';
	$size = filesize($path);
	if (isset($_SERVER['HTTP_RANGE']))
	{
		// http://www.php.net/manual/en/function.fread.php#84115
		list ($size_unit, $range_orig) = explode('=', $_SERVER['HTTP_RANGE'], 2);

		if ($size_unit === 'bytes')
			list ($range) = explode(',', $range_orig, 1);
		list ($seek_start, $seek_end) = explode('-', $range, 2);
	}
	$seek_end = empty($seek_end) ? $size - 1 : min(abs((int) $seek_end), $size - 1);
	$seek_start = empty($seek_start) || $seek_end < abs((int) $seek_start) ? 0 : max(abs((int) $seek_start), 0);

	while (@ob_end_clean());

	// Send it
	header('Pragma: ');
	if (!$context['browser']['is_gecko'])
		header('Content-Transfer-Encoding: binary');
	header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 525600 * 60) . ' GMT');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');

	if (isset($_SERVER['HTTP_RANGE']))
	{
        if ($seek_start > 0 || $seek_end < ($size - 1))
			header('HTTP/1.1 206 Partial Content');

		header('Accept-Ranges: bytes');
		header('Content-Range: bytes ' . $seek_start . '-' . $seek_end . '/' . $size);
	}
    else
		header('Accept-Ranges: bytes');

	header('Content-Length: ' . ($seek_end - $seek_start + 1));
	header('Content-Encoding: none');

	if (isset($_REQUEST['dl']))
	{
		header('Connection: close');
		header('ETag: ' . md5_file($path));
		header('Content-Type: application/octet' . ($context['browser']['is_ie'] || $context['browser']['is_opera'] ? '' : '-') . 'stream');

		$is_chrome = $context['browser']['is_safari'] && stripos($_SERVER['HTTP_USER_AGENT'], 'chrome') !== false;
		$filename = aeva_entities2utf($filename);

		// Stupid Safari doesn't support UTF-8 filenames...
		if ($context['browser']['is_safari'] && !$is_chrome)
			$filename = utf8_decode($filename);

		$att = 'Content-Disposition: attachment; filename';
		if ($context['browser']['is_firefox'])
			header($att . '*="UTF-8\'\'' . $filename . '"');
		elseif ($context['browser']['is_ie'] || $is_chrome)
			header($att . '="' . rawurlencode($filename) . '"');
		else
			header($att . '="' . $filename . '"');
	}
	else
	{
		header('Content-Type: ' . $mime);
		header('Content-Disposition: inline; filename=' . $filename);
	}

	// If the file is over 1.5MB, readfile() may have some issues.
	if ($size > 1572864 || $seek_start > 0 || @readfile($path) == null)
	{
		if ($file = fopen($path, 'rb'))
		{
			fseek($file, $seek_start);
			while (!feof($file))
			{
				echo @fread($file, 8192);
				flush();
			}
			@fclose($file);
		}
		else
			die('Something went wrong... ' . $path);
	}

	// Could use output buffers to put all calls into one. May not be worth the effort.
	if ($is_new && aeva_markSeen($id))
	{
		global $user_info;
		aeva_resetUnseen($user_info['id']);
	}

	// Update download count if the download was successful.
	if (isset($_REQUEST['dl']))
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_media
			SET downloads = downloads + 1
			WHERE id_media = {int:media}',
			array('media' => $id),__FILE__,__LINE__);

	// Nothing more to come
	die;
}

?>