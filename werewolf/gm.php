<?php

switch($args[0]){
	case "sunset":
		if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
			$dAmn->say("The sun sets in the world of Werewolf and the townies go to their nightly slumber.", $gameroom);
			$config['werewolf']['muted'] = true;
			$dAmn->admin("update privclass Players -msg",$gameroom);
			$config['werewolf']['oracleview'] = TRUE;
			$config['werewolf']['round']++;
			$config['werewolf']['day'] = "Night";
			$config['werewolf']['changed'] = FALSE;
			save_config('werewolf');
			$dAmn->set("title","Game status: :bulletred: <b>{$status}</b> | Round: <b>{$round}</b> | Current turn: <b>{$turn}</b> | Player status: :bulletred: <b>Muted</b>",$gameroom);
			//$dAmn->say("$from: Oracle set.",$backroom);
		}
		break;
	case "setoracle":
		if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
			$config['werewolf']['oracleview'] = TRUE;
			save_config('werewolf');
			$dAmn->say("$from: Oracle set.",$backroom);
		}else
			$dAmn->say("$from: Only the Game Master may set the Oracle.",$c);
		break;
	case "backroom":
			switch($args[1]){
				case "set":
					if(isset($args[2])){
						if(!isset($config['werewolf']['backroom'])){
							$config['werewolf']['backroom'] = strtolower(rChatName($args[2]));
							save_config('werewolf');
							$dAmn->say("$from: The backroom for Werewolf is now ".rChatName($args[2]).".",$c);
						}else
							$dAmn->say("$from: You already have a backroom set. To change it, simply type {$tr}backroom clear and it'll reset.",$c);
					}else
						$dAmn->say("$from: Usage: ".$tr."backroom set <i>#room</i>. The room is any dAmn chatroom.",$c);
					break;
				case "clear":
					if(isset($config['werewolf']['backroom'])){
						$config['werewolf']['backroom'] = NULL;
						unset($config['werewolf']['backroom']);
						save_config('werewolf');
						$dAmn->say("$from: Backroom successfully cleared!",$c);
					}else
						$dAmn->say("$from: You don't currently have a backroom set.",$c);
					break;
				default:
					if(isset($config['werewolf']['backroom'])){
						$dAmn->say("$from: The current backroom is ".$config['werewolf']['backroom'].". To change it, simply type {$tr}backroom clear.",$c);
					}else
						$dAmn->say("$from: There isn't a backroom set. To set one, type {$tr}backroom set <i>#room</i>",$c);
					break;
			}break;
	case "gameroom":
		switch($args[1]){
			case "set":
				if(empty($args[2])){
					return $dAmn->say("$from: Usage: {$tr}gameroom set [#room]. This sets the room that will be used for hosting the game.",$c);
				}
				$config['werewolf']['gameroom'] = strtolower(rChatName($args[2]));
				save_config('werewolf');
				break;
			case "clear":
				if(isset($config['werewolf']['gameroom'])){
					$config['werewolf']['gameroom'] = NULL;
					unset($config['werewolf']['gameroom']);
					save_config('werewolf');
					$dAmn->say("$from: Gameroom successfully cleared!",$c);
				}else
					$dAmn->say("$from: You don't currently have a gameroom set.",$c);
				break;
			default:
				if(isset($config['werewolf']['gameroom'])){
					$dAmn->say("$from: The current gameroom is ".$config['werewolf']['gameroom'].". To change it, simply type {$tr}gameroom clear.",$c);
				}else
					$dAmn->say("$from: There isn't a gameroom set. To set one, type {$tr}gameroom set <i>#room</i>",$c);
				break;
		}break;
	case "role":
		if($config['werewolf']['gamemaster'] !== strtolower($from)){
			return $dAmn->say("$from: You must be the GameMaster to assign roles.",$c);
		}
		if(!isset($args[1])){
			return $dAmn->say("$from: You need a player to assign roles to.",$c);
		}
		if(!isset($args[2])){
			return $dAmn->say("$from: You must have a roll to assign the player.",$c);
		}
		if(!isset($config['werewolf']['players'][strtolower($args[1])])){
			return $dAmn->say("$from: You can only assign roles to players.",$c);
		}
		if(!isset($config['werewolf']['notassigned'][strtolower($args[1])])){
			return $dAmn->say("$from: $args[1] already has a role.",$c);
		}
		$possible = array('gamemaster', 'werewolf', 'townie', 'witch', 'oracle', 'hunter', 'cupid', 'defender', 'harlot', 'jester', 'village idiot',);
		if(!in_array(strtolower($args[2]), $possible)){
			return $dAmn->say("$from: $args[2] is not a possible role.",$c);
		}
		$special = array('gamemaster', 'witch', 'oracle', 'hunter', 'cupid', 'defender', 'harlot', 'jester', 'village idiot',);
		if(in_array(strtolower($args[2]), $special) && in_array(strtolower($args[2]), $config['werewolf']['roles'])){
			return $dAmn->say("$from: Someone is already assigned $args[2]",$c);
		}
		if(strtolower($args[2]) == "harlot" && in_array("defender", $config['werewolf']['roles'])){
			return $dAmn->say("$from: You can't have a harlot in a game with a defender.",$c);
		}
		if(strtolower($args[2]) == "defender" && in_array("harlot", $config['werewolf']['roles'])){
			return $dAmn->say("$from: You can't have a defender in a game with a harlot.",$c);
		}
		if(strtolower($args[2]) == 'werewolf'){
			$config['werewolf']['roles'][strtolower($args[1])] = 'werewolf';
			$config['werewolf']['wolves']++;
			save_config('werewolf');
			return $dAmn->say("$from: $args[1] is a werewolf.",$c);
		}
		if(in_array(strtolower($args[2]), $special)){
			$config['werewolf']['roles'][strtolower($args[1])] = strtolower($args[2]);
			save_config('werewolf');
			return $dAmn->say("$from: $args[1] is now the $args[2].",$c);
		}
		if(strtolower($args[2]) = "townie"){
			$config['werewolf']['roles'][strtolower($args[1])] = "townie";
			save_config('werewolf');
			return $dAmn->say("$from $args[1] is now a townie.",$c);
		}
		break;
			