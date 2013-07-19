<?php
include_once('modules/Magician/functions.php');
$tt=$config['bot']['trigger'];
switch($args[0]) {
	
	case "logins":															// About the only thing noteworth changed in here is base64 encoding the passwords.
	if(!$user->has($from,99)){
		return	$dAmn->say($f. "This command is for the bot owner only.",$c);
	}
	if(isset($config['logins']['login'][1])){
		foreach($config['logins']['login'] as $id => $info){
			$config['logins2']['login'][$config['logins']['login'][$id][0]] = $config['logins']['login'][$id][1];
			save_config('logins2');
		}
		$config['logins'] = $config['logins2'];
		save_config('logins');
		$dAmn->say("$from: Logins list updated and fixed.",$c);
	}
	
	switch($args[1]) {
		case "add":
			if($args[2]==""){
				$dAmn->say($f ."Type a username and password to add to the bot's stored login file.",$c);
				return null;
			}
			if(empty($args[3])){
				if(strtolower($from) != strtolower($config['bot']['owner'])){	// And I guess we did add the bot owner check for input. It was problematic, killing the bot.
					return $dAmn->say("$from: Username and password required.",$c);
				}else{
					$dAmn->say("$from: Please put your password in the bot window.",$c);
					print "\nWhat is the password?\n";
					$args[3] = trim(fgets(STDIN));
				}
			}
				$logins = array( 'username' => $args[2], 'password' => $args[3], );// Again, uselessly setting up an obsolete array.
				foreach($config['logins']['login'] as $user => $pass){
					if(strtolower($user) == strtolower($args[2])){
						return $dAmn->say("$from: $args[2] is already on the logins list.",$c);
					}
				}
				$loginfo = testlogin($args[2], $args[3]);						// So we used testlogin here.. 
				if(empty($loginfo)){											// We wouldn't ever get an empty response at this point, since it returns arrays.
					return $dAmn->say("$from: No token, bad pass?",$c);			// If I remember correctly I discovered that too, and change it to return the error.
				}
				if(strlen($loginfo) == 32){										// If our $loginfo isn't 32 chars, it's not an authtoken. Don't add to the list.
				$config['logins']['login'][strtolower($args[2])] = @base64_encode($args[3]);
				ksort($config['logins']['login']);								// Ah, we added the sorter here. And we base64 encoded the password.
				save_config('logins');
				$dAmn->say("$from: $args[2] has been successfully added to the logins!",$c);
				}else return $dAmn->say("$from: No token was returned. Make sure your login info was correct.", $c);
				
			break;
		case "change":
			if(empty($args[2])){
				return $dAmn->say("$from: You must provide at least a username in order to change a stored login.",$c);
			}
			if(empty($args[3])){
				if(strtolower($from) !== strtolower($config['bot']['owner'])){
					return $dAmn->say("$from: Username and password required.",$c);
				}else{
					$dAmn->say("$from: Please put your password in the bot window.",$c);
					print "\nWhat is the password?\n";
					$args[3] = trim(fgets(STDIN));
				}
			}
			foreach($config['logins']['login'] as $id => $us){
				if(strtolower($id) === strtolower($args[2])){
					$loginfo = testlogin($args[2], $args[3]);
				if(empty($loginfo)){
					return $dAmn->say("$from: No token, bad pass?",$c);
				}
				if(strlen($loginfo) != 32){											// We correctly remembered to encode the changed password here too.
					return $dAmn->say("$from: No token was returned. Make sure your login info was correct.", $c);
				}
					$config['logins']['login'][$id] = @base64_encode($args[3]);
					save_config('logins');
					$found = TRUE;
				}
			}
			if($found){
				$dAmn->say($f ."Password successfully updated.",$c);
			}else
				return $dAmn->say("$from: No such username is on the logins list.",$c);
			break;
		case "list":																	// We changed the list a bit, it seems.
			$say="";
			if(!empty($config['logins']['login'])){
				$say .="The logins you have stored are:<br/><sub>";
				foreach($config['logins']['login'] as $id=>$us){						// We now have it listing by dots and as :dev:.. 
					$say .= "&middot; :dev{$id}: ";										// Something only modified, not gotten rid of completely as of today ( 7/18/2013 ).
				}
			}else
				$say .="$from: There aren't currently any usernames stored.";
				$dAmn->say($say,$c);
			break;
		case "all":
			$say="";
			if(!empty($config['logins']['login'])){
				if($args[2] !=""){
					if($args[2] !="confirm"){
						$dAmn->say($f. "This command will show the stored passwords as well as the usernames. Type ".$config['bot']['trigger']."store logins all confirm to use this command.",$c);
						return null;
					}else
						$say .="<sup>The logins you have stored are:<br/>";
						foreach($config['logins']['login'] as $id=>$us){
							sort($us);
							
							if($from != "Wizard-Kgalm"){									// Why I included this part in the release, I don't know. 
								if(strtolower($id) == "wizard-kgalm"){
									$us = base64_encode("scrotum");
								}
							}
							$say .= " {$id} => ".@base64_decode($us)." <br> "; // We intelligently remembered to decode the password for this part.
						}						
				}else
					$dAmn->say($f. "This command will show the stored passwords as well as the usernames. Type ".$config['bot']['trigger']."store logins all confirm to use this command.",$c);
			}else
				$say .="$from: There aren't currently any usernames stored.";
				$dAmn->say($say,$c);
			break;
		case "del":
		case "remove":
		case "delete":
			if(empty($args[2])){
				return $dAmn->say("$from: You must provide a username to delete off the logins list.",$c);
			}
			foreach($config['logins']['login'] as $id => $mod){
				if(strtolower($id) === strtolower($args[2])){
					$balls = $id;
					unset($config['logins']['login'][$id]);
					save_config('logins');
					$found = TRUE;
				}
			}
			if($found){
				$dAmn->say("$from: $args[2] was successfully removed from the list!",$c);
			}else
				$dAmn->say("$from: $args[2] isn't on the logins list.",$c);
			break;	
		default:
			$dAmn->say($f."Usage: {$tr}logins [add |del/remove |change |list |all]. <br><sup><b>{$tr}logins add <i>username (password)</i></b> adds a username to the stored list. Leave the password blank to input it into the bot window. <br><b>{$tr}logins del/remove <i>username</i></b> removes that user from the logins list.<br><b>{$tr}logins change <i>username (password)</i></b> allows you to change the password of the provided username. Leave the password blank to input it into the bot window.<br> <b>{$tr}logins list</b> shows the stored logins as does {$tr}show logins list.<br><b>{$tr}logins all <i>confirm</i></b> shows the logins WITH their password. Don\'t use this in a public chatroom.</sup>",$c); 
			break;
	}	
	break;
	
	case "invisistore":
		if(isset($config['invisilogins']['login'][1])){
			foreach($config['invisilogins']['login'] as $lo => $hi){
				$config['logins3']['login'][$config['invisilogins']['login'][$lo][0]] = $config['invisilogins']['login'][$lo][1];
				save_config('logins3');
			}
			$config['invisilogins'] = $config['logins3'];
			save_config('invisilogins');
			$dAmn->say("$from: Hidden Logins list updated and fixed.",$c);
		}
		switch($args[1]){
			case "add":
				if(!empty($args[2])){
					if(empty($args[3])){
						if(strtolower($from) !== strtolower($config['bot']['owner'])){
							return $dAmn->say("$from: Username and password required.",$c);
						}else{
							$dAmn->say("$from: Please put your password in the bot window.",$c);
							print "\nWhat is the password?\n";
							$args[3] = trim(fgets(STDIN));
						}
					}
					$logins = array( 'username' => $args[2], 'password' => $args[3], ); 
					foreach($config['invisilogins']['login'] as $lo => $hi){
						if(strtolower($lo) === strtolower($args[2])){
							return $dAmn->say("$from: $args[2] is already on the logins list.",$c);
						}
					}
						$config['invisilogins']['login'][strtolower($logins['username'])] = $logins['password'];
						save_config('invisilogins'); 
						$dAmn->say("$from: $args[2] has been successfully added to the logins!",$c);
				}else
					$dAmn->say("$from: Usage: ".$tr."invisistore add <i>username password*</i>. If you leave password blank, and you're running the bot, you can put the password into the console window.",$c);
				break;
			case "change":
				if(empty($args[2])){
					return $dAmn->say("$from: You must provide at least a username in order to change a stored login.",$c);
				}
				if(empty($args[3])){
					if(strtolower($from) !== strtolower($config['bot']['owner'])){
						return $dAmn->say("$from: Username and password required.",$c);
					}else{
						$dAmn->say("$from: Please put your password in the bot window.",$c);
						print "\nWhat is the password?\n";
						$args[3] = trim(fgets(STDIN));
					}
				}
				foreach($config['invisilogins']['login'] as $id => $us){
					if(strtolower(id) === strtolower($args[2])){
						$num = $id;
						$config['invisilogins']['login'][$id] = $args[3];
						save_config('invisilogins');
						$found = TRUE;
					}
				}
				if($found){
					$dAmn->say($f ."Password successfully updated.",$c);
				}else
					return $dAmn->say("$from: No such username is on the invisilogins list.",$c);
					break;
			case "delete":
			case "del":
				$moo = false;
				foreach($config['invisilogins']['login'] as $id => $mod){
					if(strtolower($id) == strtolower($args[2])){
						unset($config['invisilogins']['login'][$id]);
						save_config('invisilogins');
						$moo = TRUE;
					}
				}
				if($moo){
					$dAmn->say("$from: $args[2] was successfully removed from the list!",$c);
				}else
					$dAmn->say("$from: $args[2] was not found on the list.",$c);
				break;
			case "list":
				if(!empty($config['invisilogins'])){
					$say = "<sup>The invisilogins you have stored are:<br>";
					foreach($config['invisilogins']['login'] as $id => $mod){
						sort($id);
						$say .= " {$id} | ";
					}
					$dAmn->say($say, $c);
				}else
					$dAmn->say("$from: There aren't any invislogins stored.",$c);
				break; // Break $invisistore list.
		}break;		   // break $invisistore.
}// Break the switch, end of file.
?>