<?php
/****************************************************************
* Aeva Media													*
* © Noisen.com & SMF-Media.com									*
*****************************************************************
* MGalleryItem.php - media embedder for outgoing links			*
*****************************************************************
* Users of this software are bound by the terms of the			*
* Aeva Media license. You can view it in the license_am.txt		*
* file, or online at http://noisen.com/license.php				*
*																*
* Support and updates for this software can be found at			*
* http://aeva.noisen.com and http://smf-media.com				*
****************************************************************/

if (file_exists(dirname(__FILE__).'/SSI.php'))
	require_once(dirname(__FILE__).'/SSI.php');
else
	die('SSI.php wasn\'t found');

if (!isset($_REQUEST['id']) && !isset($_REQUEST['in']))
	die('Hacking attempt...');

global $settings, $amFunc, $context, $sourcedir;

require_once($sourcedir . '/Aeva-Subs.php');

aeva_loadSettings();

// Banned?
aeva_is_not_banned();

// Get the file's data
$id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : (int) $_REQUEST['in'];
$type = isset($_REQUEST['thumb']) ? 'thumb' : (isset($_REQUEST['preview']) ? 'preview' : 'main');

if (!aeva_allowedTo('access'))
{
	$path = $settings['theme_dir'] . '/images/aeva/denied.png';
	$filename = 'denied.png';
	$is_new = false;
}
else
	list($path, $filename, $is_new) = aeva_getMediaPath($id, $type);

if (!$path)
{
	header('HTTP/1.0 404 Not Found');
	die('Error! File not found');
}

$media = new aeva_media_handler;
$media->init($path);
$mime = $media->getMimeType();
$media->close();

while (@ob_end_clean());

// Send it
header('Pragma: ');
if (!$context['browser']['is_gecko'])
	header('Content-Transfer-Encoding: binary');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 525600 * 60) . ' GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
header('Accept-Ranges: bytes');
header('Content-Length: ' . filesize($path));
header('Content-Encoding: none');
header('Content-Type: '.$mime);
header('Content-Disposition: inline; filename='.$filename);

// If the file is over 1.5MB, readfile() may have some issues.
if (filesize($path) > 1572864 || @readfile($path) == null)
{
	if ($file = fopen($path, 'rb'))
	{
		while (!feof($file))
		{
			echo @fread($file, 8192);
			flush();
		}
		@fclose($file);
	}
	else
		die('Something went wrong...');
}

if ($is_new && aeva_markSeen($id))
{
	global $user_info;
	aeva_resetUnseen($user_info['id']);
}

// Update item views
$amFunc['db_query']('
	UPDATE {db_prefix}aeva_media
	SET views = views + 1
	WHERE id_media = {int:media}',
	array('media' => $id),__FILE__,__LINE__);

// Nothing more to come
die;

?>