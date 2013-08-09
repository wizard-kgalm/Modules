<?php
$gameroom = $config->df['werewolf']['gameroom'];
$backroom = $config->df['werewolf']['backroom'];
switch ( $args[0] ) {
	case "jester" :
		switch ( $args[1] ){
			case "on":
			case "off":
				( strtolower( $args[1] ) == "off" ) ? $stat = "FALSE" : $stat = "TRUE";
				( strtolower( $args[1] ) == "off" ) ? $msg = "disabled" : $msg = "enabled";
				if( strtolower( $from ) !== $config->df['werewolf']['gamemaster'] || $user->has( $from, 99 ) ) {
					return $dAmn->say( "$from: Only the GameMaster may change the status of the Jester role.", $c );
				}
				$config->df['werewolf']['sp']['jester'] = $stat;
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
				$dAmn->say( "$from: The Jester role has been {$msg}.", $c );
			break;
			default:
				$dAmn->say( "$from: <li> <b>Jester</b>: The Jester role is one newly introduced in this version, and is an optional role. They have a different power from the other roles. Like Cupid, this can only be done once, but like the witch, it may be done during any round. They are allowed to switch the roles of two players. The players who have had their role switched will have it done during the DAY TIME, and will not know who they switched roles with. They will be informed by note. This is the command the Jester uses:</li><br><ul><li> <b>{$tr}swaprole <i>[player1] [player2]</i></b>. This will change their stored role on the bot, and the bot will note the victims of this amusing change.</li></ul>", $c );
			break;
		}
	break;
	case "swaprole":
		$sprole = array(
			"witch"     => "witch"   ,
			"oracle"    => "oracle"  ,
			"werewolf"  => "werewolf",
			"hunter"    => "hunter"  ,
			"cupid"     => "cupid"   ,
			"harlot"    => "harlot"  ,
			"defender"  => "defender",
			"vidiot"    => "vidiot" 
		);
		if( strtolower( $c ) !== $backroom ) {
			return $dAmn->say( "$from: This command is part of dAmnWerewolves, and can only be used in the backroom, {$backroom}.", $c );
		}
		if( strtolower( $from ) !== $config->df['werewolf']['jester'] ) {
			return $dAmn->say( "$from: This command is for the Jester only.", $c );
		}
		if( empty( $args[1] ) || empty( $args[2] ) ) {
			return $dAmn->say( "$from: See <i>{$tr}swaprole ?</i> for correct usage.", $c );
		}
		if( !isset( $config->df['werewolf']['roles'][strtolower( $args[1] )] ) || !isset( $config->df['werewolf']['roles'][strtolower( $args[2] )] ) ) {
			return $dAmn->say( "$from: You can only change the roles of active players", $c );
		}
		if( strtolower( $args[1] ) == strtolower( $from ) || strtolower( $args[2] ) == strtolower( $from ) ) {
			return $dAmn->say( "$from: You are not allowed to swap anyone's roles with your own.", $c );
		}
		if( strtolower( $args[1] ) == $config->df['werewolf']['gamemaster'] || strtolower( $args[2] ) == $config->df['werewolf']['gamemaster'] ) {
			return $dAmn->say( "$from: You cannot change anyone's role with the GameMaster.", $c );
		}
		if( $config->df['werewolf']['swaprole'] === FALSE ) {
			return $dAmn->say( "$from: You cannot swap anyone else's roles this game.", $c );
		}
		note_players( strtolower( $args[1]), strtolower( $args[2] ), "jester" );
		$role1 = $config->df['werewolf']['roles'][strtolower( $args[1] )];
		$role2 = $config->df['werewolf']['roles'][strtolower( $args[2] )];
		if( isset( $sprole[$role1] ) ) {
			$config->df['werewolf'][$role1] = strtolower( $args[2] );
		}
		if( isset( $sprole[$role2] ) ) {
			$config->df['werewolf'][$role2] = strtolower( $args[1] );
		}
		$config->df['werewolf']['roles'][strtolower( $args[1] ) = $role2;
		$config->df['werewolf']['roles'][strtolower( $args[2] ) = $role1;
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->say( "$from: {$args[1]} and {$args[2]}'s roles have been swapped! You may now /part.", $c );
	break;
}
?>	