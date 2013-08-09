<?php
$gameroom = $config->df['werewolf']['gameroom'];
$backroom = $config->df['werewolf']['backroom'];
include_once( "./modules/werewolf/functions.php" );
switch ( $args[0] ){
	case "hunter":
		switch( $args[1] ){
			case "on":
				if( $config['werewolf']['roles'][strtolower( $from )] == "gamemaster" ){
					if( $config['werewolf']['hunter'] != TRUE ){
						$config['werewolf']['hunter'] = TRUE;
						$config->save_config( "./config/werewolf.df", $config->df['werewolf'] ); 
					}
					$dAmn->say( "$from: Hunter enabled! This role can now be assigned.", $c );
				}else $dAmn->say( "$from: Only the Game Master can turn the hunter role on or off.", $c );
			break;
			case "off":
				if( $config['werewolf']['roles'][strtolower( $from )] == "gamemaster" ){
					if( $config['werewolf']['hunter'] != FALSE ){
						$config['werewolf']['hunter'] = FALSE;
						$config->save_config( "./config/werewolf.df", $config->df['werewolf'] ); 
					}
					$dAmn->say( "$from: Hunter disabled. This role is now unavailable.", $c );
				}else $dAmn->say( "$from: Only the Game Master can turn the hunter role on or off.", $c );
			break;
			default:
				$dAmn->say( "$from: <li> <b>Hunter</b>: The Hunter role is different from the other townies in that when the hunter dies, they get to kill someone else. This is an optional role, however. This is the command the Hunter uses:</li><br>
<ul><li> <b>{$tr}hunt <i>player</i> <u>confirm</u></b> is used when the hunter is killed. It will the player they choose.</li></ul>", $c );
			break;
		}
	break;
	case "hunt":												//Enter $hunt. This is exactly the same as lynch, but no add-in feature for if you hunt the hunter. 
		$pclass = array(												// Here's our privclass array, so we can convert our shit instead of a long list of IF statements.
			'werewolf' => "Werewolves",
			'townie'   => "Townies",
			'witch'    => "Witch",
			'oracle'   => "Oracle", 
			'hunter'   => "Hunter",
			'cupid'    => "Cupid", 
			'defender' => "Defender",
			'harlot'   => "Harlot",
			'jester'   => "Jester",
			'vidiot'   => "VillageIdiot",
		);
		if( strtolower( $c ) !== strtolower( $gameroom ) ) {
			return $dAmn->say( "$from: This is a Werewolf command. This will only work in the game room. {$gameroom}", $c );
		}
		if( empty( $args[1] ) ) {
			return $dAmn->say( "$from: See <i>{$tr}hunt ?</i> for usage details.", $c );
		}
		if( empty( $config->df['werewolf']['round'] ) ) {				// We need to have a game actually going, or this command shouldn't continue.
			return $dAmn->say( "$from: There isn't a game currently active.", $c );
		}																// We cannot allow anyone other than the GameMaster to use this.
		if( $config->df['werewolf']['roles'][strtolower( $from )] !== "hunter" ) {
			return $dAmn->say( "$from: Only the hunter may use {$tr}hunt, and only after they've died.", $c );
		}
		if( !isset( $config->df['werewolf']['roles'][strtolower( $args[1] )] ) ) {
			return $dAmn->say( "$from: You can only hunt active players.", $c );
		}
		if( strtolower( $args[1] ) == $config->df['werewolf']['gamemaster'] ) {
			return $dAmn->say( "$from: You cannot kill the GameMaster", $c );
		}
		if( empty( $args[2] ) || $args[2] !== "confirm" || $args[2] !== "yes" ) {
			return $dAmn->say( "$from: Are you sure you want to hunt {$args[1]}, <i>{$tr}hunt {$args[1]} confirm/yes</i>.", $c );
		}
		$death = strtolower( $args[1] );
		$dclass = $pclass[$config->df['werewolf']['roles'][$death]];
		if( in_array( $death, $config->df['werewolf']['lovers'] ) ) {
			foreach( $config->df['werewolf']['lovers'] as $lovers ) {
				if( $lovers !== $death ) {
					$death2  = $lovers;
					$p2roll  = $config->df['werewolf']['roles'][$lovers];
					$p2class = $pclass[$p2roll];
				}
			}
			unset( $config->df['werewolf']['lovers'] );
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] ); 
		}
		if( $dclass == "Werewolves" ) {
			$config->df['werewolf']['wolves']--;
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] ); 
		} else {
			$config->df['werewolf']['tcount']--;
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		}
		unset( $config->df['werewolf']['roles'][$death] );
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->promote( $death, $dclass, $gameroom );
		$dAmn->promote( $death, "Dead" , $backroom );
		if( $dclass == "VillageIdiot" ) {
			$dAmn->say( "The hunter has killed the village idiot. As the idiot has died, that would be the end of the game.", $c );
			return end_game();
		}
		if( !empty( $p2class ) ) {
			if( $p2class == "Werewolves" ) {
				$config->df['werewolf']['wolves']--;
				unset( $config->df['werewolf']['roles'][$death2] );
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			} else {
				$config->df['werewolf']['tcount']--;
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			}
			$dAmn->promote( $death2, $p2class, $gameroom );
			$dAmn->promote( $death2, "Dead"  , $backroom );
		}
		if( $config->df['werewolf']['wolves'] === 0 && !isset( $config->df['werewolf']['lovers'] ) ) {
			$dAmn->say( "All the werewolves have been killed, and there are no lovers. With that, the game is over, and Townies have won.", $c );
			return end_game();
		}
	break;
} 
?>