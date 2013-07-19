<?php
include_once('modules/Magician/functions.php');
switch($args[0]) {
	case "logins":
		if(!$user->has($from,99)){														// Now with added commentary! I don't think I need to mock myself on this one.
			return	$dAmn->say($f. "This command is for bot admins only.",$c);			// We're going to move the commentary to the appropriate lines.
		}																				// And make necessary adjustments to it. Even though this version is obsolete.
		switch($args[1]) {
			case "add":
				if(empty($args[2])){
					return $dAmn->say($f ."Type a username and password to add to the bot's stored login file.",$c);
				}																		// ['hidden'] is off the main logins list. Let's check both for the new account.
				if(isset($config['logins']['hidden'][strtolower($args[2])]) || isset($config['logins']['login'][strtolower($args[2])])){
					return $dAmn->say("$from: $args[2] is already on the list.",$c);
				}
				if(empty($args[3])){ 													// No password? You're the owner? Let's kick it to the input window.
					if(strtolower($from) != strtolower($config['bot']['owner'])){
						return $dAmn->say("$from: Username and password required.",$c);
					}else{
						$dAmn->say("$from: Please put your password in the bot window.",$c);
						print "\nWhat is the password?\n";
						$args[3] = trim(fgets(STDIN));
					}
				}
				$loginfo = testlogin($args[2], $args[3]); 								// Now this part is purely to keep it error free. We're gonna kick it out to the token grabber.
				if(is_array($loginfo)){					 								// No cookie? Let's return the error you've encountered.
					return $dAmn->say("$from: Error returned. {$loginfo['error']}. Check your login info.",$c);
				}
				if(strlen($loginfo) == 32){												// Let's make sure it's still 32 characters long. 
					$config['logins']['login'][strtolower($args[2])] = @base64_encode($args[3]);
					ksort($config['logins']['login']);									// If our info is correct, we'll add it to the file now. 
					save_config('logins');
					$dAmn->say("$from: $args[2] has been successfully added to the logins!",$c);
				}else 
					return $dAmn->say("$from: No token was returned. Make sure your login info was correct.", $c);
			break;
			case "change":																// This feature is for changing a stored password. Just for ease of use. 
				if(empty($args[2])){
					return $dAmn->say("$from: You must provide at least a username in order to change a stored login.",$c);
				}
				if(!isset($config['logins']['login'][strtolower($args[2])])){			// Checking for that login on the list.. If not, suggest adding it.
					return $dAmn->say("$from: $args[2] is not currently on the logins list. Use {$tr}logins add $args[2] [password].",$c);
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
				$loginfo = testlogin($args[2], $args[3]);								// Now to test the given info.. don't want any mistakes here.
				if(is_array($loginfo)){													// If we've been given an array, there's no cookie. Let's return the error.
					return $dAmn->say("$from: Error returned. {$loginfo['error']}. Check your login info.",$c);
				}
				if(strlen($loginfo) != 32){												// Making sure our login info is the correct length.. Not sure why. ( I admitted it ). 
					return $dAmn->say("$from: No token was returned. Make sure your login info was correct.", $c);
				}
				$config['logins']['login'][strtolower($args[2])] = @base64_encode($args[3]); // Now to change the password to the new one. :D
				save_config('logins');
				$dAmn->say("$from: $args[2]'s password has been successfully changed.",$c);
			break;
			case "list":																// Your average list command.. 
				$say = "";
				if(!empty($config['logins']['login'])){
					$say .="The logins you have stored are:<br/><sub>";
					foreach($config['logins']['login'] as $name => $pass){				// At some point, this was changed to simply "implode". Same thing, equally ugly output.
						$say .= "[:dev{$name}:] ";
					}
				}else{
					$say .="$from: There aren't currently any usernames stored.";		// Finally, fixed the whole else statement. <3
				}
				$dAmn->say($say,$c);
			break;
			case "all":
				$say = "";																// This one is like list only it includes the passwords too.
				if(!empty($config['logins']['login'])){
					if(!empty($args[2])){
						if($args[2] !="confirm"){
							return $dAmn->say($f. "This command will show the stored passwords as well as the usernames. Type {$tr}logins all confirm to use this command.",$c);
						}else
							$say .="The logins you have stored are:<br/><sup>";
							foreach($config['logins']['login'] as $name => $pass){
								if($from != $config['bot']['owner']){					// Let's keep the.. muggles.. from finding out the owner's password. 
									if(strtolower($name) == strtolower($config['bot']['owner'])){
										$pass = base64_encode("supersecret");			// Few too many indentations. 
									}
								}
								$say .= "{$name} => ".@base64_decode($pass)." <br> ";	// Decoding the password. Half assed safety feature for those with computer snoopers.
							}						
					}else
						return $dAmn->say($f. "This command will show the stored passwords as well as the usernames. Type {$tr}logins all confirm to use this command.",$c);
				}else{
					$say .="$from: There aren't currently any usernames stored.";
				}
					$dAmn->say($say,$c);
			break;
			case "del":
			case "remove":
			case "delete":
				if(empty($args[2])){
					return $dAmn->say("$from: You must provide a username to remove from the logins list.",$c);
				}
				if(isset($config['logins']['login'][strtolower($args[2])])){			// Checking our list to make sure the provided username is there.							
					unset($config['logins']['login'][strtolower($args[2])]);			// Found it, removing from the list. 
					ksort($config['logins']['login']);
					save_config('logins');
					$dAmn->say("$from: $args[2] has been removed from the list!",$c);
				}else
					$dAmn->say("$from: $args[2] isn't on the logins list. {$tr}logins list to see the list.",$c);
			break;	
			default:																	// Bonus feature, a login checker. Check the list, return help for the command. 
				if(isset($args[1])){
					if(!empty($config['logins']['login'])){
						if(isset($config['logins']['login'][strtolower($args[1])])){
							$dAmn->say("$from: $args[1] is on the logins list.",$c);
						}else{
							$dAmn->say("$from: $args[1] is not on the logins list.",$c);
						}
					}
				}
				$dAmn->say($f."Usage: {$tr}logins [add, del/delete/remove, change, list, all, (username)]. <br><sup><b>{$tr}logins add [username] (password)</b> adds a username to the stored list. Leave the password blank to input it into the bot window. <br><b>{$tr}logins del/remove [username]</b> removes that user from the logins list.<br><b>{$tr}logins change [username] (password)</b> allows you to change the password of the provided username. Leave the password blank to input it into the bot window.<br> <b>{$tr}logins list</b> shows the stored logins.<br><b>{$tr}logins all <i>confirm</i></b> shows the logins WITH their password. Don't use this in a public chatroom.<br><b>{$tr}logins [username]</b> checks the list for that login.</sup>",$c); 
			break;
		}	
	break;	
	case "istore":																			// We've already established this is a direct clone of store, no further commentary edits.
		switch($args[1]){
			case "add":
				if(!empty($args[2])){
					//The entire basis of this command is that it's off the main logins list. It was on invisilogins but I've since moved it to the array ['hidden'] on the logins list. No one even uses this anyway. This part here just checks if the account is on the list.
					if(isset($config['logins']['hidden'][strtolower($args[2])]) || isset($config['logins']['login'][strtolower($args[2])])){
						return $dAmn->say("$from: $args[2] is already on the list.",$c);
					}
					if(empty($args[3])){
						//More of that entering the password in the window stuff. I got the idea from zombiewhale.
						if(strtolower($from) !== strtolower($config['bot']['owner'])){
							return $dAmn->say("$from: Username and password required.",$c);
						}else{
							$dAmn->say("$from: Please put your password in the bot window.",$c);
							print "\nWhat is the password?\n";
							$args[3] = trim(fgets(STDIN));
						}
					}
					//It's not? Let's see if we get a token/cookie. 
					$token = testlogin($args[2], $args[3]);
					//If we get an array, there's no authtoken in there.. Check your login info, make sure your password is correct. Also, make sure your account is activated.
					if(is_array($token)){	
						return $dAmn->say("$from: Error returned. {$token['error']}. Check your login info.",$c);
					}
					//Alright, we got a regular token.. let's store the login. You probably noticed these ones aren't encoded.
					$config['logins']['hidden'][strtolower($args[2])] = $args[3];
					save_config('logins'); 
					$dAmn->say("$from: $args[2] has been successfully added to the hidden logins!",$c);
				}else
					$dAmn->say("$from: Usage: {$tr}istore add <i>username password*</i>. If you leave password blank, and you're running the bot, you can put the password into the console window.",$c);
				break;
			case "change":
				if(empty($args[2])){
					return $dAmn->say("$from: You must provide at least a username in order to change a stored login.",$c);
				}//Password in window stuff.
				if(empty($args[3])){
					if(strtolower($from) !== strtolower($config['bot']['owner'])){
						return $dAmn->say("$from: Username and password required.",$c);
					}else{
						$dAmn->say("$from: Please put your password in the bot window.",$c);
						print "\nWhat is the password?\n";
						$args[3] = trim(fgets(STDIN));
					}
				}//Checking to see if we were given a login on the list. 
				if(isset($config['logins']['hidden'][strtolower($args[2])])){
					//If we found it, we'll be seeing if our new password works. Attempting to grab token..
					$token = testlogin($args[2], $args[3]);
					//Bad info? Account not activated? Internet/dA died on you? Error prints out below.
					if(is_array($token)){
						return $dAmn->say("$from: Error returned. {$token['error']}. Check your login info.",$c);
					}
					//If it worked, we'll be updating that person's stuff.
					$config['logins']['hidden'][strtolower($args[2])] = $args[3];
					save_config('logins');
					$dAmn->say("$from: $args[2]'s password has been successfully changed.",$c);
				}else
					//The username given isn't on the list. Let's suggest adding it!
					return $dAmn->say("$from: $args[2] is not currently on the hidden list. Use {$tr}istore add $args[2] [password].",$c);
					break;
			case "delete":
			case "del":
				if(empty($args[2])){
					return $dAmn->say("$from: You must provide a username to remove from the logins list.",$c);
				}
				//Checking our list to make sure the provided username is there.
				if(isset($config['logins']['hidden'][strtolower($args[2])])){
					//Found it, removing from the list. 
					unset($config['logins']['hidden'][strtolower($args[2])]);
					ksort($config['logins']['hidden']);
					save_config('logins');
					$dAmn->say("$from: $args[2] has been removed from the hidden list!",$c);
				}else
					$dAmn->say("$from: $args[2] isn't on the hidden list. {$tr}istore list to see the list.",$c);
				break;	
			case "list":
				if(!empty($config['logins']['hidden'])){
					//Nothing here but the basic list set up. 
					$say = "The hidden logins you have stored are:<br><sup>";
					foreach($config['logins']['hidden'] as $name => $pass){
						sort($id);
						$say .= "[:dev{$name}] ";
					}
					$dAmn->say($say, $c);
				}else
					$dAmn->say("$from: There aren't any hidden logins stored.",$c);
				break;
		}
		break;
}