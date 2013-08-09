<?php
include_once(f('modules/werewolf/assign2.php'));
$gameroom = $config['werewolf']['gameroom'];
$backroom = $config['werewolf']['backroom'];
$round = $config['werewolf']['round'];
$status = $config['werewolf']['status'];
$turn = $config['werewolf']['turn'];
$talk = $config['werewolf']['muted'];
$day = $config['werewolf']['day'];
$changed = $config['werewolf']['changed'];
if(!isset($gameroom)){
	$gameroom = $c;
}
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
	case "play":
		$werewolfplayer = FALSE;
		if(isset($config['werewolf']['players'][strtolower($from)])){
			return $dAmn->say("$from: You're already playing.",$c);
		}
		$config['werewolf']['players'][strtolower($from)] = strtolower($from);
		$config['werewolf']['notassigned'][strtolower($from)] = strtolower($from);
		save_config('werewolf');
		if(isset($config['werewolf']['playerclass'])){
			$werewolfclass = $config['werewolf']['playerclass'];
		}else{
			$werewolfclass = "Players";
		}
		$dAmn->promote($from,$werewolfclass,$gameroom);
		$dAmn->promote($from,$werewolfclass,$backroom);
		$dAmn->say("$from has joined the game.",$c);
		$config['werewolf']['count']++;
		save_config('werewolf');
		break;
	case "setwitch":
		if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
			$config['werewolf']['witchsave'] = TRUE;
			$config['werewolf']['witchkill'] = TRUE;
			save_config('werewolf');
			$dAmn->say("$from: Witch potions set.",$backroom);
		}else
			$dAmn->say("$from: Only the Game Master may set the witch potions.",$c);
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
				if(isset($args[2])){
					if(!isset($config['werewolf']['gameroom'])){
						$config['werewolf']['gameroom'] = strtolower(rChatName($args[2]));
						save_config('werewolf');
						$dAmn->say("$from: The Gameroom for Werewolf is now ".rChatName($args[2]).".",$c);
					}else
						$dAmn->say("$from: You already have a gameroom set. To change it, simply type {$tr}gameroom clear and it'll reset.",$c);
				}else
					$dAmn->say("$from: Usage: ".$tr."gameroom set <i>#room</i>. The room is any dAmn chatroom.",$c);
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
		if(strtolower($c) !== $backroom){
			return $dAmn->say("$from: You can only assign roles in the backroom, which is currently $backroom.",$c);
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
			unset($config['werewolf']['notassigned'][strtolower($args[1])]);
			save_config('werewolf');
			return $dAmn->say("$from: $args[1] is a werewolf.",$c);
		}
		if(in_array(strtolower($args[2]), $special)){
			$config['werewolf']['roles'][strtolower($args[1])] = strtolower($args[2]);
			unset($config['werewolf']['notassigned'][strtolower($args[1])]);
			save_config('werewolf');
			return $dAmn->say("$from: $args[1] is now the $args[2].",$c);
		}
		if(strtolower($args[2]) == "townie"){
			$config['werewolf']['roles'][strtolower($args[1])] = "townie";
			unset($config['werewolf']['notassigned'][strtolower($args[1])]);
			save_config('werewolf');
			return $dAmn->say("$from $args[1] is now a townie.",$c);
		}
		break;
	case "xrole":
		if(isset($config['werewolf'])){
			if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
				foreach($config['werewolf']['roles'] as $someone =>$playerw){
					if(strtolower($someone) == strtolower($args[1])){
						$werewolfplayer = TRUE;
					}
				}
				if($werewolfplayer){
					if($config['werewolf']['roles'][strtolower($args[1])] == "gamemaster"){
						$dAmn->demote($args[1],"Players",$gameroom);
						$dAmn->demote($args[1],"Players",$backroom);
					}
					$config['werewolf']['roles'][strtolower($args[1])] = NULL;
					unset($config['werewolf']['roles'][strtolower($args[1])]);
					$config['werewolf']['notassigned'][strtolower($args[1])] = strtolower($args[1]);
					save_config('werewolf');
					$dAmn->say("$from: $args[1]'s role has been erased.",$c);
				}else
					$dAmn->say("$from: $args[1] isn't a player.",$c);
			}else
				$dAmn->say("$from: You can't remove roles unless you're the Game Master.",$c);
		}else
			$dAmn->say("$from: There isn't a game of Werewolf running.",$c);
		break;
	case "unplay":
		$werewolfplayer = FALSE;
		if(isset($config['werewolf'])){
			if(isset($args[1])){
				if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
					foreach($config['werewolf']['players'] as $someonew =>$playerw){
						if(strtolower($playerw) == strtolower($args[1])){
							$werewolfplayer = TRUE;
							$config['werewolf']['players'][$someonew] = NULL;
							unset($config['werewolf']['players'][$someonew]);
							unset($config['werewolf']['roles'][$playerw]);
							unset($config['werewolf']['notassigned'][$playerw]);
							sort($config['werewolf']['players']);
							$config['werewolf']['count']--;
							save_config('werewolf');
						}
					}
					if($werewolfplayer){
						if(isset($config['werewolf']['audclass'])){
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
				foreach($config['werewolf']['players'] as $harpoon =>$slayer){
					if(strtolower($slayer) == strtolower($from)){
						$werewolfplayer = TRUE;
						$config['werewolf']['players'][$harpoon] = NULL;
						unset($config['werewolf']['players'][$harpoon]);
						unset($config['werewolf']['roles'][$slayer]);
						unset($config['werewolf']['notassigned'][$slayer]);
						sort($config['werewolf']['players']);
						save_config('werewolf');
					}
				}
			
		
				if($werewolfplayer){
					if(isset($config['werewolf']['audclass'])){
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
	case "defender":
		switch($args[1]){
			case "on":
				if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
					if($config['werewolf']['defender'] != TRUE){
						$config['werewolf']['defender'] = TRUE;
						save_config('werewolf');
					}
					$dAmn->say("$from: Defender enabled! This role can now be assigned.",$c);
				}else $dAmn->say("$from: Only the Game Master can turn the Defender on or off.",$c);
				break;
			case "off":
				if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
					if($config['werewolf']['defender'] != FALSE){
						$config['werewolf']['defender'] = FALSE;
						save_config('werewolf');
					}
					$dAmn->say("$from: Defender disabled. This role is now unavailable.",$c);
				}else $dAmn->say("$from: Only the Game Master can turn the Defender on or off.",$c);
				break;
			default:
				$dAmn->say("$from: <li> <b>Defender</b>: The Defender role is one that works rather interestingly. Unlike the witch, they can protect someone from WEREWOLF attacks every round, so long as they're alive. They aren't able to protect someone from the witch or hunter. Their protection has no effect the person they're protecting is the lover of someone who was killed be it by werewolf or by witch. The defender, on their turn, selects one player to protect from werewolves for that night. They may only select to protect themself once per game. This is the command the Defender uses:</li><br>
<ul><li> <b>{$tr}defend <i>player</i> <u>confirm</u></b> is used to choose a player to defend. You only need to use confirm to defend YOURSELF if you're the defender.</li></ul>",$c);
		}
		break;
	case "cupid":
		switch($args[1]){
			case "on":
				if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
					if($config['werewolf']['cupid'] != TRUE){
						$config['werewolf']['cupid'] = TRUE;
						save_config('werewolf');
					}
					$dAmn->say("$from: Cupid enabled! This role can now be assigned.",$c);
				}else $dAmn->say("$from: Only the GameMaster can turn Cupid on or off.",$c);
				break;
			case "off":
				if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
					if($config['werewolf']['cupid'] != FALSE){
						$config['werewolf']['cupid'] = FALSE;
						save_config('werewolf');
					}
					$dAmn->say("$from: Cupid disabled. This role is now unavailable.",$c);
				}else $dAmn->say("$from: Only the GameMaster can turn Cupid on or off.",$c);
				break;
			default:
				$dAmn->say("$from: <li> <b>Cupid</b>: Cupid is a one action role, where they are responsible for selecting two lovers at the start of the game. Those lovers are bound tightly in that if one dies, the idea is that the other one can't bear to go on living without them and commit suicide, so if one dies, they both die. This role is optional. This is the command that Cupid uses:</li><br>
<ul><li> <b>{$tr}lovers <i>player1 player2</i></b> is used to select the lovers. After they are set, the Game Master will note the two lovebirds.</li></ul>",$c);
				break;
		}
		break;
	case "witch":
		$dAmn->say("$from: <li> <b>Witch</b>: The witch is an essential role to the game. They have 2 potions, one can save a player that is chosen to die by the werewolves, the other can kill a person of their choice. Their turn follows the werewolves, and they're told the person who the werewolves have chosen to kill and given the option of using those two potions. These are the commands the Witch uses:</li><br>
<ul><li> <b>{$tr}todie</b> Tells the witch who the wolves have chosen and reminds them which potions they have left.</li>
<li> <b>{$tr}saves <i>player</i> <u>confirm</u></b> is used to save the player the wolves have chosen to kill. This may only be used once per game.</li>
<li> <b>{$tr}kills <i>player</i> <u>confirm</u></b> is used to kill a player of the witch's choice. Used correctly, it could very well change the tide of the game. It may only be used once per game.</li></ul>",$c);
		break;
	case "werewolf":
		$dAmn->say("$from: <li> <b>Werewolves</b>: The werewolf role is the antagonist of the game. The townies seek to weed out the few werewolves among them. If there are no lovers, the werewolves win when the number of townies is less than or equal to the number of wolves. The goal of the werewolves are to blend in unnoticeably amongst the townspeople. The werewolves turn is at the start of each night round and consists of them gathering in the backroom and voting for a player to kill. These are the commands they use:</li><br>
<ul><li> <b>{$tr}wkill <i>player</i></b> is used by EACH wolf to vote/select their kill. The goal is to unanimously vote on one player. If they don't, then no one is killed. If they mess up and would like to revote, {$tr}xvote will clear their vote.</li>
<li> <b>{$tr}xvote</b> clears the user's vote, so they may reselect their kill.</li></ul>",$c);
		break;
	case "oracle":
		$dAmn->say("$from: <ul><li><b>Oracle</b>: The oracle is the other major townie role. They are important in that they are allowed to look at one player a turn and learn of their role. If they discover one of the wolves, they are now armed with the knowledge of one of the wolves. Revealing themselves can be a strategic move towards the end of the game to rally the townies to kill the wolves. The Oracle's turn follows after the witch. This is the command the Oracle uses. </li><br>
<ul><li> <b>{$tr}seek <i>player</i></b> displays the role of the player. It may only be used ONCE per round.</li></ul>",$c);
		break;
	case "townie":
		$dAmn->say("$from: The townie is the most basic role in the game. Their goal is merely to survive to the end and get rid of all the werewolves. They have 2 default key characters, the Witch, who has 2 potions, a save, and a kill. The save can save a person chosen victim by the wolves, and the kill, which can kill a person fo their choice. They also have the Oracle, who may peer into the role of one player a turn, and can use this info later in the game. The other townie roles are Hunter, Defender, and Cupid. The hunter, when killed, is allowed to take someone down with them. The defender is allowed to protect one player a turn from WEREWOLF only attacks. They have no effect on witch or hunter killing. They are also ineffective in stopping the death if the wolves attack the player protected's lover. Cupid's role is handled at the beginning and they choose the lovers. The lovers may be a deciding factor in the game. If there are lovers and they remain the sole survivers, they win. If one of the lovers is killed, the other dies with them.",$c);
		break;
	case "gamemaster":
		$dAmn->say("$from: <ul><li> <b>Game Master</b>: The Game Master runs the game. They also moderate it. They are the ones who assign the roles, and they are responsible for the player's roles. These are the commands they use:<br></li>
<ul><li> <b>{$tr}assign</b>: If autoassign is enabled, {$tr}assign will assign the players their roles automatically.</li>
<li> <b>{$tr}autoassign <i>on/off</i></b> is used to turn autoassigning on or off. If it is off, {$tr}assign will not work.</li>
<li> <b>{$tr}hunter, {$tr}cupid, {$tr}defender <i>on/off</i></b> is used to customize the game. These trigger whether or not the hunter, cupid, and defender roles may be assigned. If they are off, the bot will not automatically assign them.</li>
<li> <b>{$tr}sunset</b> is used to change the setting to night and mute the players.</li>
<li> <b>{$tr}sunrise</b> is used to change the setting to day. If the werewolves (and/or witch) have successfully made a kill, it will automatically kill the players they have chosen. It will also unsilence the players.</li>
<li> <b>{$tr}lynch <i>player</i> <u>confirm</u></b> is used after the vote at the end of the day round and a player has been selected to be lynched. It will kill the player.</li>
<li> <b>{$tr}end</b> will end the game, and clear everyone back to the Audience privclass. (<b>NOTE</b>: A player may end the game if they promote themselves to the Game Master privclass and use the command).</li></ul>",$c);
		break;
	case "hunter":
		switch($args[1]){
			case "on":
				if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
					if($config['werewolf']['hunter'] != TRUE){
						$config['werewolf']['hunter'] = TRUE;
						save_config('werewolf');
					}
					$dAmn->say("$from: Hunter enabled! This role can now be assigned.",$c);
				}else $dAmn->say("$from: Only the Game Master can turn the hunter role on or off.",$c);
				break;
			case "off":
				if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
					if($config['werewolf']['hunter'] != FALSE){
						$config['werewolf']['hunter'] = FALSE;
						save_config('werewolf');
					}
					$dAmn->say("$from: Hunter disabled. This role is now unavailable.",$c);
				}else $dAmn->say("$from: Only the Game Master can turn the hunter role on or off.",$c);
				break;
			default:
				$dAmn->say("$from: <li> <b>Hunter</b>: The Hunter role is different from the other townies in that when the hunter dies, they get to kill someone else. This is an optional role, however. This is the command the Hunter uses:</li><br>
<ul><li> <b>{$tr}hunt <i>player</i> <u>confirm</u></b> is used when the hunter is killed. It will the player they choose.</li></ul>",$c);
				break;
		}
		break;
	case "gm":
		if(isset($config['werewolf'])){
			$werewolfplayer = FALSE;
			foreach($config['werewolf']['players'] as $someone =>$playerw){
				if(strtolower($playerw) == strtolower($from)){
					$werewolfplayer = TRUE;
				}
			}
			if($werewolfplayer){
				$gamemaster = FALSE;
				foreach($config['werewolf']['players'] as $someone =>$playerw){
					if($config['werewolf']['roles'][$playerw] == "gamemaster"){
						$gamemaster = TRUE;
					}
				}
				if(!$gamemaster){
					$role = $config['werewolf']['roles'][strtolower($from)];
					if(!isset($role)){
						$config['werewolf']['roles'][strtolower($from)] = 'gamemaster';
						$config['werewolf']['count']--;
						$config['werewolf']['gamemaster'] = strtolower($from);
						unset($config['werewolf']['notassigned'][strtolower($from)]);
						save_config('werewolf');
						$dAmn->promote($from,"GameMaster",$gameroom);
						$dAmn->promote($from,"GameMaster",$backroom);
						$dAmn->say("$from is now the Game Master.",$gameroom);
					}else
						$dAmn->say("$from: You already have a role.",$gameroom);
				}else
					$dAmn->say("$from: Someone already is the Game Master.",$gameroom);
			}else
				$dAmn->say("$from: You can only be the game master if you're playing.",$gameroom);
		}else
			$dAmn->say("$from: You don't currently have a game of Werewolf running.",$gameroom);
		break;
	case "assign":
		if(isset($config['werewolf'])){
			if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
				$autoassign = $config['werewolf']['autorole'];
				$config['werewolf']['witchsave'] = TRUE;
				$config['werewolf']['witchkill'] = TRUE;
				save_config('werewolf');
				//$dAmn->say("$from: Witch potions set.",$backroom);
				$config['werewolf']['status'] = "In Progress";
				$config['werewolf']['round'] = 0;
				$dAmn->set("title","Game status: :bulletred: <b>{$status}</b> | Round: <b>{$round}</b> | Current turn: <b>{$turn}</b> | Player status: :bulletred: <b>Muted</b>",$gameroom);
				$dAmn->admin("update privclass Hunter +msg",$gameroom);
				if($autoassign){
					autorole();
				}else
					$dAmn->say("$from: Autoassigning is disabled.",$c);
			}else
				$dAmn->say("You have to be the Game master to assign.",$c);
		}else
			$dAmn->say("$from: There isn't a game of werewolf, so I cannot assign roles.",$c);
		break;
	case "autoassign":
		if($args[1] == "on"){
			$config['werewolf']['autorole'] = TRUE;
			$dAmn->say("$from: Autoassigning is now enabled!",$c);
			save_config('werewolf');
		}
		if($args[1] == "off"){
			$config['werewolf']['autorole'] = FALSE;
			$dAmn->say("$from: Autoassign has been disabled!",$c);
			save_config('werewolf');
		}
		break;
	
	case "end":
		if($config['werewolf']['roles'][strtolower($from)] == "gamemaster" || $user->has($from, 75)){
			$dAmn->admin("move users Players to Audience",$gameroom);
			$dAmn->admin("move users Players to Audience",$backroom);
			$dAmn->admin("move users Dead to Audience",$backroom);
			$dAmn->admin("move users GameMaster to Audience",$backroom);
			$dAmn->admin("move users Werewolves to Audience",$gameroom);
			$dAmn->admin("move users Witch to Audience",$gameroom);
			$dAmn->admin("move users Hunter to Audience",$gameroom);
			$dAmn->admin("move users Townies to Audience",$gameroom);
			$dAmn->admin("move users GameMaster to Audience",$gameroom);
			$dAmn->admin("move users Oracle to Audience",$gameroom);
			$dAmn->admin("move users Defender to Audience",$gameroom);
			$dAmn->admin("move users Cupid to Audience",$gameroom);
			$config['werewolf']['players'] = NULL;
			unset($config['werewolf']['players']);
			unset($config['werewolf']['roles']);
			unset($config['werewolf']['assigned']);
			unset($config['werewolf']['witchz']);
			unset($config['werewolf']['oraclez']);
			unset($config['werewolf']['wolves']);
			unset($config['werewolf']['wolfkill']);
			unset($config['werewolf']['gamemaster']);
			unset($config['werewolf']['witchkills']);
			unset($config['werewolf']['witchkill']);
			unset($config['werewolf']['count']);
			unset($config['werewolf']['lovers']);
			unset($config['werewolf']['hunterz']);
			unset($config['werewolf']['defenderz']);
			unset($config['werewolf']['cupidz']);
			unset($config['werewolf']['dead']);
			unset($config['werewolf']['seen']);
			unset($config['werewolf']['notassigned']);
			unset($config['werewolf']['learnrole']);
			save_config('werewolf');
			$dAmn->say("$from: Game ended.",$gameroom);
		}else
		if($config['werewolf']['roles'][strtolower($from)] != "gamemaster"){
			$power = $dAmn->room[strtolower( $c )]->getHierarchy( TRUE );
			foreach($power as $num =>$vote){
				if($num == 75){
					$config['werewolf']['canend'] = array_keys( $vote );
				}
				if($num < 50){
					unset($config['werewolf']['canend'][$num]);
				} 
			}save_config('werewolf');
			foreach($config['werewolf']['canend'] as $minge => $ending){
				if(strtolower($ending) == strtolower($from)){
					$willend = TRUE;
				}
			}
			if($willend){
				$dAmn->admin("move users Players to Audience",$gameroom);
				$dAmn->admin("move users Players to Audience",$backroom);
				$dAmn->admin("move users Dead to Audience",$backroom);
				$dAmn->admin("move users GameMaster to Audience",$backroom);
				$dAmn->admin("move users Werewolves to Audience",$gameroom);
				$dAmn->admin("move users Witch to Audience",$gameroom);
				$dAmn->admin("move users Hunter to Audience",$gameroom);
				$dAmn->admin("move users Townies to Audience",$gameroom);
				$dAmn->admin("move users GameMaster to Audience",$gameroom);
				$dAmn->admin("move users Oracle to Audience",$gameroom);
				$dAmn->admin("move users Defender to Audience",$gameroom);
				$dAmn->admin("move users Cupid to Audience",$gameroom);
				$config['werewolf']['players'] = NULL;
				unset($config['werewolf']['players']);
				unset($config['werewolf']['gamemaster']);
				unset($config['werewolf']['roles']);
				unset($config['werewolf']['assigned']);
				unset($config['werewolf']['witchz']);
				unset($config['werewolf']['oraclez']);
				unset($config['werewolf']['wolves']);
				unset($config['werewolf']['wolfkill']);
				unset($config['werewolf']['witchkills']);
				unset($config['werewolf']['witchkill']);
				unset($config['werewolf']['count']);
				unset($config['werewolf']['lovers']);
				unset($config['werewolf']['hunterz']);
				unset($config['werewolf']['defenderz']);
				unset($config['werewolf']['cupidz']);
				unset($config['werewolf']['dead']);
				unset($config['werewolf']['seen']);
				unset($config['werewolf']['canend']);
				unset($config['werewolf']['learnrole']);
				save_config('werewolf');
				$dAmn->say("$from: Game ended.",$gameroom);
			}else
				return $dAmn->say("$from: You can't end the game unless you're in the GameMaster privclass.",$c);
		}
		unset($config['werewolf']['round']);
		unset($config['werewolf']['status']);
		unset($config['werewolf']['turn']);
		unset($config['werewolf']['muted']);
		unset($config['werewolf']['day']);
		unset($config['werewolf']['changed']);
		save_config("werewolf");
		$dAmn->set("title","Game status: :bulletgreen: <b>Open</b> (join by typing <b>{$tr}play</b>)",$gameroom);
		break;
	case "assignment":
		if(strtolower($c) == strtolower($backroom)){
			$werewolfplayer = FALSE;
			foreach($config['werewolf']['players'] as $lolzx => $whatzx){
				if(strtolower($whatzx) == strtolower($from)){
					$werewolfplayer = TRUE;
					if(isset($config['werewolf']['roles'][strtolower($whatzx)])){
						$playrole = $config['werewolf']['roles'][strtolower($whatzx)];
					}else
						autorole();
						$playrole = $config['werewolf']['roles'][strtolower($whatzx)];
				}
					
			}
			if($werewolfplayer){
				$dAmn->say("$from: Your role is ".$playrole.".",$c);
			}else
				$dAmn->say("$from: Only players have roles. If you want to play, type {$tr}play.",$c);
				return;
		}else
			$dAmn->say("$from: You can only recieve your role if you're in the backroom. To hear your role, join ".rChatName($backroom).".",$c);
		break;
	case "lovers":
		if(strtolower($c) == strtolower($backroom)){
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
		break;
	case "defend":
		if(strtolower($c) == strtolower($backroom)){
			if(isset($args[1])){
				$werewolfplayer = FALSE;
				foreach($config['werewolf']['players'] as $lolzx => $whatzx){
					if(strtolower($whatzx) == strtolower($from)){
						$werewolfplayer = TRUE;
					}
				}
				if($werewolfplayer){
					if($config['werewolf']['roles'][strtolower($from)] == "defender"){
						$wolfkill = FALSE;
						foreach($config['werewolf']['players'] as $lolxz => $whatxz){
							if(strtolower($whatxz) == strtolower($args[1])){
								$wolfkill = TRUE;
							}
						}
						if($wolfkill){
							if($config['werewolf']['roles'][strtolower($args[1])] == "gamemaster"){
								$dAmn->say("$from: You can't defend the Game Master.",$c);
								return;
							}
							if($config['werewolf']['roles'][strtolower($args[1])] == "defender"){
								if($args[2] == "confirm"){
									if($config['werewolf']['defendself'] == TRUE){
										$dAmn->say("$from: Defense confirmed, you are protecting yourself and you may not protect yourself again this game.",$c);
										$config['werewolf']['todefend'] = $args[1];
										$config['werewolf']['defendself'] = FALSE;
										save_config('werewolf');
									}else
										$dAmn->say("$from: You've already defended yourself once this game. Please pick a player to defend or part.",$c);
								}else
									$dAmn->say("$from: Are you sure you want to defend yourself? If you do, cannot defend yourself again this game. Type {$tr}defend <i>player</i> (confirm) to complete the command to defend yourself.",$c);
							}
							$config['werewolf']['todefend'] = strtolower($args[1]);
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
		break;						
	case "wkill":
		if(strtolower($c) == strtolower($backroom)){
			if(!empty($config['werewolf']['wolfvoted'])){
					if(in_array($from,$config['werewolf']['wolfvoted'])){
						$dAmn->say("$from: You can't vote multiple times. If you messed your vote up, type {$tr}xvote.",$c);
						return;
					}
				}
			if(isset($args[1])){
				foreach($config['werewolf']['players'] as $nomes => $cocks){
					if(strtolower($cocks) == strtolower($args[1])){
						if($config['werewolf']['roles'][$args[1]] == "gamemaster"){
							$dAmn->say("$from: You can't kill the Game Master :noes: ",$c);
							return;
						}
					
					}
				}
				$werewolfplayer = FALSE;
				foreach($config['werewolf']['players'] as $lolzx => $whatzx){
					if(strtolower($whatzx) == strtolower($from)){
						$werewolfplayer = TRUE;
					}
				}
				
				if($werewolfplayer){
					if($config['werewolf']['roles'][strtolower($from)] == "werewolf"){
						
						$wolfkill = FALSE;
							foreach($config['werewolf']['players'] as $lolxz => $whatxz){
								if(strtolower($whatxz) == strtolower($args[1])){
								$wolfkill = TRUE;
								}
							}
							
						if($wolfkill){
							$config['werewolf']['tokill'][strtolower($args[1])]++;
							$config['werewolf']['wolfvoted'][] = $from;
							save_config('werewolf');
							$dAmn->say("$args[1] has ".$config['werewolf']['tokill'][strtolower($args[1])]." out of ".$config['werewolf']['wolves']." votes. If you accidently voted for someone else, type {$tr}xvote and vote again.",$c);
							if($config['werewolf']['tokill'][strtolower($args[1])] == $config['werewolf']['wolves']){
								$dAmn->say("$args[1] has been selected as the kill. You may part now.",$c);
								unset($config['werewolf']['tokill']);
								unset($config['werewolf']['wolfvoted']);
								$config['werewolf']['wolfkill'] = strtolower($args[1]);
								save_config('werewolf');
							}
						}else
							$dAmn->say("$from: You cannot select someone who isn't playing to kill.",$c);
					}else
						$dAmn->say("$from: Only werewolves can use this command.",$c);
				}else
					$dAmn->say("$from: This command is for players only.",$c);
			}else
				$dAmn->say("$from: Usage: ".$tr."wkill <i>player</i>.",$c);
		}else
			$dAmn->say("$from: You can only use this command in the back room. Join ".rChatName($backroom).".",$c);
		break;
	case "xvote":
		if(strtolower($c) == strtolower($backroom)){
			$werewolfplayer = FALSE;
			foreach($config['werewolf']['players'] as $lolzx => $whatzx){
				if(strtolower($whatzx) == strtolower($from)){
					$werewolfplayer = TRUE;
				}
			}
			if($werewolfplayer){
				if($config['werewolf']['roles'][strtolower($from)] == "werewolf"){
					$hasvoted = FALSE;
					foreach($config['werewolf']['wolfvoted'] as $far => $outscape){
						if(strtolower($outscape) == strtolower($from)){
							unset($config['werewolf']['wolfvoted'][$far]);
							sort($config['werewolf']['wolfvoted']);
							save_config('werewolf');
							$hasvoted = TRUE;
						}
					}
					if($hasvoted){
						$dAmn->say("$from: Your vote has been cleared. You may now vote again.",$c);
					}else
						$dAmn->say("$from: You haven't voted yet.",$c);
				}else
					$dAmn->say("$from: Only werewolves can use this command.",$c);
			}else
				$dAmn->say("$from: This command is for players only.",$c);
		}else
			$dAmn->say("$from: You can only use this command in the back room. Join ".rChatName($backroom).".",$c);
		break;
	case "mute":
		$dAmn->admin("update privclass $args[1] -msg",$c);
		break;
	case "unmute":
		$dAmn->admin("update privclass $args[1] +msg",$c);
		break;
	case "todie":
		if(strtolower($c) == strtolower($backroom)){
			$werewolfplayer = FALSE;
			foreach($config['werewolf']['players'] as $lolzx => $whatzx){
				if(strtolower($whatzx) == strtolower($from)){
					$werewolfplayer = TRUE;
				}
			}
			if($werewolfplayer){
				if($config['werewolf']['roles'][strtolower($from)] == "witch"){
					$dAmn->say("$from: The wolves have selected ".$config['werewolf']['wolfkill']." to kill.",$c);
					if($config['werewolf']['witchsave'] == TRUE){
						$dAmn->say("$from: You can save. Do you wish to save the victim? If so, {$tr}saves will save them. Doing so means it cannot be undone.",$c);
					}else
					if($config['werewolf']['witchsave'] == FALSE){
						$dAmn->say("$from: You cannot save.",$c);
					}
					if($config['werewolf']['witchkill'] == TRUE){
						$dAmn->say("$from: You can kill. Do you wish to kill someone? If so, {$tr}kills <i>player</i> will kill them. Be careful in your choice.",$c);
					}else
					if($config['werewolf']['witchkill'] == FALSE){
						$dAmn->say("$from: You cannot kill.",$c);
					}
				}else
					$dAmn->say("$from: Only the witch can use this command.",$c);
			}else
				$dAmn->say("$from: This command is for players only.",$c);
		}else
			$dAmn->say("$from: You can only use this command in the back room. Join ".rChatName($backroom).".",$c);
		break;
	case "saves":
		if(strtolower($c) == strtolower($backroom)){
			$werewolfplayer = FALSE;
			foreach($config['werewolf']['players'] as $lolzx => $whatzx){
				if(strtolower($whatzx) == strtolower($from)){
					$werewolfplayer = TRUE;
				}
			}
			if($werewolfplayer){
				if($config['werewolf']['roles'][strtolower($from)] == "witch"){
					if($config['werewolf']['witchsave'] == TRUE){
						if($args[1] == "confirm"){
							$config['werewolf']['wolfkill'] = NULL;
							unset($config['werewolf']['wolfkill']);
							$config['werewolf']['witchsave'] = FALSE;
							save_config('werewolf');
							$dAmn->say("$from: Save confirmed. You have prevented the wolf from killing a victim and used your save.",$c);
						}else
							$dAmn->say("$from: Are you sure you want to use your save? If so, {$tr}saves confirm to complete the command.",$c);
					}else
					if($config['werewolf']['witchsave'] == FALSE){
						$dAmn->say("$from: You do not have a save to use.",$c);
					}
				}else
					$dAmn->say("$from: Only the witch can use this command.",$c);
			}else
				$dAmn->say("$from: This command is for players only.",$c);
		}else
			$dAmn->say("$from: You can only use this command in the back room. Join ".rChatName($backroom).".",$c);
		break;
	case "kills":
		if(strtolower($c) == strtolower($backroom)){
			if(isset($args[1])){
				$werewolfplayer = FALSE;
				foreach($config['werewolf']['players'] as $lolzx => $whatzx){
					if(strtolower($whatzx) == strtolower($from)){
						$werewolfplayer = TRUE;
					}
				}
				if($werewolfplayer){
					if($config['werewolf']['roles'][strtolower($from)] == "witch"){
						if($config['werewolf']['roles'][strtolower($args[1])] == "gamemaster"){
							$dAmn->say("$from: You can't kill the GameMaster.",$c);
							return;
						}
						if($config['werewolf']['witchkill'] == TRUE){
							$wolfkill = FALSE;
								foreach($config['werewolf']['players'] as $lolxz => $whatxz){
									if(strtolower($whatxz) == strtolower($args[1])){
										$wolfkill = TRUE;
									}
								}
								
							if($wolfkill){
								if($args[2] == "confirm"){
									$config['werewolf']['witchkills'] = $args[1];
									$config['werewolf']['witchkill'] = FALSE;
									save_config('werewolf');
									$dAmn->say("$from: Kill confirmed. At the sunrise, $args[1] will die.",$c);
								}else
									$dAmn->say("$from: Are you sure you want to use your kill? If so, <b>{$tr}kills <i>victim</i> confirm</b> to complete the command.",$c);
							}else
								$dAmn->say("$from: You can't kill anyone not playing the game.",$c);
						}else
						if($config['werewolf']['witchkill'] == FALSE){
							$dAmn->say("$from: You do not have a kill to use.",$c);
						}
					}else
						$dAmn->say("$from: Only the witch can use this command.",$c);
				}else
					$dAmn->say("$from: This command is for players only.",$c);
			}else
				$dAmn->say("$from: Usage: <b>{$tr}kills <i>victim</i> confirm</b>. Victim is any player of this current game. You must have confirm.",$c);
		}else
			$dAmn->say("$from: You can only use this command in the back room. Join ".rChatName($backroom).".",$c);
		break;
	case "seek":
		if(strtolower($c) == strtolower($backroom)){
			if(isset($args[1])){
				$werewolfplayer = FALSE;
				foreach($config['werewolf']['players'] as $lolzx => $whatzx){
					if(strtolower($whatzx) == strtolower($from)){
						$werewolfplayer = TRUE;
					}
				}
				if($werewolfplayer){
					if($config['werewolf']['roles'][strtolower($from)] == "oracle"){
						if($config['werewolf']['oracleview'] == TRUE){
							if($config['werewolf']['roles'][strtolower($args[1])] == strtolower($from)){
								$dAmn->say("$from: You can't look into yourself.",$c);
								return;
							}
							if($config['werewolf']['roles'][strtolower($args[1])] == "gamemaster"){
								$dAmn->say("$from: You can't look into the GameMaster.",$c);
								return;
							}
							$wolfkill = FALSE;
							foreach($config['werewolf']['players'] as $lolxz => $whatxz){
								if(strtolower($whatxz) == strtolower($args[1])){
									$wolfkill = TRUE;
								}
							}
							if($wolfkill){
								$prevturn = FALSE;
								foreach($config['werewolf']['seen'] as $taco => $meat){
									if(strtolower($meat) == strtolower($args[1])){
										$prevturn = TRUE;
									}
								}
								if(!$prevturn){
									$dAmn->say("$from: $args[1] is a ".$config['werewolf']['roles'][strtolower($args[1])].". You may now part. ",$c);
									$config['werewolf']['seen'][] = strtolower($args[1]);
									$config['werewolf']['oracleview'] = FALSE;
									save_config('werewolf');
								}else
									$dAmn->say("$from: You've looked at $args[1] before. Please pick another player.",$c);
							}else
								$dAmn->say("$from: You can only peer into the role of an existing player.",$c);
						}else
							$dAmn->say("$from: Either you have used your view this turn, or the Game Master forgot to set it.",$c);
					}else
						$dAmn->say("$from: Only the Oracle can use this command.",$c);
				}else
					$dAmn->say("$from: This command is for players only.",$c);
			}else
				$dAmn->say("$from: Usage: <b>{$tr}seeks <i>player</i></b>. Shows the role of the player.",$c);
		}else
			$dAmn->say("$from: You can only use this command in the back room. Join ".rChatName($backroom).".",$c);
		break;
	case "sunrise":
		if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
			if(isset($config['werewolf']['todefend'])){
				if(strtolower($config['werewolf']['wolfkill']) == strtolower($config['werewolf']['todefend'])){
					unset($config['werewolf']['wolfkill']);
					unset($config['werewolf']['todefend']);
					save_config('werewolf');
				}
			}
			if(isset($config['werewolf']['wolfkill'])){
				
				if(isset($config['werewolf']['lovers'])){
					foreach($config['werewolf']['lovers'] as $tac => $ose){
						if(strtolower($ose) == strtolower($config['werewolf']['wolfkill'])){
							$arelovers = TRUE;
						}
					}
					if($arelovers){
						foreach($config['werewolf']['lovers'] as $tak => $en){
							if($config['werewolf']['roles'][strtolower($en)] == "werewolf"){
								$config['werewolf']['wolves']--;
								$dAmn->demote($en,"Werewolves",$gameroom);
							}
							if($config['werewolf']['roles'][strtolower($en)] == "townie"){
								$dAmn->demote($en,"Townies",$gameroom);
							}
							if($config['werewolf']['roles'][strtolower($en)] == "witch"){
								$dAmn->demote($en,"Witch",$gameroom);
							}
							if($config['werewolf']['roles'][strtolower($en)] == "oracle"){
								$dAmn->demote($en,"Oracle",$gameroom);
							}
							if($config['werewolf']['roles'][strtolower($en)] == "defender"){
								$dAmn->demote($en,"Defender",$gameroom);
							}
							if(strtolower($config['werewolf']['roles'][strtolower($en)]) == "hunter"){
								$dAmn->demote($en,"Hunter",$gameroom);
								$canhunt = TRUE;
							}
							if($config['werewolf']['roles'][strtolower($en)] == "cupid"){
								$dAmn->demote($en,"Cupid",$gameroom);
							}
						
							$dAmn->demote($ose,"Dead",$backroom);
							$config['werewolf']['dead'][] = $config['werewolf']['witchkills'];
							if(!$canhunt){
								unset($config['werewolf']['todefend']);
								unset($config['werewolf']['roles'][strtolower($en)]);
								save_config('werewolf');
							}else
							if($canhunt){
								$dAmn->say("$en, being the hunter, you are entitled to take someone out with you. Select your kill with {$tr}hunt <i>player</i>.",$gameroom);
								unset($config['werewolf']['wolfkill']);
								save_config('werewolf');
							}
						}
					}
				}
				$tacos2 = $config['werewolf']['wolfkill'];
				if($config['werewolf']['roles'][strtolower($tacos2)] == "werewolf"){
					$config['werewolf']['wolves']--;
					$dAmn->demote($config['werewolf']['wolfkill'],"Werewolves",$gameroom);
				}
				if($config['werewolf']['roles'][strtolower($tacos2)] == "townie"){
					$dAmn->demote($config['werewolf']['wolfkill'],"Townies",$gameroom);
				}
				if($config['werewolf']['roles'][strtolower($tacos2)] == "witch"){
					$dAmn->demote($config['werewolf']['wolfkill'],"Witch",$gameroom);
				}
				if($config['werewolf']['roles'][strtolower($tacos2)] == "oracle"){
					$dAmn->demote($config['werewolf']['wolfkill'],"Oracle",$gameroom);
				}
				if($config['werewolf']['roles'][strtolower($tacos2)] == "defender"){
					$dAmn->demote($config['werewolf']['wolfkill'],"Defender",$gameroom);
				}
				if(strtolower($config['werewolf']['roles'][strtolower($tacos2)]) == "hunter"){
					$dAmn->demote($config['werewolf']['wolfkill'],"Hunter",$gameroom);
					$canhunt = TRUE;
				}
				if($config['werewolf']['roles'][strtolower($tacos2)] == "cupid"){
					$dAmn->demote($config['werewolf']['wolfkill'],"Cupid",$gameroom);
				}
			
				$dAmn->demote($config['werewolf']['wolfkill'],"Dead",$backroom);
				$config['werewolf']['dead'][] = $config['werewolf']['wolfkill'];
				if(!$canhunt){
					unset($config['werewolf']['todefend']);
					unset($config['werewolf']['roles'][strtolower($tacos2)]);
					unset($config['werewolf']['wolfkill']);
					save_config('werewolf');
				}else
				if($canhunt){
					$dAmn->say("$tacos2, being the hunter, you are entitled to take someone out with you. Select your kill with {$tr}hunt <i>player</i>.",$gameroom);
					unset($config['werewolf']['wolfkill']);
					save_config('werewolf');
				}
			}
			if(isset($config['werewolf']['witchkills'])){
				if(isset($config['werewolf']['lovers'])){ 
					foreach($config['werewolf']['lovers'] as $tac => $ose){
						if(strtolower($ose) == strtolower($config['werewolf']['witchkills'])){
							$arelovers = TRUE;
						}
					}
					if($arelovers){
						foreach($config['werewolf']['lovers'] as $tak => $en){
							if($config['werewolf']['roles'][strtolower($en)] == "werewolf"){
								$config['werewolf']['wolves']--;
								$dAmn->demote($en,"Werewolves",$gameroom);
							}
							if($config['werewolf']['roles'][strtolower($en)] == "townie"){
								$dAmn->demote($en,"Townies",$gameroom);
							}
							if($config['werewolf']['roles'][strtolower($en)] == "witch"){
								$dAmn->demote($en,"Witch",$gameroom);
							}
							if($config['werewolf']['roles'][strtolower($en)] == "oracle"){
								$dAmn->demote($en,"Oracle",$gameroom);
							}
							if($config['werewolf']['roles'][strtolower($en)] == "defender"){
								$dAmn->demote($en,"Defender",$gameroom);
							}
							if(strtolower($config['werewolf']['roles'][strtolower($en)]) == "hunter"){
								$dAmn->demote($en,"Hunter",$gameroom);
								$canhunt = TRUE;
							}
							if($config['werewolf']['roles'][strtolower($en)] == "cupid"){
								$dAmn->demote($en,"Cupid",$gameroom);
							}
						
							$dAmn->demote($ose,"Dead",$backroom);
							$config['werewolf']['dead'][] = $config['werewolf']['witchkills'];
							if(!$canhunt){
								unset($config['werewolf']['todefend']);
								unset($config['werewolf']['roles'][strtolower($en)]);
								save_config('werewolf');
							}else
							if($canhunt){
								$dAmn->say("$en, being the hunter, you are entitled to take someone out with you. Select your kill with {$tr}hunt <i>player</i>.",$gameroom);
								unset($config['werewolf']['witchkills']);
								save_config('werewolf');
							}
						}
					}
				}
				$tacos = $config['werewolf']['witchkills'];
				if($config['werewolf']['roles'][strtolower($tacos)] == "werewolf"){
					$config['werewolf']['wolves']--;
					$dAmn->demote($config['werewolf']['witchkills'],"Werewolves",$gameroom);
				}
				if($config['werewolf']['roles'][strtolower($tacos)] == "townie"){
					$dAmn->demote($config['werewolf']['witchkills'],"Townies",$gameroom);
				}
				if($config['werewolf']['roles'][strtolower($tacos)] == "witch"){
					$dAmn->demote($config['werewolf']['witchkills'],"Witch",$gameroom);
				}
				if($config['werewolf']['roles'][strtolower($tacos)] == "oracle"){
					$dAmn->demote($config['werewolf']['witchkills'],"Oracle",$gameroom);
				}
				if($config['werewolf']['roles'][strtolower($tacos)] == "defender"){
					$dAmn->demote($config['werewolf']['witchkills'],"Defender",$gameroom);
				}
				if($config['werewolf']['roles'][strtolower($tacos)] == "Hunter"){
					$dAmn->demote($config['werewolf']['witchkills'],"Hunter",$gameroom);
					$canhunt = TRUE;
				}
				if($config['werewolf']['roles'][strtolower($tacos)] == "cupid"){
					$dAmn->demote($config['werewolf']['witchkills'],"Cupid",$gameroom);
				}
			
				$dAmn->demote($config['werewolf']['witchkills'],"Dead",$backroom);
				unset($config['werewolf']['todefend']);
				$config['werewolf']['dead'][] = $config['werewolf']['witchkills'];
				if(!$canhunt){
					unset($config['werewolf']['roles'][strtolower($tacos)]);
					save_config('werewolf');
				}else
				if($canhunt){
					$dAmn->say("$tacos, being the hunter, you are entitled to take someone out with you. Select your kill with {$tr}hunt <i>player</i>.",$gameroom);
					unset($config['werewolf']['witchkills']);
					save_config('werewolf');
				}
			}
			$dAmn->admin("update privclass Players +msg",$gameroom);
			$config['werewolf']['day'] = "Day";
			$turn = "Townies (Lynching)";
			$dAmn->set("title","Game status: :bulletred: <b>{$status}</b> | Round: <b>{$round}</b> | Current turn: <b>{$turn}</b> | Player status: :bulletgreen: <b>Open</b>",$gameroom);
		}else
			$dAmn->say("$from: Only the Game Master can declare sunrise.",$c);
		break;
	case "lynch":
		if(strtolower($c) == strtolower($gameroom)){
			if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
				if(isset($args[1])){
					$wolfkill = FALSE;
					foreach($config['werewolf']['players'] as $lolxz => $whatxz){
						if(strtolower($whatxz) == strtolower($args[1])){
							$wolfkill = TRUE;
						}
					}
					if($wolfkill){
						
						if($config['werewolf']['roles'][strtolower($args[1])] == "gamemaster"){
							$dAmn->say("$from: You can't lynch yourself, you're the Game Master!",$c);
							return;
						}
						if(strtolower($args[2]) == "confirm"){
							if(isset($config['werewolf']['lovers'])){
								foreach($config['werewolf']['lovers'] as $tac => $ose){
									if(strtolower($ose) == strtolower($args[1])){
										$arelovers = TRUE;
									}
								}
								if($arelovers){
									foreach($config['werewolf']['lovers'] as $tak => $en){
										if($config['werewolf']['roles'][strtolower($en)] == "werewolf"){
											$config['werewolf']['wolves']--;
											$dAmn->demote($en,"Werewolves",$gameroom);
										}
										if($config['werewolf']['roles'][strtolower($en)] == "townie"){
											$dAmn->demote($en,"Townies",$gameroom);
										}
										if($config['werewolf']['roles'][strtolower($en)] == "witch"){
											$dAmn->demote($en,"Witch",$gameroom);
										}
										if($config['werewolf']['roles'][strtolower($en)] == "oracle"){
											$dAmn->demote($en,"Oracle",$gameroom);
										}
										if($config['werewolf']['roles'][strtolower($en)] == "defender"){
											$dAmn->demote($en,"Defender",$gameroom);
										}
										if(strtolower($config['werewolf']['roles'][strtolower($en)]) == "hunter"){
											$dAmn->demote($en,"Hunter",$gameroom);
											$canhunt = TRUE;
										}
										if($config['werewolf']['roles'][strtolower($en)] == "cupid"){
											$dAmn->demote($en,"Cupid",$gameroom);
										}
									
										$dAmn->demote($ose,"Dead",$backroom);
										$config['werewolf']['dead'][] = $config['werewolf']['witchkills'];
										if(!$canhunt){
											unset($config['werewolf']['todefend']);
											unset($config['werewolf']['roles'][strtolower($en)]);
											save_config('werewolf');
										}else
										if($canhunt){
											$dAmn->say("$en, being the hunter, you are entitled to take someone out with you. Select your kill with {$tr}hunt <i>player</i>.",$gameroom);
											
										}
									}
								}
							}
							$config['werewolf']['dead'][] = strtolower($args[1]);
							$tacos = $args[1];
							if($config['werewolf']['roles'][strtolower($tacos)] == "werewolf"){
								$config['werewolf']['wolves']--;
								$dAmn->demote($args[1],"Werewolves",$gameroom);
							}
							if($config['werewolf']['roles'][strtolower($tacos)] == "townie"){
								$dAmn->demote($args[1],"Townies",$gameroom);
							}
							if($config['werewolf']['roles'][strtolower($tacos)] == "witch"){
								$dAmn->demote($args[1],"Witch",$gameroom);
							}
							if($config['werewolf']['roles'][strtolower($tacos)] == "oracle"){
								$dAmn->demote($args[1],"Oracle",$gameroom);
							}
							if($config['werewolf']['roles'][strtolower($tacos)] == "defender"){
								$dAmn->demote($args[1],"Defender",$gameroom);
							}
							if(strtolower($config['werewolf']['roles'][strtolower($tacos)]) == "hunter"){
								$dAmn->demote($args[1],"Hunter",$gameroom);
								$canhunt = TRUE;
							}
							if($config['werewolf']['roles'][strtolower($tacos)] == "cupid"){
								$dAmn->demote($args[1],"Cupid",$gameroom);
							}
							$dAmn->demote($args[1],"Dead",$backroom);
							if(!$canhunt){
								unset($config['werewolf']['roles'][strtolower($args[1])]);
								save_config('werewolf');
							}else
							if($canhunt){
								$dAmn->say("$args[1], being the hunter, you are entitled to take someone out with you. Select your kill with {$tr}hunt <i>player</i>.",$gameroom);
							}
							$dAmn->say("$args[1], you are now dead. You may join the backroom and spectate if you wish.",$c);
						}else
							$dAmn->say("$from: You must include <i>confirm</i> at the end of the {$tr}lynch <i>player</i>.",$c);
					}else
						$dAmn->say("$from: You can only lynch players. Make sure you're spelling the username correctly.",$c);
				}else 
					$dAmn->say("$from: Usage: <b>{$tr}lynch <i>player</i> confirm</b>. This is for after the vote when the players have discussed amongst themselves.",$c);
			}else
				$dAmn->say("$from: Only the Game Master may use this command.",$c);
		}else
			$dAmn->say("$from: You can only use this command in the game room. Join ".rChatName($gameroom).".",$c);
		break;
	case "hunt":
		if(strtolower($c) == strtolower($gameroom)){
			foreach($config['werewolf']['dead'] as $holes => $hunterd){
				if(strtolower($hunterd) == strtolower($from)){
					$canhunt = TRUE;
				}
			}
			if($canhunt){
				if($config['werewolf']['roles'][strtolower($from)] == "Hunter"){
					if(isset($args[1])){
						$wolfkill = FALSE;
						foreach($config['werewolf']['players'] as $lolxz => $whatxz){
							if(strtolower($whatxz) == strtolower($args[1])){
								$wolfkill = TRUE;
							}
						}
						if($wolfkill){
							if($config['werewolf']['roles'][strtolower($args[1])] == "gamemaster"){
								$dAmn->say("$from: You can't kill the Game Master. Please select a different player.",$c);
								return;
							}
							if($config['werewolf']['roles'][strtolower($args[1])] == "Hunter"){
								$dAmn->say("$from: You can't kill yourself. You're already dead.",$c);
								return;
							}
							foreach($config['werewolf']['dead'] as $cun => $ts){
								if(strtolower($ts) == strtolower($args[1])){
									$alreadydead = TRUE;
								}
							}
							if($alreadydead){
								$dAmn->say("$from: You can't kill $args[1], as they're already dead.",$c);
								return;
							}
							if(strtolower($args[2]) == "confirm"){
								if(isset($config['werewolf']['lovers'])){
									foreach($config['werewolf']['lovers'] as $tac => $ose){
										if(strtolower($ose) == strtolower($args[1])){
											$arelovers = TRUE;
										}
									}
									if($arelovers){
										foreach($config['werewolf']['lovers'] as $tak => $en){
											if($config['werewolf']['roles'][strtolower($en)] == "werewolf"){
												$config['werewolf']['wolves']--;
												$dAmn->demote($en,"Werewolves",$gameroom);
											}
											if($config['werewolf']['roles'][strtolower($en)] == "townie"){
												$dAmn->demote($en,"Townies",$gameroom);
											}
											if($config['werewolf']['roles'][strtolower($en)] == "witch"){
												$dAmn->demote($en,"Witch",$gameroom);
											}
											if($config['werewolf']['roles'][strtolower($en)] == "oracle"){
												$dAmn->demote($en,"Oracle",$gameroom);
											}
											if($config['werewolf']['roles'][strtolower($en)] == "defender"){
												$dAmn->demote($en,"Defender",$gameroom);
											}
											if($config['werewolf']['roles'][strtolower($en)] == "Hunter"){
												$dAmn->demote($en,"Hunter",$gameroom);
												$canhunt = TRUE;
											}
											if($config['werewolf']['roles'][strtolower($en)] == "cupid"){
												$dAmn->demote($en,"Cupid",$gameroom);
											}
										
											$dAmn->demote($ose,"Dead",$backroom);
											$config['werewolf']['dead'][] = $config['werewolf']['witchkills'];
											if(!$canhunt){
												unset($config['werewolf']['todefend']);
												unset($config['werewolf']['roles'][strtolower($en)]);
												save_config('werewolf');
											}else
											if($canhunt){
												$dAmn->say("$en, being the hunter, you are entitled to take someone out with you. Select your kill with {$tr}hunt <i>player</i>.",$gameroom);
												
												save_config('werewolf');
											}
										}
									}
								}
								$config['werewolf']['dead'][] = strtolower($args[1]);
								$tacos = $args[1];
								if($config['werewolf']['roles'][strtolower($tacos)] == "werewolf"){
									$config['werewolf']['wolves']--;
									$dAmn->demote($args[1],"Werewolves",$gameroom);
								}
								if($config['werewolf']['roles'][strtolower($tacos)] == "townie"){
									$dAmn->demote($args[1],"Townies",$gameroom);
								}
								if($config['werewolf']['roles'][strtolower($tacos)] == "witch"){
									$dAmn->demote($args[1],"Witch",$gameroom);
								}
								if($config['werewolf']['roles'][strtolower($tacos)] == "oracle"){
									$dAmn->demote($args[1],"Oracle",$gameroom);
								}
								if($config['werewolf']['roles'][strtolower($tacos)] == "defender"){
									$dAmn->demote($args[1],"Defender",$gameroom);
								}
								if($config['werewolf']['roles'][strtolower($tacos)] == "Hunter"){
									$dAmn->demote($args[1],"Hunter",$gameroom);
								}
								if($config['werewolf']['roles'][strtolower($tacos)] == "cupid"){
									$dAmn->demote($args[1],"Cupid",$gameroom);
								}
								$dAmn->demote($args[1],"Dead",$backroom);
								unset($config['werewolf']['roles'][strtolower($args[1])]);
								unset($config['werewolf']['roles'][strtolower($from)]);
								save_config('werewolf');
								$dAmn->say("$args[1], you are now dead. You may join the backroom and spectate if you wish.",$c);
								$dAmn->admin("update privclass Hunter -msg",$gameroom);
							}else
								$dAmn->say("$from: Are you sure this is the person you want to kill? If so, retype as {$tr}hunt $args[1] <i>confirm</i> including the confirm.",$c);
						}else
							$dAmn->say("$from: You can only kill players of the game, and they must still be alive.",$c);
					}else
						$dAmn->say("$from: Usage: {$tr}hunt <i>player <b>confirm</b></i>. You must include the confirm or it won't count.",$c);
				}else
					$dAmn->say("$from: Only the hunter can use this command.",$c);
			}else
				$dAmn->say("$from: This command can't be used until the hunter has been killed.",$c);
		}else
			$dAmn->say("$from: You can only use this command in the game room. Join ".rChatName($gameroom).".",$c);
		break;
}
$partwatch = FALSE;
if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
	$partwatch = TRUE;
}
$tr = $config['bot']['trigger'];
if(strtolower($c) == strtolower($backroom)){
	if($config['werewolf']['roles'][strtolower($from)] == "werewolf"){
		if($day == "Night"){
			if(!$changed){
				$turn = "Werewolves";
				$dAmn->set("title","Game status: :bulletred: <b>{$status}</b> | Round: <b>{$round}</b> | Current turn: <b>{$turn}</b> | Player status: :bulletred: <b>Muted</b>",$gameroom);
				$config['werewolf']['changed'] = TRUE;
				$dAmn->set("title","Game status: :bulletred: <b>{$status}</b> | Round: <b>{$round}</b> | Current turn: <b>{$turn}</b> | Player status: :bulletred: <b>Muted</b>",$gameroom);
			}
		}
		
	}
	if($config['werewolf']['roles'][strtolower($from)] == "witch"){
		
		if($day == "Night"){
			$turn = "Witch";
			$dAmn->set("title","Game status: :bulletred: <b>{$status}</b> | Round: <b>{$round}</b> | Current turn: <b>{$turn}</b> | Player status: :bulletred: <b>Muted</b>",$gameroom);
		}
	}
	if($config['werewolf']['roles'][strtolower($from)] == "oracle"){
		
		if($day == "Night"){
			$turn = "Oracle";
			$dAmn->set("title","Game status: :bulletred: <b>{$status}</b> | Round: <b>{$round}</b> | Current turn: <b>{$turn}</b> | Player status: :bulletred: <b>Muted</b>",$gameroom);
		}
	}
	if($config['werewolf']['roles'][strtolower($from)] == "defender"){
		
		if($day == "Night"){
			$turn = "Defender";
			$dAmn->set("title","Game status: :bulletred: <b>{$status}</b> | Round: <b>{$round}</b> | Current turn: <b>{$turn}</b> | Player status: :bulletred: <b>Muted</b>",$gameroom);
		}
	}
	if($config['werewolf']['roles'][strtolower($from)] == "cupid"){
		
		if($day == "Night"){
			$turn = "Cupid";
			$dAmn->set("title","Game status: :bulletred: <b>{$status}</b> | Round: <b>{$round}</b> | Current turn: <b>{$turn}</b> | Player status: :bulletred: <b>Muted</b>",$gameroom);
		}
	}
}
/*if($partwatch){
	if($config['werewolf']['roles'][strtolower($from)] == "gamemaster"){
		unset($config['werewolf']['roles'][strtolower($from)]);
		foreach($config['werewolf']['players'] as $cocks => $sacks){
			if(strtolower($sacks) == strtolower($from)){
				unset($config['werewolf']['players'][$cocks]);
			}
		}
		save_config('werewolf');
		$dAmn->demote($from, "Audience",$gameroom);
		$dAmn->demote($from, "Audience",$backroom);
		return;
	}
}
*/