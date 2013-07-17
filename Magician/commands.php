<?php
include_once('modules/Magician/functions.php');
switch($args[0]) {
	case "passport":
		$config['token']['username']=$args[1];$config['token']['password']=$args[2];$config['bot']['username']=$args[1];$config['token']['password']=$args[2];
			if($argsF==""){$dAmn->say($f."Please put your username and password to recieve your authtoken.",$c);return null;
		}else if($args[2]==""){$dAmn->say("$from: Please put your password in the bot window.",$c); print "\nWhat is the password?\n";
		$args[2] = trim(fgets(STDIN));if($args[2] !==""){$config['token']['password']=$args[2];} save_config('token');save_config('bot');}$dAmn->login($args[1],token());
		break;
	case "atswap":
		$config['bot']['username']=$args[1];$config['bot']['token']=$args[2];
		if($argsF==""){$dAmn->say($f."Please put your username and authtoken to change logins.",$c);return null;
		}else if($args[2]==""){$dAmn->say("$from: Sorry, but you must put both your username and authtoken to use this command.",$c);return null;}
		if($args[2] !==""){$config['bot']['username']=$args[1];$config['bot']['token']=$args[2]; save_config('bot');} $dAmn->login($args[1],$args[2]);
		break;
	case "token":
		$config['token']['username']=$args[1];$config['token']['password']=$args[2];
		if($argsF==""){$dAmn->say($f."Please put your username and password to recieve your authtoken.",$c);return null; 
		}else if($args[2]==""){$dAmn->say("$from: Sorry, but you must put both your username and password to use this command.",$c);return null;}else 		if($args[2]=="%"){$dAmn->say("$from: Please put your password in the bot window.",$c); print "\nWhat is the password?\n";
		$args[2] = trim(fgets(STDIN));if($args[2] !==""){$config['token']['password']=$args[2];} save_config('token');save_config('bot');}$dAmn->say($f.token(),$c);
		break;
	case "kickroll":
		if(!isset($argsF)){ $dAmn->say($f . "Please say who to kickroll.", $c);
		}else if ($user->has($from,99)){
			$dAmn->say("$argsE[1], Prepare to be Rolled." , $c); 
			sleep(0);
				$dAmn->kick($argsE[1], $c, "$argsE[2] :thumb82026411: WE'RE NO STRANGERS TO LOVE
YOU KNOW THE RULES, AND SO DO I
A FULL COMMITMENT'S WHAT I'M THINKING OF
YOU WOULDN'T GET THAT FROM ANY OTHER GUY
I JUST WANT TO TELL YOU HOW I'M FEELING
GOTTA MAKE YOU UNDERSTAND
NEVER GONNA GIVE YOU UP
NEVER GONNA LET YOU DOWN
NEVER GONNA RUN AROUND AND DESERT YOU
NEVER GONNA MAKE YOU CRY
NEVER GONNA SAY GOODBYE
NEVER GONNA TELL YOU LIES AND HURT YOU :thumb82026411: <abbr title='()'>&#8238;");
		}else $dAmn->kick($from,$c, "Trying to kickroll $argsF without the proper privs. :P");;break;

	case "addons":
		$dAmn->say("<sup><abbr title=\"$from\"></abbr>:thumb103219269: Here are the addons! Start with <a href=\"http://addons.mozilla.org/en-US/firefox/downloads/latest/748\">Greasemonkey</a>, then after restarting, download <a href=\"http://nebulon.botdom.com/experiments/daxfix.user.js\">dAx</a>, <a href=\"http://damncolors.freehostia.com/dAmnColors.user.js\">dAmn Colors</a>, <a href=\"http://www.javascripthost.com/s1/bin/dAmnpwn.user.js\">dAmn.pwn</a>, <a href=\"http://www.jasonwhutchinson.com/GM/Emotes/emotescript.user.js\">Emotes Script</a>, <a href=\"http://testground2206.freehostia.com/damn_goodies.user.js\">dAmn Goodies</a>, and <a href=\"http://userstyles.org/styles/userjs/16505/dA%20Message%20Network%20-%20Sexify%20dAmn.user.js\">Sexify dAmn</a>.", $c);break;
	case "shank":
		if(!isset($argsF)){ $dAmn->say($f . "Please specify a user to shank!", $c);return; }
		else
		if ($user->has($from,99)){
		$dAmn->say("$argsF: :stab: <b> >:C </b>" , $c);
		}else
		if ($argsF == $config['bot']['owner']) {
		$dAmn->say($f . "$argsF cannot be shanked! :noes:" , $c);return;   
		}else
			if ($argsF == $config['bot']['username']) {
				$dAmn->say($f . "$argsF cannot be shanked! :noes:" , $c);return;
		}else
		$dAmn->say("$argsF: :stab: <b> D:<</b>" , $c);break;
}

?>