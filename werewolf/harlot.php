<?php
$gameroom = $config->df['werewolf']['gameroom'];
$backroom = $config->df['werewolf']['backroom'];
switch ( $args[0] ) {
	case "harlot":
		switch( $args[1] ) {
			case "on":
				if( $config->df['werewolf']['roles'][strtolower( $from )] == "gamemaster" || $user->has( $from, 99 ) ){
					if( $config->df['werewolf']['sp']['harlot'] != TRUE ){
						$config->df['werewolf']['sp']['harlot']  = TRUE;
						$config->df['werewolf']['sp']['defender']    = FALSE;	// We can't have both defender and harlot in the same game. But we can have neither!
						$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
					}
					$dAmn->say( "$from: The Harlot role has been enabled, and Defender disabled, as their roles are essentially the same. This role can now be assigned.", $c );
				}else $dAmn->say( "$from: Only the Game Master can turn the Harlot on or off.", $c );
			break;
			case "off":
				if( $config->df['werewolf']['roles'][strtolower( $from )] == "gamemaster" || $user->has( $from, 99 ) ){
					if( $config->df['werewolf']['sp']['harlot'] != FALSE ){
						$config->df['werewolf']['sp']['harlot']  = FALSE;
						$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
					}
					$dAmn->say( "$from: Harlot disabled. This role is now unavailable.", $c );
				}else $dAmn->say( "$from: Only the Game Master can turn the Harlot on or off.", $c );
			break;
			default:
				$dAmn->say( "$from: <li> <b>Harlot</b>: The Harlot role is very similar to the Defender. They \"sleep\" with one person each night. (Maybe they're homeless or something...), if that person is targeted by wolves/witch then they evade death. If the Harlot sleeps with a wolf the wolves don't kill anyone that night. When/If the Harlot dies, so does the person they were sleeping with. If the Harlot is sleeping with a wolf and is picked by the wolves to kill, only the Harlot dies. If the Harlot is sleeping with the witch and the witch uses their kill potion on the Harlot, both of them die. <br>{$tr}sleep [player]. This will protect whomever they sleep with from attacks from both the witch and the wolves. If the harlot sleeps with the wolves, no wolf attack that night. If the harlot is attacked by the witch after sleeping with the witch, they both die.", $c );
			break;
		}
	break;
	case "sleep":
		if( strtolower( $c ) !== $backroom ) {											// Gotta be in the back room.
			return $dAmn->say( "$from: This command is for the dAmnWerewolves backroom, and is part of the game. It cannot be used outside of the game.", $c );
		}
		if( !isset( $config->df['werewolf']['harlot'][strtolower( $from )] ) ) {		// We can't allow anyone other than the harlot to use this..
			return $dAmn->say( "$from: Only the harlot may use this command.", $c );
		}
		if( empty( $args[1] ) ) {														// We need someone to sleep with/defend..
			return $dAmn->say( "$from: See <i>{$tr}sleep ? </i> for correct usage.", $c );
		}
		if( $config->df['werewolf']['usedefend'] === FALSE ) {							// You must have a defend available this turn..
			return $dAmn->say( "$from: You cannot sleep with another person tonight. If you've made a mistake, please ask the GameMaster to reset your command.", $c );
		}
		if( strtolower( $args[1] ) === $config->df['werewolf']['harlot'] ) {			// The harlot, unlike the defender, cannot use one on themselves.
			return $dAmn->say( "$from: You cannot sleep with yourself!", $c );
		}
		if( isset( $config->df['werewolf']['wolf'][strtolower( $args[1] )] ) ) {		// If it's a werewolf, they cannot attack this turn.
			$config->df['werewolf']['antiattack'] = TRUE;								// Holding up to the role, if they manage to sleep with a wolf,
		}																				// There won't be a wolf attack that night.
		$config->df['werewolf']['defending']  = strtolower( $args[1] );
		$config->df['werewolf']['usedefend'] = FALSE;
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->say( "$from: $args[1] has been slept with. You may /part now.", $c );
	break;
}
?>
			