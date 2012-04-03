<?php
/*************************************
 * Main Shoutbox Settings            *
 * Does not include CSS (appearance) *
 *************************************/
global $maxLines,$chatsDir,$chatFormat,$historyFormat,$gzipCompression;
global $reverseShouts,$shoutFormOnTop,$autoGuestName,$allowCommands,$guestCommands;
global $updateTimeout,$updatePeriod,$bannedCommands,$bannedCode;
global $maxShoutChars,$maxUsernameChars;

// Set the maximum amount of lines to be displayed at a time
// After changing this, /clear the shoutbox to make the change
// take effect.
$maxLines=12;

// Logging folder for the chats
$chatsDir='chats';

// Chat file format - %s means the chat file as given by the client
$chatFormat='%s.txt';

// History format - set to '' to disable archiving.
$historyFormat='history.%s.txt';

// Should we use GZip compression? If bandwidth usage is a concern,
// set this to true. GZip compression does NOT apply to shoutbox refreshes,
// only to initialization and shout events.
$gzipCompression=false;

// The shoutbox usually shows shouts with the newest chats at the bottom.
// If you want the newest ones at the top, set this to true.
$reverseShouts=false;

// If you reverse the shouts, you might want the shout form to be on top
// rather than on the bottom. Set this to true to move the shout form
// to the top (the tool links will stay above the form)
$shoutFormOnTop=false;

// Automatic Guest Usernames: should they be able to choose their own usernames?
// Set to some string (a prefix) if you want to disable guest choice of username
// Set to false if you want to allow guests to choose a username
$autoGuestName=false;//'guest-';

// Command options.
// If this is set to false, all typed commands are disabled.
// Admin functions, via admin links, are still available.
$allowCommands=true;

// If this is set to false, guests will be denied access to commands.
$guestCommands=true;

// How long should the script wait for the chats to update? (in seconds)
// If this is set to 0 the script will not wait at all,
// but this will be very detrimental to performance.
// Make sure this is less than the maximum script execution time
// on your server, or the shoutbox will never update.
$updateTimeout=20;

// The chats file is periodically checked for changes up to $updateTimeout seconds.
// This variable, $updatePeriod, defines the time between those checks in milliseconds.
// Lower means a more responsive shoutbox (slightly more real-time), while higher
// means less strain on the system.
// 500 milliseconds is the default.
$updatePeriod=500;

// An array of commands to block.
// Example: $bannedCommands=Array('/impersonate');
// Note that since SMF recognizes /me by default, it can't be blocked.
$bannedCommands=Array();

// An array of strings to delete from the input.
// By default, this includes the list, center, left and right tags.
$bannedCode=Array('[list]','[/list]','[center]','[/center]',
                  '[left]','[/left]','[right]','[/right]');

// How many characters will be permitted in each shout.
$maxShoutChars=255;

// How many characters will be permitted in the username.
// This does not apply to SMF registered usernames.
$maxUsernameChars=25;

// Function to customize the timestamp.
// Default formatting: [(SMF user profile timestamp)]
function preg_timeformat($matches)
{
	// format: <timeval=(value)>
	// return ''; // to disable the timestamp
	return '['.timeformat(intval($matches[1])).']';
}
?>