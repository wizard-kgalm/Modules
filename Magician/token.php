<?php
include_once('modules/Magician/functions.php');
if(file_exists("./config/logins.df")){
	$logins = include "./config/logins.df";
}																						// This will ( has ) need updating with the new core. It's been taken care of.
switch($args[0]){																		// Version 5.0. Finally combined these commands.. and moved atswap to here!
	case "login":
	case "token":
		if(empty($args[1]) || empty ($args[2])){										// Here's our thing. Return correct usage on empty command. 
			return $dAmn->say("$from: Usage:{$tr}{$args[0]} <i>username [password]</i>. If the username is on the list, it'll try using the password. Otherwise, it'll ask for the password.",$c);
		}
		if($user->has($from, 99)){
			$tuser = strtolower($args[1]);												// Is our username on the list? Let's check.
			if(isset($logins['login'][strtolower($args[1])])){
				$tpass = base64_decode($logins['login'][strtolower($args[1])]);			// It is, let's decode the password.
			}elseif(isset($logins['hidden'][strtolower($args[1])]) && empty($tpass)){ 	//Perhaps our username isn't on that list. Let's check the secondary one.	
				$tpass = $logins['hidden'][strtolower($args[1])];						// We found it there! Grabbing the password. ( It's never on the hidden list ).
			} else {																	// It's not on either list? Use the second argument as the password
				$tpass = $args[2];
			}
			$tcheck = testlogin($tuser, $tpass);										// Now for the token grabber. Let's send the username and password.
			if(is_array($tcheck)){														// There's an array? Let's show the error so we know what's wrong.
				return $dAmn->say("$from: Error returned. {$tcheck['error']}",$c);
			}
			if($args[0] == "login"){													// For $login, we're going to change the bot's config info. 
				$config['bot']['username'] = $args[1];
				$config['bot']['token'] = $tcheck;
				save_config("bot");
				$dAmn->say("$from: Login accepted. Changing logins, please wait.",$c);
				$dAmn->send("disconnect\n".chr(0));										// We're good to go, kick that disconnect out. 
			}else{
				$dAmn->say("$from: javascript: dAmn_Login(\"{$args[1]}\",\"{$tcheck}\");",$c); // For token, just display the result here, in javascript command format.
			}
		}else 
			return $dAmn->say("$from: This is an owner-only command.",$c);				// This could be earlier in the command, but whatever. 
		break;
	case "atswap":																		// My red-headed stepchild, $atswap. <3 
		if(empty($argsF)){
			return $dAmn->say("$from: Please put your username and authtoken to change logins. If you don't know what an authtoken is, don't use this command.",$c);
		}else	// 7/30/11 below, 7/18/2013 right.										// I'll leave in the following, since I've been mocking that for 5 fucking versions. Haha
		//Since this command involves authtokens, which I don't imagine you have memorized, no sense in allowing it in the bot window, as you can't copypaste in command prompts.
		if(empty($args[2])){
			return $dAmn->say("$from: Username and authtoken required. To login with a password, see {$tr}login. Caution: Do not use in public rooms as this is sensitive info.",$c);
		}
		if(strlen($args[2]) !== 32){ 													// Let's make sure that's 32 characters. Otherwise, you'll have to restart the bot.
			return $dAmn->say("$from: The authtoken must be 32 characters. Try again. If you don't know what one is, don't use this command.",$c);
		}
		$config['bot']['username'] = $args[1];											// Let's plug that info into the $config. 
		$config['bot']['token'] = $args[2];
		save_config('bot');
		$dAmn->say("$from: Token accepted. Changing logins, please wait.",$c);				// Let's send that disconnect, baby. 
		$dAmn->send("disconnect\n".chr(0));
		break;
}// END switch. 58 lines (after moving the comments along the side, like the currant version.
?>