<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Shoutbox</title>
<?php
// YSHOUT HERE - <head> code
global $boardurl,$shoutFile;
$boardurl=".."; // change this to the relative or absolute path to the forum root
$shoutFile='home';
if(!file_exists("$boardurl/Themes"))
	die("Can't find Themes directory -- is \"$boardurl\" the correct path to the forum root?");
if(file_exists("$boardurl/Themes/default/script.js"))
	echo '<script src="',$boardurl,'/Themes/default/script.js" type="text/javascript"></script>';
else
	echo '<script src="',$boardurl,'/Themes/default/scripts/script.js" type="text/javascript"></script>
<script type="text/javascript">var smf_charset="UTF-8";</script>';
echo '
<script src="',$boardurl,'/yshout/js/moo.ajax.js" type="text/javascript"></script>
<script src="',$boardurl,'/yshout/settings.js" type="text/javascript"></script>
<script type="text/javascript">
window.onload=function(){loadChat();};
var shoutFile="',$shoutFile,'";
var yshout_php="',$boardurl,'/index.php?yshout";
</script>
<script src="',$boardurl,'/yshout/js/yshout.js?July062008" type="text/javascript"></script>
<style type="text/css">
	#yshout {
		font-size: 10px;
		overflow: hidden;
	}
	#yshout #yshout-toollinks { /* tool links (History, Commands, etc.) */
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
	#yshout #shout-form {
		margin: 0;
		padding: 0;
	}
	#yshout #shout-form fieldset {
		border: none;
	}
	#yshout #forum-name {
		color: #666666;
		width: 70px;
		margin-right: 5px;
	}
	#yshout #shout-text {
		color: #000000;
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
?>
</head><body><h4>Shoutbox</h4>
<div id="yshout">Loading...</div>
</body>
</html>