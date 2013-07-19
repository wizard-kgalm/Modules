<?php
include_once('modules/Magician/functions.php');
$tt=$config['bot']['trigger'];
switch($args[0]) {
	
	case "logins":														// We've finally made it to the current incarnation of the command name.
	if(!$user->has($from,99)){											// Indentation is off.. time for priv check!
		return	$dAmn->say($f. "This command is for the bot owner only.",$c);
	}																	// You don't have the privs. Do not touch.
	if(isset($config['logins']['login'][1])){							// Here's our conversion system, listed HERE as well. ( So that it's fail-safe ).
		foreach($config['logins']['login'] as $lo => $hi){
			$config['logins2']['login'][$config['logins']['login'][$lo][0]] = $config['logins']['login'][$lo][1];
			save_config('logins2');
		}
		$config['logins'] = $config['logins2'];
		save_config('logins');
		$dAmn->say("$from: Logins list updated and fixed.",$c);
	}
	
	if(empty ($config['logins'])){										// File's empty, return out-of-date instructions to start making one.
		$dAmn->say($f ."You haven't created a list of built in logins yet. Type ".$config['bot']['trigger']."store logins add 'Username' 'password' to start compiling a list.", $c);
		return null;													// For some reason, still switching back and forth on return $commands and return null.
	}
	switch($args[1]) {													// Switch for $logins's commands.
		case "add":
			if($args[2]==""){											// $logins add USERNAME PASSWORD. Return usage instructions.
				$dAmn->say($f ."Type a username and password to add to the bot's stored login file.",$c);
				return null;
			}
			if($args[3]==""){											// Empty password, ask for input.
				$dAmn->say("$from: Please put your password in the bot window.",$c);
				print "\nWhat is the password?\n";
				$args[3] = trim(fgets(STDIN));
			}
				$logins = array( 'username' => $args[2], 'password' => $args[3], ); // Apparently, still using $logins as an array.. but not calling on it.
				foreach($config['logins']['login'] as $lo => $hi){		// Still need to change to if( isset( ) ), but a little better.
					if(strtolower($lo) == strtolower($args[2])){		// This is here because some of those usernames weren't originally saved with strtolower. ;)
						return $dAmn->say("$from: $args[2] is already on the logins list.",$c);
					}
				}
				$config['logins']['login'][strtolower($args[2])] = $args[3];
				save_config('logins');
				$dAmn->say("$from: $args[2] has been successfully added to the logins!",$c);
			
			break;
		case "change":													// Now that we're using username instead of ID, that makes changing passwords easier.. 
			if(empty($args[2])){
				return $dAmn->say("$from: You must provide at least a username in order to change a stored login.",$c);
			}
			if(empty($args[3])){										// Enter password in the window, if left out of the args..
				$dAmn->say("$from: Please put your password in the bot window.",$c);
				print "\nWhat is the password?\n";
				$args[3] = trim(fgets(STDIN));
			}
			foreach($config['logins']['login'] as $id => $us){			// Searching for the username via loop.
				if(strtolower($id) === strtolower($args[2])){			// if we find $username, we'll change the password and save.
					$num = $id;
					$config['logins']['login'][$id] = $args[3];
					save_config('logins');
					$found = TRUE;										// Then mark it here so the message can be given to you.
				}
			}
			if($found){
				$dAmn->say($f ."Password successfully updated.",$c);
			}else														// Or return a failure message ( Better suited for the start, instead of at the end ).
				return $dAmn->say("$from: No such username is on the logins list.",$c);
			break;
		case "list":
			$say="";
			if(!empty($config['logins']['login'])){						// Listing the accounts. Much easier to do it like so.
				$say .="<sup>The logins you have stored are:<br/>";
				foreach($config['logins']['login'] as $id=>$us){
					sort($id);											// Still an irrelevant place to use sort or ksort.
					$say .= " {$id} | ";
				}
			}else
				$say .="$from: There aren't currently any usernames stored.";// Still not sure how this one works out, since $dAmn->say is presumably under that elseif statement.
				$dAmn->say($say,$c);
			break;
		case "all":														// All is for showing the username and password associated with it.
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
							$say .= " {$id} ==> {$us} | ";
						}						
				}else														// Didn't add confirm, return "correct" ( invalid ) usage. Store's no longer a command. Haha
					$dAmn->say($f. "This command will show the stored passwords as well as the usernames. Type ".$config['bot']['trigger']."store logins all confirm to use this command.",$c);
			}else
				$say .="$from: There aren't currently any usernames stored.";// Again with that weird application of $say with no brackets to delimit. 
				$dAmn->say($say,$c);
			break;
		case "del":
		case "remove":
		case "delete":
			if(empty($args[2])){											// Delete still oddly at the botom. Now with $delete included with $del and $remove.
				return $dAmn->say("$from: You must provide a username to delete off the logins list.",$c);
			}
			foreach($config['logins']['login'] as $id => $mod){
				if(strtolower($id) === strtolower($args[2])){				// Still searching this way.. 
					$balls = $id;											// For some reason, setting var $balls, which is used NOWHERE.
					unset($config['logins']['login'][$id]);					// Ah, we've changed to unset, instead of array_splice. 
					save_config('logins');
					$found = TRUE;
				}
			}
			if($found){
				$dAmn->say("$from: $args[2] was successfully removed from the list!",$c);
			}else
				$dAmn->say("$from: $args[2] isn't on the logins list.",$c);
			break;	
		default:															// Our default message, which is the exact same thing as the help message.
			$dAmn->say($f."Usage: {$tr}logins [add |del/remove |change |list |all]. <br><sup><b>{$tr}logins add <i>username (password)</i></b> adds a username to the stored list. Leave the password blank to input it into the bot window. <br><b>{$tr}logins del/remove <i>username</i></b> removes that user from the logins list.<br><b>{$tr}logins change <i>username (password)</i></b> allows you to change the password of the provided username. Leave the password blank to input it into the bot window.<br> <b>{$tr}logins list</b> shows the stored logins as does {$tr}show logins list.<br><b>{$tr}logins all <i>confirm</i></b> shows the logins WITH their password. Don\'t use this in a public chatroom.</sup>",$c); 
			break; // Break $logins default message
		}	// End $logins switch statement.
	break;	// Break $logins.
	case "invisistore":	//Invisistore. A direct clone of $logins, which we won't be detailing with comments, as it's the exact same thing.
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
						$dAmn->say("$from: Please put your password in the bot window.",$c);
						print "\nWhat is the password?\n";
						$args[3] = trim(fgets(STDIN));
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
					$dAmn->say("$from: Please put your password in the bot window.",$c);
					print "\nWhat is the password?\n";
					$args[3] = trim(fgets(STDIN));
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
				break; // Break $invisistore list
		}break; //Break $invisistore.
}// End switch and file. 202 lines. 
?>