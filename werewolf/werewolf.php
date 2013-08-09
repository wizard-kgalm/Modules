<?php
$gameroom = $config->df['werewolf']['gameroom'];
$backroom = $config->df['werewolf']['backroom'];
switch ( $args[0] ) {
	case "play":
		if( strtolower( rChatName( $c ) ) !==  $gameroom && strtolower( rChatName( $c ) ) !== $backroom ) {
			return $dAmn->say( "$from: This command is part of Werewolf and can only be used in the game room, or back room for the game. Gameroom: {$gameroom}. Backroom: {$backroom}", $c );
		}
		if( isset( $config->df['werewolf']['players'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: You're already playing.", $c );
		}
		$config->df['werewolf']['players'][strtolower( $from )] = strtolower( $from );
		$config->df['werewolf']['notassigned'][strtolower( $from )] = strtolower( $from );
		if( isset( $config->df['werewolf']['playerclass'] ) ) {
			$werewolfclass = $config->df['werewolf']['playerclass'];
		} else {
			$werewolfclass = "Players";
		}
		$dAmn->promote( $from, $werewolfclass, $gameroom );
		$dAmn->promote( $from, $werewolfclass, $backroom );
		$dAmn->say( "$from has joined the game.", $c );
		$config->df['werewolf']['count']++;
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
	break;
	case "rconfirm":
	case "confirmrole":
		if( strtolower( $c ) !== $gameroom && strtolower( $c ) !== $backroom ) {
			return $dAmn->say( "$from: This command is part of Werewolf and can only be used in the game room, or back room for the game. Gameroom: {$gameroom}. Backroom: {$backroom}", $c );
		}
		if( !isset( $config->df['werewolf']['players'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: This is so active players may confirm that they have received their roles.", $c );
		}
		if( !isset( $config->df['werewolf']['confirm'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: Your role has already been confirmed.", $c );
		}
		unset( $config->df['werewolf']['confirm'][strtolower( $from )] );
		$dAmn->say( "$from: You have confirmed your role.", $c );
		if( empty( $config->df['werewolf']['confirm'] ) ) {
			unset( $config->df['werewolf']['confirm'] );
		}
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
	break;
	case "unplay":
		$sprole = array(
			"witch"     => "witch"   ,
			"oracle"    => "oracle"  ,
			"werewolf"  => "werewolf",
			"hunter"    => "hunter"  ,
			"cupid"     => "cupid"   ,
			"harlot"    => "harlot"  ,
			"defender"  => "defender",
			"vidiot"    => "vidiot"  ,
			"gamemaster"=> "gamemaster"
		);
		if( strtolower( $c ) !== $gameroom && strtolower( $c ) !== $backroom ) {
			return $dAmn->say( "$from: This command is part of Werewolf and can only be used in the game room, or back room for the game. Gameroom: {$gameroom}. Backroom: {$backroom}", $c );
		}
		if( !isset( $config->df['werewolf']['players'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: You are not currently playing.", $c );
		}
		if( isset( $config->df['werewolf']['roles'][strtolower( $from )] ) ) {
			$dAmn->say( "$from is leaving the game, creating a role vacancy. WARNING." , $gameroom );
		}
		unset( $config->df['werewolf']['players'][strtolower( $from )] );
		$role = $config->df['werewolf']['roles'][strtolower( $from )];
		if( isset( $sprole[$role] ) ) {
			if( $sprole[$role] == "werewolf" ) {
				$config->df['werewolf']['wolves']--;
				unset( $config->df['werewolf']['wolf'][strtolower( $from )] );
			} else {
				$config->df['werewolf']['tcount']--;
				unset( $config->df['werewolf'][$role] );
			}
			$dAmn->say( "$gm: You need someone to fill {$role}.", $backroom );
		} else {
			unset( $config->df['werewolf']['townies'][strtolower( $from )] );
			if( $sprole[$role] !== "gamemaster" ) {
				$config->df['werewolf']['tcount']--;
			}
		}
		unset( $config->df['werewolf']['roles'][strtolower( $from )] );
		unset( $config->df['werewolf']['notassigned'][strtolower( $from )] );
		$config->df['werewolf']['count']--;
		$dAmn->promote( $from, "Audience", $gameroom );
		$dAmn->promote( $from, "Audience", $backroom );
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->say( "$from has left the game.", $c );
	break;
	case "gm":
		if( strtolower( $c ) !== $gameroom && strtolower( $c ) !== $backroom ) {
			return $dAmn->say( "$from: This command is part of Werewolf and can only be used in the game room, or back room for the game. Gameroom: {$gameroom}. Backroom: {$backroom}", $c );
		}
		if( !isset( $config->df['werewolf']['players'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: You must be playing the game to elect yourself the GameMaster.", $c );
		}
		if( isset( $config->df['werewolf']['gamemaster'] ) ) {
			return $dAmn->say( "$from: There already is a GameMaster. If they're not present, you may have to restart the game manually.", $c );
		}
		if( isset( $config->df['werewolf']['roles'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: You already have a role, and it appears a game is in progress.", $c );
		}
		$config->df['werewolf']['roles'][strtolower( $from )] = "gamemaster";
		$config->df['werewolf']['gamemaster'] = strtolower( $from );
		unset( $config->df['werewolf']['notassigned'][strtolower( $from )] );
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->promote( $from, "GameMaster", $gameroom );
		$dAmn->promote( $from, "GameMaster", $backroom );
		$dAmn->say( "$from is now the GameMaster", $gameroom );
		$dAmn->say( "$from is now the GameMaster", $backroom );
	break;
	case "mute":
		$dAmn->admin( "update privclass $args[1] -msg", $c );
	break;
	case "unmute":
		$dAmn->admin( "update privclass $args[1] +msg", $c );
	break;
	case "townie":
		$dAmn->say( "$from: The townie is the most basic role in the game. Their goal is merely to survive to the end and get rid of all the werewolves. They have 2 default key characters, the Witch, who has 2 potions, a save, and a kill. The save can save a person chosen victim by the wolves, and the kill, which can kill a person fo their choice. They also have the Oracle, who may peer into the role of one player a turn, and can use this info later in the game. The other townie roles are Hunter, Defender, and Cupid. The hunter, when killed, is allowed to take someone down with them. The defender is allowed to protect one player a turn from WEREWOLF only attacks. They have no effect on witch or hunter killing. They are also ineffective in stopping the death if the wolves attack the player protected's lover. Cupid's role is handled at the beginning and they choose the lovers. The lovers may be a deciding factor in the game. If there are lovers and they remain the sole survivers, they win. If one of the lovers is killed, the other dies with them.", $c );
	break;
	case "villageidiot":
		$dAmn->say( "$from: The Village Idiot is essentially the same as a townie, but their goal is to trick everyone into killing them. If the village idiot dies, that's an automatic game over. Alas, if they're the lover another player, killing them also will end the game, as it takes out the village idiot. The village idiot becomes the winner in death, unlike the other roles. They have no commands, and is an entirely optional role.", $c );
	break;
	case "vidiot":
		switch ( $args[1] ){
			case "on":
			case "off":
				( strtolower( $args[1] ) == "off" ) ? $stat = "FALSE" : $stat = "TRUE";
				( strtolower( $args[1] ) == "off" ) ? $msg = "disabled" : $msg = "enabled";
				if( strtolower( $from ) !== $config->df['werewolf']['gamemaster'] || $user->has( $from, 99 ) ) {
					return $dAmn->say( "$from: Only the GameMaster may change the status of the Village Idiot role.", $c );
				}
				$config->df['werewolf']['sp']['vidiot'] = $stat;
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
				$dAmn->say( "$from: The Village Idiot role has been {$msg}.", $c );
			break;
			default:
				$dAmn->say( "$from: The Village Idiot is essentially the same as a townie, but their goal is to trick everyone into killing them. If the village idiot dies, that's an automatic game over. Alas, if they're the lover another player, killing them also will end the game, as it takes out the village idiot. The village idiot becomes the winner in death, unlike the other roles. They have no commands, and is an entirely optional role.", $c );
			break;
		}
	break;
} 
?>