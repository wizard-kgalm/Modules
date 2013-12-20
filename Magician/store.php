<?php
switch($args[0]) {
	case "logins":
	case "istore":
		( $args[0] == "logins" ) ? ( $listype = "" ) : ( $listype = "hidden" );
		( $args[0] == "logins" ) ? $type = "login"   :   $type = "hidden"; 
		if(!$user->has( $from, 99 ) ) {
			return	$dAmn->say( "$from: This command is for bot admins only.", $c );
		}
		if( !empty( $config->logins ) ) {									// We're going to set up the padding for sprintf. 
			foreach( $config->logins['login'] as $UN => $PW ) {						
				( $pad < strlen ( "</code>:dev$UN:<code>" ) ) ? $pad = strlen ( "</code>:dev$UN:<code>" ) : $pad = $pad;// This one's for $logins list dev. 
				$PW = base64_decode( $PW ); 									// And this one is for $logins list all. 
				( $pad2 < strlen ( $PW ) ) ? $pad2 = strlen ( $PW ) : $pad2 = $pad2;							
			}																	// We want the list to pretty, if not obnoxiously long. :)
		}
		switch($args[1]) {
			case "add":															// I combined change and add. No need for them to be seperate.
			case "change":
				if( empty( $args[2] ) || empty( $args[3] ) ){
					return $dAmn->say( "$from: Username and password required. If this isn't a private room, I suggest telling the bot to {$tr}chat {$from} and joining the private chat.", $c );
				}																// We want to check both lists ( logins and hidden ). 
				if( ( isset( $config->logins['hidden'][strtolower( $args[2] )] ) || isset( $config->logins['login'][strtolower( $args[2] )] ) ) && $args[1] !== "change" ){
					return $dAmn->say( "$from: {$args[2]} is already on the list.", $c );
				} 																// We've removed input, because it doesn't help at least me. ( Bots hosted on a remote computer ).
				$loginfo = $dAmn->getCookie( $args[2], $args[3], TRUE );		// Token grabber in core now, let's test the given information.
				if( is_array( $loginfo ) ){										// Oops, we got an array. Return the failure.
					return $dAmn->say( "$from: Error returned. {$loginfo['error']}. Check your login info.", $c );
				}																// Removed the char length checkpoint, it's unnecessary.
				$config->logins[$type][strtolower( $args[2] )] = @base64_encode( $args[3] );
				ksort( $config->logins[$type] ); 							// Adding to the list, sorting it, saving it. All done!
				$config->save_config( './config/logins.df', $config->logins );
				$dAmn->say( "$from: $args[2] has been successfully added to the {$listype} list!", $c );
			break;
			case "list":														// Here's our list. We have three different versions of it.
				if(	empty( $config->logins[$type] ) ) {					// $logins list dev ( :devuser: ) $logins list ( normal user listing ) and 
					$say .= "$from: No usernames currently stored.";			// $logins list all (confirm or yes) lists the passwords with the accounts.
				} else {														// We're combining $logins list and $logins all because it's still a list.
					if( $args[2] == "all" && ( strtolower( $args[3] ) !== "confirm" && strtolower( $args[3] ) !== "yes" ) ) {
						return $dAmn->say( "$from: This command will show the stored passwords as well as the usernames. Type {$tr}logins all confirm to use this command.", $c );
					}
					$say = "<u>Your stored logins include:</u><br><br/><sub><code>";
					$i = 0;														// Set up our counter so we know when to cut off the line or it gets ugly.
					foreach( $config->logins[$type] as $use => $words ){	// Pull up our current list. The sorter is up top, in case
						if( $args[2] != "dev" ) {								// you're wondering what var $type refers to. 
							if( $args[2] == "all" ) {							// Our checkpoint for $logins list all is above. 
								if( strtolower( $from ) != strtolower( $config->bot['owner'] ) ) {
									if( strtolower( $use ) == strtolower( $config->bot['owner'] ) ) {
										$words = base64_encode( "supersecret" );// Don't want those.. muggles.. finding out the owner's password if it happens to be stored.
									}
								}												// Below is sprintf, our formatting friend. Courtesy of deviant-garde for showing me. 
								$say .= "-- ".sprintf( "%'".chr(160). "-" . ( 21 + $pad2 ). "s", $use. " => " .base64_decode( $words ) );
							} else {
								$say .= "-- ".sprintf( "%'".chr(160)."-". ( $pad - 16 ) . "s", $use );
							}
						} else {
							$opening = "</code>:dev{$use}:<code>";
							$say .= "-- ".sprintf( "%'".chr(160) ."-". ( $pad + 5 ) . "s", $opening );
						}
						$i++;													// Here's where we sort how many per line we can have.
						( $args[2] == "all" ) ? $num = 4 : ( ( $args[2] == "dev" ) ? $num = 5 : $num = 6 );
						if( $i == $num ){										// And where our linebreak comes in.
							$say .= "</code><br><code>";
							$i = 0;												// Reset var $i.
						}
					}
				}
				$dAmn->say( $say, $c );
			break;
			case "del":
			case "remove":
			case "delete":
			case "rem":
				if( empty( $args[2] ) ) {											// Let's make sure even is a username in the args.
					return $dAmn->say( "$from: You must provide a username to remove from the {$listype} list.", $c );
				}																	//Checking our list to make sure the provided username is there.
				if( isset( $config->logins['login'][strtolower( $args[2] )] ) || isset( $config->logins['hidden'][strtolower( $args[2] )] ) ){
					unset( $config->logins[$type][strtolower( $args[2] )] );	// It is, let's remove it.
					$config->save_config('./config/logins.df', $config->logins );
					$dAmn->say( "$from: $args[2] has been removed from the {$listype} list!", $c );
				} else																// It isn't. Tell them to check the list. 
					return $dAmn->say( "$from: $args[2] isn't on the {$listype} list. Check {$tr}{$args[0]} list.", $c );
			break;	
			default:																// Stupid bonus feature, login checker. 
				if( !empty( $args[1] ) ){
					if( !empty( $config->logins['login'] ) || !empty( $config->logins['hidden'] ) ) {
						if( isset( $config->logins['login'][strtolower( $args[1] )] ) || isset( $config->logins['hidden'][strtolower( $args[1] )] ) ) {
							$dAmn->say( "$from: $args[1] is on the {$listype} list.", $c );
						}else{
							$dAmn->say( "$from: $args[1] is not on the {$listype} list.", $c );
						}
					}
				} else { 
					$dAmn->say( "$from: Usage: {$tr}{$args[0]} <i>[add/del/change/list/all]  [username/confirm] [password]</i>. <br><sup>{$tr}{$args[0]} <i>add [username] [password]</i> adds a username to the stored list. [username] is the dA username you wish to add to the list, and [password] is the dA password. It will kick it out to a token grabber to verify that the password is correct before adding it.<br>{$tr}{$args[0]} <i>del [username]</i> removes [username] from the {$listype} list. [username] is the username you're deleting off that list.<br>{$tr}{$args[0]} <i>change [username] [password]</i> allows you to change [username]'s stored password with [password]. [username] is the dA username you are changing the password to, and [password] is the password you are changing it with. It will kick it out to a token grabber to verify that the password is correct before changing it.<br>{$tr}{$args[0]} <i>list [dev]</i> shows the stored logins. If you include [dev] it will give you te deviantART account (adding :dev: to the username and is optional).<br>{$tr}{$args[0]} <i>all [confirm]</i> shows the logins WITH their password. You must include confirm, or it won't work, and is not recommended for public chatrooms.<br>{$tr}{$args[0]} <i>[username]</i> checks the list for [username].</sup>", $c );
				}
			break;	// Break $logins default.
		}	 // End $logins switch.
	break; // Break $logins.
} // End switch, End of file. 99 lines, our smallest yet!
?>