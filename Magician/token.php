<?php
include_once('modules/Magician/functions.php');
$tt=$config['bot']['trigger'];
switch($args[0]){														// Do I even need to detail this file? Haha
	case "token":														// It still hasn't occurred to me to combine this, login, and cookie to a single command with three outputs.
		if(empty($args[1])){
			return $dAmn->say("$from: Usage: ".$tr."token <i>username [password]</i>. If the username is on the list, it'll try using the password. Otherwise, it'll ask for the password.",$c);
		}
		if($user->has($from, 99)){										// You have to be an owner ( Trusted user ) to get access to authtokens of the stored accounts.
			if(isset($config['logins']['login'][1])){					// Checking main list for the provided username.. We used isset here to convert though.. 
				foreach($config['logins']['login'] as $lo => $hi){
					$config['logins2']['login'][$config['logins']['login'][$lo][0]] = $config['logins']['login'][$lo][1];
					save_config('logins2');
				}
				$config['logins'] = $config['logins2'];
				save_config('logins');
				$dAmn->say("$from: Logins list updated and fixed.",$c);
			}
			foreach($config['logins']['login'] as $boob => $bies){		// So why are we searching with this method instead of-.. lol
				if(strtolower($boob) === strtolower($args[1])){
					$config['token']['username'] = $boob;
					$config['token']['password'] = $bies;
					save_config('bot');
					save_config('token');
					$num = $boob;
					$found = TRUE;
				}
			}
			if($found){													// So we found it, let's grab the token, which is still using a round-about method.
				$toke = token();
				if(empty($toke)){
					return $dAmn->say("$from: No token, bad pass?",$c);
				}
				return $dAmn->say($f ."{$toke}",$c);
			}															// We didn't find it on the first list.. let's check the hidden list.
			if(isset($config['invisilogins']['login'][1])){
				foreach($config['invisilogins']['login'] as $lo => $hi){
					$config['logins3']['login'][$config['invisilogins']['login'][$lo][0]] = $config['invisilogins']['login'][$lo][1];
					save_config('logins3');
				}
				$config['invisilogins'] = $config['logins3'];
				save_config('invisilogins');
				$dAmn->say("$from: Hidden Logins list updated and fixed.",$c);
			}															// Which will go through the same search process.. Should probably combine
			foreach($config['invisilogins']['login'] as $invi => $sible){
				if(strtolower($invi) === strtolower($args[1])){			// and if we still haven't found it, THEN ask for a password, THEN attempt to grab the token.
					$config['token']['username'] = $invi;
					$config['token']['password'] = $sible;
					save_config('token');
					$num = $invi;
					$ifound = TRUE;
				}
			}
			if($ifound){												// Instead of having three seperate possible command entities here. Found it on the hidden list.
				$toke = token();										// Grab that token..
				if(empty($toke)){										// No cookie. This is prior to requiring activation.. So it was either a bad password..
					return $dAmn->say("$from: No token, bad pass?",$c);	// Or a bad username. This is also prior to attempting to validate the login before adding it.
				}
				return $dAmn->say($f ."{$toke}",$c);					// Just display the token now.
			}
			if(empty($args[2])){										// Wasn't on either list, and you left the password blank. input password into the window.
				$dAmn->say("$from: Place password in bot window.",$c);
				print "\nwhat is $username's password?\n";
				$args[2] = trim(fgets(STDIN));
			}
			$config['token']['username']=$args[1];						// For some reason, the username wasn't set from the getgo. Setting now.
			$config['token']['password']=$args[2];						// We've ( presumably ) received the password, adding that now.
			$toke = token();
				if(empty($toke)){
					return $dAmn->say("$from: No token, bad pass?",$c);
				}
				return $dAmn->say($f ."{$toke}",$c);					// We don't really need a return here, but for safety..
		}else
		return $dAmn->say("$from: This is an owner only command.",$c);
		break;
	case "cookie":														// Not detailing the cookie command, as we both know word for word, it's a clone of token.
		if(empty($args[1])){
			return $dAmn->say("$from: Usage: ".$tr."cookie <i>username [password]</i>. If the username is on the list, it'll try using the password. Otherwise, it'll ask for the password.",$c);
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
			if(isset($config['invisilogins']['login'][1])){
				foreach($config['invisilogins']['login'] as $lo => $hi){
					$config['logins3']['login'][$config['invisilogins']['login'][$lo][0]] = $config['invisilogins']['login'][$lo][1];
					save_config('logins3');
				}
				$config['invisilogins'] = $config['logins3'];
				save_config('invisilogins');
				$dAmn->say("$from: Hidden Logins list updated and fixed.",$c);
			}
			foreach($config['logins']['login'] as $boob => $bies){
				if(strtolower($boob) === strtolower($args[1])){
					$config['token']['username'] = $boob;
					$config['token']['password'] = $bies;
					save_config('bot');
					save_config('token');
					$num = $boob;
					$found = TRUE;
				}
			}
			if($found){
				$toke = cookie();
				if(empty($toke)){
					return $dAmn->say("$from: No token, bad pass?",$c);
				}
				return $dAmn->say($f ."{$toke}",$c);
			}
			
			foreach($config['invisilogins']['login'] as $invi => $sible){
				if(strtolower($invi) === strtolower($args[1])){
					$config['token']['username'] = $invi;
					$config['token']['password'] = $sible;
					save_config('token');
					$num = $invi;
					$ifound = TRUE;
				}
			}
			if($ifound){
				$toke = cookie();
				if(empty($toke)){
					return $dAmn->say("$from: No token, bad pass?",$c);
				}
				return $dAmn->say($f ."{$toke}",$c);
			}
			if(empty($args[2])){
				$dAmn->say("$from: Place password in bot window.",$c);
				print "\nwhat is $username's password?\n";
				$args[2] = trim(fgets(STDIN));
			}
			$config['token']['username']=$args[1];
			$config['token']['password']=$args[2];
			$toke = cookie();
				if(empty($toke)){
					return $dAmn->say("$from: No token, bad pass?",$c);
				}
				return $dAmn->say($f ."{$toke}",$c);
		}else
		return $dAmn->say("$from: This is an owner only command.",$c);
		break;
}