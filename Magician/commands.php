<?php
include_once('modules/Magician/functions.php');
$tt=$config['bot']['trigger'];
switch($args[0]){														// Version 4.0.. Released 7/16/2011 ( That's 1.5 years after the previous version ).
	case "atswap":														// Good ol' $atswap. Still heading the game, here.<3 
		$config['bot']['username']=$args[1];
		$config['bot']['token']=$args[2];
		if($argsF==""){
			$dAmn->say($f."Please put your username and authtoken to change logins.",$c);
			return null;
		}else
		if($args[2]==""){												// Totally gonna input a 32 character token in the bot window.
			$dAmn->say("$from: Please put your authtoken in the bot window.",$c);
			print "\nWhat is the authtoken?\n";
			$args[2] = trim(fgets(STDIN));				
		}
		if($args[2] !==""){
			$config['bot']['username']=$args[1];
			$config['bot']['token']=$args[2];
			save_config('bot');
		} 
		$dAmn->send("disconnect\n".chr(0));								// Let's change accounts now. Send the disconnect.
		break;
	case "show":														// What do you know, this made it well into 2011. Did not know that. 
		switch($args[1]) {
			case "logins":
				if($args[2] !=""){
					if($args[2] !="list"){
						$dAmn->say($f. "Usage: ".$config['bot']['trigger']."show logins list.",$c);
						return null;
					}else
					$say="";
					if(!empty($config['logins']['login'])){
						$say .="<sup>The logins you have stored are:<br/>";
						foreach($config['logins']['login'] as $id=>$us){
							ksort($id);
							$say .= " {$id} | ";
						}
					}else
						$say .="$from: There aren't currently any usernames stored.";
						$dAmn->say($say,$c);
				}else
					$dAmn->say($f. "Usage: ".$config['bot']['trigger']."token logins list.",$c);
				break;
		}break;
	case "me":																// Ah, added $me to the repertoire. 
		if($args[1][0] == "#"){ 											// Just so it's recorded, this was for $input, but added here for command usage anyway.
			$dAmn->me($argsE[2],$args[1]);
		}else
			$dAmn->me($argsF,$c);
		break;
	case "npmsg":															// $npmsg, same as the above. Added for use with input.
		if($args[1][0] == "#"){
			$dAmn->npmsg($argsE[2],$args[1]);
		}else
			$dAmn->npmsg($argsF,$c);
		break;
	case "login":
		if(empty($args[1])){												// This command seems relatively unchanged from previous versions.
			return $dAmn->say("$from: Usage: ".$tr."login <i>username [password]</i>. If the login is on the list, it'll try using the password. Otherwise, it'll ask for the password.",$c);
		}
		if($user->has($from, 99)){
			if(isset($config['logins']['login'][1])){
				foreach($config['logins']['login'] as $lo => $hi){
					$config['logins2']['login'][$config['logins']['login'][$lo][0]] = $config['logins']['login'][$lo][1];
					save_config('logins2');
				}
				$config['logins'] = $config['logins2'];
				save_config('logins');
				$dAmn->say("$from: Logins list updated and fixed.",$c);
			}
			if(isset($config['invisilogins'])){
				if(isset($config['invisilogins']['login'][1])){
					foreach($config['invisilogins']['login'] as $lo => $hi){
						$config['logins3']['login'][$config['invisilogins']['login'][$lo][0]] = $config['invisilogins']['login'][$lo][1];
						save_config('logins3');
					}
					$config['invisilogins'] = $config['logins3'];
					save_config('invisilogins');
					$dAmn->say("$from: Hidden Logins list updated and fixed.",$c);
				}
			}
			foreach($config['logins']['login'] as $boob => $bies){
				if(strtolower($boob) === strtolower($args[1])){
					$config['bot']['username'] = $boob;
					$config['token']['username'] = $boob;
					$config['token']['password'] = @base64_decode($bies);		// This must be the version where I introduced base64_encode. Only to the original list.
					save_config('bot');save_config('token');
					$num = $boob;
					$found = TRUE;
				}
			}
			if($found){															// Oh look, I called upon token for the $login command.. That's weird of me.
				$toke = token();
				if(empty($toke)){												// I also neglected to return the reason for failure.. Since it's given now.
					return $dAmn->say("$from: No token, bad pass?",$c);
				}
				$config['bot']['token'] = $toke;
				$dAmn->say($f ."Login accepted. Changing logins, please wait.",$c);
				return $dAmn->send("disconnect\n".chr(0));
			}
			foreach($config['invisilogins']['login'] as $invi => $sible){		// And I didn't combine this. I must not have had a breakthrough or something yet. 
				if(strtolower($invi) === strtolower($args[1])){
					$config['bot']['username'] = $invi;
					$config['token']['username'] = $invi;
					$config['token']['password'] = $sible;
					save_config('bot');save_config('token');
					$num = $invi;
					$ifound = TRUE;
				}
			}
			if($ifound){														// We're still obnoxiously verbose. Needs some serious trimming. 
				$toke = token();
				if(empty($toke)){
					return $dAmn->say("$from: No token, bad pass?",$c);
				}
				$config['bot']['token'] = $toke;
				$dAmn->say($f ."Login accepted. Changing logins, please wait.",$c);
				return $dAmn->send("disconnect\n".chr(0));
			}
			if(empty($args[2])){
				if(strtolower($from) == strtolower($config['bot']['owner'])){
					$dAmn->say("$from: Place password in bot window.",$c);
					print "\nPlease input {$args[1]}'s password below.\n";
					$args[2] = trim(fgets(STDIN));
				}else
					return $dAmn->say("$from: Username and password required.",$c);
			}
			$config['bot']['username'] = $args[1];
			$config['token']['username'] = $args[1];
			$config['token']['password'] = $args[2];
			$toke = token();
			if(empty($toke)){
				return $dAmn->say("$from: No token, bad pass?",$c);
			}
			$config['bot']['token'] = $toke;
			save_config("bot");
			$dAmn->say($f ."Login accepted. Changing logins, please wait.",$c);
			$dAmn->send("disconnect\n".chr(0));
		}else
			return $dAmn->say("$from: This is an owner only command.",$c);
		break;
	case "kickroll":
		if(!isset($argsF)){
			$dAmn->say($f . "Please say who to kickroll.", $c);
		}else
		if ($user->has($from,99)){
			$dAmn->say("$args[1], Prepare to be Rolled." , $c); 
			sleep(0);
			$dAmn->kick($args[1], $c, "$argsE[2] :thumb82026411: WE'RE NO STRANGERS TO LOVE
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
NEVER GONNA TELL YOU LIES AND HURT YOU :thumb82026411: <abbr title='()'>&#09;");
		}else
			$dAmn->kick($from,$c, "Trying to kickroll $argsF without the proper privs. =P");
		break;

	case "addons":	// Oh look, we updated addons to include superdAmn instead of dAx. 
		$dAmn->say("<sup><abbr title=\"$from\"></abbr>:thumb103219269: Here are the addons! Start with <a href=\"http://addons.mozilla.org/en-US/firefox/downloads/latest/748\">Greasemonkey</a>, <a href=\"http://addons.mozilla.org/en-US/firefox/downloads/file/76721/damnautojoin-0.4.0-fx.xpi\">dAmn Autojoin</a>, then after restarting, download <a href=\"http://temple.24bps.com/superdamn/superdamn.user.js\">SuperdAmn</a>, <a href=\"http://damncolors.nol888.com/dAmnColors.user.js\">dAmn Colors</a>, <a href=\"http://botspam.webs.com/damn_goodies.user.js\">dAmn Goodies</a>, and <a href=\"http://userstyles.org/styles/userjs/16505/dA%20Message%20Network%20-%20Sexify%20dAmn.user.js\">Sexify dAmn</a>, <a href=\"http://temple.24bps.com/public/damntcf.user.js\" title=\"\">Tabcolor fix</a>, <a href=\"http://temple.24bps.com/public/tinydamn.user.js\" title=\"\">TinydAmn</a>, <a href=\"http://userscripts.org/scripts/source/32307.user.js\" title=\"\">Word breaker</a>.", $c);
		break;
	case "shank":															// We also added an array of shanking 
		$shanks = array(':stab: <b> >:C </b>',':stab: <b>D:< </b>',':thumb95624834:<b> >:C </b>',':thumb95624834: <b> D:< </b>',);
		$shanking = $shanks[array_rand($shanks)];
		if(!isset($argsF)){
			$dAmn->say("$from: ". $shanking, $c);
		}else
		if ($user->has($from,99)){
			$dAmn->say("$argsF: ". $shanking, $c);
		}else
		if ($argsF == $config['bot']['owner']) {
			$dAmn->say($f . "$argsF cannot be shanked! :noes:" , $c);
			return;   
		}else
		if ($argsF == $config['bot']['username']) {
			$dAmn->say($f . "$argsF cannot be shanked! :noes:" , $c);
			return;
		}else
		$dAmn->say("$argsF: " .$shanking, $c);
		break;
} // Break switch, end of file. 188 lines. We got longer, thanks to $me and $npmsg.
?>