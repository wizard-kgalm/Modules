<?php
include_once( "./modules/werewolf/functions.php" );
$status = $config->df['werewolf']['status'];
$round  = $config->df['werewolf']['round'];
$gameroom = $config->df['werewolf']['gameroom'];
$backroom = $config->df['werewolf']['backroom'];
switch( $args[0] ) {
	case "gamemaster":
		$dAmn->say("$from: <ul><li> <b>Game Master</b>: The Game Master runs the game. They also moderate it. They are the ones who assign the roles, and they are responsible for the player's roles. These are the commands they use:<br></li>
		<ul><li> <b>{$tr}assign</b>: If autoassign is enabled, {$tr}assign will assign the players their roles automatically.</li>
		<li> <b>{$tr}autoassign <i>on/off</i></b> is used to turn autoassigning on or off. If it is off, {$tr}assign will not work.</li>
		<li> <b>{$tr}hunter, {$tr}cupid, {$tr}defender <i>on/off</i></b> is used to customize the game. These trigger whether or not the hunter, cupid, and defender roles may be assigned. If they are off, the bot will not automatically assign them.</li>
		<li> <b>{$tr}sunset</b> is used to change the setting to night and mute the players.</li>
		<li> <b>{$tr}sunrise</b> is used to change the setting to day. If the werewolves (and/or witch) have successfully made a kill, it will automatically kill the players they have chosen. It will also unsilence the players.</li>
		<li> <b>{$tr}lynch <i>player</i> <u>confirm</u></b> is used after the vote at the end of the day round and a player has been selected to be lynched. It will kill the player.</li>
		<li> <b>{$tr}end</b> will end the game, and clear everyone back to the Audience privclass. (<b>NOTE</b>: A player may end the game if they promote themselves to the Game Master privclass and use the command).</li></ul>", $c );
	break;
	case "autoassign":
		switch( $args[1] ) {
			case "on" :
				$config->df['werewolf']['autorole'] = TRUE;
				$dAmn->say("$from: Autoassigning is now enabled!",$c);
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			break;
			case "off":
				$config->df['werewolf']['autorole'] = FALSE;
				$dAmn->say("$from: Autoassign has been disabled!",$c);
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			break;
			default: 
				$dAmn->say( "$from: This controls whether or not the bot is allowed to use the auto-assigner at the beginning of the game.", $c );
			break;
		}
	break;
	case "assign":
		if( empty( $config->df['werewolf'] ) ) {						// These odds are almost non-existent.
			return $dAmn->say( "$from: Something went wrong, the file may be corrupted. Please contact the bot host.", $c );
		}
		if( $config->df['werewolf']['gamemaster'] != strtolower( $from ) ) {
			return $dAmn->say( "$from: Only the GameMaster may initialize the autoassigner.", $c );
		}
		if( $config->df['werewolf']['autorole'] === FALSE || !isset( $config->df['werewolf']['autorole'] ) ) {
			return $dAmn->say( "$from: Autoassigning is currently disabled. <i>{$tr}autoassign on</i> to change it.", $c );
		}
		autorole();
		$config->df['werewolf']['witchsave']  = TRUE;
		$config->df['werewolf']['witchkill']  = TRUE;
		$config->df['werewolf']['selfdefend'] = TRUE;
		$config->df['werewolf']['roleswap']   = TRUE;					// For the jester.. he who swaps the roles of two unsuspecting people.
		$config->df['werewolf']['status']     = "In Progress";
		$config->df['werewolf']['round']      = 0;
		$dAmn->set( "title", "Game status: :bulletred: <b>{$status}</b> | Round: <b>{$round}</b> | Current turn: <b>{$turn}</b> | Player status: :bulletred: <b>Muted</b>", $gameroom );
		$dAmn->admin( "update privclass Hunter +msg", $gameroom );
		$dAmn->say( "$from: Roles assigned, the game will now begin. <i>{$tr}sunset</i>.", $c );
	break;
	case "end":
		if( $config->df['werewolf']['roles'][strtolower($from)] != "gamemaster" ) {
			$power = $dAmn->room[strtolower( $c )]->getHierarchy( TRUE );
			foreach( $power as $num => $vote ){
				if( $num == 75 ){
					$config->df['werewolf']['canend'] = array_keys( $vote );
				}
				if( $num < 50 ){
					unset( $config->df['werewolf']['canend'][$num] );
				} 
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			}
			foreach($config->df['werewolf']['canend'] as $minge => $ending){
				if(strtolower($ending) == strtolower($from)){
					$willend = TRUE;
				}
			}
		}
		if( $config->df['werewolf']['gamemaster'] == strtolower( $from ) || $user->has( $from, 75 ) || $willend ) {
			end_game( );
		}
		$dAmn->set( "title", "Game status: :bulletgreen: <b>Open</b> (join by typing <b>{$tr}play</b>)", $gameroom );
	break;
	case "sunset":														// Our switch for the fun to begin.
		if( strtolower( $c ) !== $gameroom ) {
			 return $dAmn->say( "$from: This command is part of Werewolf and can only be used in the game room, or back room for the game. Gameroom: {$gameroom}. Backroom: {$backroom}", $c );
		}
		if( strtolower( $from ) !== $config->df['werewolf']['gamemaster'] ) {
			return $dAmn->say( "$from: This command is for the GameMaster only.", $c );
		}
		if( isset( $config->df['werewolf']['confirm'] ) ) {
			return $dAmn->say( "$from: There are still roles that need to be confirmed before we can continue.", $c );
		}
		if( $config->df['werewolf']['day'] == "Night" ) {
			return $dAmn->say( "$from: The sun has already set.", $c );
		}
		if( $config->df['werewolf']['roles'][strtolower( $from )] == "gamemaster" ){
			$config->df['werewolf']['muted']      = TRUE;
			$config->df['werewolf']['oracleview'] = TRUE;
			$config->df['werewolf']['usedefend']  = TRUE;				// This one is for the defender AND harlot. Their commands will turn it off. 
			$config->df['werewolf']['day']        = "Night";
			$config->df['werewolf']['changed']    = FALSE;
			$config->df['werewolf']['wolfvote']   = 0;					// Reset the wolf votes.
			$config->df['werewolf']['round']++;
			$dAmn->admin( "update privclass Players -msg", $gameroom );
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			$dAmn->set( "title", "Game status: :bulletred: <b>Night</b> | Player status: :bulletred: <b>Muted</b>", $gameroom );
			$dAmn->say( "The sun sets in the world of Werewolf and the townies go to their nightly slumber.", $gameroom );
		}
	break;
	case "setoracle":													// We want to allow the GM to manually allow special players to repeat their turn, at their discretion. 
		if( $config->df['werewolf']['roles'][strtolower( $from )] !== "gamemaster" ) {
			return $dAmn->say( "$from: Only the Game Master may allow the oracle another view.", $c );
		}
		$config->df['werewolf']['oracleview'] = TRUE;
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->say( "$from: Oracle set.", $backroom );
	break;
	case "setwitch":
		if( $config->df['werewolf']['roles'][strtolower( $from )] !== "gamemaster" ) {
			return $dAmn->say( "$from: Only the Game Master may allow the oracle another view.", $c );
		}
		$config->df['werewolf']['witchsave'] = TRUE;
		$config->df['werewolf']['witchkill'] = TRUE;
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->say( "$from: Witch potions set.", $backroom );
	break;
	case "backroom":
		switch( $args[1] ) {
			case "set":
				if( empty( $args[2] ) ) {
					return $dAmn->say( "$from: I need a room to set the back room to. {$tr}backroom set [#room].", $c );
				}
				if( isset( $config->df['werewolf']['backroom'] ) ) {
					return $dAmn->say( "$from: The backroom has already been set. <i>{$tr}backroom clear</i> to unset it.", $c );
				}
				$config->df['werewolf']['backroom'] = strtolower( rChatName( $args[2] ) );
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
				$dAmn->say( "$from: The backroom for Werewolf is now " . rChatName( $args[2] ) .".", $c );
			break;
			case "clear":
				if( !isset( $config->df['werewolf']['backroom'] ) ) {
					return $dAmn->say( "$from: There is no back room set. <i>{$tr}backroom set [#room]</i> to set one.", $c );
				} 
				unset( $config->df['werewolf']['backroom'] );
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
				$dAmn->say( "$from: Back room cleared.", $c );
			break;
			default:
				$dAmn->say( "$from: This command sets the backroom for the \"Werewolf\" game. ", $c );
				if( isset( $config->df['werewolf']['backroom'] ) ) {
					$dAmn->say( "$from: The current backroom is {$config->df['werewolf']['backroom']}. <i>{$tr}backroom clear</i> to change it.", $c );
				} else {
					$dAmn->say( "$from: There is no backroom set. <i>{$tr}backroom set [#room]</i> to set one.", $c );
				}
			break;
		}
	break;
	case "gameroom":
		switch( $args[1] ) {
			case "set":
				if( empty( $args[2] ) ) {
					return $dAmn->say( "$from: I need a room to set the game room to. {$tr}gameroom set [#room].", $c );
				}
				if( isset( $config->df['werewolf']['gameroom'] ) ) {
					return $dAmn->say( "$from: The gameroom has already been set. <i>{$tr}gameroom clear</i> to unset it.", $c );
				}
				$config->df['werewolf']['gameroom'] = strtolower( rChatName( $args[2] ) );
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
				$dAmn->say( "$from: The gameroom for Werewolf is now " . rChatName( $args[2] ) .".", $c );
			break;
			case "clear":
				if( !isset( $config->df['werewolf']['gameroom'] ) ) {
					return $dAmn->say( "$from: There is no game room set. <i>{$tr}gameroom set [#room]</i> to set one.", $c );
				} 
				unset( $config->df['werewolf']['backroom'] );
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
				$dAmn->say( "$from: Game room cleared.", $c );
			break;
			default:
				$dAmn->say( "$from: This command sets the gameroom for the \"Werewolf\" game. ", $c );
				if( isset( $config->df['werewolf']['gameroom'] ) ) {
					$dAmn->say( "$from: The current game room is {$config->df['werewolf']['gameroom']}. <i>{$tr}gameroom clear</i> to change it.", $c );
				} else {
					$dAmn->say( "$from: There is no game room set. <i>{$tr}gameroom set [#room]</i> to set one.", $c );
				}
			break;
		}
	break;
	case "role":
		if( strtolower( $from ) != $config->df['werewolf']['gamemaster']  ) {
			return $dAmn->say( "$from: Only the GameMaster may assign, or change, roles.", $c );
		}
		if( empty( $args[1] ) || empty( $args[2] ) ) {
			return $dAmn->say( "$from: See {$tr}role ? for correct usage.", $c ); 
		}
		if( !isset( $config->df['werewolf']['players'][strtolower( $args[1] )] ) ){
			return $dAmn->say( "$from: You may only assign roles to active players.", $c );
		}
		if( !isset( $config->df['werewolf']['notassigned'][strtolower( $args[1] )] ) ) {
			return $dAmn->say( "$from: {$args[1]} has already been assigned.", $c );
		}
		$possible = array( 'gamemaster', 'werewolf', 'townie', 'witch', 'oracle', 'hunter', 'cupid', 'defender', 'harlot', 'jester', 'vidiot', );
		if( !in_array( strtolower( $args[2] ), $possible ) ) {
			return $dAmn->say("$from: {$args[2]} is not a currently used role.", $c );
		}
		$special = array( 'gamemaster', 'witch', 'oracle', 'hunter', 'cupid', 'defender', 'harlot', 'jester', 'vidiot', );
		if( in_array( strtolower( $args[2] ), $special ) && isset( $config->df['werewolf'][strtolower( $args[2] )] ) ){
			return $dAmn->say( "$from: Someone is already assigned $args[2]", $c );
		}
		if( ( strtolower( $args[2] ) == "harlot" && isset( $config->df['werewolf']['defender'] ) ) || ( strtolower( $args[2] ) == "defender" && isset( $config->df['werewolf']['harlot'] ) ) ){
			return $dAmn->say( "$from: You cannot have both the defender and harlot active in a single game.", $c );
		}
		if( strtolower( $args[2] ) == 'werewolf' ) {
			$config->df['werewolf']['roles'][strtolower( $args[1] )] = 'werewolf';
			$config->df['werewolf']['wolf'][strtolower( $args[1] )]  = $args[1];	// Backup setting.
			$config->df['werewolf']['wolves']++;
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			$dAmn->say( "$from: $args[1] is now a werewolf.", $c );
		}
		if( in_array( strtolower( $args[2] ), $special ) ){
			$config->df['werewolf']['roles'][strtolower( $args[1] )] = strtolower( $args[2] );
			$config->df['werewolf'][strtolower( $args[2] )] = strtolower( $args[1] );
			$config->df['werewolf']['witchsave']  = TRUE;
			$config->df['werewolf']['witchkill']  = TRUE;
			$config->df['werewolf']['selfdefend'] = TRUE;
			$config->df['werewolf']['roleswap']   = TRUE;	
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			return $dAmn->say("$from: {$args[1]} is now the {$args[2]}.",$c);
		}
		if( strtolower( $args[2]) == "townie" ) {
			$config->df['werewolf']['roles'][strtolower( $args[1] )] = "townie";
			$config->df['werewolf']['townies'][strtolower( $args[1] )] = strtolower( $args[1] );
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			return $dAmn->say( "$from: {$args[1]} is now a townie.", $c );
		}
	break;
	case "xrole":
		if( empty( $config->df['werewolf']['roles'] ) )  {
			return $dAmn->say( "$from: No roles have been assigned, cannot proceed.", $c );
		}
		if( strtolower( $from ) != $config->df['werewolf']['gamemaster']  ) {
			return $dAmn->say( "$from: Only the GameMaster may assign, change, or remove roles.", $c );
		}
		if( isset( $config->df['werewolf']['roles'][strtolower( $args[1] )] ) ) {
			$role = $config->df['werewolf']['roles'][strtolower( $args[1] )];
			if( isset( $config->df['werewolf'][$role] ) && ( $role !== "townie"  || $role !== "werewolf" ) ) {
				unset( $config->df['werewolf'][$role] );
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
				if( $role == "gamemaster" ) {
					$dAmn->promote( $args[1], "Players", $gameroom );
					$dAmn->promote( $args[1], "Players", $backroom );
					return $dAmn->say( "We need a new GameMaster. Please use {$tr}gm to step into the role.", $c );
				}
				$dAmn->say( "$from: WARNING! There is no {$role} currently set.", $c );
			} elseif( isset( $config->df['werewolf'][$role] ) && $role == "townie" ) {
				unset( $config->df['werewolf']['townie'][strtolower( $args[1] )] );
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
				$dAmn->say( "$from: {$args[1]} removed.", $c );
			} elseif( isset( $config->df['werewolf']['wolf'][strtolower( $args[1] )] ) ) {
				$config->df['werewolf']['wolves']--;
				unset( $config->df['werewolf']['wolf'][strtolower( $args[1] )] );
				unset( $config->df['werewolf']['roles'][strtolower( $args[1] )] );
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] ); 
				$dAmn->say( "$from: You are now short one werewolf. {$args[1]} removed.", $c );
			}
		}
	break;
	case "sunrise":
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
		$config->df['werewolf']['wolfvote']   = 0;						// Reset the wolf votes.
		if( empty( $config->df['werewolf']['round'] ) ) {				// We need to have a game actually going, or this command shouldn't continue.
			return $dAmn->say( "$from: There isn't a game currently active.", $c );
		}																// We cannot allow anyone other than the GameMaster to use this.
		if( $config->df['werewolf']['roles'][strtolower( $from )] !== "gamemaster" ) {
			return $dAmn->say( "$from: Only the GameMaster may call upon {$tr}sunrise", $c );
		}
		if( isset( $config->df['werewolf']['antikill'] ) ) {			// Harlot is sleeping with a wolf.
			unset( $config->df['werewolf']['tokill'] );					// Their kill has been nullified at sunrise.
			unset( $config->df['werewolf']['killvote'] );
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		}
		if( isset( $config->df['werewolf']['tokill'] ) ) {			// The witch unsets the tokill, so we need to check that here.
			$death = $config->df['werewolf']['tokill'];				// $death is the person who has been selected by the wolves.
			unset( $config->df['werewolf']['tokill'] );
			unset( $config->df['werewolf']['killvote'] );
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			$dcount = 1;
			$say = $death . ", ";
		}
		if( isset( $config->df['werewolf']['wtodie'] ) ) {				// If the witch has a person they're killing, we need to set up our variables for that here.
			$wdeath = $config->df['werewolf']['wtodie'];
			$wc = $config->df['werewolf']['roles'][$wdeath];
			$wclass = $pclass[$wc];
			unset( $config->df['werewolf']['wtodie'] );
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			if( $wclass == "Harlot" ) {									// OH SHIT, YOU KILLED THE HARLOT;
				if( $config->df['werewolf']['todefend'] == $config->df['werewolf']['witch'] ) {
					$death3 = $config->df['werewolf']['witch'];
					$dcount++;
					$say .= $death3 . ", ";
				}
			}
			$dcount++;
			$say .= $wdeath . ", ";
		}
		if( isset( $config->df['werewolf']['defending'] ) ) {			// The harlot and defender both start here, this is the diverging point.
			if( $config->df['werewolf']['defending'] == $death ) {
				unset( $config->df['werewolf']['tokill'] );
				unset( $config->df['werewolf']['killvote'] );
				unset( $config->df['werewolf']['defending'] );
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] ); 
			}
		}
		if( isset( $death ) ) {											// We can't call upon variables that don't exist. Haha.
			$dclass = $pclass[$config->df['werewolf']['roles'][$death]];
		}
		if( in_array( $death, $config->df['werewolf']['lovers'] ) && in_array( $wdeath, $config->df['werewolf']['lovers'] ) ) {
			$ignore = TRUE;												// If by some chance, both lovers were selected to die, we don't need to do the following.
		}
		if( $ignore === FALSE ) { 
			if( in_array( $death, $config->df['werewolf']['lovers'] ) || in_array( $wdeath , $config->df['werewolf']['lovers'] ) || in_array( $death3, $config->df['werewolf']['lovers'] ) ) {
				foreach( $config->df['werewolf']['lovers'] as $lovers ) {
					if( $lovers !== $death || $lovers !== $wdeath || $lovers !== $death3 ) {
						$death2  = $lovers;
						$p2roll  = $config->df['werewolf']['roles'][$lovers];
						$p2class = $pclass[$p2roll];
						$say    .= $death2;
						$dcount++;
					} 
				}
				unset( $config->df['werewolf']['lovers'] );
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] ); 
			}
		}
		if( !empty( $dclass ) ) {
			if( $dclass == "Werewolves" ) {
				$config->df['werewolf']['wolves']--;
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] ); 
			} else {
				$config->df['werewolf']['tcount']--;
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			}
			unset( $config->df['werewolf']['roles'][$death] );
			$config->df['werewolf']['dead'][$death] = $death;
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			$dAmn->promote( $death, $dclass, $gameroom );
			$dAmn->promote( $death, "Dead" , $backroom );
			if( $dclass == "Hunter" ) {									// We must inform the hunter that they are able to take someone down with them.
				$dAmn->say( "{$death}: As the hunter, you are able to select someone to kill before completely dying. <i>{$tr}hunt [player]</i>.", $c );
			}
		}
		if( isset( $wclass ) ) {
			if( $wclass == "Werewolves" ) {
				$config->df['werewolf']['wolves']--;
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			}
			unset( $config->df['werewolf']['roles'][$wdeath] );
			$config->df['werewolf']['dead'][$wdeath] = $wdeath;
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			$dAmn->promote( $wdeath, $wclass, $gameroom );
			$dAmn->promote( $wdeath, "Dead" , $backroom );
			if( $wclass == "Hunter" ) {
				$dAmn->say( "{$wdeath}: As the hunter, you are able to select someone to kill before completely dying. <i>{$tr}hunt [player]</i>.", $c );
			}
		}
		if( isset( $death3 ) ) {
			$dAmn->promote( $death3, "Witch", $gameroom );
			$dAmn->promote( $death3, "Dead" , $backroom );
			$config->df['werewolf']['tcount']--;
			unset( $config->df['werewolf']['roles'][$death3] );
			$config->df['werewolf']['dead'][$death3] = $death3;
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );	
		}
		if( isset( $p2class ) ) {
			if( $p2class == "Werewolves" ) {
				$config->df['werewolf']['wolves']--;
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			} else {
				$config->df['werewolf']['tcount']--;
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			}
			$config->df['werewolf']['dead'][$death2] = $death2;
			unset( $config->df['werewolf']['roles'][$death2] );
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			$dAmn->promote( $death2, $p2class, $gameroom );
			$dAmn->promote( $death2, "Dead"  , $backroom );
			if( $p2class == "Hunter" ) {
				$dAmn->say( "{$death2}: As the hunter, you are able to select someone to kill before completely dying. <i>{$tr}hunt [player]</i>.", $c );
			}
		}
		if( $p2class == "VillageIdiot" || $pclass == "VillageIdiot" || $wclass == "VillageIdiot" ) {
			$dAmn->say( "And with the death of the Village Idiot, the game is over." , $c );
			return end_game( );
		}
		$dAmn->say( "And what a night it was. We had {$dcount} death(s), and they were {$say}. The townies awake from their slumber.", $c );
		$dAmn->admin( "update privclass Players +msg", $gameroom );
		if( $config->df['werewolf']['wolves'] === 0 && !isset( $config->df['werewolf']['lovers'] ) ) {
			$dAmn->say( "All the werewolves have been killed, and there are no lovers. With that, the game is over, and Townies have won.", $c );
			return end_game();
		}
		if( $config->df['werewolf']['tcount'] <= 1 && !isset( $config->df['werewolf']['lovers'] ) ) {
			$dAmn->say( "There is only one townie remaining, and no lovers. With that, the game is over, and Werewolves have won.", $c );
			return end_game();
		}
		$config->df['werewolf']['day'] = "Day";
		$turn = "Townies ( Lynching )";
		unset( $config->df['werewolf']['killvote'] );
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->set( "title", "Game status: :bulletred: <b>{$status}</b> | Time: <b>Day</b> | Player status: :bulletgreen: <b>Open</b>", $gameroom );
	break;
	case "lynch":														// Here's where we do our lynching before sunset. It will follow the same model as sunrise.
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
			return $dAmn->say( "$from: See <i>{$tr}lynch ?</i> for usage details.", $c );
		}
		if( empty( $config->df['werewolf']['round'] ) ) {				// We need to have a game actually going, or this command shouldn't continue.
			return $dAmn->say( "$from: There isn't a game currently active.", $c );
		}																// We cannot allow anyone other than the GameMaster to use this.
		if( $config->df['werewolf']['roles'][strtolower( $from )] !== "gamemaster" ) {
			return $dAmn->say( "$from: Only the GameMaster may call upon {$tr}lynch", $c );
		}
		if( !isset( $config->df['werewolf']['roles'][strtolower( $args[1] )] ) ) {
			return $dAmn->say( "$from: You can only lynch active players.", $c );
		}
		if( strtolower( $args[1] ) == $config->df['werewolf']['gamemaster'] ) {
			return $dAmn->say( "$from: You cannot kill the GameMaster", $c );
		}
		if( empty( $args[2] ) || ( $args[2] !== "confirm" && $args[2] !== "yes" ) ) {
			return $dAmn->say( "$from: Are you sure you want to lynch {$args[1]}, <i>{$tr}lynch {$args[1]} confirm/yes</i>.", $c );
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
		$config->df['werewolf']['dead'][$death] = $death;
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] ); 
		$dAmn->promote( $death, $dclass, $gameroom );
		$dAmn->promote( $death, "Dead" , $backroom );
		if( $dclass == "Hunter" ) {									// We must inform the hunter that they are able to take someone down with them.
			$dAmn->say( "{$death}: As the hunter, you are able to select someone to kill before completely dying. <i>{$tr}hunt [player]</i>.", $c );
		}
		if( !empty( $p2class ) ) {
			if( $p2class == "Werewolves" ) {
				$config->df['werewolf']['wolves']--;
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			} else {
				$config->df['werewolf']['tcount']--;
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			}
			unset( $config->df['werewolf']['roles'][$death2] );
			$config->df['werewolf']['dead'][$death2] = $death2;
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			$dAmn->promote( $death2, $p2class, $gameroom );
			$dAmn->promote( $death2, "Dead"  , $backroom );
			$config->df['werewolf']['tcount']--; 
			if( $p2class == "Hunter" ) {
				$dAmn->say( "{$death2}: As the hunter, you are able to select someone to kill before completely dying. <i>{$tr}hunt [player]</i>.", $c );
			}
		}
		if( $p2class == "VillageIdiot" || $pclass == "VillageIdiot" || $wclass == "VillageIdiot" ) {
			$dAmn->say( "And with the death of the Village Idiot, the game is over." , $c );
			return end_game( );
		}
		if( $config->df['werewolf']['wolves'] === 0 && !isset( $config->df['werewolf']['lovers'] ) ) {
			$dAmn->say( "All the werewolves have been killed, and there are no lovers. With that, the game is over, and Townies have won.", $c );
			return end_game();
		}
		if( $config->df['werewolf']['tcount'] <= 1 && !isset( $config->df['werewolf']['lovers'] ) ) {
			$dAmn->say( "There is only one townie remaining, and no lovers. With that, the game is over, and Werewolves have won.", $c );
			return end_game();
		}
	break;
}
?>			