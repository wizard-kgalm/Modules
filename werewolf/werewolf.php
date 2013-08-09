<?php
include_once(f('modules/werewolf/assign2.php'));
$gameroom = $config->df['werewolf']['gameroom'];
$backroom = $config->df['werewolf']['backroom'];
$round = $config->df['werewolf']['round'];
$status = $config->df['werewolf']['status'];
$turn = $config->df['werewolf']['turn'];
$talk = $config->df['werewolf']['muted'];
$day = $config->df['werewolf']['day'];
$changed = $config->df['werewolf']['changed'];
if(!isset($gameroom)){
	$gameroom = $c;
}
switch ( $args[0] ) {
	case "play":
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
	case "unplay":
		$werewolfplayer = FALSE;
		if(isset($config->df['werewolf'])){
			if(isset($args[1])){
				if($config->df['werewolf']['roles'][strtolower($from)] == "gamemaster"){
					foreach($config->df['werewolf']['players'] as $someonew =>$playerw){
						if(strtolower($playerw) == strtolower($args[1])){
							$werewolfplayer = TRUE;
							$config->df['werewolf']['players'][$someonew] = NULL;
							unset($config->df['werewolf']['players'][$someonew]);
							unset($config->df['werewolf']['roles'][$playerw]);
							unset($config->df['werewolf']['notassigned'][$playerw]);
							sort($config->df['werewolf']['players']);
							$config->df['werewolf']['count']--;
							save_config('werewolf');
						}
					}
					if($werewolfplayer){
						if(isset($config->df['werewolf']['audclass'])){
							$audclass = $config('audclass');
						}else
							$audclass = "Audience";
							$dAmn->demote($playerw, $audclass, $gameroom);
							$dAmn->demote($playerw, $audclass, $backroom);
							$dAmn->say("$from has left the game. You may want to replace them if they weren't dead.",$gameroom);
					}else
						return;
				}
			}else
			if(!isset($args[1])){
				foreach($config->df['werewolf']['players'] as $harpoon =>$slayer){
					if(strtolower($slayer) == strtolower($from)){
						$werewolfplayer = TRUE;
						$config->df['werewolf']['players'][$harpoon] = NULL;
						unset($config->df['werewolf']['players'][$harpoon]);
						unset($config->df['werewolf']['roles'][$slayer]);
						unset($config->df['werewolf']['notassigned'][$slayer]);
						sort($config->df['werewolf']['players']);
						save_config('werewolf');
					}
				}
			
		
				if($werewolfplayer){
					if(isset($config->df['werewolf']['audclass'])){
						$audclass = $config('audclass');
					}else
						$audclass = "Audience";
						$dAmn->demote($from, $audclass, $gameroom);
						$dAmn->demote($from, $audclass, $backroom);
						$dAmn->say("$from has left the game. You may want to replace them if they weren't dead.",$gameroom);
				}else
					return;
			}
		}else return;
	break;
	case "gm":
		if( strtolower( $c ) !== $gameroom || strtolower( $c ) !== $backroom ) {
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
		$config->df['werewolf']['gamemaser'] = strtolower( $from );
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->promote( $from, "GameMaster", $gameroom );
		$dAmn->promote( $from, "GameMaster", $backroom );
		$dAmn->say( "$from is now the GameMaster", $gameroom );
		$dAmn->say( "$from is now the GameMaster", $backroom );
	break;
	case "mute":
		$dAmn->admin("update privclass $args[1] -msg",$c);
	break;
	case "unmute":
		$dAmn->admin("update privclass $args[1] +msg",$c);
	break;
} 
?>