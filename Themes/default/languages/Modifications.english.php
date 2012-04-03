<?php
// Version: 2.0; Modifications

// Aeva Media extra strings
$txt['aeva_gallery'] = isset($txt['aeva_gallery']) ? $txt['aeva_gallery'] : 'Media';
$txt['aeva_home'] = 'Home';
$txt['aeva_unseen'] = 'Unseen';
$txt['aeva_profile_sum'] = 'Summary';
$txt['aeva_view_items'] = 'View items';
$txt['aeva_view_coms'] = 'View comments';
$txt['aeva_view_votes'] = 'View votes';
$txt['aeva_gotolink'] = 'Details';
$txt['aeva_zoom'] = 'Zoom';
$txt['permissiongroup_aeva'] = 'Aeva Media';
$txt['permissiongroup_simple_aeva'] = 'Aeva Media';
$txt['permissionname_aeva_access'] = 'Access Gallery';
$txt['permissionname_aeva_moderate'] = 'Moderate Gallery';
$txt['permissionname_aeva_manage'] = 'Administrate Gallery';
$txt['permissionname_aeva_access_unseen'] = 'Access unseen area';
$txt['permissionname_aeva_search'] = 'Search in Gallery';
$txt['permissionname_aeva_add_user_album'] = 'Add Albums';
$txt['permissionname_aeva_add_playlists'] = 'Add User Playlists';
$txt['permissionname_aeva_auto_approve_albums'] = 'Auto-approve Albums';
$txt['permissionname_aeva_moderate_own_albums'] = '<span style="border-bottom: 1px #888 dashed" title="Delete any comments/items on own albums, and delete own albums.">Moderate own Albums</span>';
$txt['permissionname_aeva_viewprofile'] = 'View anyone\'s Gallery profile';
$txt['cannot_aeva_viewprofile'] = 'You cannot view Gallery profiles';
// End Aeva Media strings


// ---- Begin modification - nneonneo's Shoutbox ----
$txt['yshout_shoutbox'] = 'Shout Box';
$txt['yshout_loading'] = '...loading shoutbox...';
$txt['yshout_rp_banned'] = "Sorry, you've been banned from the shoutbox.";
$txt['yshout_no_guests'] = 'Sorry, you must be logged in to use the shoutbox!';
$txt['yshout_ban_conf'] = 'Ban Confirmation';
$txt['yshout_select_mode'] = 'Select Ban Mode:';
$txt['yshout_rp'] = 'Reading and Posting';
$txt['yshout_p'] = 'Posting only';
$txt['yshout_error'] = 'ERROR: ';
$txt['yshout_no_user'] = 'User not found.';
$txt['yshout_del_success'] = 'Shout deleted.';
$txt['yshout_no_action'] = 'Nothing to do.';
$txt['yshout_history'] = 'History';
$txt['yshout_commands'] = 'Commands';
$txt['yshout_exthistory'] = 'ExtendedHistory';
$txt['yshout_hide'] = 'Hide';
$txt['yshout_show'] = 'Show';
$txt['yshout_admlinks'] = 'AdminLinks';
$txt['yshout_return'] = 'ReturnToShoutbox';
$txt['yshout_p_banned'] = 'You are banned from posting.';
$txt['yshout_banned'] = 'Banned';
$txt['yshout_shout_button'] = 'Shout!';
$txt['yshout_banlist_caption'] = 'Shout Box Bans (click to unban)';
$txt['yshout_ip_bans'] = 'IP Bans for ';
$txt['yshout_username_bans'] = 'Username Bans for ';
$txt['yshout_ban_type_error'] = 'use /banuser or /banip!';
$txt['yshout_ban_mode_error'] = 'Must have mode argument.';
$txt['yshout_imp_slash_error'] = 'Prefix shout with "/" (slash character)! See "/help impersonate" for details.';
$txt['yshout_imp_uname_error'] = 'No username given!';
$txt['yshout_imp_max4_error'] = 'Maximum 4 arguments!';
$txt['yshout_cmd_reference'] = 'Command Reference';
$txt['yshout_cmdlist'] = array(
					'/help'		=>	' [command]: Help on a command, or all if no command is specified.',
					'/return'	=>	': Go back to the Shout Box.',
					'/pi'		=>	' [digits]: What is the value of pi to the nth digit?',
					'/me'		=>	' &lt;message&gt;: Emotes the message (e.g. <span class="meaction"> * Nathaniel likes dogs</span>)');
$txt['yshout_cmdlistadmin'] = array(
						'/clear'		=>	': Completely empty the Shout Box.',
						'/help'			=>	' [command]: Help on a command, or all if no command is specified.',
						'/return'		=>	': Go back to the Shout Box.',
						'/banlist'		=>	': List all bans currently in place. Unban the users by clicking on their names.',
						'/banuser'		=>	' &lt;mode&gt; &lt;username&gt;: Ban a user by name. You should use the user\'s real username, otherwise the ban can be evaded. Mode can be "u" to unban, "rp" for read and post bans, or "p" for a post ban.',
						'/banip'		=>	' &lt;mode&gt; &lt;IP&gt;: Ban a user by IP. Mode can be "u" to unban, "rp" for read and post bans, or "p" for a post ban.',
						'/impersonate'	=>	' &lt;user&gt; [userlevel] [ip] [userid] /[shout text]: Impersonate a user. Shout text must be prefixed by a "/" or else it will fail.<blockquote><div>
						&lt;user&gt;: Username to use<br />
						[userlevel]: User Level to use. 0=normal, 1=mod, 2=admin<br />
						[ip]: IP address to use, as 1.2.3.4<br />
						[userid]: User ID from forum, to fix profile link</div></blockquote>',
						'/lock'			=>	' &lt;message&gt;: Lock the shoutbox for maintenance with the specified message.',
						'/unlock'		=>	': Release the shoutbox from maintenance.');
$txt['yshout_maintenance'] = 'Locked';
$txt['yshout_lock_arg_error'] = 'You need to specify a reason for maintenance!';
$txt['yshout_lock_changed'] = 'Changed maintenance reason to "%s".';
$txt['yshout_lock_success'] = 'Locked shoutbox for maintenance with reason "%s".';
$txt['yshout_unlock_already'] = 'Failed to unlock: shoutbox isn\'t locked!';
$txt['yshout_unlock_success'] = 'Successfully unlocked shoutbox.';
$txt['yshout_no_posting'] = 'Sorry, you cannot post to the shoutbox.';
$txt['yshout_smilies'] = "Smilies";
// Permissions
$txt['permissiongroup_yshout'] = 'Shoutbox';
$txt['permissionname_yshout_view'] = 'View shoutbox';
$txt['permissionname_yshout_post'] = 'Post in shoutbox';
$txt['permissionname_yshout_moderate'] = 'Moderate shoutbox';
$txt['permissionhelp_yshout_view'] = 'This permission allows access to the shoutbox. If it is enabled, users will see the shoutbox and the chats in it.';
$txt['permissionhelp_yshout_post'] = 'This permission allows users to post messages to the shoutbox. If it is disabled, users cannot enter any messages.';
$txt['permissionhelp_yshout_moderate'] = 'If this permission is set, users will be allowed to moderate the shoutbox -- deleting, banning and clearing among other features.';
$txt['permissiongroup_simple_yshout'] = 'Shoutbox';
// ---- End modification - nneonneo's Shoutbox ----
?>