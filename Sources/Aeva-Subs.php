<?php
/****************************************************************
* Aeva Media													*
* � Noisen.com & SMF-Media.com									*
*****************************************************************
* Aeva-Subs.php - API functions, mainly							*
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

////////////////////////////////////////////
define('AEVA_MEDIA_VERSION', '1.4w');
////////////////////////////////////////////

/* This file contains vital functions used by the gallery in order to function

	void aeva_is_not_banned()
		- Checks whether the user is banned or not
		- If found banned, takes action as requested

	void aeva_reorderAlbums()
		- Re-orders the albums and fixes the a_order field in aeva_albums table to work correctly

	array aeva_getAlbumParents(int current, int master, bool simple)
		- Gets the specified album's parents, using its master ID

	array aeva_getAlbumChildren(int current)
		- Gets the specified album's children. Much slower than the earlier function, but rarely used.

	array aeva_getMediaPath(int mid, string type, bool security_override = false)
		- Gets the filepath and filename of the specified item's id
		- Valid types are "main/icon/thumb/preview"
		- Checks for permission if security_override is false

	bool aeva_createAlbumSubdir(int album_id)
		- Creates the album's sub directory

	bool aeva_createAlbumDir(int album_id, bool create_sub_dir = true)
		- Creates the album's main directory
		- If create_sub_dir is supplied as true, it also creates its first sub directory

	string aeva_getSuitableDir(int album_id)
		- Gets the suitable directory for an album to upload a file
		- Creates a sub directory if no suitable directory is found

	bool allowedToAccessAlbum(int albumid, array row = null)
		- Checks whether the user can access the album or not

	bool allowedToAccessItem(int id, int is_file_id = false)
		- Checks whether the user can access the item or not
		- If "is_file_id" is supplied true, it takes it as a file id and seeks out the item

	void aeva_loadSettings(string gal_url = null, bool load_template = false, bool load_language = false)
		- Loads the gallery's settings and vital variables

	void aeva_compat()
		- Does some compatibility checks for SMF 1.1 and SMF 2.0

	array albumsAllowedTo(string permission, bool details, bool need_write)
		- Returns the album's IDs in which the user can perform the supplied permission
		- Set details to true if you need a precise list of permissions and quotas
		- Set need_write to false if not looking for albums where uploading is allowed

	void aeva_loadAlbum()
		- Loads the current album's data
		- Handles password security as well as loads the permissions
		- Also checks for various permission clauses while accessing albums, items directly or indirectly

	void aeva_getQuickAlbums(string custom, string field)
		- If we just need a quick list with a single field from the album table...

	void aeva_getAlbums(string custom, int security_level = 2, string order, string limit, bool separate_children, bool/int need_desc, bool need_icon)
		- Gets the albums and sets them as $context elements
		- Automatically orders them in there specified order, child level etc.
		- $context['aeva_albums'] holds the complete album list with its every bit of info.
		- $context['aeva_album_list'] holds the album list ordered by there desired order
		- custom can be used to pass custom WHERE SQL command
		- Use security_level for different levels of query_see_album. 0 for disabled, 1 for {_query_see_album} (no check for entered password), 2 for {query_see_album} (default)
		- Since it's pretty CPU intensive to retrieve descriptions and icons, we can disable them too.
		- If we set need_desc to an integer, descriptions will only be retrieved if the number of albums in the array is lower than need_desc.

	void aeva_recursiveAlbums(array _list, array _tree)
		- Recursively builds the album tree

	void aeva_getOverallTotal(array _album, array _dat)
		- Gets the total number of items in an album, including its children

	bool aeva_approveItems(array items, bool approval)
		- Approves or unapproves an item

	bool aeva_deleteItems(int/array id, bool rmFiles, bool log)
		- Deletes one or more specified items
		- rmFiles can be used to specify whether to delete files or not
		- log can be set to false to skip logging

	bool aeva_deleteComments(int/array id, bool log)
		- Deletes one or more comments
		- log can be used to skip logging

	int/bool aeva_logModAction(array options, bool return_boolean)
		- Logs an action
		- If return_boolean is true, returns true on success, otherwise returns ID of the insertion in the table

	void aeva_createTextEditor(string post_box_name, string post_bos_form, int forceDisableBBC,
							string value)
		- Creates a SMF 1.1/SMF 2.0 BBC editor or a SMF 2.0 WYSIWYG editor

	array aeva_getOnlineType(array actions)
		- Called by Who.php to determine the type of action

	array aeva_getFetchData(string type, array data)
		- Returns data which needs fetching to be displayed

	array aeva_insertFileID(array options, int filesize, int filename, int width, int height, string directory, int id_album, string exif)
		- Inserts (or updates) file data into the files tables

	void aeva_loadQuotas()
		- Loads the file size limits for the specific album and specific member

	array aeva_createFile(array options)
		- Creates a file and its thumbnail, preview if requested

	int aeva_createThumbFile(int id_file, string file, array options)
		- Creates a thumbnail file

	int aeva_createPreviewFile(int id_file, string file, array options, int width, int height)
		- Creates a preview file

	bool aeva_deleteFiles(int/array id_files)
		- Deletes one or more files

	int aeva_createItem(array options)
		- Creates an item using a set of options

	int aeva_modifyItem(array options)
		- Modifies an item using a set of options

	void aeva_emptyTmpFolder()
		- Empties out the mgal_data/tmp folder

	string aeva_timeformat(int log_time)
		- Takes UNIX timestamp and formats it into a short and readable string

	array aeva_fillMediaArray(resource request, bool all_albums)
		- Takes the db request of "request" and creates an associative array

	string aeva_parse_bbc(string message)
		- Parses the [smg] BBC tag inside messages

	string aeva_parse_bbc_each(array data)
		- Does the actual parsing for each [smg] tag

	array aeva_loadCustomFields(int id_media = null, array albums = array, string custom = '')
		- Loads custom fields
		- If id_media is supplied, loads the custom fields along with the data for that item
		- If albums is supplied, loads custom fields only for those albums
		- Custom can be used for any custom WHERE clause

	array aeva_getMediaItems(int start, int limit, string sort, bool all_albums, array albums, string custom)
		- Gets items

	string aeva_listItems(array items, bool in_album = false, string align, int per_line)
		- Creates HTML for viewing items

	array aeva_getMediaComments(int start, int limit, bool random, array albums, string custom)
		- Gets comments

	array aeva_getTopAlbumsByComments(int limit, string order)
		- Gets top albums by comment count

	array aeva_getTopItems(int limit, string by = views/rating/comments, string order = DESC/ASC)
		- Gets top items by a specified order

	void aeva_updateSettings(string setting, string new_value, bool replace)
		- Updates a setting in the aeva_settings table
		- Also updates the $amSettings variable

	void aeva_increaseSettings(string setting, int add)
		- Increments a setting
		- Decrements if the value is below 0

	string aeva_theme_url(string file)
		- Gets the URL of a file inside the Theme
		- Fallbacks to default theme if not found inside the theme's folder

	string aeva_profile(int id, string name, string func)
		- Returns the URL to the profile area of gallery.

	void aeva_markSeen(int id, string options, int user)
		- Marks a specified item or multiple items as seen

	void aeva_updateWeighted()
		- Updates the rating weight of all the items

	string aeva_lockedAlbum(string pass, int id, int owner, string title)
		- Returns the title string which will be used to display the locked/unlocked status of album

	int aeva_foolProof()
		- Checks whether the gallery data folder exists and is writable. This is useful after a server
		  upgrade. Many times, the admin forgets to update this and then thinks it's my fault... :P

	void aeva_mkdir(string dir, octal chmod)
		- Creates a folder via mkdir or, if PHP safe mode is enabled, try to create it via FTP

	void aeva_addHeaders(bool add_to_headers, bool use_lightbox = true)
		- Adds the Aeva declarations to the headers
		- If add_to_headers is true, it replaces the buffer instead of using $context['html_headers']

	void aeva_loadLanguage(string str)
		- Makes sure $txt[$str] is available by loading language files

	array aeva_getItemData(int item)
		- Requests all the data of a specific item
*/

// The below functions are for database cross-compatibility between SMF 1.1 and SMF 2.0

/************************************************
Those were the DB Functions, now the other functions
************************************************/

// Checks whether the user is banned
function aeva_is_not_banned()
{
	global $user_info, $amFunc;

	// Managers can't be banned!
	if (aeva_allowedTo('manage') || $user_info['is_guest'])
		return;

	$_SESSION['aeva_ban'] = array();
	$request = $amFunc['db_query']('
		SELECT id, type, val1, val2, val3
		FROM {db_prefix}aeva_variables
		WHERE type = {string:ban}
		AND val1 = {int:id_member}', array(
			'ban' => 'ban',
			'id_member' => $user_info['id']
		),__FILE__,__LINE__);
	if ($amFunc['db_num_rows']($request) == 0)
	{
		$_SESSION['aeva_ban']['is_banned'] = false;
		$_SESSION['aeva_ban']['set_on'] = time();
	}
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		if ($row['val3'] != 0 && $row['val3'] < time())
		{
			$amFunc['db_query']('
				DELETE FROM {db_prefix}aeva_variables
				WHERE id = {int:id}
			', array('id' => $row['id']),__FILE__,__LINE__);
			continue;
		}

		aeva_loadLanguage('aeva_banned_full');

		// Bye Bye
		if ($row['val2'] == 1)
			fatal_lang_error('aeva_banned_full');
		elseif (($row['val2'] == 2 || $row['val2'] == 4) && isset($_REQUEST['sa']) && ($_REQUEST['sa'] == 'post' || $_REQUEST['sa'] == 'mass'))
			fatal_lang_error('aeva_banned_post');
		elseif (($row['val2'] == 3 || $row['val2'] == 4) && isset($_REQUEST['sa']) && $_REQUEST['sa'] == 'comment')
			fatal_lang_error('aeva_banned_comment_post');
	}
	$amFunc['db_free_result']($request);
}

// Re-Orders albums
function aeva_reorderAlbums()
{
	global $amFunc, $context;

	aeva_getAlbums('', 0, false);
	$order = 0;

	foreach ($context['aeva_album_list'] as $album)
	{
		if ($context['aeva_albums'][$album]['order'] != $order)
			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_albums
				SET a_order = {int:order}
				WHERE id_album = {int:album}',array('order' => $order, 'album' => $album),__FILE__,__LINE__);
		$order += 2;
	}
}

// Return all the parents of an album, requires the master ID
function aeva_getAlbumParents($current, $master, $simple = false)
{
	global $amFunc, $context;

	if (isset($context['aeva_album']))
	{
		$a = &$context['aeva_album'];
		if (empty($a['parent']))
			return $simple ? array($a['id']) : array(0 => $a);
	}

	$alb = $albums = array();
	$req = 'SELECT a.id_album, a.parent' . ($simple ? '' : ', a.name, a.hidden, a.album_of') . '
			FROM {db_prefix}aeva_albums AS a
			WHERE a.master = {int:master}';
	$request = $amFunc['db_query']($req, array('master' => $master), __FILE__,__LINE__);
	while ($row = $amFunc['db_fetch_assoc']($request))
		$alb[$row['id_album']] = $row;
	if (!empty($alb))
		$amFunc['db_free_result']($request);

	if ($simple)
	{
		$albums[] = $current;
		while ($current != 0)
			$albums[] = $current = $alb[$current]['parent'];
	}
	else
	{
		while ($current != 0)
		{
			$row = $alb[$current];
			$albums[] = array(
				'id' => $row['id_album'],
				'parent' => $current = $row['parent'],
				'name' => $row['name'],
				'hidden' => $row['hidden'],
				'owner' => $row['album_of'],
			);
		}
	}

	return $albums;
}

function aeva_getAlbumChildren($current)
{
	global $amFunc;

	$albums = array();

	$req = 'SELECT a.id_album
			FROM {db_prefix}aeva_albums AS a
			WHERE a.parent = {int:album}
			LIMIT 1';
	$request = $amFunc['db_query']($req, array('album' => $current), __FILE__,__LINE__);

	while ($row = $amFunc['db_fetch_assoc']($request))
		$albums = array_merge($albums, (array) $row['id_album'], aeva_getAlbumChildren($row['id_album']));
	$amFunc['db_free_result']($request);

	return $albums;
}

// This function returns file path to a media, also checks security unless security_override is true
function aeva_getMediaPath($mid, $type = 'main', $security_override = false)
{
	global $amFunc, $amSettings, $settings, $user_info;

	// Get the item's filename
	$galdir = $amSettings['data_dir_path'];

	// Main = item file, thumb = item's thumbnail, preview = item's preview,
	// Icon = album's icon, thumba = item's thumbnail - if not found, use owner album's icon
	if (!in_array($type, array('main', 'icon', 'bigicon', 'thumb', 'preview', 'thumba')))
		return false;

	if ($type == 'icon' || $type == 'bigicon')
		$req = '
		SELECT f.id_file, f.filename, f.directory, a.bigicon
		FROM {db_prefix}aeva_albums AS a
			INNER JOIN {db_prefix}aeva_files AS f ON (f.id_file = '. ($type == 'bigicon' ? 'IF(a.bigicon = 0, a.icon, a.bigicon)' : 'a.icon') . ')
		WHERE
			a.id_album = {int:media_id}' .
		($security_override || aeva_allowedTo('moderate') ? '' : '
			AND (f.id_file < 5 OR {query_see_hidden_albums})
			AND (a.approved = 1 OR a.album_of = {int:user_id})');
	else
		$req = '
		SELECT
			f.id_file, f.filename, f.directory' . (!$user_info['is_guest'] && ($type == 'preview' || $type == 'main') ? ',
			IFNULL(lm.time, IFNULL(lm_all.time, 0)) < m.log_last_access_time AS is_new' : ($type == 'thumb' || $type == 'thumba' ? ',
			forig.filename AS original_filename' : '')) . '
		FROM {db_prefix}aeva_media AS m' . (!$user_info['is_guest'] && ($type == 'preview' || $type == 'main') ? '
			LEFT JOIN {db_prefix}aeva_log_media AS lm ON (lm.id_media = m.id_media AND lm.id_member = ' . $user_info['id'] . ')
			LEFT JOIN {db_prefix}aeva_log_media AS lm_all ON (lm_all.id_media = 0 AND lm_all.id_member = ' . $user_info['id'] . ')' : ($type == 'thumba' ? '
			INNER JOIN {db_prefix}aeva_albums AS albicon ON (albicon.id_album = m.album_id)' : '')) . '
			INNER JOIN {db_prefix}aeva_files AS f
				ON ('
				. ($type == 'thumba' ? 'IF(m.id_thumb < 5 AND albicon.icon > 4, albicon.icon, IF(m.id_thumb > 0, m.id_thumb, m.id_file)) = f.id_file)'
				: ($type != 'main' ? 'IF(m.id_' . $type . ' = 0, m.id_file, m.id_' . $type . ')' : 'm.id_file') . ' = f.id_file)') . ($type == 'thumb' || $type == 'thumba' ? '
			LEFT JOIN {db_prefix}aeva_files AS forig
				ON (m.id_file = forig.id_file AND m.id_thumb < 5)' : '') .
		($security_override || aeva_allowedTo('moderate') ? '
		WHERE m.id_media = {int:media_id}' : '
			LEFT JOIN {db_prefix}aeva_albums AS a ON (a.id_album = f.id_album)
		WHERE m.id_media = {int:media_id}
		AND (f.id_file < 5 OR {query_see_hidden_albums})
		AND (m.approved = 1 OR m.id_member = {int:user_id})');

	$result = $amFunc['db_query']($req . ' LIMIT 1', array('media_id' => $mid, 'user_id' => $user_info['id']), __FILE__,__LINE__);

	// Not found?
	if ($amFunc['db_num_rows']($result) > 0)
	{
		$row = $amFunc['db_fetch_assoc']($result);
		$is_new = !empty($row['is_new']);
		$ext = !empty($row['original_filename']) ? strtolower(substr(strrchr($row['original_filename'], '.'), 1)) : '';
		$allowed_types = aeva_allowed_types(false, true);
		if (in_array($ext, $allowed_types['do']))
		{
			$path = $amSettings['data_dir_path'] . '/generic_images/';
			$filename = (!file_exists($path . $ext . '.png') ? 'default' : $ext) . '.png';
			$path .= $filename;
		}
		else
		{
			$path = $galdir . '/' . $row['directory'] . '/' . ($row['id_file'] > 4 ? aeva_getEncryptedFilename($row['filename'], $row['id_file'], in_array($type, array('icon', 'thumb', 'thumba')) || ($type == 'bigicon' && empty($row['bigicon']))) : $row['filename']);
			$filename = $row['filename'];
		}
	}
	else
	{
		$path = $type == 'icon' ? $settings['default_theme_dir'] . '/images/blank.gif' : $settings['theme_dir'] . '/images/aeva/denied.png';
		$filename = 'denied.png';
		$is_new = false;
	}
	$amFunc['db_free_result']($result);

	return file_exists($path) ? array($path, $filename, $is_new) : false;
}

// Creates a sub directory for a album, is mainly used by aeva_getSuitableDir() function
function aeva_createAlbumSubdir($album_id)
{
	global $amFunc, $amSettings, $db_prefix;

	// Get the album's directory info
	$result = $amFunc['db_query']('
		SELECT directory
		FROM {db_prefix}aeva_albums
		WHERE id_album = {int:album_id}',
		array('album_id' => $album_id),__FILE__,__LINE__);

	if ($amFunc['db_num_rows']($result) == 0)
		return false;
	$row = $amFunc['db_fetch_assoc']($result);
	$path_to_album = '/' . $row['directory'];
	$amFunc['db_free_result']($result);

	$result = $amFunc['db_query']("
		SELECT val2
		FROM {db_prefix}aeva_variables
		WHERE val1 = {int:album_id}
		AND type = {string:type}
		ORDER BY id DESC
		LIMIT 1",
		array(
			'album_id' => $album_id,
			'type' => 'dir',
		),__FILE__,__LINE__);

	if ($amFunc['db_num_rows']($result) == 0)
		$newDirName = 'Dir_1';
	else
	{
		$row = $amFunc['db_fetch_assoc']($result);
		$last_dir_id = substr($row['val2'],4);

		$newDirName = 'Dir_'.($last_dir_id + 1);
	}
	$amFunc['db_free_result']($result);

	// Create the directory
	$makedir = aeva_mkdir($path_to_album . '/' . $newDirName, 0777);

	// Copy index.php for protection
	@copy($amSettings['data_dir_path'] . '/albums/index.php', $path_to_album . '/' . $newDirName . '/index.php');

	// Now do the final steps
	if ($makedir)
	{
		$amFunc['db_insert'](
			$db_prefix . 'aeva_variables',
			array('type', 'val1', 'val2', 'val3', 'val4', 'val5', 'val6', 'val7', 'val8', 'val9'),
			array('dir', $album_id, $newDirName, '', '', '', '', '', '', ''),
			__FILE__,__LINE__
		);
		return $newDirName;
	}
	else
		return false;
}

// This creates a directory for a album, assuming that the entry for the album exists.
function aeva_createAlbumDir($album_id, $create_sub_dir = true)
{
	global $amFunc, $amSettings;

	$result = $amFunc['db_query']('
		SELECT name
		FROM {db_prefix}aeva_albums
		WHERE id_album = {int:album_id}',
		array(
			'album_id' => $album_id,
		),__FILE__,__LINE__);
	if ($amFunc['db_num_rows']($result) == 0)
		return false;
	$row = $amFunc['db_fetch_assoc']($result);
	$row['name'] = str_replace(array(' ', '.', '-', '_', '\\', '/', '#', '&', '*'), '_', $row['name']);
	$new_path_to_album = '/albums/' . $row['name'];
	$new_dir_name = 'albums/'.$row['name'];
	$amFunc['db_free_result']($result);

	// Make sure it doesn't exist
	$i = 0;
	while (file_exists($amSettings['data_dir_path'] . $new_path_to_album))
	{
		$i++;
		$new_path_to_album = '/albums/' . $row['name'] . '_' . $i;
		$new_dir_name = 'albums/'.$row['name'] . '_' . $i;
	}

	// Now create it!
	$new_dir = aeva_mkdir($new_path_to_album, 0777);
	if ($new_dir)
	{
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_albums
			SET directory = {string:directory}
			WHERE id_album = {int:id_album}',
			array('directory' => $new_dir_name, 'id_album' => $album_id),
			__FILE__,__LINE__
		);
		if ($amFunc['db_affected_rows']() == 0)
			return false;
	}

	// Copy the index.php for protection!
	@copy($amSettings['data_dir_path'] . '/albums/index.php', $new_path_to_album . '/index.php');

	// Shall we create the sub dir?
	if ($new_dir && $create_sub_dir)
	{
		$sub_dir = aeva_createAlbumSubdir($album_id);
		if (!$sub_dir)
		{
			@rmdir($new_path_to_album);
			return false;
		}
		return true;
	}

	return (bool) $new_dir;
}

function aeva_getSuitableDir($album_id)
{
	// This function is used to get a suitable directory to place the file in
	// If no suitable directory is found, it creates one
	global $amFunc, $amSettings;

	// Better crash now than later!
	$is_dir = aeva_foolProof();
	if ($is_dir !== 1)
		fatal_lang_error($is_dir ? 'aeva_admin_album_dir_failed' : 'aeva_not_a_dir');

	$request = $amFunc['db_query']('
		SELECT directory
		FROM {db_prefix}aeva_albums
		WHERE id_album = {int:album}
	',array('album' => $album_id),__FILE__,__LINE__);
	$row = $amFunc['db_fetch_assoc']($request);
	// Is it messed up?
	if (empty($row['directory']) || !file_exists($amSettings['data_dir_path'] . '/' . $row['directory']))
		return false;
	$path_to_album = $amSettings['data_dir_path'] . '/' . $row['directory'];
	$amFunc['db_free_result']($request);

	$request = $amFunc['db_query']('
		SELECT val1, val2
		FROM {db_prefix}aeva_variables
		WHERE val1 = {int:album_id}
		AND type = {string:type}
		ORDER BY id DESC
		LIMIT 1
	',array('album_id' => $album_id, 'type' => 'dir'),__FILE__,__LINE__);

	if ($amFunc['db_num_rows']($request) == 0)
	{
		$new_dir = aeva_createAlbumSubdir($album_id);
		if (!$new_dir)
			return false;
		else
			$path_to_dir = $path_to_album . '/' . $new_dir;
	}
	else
	{
		$row = $amFunc['db_fetch_assoc']($request);
		$path_to_dir = $path_to_album.'/'.$row['val2'];
		if ((aeva_get_num_files($path_to_dir) >= $amSettings['max_dir_files']) || (aeva_get_size($path_to_dir) >= $amSettings['max_dir_size'] * 1024))
		{
			$new_dir = aeva_createAlbumSubdir($album_id);
			if (!$new_dir)
				return false;
			else
				$path_to_dir = $path_to_album . '/' . $new_dir;
		}
	}
	return $path_to_dir;
}

function allowedToAccessAlbum($albumid, $row = null)
{
	// Return true of allowed, passwd if it is a password problem, and false if user is not allowed
	global $amFunc, $user_info;

	if (aeva_allowedTo('moderate'))
		return true;

	if (!is_array($row))
	{
		$result = $amFunc['db_query']('
			SELECT approved, passwd, album_of, id_album, access, allowed_members, denied_members
			FROM {db_prefix}aeva_albums
			WHERE id_album = {int:album_id}',
			array(
				'album_id' => $albumid,
			),__FILE__,__LINE__);
		$row = $amFunc['db_fetch_assoc']($result);
		$amFunc['db_free_result']($result);
	}

	if (($row['album_of'] == $user_info['id']) && !$user_info['is_guest'])
		return true;

	if (!empty($row['allowed_members']) && in_array($user_info['id'], explode(',', $row['allowed_members'])))
		return true;

	if (!empty($row['denied_members']) && in_array($user_info['id'], explode(',', $row['denied_members'])))
		return false;

	if (empty($row['approved']))
		return false;

	if (count(array_intersect($user_info['groups'], explode(',', $row['access']))) == 0)
		return false;

	if (!empty($row['passwd']) && (empty($_SESSION['aeva_access']) || !in_array($row['id_album'], $_SESSION['aeva_access'])))
		return 'passwd';

	return true;
}

function allowedToAccessItem($id, $is_file_id = false)
{
	// Simple function to check whether a user can enter a specific item or not.
	global $amFunc, $user_info;

	if (aeva_allowedTo('moderate'))
		return true;

	// Get it whether the user can enter or not
	$request = $amFunc['db_query']('
		SELECT m.album_id
		FROM {db_prefix}aeva_media AS m
			INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
		WHERE '. ($is_file_id ? 'm.id_file' : 'm.id_media') .' = {int:id}
		{raw:approved}
		AND {query_see_hidden_albums}
	', array(
		'id' => $id,
		'approved' => !aeva_allowedTo('moderate') ? 'AND (m.approved = 1 OR m.id_member = '.$user_info['id'].')' : ''
	), __FILE__,__LINE__);

	$ret = $amFunc['db_num_rows']($request) > 0;
	$amFunc['db_free_result']($request);
	return $ret;
}

// Load the gallery's critical settings and variables
function aeva_loadSettings($gal_url = null, $load_template = false, $load_language = false)
{
	global
		$amFunc, $user_info, $amSettings, $modSettings, $context, $txt,
		$scripturl, $galurl, $galurl2, $settings, $sourcedir, $amOverride;
	static $am_loaded = false;

	if ($load_template)
		loadTemplate('Aeva');
	if ($load_language)
		aeva_loadLanguage('aeva_enable');
	if ($am_loaded)
		return;
	$am_loaded = true;

	// Call that other file...
	require_once($sourcedir . '/Aeva-Subs-Vital.php');

	// Is the Foxy! add-on installed? If yes, load it...
	if ($context['aeva_foxy'] = file_exists($sourcedir . '/Aeva-Foxy.php'))
		require_once($sourcedir . '/Aeva-Foxy.php');

	// First some compatibility stuff
	aeva_compat();

	// Define the query_see_album shortcut for DB Queries
	// It is here so that it can be accessed from the outside world ;)

	if (aeva_allowedTo('moderate'))
		$user_info['aeva_query_see_album'] = '1=1';
	elseif ($user_info['is_guest'])
		$user_info['aeva_query_see_album'] = 'FIND_IN_SET(-1, a.access)';
	else
		$user_info['aeva_query_see_album'] = '(FIND_IN_SET(' . implode(', a.access) OR FIND_IN_SET(', $user_info['groups']) . ', a.access) OR (a.album_of = ' . (int) $user_info['id'] . ') OR FIND_IN_SET(' . $user_info['id'] . ', a.allowed_members))
		AND (NOT FIND_IN_SET(' . $user_info['id'] . ', a.denied_members))';

	$user_info['aeva_query_see_hidden_albums'] = $user_info['aeva_query_see_album'];
	$user_info['aeva_query_see_album'] .= $user_info['is_guest'] ? ' AND (a.hidden = 0)' : ' AND (a.hidden = 0 OR a.album_of = ' . (int) $user_info['id'] . ')';

	$user_info['aeva_query_see_album_2'] = $user_info['aeva_query_see_album'];

	if (!aeva_allowedTo('moderate'))
		$user_info['aeva_query_see_album'] .= ' AND (CHAR_LENGTH(a.passwd) = 0' . ($user_info['is_guest'] ? '' : ' OR a.album_of = ' . (int) $user_info['id']) . (empty($_SESSION['aeva_access']) ? '' : ' OR a.id_album IN (' . implode(',', $_SESSION['aeva_access']) . ')') . ')';

	// Call the other functions

	// Then the DB
	aeva_loadDatabase();

	// Is it set?
	if (!isset($_SESSION['aeva_access']))
		$_SESSION['aeva_access'] = array();

	if (empty($amSettings['enable_cache']) || ($amSettings = $amFunc['cache_get_data']('aeva_settings', 60)) == null)
	{
		$amSettings = array();
		$request = $amFunc['db_query']("
			SELECT name, value
			FROM {db_prefix}aeva_settings", array(), __FILE__,__LINE__);
		while ($row = $amFunc['db_fetch_assoc']($request))
			$amSettings[$row['name']] = $row['value'];
		$amFunc['db_free_result']($request);
		$amSettings['version'] = AEVA_MEDIA_VERSION;

		// Cache the settings
		if ($amSettings['enable_cache'])
			$amFunc['cache_put_data']('aeva_settings', $amSettings, 60);
	}
	// If you want to easily override settings dynamically, set $amSettings in index.template.php's template_init() function.
	if (!empty($amOverride))
		$amSettings = $amOverride + $amSettings;

	if (!empty($amSettings['ftp_file']) && file_exists($amSettings['ftp_file']))
	{
		require_once($amSettings['ftp_file']);
		if ($context['smg_ftp']['mgal_data'] != '/' && substr($context['smg_ftp']['mgal_data'], -1) == '/')
			$context['smg_ftp']['mgal_data'] = substr($context['smg_ftp']['mgal_data'], 0, -1);
	}
	$settings['images_aeva'] = file_exists($settings['theme_dir'] . '/images/aeva') ? $settings['images_url'] . '/aeva' : $settings['default_images_url'] . '/aeva';

	// $galurl got the URL to gallery for subactions, and $galurl2 got URL for gallery for main page
	if ($gal_url == null || empty($gal_url) || $gal_url == false)
		$galurl = $scripturl . '?action=media;';
	else
		$galurl = $gal_url;

	$galurl2 = rtrim($galurl, ';?&');

	// Session var fallback
	if (!isset($context['session_var']))
		$context['session_var'] = 'sesc';

	// Recalculate number of unseen items
	if (!empty($user_info['aeva_unseen']) && $user_info['aeva_unseen'] == -1)
	{
		$aeva_unseen = 0;
		if ($can_unseen = aeva_allowedTo('access_unseen'))
		{
			$request = $amFunc['db_query']('
				SELECT COUNT(m.id_media)
				FROM {db_prefix}aeva_media AS m
					INNER JOIN {db_prefix}aeva_albums AS a ON (m.album_id = a.id_album)
					LEFT JOIN {db_prefix}aeva_log_media AS lm ON (lm.id_media = m.id_media AND lm.id_member = {int:user})
					LEFT JOIN {db_prefix}aeva_log_media AS lm_all ON (lm_all.id_media = 0 AND lm_all.id_member = {int:user})
				WHERE {query_see_album}
				AND IFNULL(lm.time, IFNULL(lm_all.time, 0)) < m.log_last_access_time' . (!aeva_allowedTo('moderate') ? '
				AND m.approved = 1' : '') . '
				LIMIT 1', array('user' => $user_info['id']), __FILE__,__LINE__);
			list ($aeva_unseen) = $amFunc['db_fetch_row']($request);
			$amFunc['db_free_result']($request);
		}
		updateMemberData($user_info['id'], array('aeva_unseen' => $aeva_unseen));
		$user_info['aeva_unseen'] = $aeva_unseen;
		// If unseen counter if set to 0, make sure to clean up the database!
		if ($can_unseen && empty($aeva_unseen))
			aeva_markAllSeen();
	}
}

function my_version_compare($v1, $v2)
{
	$main1 = substr($v1, 0, strpos($v1, '.'));
	$main2 = substr($v2, 0, strpos($v2, '.'));
	if ($main1 < $main2) return false;
	if ($main1 > $main2) return true;
	$v1 = str_replace(array('a', 'b', 'c'), array('01', '02', '03'), strrchr($v1, '.')) . '00000';
	$v2 = str_replace(array('a', 'b', 'c'), array('01', '02', '03'), strrchr($v2, '.')) . '00000';

	for ($i = 0; $i < 5; $i++)
		if ($v1[$i] < $v2[$i]) return false;
	elseif ($v1[$i] > $v2[$i]) return true;
	return false;
}

function aeva_compat()
{
	// Ensures compatibility between SMF 1.1 and 2.0
	global $context, $smcFunc, $func, $amFunc, $ID_MEMBER, $user_info;

	$context['is_smf2'] = isset($smcFunc) && function_exists('db_extend');

	if ($context['is_smf2'])
	{
		foreach ($smcFunc as $k => $v)
			if (substr($k,0,2) !== 'db')
				$amFunc[$k] = $smcFunc[$k];
	}
	else
	{
		if (!isset($_REQUEST['action']) || !in_array($_REQUEST['action'], array('post', 'post2')))
		{
			$_POST = stripslashes__recursive($_POST);
			$_GET = stripslashes__recursive($_GET);
			$_REQUEST = stripslashes__recursive($_REQUEST);
		}
		foreach ($func as $k => $v)
			$amFunc[$k] = $func[$k];
		$context['html_headers'] .= '
	<link rel="stylesheet" type="text/css" href="' . aeva_theme_url('smf1.css') . '" />';
	}

	// Just centralize some common functions here
	if (empty($amFunc))
		$amFunc = array();
	$amFunc += array(
		'time_format' => 'timeformat',
		'comma_format' => 'comma_format',
		'shorten_subject' => 'shorten_subject',
		'forum_time' => 'forum_time',
		'parse_bbc' => 'parse_bbc',
		'add_linktree' => 'aeva_addLinktree',
		'construct_page_index' => 'constructPageIndex',
		'cache_put_data' => 'cache_put_data',
		'cache_get_data' => 'cache_get_data',
		'ucwords' => 'ucwords',
	);

	if (!$context['is_smf2'])
		$user_info['id'] = $ID_MEMBER;

	if (!isset($context['browser']['is_ie8']) && !$context['browser']['is_ie'])
		$context['browser']['is_ie'] = $context['browser']['is_ie8'] = strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8') !== false;

	// List all album-specific permissions
	$context['aeva_album_permissions'] = array(
		'auto_approve_com',
		'comment',
		'download_item',
		'edit_own_com',
		'multi_download',
		'rate_items',
		'report_com',
		'report_item',
		'whoratedwhat',
		'add_audios',
		'add_docs',
		'add_embeds',
		'add_images',
		'add_videos',
		'auto_approve_item',
		'edit_own_item',
		'multi_upload',
	);

	// Declare this function is it is not defined yet, for PHP 4.x and SMF 1.1.x compatibility.
	if (!function_exists('array_combine'))
	{
		// Array combine
		function array_combine($keys, $values)
		{
			$ret = array();
			if (count($keys) != count($values) || !is_array($keys) || !is_array($values))
				return false;

			$count = count($keys);
			$keys = array_values($keys);
			$values = array_values($values);

			for ($i=0; $i < $count; $i++)
				$ret[$keys[$i]] = $values[$i];

			return $ret;
		}
	}
}

// Returns albums with selected permission.. Set details to true if you want a list of permissions associated with them.
function albumsAllowedTo($permission, $details = false, $need_write = true)
{
	global $amFunc, $user_info, $context;

	if (empty($permission) || (!$details && aeva_allowedTo('moderate')))
		return false;

	if (!is_array($permission))
		$permission = array($permission);

	// Load it..
	// If we want details but user can moderate (i.e. has all permissions), just ask for the quota list...
	if ($details && aeva_allowedTo('moderate'))
		$query = '
		SELECT a.id_album, a.featured, a.album_of, q.quota AS `limit`, q.type AS media_type
		FROM {db_prefix}aeva_quotas AS q
		LEFT JOIN {db_prefix}aeva_albums AS a ON a.id_quota_profile = q.id_profile
		WHERE q.id_group IN ({array_int:groups})';
	elseif ($details)
		$query = '
		SELECT a.id_album, a.featured, a.album_of, p.permission, q.quota AS `limit`, q.type AS media_type
		FROM {db_prefix}aeva_albums AS a
		INNER JOIN {db_prefix}aeva_perms AS p ON (p.id_profile = a.id_perm_profile)
		LEFT JOIN {db_prefix}aeva_quotas AS q ON (
			q.id_profile = a.id_quota_profile AND
			q.id_group IN ({array_int:groups}) AND
			q.type = CASE p.permission WHEN {string:add_image} THEN {string:image} WHEN {string:add_audio} THEN {string:audio}
			WHEN {string:add_video} THEN {string:video} WHEN {string:add_embed} THEN {string:embed} WHEN {string:add_doc} THEN {string:doc} END
		)
		WHERE p.permission IN ({array_string:permissions})
			AND p.id_group IN ({array_int:groups})';
	else
		$query = '
		SELECT DISTINCT a.id_album
		FROM {db_prefix}aeva_albums AS a
		INNER JOIN {db_prefix}aeva_perms AS p ON (p.id_profile = a.id_perm_profile)
		WHERE p.permission IN ({array_string:permissions})
			AND p.id_group IN ({array_int:groups})';

	if ($need_write && !aeva_allowedTo('moderate'))
		$query .= '
			AND (a.album_of = ' . $user_info['id'] . ' OR FIND_IN_SET(' . $user_info['id'] . ', a.allowed_write)
				OR FIND_IN_SET(' . implode(', a.access_write) OR FIND_IN_SET(', $user_info['groups']) . ', a.access_write))
			AND NOT FIND_IN_SET(' . $user_info['id'] . ', a.denied_write)';

	$request = $amFunc['db_query']($query, array(
		'groups' => $user_info['groups'],
		'permissions' => $permission,
		'add_image' => 'add_images',
		'add_video' => 'add_videos',
		'add_audio' => 'add_audios',
		'add_embed' => 'add_embeds',
		'add_doc' => 'add_docs',
		'image' => 'image',
		'audio' => 'audio',
		'video' => 'video',
		'embed' => 'embed',
		'doc' => 'doc',
	),__FILE__,__LINE__);
	$albums = array();
	if ($details)
		while ($row = $amFunc['db_fetch_assoc']($request))
		{
			if (isset($row['permission']))
				$albums[$row['id_album']]['perms'][$row['permission']] = true;
			$albums[$row['id_album']]['quota'][$row['media_type']] = $row['limit'];
		}
	else
		while ($row = $amFunc['db_fetch_assoc']($request))
			$albums[] = $row['id_album'];
	$amFunc['db_free_result']($request);

	return $albums;
}

// Loads the current album... Handles a great deal of security
function aeva_loadAlbum($album_id = 0)
{
	global $amFunc, $context, $user_info, $settings, $galurl, $txt, $amSettings, $scripturl;

	// Let's see if we got anything we can get an ID from?
	// This is gonna be complex
	if (!empty($album_id))
		$id = $album_id;
	elseif (isset($_REQUEST['album']))
		$id = (int) $_REQUEST['album'];
	elseif ($context['aeva_act'] == 'massdown' && $context['aeva_sa'] == 'create' && !empty($_SESSION['aeva_mdl']))
		$id = (int) $_SESSION['aeva_mdl']['album'];
	elseif ($context['aeva_act'] == 'quickmod' && !empty($_REQUEST['in']))
		$id = (int) $_REQUEST['in'];
	elseif (in_array($context['aeva_act'], array('album', 'mass')));
	elseif ($context['aeva_act'] == 'mya' && (isset($_REQUEST['sa']) && $_REQUEST['sa'] == 'edit'));
	elseif ($context['aeva_act'] == 'edit' || ($context['aeva_act'] == 'delete' && isset($_GET['type']) && $_GET['type'] == 'comment'))
		$com_filter = true;
	elseif (in_array($context['aeva_act'], array('item', 'approve', 'unapprove', 'move', 'whoratedwhat', 'comment'))
		|| ($context['aeva_act'] == 'post' && !empty($_REQUEST['in']))
		|| ($context['aeva_act'] == 'media' && isset($_REQUEST['dl']))
		|| ($context['aeva_act'] == 'delete' && (!isset($_GET['type']) || $_GET['type'] != 'comment')))
		$item_filter = true;
	elseif ($context['aeva_act'] == 'report')
	{
		$item_filter = $_GET['type'] != 'comment';
		$com_filter = $_GET['type'] == 'comment';
	}
	else
		return false;

	$id = isset($id) ? $id : (isset($_REQUEST['in']) ? (int) $_REQUEST['in'] : 0);

	$context['aeva_album'] = array();
	$item_filter = !isset($item_filter) ? false : $item_filter;
	$com_filter = !isset($com_filter) ? false : $com_filter;

	// Let's get the album
	$request = $amFunc['db_query']('
		SELECT
			a.id_album, a.name, a.description, a.album_of, mem.realName AS member_name, a.featured, a.parent, a.num_items, a.child_level, a.directory, a.options, a.a_order, a.approved,
			a.icon, f.directory AS icon_dir, f.filename AS icon_file, f.filesize, f.width, f.height, bf.width AS bwidth, bf.height AS bheight, bf.id_file AS bigicon,
			a.id_perm_profile, a.id_quota_profile, a.access, a.access_write, a.allowed_members, a.allowed_write, a.denied_members, a.denied_write, a.passwd, a.hidden, a.master
		FROM {db_prefix}' . ($item_filter ? 'aeva_media AS m' : ($com_filter ? 'aeva_comments AS c' : 'aeva_albums AS a')) . ($item_filter ? '
			INNER JOIN {db_prefix}aeva_albums AS a ON (m.album_id = a.id_album)' : ($com_filter ? '
			INNER JOIN {db_prefix}aeva_albums AS a ON (c.id_album = a.id_album)' : '')) . '
			LEFT JOIN {db_prefix}aeva_files AS f ON (f.id_file = a.icon)
			LEFT JOIN {db_prefix}aeva_files AS bf ON (bf.id_file = IF(a.bigicon = 0, a.icon, a.bigicon))
			LEFT JOIN {db_prefix}members AS mem ON (mem.id_member = a.album_of)
		WHERE ' . ($item_filter ? 'm.id_media' : ($com_filter ? 'c.id_comment' : 'a.id_album')) . ' = {int:id}',
		array('id' => $id),__FILE__,__LINE__
	);
	if ($amFunc['db_num_rows']($request) == 0)
		fatal_lang_error('aeva_album_not_found', !empty($amSettings['log_access_errors']));
	$album_info = $amFunc['db_fetch_assoc']($request);
	$amFunc['db_free_result']($request);

	// Password being sent?
	if (isset($_POST['album_passwd']) && !in_array($album_info['id_album'], $_SESSION['aeva_access']))
		if (in_array($album_info['passwd'], array($_POST['album_passwd'], sha1(strtolower($album_info['name']) . $_POST['album_passwd']))))
			$_SESSION['aeva_access'][] = $album_info['id_album'];

	// Access....Accesss.......Accesssssssssssssszzzzzzzzzzzzzzzzzzzzzzzzzzzzzz
	$album_allowed = allowedToAccessAlbum($album_info['id_album'], $album_info);
	if ($album_allowed !== true)
	{
		if ($album_allowed == 'passwd')
		{
			$context['sub_template'] = 'aeva_form';
			$context['aeva_form_url'] = $galurl.'sa=album;in=' . $album_info['id_album'];
			$context['aeva_form_headers'] = array(
				array($txt['aeva_passwd_protected']),
			);
			$context['aeva_form'] = array(
				'passwd' => array(
					'label' => $txt['aeva_admin_passwd'],
					'fieldname' => 'album_passwd',
					'type' => 'passwd',
				),
			);
			obExit();
		}
		elseif ($album_allowed == false)
			fatal_lang_error('aeva_album_denied', !empty($amSettings['log_access_errors']));
	}

	// Permissions
	$request = $amFunc['db_query']('
		SELECT permission
		FROM {db_prefix}aeva_perms
		WHERE id_group IN ({array_int:groups})
			AND id_profile = {int:profile}',
		array(
			'groups' => $user_info['groups'],
			'profile' => $album_info['id_perm_profile'],
		),__FILE__,__LINE__
	);
	$permissions = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
		if (in_array($row['permission'], $context['aeva_album_permissions']))
			$permissions[] = $row['permission'];
	$amFunc['db_free_result']($request);

	$can_upload = in_array($user_info['id'], explode(',', $album_info['allowed_write'])) || count(array_intersect($user_info['groups'], explode(',', $album_info['access_write']))) > 0;
	$can_upload &= !in_array($user_info['id'], explode(',', $album_info['denied_write']));

	$clearurl = $amSettings['data_dir_url'];
	$icon_url = !empty($album_info['icon_dir']) && !empty($amSettings['clear_thumbnames']) ?
		$clearurl . '/' . str_replace('%2F', '/', urlencode($album_info['icon_dir'])) . '/' . aeva_getEncryptedFilename($album_info['icon_file'], $album_info['icon'], true)
		: $galurl . 'sa=media;in=' . $album_info['id_album'] . ';icon';

	$bw = $album_info['bwidth'];
	$bh = $album_info['bheight'];
	$mw = !empty($amSettings['max_bigicon_width']) ? $amSettings['max_bigicon_width'] : 200;
	$mh = !empty($amSettings['max_bigicon_height']) ? $amSettings['max_bigicon_height'] : 200;

	// Let's put the album info in a proper array...
	$context['aeva_album'] = array(
		'id' => $album_info['id_album'],
		'name' => $album_info['name'],
		'description' => empty($album_info['description']) ? '' : $amFunc['parse_bbc']($album_info['description']),
		'owner' => array(
			'id' => $album_info['album_of'],
			'name' => empty($album_info['album_of']) ? $txt['aeva_user_deleted'] : $album_info['member_name'],
		),
		'icon' => array(
			'id' => $album_info['icon'],
			'size' => round($album_info['filesize'] / 1024, 3),
			'width' => $album_info['width'],
			'height' => $album_info['height'],
			'url' => $album_info['icon'] > 0 ? $icon_url : '',
			'src' => $album_info['icon'] > 0 ? '<div class="aea" style="width: ' . $album_info['width'] . 'px; height: ' . $album_info['height'] . 'px; background: url(' . $icon_url . ')"><a href="'.$scripturl.'?action=media;sa=album;in='.$album_info['id_album'].'">&nbsp;</a></div>' : '',
		),
		'bigicon' => $bw <= $mw && $bh <= $mh ? array($bw, $bh) : (round($mw * $bh / $bw) <= $mh ? array($mw, round($mw * $bh / $bw)) : array(round($mh * $bw / $bh), $mh)),
		'bigicon_resized' => $bw > $mw || $bh > $mh,
		'sub_albums' => array(),
		'parent' => $album_info['parent'],
		'master' => $album_info['master'],
		'featured' => $album_info['featured'],
		'num_items' => $album_info['num_items'],
		'child_level' => $album_info['child_level'],
		'directory' => $album_info['directory'],
		'approved' => $album_info['approved'],
		'order' => $album_info['a_order'],
		'overall_total' => 0,
		'passwd' => $album_info['passwd'],
		'permissions' => $permissions,
		'can_upload' => aeva_allowedTo('moderate') || $album_info['album_of'] == $user_info['id'] || $can_upload,
		'id_quota_prof' => $album_info['id_quota_profile'],
		'hidden' => $album_info['hidden'],
		'options' => unserialize($album_info['options']),
	);

	// Tidy up...
	unset($permissions, $album_info);
}

function aeva_getQuickAlbums($custom = '', $field = 'id_album')
{
	global $amFunc;

	$raw_albums = array();
	$request = $amFunc['db_query']('SELECT a.' . $field . ' FROM {db_prefix}aeva_albums AS a WHERE {raw:custom}', array('custom' => $custom),__FILE__,__LINE__);
	while ($row = $amFunc['db_fetch_row']($request))
		$raw_albums[] = $row[0];
	$amFunc['db_free_result']($request);
	return $raw_albums;
}

function aeva_getAlbums($custom = '', $security_level = 2, $approved = true, $order = true, $limit = '', $separate_children = false, $need_desc = false, $need_icon = false)
{
	// This function loads all the data of every album out there
	global $amFunc, $context, $galurl, $user_info, $albums, $boardurl, $boarddir, $amSettings, $scripturl, $txt;

	if ($order === true)
		$order = 'a.child_level, a.a_order';
	$albums = $raw_albums = array();
	// We'll need to apply the hidden treatment to sub-albums that didn't go through it already.
	$can_moderate = aeva_allowedTo('moderate');
	$temp_hidden = $can_moderate ? '' : ($user_info['is_guest'] ? ' AND (a.hidden = 0)' : ' AND (a.hidden = 0 OR a.album_of = ' . (int) $user_info['id'] . ')');

	// Gets the album tree
	$request = $amFunc['db_query']('
		SELECT a.id_album
		FROM {db_prefix}aeva_albums AS a' . ($custom || $security_level || $approved || $separate_children ? '
		WHERE ' . ($separate_children ? 'a.child_level = 0' . ($custom || $security_level || $approved ? '
			AND ' : '') : '') . ($security_level ? ($security_level == 2 ? '{query_see_album}' : ($can_moderate ? '1=1' : '{_query_see_album}')) . ($custom || $approved ? '
			AND ' : '') : '') . ($custom ? '{raw:custom}' . ($approved ? '
			AND ' : '') : '') . ($approved ? 'a.approved = 1' : '') : '') . '
		ORDER BY {raw:order}' . ($limit ? '
		LIMIT {raw:limit}' : ''),
		array(
			'custom' => $custom,
			'order' => $order,
			'limit' => $limit,
		),__FILE__,__LINE__);
	while ($row = $amFunc['db_fetch_assoc']($request))
		$raw_albums[] = $row['id_album'];
	$amFunc['db_free_result']($request);

	$context['aeva_albums'] = array();
	$context['aeva_album_list'] = array();

	if (empty($raw_albums))
		return;

	// Grab them...
	$request = $amFunc['db_query']('
		SELECT
			a.id_album, a.name, ' . ($need_desc ? 'a.description, ' : '') . 'a.album_of, mem.realName AS member_name, a.featured, a.parent, a.master, a.access,
			a.num_items, a.child_level, a.approved, a.directory, a.a_order, a.passwd, a.hidden' . ($need_icon ? ', a.icon,
			f.filesize, f.width, f.height, f.filename AS icon_file, f.directory AS icon_dir' : '') . '
		FROM {db_prefix}aeva_albums AS a' . ($need_icon ? '
			LEFT JOIN {db_prefix}aeva_files AS f ON (f.id_file = a.icon)' : '') . '
			LEFT JOIN {db_prefix}members AS mem ON (mem.id_member = a.album_of)
		WHERE a.id_album IN ({array_int:albums})' . ($separate_children ? '
			OR (a.parent IN ({array_int:albums})' . $temp_hidden . ')' : '') . '
		ORDER BY {raw:order}',
		array(
			'albums' => $raw_albums,
			'order' => $order,
		),__FILE__,__LINE__);

	$clearurl = $amSettings['data_dir_url'];
	$cols = isset($amSettings['album_columns']) ? max(1, (int) $amSettings['album_columns']) : 1;
	$num_rows = $amFunc['db_num_rows']($request);

	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$desc = $need_desc && ($need_desc === true || $num_rows <= $need_desc) ? aeva_cutString($row['description'], ceil(500/$cols), true, ceil(80/$cols), true, true) : '';
		$icon_url = $need_icon ? (!empty($row['icon_dir']) && !empty($amSettings['clear_thumbnames']) ?
			$clearurl . '/' . str_replace('%2F', '/', urlencode($row['icon_dir'])) . '/' . aeva_getEncryptedFilename($row['icon_file'], $row['icon'], true)
			: $galurl . 'sa=media;in=' . $row['id_album'] . ';icon') : '';
		$albums[$row['id_album']] = array(
			'id' => $row['id_album'],
			'name' => $row['name'],
			'description' => $desc,
			'owner' => array(
				'id' => $row['album_of'],
				'name' => empty($row['album_of']) ? $txt['aeva_user_deleted'] : $row['member_name'],
			),
			'sub_albums' => array(),
			'parent' => $row['parent'],
			'master' => $row['master'],
			'featured' => $row['featured'],
			'num_items' => $row['num_items'],
			'child_level' => $row['child_level'],
			'directory' => $row['directory'],
			'approved' => $row['approved'],
			'order' => $row['a_order'],
			'overall_total' => 0,
			'passwd' => $row['passwd'],
			'hidden' => $row['hidden'],
		);
		if ($need_icon)
			$albums[$row['id_album']]['icon'] = array(
				'id' => $row['icon'],
				'size' => round($row['filesize'] / 1024, 3),
				'width' => $row['width'],
				'height' => $row['height'],
				'url' => $row['icon'] > 0 ? $icon_url : '',
				'src' => $row['icon'] > 0 ? ($row['width'] > 0 ? '<div class="aea" style="width: ' . $row['width'] . 'px; height: ' . $row['height'] . 'px; background: url(' . $icon_url . ')"><a href="'.$scripturl.'?action=media;sa=album;in='.$row['id_album'].'">&nbsp;</a></div>' :
																 '<a href="' . $scripturl . '?action=media;sa=album;in=' . $row['id_album'] . '"><img alt="" src="'.$icon_url.'" border="0" /></a>') : '',
			);
	}
	$amFunc['db_free_result']($request);

	foreach ($albums as $i => $a)
	{
		// Set the tree up
		if (!empty($albums[$a['parent']]))
		{
			if ($separate_children)
				$albums[$a['parent']]['sub_albums'][$i] = $albums[$i];
			else
				$albums[$a['parent']]['sub_albums'][$i] = &$albums[$i];

			// If there is a child-level problem, we fix it!
			if (isset($albums[$a['parent']]['child_level']) && $a['child_level'] != $albums[$a['parent']]['child_level'] + 1)
				$amFunc['db_query']('
					UPDATE {db_prefix}aeva_albums
					SET child_level = {int:level}
					WHERE id_album = {int:album}',
					array(
						'level' => $albums[$a['parent']]['child_level'] + 1,
						'album' => $i,
					),
					__FILE__,__LINE__
				);

			if ($separate_children)
				unset($albums[$i]);
		}
	}

	// Build the album list
	$album_list = array();
	foreach ($albums as $tree)
		if (empty($tree['parent']))
			aeva_recursiveAlbums($album_list, $tree);

	foreach ($albums as $id => $dat)
		aeva_getOverallTotal($albums[$id], $dat);

	// Assign them to the global space
	$context['aeva_albums'] = &$albums;
	$context['aeva_album_list'] = &$album_list;
}

// Gets album list
function aeva_recursiveAlbums(&$_list, &$_tree)
{
	$_list[] = $_tree['id'];

	foreach ($_tree['sub_albums'] as $id => $tree)
		aeva_recursiveAlbums($_list, $tree);
}

// Gets overall total # of items
function aeva_getOverallTotal(&$_album, &$_dat)
{
	if (!isset($_album['overall_total'], $_dat['num_items']))
		return;

	foreach ($_dat['sub_albums'] as $id => $album)
		aeva_getOverallTotal($_album, $album);

	$_album['overall_total'] += $_dat['num_items'];
}

function aeva_approveItems($items, $approval)
{
	global $user_info;

	foreach ($items as $item => $title)
	{
		$options = array(
			'id' => $item,
			'approved' => $approval,
			'skip_log' => true,
		);

		// Update item
		aeva_modifyItem($options);

		// Log item approval/unapproval
		$opts = array(
			'type' => 'approval',
			'subtype' => empty($approval) ? 'unapproved' : 'approved',
			'action_on' => array(
				'id' => $item,
				'name' => $title,
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
	}
}

function aeva_deleteItems($id, $rmFiles = true, $log = true)
{
	// Deletes a single item or multiple items
	global $amFunc, $amSettings, $user_info;

	$id = is_array($id) ? $id : array($id);

	// Start by assigning some variables
	$deleted = array();
	$deleted['items'] = 0;
	$deleted['comments'] = 0;
	$deleted['files'] = 0;

	// We cannot do anything if it is empty
	if (empty($id))
		return $deleted;

	// Let's get what we actually have to delete
	$ids = array();
	$files_to_delete = array();
	$album_counter = array();
	$mem_counter = array();

	$request = $amFunc['db_query']('
		SELECT id_media, id_file, id_thumb, id_preview, album_id, id_member, title, approved
		FROM {db_prefix}aeva_media
		WHERE id_media IN ({array_int:ids})',
		array('ids' => $id),__FILE__,__LINE__);

	$num_approved = $num_unapproved = 0;
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$ids[] = $row['id_media'];
		if ($row['approved'])
			$num_approved++;
		else
			$num_unapproved++;

		if (!isset($album_counter[$row['album_id']]))
			$album_counter[$row['album_id']] = 0;
		if (!isset($mem_counter[$row['id_member']]))
			$mem_counter[$row['id_member']] = 0;

		if ($row['approved'])
			$album_counter[$row['album_id']]++;
		if ($row['approved'])
			$mem_counter[$row['id_member']]++;

		if ($rmFiles)
		{
			$files_to_delete[] = $row['id_file'];
			$files_to_delete[] = $row['id_thumb'];
			$files_to_delete[] = $row['id_preview'];
		}

		// Do we need to log?
		if ($log)
		{
			$opts = array(
				'type' => 'delete',
				'subtype' => 'item',
				'action_by' => array(
					'id' => $user_info['id'],
					'name' => $user_info['name'],
				),
				'action_on' => array(
					'id' => $row['id_media'],
					'name' => $row['title'],
				),
			);
			aeva_logModAction($opts);
		}
	}
	$amFunc['db_free_result']($request);

	// If it is empty, return it now
	if (empty($ids))
		return $deleted;

	// Delete the files first (we need to have the aeva_media entry available.)
	$files = aeva_deleteFiles($files_to_delete);

	// Start deleting them
	$amFunc['db_query']("DELETE FROM {db_prefix}aeva_media WHERE id_media IN ({array_int:ids})",array('ids' => $ids),__FILE__,__LINE__);

	// Update the stats
	if ($num_approved > 0)
		aeva_increaseSettings('total_items', -$num_approved);
	if ($num_unapproved > 0)
		aeva_increaseSettings('num_unapproved_items', -$num_unapproved);

	foreach ($album_counter as $id_album => $to_decrement)
		$amFunc['db_query']("UPDATE {db_prefix}aeva_albums SET num_items = num_items - {int:decrement} WHERE id_album = {int:album}",array('decrement' => $to_decrement, 'album' => $id_album),__FILE__,__LINE__);

	// Remove the comments
	$request = $amFunc['db_query']("SELECT id_comment FROM {db_prefix}aeva_comments WHERE id_media IN ({array_int:media})",array('media' => $ids),__FILE__,__LINE__);
	$c_id = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
		$c_id[] = $row['id_comment'];
	$amFunc['db_free_result']($request);
	$deleted_comments = aeva_deleteComments($c_id, false);

	// Some more stuff.....
	$amFunc['db_query']("DELETE FROM {db_prefix}aeva_variables WHERE val4 IN ({array_int:media}) AND type = {string:type}",array('media' => $ids, 'type' => 'item_report'),__FILE__,__LINE__);
	$total_deleted = $amFunc['db_affected_rows']();
	if ($total_deleted > 0)
		aeva_increaseSettings('num_reported_items', -$total_deleted);

	// Some logs
	$amFunc['db_query']("DELETE FROM {db_prefix}aeva_log_media WHERE id_media IN ({array_int:id})",array('id' => $ids),__FILE__,__LINE__);
	$amFunc['db_query']("DELETE FROM {db_prefix}aeva_log_ratings WHERE id_media IN ({array_int:id})",array('id' => $ids),__FILE__,__LINE__);
	aeva_updateWeighted();

	// Update the album's id_last_media
	$request = $amFunc['db_query']("
		SELECT MAX(id_media) AS last_media, album_id
		FROM {db_prefix}aeva_media
		WHERE album_id IN ({array_int:albums})
		GROUP BY album_id",array('albums' => array_keys($album_counter)),__FILE__,__LINE__);
	while ($row = $amFunc['db_fetch_assoc']($request))
		$amFunc['db_query']("UPDATE {db_prefix}aeva_albums SET id_last_media = {int:media} WHERE id_album = {int:album}",array('album' => $row['album_id'], 'media' => $row['last_media']),__FILE__,__LINE__);
	$amFunc['db_free_result']($request);

	// Update the member's data
	foreach ($mem_counter as $id_mem => $to_decrement)
		$amFunc['db_query']("
			UPDATE {db_prefix}members
			SET aeva_items = aeva_items - {int:to_decrement}
			WHERE ID_MEMBER = {int:mem}",array('mem' => $id_mem, 'to_decrement' => $to_decrement),__FILE__,__LINE__);

	aeva_resetUnseen();

	// Finished at last
	$deleted['items'] = count($ids);
	$deleted['comments'] = $deleted_comments;
	$deleted['files'] = $files;

	return $deleted;
}

// Removes comment(s)
function aeva_deleteComments($id, $log = true)
{
	global $amFunc, $user_info;

	// Make sure everything is fine
	$id = is_array($id) ? $id : array($id);

	// We don't need it empty
	if (empty($id))
		return 0;

	$total_deleted = array();
	$item_counter = array();
	$ids = array();
	$mem_counter = array();

	// Let's get what we have to delete
	$request = $amFunc['db_query']('
		SELECT c.id_media, c.id_comment, c.id_member, c.approved, m.title
		FROM {db_prefix}aeva_comments AS c
			LEFT JOIN {db_prefix}aeva_media AS m ON (m.id_media = c.id_media)
		WHERE id_comment IN ({array_int:comments})',
		array('comments' => $id),__FILE__,__LINE__);

	$num_approved = $num_unapproved = 0;
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$ids[] = $row['id_comment'];
		if ($row['approved'])
			$num_approved++;
		else
			$num_unapproved++;

		if (!isset($item_counter[$row['id_media']]) && $row['approved'])
			$item_counter[$row['id_media']] = 0;
		if (!isset($mem_counter[$row['id_member']]) && $row['approved'])
			$mem_counter[$row['id_member']] = 0;

		if ($row['approved'])
			$item_counter[$row['id_media']]++;
		if ($row['approved'])
			$mem_counter[$row['id_member']]++;

		// Do we need to log?
		if ($log)
		{
			$opts = array(
				'type' => 'delete',
				'subtype' => 'comment',
				'action_by' => array(
					'id' => $user_info['id'],
					'name' => $user_info['name'],
				),
				'action_on' => array(
					'id' => $row['id_comment'],
					'name' => $row['title'],
				),
				'extra' => array(
					'val8' => $row['id_media'],
				),
			);
			aeva_logModAction($opts);
		}
	}
	$amFunc['db_free_result']($request);
	if (empty($ids))
		return 0;

	// Start deleting them
	$amFunc['db_query']('
		DELETE FROM {db_prefix}aeva_comments WHERE id_comment IN ({array_int:comment})',
		array('comment' => $ids),__FILE__,__LINE__);

	// Update the stats
	aeva_increaseSettings('total_comments', -$num_approved);
	aeva_increaseSettings('num_unapproved_comments', -$num_unapproved);

	foreach ($item_counter as $id_media => $to_decrement)
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_media SET num_comments = num_comments - {int:value} WHERE id_media = {int:id}',
			array('id' => $id_media, 'value' => $to_decrement),__FILE__,__LINE__);

	$amFunc['db_query']('
		DELETE FROM {db_prefix}aeva_variables WHERE val4 IN ({array_int:media}) AND type = {string:type}',
		array('media' => $ids, 'type' => 'comment_report'),__FILE__,__LINE__);
	$total_deleted = $amFunc['db_affected_rows']();
	aeva_increaseSettings('num_reported_comments', -$total_deleted);

	// Update id_last_comment for items (the first update is needed when the final comment in an item is removed)
	$akeys = array_keys($item_counter);
	if (!empty($akeys))
	{
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_media SET id_last_comment = 0 WHERE id_media IN ({array_int:medias})',
			array('medias' => $akeys),__FILE__,__LINE__);
		$request = $amFunc['db_query']('
			SELECT MAX(id_comment) AS last_comment, id_media FROM {db_prefix}aeva_comments WHERE id_media IN ({array_int:medias}) GROUP BY id_media',
			array('medias' => $akeys),__FILE__,__LINE__);
		while ($row = $amFunc['db_fetch_assoc']($request))
			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_media SET id_last_comment = {int:comment} WHERE id_media = {int:media}',
				array('comment' => $row['last_comment'], 'media' => $row['id_media']),__FILE__,__LINE__);
		$amFunc['db_free_result']($request);
	}

	// Update member's data
	foreach ($mem_counter as $id_mem => $to_decrement)
		$amFunc['db_query']('
			UPDATE {db_prefix}members SET aeva_comments = aeva_comments - {int:to_decrement} WHERE ID_MEMBER = {int:mem}',
			array('mem' => $id_mem, 'to_decrement' => $to_decrement),__FILE__,__LINE__);

	aeva_resetUnseen();

	return count($ids);
}

// Logs a moderation action
function aeva_logModAction(&$options, $return_boolean = false)
{
	global $amFunc;

	// Type -- Val1
	$type = $options['type'];
	if (!in_array($type, array('approval', 'delete', 'report', 'prune', 'ban')))
		return false;
	// SubType Val 2
	// Like type(approval)-subtype(approved/delete), type(delete)-subtype(album/item/comment), type(report)-subtype(deleted_item/deleted_report)
	$subtype = isset($options['subtype']) ? $options['subtype'] : '';
	// Action-on-id(val3)
	$action_on_id = isset($options['action_on']['id']) ? $options['action_on']['id'] : 0;
	// Action-on-name(val4)
	$action_on_name = isset($options['action_on']['name']) ? $options['action_on']['name'] : '';
	// Action-by-id(val5)
	$action_by_id = isset($options['action_by']['id']) ? $options['action_by']['id'] : 0;
	// Action-by-name(val6)
	$action_by_name = isset($options['action_by']['name']) ? $options['action_by']['name'] : '';
	// Action time(val7)
	$action_time = isset($options['action_time']) ? $options['action_time'] : time();
	// Maybe some extra info?
	$val8 = isset($options['extra_info']['val8']) ? $options['extra_info']['val8'] : '';
	$val9 = isset($options['extra_info']['val9']) ? $options['extra_info']['val9'] : '';

	// Log it!
	$amFunc['db_insert'](
		'{db_prefix}aeva_variables',
		array('type', 'val1', 'val2', 'val3', 'val4', 'val5', 'val6', 'val7', 'val8', 'val9'),
		array('mod_log', $type, $subtype, $action_on_id, $action_on_name, $action_by_id, $action_by_name, $action_time, $val8, $val9),
		__FILE__,__LINE__
	);
	$id_log = $amFunc['db_insert_id']('{db_prefix}aeva_variables', 'id');

	// Return it.
	if ($return_boolean)
		if ($id_log > 0)
			return true;
		else
			return false;
	else
		return $id_log;
}

function aeva_createTextEditor($post_box_name, $post_box_form, $forceDisableBBC = false, $value = '')
{
	global $context, $sourcedir, $modSettings;

	if ($context['is_smf2'])
	{
		// We do it the SMF 2 style.
		require_once($sourcedir . '/Subs-Editor.php');

		$context['post_box_name'] = $post_box_name;
		$modSettings['enableSpellChecking'] = false;

		$editorOptions = array(
			'id' => $post_box_name,
			'form' => $post_box_form,
			'value' => $value,
			'width' => '95%',
			'preview_type' => 1,
			'disable_smiley_box' => $forceDisableBBC,
		);
		create_control_richedit($editorOptions);
	}
	else
	{
		require_once($sourcedir . '/Subs-Post.php');

		$context['post_box_name'] = $post_box_name;
		$context['post_form'] = $post_box_form;
		$context['post_box_value'] = $value;
		$context['show_bbc'] = !$forceDisableBBC;
	}
}

// Determines who's online action type
function aeva_getOnlineType($actions)
{
	global $amSettings, $amFunc, $txt, $user_info;

	// Checks...
	if (!is_array($actions) || !isset($actions['action']) || $actions['action'] != 'media')
		return false;

	aeva_loadLanguage('aeva_wo_home');

	// Admin area?
	if (isset($actions['area']))
		return array(allowedTo('aeva_manage') ? 'direct' : 'hidden', $txt['aeva_wo_admin']);

	// Load if not set
	if (!isset($amFunc) || empty($amFunc))
		aeva_loadSettings();

	// Uh allowed?
	if (!allowedTo('aeva_access'))
		return array('hidden');

	// Let's get their type
	$sa = isset($actions['sa']) ? $actions['sa'] : 'home';
	switch ($sa)
	{
		case 'home';
			$ret[1] = $txt['aeva_wo_home'];
			$ret[0] = 'direct';
		break;
		case 'item';
			$ret[3] = 'item';
			$ret[2] = $actions['in'];
			$ret[1] = 'item';
			$ret[0] = 'fetch';
		break;
		case 'album';
			$ret[3] = 'album';
			$ret[2] = $actions['in'];
			$ret[1] = 'album';
			$ret[0] = 'fetch';
		break;
		case 'post';
			if (isset($actions['in']))
			{
				$ret[3] = 'item';
				$ret[2] = $actions['in'];
				$ret[1] = 'edit';
				$ret[0] = 'fetch';
			}
			else
			{
				$ret[3] = 'album';
				$ret[2] = isset($actions['album']) ? $actions['album'] : 0;
				$ret[1] = 'add';
				$ret[0] = 'fetch';
			}
		break;
		case 'unseen';
			$ret[0] = allowedTo('aeva_access_unseen') ? 'direct' : 'hidden';
			$ret[1] = $txt['aeva_wo_unseen'];
		break;
		case 'comment';
			$ret[3] = 'item';
			$ret[2] = $actions['in'];
			$ret[1] = 'comment';
			$ret[0] = allowedTo('aeva_comment') ? 'fetch' : 'hidden';
		break;
		case 'report';
			$ret[3] = 'item';
			$ret[2] = $actions['in'];
			$ret[1] = 'report';
			$ret[0] = allowedTo('aeva_report_items') ? 'fetch' : 'hidden';
		break;
		case 'search';
			$ret[0] = allowedTo('aeva_search') ? 'direct' : 'hidden';
			$ret[1] = $txt['aeva_wo_search'];
		break;
		case 'stats';
			$ret[0] = 'direct';
			$ret[1] = $txt['aeva_wo_stats'];
		break;
		case 'vua';
			$ret[0] = 'direct';
			$ret[1] = $txt['aeva_wo_vua'];
		break;
		case 'mya';
			$ret[0] = !$user_info['is_guest'] ? 'direct' : 'hidden';
			$ret[1] = $txt['aeva_wo_ua'];
		break;
		default;
			$ret[0] = 'direct';
			$ret[1] = $txt['aeva_wo_unknown'];
		break;
	}

	return $ret;
}

function aeva_getFetchData($type, $data)
{
	global $amFunc, $txt;

	// We need to load it right?
	if (!isset($amFunc))
		aeva_loadSettings();
	aeva_loadLanguage('aeva_wo_home');

	if (!is_array($data))
		return false;

	// Let's see what do we need to fetch
	$fetch = array();
	foreach ($data as $d)
		$fetch[] = (int) $d['id'];

	// Empty?
	if (empty($fetch))
		return false;

	$items = array();
	switch ($type)
	{
		case 'item';
			$request = $amFunc['db_query']('
				SELECT m.id_media, m.title
				FROM {db_prefix}aeva_media AS m
					INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
				WHERE m.approved = 1
				AND {query_see_album}
				AND m.id_media IN ({array_int:item})', array('item' => $fetch), __FILE__,__LINE__);
			while ($row = $amFunc['db_fetch_assoc']($request))
				$items[$row['id_media']] = array(
					'id' => $row['id_media'],
					'title' => $row['title'],
				);
			$amFunc['db_free_result']($request);
		break;

		case 'album';
			$request = $amFunc['db_query']('
				SELECT a.id_album, a.name
				FROM {db_prefix}aeva_albums AS a
				WHERE (featured = 1 OR approved = 1)
				AND {query_see_album}
				AND id_album IN ({array_int:album})',
				array(
					'album' => $fetch,
				),__FILE__,__LINE__);
			while ($row = $amFunc['db_fetch_assoc']($request))
				$items[$row['id_album']] = array(
					'id' => $row['id_album'],
					'title' => $row['name'],
				);
			$amFunc['db_free_result']($request);
		break;

		default;
			return false;
		break;
	}

	$ret = array();
	// OK let's get'em!
	foreach ($data as $k => $v)
	{
		if (!isset($items[$v['id']]))
		{
			$ret[$k] = $txt['aeva_wo_hidden'];
			continue;
		}
		// OK then... Let's fetch the text
		$ret[$k] = sprintf($txt['aeva_wo_'.$v['type']], $items[$v['id']]['id'], trim($items[$v['id']]['title']) != '' ? $items[$v['id']]['title'] : $txt['aeva_not_available']);
	}

	// We are through
	return $ret;
}

function aeva_insertFileID($id, $filesize, $filename, $width, $height, $directory, $id_album, $exif = '')
{
	global $amFunc;

	if (empty($id))
	{
		// Insert it
		$amFunc['db_insert'](
			'{db_prefix}aeva_files',
			array('filesize', 'filename', 'width', 'height', 'directory', 'id_album', 'exif'),
			array($filesize, $filename, $width, $height, $directory, $id_album, $exif),
			__FILE__,__LINE__);

		return $amFunc['db_insert_id']('{db_prefix}aeva_files', 'id_file');
	}

	$request = $amFunc['db_query']('
		UPDATE {db_prefix}aeva_files
		SET filesize = {int:filesize}, width = {int:width}, height = {int:height}, exif = {string:exif}, filename = {string:filename}'
		. (!empty($directory) ? ', directory = {string:directory}' : '') . (!empty($id_album) ? ', id_album = {int:id_album}' : '') . '
		WHERE id_file = {int:id_file}',
		array(
			'id_file' => $id,
			'filename' => $filename,
			'filesize' => $filesize,
			'width' => $width,
			'height' => $height,
			'id_album' => $id_album,
			'directory' => $directory,
			'exif' => $exif,
		),__FILE__,__LINE__);

	return $id;
}

// Checks for maximum file size limits
function aeva_loadQuotas($pre = array())
{
	global $context, $amFunc, $amSettings, $user_info;

	// Just set it for now...
	$context['aeva_max_file_size'] = array(
		'audio' => !empty($pre) ? $pre['audio'] : $amSettings['max_file_size'],
		'video' => !empty($pre) ? $pre['video'] : $amSettings['max_file_size'],
		'image' => !empty($pre) ? $pre['image'] : $amSettings['max_file_size'],
		'doc' => !empty($pre) ? $pre['doc'] : $amSettings['max_file_size'],
	);

	// Not set?
	if (empty($context['aeva_album']['id_quota_prof']))
		return;

	// Load the profile for the group(s)
	$possible_quotas = array();
	$request = $amFunc['db_query']('
		SELECT quota AS `limit`, type
		FROM {db_prefix}aeva_quotas
		WHERE id_profile = {int:id_profile}
			AND id_group IN ({array_int:groups})',
		array(
			'id_profile' => $context['aeva_album']['id_quota_prof'],
			'groups' => $user_info['groups'],
		),__FILE__,__LINE__
	);
	if ($amFunc['db_num_rows']($request) == 0)
		return;

	while ($row = $amFunc['db_fetch_assoc']($request))
		$possible_quotas[$row['type']][] = $row['limit'];
	$amFunc['db_free_result']($request);

	// OK Get the quota one...
	foreach ($possible_quotas as $type => $limits)
		$context['aeva_max_file_size'][$type] = max($limits);
}

// Creates a file
function aeva_createFile(&$options)
{
	global $amSettings, $amFunc, $context;

	// Initialize
	$options['is_uploading'] = isset($options['is_uploading']) && $options['is_uploading'] == true ? true : false;
	$options['destination'] = isset($options['destination']) ? $options['destination'] : '';
	$options['cur_dest'] = substr($options['destination'], strlen($amSettings['data_dir_path']) + 1);
	$options['album'] = isset($options['album']) ? $options['album'] : 0;
	$options['max_width'] = isset($options['max_width']) ? $options['max_width'] : $amSettings['max_width'];
	$options['max_height'] = isset($options['max_height']) ? $options['max_height'] : $amSettings['max_height'];
	$options['allow_over_max'] = isset($options['allow_over_max']) ? $options['allow_over_max'] : $amSettings['allow_over_max'];
	$options['max_file_size'] = isset($options['max_file_size']) ? $options['max_file_size'] : (isset($context['aeva_max_file_size']) ? $context['aeva_max_file_size'] : $amSettings['max_file_size']);
	$ret = array();

	// Do some checking
	if (!isset($options['filepath']) || (($options['is_uploading'] && !is_uploaded_file($options['filepath'])) || (!$options['is_uploading'] && !file_exists($options['filepath']))))
		return array('error' => 'file_not_found', 'error_context' => array('file_not_found (' . htmlspecialchars($options['filepath']) . ')'));

	// Is the destination empty?
	if (empty($options['destination']))
		return array('error' => 'dest_empty', 'error_context' => '(folder variable is empty)');

	// Does the directory exist?
	if (!file_exists($options['destination']))
		return array('error' => 'dest_not_found', 'error_context' => array('dest_not_found (' . htmlspecialchars($options['destination']) . ')'));

	// Rename the file for now
	if ($options['is_uploading'])
	{
		@move_uploaded_file($options['filepath'], $amSettings['data_dir_path'] . '/tmp/' . $options['filename']);
		$options['filepath'] = $amSettings['data_dir_path'] . '/tmp/' . $options['filename'];
	}

	// Open the handler anyway
	$file = new aeva_media_handler;
	$file->init($options['filepath']);
	$file->securityCheck($options['filename']);

	// Width and height
	list ($width, $height) = $file->getSize();
	if (empty($width))
		$width = isset($options['width']) ? $options['width'] : 0;
	if (empty($height))
		$height = isset($options['height']) ? $options['height'] : 0;

	$exifInfo = $file->getInfo();
	if ($amSettings['use_exif_date'] && !empty($exifInfo['datetime']))
		if (preg_match('/(\d{4}).(\d{2}).(\d{2}) (\d{2}).(\d{2}).(\d{2})/', $exifInfo['datetime'], $dt) > 0 && $dt[1] != 1970)
			$ret['time'] = mktime($dt[4], $dt[5], $dt[6], $dt[2], $dt[3], $dt[1]);

	$exif = serialize($exifInfo);
	$fsize = $file->getFileSize();
	$mtype = $file->media_type();

	// If we have an array in max file sizes... We need to choose the correct one
	if (is_array($options['max_file_size']))
		$options['max_file_size'] = isset($options['max_file_size'][$mtype]) ? $options['max_file_size'][$mtype] : $amSettings['max_file_size'];

	// Do we need to make the checks?
	if (empty($options['security_override']))
	{
		// Is it of invalid extension?
		$ext = aeva_getExt($options['filename']);
		if (!in_array($ext, aeva_allowed_types(true)))
			return array('error' => 'invalid_extension', 'error_context' => array(htmlspecialchars($ext)));
		elseif (empty($options['allow_over_max']))
		{
			// Is the size too large?
			if ($fsize > $options['max_file_size'] * 1024)
				return array('error' => 'size_too_big', 'error_context' => array(round($fsize/1024)));
			// Are the width or height too large?
			if ($width > $options['max_width'])
				return array('error' => 'width_bigger', 'error_context' => array((int) $width));
			if ($height > $options['max_height'])
				return array('error' => 'height_bigger', 'error_context' => array((int) $height));
		}
	}

	if ((empty($options['security_override']) && !empty($options['allow_over_max']))
	&& (($fsize > $options['max_file_size'] * 1024) || ($width > $options['max_width']) || ($height > $options['max_height'])))
	{
		// If the picture is too large, resize it. If the file itself is too large, try to create a lighter file with the same dimensions.
		// Does not apply if you're converting from an older gallery.
		$resizeddest = $amSettings['data_dir_path'] . '/tmp/resized_' . $options['filename'];
		if ($resizedpic = $file->createThumbnail($resizeddest, min($width, $options['max_width']), min($height, $options['max_height'])))
		{
			if (!isset($options['skip_preview_unlink']))
				@unlink($options['filepath']);
			$options['filepath'] = $resizeddest;
			list ($width, $height) = $resizedpic->getSize();
			if (empty($width))
				$width = isset($options['width']) ? $options['width'] : 0;
			if (empty($height))
				$height = isset($options['height']) ? $options['height'] : 0;
			$fsize = $resizedpic->getFileSize();
			$resizedpic->close();
			// Is the new picture still too large? Well, we did what we could!
			if ($fsize > $options['max_file_size'] * 1024)
				return array('error' => 'size_too_big', 'error_context' => array((int) $fsize));
		}
	}

	// Close it.
	$file->close();

	// Done with security checks, now on with creating the file
	$ret['file'] = $id_file = aeva_insertFileID(
		isset($options['force_id_file']) ? $options['force_id_file'] : 0, $fsize, $options['filename'],
		$width, $height, $options['cur_dest'], $options['album'], $exif
	);

	// Move the file
	if ($options['is_uploading'])
		@rename($options['filepath'], $options['destination'] . '/' . aeva_getEncryptedFilename($options['filename'], $id_file));
	else
		@copy($options['filepath'], $options['destination'] . '/' . aeva_getEncryptedFilename($options['filename'], $id_file));

	$options['new_dest'] = $options['destination'] . '/' . aeva_getEncryptedFilename($options['filename'], $id_file);

	// Re-open it
	$file = new aeva_media_handler;
	$file->init($options['new_dest']);

	// Do we need to create a thumbnail?
	if (empty($options['skip_thumb']))
		$ret['thumb'] = aeva_createThumbFile($id_file, $file, $options);

	// Do we have to create a preview?
	if (empty($options['skip_preview']) && (($mtype == 'video' && $file->testFFMpeg()) || (!empty($amSettings['max_preview_width']) && !empty($amSettings['max_preview_height']))))
		$ret['preview'] = aeva_createPreviewFile($id_file, $file, $options, $width, $height);

	// Close the handler
	$file->close();

	// Return
	return $ret;
}

function aeva_createThumbFile($id_file, $file, &$options)
{
	global $amSettings;

	$options['max_thumb_width'] = isset($options['max_thumb_width']) ? $options['max_thumb_width'] : $amSettings['max_thumb_width'];
	$options['max_thumb_height'] = isset($options['max_thumb_height']) ? $options['max_thumb_height'] : $amSettings['max_thumb_height'];
	$options['cur_dest'] = substr($options['destination'], strlen($amSettings['data_dir_path']) + 1);

	$mtype = $file->media_type();
	$ext = aeva_getExt($file->src);
	$ext = $ext == 'gif' || $ext == 'png' ? 'png' : 'jpg';
	$thumb = $file->createThumbnail($amSettings['data_dir_path'] . '/tmp/tmp_thumb_' . $id_file . '.' . $ext, $options['max_thumb_width'], $options['max_thumb_height']);
	if (!$thumb)
	{
		if ($mtype != 'doc')
			return $mtype == 'image' ? 3 : ($mtype == 'video' ? 2 : 1);
		$ext = 'png';
		$ext2 = !empty($options['filename']) ? strtolower(substr(strrchr($options['filename'], '.'), 1)) : '';
		$allowed_types = aeva_allowed_types(false, true);
		if (in_array($ext2, $allowed_types['do']))
		{
			$path = $amSettings['data_dir_path'] . '/generic_images/';
			$filename = (!file_exists($path . $ext2 . '.png') ? 'default' : $ext2) . '.png';
			$file2 = new aeva_media_handler;
			$file2->init($path . $filename);
			$thumb = $file2->createThumbnail($amSettings['data_dir_path'] . '/tmp/tmp_thumb_' . $id_file . '.png', $options['max_thumb_width'], $options['max_thumb_height']);
			$file2->close();
			if (!$thumb)
				return 3;
			$options['filename'] = $id_file . '_' . $ext2 . '.png';
		}
	}

	list ($twidth, $theight) = $thumb->getSize();
	if (empty($twidth))
		$twidth = $options['max_thumb_width'];
	if (empty($theight))
		$theight = $options['max_thumb_height'];

	$new_filename = 'thumb_' . preg_replace('~^preview_~', '', $options['filename']) . ($mtype == 'video' ? '.jpg' : ($ext == 'png' ? '.png' : ''));
	$id_thumb = aeva_insertFileID(
		isset($options['force_id_thumb']) && $options['force_id_thumb'] > 4 ? $options['force_id_thumb'] : 0, $thumb->getFileSize(),
		$new_filename, $twidth, $theight, $options['cur_dest'], $options['album']
	);

	// Move the file
	rename($amSettings['data_dir_path'] . '/tmp/tmp_thumb_' . $id_file . '.' . $ext, $options['destination'] . '/' . aeva_getEncryptedFilename($new_filename, $id_thumb, true));
	$thumb->close();

	return $id_thumb;
}

function aeva_createPreviewFile($id_file, $file, &$options, $width, $height)
{
	global $amSettings;

	$options['max_preview_width'] = isset($options['max_preview_width']) ? $options['max_preview_width'] : $amSettings['max_preview_width'];
	$options['max_preview_height'] = isset($options['max_preview_height']) ? $options['max_preview_height'] : $amSettings['max_preview_height'];
	$options['cur_dest'] = substr($options['destination'], strlen($amSettings['data_dir_path']) + 1);

	$mtype = $file->media_type();
	if ($mtype != 'video' && $width <= $options['max_preview_width'] && $height <= $options['max_preview_height'])
		return 0;

	$ext = aeva_getExt($file->src);
	$ext = $ext == 'gif' || $ext == 'png' ? 'png' : 'jpg';
	$preview = $file->createThumbnail($amSettings['data_dir_path'] . '/tmp/tmp_preview_' . $id_file . '.' . $ext, $options['max_preview_width'], $options['max_preview_height']);
	if (!$preview)
		return 0;

	list ($pwidth, $pheight) = $preview->getSize();
	if (empty($pwidth))
		$pwidth = $options['max_preview_width'];
	if (empty($pheight))
		$pheight = $options['max_preview_height'];

	$new_filename = 'preview_' . $options['filename'] . ($mtype == 'video' ? '.jpg' : '');
	$id_preview = aeva_insertFileID(
		isset($options['force_id_preview']) ? $options['force_id_preview'] : 0, $preview->getFileSize(),
		$new_filename, $pwidth, $pheight, $options['cur_dest'], $options['album']
	);

	// Move the file
	@rename($amSettings['data_dir_path'] . '/tmp/tmp_preview_' . $id_file . '.' . $ext, $options['destination'] . '/' . aeva_getEncryptedFilename($new_filename, $id_preview));
	$preview->close();

	return $id_preview;
}

// Delete a file
function aeva_deleteFiles($id_file, $keep_id = false)
{
	global $amFunc, $amSettings;

	// Do some checks
	if (empty($id_file) || (is_array($id_file) ? max($id_file) : $id_file) < 5)
		return false;
	if (!is_array($id_file))
		$id_file = array($id_file);

	// Fetch the item list, but remove thumbs if they're being used as album icons.
	$request = $amFunc['db_query']('
		SELECT f.id_file, f.directory, f.filename, a.icon, a.bigicon, i.id_file > 0 AS is_thumb
		FROM {db_prefix}aeva_files AS f
			LEFT JOIN {db_prefix}aeva_albums AS a ON (f.id_file = a.icon OR f.id_file = a.bigicon)
			LEFT JOIN {db_prefix}aeva_media AS i ON (f.id_file = i.id_thumb)
		WHERE f.id_file IN ({array_int:id_file})',
		array(
			'id_file' => $id_file,
		),__FILE__,__LINE__);
	$files = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
		if (empty($row['icon']) && empty($row['bigicon']) && $row['id_file'] > 4)
			$files[] = array(
				'id' => $row['id_file'],
				'filepath' => $amSettings['data_dir_path'] . '/' . $row['directory'] . '/' . aeva_getEncryptedFilename($row['filename'], $row['id_file'], (bool) $row['is_thumb']),
			);
	$amFunc['db_free_result']($request);

	if (empty($files))
		return false;

	// Delete them
	foreach ($files as $file)
	{
		// First the DB entry
		if (!$keep_id)
			$amFunc['db_query']('
				DELETE FROM {db_prefix}aeva_files WHERE id_file = {int:file}',
				array('file' => $file['id']), __FILE__, __LINE__);

		// Delete the file itself
		@unlink($file['filepath']);
	}

	// End it
	return count($files);
}

// Create an item
function aeva_createItem($options)
{
	global $amFunc, $amSettings, $user_info;

	// Do some checking
	if (!isset($options['title']))			$options['title'] = '';
	if (!isset($options['description']))	$options['description'] = '';
	if (!isset($options['id_file']))		$options['id_file'] = 0;
	if (!isset($options['id_member']))		$options['id_member'] = $user_info['id'];
	if (!isset($options['embed_url']))		$options['embed_url'] = '';
	if (!isset($options['id_thumb']))		$options['id_thumb'] = 0;
	if (!isset($options['id_preview']))		$options['id_preview'] = 0;
	if (!isset($options['album']))			$options['album'] = 0;
	if (!isset($options['keywords']))		$options['keywords'] = '';
	if (!isset($options['approved']))		$options['approved'] = 1;
	if (!isset($options['mem_name']))		$options['mem_name'] = '';
	if (empty($options['time']))			$options['time'] = time();

	// Get its type
	if (empty($options['embed_url']))
	{
		$request = $amFunc['db_query']('
			SELECT filename
			FROM {db_prefix}aeva_files
			WHERE id_file = {int:file}',
			array(
				'file' => $options['id_file'],
			),__FILE__,__LINE__);
		list ($filename) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);

		$file = new aeva_media_handler;
		$file->force_mime = $file->getMimeFromExt($filename);
		$options['type'] = $file->media_type();
		$file->close();
	}
	else
	{
		$options['type'] = 'embed';
		$options['id_thumb'] = empty($options['id_thumb']) ? 2 : $options['id_thumb'];
	}

	// Insert it
	$amFunc['db_insert'](
		'{db_prefix}aeva_media',
		array('title', 'description', 'id_file', 'id_thumb', 'id_preview', 'keywords', 'embed_url', 'type', 'album_id', 'approved', 'time_added', 'member_name', 'log_last_access_time', 'id_member', 'last_edited_name'),
		array($options['title'], $options['description'], $options['id_file'], $options['id_thumb'], $options['id_preview'], $options['keywords'], $options['embed_url'], $options['type'], $options['album'], $options['approved'], $options['time'], $options['mem_name'], time(), $options['id_member'], ''),
		__FILE__,__LINE__);
	$id_media = $amFunc['db_insert_id']('{db_prefix}aeva_media', 'id_media');

	// If approved, update album and uploader stats
	if ($options['approved'])
	{
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_albums
			SET num_items = num_items + 1, id_last_media = {int:media}
			WHERE id_album = {int:album_id}',
			array('album_id' => $options['album'], 'media' => $id_media),__FILE__,__LINE__);

		$amFunc['db_query']('
			UPDATE {db_prefix}members
			SET aeva_items = aeva_items + 1
			WHERE ID_MEMBER = {int:mem}',
			array('mem' => $options['id_member']),__FILE__,__LINE__);
	}
	aeva_increaseSettings($options['approved'] ? 'total_items' : 'num_unapproved_items');

	// Return the newly created item's ID
	return $id_media;
}

// Modify an item
function aeva_modifyItem($options)
{
	global $amFunc, $amSettings;

	$update = array();
	$params = array();
	if (isset($options['title']))
	{
		$update[] = 'title = {string:title}';
		$params['title'] = $options['title'];
	}
	if (isset($options['description']))
	{
		$update[] = 'description = {string:desc}';
		$params['desc'] = $options['description'];
	}
	if (isset($options['id_file']))
	{
		$update[] = 'id_file = {int:id_file}';
		$params['id_file'] = (int) $options['id_file'];
		$update[] = 'type = {string:type}';

		// Get the new type
		if (empty($options['embed_url']))
		{
			$request = $amFunc['db_query']('
				SELECT filename
				FROM {db_prefix}aeva_files
				WHERE id_file = {int:file}',
				array(
					'file' => $options['id_file'],
				),__FILE__,__LINE__);
			list ($filename) = $amFunc['db_fetch_row']($request);
			$amFunc['db_free_result']($request);

			$file = new aeva_media_handler;
			$file->force_mime = $file->getMimeFromExt($filename);
			$params['type'] = $file->media_type();
			$file->close();
		}
		else
			$params['type'] = 'embed';
	}
	if (isset($options['id_thumb']))
	{
		$update[] = 'id_thumb = {int:id_thumb}';
		$params['id_thumb'] = (int) $options['id_thumb'];
	}
	if (isset($options['id_preview']))
	{
		$update[] = 'id_preview = {int:id_preview}';
		$params['id_preview'] = (int) $options['id_preview'];
	}
	if (isset($options['keywords']))
	{
		$update[] = 'keywords = {string:keywords}';
		$params['keywords'] = $options['keywords'];
	}
	if (isset($options['embed_url']))
	{
		$update[] = 'embed_url = {string:embed_url}';
		$params['embed_url'] = $options['embed_url'];
	}

	// Last updated
	if (!isset($options['skip_log']))
	{
		$update[] = 'last_edited = {int:time}';
		$update[] = 'last_edited_by = {int:id_mem}';
		$update[] = 'last_edited_name = {string:mem_name}';
		$update[] = 'log_last_access_time = {int:time}';
		$params['time'] = time();
		$params['id_mem'] = $options['id_member'];
		$params['mem_name'] = $options['mem_name'];

		aeva_resetUnseen();
	}

	// Approved
	if (isset($options['approved']))
	{
		// Load some data for stats
		$request = $amFunc['db_query']('
			SELECT a.id_last_media, a.id_album, m.approved
			FROM {db_prefix}aeva_media AS m
				INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
			WHERE m.id_media = {int:media}',
			array(
				'media' => (int) $options['id'],
			),__FILE__,__LINE__);
		list ($id_last_media, $id_album, $previous_approved) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);

		// Are we really going to change the approved flag?
		if ($options['approved'] != $previous_approved)
		{
			$update[] = 'approved = {int:approved}';
			$params['approved'] = $options['approved'];

			// Handle the id_last_media
			if ($options['approved'] && $id_last_media < $options['id'])
				$new_id_last_media = $options['id'];
			elseif (!$options['approved'] && $id_last_media == $options['id'])
			{
				$request = $amFunc['db_query']('
					SELECT MAX(id_media)
					FROM {db_prefix}aeva_media
					WHERE album_id = {int:album}
					AND approved = 1',
					array(
						'album' => $id_album,
					),__FILE__,__LINE__);
				list ($new_id_last_media) = $amFunc['db_fetch_row']($request);
				$amFunc['db_free_result']($request);
			}

			// Update the album data
			$amFunc['db_query']('
				UPDATE {db_prefix}aeva_albums
				SET num_items = num_items '.(empty($options['approved']) ? '-' : '+').' 1'.(isset($new_id_last_media) ? ', id_last_media = {int:media}' : '').'
				WHERE id_album = {int:album}',
				array(
					'album' => $id_album,
					'media' => isset($new_id_last_media) ? $new_id_last_media : 0,
				),__FILE__,__LINE__);

			// Update the settings
			aeva_increaseSettings(empty($options['approved']) ? 'num_unapproved_items' : 'total_items');
			aeva_increaseSettings(empty($options['approved']) ? 'total_items' : 'num_unapproved_items', -1);
		}
	}

	// Do it!
	if (!empty($update))
	{
		$params['media'] = $options['id'];
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_media
			SET '.implode(',', $update).'
			WHERE id_media = {int:media}',
			$params,__FILE__,__LINE__);
	}

	return true;
}

// Empties the tmp folder
function aeva_emptyTmpFolder()
{
	global $amSettings;

	$dir = @opendir($amSettings['data_dir_path'] . '/tmp');
	while ($f = @readdir($dir))
		if ($f != '.' && $f != '..' && $f != 'index.php')
			@unlink($amSettings['data_dir_path'] . '/tmp/' . $f);
	@closedir($dir);

	return true;
}

function aeva_timeformat($log_time)
{
	global $user_info, $txt, $modSettings, $amFunc;

	aeva_loadLanguage('aeva_short_date_format');
	$str = $txt['aeva_short_date_format'];

	$time = $log_time + ($user_info['time_offset'] + $modSettings['time_offset']) * 3600;

	if ($log_time < 0)
		$log_time = 0;

	if ($modSettings['todayMod'] >= 1)
	{
		$nowtime = forum_time();

		$then = @getdate($time);
		$now = @getdate($nowtime);

		if ($then['yday'] == $now['yday'] && $then['year'] == $now['year'])
			return $txt['aeva_today'];

		if ($modSettings['todayMod'] == '2' && (($then['yday'] == $now['yday'] - 1 && $then['year'] == $now['year']) || ($now['yday'] == 0 && $then['year'] == $now['year'] - 1) && $then['mon'] == 12 && $then['mday'] == 31))
			return $txt['aeva_yesterday'];
	}

	if (setlocale(LC_TIME, $txt['lang_locale']))
		$str = str_replace('%b', $amFunc['ucwords'](strftime('%b', $time)), $str);
	else
	{
		foreach (array('%b' => 'months_short', '%B' => 'months') as $token => $text_label)
			if (strpos($str, $token) !== false)
				$str = str_replace($token, $txt[$text_label][(int) strftime('%m', $time)], $str);
	}

	$i = strftime($str, $time);
	if (preg_match('/(^| )0([0-9] )/', $i, $dt))
		$i = str_replace($dt[0], $dt[2], $i);
	if (isset($user_info['language']) && $user_info['language'] == 'french' && $i[0] == '1' && $i[1] == ' ') // Vive la France !
		$i = '1er' . substr($i, 1);

	return is_numeric($i[0]) ? $txt['aeva_on_date'] . ' ' . $i : $i;
}

/*************************************
The functions below can be used for external integration, provided that Gallery settings are loaded (use aeva_loadSettings for that.)
Those functions return an array with the requested information. They are also used by the gallery for several purposes.
*************************************/

function aeva_protect_bbc(&$message)
{
	global $modSettings;
	if (empty($modSettings['enableBBC']) || (isset($_REQUEST) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'jseditor'))
		return;

	$protect_tags = array('code', 'html', 'php', 'noembed', 'nobbc');
	foreach ($protect_tags as $tag)
		if (stripos($message, '[' . $tag . ']') !== false)
			$message = preg_replace('~\[' . $tag . ']((?>[^[]|\[(?!/?' . $tag . '])|(?R))+?)\[/' . $tag . ']~ie',
				"'[" . $tag . "]' . str_ireplace('[smg', '&#91;smg', '$1') . '[/" . $tag . "]'", $message);
}

function aeva_parse_bbc(&$message, $id_msg = -1)
{
	global $modSettings, $context, $sourcedir;
	if ($id_msg >= 0)
		$context['aeva_id_msg'] = $id_msg;
	if (isset($context['smg_disable']) || empty($modSettings['enableBBC']) || (isset($_REQUEST) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'jseditor'))
	{
		unset($context['smg_disable']);
		return;
	}

	$context['aeva_foxy'] = file_exists($sourcedir . '/Aeva-Foxy.php');
	preg_match_all('~\[smg\s+([^]]*?(?:&quot;.+?&quot;.*?(?!&quot;))?)](?:<br />)?[\r\n]?~i', $message, $aeva_stuff);
	if (!empty($aeva_stuff))
		foreach ($aeva_stuff[1] as $id => $aeva_replace)
			$message = str_replace($aeva_stuff[0][$id], aeva_parse_bbc_each($aeva_replace), $message);
	unset($context['aeva_id_msg']);
}

function aeva_parse_bbc_each($data)
{
	global $context;
	$params = array(
		'id' => array('match' => '(\d+(?:,\d+)*)'),
		'type' => array('optional' => true, 'match' => '(normal|box|av|link|preview|full|album' . ($context['aeva_foxy'] ? '|playlist|(?:media|audio|video|photo)_album' : '') . ')'),
		'align' => array('optional' => true, 'match' => '(none|right|left|center)'),
		'width' => array('optional' => true, 'match' => '(\d+)'),
		'details' => array('optional' => true, 'match' => '(none|all|no_name|(?:name|description|playlists|votes)(?:,(?:name|description|playlists|votes))*)'),
		'caption' => array('optional' => true, 'quoted' => true),
	);
	// Admins should preparse() their strings before going through parse_bbc() on SSI pages. This hack is only meant to fix this tag's behavior.
	$q2 = '(?:' . ($q = (strpos($data, '"') !== false) ? '"' : '&quot;') . ')';
	$done = array('id' => '', 'type' => '', 'align' => '', 'width' => '', 'caption' => '');
	foreach ($params as $id => $cond)
		if (preg_match('/' . $id . '=' . (isset($cond['quoted']) ? $q2 . '?((?<=' . $q . ').+?(?=' . $q . ')|[^]\s]+)' . $q2 . '?' : $q2 . '?' . $cond['match']) . $q2 . '?/i', $data, $this_one))
			$done[$id] = $this_one[1];

	$result = aeva_showThumbnail($done);
	return !empty($result) ? $result : '[smg ' . $data . ']';
}

function aeva_showThumbnail($data)
{
	global $scripturl, $txt, $amSettings, $sourcedir, $context, $user_info;
	static $counter = 0;

	if (!isset($amSettings) || count($amSettings) < 10)
	{
		$backup = $amSettings;
		aeva_loadSettings();
		// If an external mod/hack already set a few $amSettings variables, merge them back into the full array
		if (!empty($backup))
			$amSettings = array_merge($amSettings, $backup);
	}
	if ($counter++ >= (isset($amSettings['max_thumbs_per_page']) ? $amSettings['max_thumbs_per_page'] : 100))
	{
		aeva_loadLanguage('aeva_max_thumbs_reached');
		return $txt['aeva_max_thumbs_reached'];
	}
	if (!aeva_allowedTo('access'))
	{
		aeva_loadLanguage('aeva_accessDenied');
		return '(' . $txt['aeva_accessDenied'] . ')<br />';
	}

	extract($data);
	$ids = explode(',', $id);
	$type = !empty($type) ? $type : (!empty($amSettings['default_tag_type']) ? $amSettings['default_tag_type'] : 'normal');
	$align = in_array($align, array('left', 'right', 'center')) ? $align : '';
	$width = !empty($width) ? (int) $width : 0;
	$details = !empty($details) ? explode(',', $details) : '';
	$caption = !empty($caption) ? preg_replace('/(^\&quot\;|&quot;$)/', '', $caption) : $txt['aeva_gotolink'];
	$my_width = $width > 0 ? ' width="' . $width . '"' : '';
	$css_stuff = $align == 'left' ? array('padding: 8px 16px 8px 0') : ($align == 'right' ? array('padding: 4px 0 8px 16px') : array());
	if ($width > 0)
		$css_stuff[] = 'width: ' . ($width + 12) . 'px';
	$show_bigger = in_array($type, array('normal', 'link', 'preview'));
	$show_main_div = $type != 'box' || $align != '';

	if ((int) $id <= 0)
		return '';

	$is_playlist = in_array($type, array('media_album', 'audio_album', 'video_album', 'photo_album', 'playlist'));
	$no_lightbox = empty($amSettings['use_lightbox']) || (isset($_REQUEST['action']) && $_REQUEST['action'] == '.xml') || isset($_REQUEST['xml']);

	aeva_addHeaders(false, true, !$no_lightbox);
	$box = '';

	if ($is_playlist && $context['aeva_foxy'])
	{
		require_once($sourcedir . '/Aeva-Foxy.php');
		$box = aeva_foxy_album($id, substr($type, 0, 5), $width, $details);
		$css_stuff[] = 'text-align: left; width: 100%';
	}
	elseif ($type === 'av')
	{
		$items = aeva_getMediaItems(-1, count($ids), 'm.id_media', true, array(), 'm.id_media IN (' . $id . ') AND m.type != \'image\'', 'file');
		if (!isset($items[(int) $id]))
			return $txt['aeva_tag_no_items'];
		$item = $items[(int) $id];
		$resun = false;
		if ($item['type'] == 'embed' && !empty($item['embed_url']))
		{
			require_once($sourcedir . '/Aeva-Embed.php');
			$context['aeva_mg_calling'] = true;
			foreach ($items as $item)
			{
				$box .= aeva_embed_video($item['embed_url']);
				if ($item['is_new'])
				{
					aeva_markSeen($item['id']);
					$resun = true;
				}
			}
			$context['aeva_mg_calling'] = false;
		}
		else
		{
			$file = new aeva_media_handler;
			foreach ($items as $item)
			{
				$path = $amSettings['data_dir_path'] . '/' . $item['directory'] . '/' . ($item['id_file'] > 4 ? aeva_getEncryptedFilename($item['filename'], $item['id_file']) : $item['filename']);
				$file->init($path);
				list ($ob_width, $ob_height) = $file->getSize();
				if (in_array($item['type'], array('audio', 'doc')))
					$ob_height = $item['h_thumb'];
				$context['aeva_has_preview'] = $item['has_preview'];
				$box .= aeva_embedObject($file, $id, $ob_width, $ob_height, $item['title']);
				if ($item['is_new'])
				{
					aeva_markSeen($item['id']);
					$resun = true;
				}
			}
			$file->close();
		}
		if ($resun)
			aeva_resetUnseen($user_info['id']);
		if (count($ids) == 1)
			$inside_caption = '<div class="aeva_inside_caption"><div style="float: right"><a class="aelink" href="' . $scripturl . '?action=media;sa=item;in=' . $id . '">' . $txt['aeva_gotolink'] . '</a></div>' . ($caption != $txt['aeva_gotolink'] ? $caption : '') . '</div>';
	}
	elseif ($type == 'box')
		$box = aeva_listItems(aeva_getMediaItems(-1, count($ids), 'm.id_media', true, array(), 'm.id_media IN (' . $id . ')'), false, $align == 'none' ? '' : $align, -1);
	elseif ($type == 'album')
		$box = aeva_listItems(aeva_getMediaItems(-1, !empty($amSettings['max_items_per_page']) ? $amSettings['max_items_per_page'] : 15, 'm.id_media DESC', true, array(), 'm.album_id IN (' . $id . ')'), false, $align == 'none' ? '' : $align, -1);
	else
	{
		$box = '<img alt="" src="' . $scripturl . '?action=media;sa=media;in=' . $id . ($type == 'full' && !$context['browser']['possibly_robot'] ? ';v' : ($type == 'preview' || ($width > $amSettings['max_thumb_width']) ? ';preview' : ';thumb')) . '"' . $my_width . ' class="aext" border="0" />';
		$inside_caption = $no_lightbox ? '' : '<div class="highslide-caption"><div style="float: right"><a class="aelink" href="' . $scripturl . '?action=media;sa=item;in=' . $id . '">' . $txt['aeva_gotolink'] . '</a></div>' . ($caption != $txt['aeva_gotolink'] ? $caption : '') . '</div>';
	}
	if (empty($box))
		$box = $txt['aeva_tag_no_items'];
	$caption_box = ($type != 'link' && $caption == $txt['aeva_gotolink']) ? '' : '<div class="aeva_caption">' . ($type == 'link' ? '<a class="aelink" href="' . $scripturl . '?action=media;sa=item;in=' . $id . '">' : '') . $caption . ($type == 'link' ? '</a>' : '') . '</div>';

	$data = ($show_main_div ? '<table class="aextbox"' . (!empty($align) ? ' align="' . $align . '"' : '') . (!empty($css_stuff) ? ' style="' . implode('; ', $css_stuff) . '"' : '') . '><tr><td>' : '')
		. ($show_bigger ? '<a href="' . $scripturl . '?action=media;sa=media;in=' . $id . ($type == 'preview' ? '' : ';preview') . ($amSettings['use_lightbox'] ? '" class="hs" onclick="return hs.expand(this, slideOptions);">' : '">') : '')
		. $box . ($show_bigger ? '</a>' : '') . (empty($inside_caption) ? '' : $inside_caption) . ($show_main_div && !empty($caption_box) ? '</td></tr><tr><td>' : '') . ($type === 'av' && !empty($inside_caption) ? '' : $caption_box) . ($show_main_div ? '</td></tr></table>' : '');
	return $data;
}

// Loads the custom fields, if id_media is not null, it loads the data for that item as well. If albums are given, it loads fields for those albums only...
function aeva_loadCustomFields($id_media = null, $albums = array(), $custom = '')
{
	global $amFunc;

	$albums = is_array($albums) ? $albums : array($albums);
	foreach ($albums as $k => $v)
		$albums[$k] = (int) $v;

	// Get the fields....
	$request = $amFunc['db_query']('
		SELECT cf.*' . (!is_null($id_media) ? ', cfd.value' : '') . '
		FROM {db_prefix}aeva_fields AS cf' . (is_null($id_media) ? '' : '
			LEFT JOIN {db_prefix}aeva_field_data AS cfd ON (cfd.id_media = {int:id_media} AND cfd.id_field = cf.id_field)') . (!empty($albums) ? '
		WHERE (FIND_IN_SET(' . implode(', cf.albums) OR FIND_IN_SET(', $albums) . ', cf.albums)) OR cf.albums = {string:all}' : '') . (!empty($custom) ?
			(!empty($albums) ? ' AND ' : ' WHERE ') . '{raw:custom}' : '') . '
		ORDER BY id_field DESC',
		array(
			'id_media' => $id_media,
			'all' => 'all_albums',
			'custom' => $custom,
		),__FILE__,__LINE__
	);
	$fields = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$fields[$row['id_field']] = array(
			'id' => $row['id_field'],
			'name' => $row['name'],
			'desc' => empty($row['description']) ? '' : parse_bbc($row['description']),
			'raw_desc' => $row['description'],
			'bbc' => $row['bbc'],
			'required' => $row['required'],
			'searchable' => $row['searchable'],
			'options' => trim($row['options']) != '' ? explode(',', $row['options']) : array(),
			'albums' => $row['albums'] == 'all_albums' ? 'all_albums' : explode(',', $row['albums']),
			'type' => $row['type'],
			'value' => !empty($row['value']) ? ($row['searchable'] ? aeva_getTags($row['bbc'] && !empty($row['value']) ? parse_bbc($row['value']) : $row['value']) : ($row['bbc'] && !empty($row['value']) ? parse_bbc($row['value']) : $row['value'])) : '',
			'raw_value' => !empty($row['value']) ? $row['value'] : '',
		);
	}
	$amFunc['db_free_result']($request);

	return $fields;
}

function aeva_lockedAlbum(&$pass, &$id, &$owner)
{
	global $settings, $user_info, $txt;

	$name = array('', 'locked', 'unlocked');
	$locked = empty($pass) ? 0 : ((empty($_SESSION['aeva_access']) || !in_array($id, $_SESSION['aeva_access'])) && ($owner != $user_info['id'] || $user_info['is_guest']) ? 1 : 2);
	return ' <img alt="" src="' . $settings['images_aeva'] . '/' . $name[$locked] . '.png" title="' . ($locked ? $txt['aeva_passwd_' . ($locked == 2 ? 'un' : '') . 'locked'] : '') . '" class="aevera" /> ';
}

function aeva_showSubAlbums(&$alb)
{
	global $context, $galurl, $settings, $txt, $amFunc, $amSettings;

	$ret = '';
	$co = 0;
	$cols = isset($amSettings['album_columns']) ? max(1, (int) $amSettings['album_columns']) : 1;
	$max_albums = ceil(20/$cols);

	foreach ($alb['sub_albums'] as $album)
	{
		$co++;
		// Don't show too many...
		if ($co > $max_albums)
		{
			$ret .= sprintf($txt['aeva_more_albums_left'], count($alb['sub_albums']) - $co + 1);
			break;
		}
		$ret .= (!empty($album['passwd']) ? aeva_lockedAlbum($album['passwd'], $album['id'], $album['owner']['id']) : '')
				. ' <a href="' . $galurl . 'sa=album;in=' . $album['id'] . '"' . (!$album['approved'] ? ' class="unapp"' : '') . '>' . $album['name'] . '</a>'
				. (!empty($album['num_items']) ? ' (' . $album['num_items'] . ')' : '');

		if (!empty($album['sub_albums']))
			$ret .= ' (+)';
		$ret .= ', ';
	}
	return rtrim($ret, ', ');
}

// List a specific member's album -- intended for showing in a reduced space, like a profile sidebar
function aeva_listMemberAlbums($id_member)
{
	global $amSettings, $galurl, $settings, $txt, $user_info, $context;

	aeva_getAlbums('a.album_of = ' . $id_member, 1, true, true, '', true, true, true);

	if (empty($context['aeva_albums']))
		return;

	foreach ($context['aeva_albums'] as $album)
	{
		echo '
			<div>', !empty($album['passwd']) ? aeva_lockedAlbum($album['passwd'], $album['id'], $album['owner']['id']) : '', '
				<a href="', $galurl, 'sa=album;in=', $album['id'], '">', $album['name'], '</a> (', $album['num_items'], $album['hidden'] ? ' - ' . $txt['aeva_unbrowsable'] : '', ')
			</div>';
		if (!empty($album['sub_albums']))
		{
			echo '
			<div class="smalltext" style="padding: 3px 3px 3px 12px; margin-top: 6px; border-top: 1px dotted #999">';
			if ($amSettings['show_sub_albums_on_index'] != 1)
				echo $txt['aeva_sub_albums'], ': ', count($album['sub_albums']);
			else
				echo aeva_showSubAlbums($album);
			echo '</div>';
		}
	}
}

// Sub-template for showing children albums
function aeva_listChildren(&$albums, $skip_table = false)
{
	global $amSettings, $galurl, $settings, $txt, $user_info, $context;

	if (empty($albums))
		return;

	if (!isset($context['aeva_windowbg']))
		$context['aeva_windowbg'] = '2';
	if (!$skip_table)
		echo '
	<div class="windowbg', $context['aeva_windowbg'] ? '' : '2', '">
		<span class="topslice"><span></span></span>
		<div style="line-height: 1.4em">
			<table width="100%" cellspacing="0" class="aelista">';

	$can_moderate = aeva_allowedTo('moderate');
	$cols = isset($amSettings['album_columns']) ? max(1, (int) $amSettings['album_columns']) : 1;
	$w45 = round(100 / $cols) - 5;
	$is_alone = $cols > 1 && count($albums) < 2;
	$count = ceil(count($albums) / $cols);
	$i = $j = -1;

	foreach ($albums as $album)
	{
		$it1 = $album['num_items'];
		$it2 = $album['overall_total'] - $it1;
		$totals = $it1 == 0 ? ($it2 == 0 ? $txt['aeva_no_items'] : $it2 . ' ' . $txt['aeva_lower_item' . ($it2 == 1 ? '' : 's')]) : $it1 . ' ' . $txt['aeva_lower_item' . ($it1 == 1 ? '' : 's')];
		$totals .= $it2 == 0 ? '' : sprintf($it1 == 0 ? $txt['aeva_items_only_in_children'] : $txt['aeva_items_also_in_children'], $it2);
		$can_moderate_here = $can_moderate || (!$user_info['is_guest'] && $user_info['id'] == $album['owner']['id']);

		$i++;
		if ($i % $cols === 0)
		{
			$context['aeva_windowbg'] = !empty($context['aeva_windowbg']) ? '' : '2';
			echo '<tr class="windowbg' . $context['aeva_windowbg'] . '">';
			$j++;
		}
		$padding = $j === 0 ? ($count == 1 ? ' style="padding: 0 8px"' : ' style="padding-top: 0"') : ($j == $count - 1 ? ' style="padding-bottom: 0"' : '');
		echo '
				<td width="5%" valign="top" align="right"', $padding, '>', $album['icon']['src'], '</td>
				<td', $i <= $cols ? ' width="' . $w45 . '%"' : '', ' valign="top"', $is_alone ? ' colspan="' . ($cols*2-1) . '"' : '', $padding, '>
					<div class="mg_large">', $can_moderate_here ? '
						<a href="' . $galurl . 'area=mya;sa=edit;in=' . $album['id'] . '"><img alt="" src="' . $settings['images_aeva'] . '/folder_edit.png" title="' . $txt['aeva_admin_edit'] . '" /></a>' : '',
						!empty($album['passwd']) ? aeva_lockedAlbum($album['passwd'], $album['id'], $album['owner']['id']) : '',
						!empty($album['featured']) ? '
						<img alt="" src="' . $settings['images_aeva'] . '/star.gif" title="' . $txt['aeva_featured_album'] . '" />' : '', '
						<a href="', $galurl, 'sa=album;in=', $album['id'], '">', $album['name'], '</a>
					</div>
					<div>', $totals, $album['hidden'] ? ' (<span class="unbrowsable">' . $txt['aeva_unbrowsable'] . '</span>)' : '', '</div>', empty($album['description']) || $album['description'] === '&hellip;' ? '' : '
					<div class="mg_desc">' . $album['description'] . '</div>';
		if (!empty($album['sub_albums']))
		{
			echo '
					<div class="smalltext" style="padding-top: 3px; margin-top: 6px; border-top: 1px dotted #999">';
			if ($amSettings['show_sub_albums_on_index'] != 1)
				echo $txt['aeva_sub_albums'], ': ', count($album['sub_albums']);
			else
				echo aeva_showSubAlbums($album);
			echo '</div>';
		}
		echo '
				</td>', $i % $cols == $cols - 1 ? '</tr>' : '';
	}

	if ($i++ % $cols != $cols - 1)
	{
		while (($i++ % $cols != 0) && !$is_alone)
			echo '<td></td><td></td>';
		echo '</tr>';
	}

	if (!$skip_table)
		echo '
			</table>
		</div>
	</div>
	<div class="windowbg', $context['aeva_windowbg'], '">
		<span class="botslice"><span></span></span>
	</div>';
}

// Sub-template for showing item lists
function aeva_listItems($items, $in_album = false, $align = '', $per_line = 0, $can_moderate = false)
{
	global $scripturl, $txt, $galurl, $settings, $context, $amSettings, $modSettings, $sourcedir, $user_info;
	static $in_page = 0;

	if (empty($items))
		return;

	aeva_addHeaders();
	$urlmore = isset($context['aeva_urlmore']) ? $context['aeva_urlmore'] : '';
	$user_is_known = !empty($context['current_action']) && $context['current_action'] == 'profile';
	$main_user = $in_album && !empty($context['aeva_album']['owner']['id']) ? (int) $context['aeva_album']['owner']['id'] : 0;
	$mtl = !empty($amSettings['max_title_length']) && is_numeric($amSettings['max_title_length']) ? $amSettings['max_title_length'] : 30;
	$icourl = '
			<img alt="" width="10" height="10" src="' . $settings['images_aeva'] . '/';
	$new_icon = '<img alt="" src="' . $settings['images_url'] . '/' . $context['user']['language'] . '/new.gif" border="0" />';
	// If we're in an external embed, we might not have all the space we would like...
	$per_line = $per_line > 0 ? $per_line : (!empty($amSettings['num_items_per_line' . ($per_line === -1 ? '_ext' : '')]) ?
				max(1, $amSettings['num_items_per_line' . ($per_line === -1 ? '_ext' : '')]) : ($per_line === -1 ? 3 : 5));
	$ico = !empty($amSettings['icons_only']);
	$first = reset($items);
	$can_moderate &= isset($_REQUEST['action']) && $_REQUEST['action'] == 'media';
	$can_moderate_here = aeva_allowedTo('moderate');
	$re = '
		<table class="pics smalltext" width="' . (count($items) == 1 ? max(120, $first['w_thumb'] + 12) . '"' : '100%" cellspacing="8"') . (!empty($align) ? ' align="' . $align . '"' : '') . '>';

	$cnt = 0;
	$ex_album_id = 0;

	foreach ($items as $i)
	{
		// If you don't want to allow item previewing via Highslide on album pages, replace the following line with: $is_image = false;
		$is_image = $i['type'] == 'image' || ($i['type'] == 'embed' && preg_match('/\.(?:jpe?g?|gif|png|bmp)/i', $i['embed_url']));
		$is_embed = !$is_image && $i['type'] == 'embed' && !empty($modSettings['aeva_enable']);
		if ($is_embed)
		{
			if (!function_exists('aeva_main'))
				include($sourcedir . '/Aeva-Embed.php');
			$match = preg_replace(array('~\[url=([^]]+)]([^[]+)\[/url]~', '~\[url]([^[]+)\[/url]~'), array('<a href="$1">$2</a>', '<a href="$1"></a>'), $i['embed_url']);
			$match = substr(strtolower($match), 0, 4) === 'http' ? '<a href="' . $match . '">Test</a>' : $match;
			$match = aeva_main($match);
			preg_match('~"(\d+)", "(\d+)"~', $match, $siz);
			if (empty($siz))
				preg_match('~width="(\d+)(?:px)?" height="(\d+)(?:px)?"~', $match, $siz);
			$is_embed = !empty($siz);
		}

		$in_page++;
		$inside_caption = !$amSettings['use_lightbox'] ? '' : ($is_image || $is_embed ? ($is_image ? '
			<div class="highslide-caption">' : ($is_embed ? '
			<div class="highslide-maincontent" style="width: ' . $siz[1] . 'px; height: ' . ($siz[2]+42) . 'px; overflow: visible !important">
				' . trim($match) : '')) . '
				<div style="float: right">' . ($i['has_preview'] ? '
					<a class="aelink hs" href="' . ($i['type'] == 'embed' ? $i['embed_url'] : $galurl . 'sa=media;in=' . $i['id']) . '" onclick="return hss(' . $in_page . ', this);">' . $txt['aeva_zoom'] . '</a> <span style="font-weight: bold; font-size: 1.2em;">&oplus;</span>' : '') . '
					<a class="aelink" href="' . $galurl . 'sa=item;in=' . $i['id'] . $urlmore . '">' . $txt['aeva_gotolink'] . '</a>' . (!empty($i['comments']) ? '
					<img alt="" src="' . $settings['images_aeva'] . '/comment.gif" /> ' . $i['comments'] : '') . '
				</div>
				' . $i['title'] . (empty($i['desc']) ? '' : '
				<div class="smalltext mg_desc">
					' . aeva_cutString($i['desc'], 300, true, 50, true, true) . '
				</div>') . '
			</div>' : '');

		if ($cnt % $per_line == 0)
			$re .= '<tr>';
		$title = empty($i['title']) ? '&hellip;' : (strlen($i['title']) < $mtl ? $i['title'] : aeva_cutString($i['title'], $mtl));
		if ($ex_album_id != $i['id_album'])
			$album_name = empty($i['album_name']) ? '&hellip;' : (strlen($i['album_name']) < $mtl ? $i['album_name'] : aeva_cutString($i['album_name'], $mtl));
		$ex_album_id = $i['id_album'];

		$check = $can_moderate && ($i['poster_id'] == $user_info['id'] || $can_moderate_here) ? '<div class="aeva_quickmod"><input type="checkbox" name="mod_item[' . $i['id'] . ']" /></div>' : '';
		$dest_link = $is_image && $i['type'] == 'embed' && !$i['has_preview'] ? $i['embed_url'] : $galurl . 'sa=' . ($is_image ? 'media' : 'item') . ';in=' . $i['id'] . ($is_image ? ';preview' : '');
		$re .= '
		<td class="windowbg' . ($i['approved'] ? '' : ' unapp') . '" align="center">' . $check . ($i['is_new'] ? '
			' . $new_icon : '') . '
			<div style="margin: auto; width: ' . ($amSettings['max_thumb_width'] + 10) . 'px"><a href="' . $galurl . 'sa=item;in=' . $i['id'] . $urlmore . '"' . ($title != $i['title'] ? ' title="'
			. preg_replace('/&amp;(#[0-9]+|[a-zA-Z]+);/', '&$1;', htmlspecialchars($i['title'])) . '"' : '') . '>' . $title . '</a></div>
			<div class="aep" style="width: ' . $i['w_thumb'] . 'px; height: ' . $i['h_thumb'] . 'px; background: url(' . $i['thumb_url'] . ') 0 0;' . (strpos($i['thumb_url'], 'generic_images') !== false ? ' box-shadow: none' : '') . '"><a href="'
			. $dest_link . '"' . (($is_image || $is_embed) && $amSettings['use_lightbox'] ?
				' id="hsm' . $in_page . '" class="hs" onclick="' . ($is_image ? 'return hs.expand(this, slideOptions)' :
				'mediaOptions[\'width\'] = ' . $siz[1] . '; return hs.htmlExpand(this, mediaOptions)') . ';"' : '')
			. '>&nbsp;</a>' . $inside_caption . '</div>';
		if ($ico) // Icons only?
			$re .= $icourl . 'graph.gif" title="' . $txt['aeva_views'] . '" />&nbsp;' . $i['views'] .
			(!empty($i['comments']) ? $icourl . 'comment.gif" title="' . $txt['aeva_comments'] . '" />&nbsp;' . $i['comments'] . (!empty($i['new_comments']) ? ' (' . $new_icon . '&nbsp;' . $i['new_comments'] . ')' : '') : '') .
			(!empty($i['new_comments']) ? '(' . $new_icon . '&nbsp;' . $i['new_comments'] . ')' : '') .
			(!empty($i['voters']) ? $icourl . 'star.gif" title="' . $txt['aeva_rating'] . '" />&nbsp;' . $i['rating'] : '') . '<br />';
		else
			$re .= $icourl . 'graph.gif" />&nbsp;' . $txt['aeva_views'] . ':&nbsp;' . $i['views'] . '<br />' .
			(!empty($i['comments']) ? $icourl . 'comment.gif" />&nbsp;' . $txt['aeva_comments'] . ':&nbsp;' . $i['comments'] . (!empty($i['new_comments']) ? ' (' . $new_icon . '&nbsp;' . $i['new_comments'] . ')' : '') . '<br />' : '') .
			(!empty($i['voters']) ? $icourl . 'star.gif" />&nbsp;' . $txt['aeva_rating'] . ':&nbsp;' . $i['rating'] . '<br />' : '');

		$re .= ($user_is_known || $main_user == $i['poster_id'] ? '' : ($ico ? $icourl . 'person.gif" title="' . $txt['aeva_posted_by'] . '" />&nbsp;' : '
			' . $txt['aeva_posted_by'] . ' ') . aeva_profile($i['poster_id'], $i['poster_name']) . '<br />') . $icourl . 'clock.gif" title="" /> ' . $i['time'] . (!$in_album ? '<br />
			' . $txt['aeva_in_album'] . ' ' . ($i['hidden_album'] ? $album_name : '<a href="' . $galurl . 'sa=album;in=' . $i['id_album'] . '">' . $album_name . '</a>') : '') . '
		</td>';
		if (++$cnt % $per_line == 0)
			$re .= '</tr>';
	}

	if ($cnt % $per_line != 0)
		$re .= '</tr>';

	return $re . '</table>';
}

function aeva_fillMediaArray($request, $all_albums = true)
{
	global $amFunc, $user_info, $amSettings, $galurl;

	$clearurl = $amSettings['data_dir_url'];
	$items = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$items[$row['id_media']] = array(
			'id_album' => $all_albums ? $row['id_album'] : 0,
			'album_name' => $all_albums ? $row['name'] : '',
			'desc' => !empty($row['description']) ? $row['description'] : 0,
			'time_added' => $row['time_added'],
			'rating' => !empty($row['rating']) ? sprintf('%01.2f', $row['rating']) : '',
			'voters' => !empty($row['voters']) ? $row['voters'] : 0,
			'id' => $row['id_media'],
			'title' => !empty($row['title']) ? $row['title'] : '&hellip;',
			'approved' => $row['approved'],
			'time' => aeva_timeformat($row['time_added']),
			'is_new' => !empty($row['is_new']) && !$user_info['is_guest'],
			'views' => isset($row['type']) && $row['type'] === 'doc' && !empty($row['downloads']) ? $row['downloads'] : $row['views'],
			'comments' => $row['num_comments'],
			'poster_id' => $row['id_member'],
			'poster_name' => empty($row['real_name']) ? $row['member_name'] : $row['real_name'],
			'posted_on' => timeformat($row['time_added']),
			'w_thumb' => $row['width'],
			'h_thumb' => isset($row['type']) && ($row['type'] === 'audio' || $row['type'] === 'doc') ? $row['thumb_height'] : $row['height'],
			'hidden_album' => !empty($row['hidden']),

			// These are for [smg type=av]
			'type' => isset($row['type']) ? $row['type'] : '',
			'id_file' => isset($row['id_file']) ? $row['id_file'] : 0,
			'embed_url' => isset($row['embed_url']) ? $row['embed_url'] : '',
			'directory' => isset($row['directory']) ? $row['directory'] : '',
			'filename' => isset($row['filename']) ? $row['filename'] : '',
			'has_preview' => isset($row['has_preview']) ? $row['has_preview'] : false,
			'thumb_url' => isset($row['thumb_dir']) && !empty($amSettings['clear_thumbnames']) ? $clearurl . '/' . str_replace('%2F', '/', urlencode($row['thumb_dir'])) . '/' . aeva_getEncryptedFilename($row['thumb_file'], $row['id_thumb'], true) : $galurl . 'sa=media;in=' . $row['id_media'] . ';thumb',
		);
	}
	$amFunc['db_free_result']($request);
	return $items;
}

// Gets random or recent items
function aeva_getMediaItems($start = 0, $limit = 1, $sort = '', $all_albums = true, $albums = array(), $custom = '', $custom_file = 'thumb')
{
	global $amFunc, $user_info, $context;

	if (empty($amFunc) || empty($amFunc['db_query']))
		aeva_loadSettings();

	$query_see = '{query_see_album}';
	// If used in a tag, make sure the album/item is either visible to all, or owned by poster.
	if (!empty($context['aeva_id_msg']) && $start < 0)
	{
		$query_see = '{query_see_hidden_albums}';
		$request = $amFunc['db_query']('
			SELECT m.ID_MEMBER FROM {db_prefix}messages AS m WHERE m.ID_MSG = {int:id}',
			array('id' => (int) $context['aeva_id_msg']),__FILE__,__LINE__);
		list ($author) = $amFunc['db_fetch_row']($request);
		$amFunc['db_free_result']($request);
		$custom = (!empty($custom) ? $custom . ' AND ' : '') . '(a.hidden = 0 OR a.album_of = {int:author} OR m.id_member = {int:author})';
	}
	$start = $start < 0 ? 0 : $start;

	return aeva_fillMediaArray($amFunc['db_query']('
		SELECT
			m.id_media, m.id_member, m.title, m.views, m.downloads, m.time_added, m.type, m.num_comments, m.voters, m.weighted AS rating, m.embed_url,
			IFNULL(lm.time, IFNULL(lm_all.time, 0)) < m.log_last_access_time AS is_new, mem.realName AS real_name, m.member_name,
			ft.id_file AS id_thumb, ft.directory AS thumb_dir, ft.filename AS thumb_file, (pt.width && pt.height) AS has_preview,
			f.id_file, f.width, f.height, f' . ($custom_file != 'thumb' ? 't' : '') . '.height AS thumb_height, f.filename, f.directory, m.approved, m.description' . ($all_albums ? ', a.id_album, a.name, a.hidden' : '') . '
		FROM {db_prefix}aeva_media AS m' . ($all_albums ? '
			INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)' : '') . '
			LEFT JOIN {db_prefix}aeva_files AS f ON (f.id_file = m.id_' . $custom_file . ')
			LEFT JOIN {db_prefix}aeva_files AS ft ON (ft.id_file = m.id_thumb)
			LEFT JOIN {db_prefix}aeva_files AS pt ON (pt.id_file = m.id_preview)
			LEFT JOIN {db_prefix}aeva_log_media AS lm ON (lm.id_media = m.id_media AND lm.id_member = {int:user_id})
			LEFT JOIN {db_prefix}aeva_log_media AS lm_all ON (lm_all.id_media = 0 AND lm_all.id_member = {int:user_id})
			LEFT JOIN {db_prefix}members AS mem ON (mem.ID_MEMBER = m.id_member)
		WHERE ' . ($all_albums ? $query_see . '{raw:albums_in}' : 'm.album_id = {int:album}') . '{raw:approvals}' . (!empty($custom) ? '
			AND '. $custom : '') . (!empty($sort) ? '
		ORDER BY {raw:sort}' : '') . '
		LIMIT ' . (!empty($start) ? '{int:start},' : '') . '{int:limit}
	', array(
		'user' => 'user',
		'user_id' => $user_info['id'],
		'album' => $all_albums ? 0 : (int) $context['aeva_album']['id'],
		'albums_in' => count($albums) > 0 ? ' AND a.id_album IN (' . implode(',', $albums) . ')' : '',
		'author' => isset($author) ? $author : 0,
		'approvals' => !aeva_allowedTo('moderate') ? ' AND (m.approved = 1 OR m.id_member = ' . (int) $user_info['id'] . ')' : '',
		'start' => (int) $start,
		'limit' => (int) $limit,
		'sort' => $sort,
	),__FILE__,__LINE__), $all_albums);
}

// Gets random or recent comments
function aeva_getMediaComments($start, $limit, $random = false, $albums = array(), $custom = '')
{
	global $amFunc, $user_info, $scripturl, $txt;

	$request = $amFunc['db_query']('
		SELECT
			com.id_comment, com.id_member, com.id_media, com.message, com.posted_on,
			IFNULL(lm.time, IFNULL(lm_all.time, 0)) < GREATEST(com.posted_on, com.last_edited) AS is_new, a.id_album, a.name, m.title, mem.realName AS member_name
		FROM {db_prefix}aeva_comments AS com
			INNER JOIN {db_prefix}aeva_media AS m ON (m.id_media = com.id_media)
			INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
			LEFT JOIN {db_prefix}members AS mem ON (mem.ID_MEMBER = com.id_member)
			LEFT JOIN {db_prefix}aeva_log_media AS lm ON (lm.id_media = m.id_media AND lm.id_member = {int:id_member})
			LEFT JOIN {db_prefix}aeva_log_media AS lm_all ON (lm_all.id_media = 0 AND lm_all.id_member = {int:id_member})
		WHERE {query_see_hidden_albums}
			AND com.approved = 1' . (!empty($albums) ? '
			AND a.id_album IN ({string:albums})' : '') . (!empty($custom) ? '
			AND '. $custom : '').'
		ORDER BY ' . ($random ? 'RAND()' : 'com.id_comment DESC') . '
		LIMIT ' . (!empty($start) ? '{int:start},' : '') . '{int:limit}
	', array('id_member' => $user_info['id'], 'start' => $start, 'limit' => $limit, 'albums' => implode(',', $albums)),__FILE__,__LINE__);

	$items = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$items[] = array(
			'id_comment' => $row['id_comment'],
			'url' => $scripturl . '?action=media;sa=item;in=' . $row['id_media'] . '#com' . $row['id_comment'],
			'id_member' => $row['id_member'],
			'media_title' => $row['title'],
			'member_link' => empty($row['member_name']) ? $txt['guest'] : aeva_profile($row['id_member'], $row['member_name']),
			'id_media' => $row['id_media'],
			'posted_on' => aeva_timeformat($row['posted_on']),
			'is_new' => $row['is_new'],
			'id_album' => $row['id_album'],
			'album_name' => $row['name'],
			'msg' => $row['message'],
		);
	}
	$amFunc['db_free_result']($request);
	return $items;
}

// Gets recent albums
function aeva_getMediaAlbums($start = 0, $limit = 10)
{
	global $amFunc;

	$request = $amFunc['db_query']('
		SELECT a.id_album, a.name, a.num_items, a.album_of, m.realName AS owner_name
		FROM {db_prefix}aeva_albums AS a
		LEFT JOIN {db_prefix}members AS m ON (m.id_member = a.album_of)
		WHERE {query_see_album}
		AND a.num_items > 0
		ORDER BY a.id_album DESC
		LIMIT {int:start},{int:limit}', array('start' => $start, 'limit' => $limit),__FILE__,__LINE__);

	$albums = array();
	while ($row = $amFunc['db_fetch_assoc']($request))
		$albums[$row['id_album']] = array(
			'id' => $row['id_album'],
			'name' => $row['name'],
			'num_items' => $row['num_items'],
			'owner_id' => $row['album_of'],
			'owner_name' => $row['owner_name'],
		);

	$amFunc['db_free_result']($request);
	return $albums;
}

// Gets top albums by comments
function aeva_getTopAlbumsByComments($limit = 10, $order = 'DESC')
{
	// Simple(ish) function used for gettings top albums sorted by no. of comments
	// Returnes id of album, name of album and no. of comments and associative percentage
	// Use DESC in $order for Descending order and ASC in $order for ascending order
	global $amFunc;

	$request = $amFunc['db_query']('
		SELECT a.id_album, COUNT(id_comment) AS num_comments
		FROM {db_prefix}aeva_comments AS c
			INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = c.id_album)
		WHERE {query_see_album}
		GROUP BY a.id_album
		HAVING num_comments > 0
		ORDER BY num_comments {raw:order}
		LIMIT {int:limit}', array('order' => $order, 'limit' => $limit, '1' => 1), __FILE__,__LINE__);

	$albums = array();
	$max_com = 0;
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$req2 = $amFunc['db_query']('
			SELECT name
			FROM {db_prefix}aeva_albums
			WHERE id_album = {int:album}', array('album' => $row['id_album']), __FILE__,__LINE__);
		list ($row['name']) = $amFunc['db_fetch_row']($req2);
		$amFunc['db_free_result']($req2);

		$albums[$row['id_album']] = array(
			'id' => $row['id_album'],
			'name' => $row['name'],
			'num_comments' => $row['num_comments'],
		);
		if ($max_com < $row['num_comments'])
			$max_com = $row['num_comments'];
	}

	foreach ($albums as $k => $v)
		$albums[$k]['percent'] = round(($v['num_comments'] * 100) / $max_com);

	$amFunc['db_free_result']($request);
	return $albums;
}

// Gets top albums by items
function aeva_getTopAlbumsByItems($limit = 10, $order = 'DESC')
{
	// Simple(ish) function used for gettings top albums sorted by no. of items
	// Returns id of album, name of album and no. of items and associative percentage
	// Use DESC in $order for Descending order and ASC in $order for ascending order
	global $amFunc;

	$request = $amFunc['db_query']("
		SELECT a.id_album, a.name, a.num_items
		FROM {db_prefix}aeva_albums AS a
		WHERE {query_see_album}
		AND a.num_items > 0
		ORDER BY a.num_items {raw:order}
		LIMIT {int:limit}",array('order' => $order, 'limit' => $limit),__FILE__,__LINE__);

	$albums = array();
	$max_items = 0;
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$albums[$row['id_album']] = array(
			'id' => $row['id_album'],
			'name' => $row['name'],
			'num_items' => $row['num_items'],
		);
		if ($max_items < $row['num_items'])
			$max_items = $row['num_items'];
	}

	foreach ($albums as $k => $v)
		$albums[$k]['percent'] = round(($v['num_items'] * 100) / $max_items);

	$amFunc['db_free_result']($request);
	return $albums;
}

// Gets top items in different clauses
function aeva_getTopItems($limit = 10, $by = 'views', $order = 'DESC')
{
	// Use 'views' in $by to sort by views, 'rating' to sort by rating, 'num_com' to sort by # of comments
	// Use DESC in $order to get in descending order and ASC to get in Ascending order
	global $amFunc;

	$request = $amFunc['db_query']('
		SELECT m.id_media, m.title, m.views, m.num_comments, m.id_thumb, m.id_preview, a.name, a.id_album, m.weighted, m.voters
		FROM {db_prefix}aeva_media AS m
			INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
		WHERE {query_see_album}
		AND m.approved = 1
		AND ' . ($by == 'views' ? 'm.views' : ($by == 'rating' ? 'm.weighted' : ($by == 'voters' ? 'm.voters' : ($by == 'num_com' ? 'm.num_comments' : 'm.views')))) . ' > 0
		ORDER BY {raw:sort} {raw:sort_order}
		LIMIT {int:limit}',
		array('sort' => $by == 'views' ? 'm.views' : ($by == 'rating' ? 'm.weighted' : ($by == 'voters' ? 'm.voters' : ($by == 'num_com' ? 'm.num_comments' : 'm.views'))), 'sort_order' => $order, 'limit' => $limit),__FILE__,__LINE__);

	$items = array();
	$max = 0;
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		if ($by == 'views')
			$match = $row['views'];
		elseif ($by == 'rating')
			$match = round($row['weighted']);
		elseif ($by == 'voters')
			$match = $row['voters'];
		elseif ($by == 'num_com')
			$match = $row['num_comments'];
		$items[$row['id_media']] = array(
			'id' => $row['id_media'],
			'title' => $row['title'],
			'views' => $row['views'],
			'rating' => round($row['weighted'], 2),
			'voters' => $row['voters'],
			'num_com' => $row['num_comments'],
			'id_thumb' => $row['id_thumb'],
			'id_preview' => $row['id_preview'],
			'album' => array(
				'id' => $row['id_album'],
				'name' => $row['name'],
			),
			'match' => $match,
		);

		if ($max < $match)
			$max = $match;
	}
	foreach ($items as $k => $v)
		$items[$k]['percent'] = round(($v['match']*100) / $max);

	$amFunc['db_free_result']($request);
	return $items;
}

// Gets top uploader
function aeva_getTopMembers($limit = 10, $by = 'items', $order = 'DESC')
{
	global $amFunc;
	$request = $amFunc['db_query']("
		SELECT mem.realName AS member_name, mem.ID_MEMBER AS id_member, mem.aeva_items, mem.aeva_comments
		FROM {db_prefix}members AS mem
		WHERE ".($by == 'items' ? 'mem.aeva_items' : 'mem.aeva_comments')." > 0
		ORDER BY ".($by == 'items' ? 'mem.aeva_items' : 'mem.aeva_comments')." {raw:order}
		LIMIT {int:limit}",array('1' => 1, 'order' => $order, 'limit' => $limit),__FILE__,__LINE__);

	$members = array();
	$max = 0;
	while ($row = $amFunc['db_fetch_assoc']($request))
	{
		$members[$row['id_member']] = array(
			'id' => $row['id_member'],
			'total_items' => $row['aeva_items'],
			'total_comments' => $row['aeva_comments'],
			'name' => $row['member_name'],
		);
		if ($max < $row[$by == 'items' ? 'aeva_items' : 'aeva_comments'])
			$max = $row[$by == 'items' ? 'aeva_items' : 'aeva_comments'];
	}
	foreach ($members as $k => $v)
		$members[$k]['percent'] = round(($v[$by == 'items' ? 'total_items' : 'total_comments'] * 100) / $max);

	$amFunc['db_free_result']($request);
	return $members;
}

// ******* NOTICE: THIS FUNCTION IS NOT USED AT ALL, ANYWHERE... IT SHOULD PROBABLY BE REMOVED. OR USED! ******
// Use this to get a user's stats like number of pictures uploaded, filespace used, User Gallery, # of comments sent, latest images posted, etc.
function aeva_userStats($userid = 0, $latest_images_limit = 0)
{
	global $amFunc;

	// Nothing for a guest!
	if ($userid == 0)
		return false;

	$result = $amFunc['db_query']('
		SELECT m.id_media, m.id_member, f.filesize
		FROM {db_prefix}aeva_media AS m
		INNER JOIN {db_prefix}aeva_files AS f ON (m.id_file = f.id_file)
		WHERE m.id_member = {int:user_id}',
		array(
			'user_id' => $userid,
		),__FILE__,__LINE__);

	$stats = array();
	$stats['filespace_taken'] = 0;
	$stats['num_pics_uploaded'] = 0;
	while ($row = $amFunc['db_fetch_assoc']($result))
		$stats['filespace_taken'] += $row['filesize'];

	$stats['num_pics_uploaded'] = $amFunc['db_num_rows']($result);
	$amFunc['db_free_result']($result);

	// Get their user gallery
	$user_album = $amFunc['db_query']('
		SELECT id_album, name, featured, album_of
		FROM {db_prefix}aeva_albums
		WHERE album_of = {int:user_id}
		AND approved = 1',
		array(
			'user_id' => $userid,
			'user' => 'user',
		),__FILE__,__LINE__);

	if ($amFunc['db_num_rows']($user_album) == 0)
		$stats['user_album'] = false;
	else
	{
		$row = $amFunc['db_fetch_assoc']($user_album);
		$stats['user_album'] = array(
			'id' => $row['id_album'],
			'name' => $row['name'],
			'featured' => $row['featured'],
		);
	}
	$amFunc['db_free_result']($user_album);

	// Get their latest uploaded images
	if ($latest_images_limit > 0)
	{
		$images = $amFunc['db_query']('
			SELECT m.id_media, m.id_member, m.title, m.time_added, m.type AS mtype, m.id_thumb, m.id_preview
			FROM {db_prefix}aeva_media AS m
			INNER JOIN {db_prefix}aeva_albums AS a ON (m.id_album = a.id_album)
			WHERE m.id_member = {int:user_id}
			AND {query_see_hidden_albums}
			ORDER BY m.time_added DESC
			LIMIT {int:latest_images_limit}',
			array(
				'user_id' => $userid,
				'latest_images_limit' => $latest_images_limit,
			),__FILE__,__LINE__);
		while ($row = $amFunc['db_fetch_assoc']($images))
		{
			$stats['latest_images'][] = array(
				'id' => $row['id'],
				'title' => $row['title'],
				'time_added' => timeformat($row['time_added']),
				'type' => $row['mtype'],
				'id_thumb' => $row['id_thumb'],
				'id_preview' => $row['id_preview'],
			);
		}
		$amFunc['db_free_result']($images);
	}

	// Get there no. of comments made
	$request = $amFunc['db_query']('
		SELECT id_comment, id_member
		FROM {db_prefix}aeva_comments
		WHERE id_member = {int:user_id}
		AND approved = 1',
		array('user_id' => $userid),__FILE__,__LINE__);
	$stats['num_comments'] = $amFunc['db_num_rows']($request);
	$amFunc['db_free_result']($request);

	return $stats;
}

function aeva_updateSettings($setting, $new_value, $replace = false)
{
	global $amFunc, $amSettings;

	$amFunc['db_query']($replace ? '
		REPLACE INTO {db_prefix}aeva_settings
		(name, value)
		VALUES ({string:name}, {string:value})' : '
		UPDATE {db_prefix}aeva_settings
		SET value = {string:value}
		WHERE name = {string:name}',
		array(
			'name' => $setting,
			'value' => $new_value,
		),__FILE__,__LINE__);

	$amSettings[$setting] = $new_value;
}

function aeva_increaseSettings($setting, $add = 1)
{
	global $amFunc, $amSettings;

	if ($add == 0)
		return;

	$add = (int) $add;
	$amFunc['db_query']('
		UPDATE {db_prefix}aeva_settings
		SET value = value ' . ($add < 0 ? '-' : '+') . ' {int:value}
		WHERE name = {string:name}' . ($add < 0 ? ' AND value >= {int:value}' : ''),
		array(
			'name' => $setting,
			'value' => abs($add),
		),__FILE__,__LINE__);

	$amSettings[$setting] += $add;
}

function aeva_theme_url($file)
{
	global $settings;

	return file_exists($settings['default_theme_dir'] . '/aeva/' . $file) ?
		$settings['default_theme_url'] . '/aeva/' . $file : $settings['theme_url'] . '/aeva/' . $file;
}

function aeva_profile($id, $name, $func = 'aeva')
{
	global $scripturl, $context, $forum_version, $txt;
	return empty($id) ? (empty($name) ? $txt['guest'] : $name) : ('<a href="' . $scripturl . '?action=profile;u=' . $id . ($context['is_smf2'] && !strpos('RC', $forum_version) ? ';area=' : ';sa=') . $func . '">' . $name .'</a>');
}

function aeva_markSeen($id, $options = '', $user = -1)
{
	global $amFunc, $db_prefix, $user_info;

	if ($user == -1)
		$user = $user_info['id'];

	if (empty($user))
		return false;

	// Update the unseen tracker!
	if ($options != 'force_insert')
		$amFunc['db_query']('
			UPDATE {db_prefix}aeva_log_media
			SET time = {int:time}
			WHERE id_member = {int:mem}
			AND id_media ' . (is_array($id) ? 'IN ({array_int:media})' : '= {int:media}'),
			array('time' => time(), 'mem' => $user, 'media' => $id),__FILE__,__LINE__
		);

	if ($options == 'force_insert' || $amFunc['db_affected_rows']() == 0)
	{
		// Never seen this item before? OK, let's INSERT IGNORE a new entry
		$amFunc['db_insert'](
			$db_prefix . 'aeva_log_media',
			array('id_media', 'id_member', 'time'),
			array($id, $user, time()),
			__FILE__,__LINE__, true
		);
		// Returns true if resetUnseen() needs to be called.
		return true;
	}
	return false;
}

function aeva_updateWeighted()
{
	global $amFunc;

	$request = $amFunc['db_query']('
		SELECT SUM(voters), SUM(rating), COUNT(id_media) FROM {db_prefix}aeva_media LIMIT 1', array(),__FILE__,__LINE__);
	list ($voters, $ratings, $co) = $amFunc['db_fetch_row']($request);
	$amFunc['db_free_result']($request);

	$request = $amFunc['db_query']('
		UPDATE {db_prefix}aeva_media
		SET weighted = ({float:avg_rating} + rating) / ({float:avg_voters} + voters)
		WHERE voters > 0', array('avg_rating' => $ratings / max(1, $co), 'avg_voters' => $voters / max(1, $co)),__FILE__,__LINE__);
}

function aeva_foolProof()
{
	global $amSettings;

	return is_dir($amSettings['data_dir_path']) ? (is_writable($amSettings['data_dir_path']) ? 1 : -1) : 0;
}

function aeva_mkdir($dir, $chmod)
{
	global $amSettings, $context, $sourcedir;

	if (isset($context['smg_ftp']) && ini_get('safe_mode'))
	{
		require_once($sourcedir . '/Subs-Package.php');
		if (function_exists('loadClassFile'))
			loadClassFile('Class-Package.php');
		$smg_ftp = new ftp_connection($context['smg_ftp']['server'], $context['smg_ftp']['port'], $context['smg_ftp']['username'], $context['smg_ftp']['password']);
		$success = $smg_ftp->create_dir($context['smg_ftp']['mgal_data'] . $dir);
		$smg_ftp->chmod($context['smg_ftp']['mgal_data'] . $dir, $chmod);
		$smg_ftp->close();
		return (bool) $success;
	}

	return @mkdir($amSettings['data_dir_path'] . $dir, $chmod);
}

// Reset everyone's Unseen counter to zero.
function aeva_resetUnseen($id = null)
{
	updateMemberData($id, array('aeva_unseen' => '-1'));
	if ($id === null && function_exists('clean_cache'))
		clean_cache('member_data');
}

// Set current user's Unseen counter to zero and mark all items as seen.
function aeva_markAllSeen()
{
	global $amFunc, $user_info;

	$request = $amFunc['db_query']('
		DELETE FROM {db_prefix}aeva_log_media WHERE id_member = {int:member}',
		array('member' => $user_info['id']), __FILE__,__LINE__);
	$amFunc['db_query']('
		INSERT INTO {db_prefix}aeva_log_media
			(id_media, id_member, time)
		VALUES (0, {int:member}, UNIX_TIMESTAMP())',
		array('member' => $user_info['id']), __FILE__,__LINE__);

	if (!empty($user_info['aeva_unseen']))
		updateMemberData($user_info['id'], array('aeva_unseen' => 0));
	$user_info['aeva_unseen'] = 0;

	// Optimize the table from time to time... Only 33% of the time should be okay,
	// change this to mt_rand(1, 100) for a 1% rate if your forum is busy.
	if (mt_rand(1, 3) == 1)
		$amFunc['db_query']('OPTIMIZE TABLE {db_prefix}aeva_log_media', array(), __FILE__,__LINE__);
}

function aeva_addHeaders($add_to_headers = false, $autosize = true, $use_lightbox = true)
{
	global $context, $txt, $modSettings, $amSettings, $scripturl;

	if (isset($context['mg_headers_sent']))
		return;

	aeva_loadLanguage('aeva_move');

	$use_lightbox &= !empty($amSettings['use_lightbox']);
	$lightbox = (empty($_GET['action']) || $_GET['action'] != 'media' ? '
	<link rel="stylesheet" type="text/css" href="' . aeva_theme_url('am.css') . '" />' : '') . (!$use_lightbox ? '' : '
	<link rel="stylesheet" type="text/css" href="' . aeva_theme_url('hs.css') . '" media="screen" />');

	if ((empty($_GET['action']) || $_GET['action'] != 'media') && (($context['browser']['is_firefox'] && $pfx = 'moz') || ($context['browser']['is_safari'] && $pfx = 'webkit')))
		$lightbox .= '
	<style type="text/css">
		.pics td { -' . $pfx . '-border-radius: 5px; }
		.aeva_rounded { -' . $pfx . '-border-radius: 5px; }
	</style>';

	if ($use_lightbox)
		$lightbox .= aeva_initLightbox($autosize);

	if ($add_to_headers || (ob_get_length() === 0))
		$context['html_headers'] .= $lightbox;
	else
	{
		// If PrettyURLs is enabled, it'll run twice... Don't waste time on that!
		$temp_pretty = isset($modSettings['pretty_enable_filters']) ? $modSettings['pretty_enable_filters'] : false;
		$modSettings['pretty_enable_filters'] = false;

		$obs = function_exists('ob_get_status') ? ob_get_status() : false;
		$temp = ob_get_contents();
		@ob_end_clean();
		ob_start($obs && ($obs['name'] != 'default output handler') ? $obs['name'] : null);

		$modSettings['pretty_enable_filters'] = $temp_pretty;
		echo substr_replace($temp, $lightbox . "\n" . '</head>', stripos($temp, '</head>'), 7);
		unset($temp);
	}

	$context['mg_headers_sent'] = true;
}

function aeva_loadLanguage($str)
{
	global $txt;

	if (!isset($txt[$str]) && (!($tst = loadLanguage('Aeva')) || !isset($txt[$str])))
	{
		loadLanguage('Aeva', 'english');
		if ($tst)
			loadLanguage('Aeva');
	}
}

function aeva_getItemData($item)
{
	global $amFunc, $amSettings, $user_info;

	$request = $amFunc['db_query']('
		SELECT
			m.id_media, m.title, m.description, m.keywords, m.id_member, m.last_edited, m.last_edited_by,
			m.id_thumb, m.id_preview, m.id_file, IFNULL(mem2.realName, m.last_edited_name) AS last_edited_name,
			m.approved, m.type, m.rating, m.voters, m.weighted, m.views, m.downloads, m.time_added, m.num_comments,
			a.id_album AS album_id, a.master, a.name AS album_name, a.featured, a.options,
			f.filename, f.filesize, f.width, f.height, f.directory, m.embed_url, f.exif,
			IFNULL(lm.time, IFNULL(lm_all.time, 0)) < m.log_last_access_time AS is_new,
			IFNULL(p.width,f.width) AS preview_width, IFNULL(p.height,f.height) AS preview_height, (p.width && p.height) AS has_preview,
			t.width AS thumb_width, t.height AS thumb_height
		FROM {db_prefix}aeva_media AS m
			INNER JOIN {db_prefix}aeva_albums AS a ON (a.id_album = m.album_id)
			LEFT JOIN {db_prefix}aeva_files AS f ON (f.id_file = m.id_file)
			LEFT JOIN {db_prefix}aeva_files AS p ON (p.id_file = m.id_preview)
			LEFT JOIN {db_prefix}aeva_files AS t ON (t.id_file = m.id_thumb)
			LEFT JOIN {db_prefix}members AS mem2 ON (mem2.ID_MEMBER = m.last_edited_by)
			LEFT JOIN {db_prefix}aeva_log_media AS lm ON (lm.id_media = m.id_media AND lm.id_member = m.id_member)
			LEFT JOIN {db_prefix}aeva_log_media AS lm_all ON (lm_all.id_media = 0 AND lm_all.id_member = m.id_member)
		WHERE m.id_media = {int:id_media}
		{raw:approvals}
		LIMIT 1',
		array('id_media' => $item, 'approvals' => !aeva_allowedTo('moderate') ? 'AND (m.approved = 1 OR m.id_member = '.$user_info['id'].')' : ''),__FILE__,__LINE__);
	if ($amFunc['db_num_rows']($request) == 0)
		fatal_lang_error('aeva_item_not_found', !empty($amSettings['log_access_errors']));
	$item_data = $amFunc['db_fetch_assoc']($request);
	$amFunc['db_free_result']($request);
	return $item_data;
}

?>