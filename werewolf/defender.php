<?php
switch( $args[0] ) {
	case "defender":
		switch( $args[1] ) {
			case "on":
				if( $config->df['werewolf']['roles'][strtolower( $from )] == "gamemaster" || $user->has( $from, 99 ) ){
					if( $config->df['werewolf']['sp']['defender'] != TRUE ){
						$config->df['werewolf']['sp']['defender']  = TRUE;
						$config->df['werewolf']['sp']['harlot']    = FALSE;	// We can't have both defender and harlot in the same game. But we can have neither!
						$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
					}
					$dAmn->say( "$from: The defender role has been enabled, and Harlot disabled, as their roles are essentially the same. This role can now be assigned.", $c );
				}else $dAmn->say( "$from: Only the Game Master can turn the Defender on or off.", $c );
			break;
			case "off":
				if( $config->df['werewolf']['roles'][strtolower( $from )] == "gamemaster" || $user->has( $from, 99 ) ){
					if( $config->df['werewolf']['sp']['defender'] != FALSE ){
						$config->df['werewolf']['sp']['defender']  = FALSE;
						$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
					}
					$dAmn->say( "$from: Defender disabled. This role is now unavailable.", $c );
				}else $dAmn->say( "$from: Only the Game Master can turn the Defender on or off.", $c );
			break;
			default:
				$dAmn->say( "$from: <li> <b>Defender</b>: The Defender role is one that works rather interestingly. Unlike the witch, they can protect someone from WEREWOLF attacks every round, so long as they're alive. They aren't able to protect someone from the witch or hunter. Their protection has no effect if the person they're protecting is the lover of someone who was been killed be it by werewolf or by witch. The defender, on their turn, selects one player to protect from werewolves for that night. They may only select to protect themself once per game. This is the command the Defender uses:</li><br>
<ul><li> <b>{$tr}defend <i>player</i> <u>confirm</u></b> is used to choose a player to defend. You only need to use confirm to defend YOURSELF if you're the defender.</li></ul>", $c );
			break;
		}
	break;
	case "defend":
		if( strtolower( $c ) !== strtolower( $backroom ) ) {							// Can only use this in the backroom. Wouldn't want anyone to see. lol
			return $dAmn->say( "$from: This command can only be used in the Werewolf backroom. ( That would be {$backroom} )." , $c );
		}
		if( empty( $args[1] ) ) {														// We need someone to defend. I'm not going to repeat the usage with that being absent.
			return $dAmn->say( "$from: See <i>{$tr}defend ?</i> for correct usage.", $c );
		}
		if( $config->df['werewolf']['usedefend'] === FALSE ) {							// You cannot defend more than once per turn, this is enabled at sunset.
			return $dAmn->say( "$from: You have already selected whom you would like to defend. You may not change your mind, and you may not defend anyone else this turn.", $c );
		}
		if( strtolower( $args[1] ) == $config->df['werewolf']['lastdefend'] ) {			// You cannot defend the same person twice in a row.
			return $dAmn->say( "$from: You cannot defend the same person two nights in a row.", $c );
		}
		if( $config->df['werewolf']['roles'][strtolower( $from )] !== "defender" ) {	// We can only accept usage from the defender. 
			return $dAmn->say( "$from: Only the player assigned to the defender role may use this command.", $c );
		}
		if( !isset( $config->df['werewolf']['players'][strtolower( $args[1] )] ) ) {	// We can only defend someone who is actually actively playing.
			return $dAmn->say( "$from: You may only defend someone currently playing.", $c );
		}
		if( isset( $config->df['werewolf']['dead'][strtolower( $args[1] )] ) ) {		// I hope this filter never comes up. lol You can't defend someone who is dead.
			return $dAmn->say( "$from: You cannot defend someone who is already dead.", $c );
		}
		if( $config->df['werewolf']['roles'][strtolower( $args[1] )] == "gamemaster" ) {// You can't defend the game master, as they cannot be killed.
			return $dAmn->say( "$from: You cannot defend the Game Master.", $c );
		}
		if( strtolower( $args[1] ) == strtolower( $from ) && ( $args[2] != "yes" || $args[2] != "confirm" ) ) { // We need confirmation that you want to defend yourself.
			return $dAmn->say( "$from: Are you sure you want to defend yourself? ( Say {$tr}defend {$args[1]} yes/confirm )", $c );
		} elseif ( strtolower( $args[1] ) == strtolower( $from ) && ( $args[2] == "yes" || $args[2] == "confirm" ) ) {
			if( $config->df['werewolf']['selfdefend'] === TRUE ) {						// This is in place to allow you to defend yourself but ONCE per game.
				$config->df['werewolf']['selfdefend'] = FALSE;							// Having used that, it is now set to FALSE.
				$config->df['werewolf']['defending']   = strtolower( $args[1] );		// ['defending'] is the currently active defense. Should the werewolves select this, 
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );// their kill will have been nullified. BUT ONLY ON THE WEREWOLVES.
				$dAmn->say( "$from: Defense confirmed, you have defended yourself, and you may not do this again for the duration of this game. You may now /part.", $c );
			} else {
				return $dAmn->say( "$from: You cannot defend yourself more than once per game. Please select from another of the players, or pass.", $c );
			}
		}
		if( strtolower( $args[1] ) != strtolower( $from ) ) {							// We do not need confirmation for any other person, and to prevent multiple usage.. 
			$config->df['werewolf']['defending'] = strtolower( $args[1] );
			$config->df['werewolf']['usedefend'] = FALSE;
			$config->df['werewolf']['lastdefend'] = strtolower( $args[1]);
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			$dAmn->say( "$from: Defense confirmed. You have selected to defend {$args[1]}. You may now /part.", $c );
		}
	break;
}/*
		if(strtolower($c) == strtolower($backroom)){
			if(isset($args[1])){
				$werewolfplayer = FALSE;
				foreach($config->df['werewolf']['players'] as $lolzx => $whatzx){
					if(strtolower($whatzx) == strtolower($from)){
						$werewolfplayer = TRUE;
					}
				}
				if($werewolfplayer){
					if($config->df['werewolf']['roles'][strtolower($from)] == "defender"){
						$wolfkill = FALSE;
						foreach($config->df['werewolf']['players'] as $lolxz => $whatxz){
							if(strtolower($whatxz) == strtolower($args[1])){
								$wolfkill = TRUE;
							}
						}
						if($wolfkill){
							if($config->df['werewolf']['roles'][strtolower($args[1])] == "gamemaster"){
								$dAmn->say("$from: You can't defend the Game Master.",$c);
								return;
							}
							if($config->df['werewolf']['roles'][strtolower($args[1])] == "defender"){
								if($args[2] == "confirm"){
									if($config->df['werewolf']['defendself'] == TRUE){
										$dAmn->say("$from: Defense confirmed, you are protecting yourself and you may not protect yourself again this game.",$c);
										$config->df['werewolf']['todefend'] = $args[1];
										$config->df['werewolf']['defendself'] = FALSE;
										save_config('werewolf');
									}else
										$dAmn->say("$from: You've already defended yourself once this game. Please pick a player to defend or part.",$c);
								}else
									$dAmn->say("$from: Are you sure you want to defend yourself? If you do, cannot defend yourself again this game. Type {$tr}defend <i>player</i> (confirm) to complete the command to defend yourself.",$c);
							}
							$config->df['werewolf']['todefend'] = strtolower($args[1]);
							save_config('werewolf');
							$dAmn->say("$from: $args[1] is now defended against a werewolf attack.",$c);
						}else
							$dAmn->say("$from: You can only defend people who are playing the game.",$c);
					}else
						$dAmn->say("$from: Only the defender may use this command.",$c);
				}else
					$dAmn->say("$from: Only players may use this command.",$c);
			}else
				$dAmn->say("$from: Usage: {$tr}defend <i>player</i> (confirm). You can defend any player except the Game Master. If you defend yourself, you must include confirm. You can only defend yourself once per game.",$c);
		}else
			$dAmn->say("$from: You can only use this command in the back room. Join ".rChatName($backroom).".",$c);
		break;	*/					
?>