<?php
/****************************************************************
* Aeva Media													*
* © Noisen.com & SMF-Media.com									*
*****************************************************************
* Aeva-Subs-Vital.php - database functions, etc.				*
*****************************************************************
* Users of this software are bound by the terms of the			*
* Aeva Media license. You can view it in the license_am.txt		*
* file, or online at http://noisen.com/license.php				*
*																*
* Support and updates for this software can be found at			*
* http://aeva.noisen.com and http://smf-media.com				*
****************************************************************/

/*
	Contains vital functions for Aeva Media, previously half of Aeva-Subs.php.... Basically functions that don't play with the DB.

	void aeva_loadDatabase()
		- Initialises the DB part of $amFunc array

	array aeva_db_fetch_assoc(resource result)
		- Compatibility function for $smcFunc['db_fetch_assoc'] in SMF 2

	int aeva_db_num_rows(resource result)
		- Compatibility function for $smcFunc['db_num_rows'] in SMF 2

	int aeva_db_insert_id(string table, string field)
		- Compatibility function for $smcFunc['db_insert_id'] in SMF 2

	void aeva_db_free_result(resource result)
		- Compatibility function for $smcFunc['db_free_result'] in SMF 2

	int aeva_db_affected_rows(resource identifier)
		- Compatibility function for $smcFunc['db_affected_rows'] in SMF 2

	array aeva_db_fetch_row(resource result)
		- Compatibility function for $smcFunc['db_fetch_row'] in SMF 2

	resource aeva_db_query(string db_string, array db_values, string file, int line, bool security_override = false)
		- Compatibility function for $smcFunc['db_query'] in SMF 2

	void aeva_db_insert(string table, array columns, array data, string file, int line, bool ignore = false)
		- Compatibility function for $smcFunc['db_affected_rows'] in SMF 2

	string aeva_db_replacement_callback(array matches)
		- Stripped-down version of smf_db_replacement__callback in SMF 2

	string aeva_db_filter_columns(string db_string)
		- Replaces SMF 1.1's column names into SMF 2's if SMF 2 is found installed.

	array aeva_allowed_types(bool flat = false, bool see_all = false)
		- Returns the allowed item extensions for the user
		- If flat is true, skips adding "BRs" to the array list

	int aeva_get_num_files(string path)
		- Gets the number of files inside the specified path

	void aeva_addLinktree(string url, string name)
		- Adds an element to the linktree

	bool aeva_allowedTo(mixed permissions, bool single_true)
		- Uses allowedTo to determine whether the user can perform a specific action against a permission name or not
		- If permissions is an array, performs test on all permissions
		- If single_true is false, makes sures that all the returned tests are true otherwise it returns false. If true, it requires only one true to pass.

	int aeva_get_size(string path)
		- Returns the size of a directory or file

	array aeva_get_dir_map(string path)
		- Returns the whole map of the directory
		- Returns all the folders, sub-folders (and so on), as well as their files
		- 0 contains the main array, 1 contains the list

	array aeva_get_dir_list_subfolders()
		- You really wanna know?

	class aeva_media_handler
		- Handles our media items
		- Supports GD2, Imagick, MagickWand and FFMPEG (when compiled with PHP)

	string aeva_getEncryptedFilename(string name, int id)
		- Gets an encrypted filename for a specified name

	int aeva_getPHPSize(string size)
		- Returns a php.ini size limit, in bytes

	string aeva_getTags(array taglist)
		- Returns a formatted tag list

	array aeva_splitTags(string string, string separation)
		- Splits keywords from a comma-separated list

	array aeva_closeTags(string str)
		- Closes all open tags, in recursive order, in order for pages not to be broken and to validate.

	array aeva_cutString(string string, int max_length, bool check_multibyte, bool cut_long_words, bool ellipsis, bool preparse, int hard_limit)
		- Cuts a HTML string to requested length, counting entities as 1 character, and not cutting them
		- max_length is the max desired length in characters, hard_limit in bytes (for database storage reasons), the rest is self explained.

	array aeva_restoreEntities(array match)
		- Recursively reattributes entities to strings

	bool aeva_is_utf8(string string)
		- Tests whether current string is in UTF-8 format (really not needed though)

	string aeva_utf2entities(string source, bool is_file, int limit, bool is_utf, bool ellipsis, bool check_multibyte, bool cut_long_words, int hard_limit)
		- Converts a string to numeric entities. Has plenty of parameters because I suck at doing this clearly. But at least it works. Usually.

	string aeva_entities2utf(array mixed)
		// !!!

	string aeva_utf8_chr(string code)
		// !!!

	class aeva_zipper
		- Handles creation of zip files, especially while multi downloading
*/

global $sourcedir;

require_once($sourcedir . '/Aeva-Media.php');

/****************
 !! NOTE !!
 These functions are optimized for use within Aeva Media, they are NOT for any mod or general use.
 Some of the code is derived from the SMF 2.0 codebase
 ***************/
function aeva_loadDatabase()
{
	global $amFunc;

	$amFunc += array(
		'db_query' => 'aeva_db_query',
		'db_fetch_assoc' => 'aeva_db_fetch_assoc',
		'db_num_rows' => 'aeva_db_num_rows',
		'db_insert_id' => 'aeva_db_insert_id',
		'db_free_result' => 'aeva_db_free_result',
		'db_insert' => 'aeva_db_insert',
		'db_affected_rows' => 'aeva_db_affected_rows',
		'db_fetch_row' => 'aeva_db_fetch_row',
	);
}

function aeva_db_fetch_assoc($result)
{
	global $context, $smcFunc;
	return $context['is_smf2'] ? $smcFunc['db_fetch_assoc']($result) : mysql_fetch_assoc($result);
}

function aeva_db_num_rows($result)
{
	global $context, $smcFunc;
	return $context['is_smf2'] ? $smcFunc['db_num_rows']($result) : mysql_num_rows($result);
}

function aeva_db_insert_id($table = '', $field = '')
{
	global $context, $smcFunc;
	return $context['is_smf2'] ? $smcFunc['db_insert_id']($table, $field) : mysql_insert_id();
}

function aeva_db_free_result($result)
{
	global $context, $smcFunc;
	return $context['is_smf2'] ? $smcFunc['db_free_result']($result) : mysql_free_result($result);
}

function aeva_db_affected_rows($identifier = null)
{
	global $context, $smcFunc;
	return $context['is_smf2'] ? $smcFunc['db_affected_rows']() : mysql_affected_rows();
}

function aeva_db_fetch_row($result)
{
	global $context, $smcFunc;
	return $context['is_smf2'] ? $smcFunc['db_fetch_row']($result) : mysql_fetch_row($result);
}

function aeva_db_query($db_string, $db_values, $file, $line, $security_override = false)
{
	global $context, $db_callback, $smcFunc, $db_connection, $user_info;

	if (empty($db_string))
		return false;

	if ($context['is_smf2'])
	{
		$db_string = aeva_db_filter_columns($db_string);
		if ($security_override)
			$db_values = 'security_override';

		$db_string = str_replace(
			array('{_query_see_album}', '{query_see_album}', '{query_see_hidden_albums}'),
			array($user_info['aeva_query_see_album_2'], $user_info['aeva_query_see_album'], $user_info['aeva_query_see_hidden_albums']),
			$db_string
		);

		return $smcFunc['db_query']('', $db_string, $db_values);
	}

	if (!$security_override)
	{
		// Pass some values to the global space for use in the callback function.
		$db_callback = array($db_values, $db_connection, $file, $line);

		// Inject the values passed to this function.
		$db_string = preg_replace_callback('~{([a-z_]+)(?::([a-zA-Z0-9_-]+))?}~', 'aeva_db_replacement_callback', $db_string);

		// This shouldn't be residing in global space any longer.
		$db_callback = array();
	}

	return db_query($db_string, $file, $line);
}

function aeva_db_insert($table, $columns, $data, $file, $line, $ignore = false)
{
	// Function used for inserting some data into some table
	global $context, $db_prefix, $amFunc, $smcFunc;

	if (empty($table) || empty($columns) || empty($data))
		return false;
	$insert = $ignore ? 'INSERT IGNORE' : 'INSERT';
	if ($context['is_smf2'])
	{
		$columns_2 = array();
		// OK Convert them to a proper SMF 2.0 compatible format
		$count = count($columns);
		foreach ($columns as $k => $v)
			$columns_2[$v] = is_int($data[$k]) ? 'int' : 'string';
		$data_2 = array();
		// Convert the data now
		foreach ($data as $v)
			$data_2[] = $v;

		return $smcFunc['db_insert']($ignore ? 'ignore' : '', $table, $columns_2, $data_2, null);
	}

	// OK this seems to be SMF 1.1, well, do it this way then
	$table = str_replace('{db_prefix}', $db_prefix, $table);

	$query_data = array_combine($columns, $data);
	$insert_columns = array();
	$insert_data = array();

	// Just so that we get the things at the right place
	foreach ($query_data as $c => $d)
	{
		$insert_columns[] = '`' . $c . '`';
		$insert_data[] = is_int($d) ? (int) $d : sprintf('\'%1$s\'', mysql_real_escape_string($d));
	}

	$amFunc['db_query'](
		$insert . ' INTO ' . $table . ' (' . implode(',', $insert_columns) . ')
		VALUES
		(' . implode(',', $insert_data) . ')', array(), $file, $line, true);
}

// Simplified version of the smf_db_replacement__callback function in SMF 2.0
function aeva_db_replacement_callback($matches)
{
	global $db_callback, $user_info, $db_prefix, $amFunc;

	list ($values, $connection, $file, $line) = $db_callback;

	if ($matches[1] === 'db_prefix')
		return $db_prefix;

	if ($matches[1] === 'query_see_board')
		return $user_info['query_see_board'];

	if ($matches[1] === 'query_see_album')
		return $user_info['aeva_query_see_album'];

	if ($matches[1] === '_query_see_album')
		return $user_info['aeva_query_see_album_2'];

	if ($matches[1] === 'query_see_hidden_albums')
		return $user_info['aeva_query_see_hidden_albums'];

	if (!isset($matches[2]))
		fatal_error('Invalid value inserted or no type specified.' . htmlspecialchars($matches[2]).' <br />'.$file.'<br />'.$line);

	if (!isset($values[$matches[2]]))
		fatal_error('The database value you\'re trying to insert does not exist: ' . htmlspecialchars($matches[2]).' <br />'.$file.'<br />'.$line);

	$replacement = $values[$matches[2]];

	switch ($matches[1])
	{
		case 'int':
			if (!is_numeric($replacement) || (string) $replacement !== (string) (int) $replacement)
				fatal_error('There was a error in your query<br />'.htmlspecialchars($file).'<br />'.$line.'<br />'.$matches[2]);
			return (string) (int) $replacement;
		break;

		case 'string':
		case 'text':
			return sprintf('\'%1$s\'', mysql_real_escape_string($replacement));
		break;

		case 'raw':
			return $replacement;
		break;

		case 'array_int':
			if (is_array($replacement))
			{
				if (empty($replacement))
					fatal_error('Database error, given array of integer values is empty. (' . $matches[2] . ')');

				foreach ($replacement as $key => $value)
				{
					if (!is_numeric($value) || (string) $value !== (string) (int) $value)
						fatal_error('Wrong value type sent to the database. Array of integers expected. (' . $matches[2] . ')');

					$replacement[$key] = (string) (int) $value;
				}

				return implode(', ', $replacement);
			}
			else
				fatal_error('Wrong value type sent to the database. Array of integers expected. (' . $matches[2] . ')');
		break;

		case 'array_string':
			if (is_array($replacement))
			{
				if (empty($replacement))
					fatal_error('Database error, given array of string values is empty. (' . $matches[2] . ')');

				foreach ($replacement as $key => $value)
					$replacement[$key] = sprintf('\'%1$s\'', mysql_real_escape_string($value, $connection));

				return implode(', ', $replacement);
			}
			else
				fatal_error('Wrong value type sent to the database. Array of strings expected. (' . $matches[2] . ')');
		break;

		case 'float':
			if (!is_numeric($replacement))
				fatal_error('Wrong value type sent to the database. Floating point number expected.');
			return (string) (float) $replacement;
		break;
	}
	fatal_error('The type you specified is not found');
}

// This filters the 1.1 columns to 2.0
function aeva_db_filter_columns($db_string)
{
	return str_replace(
		array(
			'ID_MEMBER', 'realName', 'memberName', 'ID_TOPIC', 'ID_MSG', 'ID_FIRST_MSG', 'posterName', 'groupName',
			'ID_GROUP', 'minPosts', 'additionalGroups', 'ID_BOARD', 'ID_CAT', 'boardOrder', 'childLevel',
		),
		array(
			'id_member', 'real_name', 'member_name', 'id_topic', 'id_msg', 'id_first_msg', 'poster_name', 'group_name',
			'id_group', 'min_posts', 'additional_groups', 'id_board', 'id_cat', 'board_order', 'child_level',
		), $db_string
	);
}

function aeva_allowed_types($flat = false, $see_all = false)
{
	$ext = aeva_extList();
	$allowed_types = array(
		'im' => array_keys($ext['image']),
		'au' => array_keys($ext['audio']),
		'vi' => array_keys($ext['video']),
		'do' => array_keys($ext['doc']),
		'zi' => array('zipm')
	);

	if (!$see_all)
	{
		if (!aeva_allowedTo('add_images'))
			unset($allowed_types['im']);
		if (!aeva_allowedTo('add_audios'))
			unset($allowed_types['au']);
		if (!aeva_allowedTo('add_videos'))
			unset($allowed_types['vi']);
		if (!aeva_allowedTo('add_docs'))
			unset($allowed_types['do']);
		if (!aeva_allowedTo(array('add_images', 'add_audios', 'add_videos', 'add_docs'), true))
			unset($allowed_types['zi']);
	}

	if (!$flat)
		return $allowed_types;

	$allowed_types_flat = array();
	foreach ($allowed_types as $all)
		foreach ($all as $v)
			$allowed_types_flat[] = $v;

	return $allowed_types_flat;
}

function aeva_addLinktree($url, $name)
{
	global $context;
	$context['linktree'][] = array('url' => $url, 'name' => $name);
}

function aeva_allowedTo($perms, $single_true = false)
{
	global $context;

	if (empty($perms))
		return false;

	if (allowedTo('aeva_manage'))
		return true;

	if (!is_array($perms))
		return !in_array($perms, $context['aeva_album_permissions']) ? allowedTo('aeva_' . $perms) : isset($context['aeva_album']) && in_array($perms, $context['aeva_album']['permissions']);

	$tests = array();
	foreach ($perms as $perm)
		$tests[] = !in_array($perm, $context['aeva_album_permissions']) ? allowedTo('aeva_' . $perm) : isset($context['aeva_album']) && in_array($perm, $context['aeva_album']['permissions']);

	return $single_true ? in_array(true, $tests) : !in_array(false, $tests);
}

// Gets the size for a file or a directory
function aeva_get_size($path)
{
	if (!is_readable($path))
		return false;

	if (!is_dir($path))
		return filesize($path);

	$dirname_stack[] = $path;
	$size = 0;

	do {
		$dirname = array_shift($dirname_stack);
		$handle = @opendir($dirname);
		while (false !== ($file = readdir($handle)))
		{
			if ($file != '.' && $file != '..' && is_readable($dirname . '/' . $file))
			{
				if (is_dir($dirname . '/' . $file))
					$dirname_stack[] = $dirname . '/' . $file;
				$size += filesize($dirname . '/' . $file);
			}
		}
		closedir($handle);
	} while (count($dirname_stack) > 0);

	return $size;
}

function aeva_get_num_files($path)
{
	// Counts number of items in a directory
	if (!is_readable($path))
		return false;
	if (!is_dir($path))
		return false;

	$dirname_stack[] = $path;
	$num_files = 0;

	do
	{
		$dirname = array_shift($dirname_stack);
		$handle = @opendir($dirname);
		while (false !== ($file = readdir($handle)))
		{
			if ($file != '.' && $file != '..' && is_readable($dirname . '/' . $file))
			{
				if (is_dir($dirname . '/' . $file))
					$dirname_stack[] = $dirname . '/' . $file;
				$num_files++;
			}
		}
		closedir($handle);
	}
	while (count($dirname_stack) > 0);

	return $num_files;
}

function aeva_get_dir_map($path)
{
	if (!is_readable($path))
		return false;
	if (!is_dir($path))
		return false;

	// Actually map the directory
	$dirname_stack[] = array($path, null, 'root');
	$dirs = array();
	$i = 0;
	do
	{
		list ($dirname, $parent, $foldername) = array_shift($dirname_stack);
		$dirs[$i] = array(
			'dirname' => $dirname,
			'fname' => $foldername,
			'parent' => $parent,
			'files' => array(),
			'folders' => array(),
		);
		$handle = @opendir($dirname);
		while (false !== ($file = readdir($handle)))
		{
			if ($file != '.' && $file != '..' && is_readable($dirname . '/' . $file) && substr($file, 0, 1) != '.')
			{
				if (is_dir($dirname . '/' . $file))
				{
					$dirname_stack[] = array($dirname . '/' . $file, $i, $file);
					$dirs[$i]['folders'][] = array($file, $dirname . '/' . $file);
				}
				else
					$dirs[$i]['files'][] = array($file, filesize($dirname . '/' . $file), $dirname . '/' . $file);
			}
		}
		closedir($handle);

		$i++;
	}
	while (count($dirname_stack) > 0);

	// Get the folders' child level
	$child_level_index = array(0 => 0);
	foreach ($dirs as $dir => $data)
	{
		if (isset($child_level_index[$dir['parent']]))
			continue;
		elseif (isset($child_level_index[$data['parent']]))
			$child_level_index[$dir] = $child_level_index[$data['parent']] + 1;
		else
			$child_level_index[$dir] = 1;
	}

	// Assign them
	foreach ($dirs as $dir => $data)
	{
		$dirs[$dir]['child_level'] = isset($child_level_index[$data['parent']]) ? $child_level_index[$data['parent']] : 0;
	}

	// Assign the sub-folders, list their index
	$dirpath_index = array();
	foreach ($dirs as $dir => $data)
	{
		$dirpath_index[$data['dirname']] = $dir;
	}
	foreach ($dirs as $dir => $data)
	{
		foreach ($data['folders'] as $folder => $folderdata)
		{
			$dirs[$dir]['folders'][$folder][2] = $dirpath_index[$folderdata[1]];
		}
	}

	// Get the list
	foreach ($dirs as $dir => $data)
	{
		// If the parent's not empty... They are already included!
		if (!is_null($data['parent']))
			continue;

		$_list[] = $dir;
		aeva_get_dir_list_subfolders($dirs, $data, $_list);
	}

	return array($dirs, $_list);
}

function aeva_get_dir_list_subfolders($dirs, $data, &$_list)
{
	foreach ($data['folders'] as $folder)
	{
		$_list[] = $folder[2];
		if (!empty($dirs[$folder[2]]['folders']))
			aeva_get_dir_list_subfolders($dirs, $dirs[$folder[2]], $_list);
	}
}

function aeva_copyright()
{
	global $amSettings;
	// IT IS ILLEGAL TO MODIFY/REMOVE THIS FUNCTION OR NOT INCLUDE THIS ON THE PAGE WITHOUT WRITTEN PERMISSION FROM THE AUTHOR
	// DO NOT MODIFY/REMOVE THIS FUNCTION UNLESS YOU GOT WRITTEN PERMISSION FROM THE AUTHOR OR YOU BOUND TO A LEGAL OFFENSE
	echo '<strong>Aeva Media</strong> ', $amSettings['version'], ' &copy; 2008-2011 Nao &amp; Dragooon - <a href="http://wedge.org" target="_blank">Wedge: level up your forum!</a>';
}

/**
 * Class to dynamically create a zip file (archive)
 *
 * @author Rochak Chauhan
 */

// Obtained from http://olederer.users.phpclasses.org/browse/package/2322.html
class aeva_zipper
{
	var $compressedData = array();
	var $centralDirectory = array(); // central directory
	var $endOfCentralDirectory = "\x50\x4b\x05\x06\x00\x00\x00\x00"; // end of central directory record
	var $oldOffset = 0;

	/**
	 * Function to create the directory where the file(s) will be unzipped
	 *
	 * @param $directoryName string
	 *
	 */

	function addDirectory($directoryName)
	{
		$directoryName = str_replace("\\", "/", $directoryName);

		$feedArrayRow = "\x50\x4b\x03\x04";
		$feedArrayRow .= "\x0a\x00";
		$feedArrayRow .= "\x00\x00";
		$feedArrayRow .= "\x00\x00";
		$feedArrayRow .= "\x00\x00\x00\x00";

		$feedArrayRow .= pack("V",0);
		$feedArrayRow .= pack("V",0);
		$feedArrayRow .= pack("V",0);
		$feedArrayRow .= pack("v", strlen($directoryName));
		$feedArrayRow .= pack("v", 0);
		$feedArrayRow .= $directoryName;

		$feedArrayRow .= pack("V",0);
		$feedArrayRow .= pack("V",0);
		$feedArrayRow .= pack("V",0);

		$this -> compressedData[] = $feedArrayRow;

		$newOffset = strlen(implode("", $this->compressedData));

		$addCentralRecord = "\x50\x4b\x01\x02";
		$addCentralRecord .="\x00\x00";
		$addCentralRecord .="\x0a\x00";
		$addCentralRecord .="\x00\x00";
		$addCentralRecord .="\x00\x00";
		$addCentralRecord .="\x00\x00\x00\x00";
		$addCentralRecord .= pack("V",0);
		$addCentralRecord .= pack("V",0);
		$addCentralRecord .= pack("V",0);
		$addCentralRecord .= pack("v", strlen($directoryName));
		$addCentralRecord .= pack("v", 0);
		$addCentralRecord .= pack("v", 0);
		$addCentralRecord .= pack("v", 0);
		$addCentralRecord .= pack("v", 0);
		$ext = "\x00\x00\x10\x00";
		$ext = "\xff\xff\xff\xff";
		$addCentralRecord .= pack("V", 16);

		$addCentralRecord .= pack("V", $this->oldOffset);
		$this->oldOffset = $newOffset;

		$addCentralRecord .= $directoryName;

		$this->centralDirectory[] = $addCentralRecord;
	}

	/**
	 * Function to add file(s) to the specified directory in the archive
	 *
	 * @param $directoryName string
	 *
	 */

	function addFile($data, $directoryName)
	{
		$directoryName = str_replace("\\", "/", $directoryName);

		$feedArrayRow = "\x50\x4b\x03\x04";
		$feedArrayRow .= "\x14\x00";
		$feedArrayRow .= "\x00\x00";
		$feedArrayRow .= "\x08\x00";
		$feedArrayRow .= "\x00\x00\x00\x00";

		$uncompressedLength = strlen($data);
		$compression = crc32($data);
		$gzCompressedData = substr(gzcompress($data), 2, -4);
		$compressedLength = strlen($gzCompressedData);
		$feedArrayRow .= pack("V", $compression);
		$feedArrayRow .= pack("V", $compressedLength);
		$feedArrayRow .= pack("V", $uncompressedLength);
		$feedArrayRow .= pack("v", strlen($directoryName));
		$feedArrayRow .= pack("v", 0);
		$feedArrayRow .= $directoryName;

		$feedArrayRow .= $gzCompressedData;

		$feedArrayRow .= pack("V",$compression);
		$feedArrayRow .= pack("V",$compressedLength);
		$feedArrayRow .= pack("V",$uncompressedLength);

		$this -> compressedData[] = $feedArrayRow;

		$addCentralRecord = "\x50\x4b\x01\x02";
		$addCentralRecord .="\x00\x00";
		$addCentralRecord .="\x14\x00";
		$addCentralRecord .="\x00\x00";
		$addCentralRecord .="\x08\x00";
		$addCentralRecord .="\x00\x00\x00\x00";
		$addCentralRecord .= pack("V", $compression);
		$addCentralRecord .= pack("V", $compressedLength);
		$addCentralRecord .= pack("V", $uncompressedLength);
		$addCentralRecord .= pack("v", strlen($directoryName));
		$addCentralRecord .= pack("v", 0);
		$addCentralRecord .= pack("v", 0);
		$addCentralRecord .= pack("v", 0);
		$addCentralRecord .= pack("v", 0);
		$addCentralRecord .= pack("V", 32);

		$addCentralRecord .= pack("V", $this->oldOffset);

		$addCentralRecord .= $directoryName;

		$this->centralDirectory[] = $addCentralRecord;
	}

	// custom function by Dragooon for caching stuff
	function addFileDataToCache($data, $filename, $cache)
	{
		if (empty($this->oldOffset) && file_exists($cache . '_other'))
			list (, $this->oldOffset) = unserialize(@file_get_contents($cache . '_other'));

		$this->addFile($data, $filename);

		$this->oldOffset += strlen($this->compressedData[count($this->compressedData) - 1]);

		$f = @fopen($cache . '_data', file_exists($cache . '_data') ? 'a' : 'w');
		@fwrite($f, $this->compressedData[count($this->compressedData) - 1]);
		@fclose($f);

		@chmod($cache . '_data', 0777);

		$this->compressedData = array();

	}

	// Save it
	function saveFile($cache)
	{
		if (file_exists($cache . '_other'))
		{
			list ($centralDirectory) = unserialize(@file_get_contents($cache . '_other'));
			$this->centralDirectory = array_merge($centralDirectory, $this->centralDirectory);
		}

		@file_put_contents($cache . '_other', serialize(array($this->centralDirectory, $this->oldOffset)));
		@chmod($cache . '_other', 0777);
	}

	// Save as a proper zip file
	function saveAsZip($cache)
	{
		if (!($f = fopen($cache . '_data', 'a+')))
			return false;

		$strlen = 0;

		$f2 = fopen($cache . '_data', 'r');
		while (!feof($f2))
			$strlen += strlen(@fread($f2, 8192));
		fclose($f2);

		if (file_exists($cache . '_other'))
		{
			list ($centralDirectory) = unserialize(@file_get_contents($cache . '_other'));
			$this->centralDirectory = array_merge($centralDirectory, $this->centralDirectory);
		}

		// Finally make it...
		fwrite($f, implode("", $this->centralDirectory));
		fwrite($f, $this->endOfCentralDirectory);
		fwrite($f, pack("v", sizeof($this->centralDirectory)));
		fwrite($f, pack("v", sizeof($this->centralDirectory)));
		fwrite($f, pack("V", strlen(implode("", $this->centralDirectory))));
		fwrite($f, pack("V", $strlen));
		fwrite($f, "\x00\x00");
		fclose($f);
		@unlink($cache . '_other');
	}

	/**
	 * Fucntion to return the zip file
	 *
	 * @return zipfile (archive)
	 */

	function getZippedfile()
	{
		return
			implode('', $this->compressedData) .
			implode('', $this->centralDirectory) .
			$this->endOfCentralDirectory .
			pack("v", sizeof($this->centralDirectory)) .
			pack("v", sizeof($this->centralDirectory)) .
			pack("V", strlen($controlDirectory)) .
			pack("V", strlen($data)) .
			"\x00\x00";
	}
}

// Get the HTML code for a media item
function aeva_embedObject($obj, $id_file, $cur_width = 0, $cur_height = 0, $desc = '', $type = null)
{
	global $galurl, $context, $settings, $amSettings, $modSettings, $cookiename;
	static $swfobjects = 0;

	if (empty($type))
		$type = $obj->media_type();

	$output = '';
	$pcol = !empty($amSettings['player_color']) ? ($amSettings['player_color'][0] == '#' ? substr($amSettings['player_color'], 1) : $amSettings['player_color']) : '';
	$bcol = !empty($context['aeva_override_bcolor']) ? $context['aeva_override_bcolor'] : (!empty($amSettings['player_bcolor']) ? ($amSettings['player_bcolor'][0] == '#' ? substr($amSettings['player_bcolor'], 1) : $amSettings['player_bcolor']) : '');
	$pwid = !empty($context['aeva_override_player_width']) ? $context['aeva_override_player_width'] : (!empty($amSettings['audio_player_width']) ? min($amSettings['max_preview_width'], max(100, (int) $amSettings['audio_player_width'])) : 400);
	$preview_image = $galurl . 'sa=media;in=' . $id_file . (!empty($context['aeva_has_preview']) || $type == 'image' ? ';preview' : ';thumb');
	$show_audio_preview = $type == 'audio' && !empty($_REQUEST['action']) && $_REQUEST['action'] == 'media';
	$increm = $show_audio_preview && !empty($context['aeva_has_preview']) ? '' : ';v';

	if ($show_audio_preview)
		$output .= '
		<div align="center" style="margin: auto; text-align: center; width: ' . max($cur_width, $pwid) . 'px">
		<img src="' . $preview_image . '" alt=""' . ($cur_width > 0 && $cur_height > 0 ? ' width="' . $cur_width . '" height="' . $cur_height . '"' : '') . ' align="middle" style="padding-bottom: 8px" />';

	$ext = aeva_getExt($obj->src);
	if ($type == 'image')
	{
		$output .= '
		' . (!empty($context['aeva_has_preview']) ? '<a href="' . $galurl . 'sa=media;in=' . $id_file . '" title="' . htmlspecialchars($desc) . '"' . ($amSettings['use_lightbox'] ? ' class="hs" onclick="return hs.expand(this, slideOptions);"' : '') . '>' : '')
		. '<img src="' . $preview_image . '" width="' . $cur_width . '" height="' . $cur_height . '" alt="" />'
		. (!empty($context['aeva_has_preview']) ? '</a>' : '');
	}
	elseif ($type == 'doc')
	{
		$width = empty($cur_width) ? 48 : $cur_width;
		$height = empty($cur_height) ? 52 : $cur_height;
		$output .= '
		<a href="' . $galurl . 'sa=media;in=' . $id_file . ';dl" title="' . htmlspecialchars($desc) . '">'
		. '<img src="' . $preview_image . '" width="' . $width . '" height="' . $height . '" alt="" /></a>';
	}
	elseif ($type == 'video' || ($type == 'audio' && in_array($ext, array('mp3', 'm4a', 'm4p', 'a-latm'))))
	{
		$mime = $obj->getMimeType($obj->src);

		$qt = false;
		$width = empty($cur_width) ? 500 : $cur_width;
		$height = empty($cur_height) ? 470 : $cur_height;

		switch ($mime)
		{
			case 'audio/mpeg':
			case 'audio/mp4a-latm':
				// Hopefully getid3 should be able to return durations for all file types...
				$duration = $obj->getInfo();
				$width = $pwid;
				$height = 80;

			case 'video/x-flv':
			case 'video/x-m4v':
			case 'video/mp4':
			case 'video/3gpp':

				if ((isset($_GET['action']) && $_GET['action'] == '.xml') || isset($_GET['xml']) || SMF == 'SSI')
				{
					$output .= '
		<embed src="' . aeva_theme_url('player.swf') . '" flashvars="file=' . $galurl . 'sa=media;in=' . $id_file . $increm
		. (!empty($pcol) ? '&amp;backcolor=' . $pcol : '') . (!empty($bcol) ? '&amp;screencolor=' . $bcol : '')
		. ($show_audio_preview ? '' : 'amp;image=' . $preview_image) . '&amp;type=' . ($type != 'audio' ? $type : 'sound&amp;plugins=spectrumvisualizer-1&amp;showdigits=true&amp;repeat=always&amp;duration='
		. floor($duration['duration'])) . '" width="' . $width . '" height="' . ($height+20) . '" allowscriptaccess="always" allowfullscreen="true" wmode="transparent" />';
				}
				else
				{
					if (!$swfobjects++)
					{
						$scr = "\n\t" . '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.1/swfobject.js"></script>';
						if (ob_get_length() === 0)
							$context['html_headers'] = empty($context['html_headers']) ? $scr : $context['html_headers'] . $scr;
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
							echo substr_replace($temp, $scr . "\n" . '</head>', stripos($temp, '</head>'), 7);
							unset($temp);
						}
					}

					$output .= '
		<div id="sob'. $swfobjects . '">&nbsp;</div>
		<script type="text/javascript"><!-- // --><![CDATA[
			var fvars = { file: "' . $galurl . 'sa=media;in=' . $id_file . $increm . '", ' . (!empty($pcol) ? 'backcolor: "' . $pcol . '", ' : '') . (!empty($bcol) ? 'screencolor: "' . $bcol . '", ' : '')
			. ($show_audio_preview ? '' : 'image: "' . $preview_image . '", ') . 'type: "' . ($type != 'audio' ? $type : 'sound", plugins: "spectrumvisualizer-1", showdigits: true, repeat: "always", duration: "' . floor($duration['duration'])) . '" };
			swfobject.embedSWF("' . aeva_theme_url('player.swf') . '", "sob' . $swfobjects . '", "' . $width . '", "' . ($height+20) . '", "9", "", fvars, { allowFullscreen: "true", allowScriptAccess: "always", wmode: "transparent" });
		// ]]></script>';
				}

				return $show_audio_preview ? $output . '
		</div>' : $output;

			case 'video/quicktime':
				if ($context['browser']['is_ie'] && !$context['browser']['is_mac_ie'])
					$output .= '
		<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" width="' . $width . '" height="' . ($height + 15) . '">
			<param name="src" value="' . $galurl . 'sa=media;in=' . $id_file . ';v" />
			<param name="wmode" value="transparent" />
			<param name="controller" value="true" />
			<param name="autoplay" value="false" />
			<param name="loop" value="false" />';

				$output .='
			<embed src="' . $galurl . 'sa=media;in=' . $id_file . ';v" width="' . $width . '" height="' . ($height + 15) . '" type="' . $mime . '"
				pluginspage="http://www.apple.com/quicktime/download/" controller="true" autoplay="false" loop="false" wmode="transparent" />';

				if ($context['browser']['is_ie'] && !$context['browser']['is_mac_ie'])
					$output .='
		</object>';

				return $output;

			case 'video/mpeg':
			case 'video/x-msvideo':
			case 'video/x-ms-wmv':
				$class_id = 'CLSID:05589FA1-C356-11CE-BF01-00AA0055595A';
				// Stupid Windows Media Player seems to ignore cookies, so we'll force it in...
				if (isset($_COOKIE[$cookiename]))
					$upcook = ';upcook=' . urlencode(base64_encode($_COOKIE[$cookiename]));
			break;
		}

		if (!isset($class_id))
			$class_id = 'CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95';

		if ($context['browser']['is_ie'] && !$context['browser']['is_mac_ie'])
			$output .= '
		<object classid="' . $class_id . '" width="' . $width . '" height="' . $height . '">
			<param name="wmode" value="transparent" />
			<param name="ShowDisplay" value="0" />
			<param name="ShowControls" value="1" />
			<param name="AutoStart" value="0" />
			<param name="AutoRewind" value="-1" />
			<param name="Volume" value="0" />
			<param name="FileName" value="' . $galurl . 'sa=media;in=' . $id_file . ';v" />';

		$output .= '
			<embed src="' . $galurl . 'sa=media;in=' . $id_file . ';v' . (isset($upcook) ? $upcook : '')
			. '" width="' . $width . '" height="' . ($height+42) . '" type="' . $mime . '" controller="true" autoplay="false" autostart="0" loop="false" wmode="transparent" />';

		if ($context['browser']['is_ie'] && !$context['browser']['is_mac_ie'])
			$output .= '
		</object>';
	}
	elseif ($type == 'audio')
	{
		// Audio, but no mp3..............

		if ($ext == 'ogg')
			$output .= '
		<audio src="' . $galurl . 'sa=media;in=' . $id_file . ';v" width="' . $pwid . '" height="50" controls="controls">
			<object style="border: 1px solid #999" type="application/ogg" data="' . $galurl . 'sa=media;in=' . $id_file . ';v" width="' . $pwid . '" height="50">
				<param name="wmode" value="transparent" />
			</object>
		</audio>';
		else
			$output .= '
		<audio src="' . $galurl . 'sa=media;in=' . $id_file . ';v" width="' . $pwid . '" height="50" controls="controls">
			<embed src="' . $galurl . 'sa=media;in=' . $id_file . ';v' . (isset($_COOKIE[$cookiename]) ? ';upcook=' . urlencode(base64_encode($_COOKIE[$cookiename])) : '')
			. '" width="' . $pwid . '" height="50" autoplay="false" autostart="0" loop="true" wmode="transparent" />
		</audio>';

		$output .= '
		</div>';
	}
	return $output;
}

function aeva_initLightbox($autosize, $peralbum = array())
{
	global $txt;

	$not_single = empty($peralbum) ? 'true' : 'false';
	$fadein = empty($peralbum) || !empty($peralbum['fadeinout']) ? 'true' : 'false';
	$r = '
	<script type="text/javascript" src="' . aeva_theme_url('highslide-2.js') . '"></script>
	<script type="text/javascript"><!-- // --><![CDATA[
		function hss(aId, aSelf)
		{
			var aUrl = aSelf.href;
			var ah = document.getElementById(\'hsm\' + aId);
			hs.close(ah);
			hs.expanders[hs.getWrapperKey(ah)] = null;
			ah.href = aUrl;
			hs.expand(ah);
			return false;
		}' . "\n";

	$r .= empty($peralbum) ? '
		hs.Expander.prototype.onInit = function()
		{
			for (var i = 0, j = this.a.attributes, k = j.length; i < k; i++)
			{
				if (j[i].value.indexOf(\'htmlExpand\') != -1)
				{
					getXMLDocument(\'index.php?action=media;sa=addview;in=\' + this.a.id.substr(3), function() {});
					return;
				}
			}
		}

		var slideOptions = { slideshowGroup: \'aeva\', align: \'center\', transitions: [\'expand\', \'crossfade\'], fadeInOut: ' . $fadein . ' };
		var mediaOptions = { slideshowGroup: \'aeva\', align: \'center\', transitions: [\'expand\', \'crossfade\'], fadeInOut: ' . $fadein . ', width: 1 };' : '
		var slideOptions = { align: \'center\', transitions: [\'expand\', \'crossfade\'], fadeInOut: ' . $fadein . ' };';

	$r .= '

		if (hs.addSlideshow) hs.addSlideshow({
			slideshowGroup: \'aeva\',
			interval: 5000,
			repeat: false,
			useControls: true,
			fixedControls: \'fit\',
			overlayOptions: {
				opacity: .66,
				position: \'bottom center\',
				hideOnMouseOut: true
			}
		});

		hs.lang = {
			moveText: \'' . $txt['aeva_hs_move'] . '\',
			closeText: \'' . $txt['aeva_close'] . '\',
			closeTitle: \'' . $txt['aeva_hs_close_title'] . '\',
			loadingText: \'' . $txt['aeva_hs_loading'] . '\',
			loadingTitle: \'' . $txt['aeva_hs_clicktocancel'] . '\',
			restoreTitle: \'' . $txt['aeva_hs_clicktoclose'] . '\',
			focusTitle: \'' . $txt['aeva_hs_focus'] . '\',
			fullExpandTitle: \'' . $txt['aeva_hs_expandtoactual'] . '\',
			previousTitle: \'' . $txt['aeva_hs_previous'] . '\',
			nextTitle: \'' . $txt['aeva_hs_next'] . '\',
			playTitle: \'' . $txt['aeva_hs_play'] . '\',
			pauseTitle: \'' . $txt['aeva_hs_pause'] . '\'
		};' . ($autosize ? '' : '
		hs.allowSizeReduction = false;') . (empty($peralbum) || $peralbum['outline'] == 'rounded-white' ? '
		hs.outlineType = \'rounded-white\';' : '') . '
		hs.numberOfImagesToPreload = 0;
		hs.graphicsDir = \'' . aeva_theme_url('hs/') . '\';';

	if (empty($peralbum))
		return $r . '

	// ]]></script>';

	return $r . ($peralbum['outline'] == 'drop-shadow' ? '' : '
		hs.outlineType = \'' . $peralbum['outline'] . '\';') . ($peralbum['autosize'] == 'yes' ? '' : '
		hs.allowSizeReduction = false;') . (!isset($peralbum['expand']) || $peralbum['expand'] == 250 ? '' : '
		hs.expandDuration = ' . $peralbum['expand'] . ';
		hs.restoreDuration = ' . $peralbum['expand'] . ';') . '

	// ]]></script>' . ($peralbum['outline'] == 'rounded-white' || !empty($peralbum['fadeinout']) ? '
	<style type="text/css">' . ($peralbum['outline'] == 'rounded-white' ? '
		.hs img { border: 2px solid gray }
		.hs:hover img, .highslide-image { border: 2px solid white }
		.highslide-wrapper .highslide-html-content { padding: 0 5px 5px 5px }' : '') . (!empty($peralbum['fadeinout']) ? '
		.highslide-active-anchor img { visibility: visible }' : '') . '
	</style>' : '');
}

// Gets an encrypted filename
// Derived from getAttachmentFilename function in Subs.php
// It's not much of a strong encryption though... Since it's a md5 string based on a string
// that appears in clear right before it... Uh. Is that really useful at this point?
function aeva_getEncryptedFilename($name, $id, $check_for_encrypted = false, $both = false)
{
	global $amSettings;

	if ($id < 5)
		return $both ? array($name, $name) : $name;

	// Remove special accented characters - eg. sí.
	$clean_name = strtr($name, 'ŠŽšžŸÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïñòóôõöøùúûüýÿ', 'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy');
	$clean_name = strtr($clean_name, array('Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss', 'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u'));

	// Sorry, no spaces, dots, or anything else but letters allowed.
	$clean_name = preg_replace(array('/\s/', '/[^\w_\.-]/'), array('_', ''), $clean_name);
	$ext = aeva_getExt($name);
	$enc_name = $id . '_' . strtr($clean_name, '.', '_') . md5($clean_name) . '_ext' . $ext;
	$clean_name = substr(sha1($id), 0, 2) . sha1($id . $clean_name) . '.' . $ext;

	return $both ? array($clean_name, $enc_name) : (!$check_for_encrypted || empty($amSettings['clear_thumbnames']) ? $enc_name : $clean_name);
}

// Returns a php.ini size limit, in bytes
function aeva_getPHPSize($size)
{
	if (preg_match('/^([\d\.]+)([gmk])?$/i', @ini_get($size), $m))
	{
		$value = $m[1];
		if (isset($m[2]))
		{
			switch(strtolower($m[2]))
			{
				case 'g': $value *= 1024;
				case 'm': $value *= 1024;
				case 'k': $value *= 1024;
			}
		}
	}
	return isset($value) ? $value : 0;
}

if (!function_exists('str_ireplace'))
{
	function str_ireplace($search, $replace, $subject)
	{
		global $context;
		$endu = '~i' . ($context['utf8'] ? 'u' : '');
		if (is_array($search))
			foreach (array_keys($search) as $pat)
				$search[$pat] = '~' . preg_quote($search[$pat], '~') . $endu;
		else
			$search = '~' . preg_quote($search, '~') . $endu;
		return preg_replace($search, $replace, $subject);
	}
}

if (!function_exists('array_diff_key'))
{
	function array_diff_key()
	{
		$args = func_get_args();
		return array_flip(call_user_func_array('array_diff', array_map('array_flip', $args)));
	}
}

function aeva_getTags($taglist)
{
	return aeva_splitTags(str_replace('&quot;', '"', $taglist));
}

function aeva_splitTags($string, $separator = ',')
{
	global $amFunc;

	$elements = explode($separator, $string);
	for ($i = 0; $i < count($elements); $i++)
	{
		$nquotes = substr_count($elements[$i], '"');
		if ($nquotes % 2 == 1)
			for ($j = $i+1; $j < count($elements); $j++)
				if (substr_count($elements[$j], '"') % 2 == 1)
				{
					array_splice($elements, $i, $j-$i+1, implode($separator, array_slice($elements, $i, $j-$i+1)));
					break;
				}
		if ($nquotes > 0)
			$elements[$i] = str_replace('""', '"', $elements[$i]);
		$elements[$i] = $amFunc['htmlspecialchars'](trim($elements[$i], '" '));
	}
	return $elements;
}

function aeva_closeTags(&$str, $hard_limit)
{
	// Could be made faster with substr_count() but wouldn't always validate.
	if (!preg_match_all('~<([^/\s>]+)(?:>|[^>]*?[^/]>)~', $str, $m) || empty($m[1]))
		return;

	$mo = $m[1];
	preg_match_all('~</([^>]+)~', $str, $m);
	$mc = $m[1];
	$ct = array();
	if (count($mo) > count($mc))
	{
		foreach ($mc as $tag)
			$ct[$tag] = isset($ct[$tag]) ? $ct[$tag] + 1 : 1;
		foreach (array_reverse($mo) as $tag)
		{
			if (empty($ct[$tag]) || !($ct[$tag]--))
			{
				// If we're not limited in size, close the tag, otherwise just give up and strip all tags.
				if (!$hard_limit || strlen($str . $tag) + 3 <= $hard_limit)
					$str .= '</' . $tag . '>';
				else
				{
					$str = strip_tags($str);
					return;
				}
			}
		}
	}
}

function aeva_cutString($string, $max_length = 255, $check_multibyte = true, $cut_long_words = true, $ellipsis = true, $preparse = false, $hard_limit = 0)
{
	global $entities, $replace_counter, $amFunc, $context;

	if (empty($string))
		return $ellipsis ? '&hellip;' : '';
	if (!$check_multibyte)
		return rtrim(preg_replace('/&#?\w*$/', '', substr($string, 0, $max_length))) . ($ellipsis && strlen($string) > $max_length ? '&hellip;' : '');
	if ($preparse)
		$string = $amFunc['parse_bbc']($string);
	$work = preg_replace('/(?:&[^&;]+;|<[^>]+>)/', chr(20), $string);
	$strlen = function_exists('mb_strlen') ? 'mb_strlen' : 'strlen';
	$substr = function_exists('mb_substr') ? 'mb_substr' : 'substr';
	if ($strlen($work) <= $max_length && (empty($hard_limit) || strlen($string) <= $hard_limit))
		return $string;
	preg_match_all("/(?:\x14|&[^&;]+;|<[^>]+>)/", $string, $entities);
	$work = rtrim($substr($work, 0, $max_length)) . ($ellipsis && $strlen($work) > $max_length ? '&hellip;' : '');
	if ($cut_long_words)
	{
		$cw = is_integer($cut_long_words) ? round($cut_long_words/2) + 1 : round($max_length/3) + 1;
		$work = preg_replace('/(\w{'.$cw.'})(\w+)/' . ($context['utf8'] ? 'u' : ''), '$1&shy;$2', $work);
	}
	$replace_counter = 0;
	$work = preg_replace_callback("/\x14/", 'aeva_restoreEntities', $work);
	// Make sure to close any opened tags after preparsing the string...
	if (strpos($work, '<') !== false)
		aeva_closeTags($work, $hard_limit);
	return $hard_limit && strlen($work) > $hard_limit ? rtrim(preg_replace('/&#?\w*$/', '', substr($work, 0, $hard_limit))) : $work;
}

function aeva_restoreEntities($match)
{
	global $entities, $replace_counter;
	return $entities[0][$replace_counter++];
}

function aeva_is_utf8(&$string)
{
	return preg_match('/^(?:[\x09\x0A\x0D\x20-\x7E]|[\xC2-\xDF][\x80-\xBF]|\xE0[\xA0-\xBF][\x80-\xBF]|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}|\xED[\x80-\x9F][\x80-\xBF]|\xF0[\x90-\xBF][\x80-\xBF]{2}|[\xF1-\xF3][\x80-\xBF]{3}|\xF4[\x80-\x8F][\x80-\xBF]{2})*$/', $string);
}

function aeva_utf2entities($source, $is_file = true, $limit = 255, $is_utf = false, $ellipsis = true, $check_multibyte = false, $cut_long_words = false, $hard_limit = 0)
{
	global $context, $amSettings, $modSettings;

	if (isset($modSettings['aeva_enable']) && function_exists('aeva_onposting'))
		$source = aeva_onposting($source);

	$do = empty($amSettings['entities_convert']) ? 0 : $amSettings['entities_convert'];
	$is_utf |= $do == 2 ? false : aeva_is_utf8($source);
	$str = ($do == 1 && $context['utf8'] && $is_utf) || ($do == 2) || !$is_utf ? $source : (function_exists('mb_encode_numericentity') ?
				mb_encode_numericentity($source, array(0x80, 0x2ffff, 0, 0xffff), 'UTF-8') : aeva_utf2entities_internal($source));
	$strlen = function_exists('mb_strlen') ? 'mb_strlen' : 'strlen';
	if ($limit == 0 || ($strlen($str) <= $limit && (!$hard_limit || strlen($str) <= $hard_limit)))
	{
		if ($cut_long_words)
		{
			$cw = is_integer($cut_long_words) ? round($cut_long_words/2) + 1 : round($limit/3) + 1;
			$str = preg_replace('/(\w{'.$cw.'})(\w+)/' . ($context['utf8'] ? 'u' : ''), '$1&shy;$2', $str);
		}
		return $str;
	}

	$ext = $is_file ? strrchr($str, '.') : '';
	$base = !empty($ext) ? substr($str, 0, -strlen($ext)) : $str;
	return aeva_cutString($base, $limit, $check_multibyte, $cut_long_words, $ellipsis, false, $hard_limit) . $ext;
}

function aeva_entities2utf($mixed)
{
	if (function_exists('mb_decode_numericentity'))
		return mb_decode_numericentity($mixed, array(0x80, 0x2ffff, 0, 0xffff), 'UTF-8');

	$mixed = preg_replace('/&#(\d+);/me', 'aeva_utf8_chr($1)', $mixed);
	$mixed = preg_replace('/&#x(\d+);/me', 'aeva_utf8_chr(0x$1)', $mixed);
	return $mixed;
}

function aeva_utf2entities_internal($source)
{
	$decrement = array(4 => 240, 3 => 224, 2 => 192, 1 => 0);
	$shift = array(1 => array(0 => 0), 2 => array(0 => 6, 1 => 0), 3 => array(0 => 12, 1 => 6, 2 => 0), 4 => array(0 => 18, 1 => 12, 2 => 6, 3 => 0));
	$pos = 0;
	$len = strlen($source);
	$encodedString = '';
	while ($pos < $len)
	{
		$charPos = substr($source, $pos, 1);
		$asciiPos = ord($charPos);
		if ($asciiPos < 128)
		{
			$encodedString .= htmlentities($charPos);
			$pos++;
			continue;
		}
		$i = ($asciiPos >= 240) && ($asciiPos <= 255) ? 4 : ((($asciiPos >= 224) && ($asciiPos <= 239)) ? 3 : ((($asciiPos >= 192) && ($asciiPos <= 223)) ? 2 : 1));
		$thisLetter = substr($source, $pos, $i);
		$pos += $i;
		$thisLen = strlen($thisLetter);
		$thisPos = 0;
		$decimalCode = 0;
		while ($thisPos < $thisLen)
		{
			$thisCharOrd = ord(substr($thisLetter, $thisPos, 1));
			$charNum = intval($thisCharOrd - ($thisPos == 0 ? $decrement[$thisLen] : 128));
			$decimalCode += ($charNum << $shift[$thisLen][$thisPos]);
			$thisPos++;
		}
		$encodedString .= strlen($encodedString.'&#'.$decimalCode.';') <= 255 ? '&#'.$decimalCode.';' : '';
	}
	return $encodedString;
}

function aeva_utf8_chr($code)
{
	if ($code<128) return chr($code);
	elseif ($code<2048) return chr(($code>>6)+192).chr(($code&63)+128);
	elseif ($code<65536) return chr(($code>>12)+224).chr((($code>>6)&63)+128).chr(($code&63)+128);
	elseif ($code<2097152) return chr($code>>18+240).chr((($code>>12)&63)+128).chr(($code>>6)&63+128).chr($code&63+128);
}

?>