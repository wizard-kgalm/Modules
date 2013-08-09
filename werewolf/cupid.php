<?php
include_once( "./modules/werewolf/functions.php" );
switch( $args[0] ) {
	case "cupid":
		switch($args[1]){
			case "on":
				if( ( $config->df['werewolf']['roles'][strtolower( $from )] == "gamemaster" ) || $user->has( $from, 99 ) ) {	// Overrides for owners. hue hue.
					if( $config->df['werewolf']['sp']['cupid'] != TRUE ){
						$config->df['werewolf']['sp']['cupid']  = TRUE;
						$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
					}
					$dAmn->say( "$from: Cupid enabled! This role can now be assigned.", $c );
				} else $dAmn->say( "$from: Only the GameMaster can turn Cupid on or off.", $c );
			break;
			case "off":
				if( $config->df['werewolf']['roles'][strtolower( $from )] == "gamemaster" ){
					if( $config->df['werewolf']['sp']['cupid'] != FALSE ){
						$config->df['werewolf']['sp']['cupid']  = FALSE;
						$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
					}
					$dAmn->say( "$from: Cupid disabled. This role is now unavailable.", $c );
				}else $dAmn->say( "$from: Only the GameMaster can turn Cupid on or off.", $c );
			break;
			default:
				$dAmn->say( "$from: <li> <b>Cupid</b>: Cupid is a one action role, where they are responsible for selecting two lovers at the start of the game. Those lovers are bound tightly in that if one dies, the idea is that the other one can't bear to go on living without them and commit suicide, so if one dies, they both die. This role is optional. This is the command that Cupid uses:</li><br>
<ul><li> <b>{$tr}lovers <i>player1 player2</i></b> is used to select the lovers. After they are set, the Game Master will note the two lovebirds.</li></ul>", $c );
			break;
		}
	break;
	case "lovers":
		if( strtolower( $c ) !== strtolower( $backroom ) ) {
			return $dAmn->say( "$from: This command can only be used in the Werewolf backroom. ( That would be {$backroom} )." , $c );
		}
		if( $config->df['werewolf']['roles'][strtolower( $from )] !== "cupid" ) {
			return $dAmn->say( "$from: Only the player assigned to the cupid role may use this command.", $c );
		}
		if( !isset( $config->df['werewolf']['players'][strtolower( $args[1] )] ) || !isset( $config->df['werewolf']['players'][strtolower( $args[2] )] ) ) {
			return $dAmn->say( "$from: Both lovers <u>must</u> be current players.", $c );
		}
		if( $config->df['werewolf']['roles'][strtolower( $args[1] )] == "gamemaster" || $config->df['werewolf']['roles'][strtolower( $args[2] )] == "gamemaster" ) {
			return $dAmn->say( "$from: You cannot make the gamemaster a lover.", $c );
		}
		$config->df['werewolf']['lovers'] = array(						// We're setting our lovers up.. We'll using this info as well for sending the note.
			strtolower( $args[1] ) => strtolower( $args[1] ) ,
			strtolower( $args[2] ) => strtolower( $args[2] ) ,
		);
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );		
		note_players( strtolower( $args[1] ), strtolower( $args[2] ), "lovers" );								// We'll be using the bot's account for the note. 
		$dAmn->say( "$from: You have selected the lovers, and the notes have been sent.", $c );
	break;
}
	/*	if(strtolower($c) == strtolower($backroom)){
			if(isset($args[1])){
				if(isset($args[2])){
					$werewolfplayer = FALSE;
					foreach($config['werewolf']['players'] as $lolzx => $whatzx){
						if(strtolower($whatzx) == strtolower($from)){
							$werewolfplayer = TRUE;
						}
					}
					if($werewolfplayer){
						if($config['werewolf']['roles'][strtolower($from)] == "cupid"){
							$wolfkill = FALSE;
							$half1 = FALSE;
							$half2 = FALSE;
							foreach($config['werewolf']['players'] as $lolxz => $whatxz){
								if(strtolower($whatxz) == strtolower($args[1])){
									$half1 = TRUE;
								}
								if(strtolower($whatxz) == strtolower($args[2])){
									$half2 = TRUE;
								}
								if($half1 && $half2){
									$wolfkill = TRUE;
								}
							}
							if($wolfkill){
								if($config['werewolf']['roles'][strtolower($args[1])] == "gamemaster" || $config['werewolf']['roles'][strtolower($args[2])] == "gamemaster"){
									$dAmn->say("$from: You can't select the Game Master as a lover.",$c);
									return;
								}
								$config['werewolf']['lovers'][0] = $args[1];
								$config['werewolf']['lovers'][1] = $args[2];
								save_config('werewolf');
								$dAmn->say("$from: You have selected $args[1] and $args[2] as the lovers. The Game Master will note them.",$c);
							}
						}else
							$dAmn->say("$from: Only Cupid may select the lovers.",$c);
					}else
						$dAmn->Say("$from: Only players may use this command.",$c);
				}else
					$dAmn->say("$from: You need to include the second person.",$c);
			}else
				$dAmn->say("$from: Usage: {$tr}lovers <i>player1 player2</i>. They must be players, you may select yourself, and you cannot select the Game Master.",$c);
		}else 
			$dAmn->say("$from: You can only use this command in the back room. Join ".rChatName($backroom).".",$c);
		break;*/
?>