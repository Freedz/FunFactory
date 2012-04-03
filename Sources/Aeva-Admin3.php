<?php
/****************************************************************
* Aeva Media													*
* � Noisen.com													*
*****************************************************************
* Aeva-Admin3.php - admin area for the auto-embedder			*
*****************************************************************
* Users of this software are bound by the terms of the			*
* Aeva Media license. You can view it in the license_am.txt		*
* file, or online at http://noisen.com/license.php				*
*																*
* Support and updates for this software can be found at			*
* http://aeva.noisen.com and http://smf-media.com				*
****************************************************************/

// Prevent attempts to access this file directly
if (!defined('SMF'))
	die('Hacking attempt...');

// Handles the admin pages
function aeva_admin_embed()
{
	global $amFunc, $context, $scripturl, $txt, $modSettings, $sourcedir;

	// Our sub-template
	$context['sub_template'] = 'aeva_form';
	$context['template_layers'][] = 'aeva_admin_enclose_table';

	$context['current_area'] = isset($_REQUEST['sa']) && $_REQUEST['sa'] == 'sites' ? 'sites' : 'config';

	$is_sites = isset($_REQUEST['sa']) && $_REQUEST['sa'] == 'sites';

	// Increase timeout limit - Reading and writing files may take a little time
	@set_time_limit(600);

	// Test whether lookups work - don't let it run more than once every day, except if we add ;flt (force lookup test) in the URL
	if (!isset($modSettings['aeva_lookup_result']) || ((time() - 24*3600) >= @$modSettings['aeva_lookup_test']) || isset($_GET['flt']))
	{
		// We need to access Aeva's aeva_fetch function to grab url files
		require_once($sourcedir . '/Aeva-Embed.php');

		// Unlikely, but we might need more umph.
		@ini_set('memory_limit', '64M');

		// Domo arigato, misutaa Robotto
		$url = 'http://www.google.com/robots.txt';

		// Fetch the file... Now or never.
		$data = @aeva_fetch($url, true);

		// If we got nothin', try a last time on Noisen...
		if (empty($data) || strlen($data) < 50)
			$data = @aeva_fetch('http://noisen.com/external.gif');

		// Result? If it's empty or too short, then lookups won't work :(
		$modSettings['aeva_lookup_result'] = $test = empty($data) || strlen($data) < 50 ? 0 : 1;

		// Save the result so we don't need to run this again.
		$results = array('aeva_lookup_test' => time(), 'aeva_lookup_result' => $test);
		if (!isset($modSettings['aeva_lookups']))
			$results['aeva_lookups'] = (int) $modSettings['aeva_lookup_result'];
		updateSettings($results);

		$test = $txt['aeva_lookup_' . (empty($test) ? 'fail' : 'success')];
	}
	else
		$test = $txt['aeva_lookup_' . (empty($modSettings['aeva_lookup_result']) ? 'fail' : 'success')];

	$test = $txt['aeva_lookups_desc'] . '<br /><span style="font-weight: bold; color: ' . (empty($modSettings['aeva_lookup_result']) ? 'red' : 'green') . '">' . $test . '</span>';

	$settings = array(
		'aeva_enable'			=> array('yesno', 'config'),
		'aeva_admin_labels_embed' => array('title', 'config'),
		'hr1'					=> array('hr', 'config'),
		'aeva_lookups'			=> array('yesno', 'config', 'subtext' => $test, 'disabled' => $modSettings['aeva_lookup_result'] ? 0 : 1),
		'aeva_yq'				=> array('select', 'config', array(&$txt['aeva_yq_default'], &$txt['aeva_yq_hd'])),
		'hr2'					=> array('hr', 'config'),
		'aeva_titles'			=> array('select', 'config', array(&$txt['aeva_titles_yes'], &$txt['aeva_titles_yes2'], &$txt['aeva_titles_no'], &$txt['aeva_titles_no2'])),
		'aeva_lookup_titles'	=> array('yesno', 'config'),
		'aeva_inlinetitles'		=> array('select', 'config', array(&$txt['aeva_inlinetitles_yes'], &$txt['aeva_inlinetitles_maybe'], &$txt['aeva_inlinetitles_no'])),
		'hr3'					=> array('hr', 'config'),
		'aeva_center'			=> array('yesno', 'config'),
		'aeva_incontext'		=> array('yesno', 'config'),
		'aeva_quotes'			=> array('yesno', 'config'),
		'aeva_fix_html'			=> array('yesno', 'config'),
		'aeva_includeurl'		=> array('yesno', 'config'),
		'hr4'					=> array('hr', 'config'),
		'aeva_noscript'			=> array('yesno', 'config'),
		'aeva_expins'			=> array('yesno', 'config'),
		'aeva_debug'			=> array('yesno', 'config'),
		'hr5'					=> array('hr', 'config'),
		'aeva_max_width'		=> array('small_text', 'config', null, null, $txt['aeva_pixels']),
		'aeva_max_per_post'		=> array('small_text', 'config', null, null, $txt['aeva_lower_items']),
		'aeva_max_per_page'		=> array('small_text', 'config', null, null, $txt['aeva_lower_items']),
		'aeva_local'			=> array('title', 'config'),
		'aeva_nonlocal'			=> array('yesno', 'config'),
		'aeva_ext'				=> array('checkbox_line', 'config', array(), true),
	);

	foreach (array('mp3','mp4','flv','avi','divx','mov','wmp','real','swf') as $ext)
		$settings['aeva_ext'][2]['aeva_' . $ext] = array($txt['aeva_' . $ext], !empty($modSettings['aeva_' . $ext]), 'force_name' => 'aeva_' . $ext);

	// Clear sites that may have already been loaded (possibly for news and such)
	$sites = array();

	// Avoid errors - we'll use full in an emergency
	$definitions = 'full';

	// Attempt to load enabled sites
	if (file_exists($sourcedir . '/Subs-Aeva-Generated-Sites.php'))
		rename($sourcedir . '/Subs-Aeva-Generated-Sites.php', $sourcedir . '/Aeva-Sites.php');
	if (file_exists($sourcedir . '/Aeva-Sites.php'))
		include($sourcedir . '/Aeva-Sites.php');

	// Site definitions
	if (empty($sites))
		$definitions = 'full';
	elseif ($sites[0] == 'none')
	{
		// No enabled sites
		$definitions = 'none';
		$enabled_sites = array();
	}
	else
	{
		// Generated set means that we have an optimized array with only the enabled sites in it
		$definitions = 'generated';

		// Only count as enabled, sites with an actual ID
		foreach (array_keys($sites) as $site)
			if (!empty($sites[$site]['id']))
				$enabled_sites[$sites[$site]['id']] = 1;
	}

	// Clear static
	$sites = array();

	// Load the FULL definitions into the $sites static
	@include($sourcedir . '/Subs-Aeva-Sites.php');

	// Checkall helps us decide whether to make the checkboxes all checked="checked"
	$checkall = array('pop' => true, 'video' => true, 'audio' => true, 'adult' => true, 'other' => true);
	// Create arrays to store bits of information/organize them into various sections
	$stypes = array('local', 'pop', 'video', 'audio', 'adult', 'other');

	if (file_exists($sourcedir . '/Aeva-Sites-Custom.php'))
	{
		@include($sourcedir . '/Aeva-Sites-Custom.php');
		$checkall['custom'] = true;
		$stypes[] = 'custom';
	}

	$sitelist = array();
	foreach ($stypes as $stype)
		$sitelist[$stype] = array();

	// Prepare to organize the sites into specific sections
	foreach (array_keys($sites) as $site)
	{
		$s = &$sites[$site];

		// Make sure it has the enabled setting
		$s['disabled'] = !empty($s['disabled']);

		// Override the default setting, based on which sites are enabled
		if ($definitions == 'generated')
			$s['disabled'] = empty($enabled_sites[$s['id']]);
		elseif ($definitions == 'none')
			$s['disabled'] = true;

		// Checkall - whether the checkall setting for each section is checked. It won't be if just one is unchecked.
		if ($s['disabled'])
			$checkall[$s['type']] = false;

		// Store in arrays organized for different types of supported sites
		// We only need the local ones on saving
		if (isset($s['type'], $sitelist[$s['type']]) && ($s['type'] != 'local' || isset($_POST['submit_aeva'])))
			$sitelist[$s['type']][] = $s;
	}

	// Clear static
	$sites = array();

	// Submitting?
	if (isset($_POST['submit_aeva']))
	{
		// Prepare/optimize the arrays for the generated file by removing disabled sites and unneeded details
		$wsites = array();
		foreach ($stypes as $stype)
		{
			if (!empty($sitelist[$stype]))
			{
				$checkall[$stype] = true;
				$wsites[$stype] = aeva_prepare_sites($sitelist[$stype], $stype, $is_sites, $checkall[$stype]);
			}
		}
		unset($sitelist['local']);

		// Writes/outputs a php file of all the ENABLED sites only
		aeva_write_file($wsites);
		unset($wsites);

		if (!$is_sites)
		{
			// These need to be within limits, and max per page >= max per post
			if (isset($_POST['aeva_max_per_page']))
			{
				$_POST['aeva_max_per_page'] = min(1000, max(1, (int) $_POST['aeva_max_per_page']));
				$_POST['aeva_max_per_post'] = min(min(1000, max(1, (int) $_POST['aeva_max_per_post'])), $_POST['aeva_max_per_page']);
			}
			$hsc = isset($amFunc['htmlspecialchars']) ? $amFunc['htmlspecialchars'] : 'htmlspecialchars';

			foreach ($settings as $setting => $options)
			{
				// Skip if we're not in the right page...
				if ($options[1] != $context['current_area'])
					continue;
				if ($options[0] != 'title' && isset($_POST[$setting]))
					$new_value = is_array($_POST[$setting]) ? $_POST[$setting] : $hsc($_POST[$setting]);
				elseif ($options[0] == 'checkbox' && !isset($_POST[$setting]))
					$new_value = 0;
				elseif ($options[0] !== 'checkbox_line')
					continue;

				if (!empty($options[2]) && is_array($options[2]) && !in_array($options[0], array('radio', 'select')))
				{
					foreach ($options[2] as $sub_setting => $dummy)
					{
						updateSettings(array($sub_setting => isset($_POST[$sub_setting]) ? 1 : 0));
						$settings[$setting][2][$sub_setting][1] = !empty($modSettings[$sub_setting]);
					}
				}
				else
					updateSettings(array($setting => $new_value));
			}
		}
	}

	if ($is_sites)
		$warning_message =
			'<span style="font-weight: normal; color: ' . (empty($modSettings['aeva_lookup_result']) ? 'red' : 'green') .
			'" class="smalltext">' . $txt['aeva_' . (empty($modSettings['aeva_lookup_result']) ? 'fish' : 'denotes')] . '</span>';

	foreach ($stypes as $stype)
		if ($is_sites && !empty($sitelist[$stype]))
			aeva_settings($settings, $sitelist[$stype], $stype, $checkall);

	// Only show the MASTER setting, if it's disabled
	if (empty($modSettings['aeva_enable']))
	{
		$settings = array(
			'aeva_title'	=> array('title', $context['current_area']),
			'aeva_enable'	=> array('yesno', $context['current_area']),
		);
	}

	// Render the form
	$context['aeva_form_url'] = $scripturl.'?action=admin;area=aeva_embed;sa='.$context['current_area'].';'.$context['session_var'].'='.$context['session_id'];
	if (!empty($warning_message))
		$context['aeva_form']['warning'] = array('type' => 'info', 'label' => '', 'fieldname' => 'info', 'value' => $warning_message, 'options' => array(), 'multi' => false, 'next' => null, 'subtext' => '', 'skip_left' => true);

	foreach ($settings as $setting => $options)
	{
		if ($options[1] != $context['current_area'])
			continue;

		// Options
		if (!empty($options[2]))
			foreach ($options[2] as $k => $v)
				if (isset($modSettings[$setting]) && $modSettings[$setting] == $k)
					$options[2][$k] = array($v, true);

		$context['aeva_form'][$setting] = array(
			'type' => $options[0],
			'label' => !isset($options['force_title']) ? (isset($txt[$setting]) ? $txt[$setting] : '') : $options['force_title'],
			'fieldname' => $setting,
			'value' => isset($modSettings[$setting]) ? $modSettings[$setting] : '',
			'options' => !empty($options[2]) ? $options[2] : array(),
			'multi' => !empty($options[3]) && $options[3] == true,
			'next' => !empty($options[4]) ? ' ' . $options[4] : null,
			'subtext' => isset($options['subtext']) ? $options['subtext'] : (isset($txt[$setting.'_desc']) ? $txt[$setting.'_desc'] : ''),
			'disabled' => !empty($options['disabled']),
			'skip_left' => !empty($options['skip_left']),
		);
	}
}

// Removes disabled sites, and removes information we won't need.
function aeva_prepare_sites(&$original_array, $type, $is_sites, &$checkall)
{
	global $modSettings;

	if ($is_sites && $type != 'local' && (empty($_POST['aeva_'.$type]) || !is_array($_POST['aeva_'.$type])))
	{
		$checkall = false;
		return array();
	}

	// Unset our KNOWN unnecessary information - this way it won't interfere with future variables, upgrading, or any custom variables you decide to use.

	// These are NEVER needed
	$fields = array('title', 'website', 'type', 'disabled', 'added');

	// Lookups are disabled, so get rid of all unnecessary information
	if ($type != 'local' && ($is_sites ? empty($modSettings['aeva_lookups']) : empty($_POST['aeva_lookups'])))
		$fields = array_merge($fields, array(
			'lookup-url', 'lookup-title', 'lookup-title-skip', 'lookup-pattern', 'lookup-actual-url',
			'lookup-final-url', 'lookup-unencode', 'lookup-urldecode', 'lookup-skip-empty')
		);

	// If fixing embed html is disabled, add that to the fields to drop (is likely to be bandwidth saving with this one)
	if ($type != 'local' && ($is_sites ? empty($modSettings['aeva_fix_html']) : empty($_POST['aeva_fix_html'])))
		$fields = array_merge($fields, array('fix-html-pattern', 'fix-html-url'));

	// Unset video sites from arrays which are disabled
	$array = $original_array;
	foreach ($array as $a => $b)
	{
		if ($type == 'local')
		{
			// No plugin, then it can't be a local one, so unset it
			if (empty($b['plugin']))
				unset($array[$a], $b);
			// Don't save data if box was unchecked or option was disabled
			elseif ($is_sites ? empty($modSettings['aeva_' . substr($b['id'], 6)]) : !isset($_POST['aeva_' . substr($b['id'], 6)]))
				unset($array[$a], $b);
		}
		// Site disabled? Skip it
		elseif ($is_sites ? !isset($_POST['aeva_' . $type][$b['id']]) : $b['disabled'])
			unset($array[$a], $b);
		elseif (isset($b['plugin']) && $b['plugin'] == 'flash')
			unset($array[$a]['plugin']);

		// Drop each one of those fields from our array if it exists
		if (!empty($b))
			foreach ($fields as $c)
				unset($array[$a][$c]);

		if (isset($array[$a]['lookup-title']) && ($is_sites ? !empty($modSettings['aeva_titles']) : !empty($_POST['aeva_titles']))
		&& (empty($array[$a]['lookup-title-skip']) || (!empty($modSettings['aeva_titles']) && ($modSettings['aeva_titles'] % 2 == 1))))
			unset($array[$a]['lookup-title']);

		$checkall &= !($original_array[$a]['disabled'] = empty($array[$a]));
	}
	unset($_POST['aeva_' . $type]);

	return $array;
}

// Generates the file containing optimized arrays (ONLY enabled sites with only necessary information
function aeva_write_file($arrays)
{
	global $sourcedir;

	// Filename
	$filename = $sourcedir . '/Aeva-Sites.php';

	// Chmod - suppress errors, especially for Windows
	@chmod($filename, 0777);

	// Open file for writing (replacing what's there)
	$fp = fopen($filename, 'w');

	// Comment header - left-justified
	$page = '<' . '?php
/********************************************************************************
* Aeva-Sites.php
* By Rene-Gilles Deberdt
*********************************************************************************
* The full/complete definitions are stored in Subs-Aeva-Sites.php
* This is a GENERATED php file containing ONLY ENABLED sites for Aeva Media,
* and is created when enabling/disabling sites via the admin panel.
* It\'s more efficient this way.
*********************************************************************************
* This program is distributed in the hope that it is and will be useful, but
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY
* or FITNESS FOR A PARTICULAR PURPOSE.
********************************************************************************/

';

	// If no sites are enabled, then exit early
	if (count($arrays) == count($arrays, COUNT_RECURSIVE))
	{
		// Last piece, and close the file early
		$page .= 'global $sites;
$sites = array(\'none\');
				/* No Sites Are Enabled */
?' . '>';
		fwrite($fp, $page);
		fclose($fp);
		return;
	}

	// Ok we've got some enabled sites to output, start the array
	$page .= 'global $sites;
$sites = array(';
	fwrite($fp, $page);

	foreach ($arrays as $one_array)
		if (!empty($one_array))
			fwrite($fp, aeva_generate_sites($one_array));

	// Last piece, and close the file
	$page = '
);
?' . '>';
	fwrite($fp, $page);
	fclose($fp);
}

// Returns a string with the sites in array - ONLY necessary pieces are included for optimized/effiency
function aeva_generate_sites(&$array)
{
	$page = '';
	foreach ($array as $a)
	{
		$page .= '
	array(';

		// Bools show as bools, the rest shows in single quotes. (Re-adding them because PHP stripped them.)
		foreach ($a as $b => $c)
			if (isset($c) && $c !== '')
				if (is_array($c) && $b == 'size')
				{
					$page .= "
		'$b' => array(";
					if (isset($c['normal']))
					{
						foreach ($c as $d => $e)
							$page .= "'$d' => array(" . $e[0] . ', ' . $e[1] . '), ';
						$page = substr($page, 0, -2) . '),';
					}
					else
						$page .= implode($c, ', ') . '),';
				}
				elseif (is_array($c))
				{
					$page .= "
		'$b' => array(";
					foreach ($c as $d => $e)
						$page .= "'$d' => " . (is_int($e) ? $e . ', ' : "'" . str_replace("'", "\'", $e) . "', ");
					$page = substr($page, 0, -2) . '),';
				}
				else
					$page .= "
		'$b' => " . ($b == 'ui-height' ? (int) $c : (is_bool($c) || is_int($c) ? ($c == true ? 'true' : 'false') : "'" . str_replace('\'', '\\\'', $c) . "'")) . ",";

		$page .= '
	),';
	}
	return $page;
}

// Fills the admin settings for each type of site
function aeva_settings(&$dest, &$array, $type, $checkall)
{
	global $txt, $modSettings, $settings;

	$dest['aeva_' . $type] = array('title', 'sites', null, null, null, 'force_title' => '<strong>' . $txt['aeva_' . $type . '_sites'] . ' (' . count($array) . ')' . '</strong> - <input type="checkbox" id="checkall_' . $type . '" onclick="invertAll(this, this.form, \'aeva_' . $type . '\');" ' . (!empty($checkall[$type]) ? 'checked="checked" ' : '') . '/><label class="smalltext" for="checkall_' . $type . '"> <em>' . $txt['aeva_select'] . '</em></label>');
	$dest['aeva_' . $type . '_items'] = array('checkbox_line', 'sites', array(), true, null, 'skip_left' => true);

	// Now for the magic block builder
	foreach ($array as $arr)
	{
		$link = (!empty($arr['website']) ? '<a href="' . $arr['website'] . '" style="text-decoration: none" title="-" target="_blank">&oplus;</a> ' : '') . $arr['title']
				. (!empty($arr['lookup-url']) ? '<span style="color: ' . (empty($modSettings['aeva_lookup_result']) ? 'red' : 'green') . '">*</span>' : '');
		$dest['aeva_' . $type . '_items'][2]['aeva_' . $arr['id']] = array($link, !$arr['disabled'], 'force_name' => 'aeva_' . $type . '[' . $arr['id'] . ']');
	}
}

?>