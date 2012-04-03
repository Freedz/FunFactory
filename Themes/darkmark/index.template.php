<?php
// Version: 2.0 RC3; index

/*	This template is, perhaps, the most important template in the theme. It
	contains the main template layer that displays the header and footer of
	the forum, namely with main_above and main_below. It also contains the
	menu sub template, which appropriately displays the menu; the init sub
	template, which is there to set the theme up; (init can be missing.) and
	the linktree sub template, which sorts out the link tree.

	The init sub template should load any data and set any hardcoded options.

	The main_above sub template is what is shown above the main content, and
	should contain anything that should be shown up there.

	The main_below sub template, conversely, is shown after the main content.
	It should probably contain the copyright statement and some other things.

	The linktree sub template should display the link tree, using the data
	in the $context['linktree'] variable.

	The menu sub template should display all the relevant buttons the user
	wants and or needs.

	For more information on the templating system, please see the site at:
	http://www.simplemachines.org/
*/

// Initialize the template... mainly little settings.
function template_init()
{
	global $context, $settings, $options, $txt;

	/* Use images from default theme when using templates from the default theme?
		if this is 'always', images from the default theme will be used.
		if this is 'defaults', images from the default theme will only be used with default templates.
		if this is 'never' or isn't set at all, images from the default theme will not be used. */
	$settings['use_default_images'] = 'never';

	/* What document type definition is being used? (for font size and other issues.)
		'xhtml' for an XHTML 1.0 document type definition.
		'html' for an HTML 4.01 document type definition. */
	$settings['doctype'] = 'xhtml';

	/* The version this template/theme is for.
		This should probably be the version of SMF it was created for. */
	$settings['theme_version'] = '2.0 RC3';

	/* Set a setting that tells the theme that it can render the tabs. */
	$settings['use_tabs'] = true;

	/* Use plain buttons - as opposed to text buttons? */
	$settings['use_buttons'] = true;

	/* Show sticky and lock status separate from topic icons? */
	$settings['separate_sticky_lock'] = true;

	/* Does this theme use the strict doctype? */
	$settings['strict_doctype'] = false;

	/* Does this theme use post previews on the message index? */
	$settings['message_index_preview'] = false;

	/* Set the following variable to true if this theme requires the optional theme strings file to be loaded. */
	$settings['require_theme_strings'] = true;
}

// The main sub template above the content.
function template_html_above()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	// Show right to left and the character set for ease of translating.
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"', $context['right_to_left'] ? ' dir="rtl"' : '', '>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
	<meta name="description" content="', $context['page_title_html_safe'], '" />', !empty($context['meta_keywords']) ? '
	<meta name="keywords" content="' . $context['meta_keywords'] . '" />' : '', '
	<title>', $context['page_title_html_safe'], '</title>';

	// Please don't index these Mr Robot.
	if (!empty($context['robot_no_index']))
		echo '
	<meta name="robots" content="noindex" />';

	// Present a canonical url for search engines to prevent duplicate content in their indices.
	if (!empty($context['canonical_url']))
		echo '
	<link rel="canonical" href="', $context['canonical_url'], '" />';

	// The ?rc3 part of this link is just here to make sure browsers don't cache it wrongly.
	echo '
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/index', $context['theme_variant'], '.css?rc3" />
	<link rel="stylesheet" type="text/css" href="', $settings['default_theme_url'], '/css/print.css?rc3" media="print" />';

	// Show all the relative links, such as help, search, contents, and the like.
	echo '
	<link rel="help" href="', $scripturl, '?action=help" />
	<link rel="search" href="', $scripturl, '?action=search" />
	<link rel="contents" href="', $scripturl, '" />';

// If RSS feeds are enabled, advertise the presence of one.
	if (!empty($modSettings['xmlnews_enable']) && (!empty($modSettings['allow_guestAccess']) || $context['user']['is_logged']))
		echo '
	<link rel="alternate" type="application/rss+xml" title="', $context['forum_name_html_safe'], ' - ', $txt['rss'], '" href="', $scripturl, '?type=rss;action=.xml" />';

	// If we're viewing a topic, these should be the previous and next topics, respectively.
	if (!empty($context['current_topic']))
		echo '
	<link rel="prev" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=prev" />
	<link rel="next" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=next" />';

	// If we're in a board, or a topic for that matter, the index will be the board's index.
	if (!empty($context['current_board']))
		echo '
	<link rel="index" href="', $scripturl, '?board=', $context['current_board'], '.0" />';

// YSHOUT HERE - <head> code
	global $boardurl,$shoutFile;
	$shoutFile='home';
	$scripturlparsed = parse_url($scripturl);
	$scriptpath=isset($scripturlparsed['path'])?$scripturlparsed['path']:'/';
	$args='';
	foreach($_GET as $key => $value) // passthrough $_GET
		$args.='&'.urlencode($key).'='.urlencode($value);
	echo '
	<script src="',$boardurl,'/yshout/js/moo.ajax.js" type="text/javascript"></script>
	<script src="',$boardurl,'/yshout/settings.js" type="text/javascript"></script>
	<script type="text/javascript"><!-- // --><![CDATA[
	if (window.addEventListener){
		window.addEventListener("load", function(){loadChat();}, false);
	} else if (window.attachEvent){
		window.attachEvent("onload", function(){loadChat();});
	}
	var shoutFile="',$shoutFile,'";
	var yshout_php="',$scriptpath,'?yshout',$args,'";
	// ]]></script>
	<script src="',$boardurl,'/yshout/js/yshout.js?July062008" type="text/javascript"></script>
	<style type="text/css">
		#yshout {
			font-size: 10px;
			overflow: hidden;
		}
		#yshout #yshout-toollinks { /* tool links (History, Commands, etc.) */
		}
		#yshout #shouts { /* main shouts area */
		}
		#yshout .shout { /* one shout */
			margin: 0 0 0; /* Top Bottom Linespacing */
			line-height: 1;
		}
		#yshout .shout-timestamp {
			font-style: normal;
			font-weight: normal;
		}
		#yshout .shout-adminlinks { /* del and ban buttons */
			font-size: 6pt;
			color: #141414;
		}
		#yshout #shout-form {
			margin: 0;
			padding: 0;
		}
		#yshout #shout-form fieldset {
			border: none;
		}
		#yshout #forum-name {
			width: 70px;
			margin-right: 5px;
		}
		#yshout #shout-text {
			width: 310px;
			margin-right: 5px;
		}
		#yshout #shout-button {
			width: 55px;
		}
		#yshout .shout-invalid { /* invalid shout (shout textbox) */
			background: #FFFDD1;
		}
	</style>';
	// YSHOUT END - <head> code



	// Some browsers need an extra stylesheet due to bugs/compatibility issues.
	foreach (array('ie7', 'ie6', 'webkit') as $cssfix)
		if ($context['browser']['is_' . $cssfix])
			echo '
	<link rel="stylesheet" type="text/css" href="', $settings['default_theme_url'], '/css/', $cssfix, '.css" />';

	// RTL languages require an additional stylesheet.
	if ($context['right_to_left'])
		echo '
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/rtl.css" />';

	echo '
	<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/script.js?rc3"></script>
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/theme.js?rc3"></script>';
echo '
	<script type="text/javascript"><!-- // --><![CDATA[
		var smf_theme_url = "', $settings['theme_url'], '";
		var smf_default_theme_url = "', $settings['default_theme_url'], '";
		var smf_images_url = "', $settings['images_url'], '";
		var smf_scripturl = "', $scripturl, '";
		var smf_iso_case_folding = ', $context['server']['iso_case_folding'] ? 'true' : 'false', ';
		var smf_charset = "', $context['character_set'], '";', $context['show_pm_popup'] ? '
		var fPmPopup = function ()
		{
			if (confirm("' . $txt['show_personal_messages'] . '"))
				window.open(smf_prepareScriptUrl(smf_scripturl) + "action=pm");
		}
		addLoadEvent(fPmPopup);' : '', '
		var ajax_notification_text = "', $txt['ajax_in_progress'], '";
		var ajax_notification_cancel_text = "', $txt['modify_cancel'], '";
	// ]]></script>
	<script language="JavaScript" type="text/javascript" src="', $settings['theme_url'], '/scripts/mootools.js"></script>
	<script language="JavaScript" type="text/javascript" src="', $settings['theme_url'], '/scripts/imagemenu.js"></script>
	<script language="JavaScript" type="text/javascript" src="', $settings['theme_url'], '/scripts/imagemenu2.js"></script>';

	// Output any remaining HTML headers. (from mods, maybe?)
	echo $context['html_headers'];

	echo '
</head>
<body>';
}

function template_body_above()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

echo '
		 <div id="header">
		  <div id="head-l">
			<div id="head-r">
				<div class="user">';
		// If the user is logged in, display stuff like their name, new messages, etc.
		if ($context['user']['is_logged'])
		{
			if (!empty($context['user']['avatar']))
				echo '
				<p class="avatar">', $context['user']['avatar']['image'], '</p>';
			echo '
				<ul class="reset">
					<li class="greeting">', $txt['hello_member_ndt'], ' <span>', $context['user']['name'], '</span></li>
					<li><a href="', $scripturl, '?action=unread">', $txt['unread_since_visit'], '</a></li>
					<li><a href="', $scripturl, '?action=unreadreplies">', $txt['show_unread_replies'], '</a></li>';

			// Is the forum in maintenance mode?
			if ($context['in_maintenance'] && $context['user']['is_admin'])
				echo '
					<li class="notice">', $txt['maintain_mode_on'], '</li>';

			// Are there any members waiting for approval?
			if (!empty($context['unapproved_members']))
				echo '
					<li>', $context['unapproved_members'] == 1 ? $txt['approve_thereis'] : $txt['approve_thereare'], ' <a href="', $scripturl, '?action=admin;area=viewmembers;sa=browse;type=approve">', $context['unapproved_members'] == 1 ? $txt['approve_member'] : $context['unapproved_members'] . ' ' . $txt['approve_members'], '</a> ', $txt['approve_members_waiting'], '</li>';

			if (!empty($context['open_mod_reports']) && $context['show_open_reports'])
				echo '
					<li><a href="', $scripturl, '?action=moderate;area=reports">', sprintf($txt['mod_reports_waiting'], $context['open_mod_reports']), '</a></li>';

			echo '
				</ul>';
		}
				else
					echo sprintf($txt['welcome_guest'], $txt['guest_title']);
echo '
		</div>

		  <div id="arama">
				<form id="search_form" style="margin: 0;" action="', $scripturl, '?action=search2" method="post" accept-charset="', $context['character_set'], '">
				<div id="searchbox">
                        	<input type="text" name="search" value="" class="search_input" />
                        </div>
					<input type="submit" name="submit" value="" class="search_button" />
					<input type="hidden" name="advanced" value="0" />';

		// Search within current topic?
		if (!empty($context['current_topic']))
			echo '
					<input type="hidden" name="topic" value="', $context['current_topic'], '" />';
			// If we're on a certain board, limit it to this board ;).
		elseif (!empty($context['current_board']))
			echo '
					<input type="hidden" name="brd[', $context['current_board'], ']" value="', $context['current_board'], '" />';

			echo '
			      </form></div>

				<a href="'.$scripturl.'?action=forum" title=""><span id="logo"> </span></a>';

echo '
		</div>		 
	</div>
</div>

	<div id="navi">
		<div id="navi-l">
			<div id="navi-r">
	                <div id="fancymenu2">',template_menu(),'</div>
		      </div>
	     </div>
	</div>';
echo '
	  <div id="linkt">
		      <div id="timef">', $context['current_time'], '<div>
                          
        </div>';
             
 echo '
	  </div>';

	      echo '
			<div id="news">
			   ',theme_linktree2(),'
			</div>
	       </div>
	     <div id="mainarea2">';
 
// YSHOUT HERE - shoutbox code
	global $txt,$context,$boarddir;
	if(allowedTo('yshout_view'))
	{
		echo '<div class="innerframe">
				<div class="cat_bar">
					<h3 class="catbg">',$txt['yshout_shoutbox'],'</h3>
		</div>';
		echo '<div class="windowbg2" id="yshout" style="font-size: 14px; margin-bottom:30px;">';
		include_once($boarddir.'/yshout/yshout.php');
		echo '</div></div>';
	}
	elseif($context['user']['is_guest'])
		echo $txt['yshout_no_guests'];
	// YSHOUT END - shoutbox code

}

function template_body_below()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
           </div>';

		// Show the "Powered by" and "Valid" logos, as well as the copyright. Remember, the copyright must be somewhere!
	echo '
		  <div id="footer">
		    <div id="foot-l">
			 <div id="foot-r">
		          <div id="footerarea">
				', theme_copyright(), '<br />2012 Copyright <a href="http://www.funfactory.ph" target="_blank">FunFactory.ph</a>
                       </div>';

		// Show the load time?
		if ($context['show_load_time'])
			echo '<br />'. $txt['page_created'], $context['load_time'], $txt['seconds_with'], $context['load_queries'], $txt['queries'], '</span>';

	echo '
                </div>
		</div>
	</div>';
}

function template_html_below()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

echo '
</body></html>';
}

// Show a linktree. This is that thing that shows "My Community | General Category | General Discussion"..
function theme_linktree()
{

}

// Show a linktree2. This is that thing that shows "My Community | General Category | General Discussion"..
function theme_linktree2()
{
global $context, $settings, $options;

echo '<div class="nav" style="font-size: normal; margin-bottom: 2ex;">';

// Each tree item has a URL and name. Some may have extra_before and extra_after.
foreach ($context['linktree'] as $link_num => $tree)
{
// Show something before the link?
if (isset($tree['extra_before']))
echo $tree['extra_before'];

// Show the link, including a URL if it should have one.
echo '<b>', $settings['linktree_link'] && isset($tree['url']) ? '<a href="' . $tree['url'] . '" class="nav">' . $tree['name'] . '</a>' : $tree['name'], '</b>';

// Show something after the link...?
if (isset($tree['extra_after']))
echo $tree['extra_after'];

// Don't show a separator for the last one.
if ($link_num != count($context['linktree']) - 1)
echo '&nbsp;\BB&nbsp;';
}

echo '</div>';
}

// Show the menu up top. Something like [home] [help] [profile] [logout]...
function template_menu()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
		 <div id="kwick">
               <ul class="kwicks">';

foreach ($context['menu_buttons'] as $act => $button)
				echo '<li><a href="', $button['href'], '" class="kwick opt1">', $settings['use_image_buttons'] ? '<img src="' . $settings['lang_images_url'] . '/' . $act . '.png" alt="' . $button['title'] . '" border="0" />' : $button['title'], '</a></li>', !empty($button['is_last']) ? '' : $context['menu_separator'];

	echo '
			</ul>
		</div>';

}

// Generate a strip of buttons.
function template_button_strip($button_strip, $direction = 'top', $strip_options = array())
{
	global $settings, $context, $txt, $scripturl;

	if (!is_array($strip_options))
		$strip_options = array();

	// Create the buttons...
	$buttons = array();
	foreach ($button_strip as $key => $value)
	{
		if (!isset($value['test']) || !empty($context[$value['test']]))
			$buttons[] = '
				<li><a' . (isset($value['id']) ? ' id="button_strip_' . $value['id'] . '"' : '') . ' class="button_strip_' . $key . '' . (isset($value['active']) ? ' active' : '') . '" href="' . $value['url'] . '"' . (isset($value['custom']) ? ' ' . $value['custom'] : '') . '><span>' . $txt[$value['text']] . '</span></a></li>';
	}

	// No buttons? No button strip either.
	if (empty($buttons))
		return;

	// Make the last one, as easy as possible.
	$buttons[count($buttons) - 1] = str_replace('<span>', '<span class="last">', $buttons[count($buttons) - 1]);

	echo '
		<div class="buttonlist', !empty($direction) ? ' align_' . $direction : '', '"', (empty($buttons) ? ' style="display: none;"' : ''), (!empty($strip_options['id']) ? ' id="' . $strip_options['id'] . '"': ''), '>
			<ul>',
				implode('', $buttons), '
			</ul>
		</div>';
}

?>
