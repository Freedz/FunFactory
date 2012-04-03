<?php
// nneonneo's AJAX shoutbox
// Version 1.22

// Figure out where the yshout folder is
global $yshoutdir;
$yshoutdir=(defined('SMF')||isset($yshout_from_index))?'yshout/':'';
// Check configuration files
if(!file_exists($yshoutdir.'settings.php'))
{
	echo 'Error: No settings.';
	return;
}
if(!file_exists($yshoutdir.'_banlist.php'))
{
	// If _banlist.php has been deleted, assume it should be reset to defaults
	$ban_ips_readpost=$ban_ips_post=$ban_names_readpost=$ban_names_post=array();
	$sbMaintenance=false;
	writeBanList();
}
// Load settings
require_once($yshoutdir."settings.php");
global $ban_ips_readpost,$ban_ips_post,$ban_names_readpost,$ban_names_post,$sbMaintenance;
require_once($yshoutdir.'_banlist.php');
// Figure out which file we're logging chats to
global $shoutFile;
if(!isset($shoutFile))
	$shoutFile='home';
if(isset($_REQUEST['file']))
	$shoutFile=$_REQUEST['file'];
$shoutFile=preg_replace('/[^A-Za-z0-9_]/','',$shoutFile);
global $chatPath,$historyPath;
$chatsFullDir=$yshoutdir.$chatsDir.'/';
$chatPath=$chatsFullDir.sprintf($chatFormat,$shoutFile);
$historyPath=($historyFormat==='')?'':$chatsFullDir.sprintf($historyFormat,$shoutFile);

// If the shoutbox isn't require'd from SMF, we need to load some SMF components.
$loadedFromSMF=true;
if(!defined('SMF'))
{
	global $sourcedir;
	$loadedFromSMF=false;
	// session_start(); // removing for now: causes "session verification failed" errors
	                    // on some hosts due to Load.php continually creating new $sc codes
	                    // instead of keeping the same one.
	                    // n.b. what to do about refreshChats()?
	require(dirname(__FILE__) . "/../SSI.php");
	require_once($sourcedir . '/Subs-Post.php');
	$defaultEncoding=(empty($context['character_set']) ? 'ISO-8859-1' : $context['character_set']);
	header('Content-type: text/html; charset='.$defaultEncoding);
}
// Set up some useful globals
global $func,$smcFunc,$ip,$isSMF1,$user;
$ip = $_SERVER['REMOTE_ADDR'];
$isSMF1 = isset($func);
if(!$isSMF1)
	$func=$smcFunc;
$maxLines+=1; // off-by-one correction
$user=$context['user']; // shortcut, for brevity
if(!$loadedFromSMF)
{
	loadUserSettings();
	loadPermissions();
	loadTheme();
	writeLog(); // mark user as online
}
// Are you banned from reading the shoutbox?
if(in_array($ip, $ban_ips_readpost) || in_array($user['username'], $ban_names_readpost) || in_array($user['name'], $ban_names_readpost))
{
	echo $txt['yshout_banned'];
	return;
}
if(!allowedTo('yshout_view'))
{
	if(isGuest())
		echo $txt['yshout_no_guests'];
	return;
}

// Check guest status and grab guest username
if(isGuest())
{
	if($autoGuestName!==false)
		$user['username']=$user['name']=$_COOKIE['username']=$autoGuestName.substr(md5($ip),0,4);
	elseif(isset($_POST['username']) || isset($_COOKIE['username']))
	{
		$requsername=isset($_POST['username'])?$_POST['username']:$_COOKIE['username'];
		$requsername=$func['htmlspecialchars'](html_entity_decode(urldecode($requsername)),ENT_QUOTES);
		$user['username']=$user['name']=$_COOKIE['username']=$requsername;
	}
}
// Check user group membership
$user['is_sbmod']=false;
$user['can_sbpost']=false;
if(allowedTo('yshout_moderate'))
	$user['is_sbmod']=true;
if(allowedTo('yshout_post'))
	$user['can_sbpost']=true;

if($loadedFromSMF)
{
	// Initialize the shoutbox and quit
	initShoutbox($user,true);
	return;
}

// Permission checks
function isGuest($user=false)
{
	if($user===false) global $user;
	return !$user['is_logged'];
}

function isMod($user=false)
{
	if($user===false) global $user;
	return $user['is_admin'] || $user['is_sbmod'];
}

function isPostBanned($user=false)
{
	global $ip,$ban_ips_post,$ban_names_post;
	if($user===false) global $user;
	return in_array($ip, $ban_ips_post) || in_array($user['username'], $ban_names_post) || in_array($user['name'], $ban_names_post);
}

// $_GET commands
// administrative: ban/unban and delete
if(isset($_GET['banid']))
{
	if(!isset($_GET['mode']))
	{
		global $boardurl;
		doMsg(<<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<base href="$boardurl/" />
		<meta http-equiv="content-type" content="text/html; charset=$defaultEncoding" />
		<title>{$txt['yshout_ban_conf']}</title>
		<script type="text/javascript">
		//<![CDATA[
		function ajaxGet(args) {
			window.location=window.location+'&'+args;
		}
		//]]>
		</script>
	</head>
	<body>
		<h1>{$txt['yshout_select_mode']}</h1>
		<p><a href="javascript:ajaxGet('banid={$_GET['banid']}&amp;sesc={$_GET['sesc']}&amp;mode=rp');">{$txt['yshout_rp']}</a></p>
		<p><a href="javascript:ajaxGet('banid={$_GET['banid']}&amp;sesc={$_GET['sesc']}&amp;mode=p');">{$txt['yshout_p']}</a></p>
	</body>
</html>
EOF
);
		exit;
	}
	if(isMod())
	{
		$error=checkSession('request','',false);
		if($error!=='')
		{
			loadLanguage('Errors');
			die($txt[$error]);
		}
		if(!is_numeric($_GET['banid']))
		{
			// not an ID, so probably an IP
			$oldread=isset($_SESSION['readingCmd'])?$_SESSION['readingCmd']:NULL;
			doBan('ban_ips_',$_GET['mode'],$_GET['banid']);
			if($oldread==NULL) unset($_SESSION['readingCmd']);
			else $_SESSION['readingCmd']=$oldread;
			exit;
		}
		if(loadMemberData(Array($_GET['banid']),false,'minimal')===false)
		{
			doMsg($txt['yshout_error'].$txt['yshout_no_user']);
			exit;
		}
		$oldread=isset($_SESSION['readingCmd'])?$_SESSION['readingCmd']:NULL;
		doBan('ban_names_',$_GET['mode'],$user_profile[$_GET['banid']][$isSMF1?'memberName':'member_name']);
		if($oldread==NULL) unset($_SESSION['readingCmd']);
		else $_SESSION['readingCmd']=$oldread;
	}
	exit;
}

if(isset($_GET['unban']))
{
	if(isMod())
	{
		$oldread=isset($_SESSION['readingCmd'])?$_SESSION['readingCmd']:NULL;
		doBan('ban_'.$_GET["type"].'s_','u',$_GET['unban']);
		if($oldread==NULL) unset($_SESSION['readingCmd']);
		else $_SESSION['readingCmd']=$oldread;
	}
	exit;
}

if(isset($_GET['delete']))
{
	if(isMod())
	{
		$error=checkSession('request','',false);
		if($error!=='')
		{
			loadLanguage('Errors');
			die($txt[$error]);
		}
		$success=deleteShout($_GET['delete'],$chatPath);
		if(isset($_GET['history']) && !$success)
			$success=deleteShout($_GET['delete'],$historyPath);
		if($success)
			echo $txt['yshout_del_success'];
	}
	exit;
}
// Regular user $_GET commands: history, help
if(isset($_GET["history"]))
{
	history();
	exit;
}

if(isset($_GET["help"]))
{
	help();
	exit;
}
// If $_GET doesn't carry a command, check the request type
if(!isset($_POST["reqtype"]))
{
	echo $txt['yshout_no_action'];
	return;
}

if(isset($_POST["location"]))
{
	header("Location: " . $_POST["location"]);
}

$reqType = $_POST["reqtype"];

function initShoutbox($user,$fromSMF)
{
	// This function initializes the shoutbox: it prints the tool links,
	// current shouts and shout form
	global $gzipCompression,$txt,$user,$maxUsernameChars,$maxShoutChars,$sbMaintenance,$autoGuestName,$shoutFormOnTop,$shoutFile,$args,$scriptpath;
	if($gzipCompression && !$fromSMF) ob_start("ob_gzhandler");
	// Language check -- only admins will see this
	if($user['is_admin'] && !isset($txt['yshout_history']) && !isset($_COOKIE['yShout_read_txt_notice']))
	{
		global $user_info,$language,$settings;
		$user_language=isset($user_info['language']) ? $user_info['language'] : $language;
		if($user_language != 'english' || $settings['theme_dir'] != $settings['default_theme_dir'])
		echo '<span style="color:red;background:white">
		Warning! The shoutbox text files for your language are not installed.
		This may cause the shoutbox and admin settings to appear wrong.<br /><br />
		To fix this problem, copy <strong>',$settings['default_theme_dir'],'/languages/Modifications.english.php</strong>
		to <strong>',$settings['theme_dir'],'/languages/Modifications.',$user_language,'.php</strong> and translate as desired.<br /><br />
		To <strong>ignore</strong> this notice, click <a href="javascript:set_cookie(\'yShout_read_txt_notice\',\'true\',3600*24*365);delete_cookie(\'yShout_open\');loadChat();">here</a>.<br /><br /></span>';
	}
	// Tool links (History, Commands, etc.)
	echo '<div>Legend: <span style="color:red;">Administrator</span>, <span style="color:Blue;">Global Moderator</span>, <span style="color:Goldenrod">Associates</span>, <span style="color:deeppink;">FunGirls</span>, <span style="color:blueviolet;">2012 FunPals</span></div>';
	echo '<span id="yshout-toollinks">';
	/*echo '[<a href="javascript:goTo(\'history\')">',$txt['yshout_history'],'</a>] ';*/
	echo '[<a href="javascript:goTo(\'help\')">',$txt['yshout_commands'],'</a>]';
	if(isMod())
	{
		/*echo ' [<a href="javascript:history_number=prompt(\'How far back?\',200);if(history_number){goTo(\'history&amp;n=\'+history_number)}else{void(0)}">',$txt['yshout_exthistory'],'</a>]';*/
		if(!isset($_COOKIE['yShout_hideadmlinks']))
			echo ' [<a href="javascript:set_cookie(\'yShout_hideadmlinks\',\'true\',3600*24*365);delete_cookie(\'yShout_open\');loadChat();">',$txt['yshout_hide'],$txt['yshout_admlinks'],'</a>]';
		else
			echo ' [<a href="javascript:delete_cookie(\'yShout_hideadmlinks\');delete_cookie(\'yShout_open\');loadChat();">',$txt['yshout_show'],$txt['yshout_admlinks'],'</a>]';
		echo ' [<a href="javascript:autoShout(\'/return\');">',$txt['yshout_return'],'</a>]';
	}
	echo '</span>'; // yshout-toollinks
	if(!$shoutFormOnTop)
		echo '<div id="shouts">',readChat(),'</div>';
	// Shout form
	echo '
<form id="shout-form" name="shout_form" method="post" action="', $fromSMF ? htmlspecialchars("$scriptpath?yshout$args") : "#", '" onsubmit="doSend();return false;">
<fieldset>';
	$inputForumName='		<input name="username" type="text" maxlength="'.$maxUsernameChars.'"';
	$inputShoutText='		<input id="shout-text" name="shout" type="text" maxlength="'.$maxShoutChars.'" ';
	$inputShoutButton='		<input id="shout-button" type="submit" ';
	if($fromSMF) echo '
<input type="hidden" name="reqtype" value="shout" />
<input type="hidden" name="file" value="', $shoutFile, '" />
<input type="hidden" name="location" value="', htmlspecialchars("$scriptpath?unused$args"), '" />';
	if(isPostBanned())
		echo '
',$inputForumName,'value="',$user['name'], '" disabled="disabled" />
',$inputShoutText,'value="',$txt['yshout_p_banned'],'" disabled="disabled" />
',$inputShoutButton,'value="',$txt['yshout_banned'],'" disabled="disabled" />';
	elseif(!isMod() && $sbMaintenance!==false)
		echo '
',$inputForumName,'value="',$user['name'], '" disabled="disabled" />
',$inputShoutText,'value="',$sbMaintenance,'" disabled="disabled" />
',$inputShoutButton,'value="',$txt['yshout_maintenance'],'" disabled="disabled" />';
	elseif(!$user['can_sbpost'])
		echo '
',$inputForumName,'value="',$user['name'], '" disabled="disabled" />
',$inputShoutText,'value="',isGuest()?$txt['yshout_no_guests']:$txt['yshout_no_posting'],'" disabled="disabled" />
',$inputShoutButton,'value="',$txt['yshout_maintenance'],'" disabled="disabled" />';
	else
	{
		if(isGuest() && $autoGuestName===false)
		echo '
',$inputForumName,'value="',$user['name'], '" />';
		else
		echo '
',$inputForumName,'value="',$user['name'], '" disabled="disabled" />';
	echo '
',$inputShoutText,'value="" />
',$inputShoutButton,'value="',$txt['yshout_shout_button'],'" />';
	}
	echo '
</fieldset>
</form>';
	if($shoutFormOnTop)
		echo '<div id="shouts">',readChat(),'</div>';
	if($gzipCompression && !$fromSMF) ob_end_flush();
}
// Figure out the request
switch($reqType) {
	case "init":
		initShoutbox($user,false);
		break;
	case "shout":
		if(isPostBanned()) break;
		if(!$user['can_sbpost']) break;
		if(!isMod() && $sbMaintenance!==false) break;
		$shoutText = $_POST["shout"];
		if($shoutText[0]=='/' && $allowCommands)
		{
			if(isMod())
			{
				if(processCommand($shoutText))
					break;
			}
			elseif(!isGuest() || $guestCommands)
			{
				$shoutText=substr($shoutText,0,$maxShoutChars);
				if(processUserCommand($shoutText)) break;
			}
		}
		$shoutName = $user['name'];

		if(!isMod())
			$shoutText=substr($shoutText,0,$maxShoutChars);

		makeShout($shoutText,$user);
		break;
	case "refresh":
		refreshChats(false);
		break;
	case "autoshout":
		if(isMod())
			processCommand($_POST["shout"]);
		break;
}

function doMsg($msg)
{
	echo $msg; // tell user
	$_SESSION['readingCmd']=$msg; // make sure user keeps seeing this message; see readChat
}

function processCommand($text) {
	global $reqType, $maxLines, $ip, $user, $bannedCommands, $txt, $sbMaintenance;
	global $ban_ips_readpost, $ban_ips_post, $ban_names_readpost, $ban_names_post;
	if($text[0]!='/') return false; // no slash, no service
	$data=explode(' ',$text,2); // "2" means to make the first "word" separated from the rest
	$cmd=$data[0]; // first word is the cmd. No cmds can have spaces.
	$args=(isset($data[1])?$data[1]:''); // are there even any arguments?
	if(in_array($cmd,$bannedCommands)) return false;
	switch($cmd) {
		case "/clear":
			global $chatPath, $historyPath;
			$fileContents='';
			if(file_exists($chatPath))
				$fileContents = file_get_contents($chatPath);
			$handle=fopen($chatPath, 'w');
			fputs($handle,'');
			fclose($handle);
			if($historyPath !== '')
			{
				$handle=fopen($historyPath, 'a');
				fputs($handle,$fileContents);
				fclose($handle);
			}
			return true;
		case "/return": // I'm done reading
			unset($_SESSION['readingCmd']);
			echo readChat();
			return true;
		case "/lock":
			if($args=='')
			{
				doMsg($txt['yshout_error'].$txt['yshout_lock_arg_error']);
				return true;
			}
			if($sbMaintenance !== false)
				doMsg(sprintf($txt['yshout_lock_changed'],$args));
			else
				doMsg(sprintf($txt['yshout_lock_success'], $args));
			$sbMaintenance = $args;
			writeBanList();
			return true;
		case "/unlock":
			if($sbMaintenance === false)
			{
				doMsg($txt['yshout_error'].$txt['yshout_unlock_already']);
				return true;
			}
			$sbMaintenance = false;
			writeBanList();
			doMsg($txt['yshout_unlock_success']);
			return true;
		case "/banlist": // who's banned?
			$_SESSION['readingCmd']=$text;
			$temp=Array();
			echo '<table>
			<caption>',$txt['yshout_banlist_caption'],'</caption>';
			echo '<tr><td>',$txt['yshout_ip_bans'],$txt['yshout_rp'],'</td><td>';
			$temp=Array();
			foreach($ban_ips_readpost as $i)
				$temp[]="<a href=\"javascript:ajaxGet('unban=$i&type=ip');\">$i</a>";
			echo implode($temp,','),'</tr>';
			echo '<tr><td>',$txt['yshout_ip_bans'],$txt['yshout_p'],'</td><td>';
			$temp=Array();
			foreach($ban_ips_post as $i)
				$temp[]="<a href=\"javascript:ajaxGet('unban=$i&type=ip');\">$i</a>";
			echo implode($temp,','),'</tr>';
			echo '<tr><td>',$txt['yshout_username_bans'],$txt['yshout_rp'],'</td><td>';
			$temp=Array();
			foreach($ban_names_readpost as $i)
				$temp[]="<a href=\"javascript:ajaxGet('unban=$i&type=name');\">$i</a>";
			echo implode($temp,','),'</tr>';
			echo '<tr><td>',$txt['yshout_username_bans'],$txt['yshout_p'],'</td><td>';
			$temp=Array();
			foreach($ban_names_post as $i)
				$temp[]="<a href=\"javascript:ajaxGet('unban=$i&type=name');\">$i</a>";
			echo implode($temp,','),'</tr>';
			echo '</table>';
			return true;
		case "/ban": // need to be more specific!
			doMsg($txt['yshout_error'].$txt['yshout_ban_type_error']);
			return true;
		case "/banuser":
		case "/banip":
			$type=($cmd=='/banip')?'ban_ips_':'ban_names_'; // prefixes for variables
			$ar=explode(' ',$args,2); // true argument array. the "2" ensures that we cut only once: mode can't have spaces but user can.
			if(count($ar)!=2) // whoops: only one argument?
			{
				doMsg($txt['yshout_error'].$txt['yshout_ban_mode_error']);
				return true;
			}
			$mode=$ar[0]; // set up vars
			$id=$ar[1];
			doBan($type,$mode,$id);
			return true;
		case "/impersonate":
			// <user> [userlevel] [ip] [userid] /[shout text]
			$slashpos=strpos($args,' /'); // use ' /' as a separator, so we can see how many args came before
			if($slashpos===false) // no shout? invalid formatting?
			{
				doMsg($txt['yshout_error'].$txt['yshout_imp_slash_error']);
				return true;
			}
			$shout=substr($args,$slashpos+2);
			$ar=explode(' ',substr($args,0,$slashpos));
			$name='';
			$userlevel=0;
			$userid=0;
			
			switch(count($ar)) // how many args did we get?
			{
				case 0: // no args
					doMsg($txt['yshout_error'].$txt['yshout_imp_uname_error']);
					return true;
				case 4: // reverse order to save space: we just set them from the back!
					$userid=intval($ar[3]);
				case 3:
					$ip=$ar[2]; // corrupt the global >:D
				case 2:
					$userlevel=intval($ar[1]);
				case 1:
					$name=html_entity_decode($ar[0]);
					break;
				default:
					doMsg($txt['yshout_error'].$txt['yshout_imp_max4_error']); // just so they know that we only have 4 params
					return true;
			}
			$ip.='.'; // to set off the impersonated msgs
			$fakeuser=array('id'=>$userid,'name'=>$name,'is_admin'=>($userlevel==2)?1:0,'is_sbmod'=>($userlevel==1)?1:0,'is_logged'=>($userlevel==-1)?0:1); // fake SMF $user array
			makeShout($shout,$fakeuser);
			return true;
		default: // not a command
			return processUserCommand($text);
	}
	return false;
}

function processUserCommand($text) {
	global $reqType,$chatPath,$historyPath,$maxLines,$ip,$ban_ips_readpost,$ban_ips_post,$ban_names_readpost,$ban_names_post,$user,$bannedCommands,$func;
	if($text[0]!='/') return false; // no slash, no service
	$data=explode(' ',$text,2); // "2" means to make the first "word" separated from the rest
	$cmd=$data[0]; // first word is the cmd. No cmds can have spaces.
	$args=(isset($data[1])?$data[1]:''); // are there even any arguments?
	if(in_array($cmd,$bannedCommands)) return false;
	switch($cmd) {
		case "/help":
			if(empty($args)) help();
			elseif($args[0]!='/') help('/'.$args);
			else help($args);
			$_SESSION['readingCmd']=$text;
			return true;
		case "/return": // I'm done reading
			unset($_SESSION['readingCmd']);
			echo readChat();
			return true;
		case "/pi":
			$s_pi='141592653589793238462643383279502884197169399375105820974944592307816406286208998628034825342117067982148086513282306647093844609550582231725359408128481117450284102701938521105559644622948954930381964428810975665933446128475648233786783165271201909145648566923460348610454326648213393607260249141273724587006606315588174881520920962829254091715364367892590360011330530548820466521384146951941511609';
			$n=5;
			if($args!='') $n=intval($args);
			$res=($n==0)?"PI IS EXACTLY 3!":'3.'.substr($s_pi,0,$n-1).(substr($s_pi,$n-1,1)+(substr($s_pi,$n,1)>=5?1:0));
			// all that nasty little bit does is add the first n-2 chars, then add the last digit and increment if rounding is necessary.
			makeShout($res);
			return true;
		case "/me":
			$newText = cleanupShout($args.' ');
			$shoutName=$user['name'];
			makeRawShout("<span class=\"meaction\"> * $shoutName $newText</span>",$user);
			return true;
		default:
			return false;
	}
	return false;
}
// utility functions for banning and deleting
function doBan($type,$mode,$id)
{
	global $ban_ips_readpost,$ban_ips_post,$ban_names_readpost,$ban_names_post,$txt;
	switch($mode)
	{
		case 'u': // nice guy
			$r=$type.'readpost'; // need to search both ban arrays. Search this one first...
			$index=array_search($id,$$r); // where is my little banned user?
			if($index===false)
			{
				$r=$type.'post'; // ...and this one second on failure.
				$index=array_search($id,$$r);
				if($index===false) // whoops, both searches failed!
				{
					doMsg($txt['yshout_error'].'Couldn\'t find user to unban!');
					return false;
				}
			}
			array_splice($$r,$index,1); // cut the 1 element loose with splice. $$r is used because $r is the string variable denoting the target array.
			doMsg("Success: unbanned $id.");
			break;
		case 'rp':
			array_push(${$type.'readpost'},$id); // easy, huh!
			doMsg("Success: banned $id from reading and posting.");
			break;
		case 'p':
			array_push(${$type.'post'},$id);
			doMsg("Success: banned $id from posting.");
			break;
		default:
			doMsg($txt['yshout_error']."Invalid mode $mode! Use only 'u', 'rp' or 'p'!");
			return false;
	}
	writeBanList(); // write the final report
	return true;
}

function writeBanList() // generate our dynamic ban list, which is 'require'd at the start of this script
{
	global $ban_ips_readpost,$ban_ips_post,$ban_names_readpost,$ban_names_post,$sbMaintenance,$yshoutdir;
	$writeText = "<"."?php\n"; // php header
	$writeText .= '$ban_ips_readpost = '.var_export($ban_ips_readpost,true).";\n"; // bans
	$writeText .= '$ban_ips_post = '.var_export($ban_ips_post,true).";\n";
	$writeText .= '$ban_names_readpost = '.var_export($ban_names_readpost,true).";\n";
	$writeText .= '$ban_names_post = '.var_export($ban_names_post,true).";\n";
	$writeText .= '$sbMaintenance = '.var_export($sbMaintenance,true).";\n";
	$writeText .= '?'.'>'; // end tag
	$handle = fopen($yshoutdir."_banlist.php", "w");
	if($handle===false) die('File error (writeBanList); aborted');
	$failcount=0;
	while( !flock($handle, LOCK_EX) ) // just IN CASE two bans happen simultaneously
	{
		usleep(50000);
		$failcount++;
		if($failcount > 20) die('Write error (writeBanList); aborted'); // one second
	}
	fwrite($handle, $writeText);
	flock($handle, LOCK_UN);
	fclose($handle);
}

function deleteShout($spanTitle, $chatPath) {
	$fileContents = '';

	if(file_exists($chatPath))
		$fileContents = file_get_contents($chatPath);
	$newFileContents=preg_replace('/<p[^>]*><span class="shout-timestamp" title="'.str_replace('|','\|',$spanTitle).'">.+\n/','',$fileContents);
	if($fileContents == $newFileContents) return false;
	$handle = fopen($chatPath, "w");
	fputs($handle, $newFileContents);
	fclose($handle);
	return true;
}

// utility functions for shouting
function cleanupShout($text) {
	global $func,$bannedCode,$context;
	$text = $func['htmlspecialchars'](stripslashes($text), ENT_QUOTES);
	foreach($bannedCode as $searchString)
		$text = preg_replace('/'.preg_quote($searchString,'/').'/i','',$text);
	preparsecode($text);
	$text = parse_bbc($text);
	censorText($text);
	return $text;
}

function makeShout($text,$user=false) {
	if($user===false)
		global $user;
	$text = cleanupShout($text.' ');

	$a_style = "";
	global $user_profile;
	if(loadMemberData(Array($user['id']),false,'profile')!==false)
	{
		$profile=$user_profile[$user['id']];
		$a_style = ' class="userclass" style="color: '.(empty($profile['member_group_color']) ? $profile['post_group_color'] : $profile['member_group_color']).'"';
	}
	
	$shoutName=$user['name'];
	$userID=$user['id'];
	if(isGuest($user))
		$writeText=$shoutName;
	else
		$writeText="<a$a_style href=\"index.php?action=profile;u=$userID\">$shoutName</a>";
	$writeText.=": $text";
	makeRawShout($writeText,$user);
}

function makeRawShout($text,$user=false) {
	global $maxLines,$chatPath,$historyPath,$ip;
	
	if($user===false)
		global $user;
	
	$emTitle=time()." | $ip";
	$banID=isGuest($user)?$ip:$user['id'];
	$timestamp="<span class=\"shout-timestamp\" title=\"$emTitle\"><timeval=".time()."></span>";
	$delLink="<a href=\"javascript:ajaxGet('delete=$emTitle&amp;sesc=<sesc>')\">del</a>";
	$banLink="<a href=\"javascript:ajaxGet('banid=$banID&amp;sesc=<sesc>')\">ban</a>";
	$adminlinks="<span class=\"shout-adminlinks\">$delLink&nbsp;$banLink&nbsp;</span>";
	writeLine("<p class=\"shout\">$timestamp&nbsp;$adminlinks$text</p>\n",$chatPath);
	truncateChat($maxLines,$chatPath,$historyPath);
	refreshChats(true);
}

function truncateChat($maxLines,$chatPath,$historyPath) {
	$fileContents = '';

	if(file_exists($chatPath))
		$fileContents = file_get_contents($chatPath);

	$lines = explode("\n", $fileContents);
	
	if(count($lines) > $maxLines) {
		$newText = substr($fileContents, strpos($fileContents, "\n") + 1);
		$handle = fopen($chatPath, "w");

		fputs($handle, $newText);
		fclose($handle);

		if($historyPath !== '')
		{
			// History
			$oldText = substr($fileContents, 0, strpos($fileContents, "\n") + 1);
			$handle = fopen($historyPath, "a");
			fputs($handle, $oldText);
			fclose($handle);
		}
	}
}

function writeLine($writeText,$chatPath) {
	$handle = fopen($chatPath, "a");
	if($handle===false) die('File error (writeLine); aborted');
	$failcount=0;
	while( !flock($handle, LOCK_EX) ) // just IN CASE two shouts happen simultaneously
	{
		usleep(50000);
		$failcount++;
		if($failcount > 20) die('Write error (writeLine); aborted'); // one second
	}
	fwrite($handle, $writeText);
	flock($handle, LOCK_UN);
	fclose($handle);
}

// utility functions for reading shouts
function processChats($chatText, $user=false) {
	if($user===false)
		global $user;
	if(!isMod($user) || isset($_COOKIE['yShout_hideadmlinks']))
		$chatText = preg_replace('/<span class="shout-adminlinks".+?<\/span>/','',$chatText);
	if(!isMod($user))
		$chatText = preg_replace('/<span class="shout-timestamp" title="(\d+) \| [0-9\.]+">/','<span class="shout-timestamp" title="\\1 | logged">',$chatText);
	global $sc;
	if(isMod($user))
		$chatText = preg_replace('/<sesc>/',$sc,$chatText);
	$chatText=preg_replace_callback("/<timeval=(\d+)>/","preg_timeformat",$chatText);
	return $chatText;
}

function readChat($chatPath=false, $force=false) {
	global $user,$reverseShouts;
	if($chatPath === false)
		global $chatPath;
	if(isset($_SESSION['readingCmd']) && !$force)
	{
		$c=$_SESSION['readingCmd'];
		if($c[0]=='/') // it's a command, redo command to retain the message
		{
			if(isMod()) processCommand($c);
			else processUserCommand($c);
		}
		else
			echo $c;
		return ' ';
	}
	$chatText = "";

	if(file_exists($chatPath))
		$chatText = file_get_contents($chatPath);
	$chatText=processChats($chatText,$user);
	if($reverseShouts)
		$chatText=implode("\n", array_reverse(explode("\n", $chatText)));
	return $chatText.' '; // hack: totally empty responses can break some browsers
}

function refreshChats($forceRefresh=false) {
	global $chatPath,$user,$maxLines,$gzipCompression,$updateTimeout,$updatePeriod,$loadedFromSMF;
	if(!file_exists($chatPath))
		writeLine('',$chatPath);
	$time=filemtime($chatPath);
	$start_time=time();
	$heartBeatSent=false;
	if(!$forceRefresh)
	{
		session_write_close(); // so that future session requests succeed
		while((time() - $start_time < $updateTimeout) && ($time==filemtime($chatPath)))
		{
			usleep($updatePeriod*1000);
			// heartbeat - check connection to ensure client is still connected
			echo ' ';
			flush();
			ob_flush();
			$heartBeatSent=true;
			clearstatcache();
		}
		@loadSession();
	}
	if($gzipCompression && !$heartBeatSent) ob_start("ob_gzhandler");
	echo readChat();
	if($gzipCompression && !$heartBeatSent) ob_end_flush();
}

// help and history handlers
function help($command='')
{
	global $user,$defaultEncoding,$txt;
	$cmdlist=$txt['yshout_cmdlist'];

	$cmdlistadmin=$txt['yshout_cmdlistadmin'];
	if(isMod())
		$cmdlist=array_merge($cmdlist,$cmdlistadmin);
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
		<head>
			<meta http-equiv="content-type" content="text/html; charset=<?php echo $defaultEncoding ?>" />
			<title><?php echo $txt['yshout_cmd_reference']; ?></title>
			<style type="text/css">
			/*<![CDATA[*/
			.meaction {
				color: red;
			}
			/*]]>*/
			</style>
		</head>
		<body>
			<?php
			if($command=='')
			{
				echo '<h1>',$txt['yshout_shoutbox'],' ',$txt['yshout_commands'],'</h1><div>';
				foreach($cmdlist as $cmd=>$desc)
				{
					echo "$cmd$desc<br />\n";
				}
				echo '</div>';
			}
			else
			{
				echo '<div>';
				if(isset($cmdlist[$command])) echo "$command{$cmdlist[$command]}<br />\n";
				else echo htmlentities($command)," not found";
				echo '</div>';
			}
			?>
		</body>
	</html>
<?php
}

function history()
{
	global $chatPath,$historyPath,$boardurl,$gzipCompression,$defaultEncoding,$txt;

	$n=250;
	if(isset($_GET['n'])) $n=intval($_GET['n']); // integers only!
	if($gzipCompression) ob_start("ob_gzhandler");
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
		<head>
			<base href="<?php echo $boardurl,'/'; ?>" />
			<meta http-equiv="content-type" content="text/html; charset=<?php echo $defaultEncoding ?>" />
			<title><?php echo $txt['yshout_shoutbox'],' ',$txt['yshout_history']; ?></title>
			<script type="text/javascript">
			//<![CDATA[
			function ajaxGet(args) {
				window.location=window.location+'&'+args+'&'+'sesc=<?php global $sc; echo $sc; ?>';
			}
			//]]>
			</script>
			<style type="text/css">
			/*<![CDATA[*/
			/* form and toollink CSS omitted */
			#yshout {
				font-size: 10px;
				overflow: hidden;
			}
			#yshout #shouts { /* main shouts area */
				color: #000000;
			}
			#yshout .shout { /* one shout */
				margin: 0 0 0; /* Top Bottom Linespacing */
				line-height: 1;
			}
			#yshout .shout-timestamp {
				font-style: normal;
				font-weight: normal;
				color: #000000;
			}
			#yshout .shout-adminlinks { /* del and ban buttons */
				font-size: 6pt;
				color: #141414;
			}
			/* from default theme */
			.meaction {
				color: red;
			}
			a:link {
				color: #476C8E;
			}
			/*]]>*/
			</style>
		</head>
		<body>
			<h1><?php /*echo $txt['yshout_shoutbox'],' ',$txt['yshout_history'];*/ ?></h1>
			<div id="yshout">
				<div id="shouts">
					<?php
						$text='';
						if($historyPath !== '')
						{
							global $user;
							require_once("class.tail.php");
							$mytail = new tail($historyPath);
							$mytail->setGrep(".*");
							$mytail->setNumberOfLines($n);
							$text=$mytail->output(PLAIN);
						}
						$text.=file_get_contents($chatPath);
						echo processChats($text,$user);
					?>
				</div>
			</div>
		</body>
	</html>
<?php
	if($gzipCompression) ob_end_flush();
	exit;
}
?>
