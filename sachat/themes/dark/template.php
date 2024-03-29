<?php
/*
	Since it has been wanted here it is, the chat template.
	Remember you can change the content of the divs but be aware
	that changing or removing ids or class attributes can have negitive
	effects on the chat.
*/
function chat_window_template() { //Main chat window, not the bar, the window you chat to your friends with, duh :P

	global $user_settings, $buddy_settings, $boardurl, $context, $themeurl;

	// The main chat window
	$data ='
			<div id="top_container" onMouseOver="javascript:this.style.cursor=\'move\';">
				<div id="top_cont_x">
					<a href="javascript:void(0)" onclick="javascript:xchat(\''.$buddy_settings['id_member'].'\'); return false;" onMouseOver="document.rollover'.$buddy_settings['id_member'].'.src=image2.src" onMouseOut="document.rollover'.$buddy_settings['id_member'].'.src=image1.src">
						<img name="rollover'.$buddy_settings['id_member'].'" src="'.$themeurl.'/images/x_inactive.png" border="0" alt="X" />
					</a>
				</div>
				<div id="top_cont_avatar">
					<img align="left" width="40px" height="40px" src="'.$buddy_settings['avatar'].'" /><br />&nbsp;<span class="'.($buddy_settings['session']?'green':'red').'">*&nbsp;</span><span class="white">'.$buddy_settings['real_name'].'</span>
				</div>
			</div>
			<div id="mid_container">
				<form id="mid_cont_form" action="javascript:void(0)" onsubmit="javascript:jsubmit(\''.$buddy_settings['id_member'].'\');" method="post">
					<input type="text" name="msg'.$buddy_settings['id_member'].'" id="msg'.$buddy_settings['id_member'].'" style="width: 80%;" maxlength="255" />
					<input type="button" onclick="javascript:jsubmit(\''.$buddy_settings['id_member'].'\'); return false;" value="Send" />
				</form>
			</div>
			<div class="msg_container">
				<div id="cmsg'.$buddy_settings['id_member'].'" class="msg_container2">';
	// Messages from previous chat session that have not been deleted yet, lets show them. :D
	if(!empty($context['msgs'])) {
		foreach ($context['msgs'] as $message) {
			if ($message['from'] == $user_settings['id_member']) { // Messages sent from me.
				$data.='
					<div style="background-color: #D8D8D8;">
						<img width="20px" height="20px" src="'.$user_settings['avatar'].'" />
						<strong>'.$user_settings['real_name'].': </strong>
						'.$message['msg'].'
					</div>';
			} else { // Messages sent by my buddy
				$data.='
					<div id="u'.$buddy_settings['id_member'].'i'.$message['id'].'">
						<img width="20px" height="20px" src="'.$buddy_settings['avatar'].'" />
						<strong>'.$buddy_settings['real_name'].': </strong>
						'.$message['msg'].'
					</div>';
			}
		 }
	}
	$data.='
				</div>
			</div>
			<div class="bot_container">
			</div>
			';
	return $data;
}

function chat_retmsg_template() { //When you recieve a message

	global $buddy_settings, $context;

	// This is where someone sends you a message when your online.
    if(!empty($context['msgs'])) {
		foreach ($context['msgs'] as $message) {
			$data ='
				<div id="u'.$buddy_settings['id_member'].'i'.$message['id'].'">
					<img width="20px" height="20px" src="'.$buddy_settings['avatar'].'" />
					<strong>'.$buddy_settings['real_name'].': </strong>
					'.$message['msg'].'
				</div>';
		}
	return $data;
	}
}

function chat_savemsg_template() { //When you send a message

	global $user_settings, $context;

	// This is the html response when you send a message.
	$data ='<div style="background-color: #D8D8D8;">
					<img width="20px" height="20px" src="'.$user_settings['avatar'].'" />
					<strong>'.$user_settings['real_name'].': </strong>
					'.$context['msgs'].'
				</div>';
	return $data;
}

function chat_bar_template() { //Chat bar template for logged in users, not guest.

	global $boardurl, $themeurl, $modSettings, $context, $OnCount, $txt;

	// jquery google ajax translate, does not work good.
	// It is however coded into 2-SI Chat.
	// Maybe someday it will work, but will have to use the google translate element
	// <div style="float: right; padding-right: 30px; position: relative; bottom: 2px;" id="2sitranslate"> </div>

		
			$data = '
			'.(!$modSettings['2sichat_dis_list'] ? ' <div style="float: right; padding-right: 30px; padding-top: 1px;">':'
			 <div style="float: right; padding-right: 30px; padding-top: 3px;">').'';
			if(!empty($context['gadgetslink'])) {
			foreach ($context['gadgetslink'] as $link) {
			if($link['image']){
				$data.= '
			<a href="'.$link['url'].'" '.(!empty($link['newwin']) ? 'target="blank"' :'').'><img src="'.$link['image'].'" alt="'.$link['title'].'" /></a>&nbsp;';
			  }
			}
			}
			$data.= '
			'.($modSettings['2sichat_ico_myspace'] ? '<a href="javascript:void(0)" onclick="javascript:getSocial(\'myspace\');">
				<img src="'.$themeurl.'/images/myspace.png" width="17" height="17" alt="'.$txt['myspace'].'" border="0">
			</a>':'').'
			'.($modSettings['2sichat_ico_twit'] ? '<a href="javascript:void(0)" onclick="javascript:getSocial(\'twitter\');">
				<img src="'.$themeurl.'/images/twitter.png" width="17" height="17" alt="'.$txt['twitter'].'" border="0">
			</a>':'').'
			'.($modSettings['2sichat_ico_fb'] ? '<a href="javascript:void(0)" onclick="javascript:getSocial(\'facebook\');">
				<img src="'.$themeurl.'/images/facebook.png" width="17" height="17" alt="'.$txt['facebook'].'" border="0">
			</a>':'').'
			'.(!$modSettings['2sichat_dis_list'] ? ' &nbsp;<a href="javascript:void(0)" onclick="javascript:chatSnd();">
				<img id="chat_Snd" src="'.(!empty($_COOKIE["chatSnd"]) ? $themeurl.'/images/mute2.png':$themeurl.'/images/mute1.png').'" />
				</a>':'').'
		</div>';
		
		$data.= '
		<div class="langCont">
			<div id="2siTranslate"></div>
		</div>
		'.($modSettings['2sichat_dis_list'] ? '':'
		<a class="white" href="javascript:void(0)" onclick="javascript:showhide(\'friends\');">
			<img src="'.$themeurl.'/images/balloon.png" alt="{}" border="0"><strong>'.$txt['whos_on'].' ('.$OnCount.')</strong>
		</a>');
         
	      if(!empty($context['gadgets'])) {
		 $data .=''.(!$modSettings['2sichat_dis_list'] ? '&nbsp;&nbsp;|&nbsp;&nbsp;':'').'';
			foreach ($context['gadgets'] as $gadget) {
				$data.= '
				'.(!$modSettings['2sichat_dis_list'] ? '':'<span style="float: left; padding-left: 0px; padding-top: 4px;">').'
			<a class="white" href="javascript:void(0)" onclick="javascript:openGadget(\''.$gadget['id'].'\');"><strong>'.$gadget['title'].'</strong></a></span>';
			if(count($context['gadgets'],2) > 1) {
		    $data.= '
		   '.(!$modSettings['2sichat_dis_list'] ? '':'<span style="float: left; padding-left: 0px; padding-top: 4px;">').'
		   &nbsp;&nbsp;|&nbsp;&nbsp;</span>';
		  }
		  }
		}
	return $data;
}

function buddy_list_template() { //The buddy list.

	global $context, $user_settings, $themeurl;

	$data ='
		<div id="friends_top">
			<div id="friends_x">
				<a href="javascript:void(0)" onclick="javascript:showhide(\'friends\');" onMouseOver="document.fx.src=image2.src" onMouseOut="document.fx.src=image1.src">
					<img name="fx" src="'.$themeurl.'/images/x_inactive.png" border="0" alt="X" />
				</a>
			</div>
		</div>
		<div id="friends_bottom">';

     if(!empty($context['friends'])) {
		foreach ($context['friends'] as $buddy) {
		$user_settings = loadUserSettings($buddy['id_member']);
			$data.= '
				<a class="'.($buddy['session']?'green':'red').'" href="javascript:void(0)" onclick="javascript:chatTo(\''.$buddy['id_member'].'\');showhide(\'friends\');return false;">
				<img width="20px" height="20px" src="'.$user_settings['avatar'].'" />&nbsp;<strong>'.$buddy['real_name'].'</strong>&nbsp;<span class="'.($buddy['session']?'green':'red').'">*</span>
				</a><br />';
		}
	}
	$data.="
			<br /><br />
		</div>";
	return $data;
}

function guest_bar_template() { //Well guest can't access everything.

	global $boardurl, $themeurl, $modSettings, $txt, $context;

			$data = '
			<div style="float: right; padding-right: 30px; padding-top: 3px;">';
			if(!empty($context['gadgetslink'])) {
			foreach ($context['gadgetslink'] as $link) {
			if($link['image']){
				$data.= '
			<a href="'.$link['url'].'" '.(!empty($link['newwin']) ? 'target="blank"' :'').'><img src="'.$link['image'].'" alt="'.$link['title'].'" /></a>&nbsp;';
			  }
			}
			}
			$data.= '
			'.($modSettings['2sichat_ico_myspace'] ? '<a href="javascript:void(0)" onclick="javascript:getSocial(\'myspace\');">
				<img src="'.$themeurl.'/images/myspace.png" width="17" height="17" alt="'.$txt['myspace'].'" border="0">
			</a>':'').'
			'.($modSettings['2sichat_ico_twit'] ? '<a href="javascript:void(0)" onclick="javascript:getSocial(\'twitter\');">
				<img src="'.$themeurl.'/images/twitter.png" width="17" height="17" alt="'.$txt['twitter'].'" border="0">
			</a>':'').'
			'.($modSettings['2sichat_ico_fb'] ? '<a href="javascript:void(0)" onclick="javascript:getSocial(\'facebook\');">
				<img src="'.$themeurl.'/images/facebook.png" width="17" height="17" alt="'.$txt['facebook'].'" border="0">
			</a>':'').' </div>';
	$data.= '
		<div class="langCont">
			<div id="2siTranslate"></div>
		</div>
		<div style="float: left; padding-left: 5px; padding-top: 3px;">
		<span class="white">
		'.$txt['guest_msg'].'
		</span>';
		
	     if(!empty($context['gadgets'])) {
			foreach ($context['gadgets'] as $gadget) {
				$data.= '
			&nbsp;&nbsp;|&nbsp;&nbsp;<a class="white" href="javascript:void(0)" onclick="javascript:openGadget(\''.$gadget['id'].'\');"><strong>'.$gadget['title'].'</strong></a> </div>';
			}
		}
		$data .='</div>';

	return $data;
}

function gadget_template() {
	
	global $boardurl, $themeurl, $context;

	$data ='
			<div id="top_container" style="position:relative;top:7px;right:2px;" onMouseOver="javascript:this.style.cursor=\'move\';">
				<div id="top_cont_x">
					<a href="javascript:void(0)" onclick="javascript:closeGadget(\''.$context['gadget']['id'].'\'); return false;" onMouseOver="document.rolloverGad'.$context['gadget']['id'].'.src=image2.src" onMouseOut="document.rolloverGad'.$context['gadget']['id'].'.src=image1.src">
						<img name="rolloverGad'.$context['gadget']['id'].'" src="'.$themeurl.'/images/x_inactive.png" border="0" alt="X" />
					</a>
				</div>
				<div id="top_cont_gadget">'.$context['gadget']['title'].'</div>
			</div>
			<object id="gadget'.$context['gadget']['id'].'" type="text/html" data="'.(substr($context['gadget']['url'], 0, 4) == 'http' ? $context['gadget']['url']:$boardurl.'/sachat/index.php?gid='.$context['gadget']['id'].'&src=true').'" width="'.$context['gadget']['width'].'" height="'.$context['gadget']['height'].'" style"overflow:hidden;" hspace="0" vspace="0"></object>';
	return $data;
}

function gadgetObject_template() {

	global $context;

	$data ='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>'.$context['gadget']['title'].'</title>
	</head>
	<body style="background-color: #B8B8B8;padding:1;margin:1;">
	'.$context['gadget']['url'].'
	</body>
</html>';
	return $data;
}
?>