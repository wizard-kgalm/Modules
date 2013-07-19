<?php
include_once('modules/Magician/functions.php');
if(file_exists('./config/logins.df')){
	$logins = include './config/logins.df';
}
switch($args[0]) {
	case "logins":																		// Welcome to the new $logins/$istore. Current version: 5.0 ( No release date ).
	case "istore":																		// The two storage areas have been combined. Like $login and $token, it's the same thing.
		( $args[0] == "logins" ) ? ( $listype = "" ) : ( $listype = "hidden" );			// Here's where we apply our $listype for the messages.
		if(!$user->has($from,99)){
			return	$dAmn->say( "$from: This command is for bot admins only.", $c);		// Our owner's only message.
		}
		switch($args[1]) {																// Enter subcommand switch.
			case "add":
				if(empty($args[2]) || empty($args[3])){									// No username or password included, return instructions.
					return $dAmn->say("$from: Username and password required. If this isn't a private room, I suggest telling the bot to {$tr}chat {$from} and joining the private chat.", $c);
				}																		// Checking both lists for the existence of the account.
				if(isset($logins['hidden'][strtolower($args[2])]) || isset($logins['login'][strtolower($args[2])])){
					return $dAmn->say( "$from: {$args[2]} is already on the list.", $c);
				}																		// Removed input, it sucks ass, and locks up ( my ) bots.
				$loginfo = testlogin($args[2], $args[3]);								// Cookie grabber. We want to verify the account info.
				if(is_array($loginfo)){													// We got an array, something went wrong.
					return $dAmn->say( "$from: Error returned. {$loginfo['error']}. Check your login info.", $c);
				}
				if(strlen($loginfo) == 32){												// This isn't necessary, but it's been included anyway.
					( $args[0] == "logins" ) ? ($logins['login'][strtolower($args[2])] = @base64_encode($args[3])) : ($logins['hidden'][strtolower($args[2])] = @base64_encode($args[3]));
					( $args[0] == "logins" ) ? ksort($logins['login']) : ksort($logins['hidden']);
					save_info('./config/logins.df', $logins);							// Our new method of saving. This is borrowed from Contra, and is far more stable.
					$dAmn->say($f. "$args[2] has been successfully added to the {$listype} list!", $c);
				}else 																	// Weird token returned somehow ( it's not possible ). 
					return $dAmn->say( "$from: No token was returned. Make sure your login info was correct.", $c);
			break;
			case "change":																// $logins change. Changes the password for the given account.
				if(empty($args[2]) || empty($args[3])){									// We need both in the message. No more input, kill the command.
					return $dAmn->say( "$from: Username and <i>[a new]</i> password required. If this isn't a private room, I suggest telling the bot to {$tr}chat {$from} and joining the private chat.", $c);
				}																		// We can only change a login that's actually stored.
				if(!isset($logins['login'][strtolower($args[2])]) || !isset($logins['hidden'][strtolower($args[2])])){
					return $dAmn->say( "$from: $args[2] is not currently on the {$listype} list. Use {$tr}{$args[0]} add $args[2] [password].", $c);
				}
				$loginfo = testlogin($args[2], $args[3]);								// Grab the cookie, verify the info. 
				if(is_array($loginfo)){													// We got an array, something went wrong.
					return $dAmn->say( "$from: Error returned. {$loginfo['error']}. Check your login info.", $c);
				}
				if(strlen($loginfo) != 32){												// Pointless length checker.
					return $dAmn->say( "$from: No token was returned. Make sure your login info was correct.", $c);
				}																		// Changing the stored password now.
				( $args[0] == "logins" ) ? ( $logins['login'][strtolower($args[2] )] = @base64_encode( $args[3] )) : ($logins['hidden'][strtolower($args[2])] = @base64_encode( $args[3] ));
				save_info('./config/logins.df', $logins);
				$dAmn->say( "$from: $args[2]'s password has been successfully changed.", $c);
				break;
			case "list":																// $logins list. It has been redone so the list displays in a nice format. 
				if($args[0] == "logins"){
					if($args[2] != "dev"){												// We've also seperated it by type of display, though I'm sure there's
						if(!empty($logins['login'])){									// a cleaner way to do it than this.
							$say = "<u>Your stored logins include:</u><br><br/><sub><code>";
							$i = 0;
							foreach( $logins['login'] as $use => $words ){
								$say .= "-- ".sprintf( "%'".chr(160)."-21s", $use );
								$i++;
								if( $i == 6 ){
									$say .= "</code><br><code>";
									$i = 0;
								}
							}
						}else{
							$say .= "$from: No usernames are currently stored.";
						}
					}elseif($args[2] == "dev"){
						if(!empty($logins['login'])){
							$say .= "<u>Your stored logins include:</u><br><br/><sub>";
							$i = 0;
							foreach( $logins['login'] as $use => $words ){
								$opening = ":dev{$use}:<code>";
								$openingLength = strlen($opening);
								$closing = "</code>";
								$closingLength = strlen($closing);
								$say .= sprintf("%'".chr(160)."-" . (31 + $closingLength + 20  ) . "s", $opening . $closing);
								$i++;
								if( $i == 6 ){
									$say .= "<br>";
									$i = 0;
								}
							}
						}else{
							$say .= $f. "No usernames are currently stored.";
						}
					}
				}elseif($args[0] == "hidden"){											// In all honesty, this doesn't even really need to exist, I'm sure.
					if($args[2] != "dev"){
						if(!empty($logins['hidden'])){
							$say .= "Your hidden logins include: <br/><sub>";
							$say .= "[ ".implode(" ] | [ ", array_keys($logins['hidden'])) . " ] ";
						}else{
							$say .= "$from: No usernames are currently stored.";
						}
					}elseif($args[2] == "dev"){
						if(!empty($logins['hidden'])){
							$say .= "Your hidden logins include: <br/><sub>";
							$say .= ":dev" . implode(":, :dev", array_keys($logins['hidden'])) . ":";
						}else{
							$say .= $f. "No usernames are currently stored.";
						}
					}
				}
				$dAmn->say($say, $c);
				break;
			case "all":																	// I'm willing to bet $logins list all yes/confirm would work fine.
				$say = "";																// This is for listing the accounts with their password.
				if(empty($args[2]) || strtolower($args[2]) !== "confirm"){
					return $dAmn->say($f. "This command will show the stored passwords as well as the usernames. Type {$tr}logins all confirm to use this command.", $c);
				}
				if($args[0] == "logins"){
					if(!empty($logins['login'])){	
						$say .= "Your stored logins include: <br/><sup>";
						foreach($logins['login'] as $name => $pass){
							if(strtolower($from) != strtolower($config['bot']['owner'])){// This is to keep anyone from finding the owner's info, if it's stored.
								if(strtolower($name) == strtolower($config['bot']['owner'])){
									$pass = base64_encode("supersecret");
								}
							}
							$say .= "{$name} => ".@base64_decode($pass)." <br>";		// Decoding the password. Half assed safety feature for those with computer snoopers.
						}
					}else{
						$say .= $f. "No usernames are currently stored.";
					}
				}elseif($args[0] == "hidden"){											// Still not really necessary. 
					if(!empty($logins['hidden'])){										// We can easily combine these. I'm not going to here, I'm just remarking on the past.
						$say .= "Your hidden logins include: <br/><sup>";
						foreach($logins['hidden'] as $name => $pass){
							if(strtolower($from) != strtolower($config['bot']['owner'])){
								if(strtolower($name) == strtolower($config['bot']['owner'])){
									$pass = base64_encode("supersecret");
								}
							}
							$say .= "{$name} => ".@base64_decode($pass)." <br>";
						}
					}else{
						$say .= $f. "No usernames are currently stored.";
					}
				}
				$dAmn->say($say, $c);
			break;
			case "del":
			case "remove":
			case "delete":																// $logins del removes the account from the list.
				if(empty($args[2])){													// It's only the account we need for this.
					return $dAmn->say($f. "You must provide a username to remove from the {$listype} list.",$c);
				}																		// Let's see if it's on the list.
				if(isset($logins['login'][strtolower($args[2])]) || isset($logins['hidden'][strtolower($args[2])])){
					$typeset = ($args[0] == "logins") ? "login" : "hidden";				// We found it, let's remove it.
					unset( $logins[$typeset][strtolower($args[2])]);
					ksort( $logins[$typeset] );											// Not really needed, but we'll resort the list.
					save_info('./config/logins.df', $logins);
					$dAmn->say($f. "$args[2] has been removed from the {$listype} list!", $c);
				}else																	// It's not there. Suggest checking the list.
					return $dAmn->say($f. "$args[2] isn't on the {$listype} list. Check {$tr}{$args[0]} list.", $c);
			break;	
			default:																	// Bonus feature, a login checker. Check the list, return help for the command.
				if(!empty($args[1])){
					if(!empty($logins['login']) || !empty($logins['hidden'])){
						if(isset($logins['login'][strtolower($args[1])]) || isset($logins['hidden'][strtolower($args[1])])){
							$dAmn->say($f. "$args[1] is on the {$listype} list.", $c);
						}else{
							$dAmn->say($f. "$args[1] is not on the {$listype} list.", $c);
						}
					}
				} 
				$dAmn->say($f. "Usage: {$tr}{$args[0]} <i>[add/del/change/list/all]  [username/confirm] [password]</i>. <br><sup>{$tr}{$args[0]} <i>add [username] [password]</i> adds a username to the stored list. [username] is the dA username you wish to add to the list, and [password] is the dA password. It will kick it out to a token grabber to verify that the password is correct before adding it.<br>{$tr}{$args[0]} <i>del [username]</i> removes [username] from the {$listype} list. [username] is the username you're deleting off that list.<br>{$tr}{$args[0]} <i>change [username] [password]</i> allows you to change [username]'s stored password with [password]. [username] is the dA username you are changing the password to, and [password] is the password you are changing it with. It will kick it out to a token grabber to verify that the password is correct before changing it.<br>{$tr}{$args[0]} <i>list [dev]</i> shows the stored logins. If you include [dev] it will give you te deviantART account (adding :dev: to the username and is optional).<br>{$tr}{$args[0]} <i>all [confirm]</i> shows the logins WITH their password. You must include confirm, or it won't work, and is not recommended for public chatrooms.<br>{$tr}{$args[0]} <i>[username]</i> checks the list for [username].</sup>", $c); 
			break; // Break $istore/$logins default.
		} // End switch.
	break; // Break istore/logins.
} // End switch, End of file. 172 lines.
?>