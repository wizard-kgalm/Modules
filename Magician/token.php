<?php
include_once('modules/Magician/functions.php');
$tt=$config['bot']['trigger'];
switch($args[0]){
	case "token":														// I must have not been that bright, still overly long, still using token instead of testlogins.
		if(empty($args[1])){
			return $dAmn->say("$from: Usage: ".$tr."token <i>username [password]</i>. If the username is on the list, it'll try using the password. Otherwise, it'll ask for the password.",$c);
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
			foreach($config['logins']['login'] as $boob => $bies){
				if(strtolower($boob) === strtolower($args[1])){
					$config['token']['username'] = $boob;
					$config['token']['password'] = @base64_decode($bies);// This is likely the only change made to this entire process.
					save_config('bot');
					save_config('token');
					$num = $boob;
					$found = TRUE;
				}
			}
			if($found){
				$toke = token();
				if(empty($toke)){
					return $dAmn->say("$from: No token, bad pass?",$c);
				}
				return $dAmn->say($f ."javascript: dAmn_Login(\"{$args[1]}\",\"{$toke}\");",$c); // We've changed it to use the javascript syntax.. 
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
				$toke = token();
				if(empty($toke)){
					return $dAmn->say("$from: No token, bad pass?",$c);
				}
				return $dAmn->say($f ."javascript: dAmn_Login(\"{$args[1]}\",\"{$toke}\");",$c);
			}
			if(empty($args[2])){
				if(strtolower($from) == strtolower($config['bot']['owner'])){	// Oh look, added filtering so other people can't kill the bot by leaving the password blank.
					$dAmn->say("$from: Place password in bot window.",$c);
					print "\nPlease input {$args[1]}'s password below.\n";
					$args[2] = trim(fgets(STDIN));
				}else
					return $dAmn->say("$from: Username and password required. Do not use in public rooms.",$c);
			}
			$config['token']['username']=$args[1];
			$config['token']['password']=$args[2];
			$toke = token();
				if(empty($toke)){
					return $dAmn->say("$from: No token, bad pass?",$c);
				}
				return $dAmn->say($f ."javascript: dAmn_Login(\"{$args[1]}\",\"{$toke}\");",$c);
		}else
		return $dAmn->say("$from: This is an owner only command.",$c);
		break;	// Cookie commented out below, but left in.
	/*case "cookie":
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
					$config['token']['password'] = @base64_decode($bies);
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
	*/
}//78 lines for one command. Still overly long. This was even fixed to work with the new storage system.
?>