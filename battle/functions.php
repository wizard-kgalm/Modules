<?php
	function lvl_up_calc( $expclass, $lvl, $exp = "" )								// Let's set up our level up monitor. 
	{																				// We'll be using floor so it lines up perfectly with the table on Bulbapedia.
		global $config;
		if( !empty( $exp ) )
		{
			$lvl = $lvl + 1;
		}
		switch( strtolower( $expclass ) )											// Here's where we'll separate it by the exp class.
		{
			case "erratic":															// Erratic operates on piece-wise functions.
				if( $lvl <= 50 )
				{																	// $nxtlvl is the value needed to reach the next level. This value will come in handy.
					if( !empty( $exp ) )
					{
						$nxtlvl = floor( ( pow( $lvl, 3 ) * ( 100 - $lvl ) ) / 50 ) - $exp;
					} else
					{
						$exp = floor( ( pow( $lvl, 3 ) * ( 100 - $lvl ) ) / 50 );
						return $exp;
					}
				} elseif( $lvl > 50 && $lvl <= 68 )
				{
					if( !empty( $exp ) )
					{
						$nxtlvl = floor( ( pow( $lvl, 3 ) * ( 150 - $lvl ) / 100 ) ) - $exp;
					} else
					{
						$exp = floor( ( pow( $lvl, 3 ) * ( 150 - $lvl ) / 100 ) );
						return $exp;
					}
				} elseif( $lvl > 68 && $lvl <= 98 )
				{
					if( !empty( $exp ) )
					{
						$nxtlvl = floor( ( pow( $lvl, 3 ) * ( ( 1911 - ( 10 * $lvl ) ) / 3 ) ) / 500 ) - $exp;
					} else
					{
						$exp = floor( ( pow( $lvl, 3 ) * ( ( 1911 - ( 10 * $lvl ) ) / 3 ) ) / 500 );
						return $exp;
					}
				} elseif( $lvl > 98 )
				{
					if( !empty( $exp ) )
					{
						$nxtlvl = floor( ( pow( $lvl, 3 ) * ( 160 - $lvl ) ) / 100 ) - $exp;
					} else
					{
						$exp = floor( ( pow( $lvl, 3 ) * ( 160 - $lvl ) ) / 100 );
						return $exp;
					}
				}
			break;
			case "fast":
				if( !empty( $exp ) )
				{
					$nxtlvl = floor( 4 * ( pow( $lvl, 3 ) / 5 ) ) - $exp;
				} else
				{
					$exp = floor( 4 * ( pow( $lvl, 3 ) / 5 ) );
					return $exp;
				}
			break;
			case "medium-fast":
				if( !empty( $exp ) )
				{
					$nxtlvl = floor( pow( $lvl, 3 ) ) - $exp;
				} else
				{
					$exp = floor ( pow( $lvl, 3 ) );
					return $exp;
				}
			break;
			case "medium-slow":
				if( !empty( $exp ) )
				{
					$nxtlvl = floor( ( 6 / 5 * pow( $lvl, 3 ) ) - ( 15 * pow( $lvl, 2 ) ) + 100 * $lvl - 140 ) - $exp;
				} else
				{
					$exp = floor( ( 6 / 5 * pow( $lvl, 3 ) ) - ( 15 * pow( $lvl, 2 ) ) + 100 * $lvl - 140 );
					return $exp;
				}
			break;
			case "slow":
				if( !empty( $exp ) )
				{
					$nxtlvl = floor( 5 * ( pow( $lvl, 3 ) / 4 ) ) - $exp;
				} else
				{
					$exp = floor( 5 * ( pow( $lvl, 3 ) / 4 ) );
					return $exp;
				}
			break;
			case "fluctuating":
				if( $lvl <= 15 )
				{
					if( !empty( $exp ) )
					{
						$nxtlvl = floor(  pow( $lvl, 3 ) * ( ( ( ( $lvl + 1 )  / 3 ) + 24 ) / 50 ) ) - $exp;
					} else
					{	
						$exp = floor( pow( $lvl, 3 ) * ( ( ( ( $lvl + 1 ) / 3 ) + 24 ) / 50 ) );
						return $exp;
					}
				} elseif( $lvl > 15 && $lvl <= 36 )
				{
					if( !empty( $exp ) )
					{
						$nxtlvl = floor( pow( $lvl , 3 ) * ( ( $lvl + 14 ) / 50 ) ) - $exp;
					} else
					{
						$exp = floor( pow( $lvl, 3 ) * ( ( $lvl + 14 ) / 50 ) );
						return $exp;
					}
				} elseif( $lvl > 36 )
				{
					if( !empty( $exp ) )
					{
						$nxtlvl = floor( pow( $lvl, 3 ) * ( ( ( $lvl / 2 ) + 32 ) / 50 ) ) - $exp;
					} else
					{
						$exp = floor( pow( $lvl, 3 ) * ( ( ( $lvl / 2 ) + 32 ) / 50 ) );
						return $exp;
					}
				}
			break;
		}
		return $nxtlvl;																// Here's where we return the value to whatever called upon this function.
	}
	
	function exp_gain ( $pokemon, $player, $expclass, $lvl, $exp, $expgain )					// This will be where we figure out if we leveled up or not.
	{
		global $config;
		if( empty( $pokemon ) || empty( $lvl ) || empty( $exp ) )
		{
			return FALSE;
		}
		$nxtlvl = lvl_up_calc( $expclass, $lvl, $exp );
		if( ( $nxtlvl - $expgain ) <= 0 )											// We've leveled up!
		{
			$expleft = $expgain - $nxtlvl;
			$lvl++;
			level_up( $pokemon, $player, $lvl, $exp );								// Will likely need reworking. I don't even know, I should combine these.
			calc_stats( $pokemon, $player, $lvl );
			$nexp = $exp + $nxtlvl;
			$nxtlvl2 = lvl_up_calc( $expclass, $lvl, $nexp );
			if( ( $nxtlvl2 - $exp ) >= 0 )
			{
				exp_gain( $expclass, $lvl++, $nexp, $expleft);
			}
		} else
		{
			$exp = $exp + $expgain; 
			$tonxtlvl = $nxtlvl - $expgain;
		}
		$config->df['pokemon'][$player]['party'][$pokemon]['EXP'] = $exp;
		$config->df['pokemon'][$player]['party'][$pokemon]['LVL'] = $lvl;
		$config->save_config( "./config/pokemon.df", $config->df['pokemon'] );
	}
	
	function level_up ( $pokemon, $player, $lvl, $exp )
	{
		global $config;
		if( empty( $pokemon ) || empty( $player ) )
		{
			return FALSE;
		}
		if( isset( $config->df['pokedex'] ) )
		{
			if( !isset( $config->df['pokedex'][strtolower( $pokemon )] ) )			// Lol.
			{
				return FALSE;
			}
			$pkmn = $config->df['pokedex'][strtolower( $pokemon )];
			foreach( $pkmn['Learned'] as $move => $level )
			{
				if( $lvl == $level )
				{
					$config->df['pktemp']['lrnmove'][$player][$pokemon] = $move;	// I'll worry about tying this in with the function.
				}
			}
			if( is_array( $pkmn['Evolve'] ) )
			{
				if( $pkmn['Evolve']['Level'] >= $lvl )
				{
					$config->df['pktemp']['evolvelist'][$player] = $pokemon;
				}
			}
			$config->save_config( "./config/pktemp.df", $config->df['pktemp'] );
		}
	}
	
	function calc_stats ( $pokemon, $player, $lvl )
	{
		global $config;
		if( !file_exists( "./config/pokedex.df" ) )
		{
			create_pokedex();
		}
		$pkmn = $config->df['pokemon'][strtolower( $player )]['party'][$pokemon];	// EVs is the Effort Values gained from battling. These will increase stats.
		$hpiv = $pkmn['IVs']['hpiv'];												// Need to grab our HP Individual Value 
		$hpev = $pkmn['EVs']['hpev'];												// And our HP effort value. Generated by defeating certain pokemon. 
		$bHP  = $config->df['pokedex'][strtolower( $pokemon )]['Stats']['HP'];		// We need our base HP ($bHP) for the calculator. 
		$HP   = floor( ( ( $hpiv + ( 2 * $bHP ) + ( $hpev / 4 ) + 100 ) * $lvl ) / 100 ) + 10;
		$config->df['pokemon'][strtolower( $player )]['party'][$pokemon]['Stats']['HP'] = $HP;	// We have finished calculating HP. It's different from the others.
		$config->df['pokemon'][strtolower( $player )]['party'][$pokemon]['Info']['Current']['Max HP']	= $HP;
		$config->df['pokemon'][strtolower( $player )]['party'][$pokemon]['Info']['Current']['HP']		= $HP;
		$ativ = $pkmn['IVs']['attiv'];											// .. Attack info
		$atev = $pkmn['EVs']['attev'];
		$deiv = $pkmn['IVs']['defiv'];											// .. Defense info
		$deev = $pkmn['EVs']['defev'];
		$spaiv= $pkmn['IVs']['spaiv'];											// .. Special Attack info
		$spaev= $pkmn['EV']['spaev'];
		$spdiv= $pkmn['IVs']['spdiv'];											// .. Special Defense info
		$spdev= $pkmn['EVs']['spdev'];
		$speiv= $pkmn['IVs']['speediv'];										// .. And Speed info
		$speev= $pkmn['EVs']['speedev'];
		$bATT = $config->df['pokedex'][strtolower( $pokemon )]['Stats']['Attack'];
		$ATK  = floor( ( ( ( $ativ + ( 2 * $bATT ) + ( $atev / 4 ) ) * $lvl ) / 100 ) + 5 );
		$config->df['pokemon'][strtolower( $player )]['party'][$pokemon]['Stats']['Attack'] = $ATK;
		$bDEF = $config->df['pokedex'][strtolower( $pokemon )]['Stats']['Defense'];
		$DEF  = floor( ( ( ( $deiv + ( 2 * $bDEF ) + ( $deev / 4 ) ) * $lvl ) / 100 ) + 5 );
		$config->df['pokemon'][strtolower( $player )]['party'][$pokemon]['Stats']['Defense'] = $DEF;
		$bSPA = $config->df['pokedex'][strtolower( $pokemon )]['Stats']['Special Attack'];
		$SPA  = floor( ( ( ( $spaiv + ( 2 * $bSPA ) + ( $spaev / 4 ) ) * $lvl ) / 100 ) + 5 );
		$config->df['pokemon'][strtolower( $player )]['party'][$pokemon]['Stats']['Special Attack'] = $SPA;
		$bSPD = $config->df['pokedex'][strtolower( $pokemon )]['Stats']['Special Defense'];
		$SPD  = floor( ( ( ( $spdiv + ( 2 * $bSPD ) + ( $spdev / 4 ) ) * $lvl ) / 100 ) + 5 );
		$config->df['pokemon'][strtolower( $player )]['party'][$pokemon]['Stats']['Special Defense'] = $SPD;
		$bSPE = $config->df['pokedex'][strtolower( $pokemon )]['Stats']['Speed'];
		$SPE  = floor( ( ( ( $speiv + ( 2 * $bSPE ) + ( $speev / 4 ) ) * $lvl ) / 100 ) + 5 );
		$config->df['pokemon'][strtolower( $player )]['party'][$pokemon]['Stats']['Speed'] = $SPE;
		$config->save_config( "./config/pokemon.df", $config->df['pokemon'] );
	}
	
	function generate_pokemon ( $pokemon, $lvl )									// $lvl will typically be determined by the area, or for starters, will be 5.
	{
		global $config;
		if( !file_exists( "./config/pokedex.df" ) )									// Gotta have your pokedex ready as well. 
		{
			create_pokedex();
		}
		if( !file_exists( "./config/pokemoves.df" ) )								// Seems like a good time to check for this.
		{
			move_list();
		}
		if( !isset( $config->df['pokedex'][strtolower( $pokemon )] ) )				// OOPS! Either we done goof'd or the function was called upon by someone externally.
		{
			return FALSE;
		}																			// HitPoints IV, Defense, Special Attack, Special Defense, and Speed Indiv. Values.
		$pokemonthings = array( );
		$pokemonthings['level'] = $lvl;
		$exp 	= lvl_up_calc( $config->df['pokedex'][strtolower( $pokemon )]['EXP'], $lvl );
		$tonxt	= lvl_up_calc( $config->df['pokedex'][strtolower( $pokemon )]['EXP'], $lvl, $exp );
		$o = 0;
		$i = 0;
		foreach( $config->df['pokedex'][strtolower( $pokemon )]['Learned'] as $move => $atlvl )
		{
			if( $lvl >= $atlvl )
			{
				$pokemonthings['moveset'][strtolower( $move )]['PP'] = array(
					"Current"	=>	$config->df['pokemoves']['gen1'][strtolower( $move )]['pp'],
					"Max"		=>	$config->df['pokemoves']['gen1'][strtolower( $move )]['pp'],
				);
				$oname[$o] = $move;
				$o++;
				if( count( $pokemonthings['moveset'] ) > 4 )
				{
					unset( $pokemonthings['moveset'][strtolower( $oname[$i] )] );
					echo "{$oname[$i]}\n";
					$i++;
				}
			}
		}
		foreach( $config->df['pokedex'][strtolower( $pokemon )]['Stats'] as $stat => $quant )
		{
			$iv = mt_rand( 0, 31 );
			$ev = 0;
			if( $stat == "HP" )
			{
				$gen[$stat] = floor( ( ( $iv + ( 2 * $quant ) + ( $ev / 4 ) + 100 ) * $lvl ) / 100 ) + 10;
				$pokemonthings['IVs']['hpiv']	= $iv;
				$pokemonthings['Stats']['HP']	= $gen[$stat];
				$pokemonthings['Info']['Current']	=	array(
					"HP"			=>	$gen[$stat],
					"Max HP"		=>	$gen[$stat],
					"EXP"			=>	$exp,
					"Next Level"	=>	$tonxt,
				);
			} else
			{
				if( $stat == "Special Attack" )
				{
					$pokemonthings['IVs']['spaiv']   = $iv;
				} elseif( $stat == "Special Defense" )
				{
					$pokemonthings['IVs']['spdiv']   = $iv;
				} elseif( $stat == "Speed" )
				{
					$pokemonthings['IVs']['speediv'] = $iv;
				} else
				{
					$ivs = substr( $stat, 0, 3 ) . "iv";
					$pokemonthings['IVs'][$ivs]		 = $iv;
				}
				$gen[$stat] = floor( ( ( ( $iv + ( 2 * $quant ) + ( $ev / 4 ) ) * $lvl ) / 100 ) + 5 ); 
				$pokemonthings['Stats'][$stat]	= $gen[$stat];
			}
		}
		return $pokemonthings;
	}
	
	function damage_calc ( $move, $attacker, $pokemon, $defender, $target ) 			// We need the move, the user, the pokemon using the attack, and the target.
	{
		global $config;
		if( !isset( $config->df['pokemoves']['gen1'][strtolower( $move )] ) )
		{
			return FALSE;
		}
		$rand = mt_rand( 0.85, 1 );
		$mvtp = $config->df['pokemoves']['gen1'][strtolower( $move )]['type'];		// mvtp is the move type, like rock, ground.
		$stab = 1;
		if( in_array( $mvtp, $config->df['pokedex'][strtolower( $pokemon )]['Types'] ) )
		{
			$stab = 2;
		}
		$tt1 = $config->df['pokedex'][strtolower( $target )]['Types'][1];	// Gonna grab the target's types and run it through the attack's type.
		$tt2 = $config->df['pokedex'][strtolower( $target )]['Types'][2];
		if( in_array( $tt1, $config->df['poketypes'][$mvtp]['Offense']['None'] ) || in_array( $tt2, $config->df['poketypes'][$mvtp]['Offense']['None'] ) )
		{
			$type = 0;
		} elseif( in_array( $tt1, $config->df['poketypes'][$mvtp]['Offense']['Double'] ) )
		{
			if( in_array( $tt2, $config->df['poketypes'][$mvtp]['Offense']['Double'] ) )
			{
				$type = 4;														// If we have a hit on both types, we're at x4 damagio, buddy.
			} elseif( in_array( $tt2, $config->df['poketypes'][$mvtp]['Offense']['Half'] ) )
			{
				$type = 1;
			} else
			{
				$type = 2;
			}
		} elseif( in_array( $tt1, $config->df['poketypes'][$mvtp]['Offense']['Half'] ) )
		{
			if( in_array( $tt2, $config->df['poketypes'][$mvtp]['Offense']['Double'] ) )
			{
				$type = 1;
			} elseif( in_array( $tt2, $config->df['poketypes'][$mvtp]['Offense']['Half'] ) )
			{
				$type = 0.25;
			} else
			{
				$type = 0.50;
			}
		} elseif( !in_array( $tt1, $config->df['poketypes'][$mvtp]['Offense']['Half'] ) && !in_array( $tt1, $config->df['poketypes'][$mvtp]['Offense']['Double'] )  && !in_array( $tt1, $config->df['poketypes'][$mvtp]['Offense']['None'] ) )
		{
			if( in_array( $tt2, $config->df['poketypes'][$mvtp]['Offense']['Double'] ) )
			{
				$type = 2;
			} elseif( in_array( $tt2, $config->df['poketypes'][$mvtp]['Offense']['Half'] ) )
			{
				$type = 0.50;
			} elseif( in_array( $tt2, $config->df['poketypes'][$mvtp]['Offense']['None'] ) )
			{
				$type = 0;
			} else
			{
				$type = 1;
			}
		}
		$critclass = 1;
		if( $config->df['pokemoves']['gen1'][strtolower( $move )]['crit'] == "yes" )
		{
			$critclass = 3;
		}
		$other = 1;
		/*if( isset( $config->df['pokemon'][strtolower( $attacker )]['party'][strtolower( $pokemon )]['holding'] ) )
		{																			// Placeholder for held item calcs. Lots of variables to tie in here.
		} else
		{
			$other = 1;
		}*/
		$mdfr = floor( $stab * $type * $crit * $other * ( $rand ) );
		$damage = floor( ( ( 2 * $lvl + 10 ) / 250 ) * ( $atk / $dfs ) * $abase + 2 ) * $mdfr;
		return $damage; 
	}
		
	function attack ( $move, $attacker, $pokemon, $defender, $target )				// Here's where our details come in. If the attack lands, we'll calc damage.
	{
		$acc = $config->df['pokemoves']['gen1'][strtolower( $move )]['acc'];	// Pull up our accuracy.
		$ata = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Stats']['Accuracy'];	// Attacker's in-battle accuracy.
		$dee = $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Stats']['Evade'];		// Defender's in-battle evasion.
		if( $acc == 0 )
		{
			switch( $move )
			{
				case "guillotine":														// Will need to add something for substitutes.
				case "horn drill":
				case "fissure":
					$lvl = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Level'];
					$olvl = $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Level'];
					$acc2 = $lvl - $olvl + 30; 
					$hit2 = mt_rand( 1, 100 );
					if( $hit2 <= $acc2 )
					{
						if( isset( $config->df['pokebattle'][strtolower( $defender )]['Substitute'] ) )
						{
							$dmg = $config->df['pokebattle'][strtolower( $defender )]['Substitute'];	
							unset( $config->df['pokebattle'][strtolower( $defender )]['Substitute'] );	// Substitute has been broken.
							$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
							return $dmg;
						}
						$dmg = $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Current']['HP'];	// 1-Hit KO!
						return $dmg;
					}
				break;
				case "mist":
					if( isset( $config->df['pokebattle'][strtolower( $attacker )]['Effects']['Mist'] ) )
					{
						return FALSE;												// Can't enable it twice. lol
					}
					$config->df['pokebattle'][strtolower( $attacker )]['Effects']['Mist'] = TRUE;	// With this enabled, no stat changing moves.
					return TRUE;
				break;
				case "whirlwind":
				case "roar":
					if( $defender !== $target )
					{																// Making sure our defender isn't the pokemon, that would be a wild pokemon.
						if( count( $config->df['pokebattle'][strtolower( $defender )]['pokemon'] ) < 2 ) 
						{
							return FALSE;											// Can't blow away a trainer's only pokemon, he has none to switch. 
						} else
						{
							return TRUE;											// Make them switch to another pokemon. This will be done by the command.
						}
					} else
					{
						unset( $config->df['pokebattle'][strtolower( $defender )] );
						$config->df['pokebattle']['winner'] = $attacker;			// We'll add something to this as well.
						$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
						return TRUE;												// We'll actually have to come back to this and add things as I specify shit.
					}
				break;
				case "growth":
					$spatk 	= $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Special Attack'];
					$atk	= $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Attack'];
					if( $sptak == 6 )
					{
						return FALSE;												// Can't enhance the maxed stat. Haha
					} else
					{
						if( ( $spatk + 2 ) > 6 )
						{
							$spatk = 6;
						} else
						{
							$spatk = $spatk + 2;
						}
						if( ( $atk + 2 ) > 6 )
						{
							$atk = 6;
						} else
						{
							$atk = $atk + 2;
						}
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Special Attack'] 	= $spatk;
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Attack'] 			= $atk;
						$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
						return TRUE;
					}
				break;
				case "meditate":
				case "sharpen":
					$atk = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Attack'];
					if( $atk == 6 )
					{
						return FALSE;												// Can't raise the stage further than that.
					} else
					{
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Attack']++;
						$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
						return TRUE;
					}
				break;
				case "agility":
					$spd = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Speed'];
					if( $spd == 6 )
					{
						return FALSE;												// Can't raise this stat by more than 6 stages.
					} else
					{
						if( ( $spd + 2 ) > 6 )
						{
							$spd = 6;
						} else
						{
							$spd = $spd + 2;
						}
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Speed'] = $spd;
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					}
				break;
				case "teleport":
					if( $defender !== $target )
					{
						if( $attacker !== $pokemon )
						{
							return FALSE;
						} else 
						{
							unset( $config->df['pokebattle'][strtolower( $attacker )] );
							$config->df['pokebattle']['winner'] = strtolower( $defender );
							$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
							return TRUE;
						}
					} else
					{
						unset( $config->df['pokebattle'][strtolower( $attacker )] );
						$config->df['pokebattle']['winner'] = strtolower( $defender );
						$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
						return TRUE;
					}
				break;
				case "double team":
				case "minimize":
					$evade = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Evasion'];
					if( $evade == 6 )
					{
						return FALSE;
					} else
					{
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Evasion']++;
						$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
						return TRUE;
					}
				break;
				case "recover":
				case "soft-boiled":
					$maxhp 	= $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Current']['Max HP'];
					$hp		= $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Current']['HP'];
					if( $hp == $maxhp )
					{
						return FALSE;												// Can't heal at full health, haha.
					} else
					{
						if( $hp + floor( $maxhp / 2 ) > $maxhp )
						{
							$hp = $maxhp;
						} else
						{
							$hp = $hp + floor( $maxhp / 2 );
						}
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Current']['HP'] = $hp;
						$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
						return TRUE;
					}
				break;
				case "harden":
				case "withdraw":
				case "defense curl":
					$def = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Defense'];
					if( $def == 6 )
					{
						return FALSE;
					} else
					{
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Defense']++;
						$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
						return TRUE;
					}
				break;
				case "barrier":
				case "acid armor":
					$def = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Defense'];
					if( $def == 6 )
					{
						return FALSE;
					} else
					{	
						if( ( $def + 2 ) > 6 )
						{
							$def = 6;
						} else
						{
							$def = $def + 2;
						}
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Defense'] = $def;
						$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
						return TRUE;
					}
				break;
				case "light screen":
					if( isset( $config->df['pokebattle'][strtolower( $attacker )]['Special']['Light Screen'] ) )
					{
						return FALSE;												// Can't be used twice..
					}																// Also covers the entire time on attacker's side.
					$config->df['pokebattle'][strtolower( $attacker )]['Special']['Light Screen'] = 5; 
					$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
					return TRUE;
				break;
				case "haze":
					foreach( $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage'] as $stat => $stage )
					{
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage'][$stat] = 0;
					}
					foreach( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage'] as $stat => $stage )
					{
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage'][$stat] = 0;
					}
					$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
					return TRUE;
				break;
				case "reflect":
					if( isset( $config->df['pokebattle'][strtolower( $attacker )]['Special']['Reflect'] ) )
					{
						return FALSE;												// Can't be used twice..
					}																// Also covers the entire time on attacker's side.
					$config->df['pokebattle'][strtolower( $attacker )]['Special']['Reflect'] = 5; 
					$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
					return TRUE;
				break;
				case "focus energy":
					$crit = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Critical Hit'];
					if( $crit == 6 )
					{
						return FALSE;
					} else
					{	
						if( ( $crit + 2 ) > 6 )
						{
							$crit = 6;
						} else
						{
							$crit = $crit + 2;
						}
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Critical Hit'] = $crit;
						$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
						return TRUE;
					}
				break;
				case "metronome":
					$atk = array_rand( $config->df['pokemoves']['gen1'] );
					if( $atk == "metronome" || $atk == "struggle" )
					{
						return attack ( $move, $attacker, $pokemon, $defender, $target );	// Keep it going until it selects a move that isn't these.
					} else
					{
						return attack ( $atk, $attacker, $pokemon, $defender, $target );
					}
				break;
				case "mirror move":
					$atk = $config->df['pokebattle'][strtolower( $defender )]['Last Move'];
					if( empty( $atk ) )
					{
						return FALSE;
					} else
					{
						return attack ( $atk, $attacker, $pokemon, $defender, $target );
					}
				break;
				case "swift":
					$dmg = damage_calc( $move, $attacker, $pokemon, $defender, $target );	// Hits even on dig and fly.
					return $damage;
				break;
				case "amnesia":
					$spd = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Special Defense'];
					if( $spd == 6 )
					{
						return FALSE;
					} else
					{	
						if( ( $spd + 2 ) > 6 )
						{
							$spd = 6;
						} else
						{
							$spd = $spd + 2;
						}
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Special Defense'] = $spd;
						$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
						return TRUE;
					}
				break;
				case "transform":
					if( $target == "ditto" )
					{
						return FALSE;									// No transform loops, haha
					} else
					{
						$config->df['pokebattle'][strtolower( $attacker )] = $config->df['pokebattle'][strtolower( $defender )];
						$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );	// Replace Ditto or whoever is transforming with the target
						return TRUE;
					}
				break;
				case "splash":
					return TRUE;										// Does nothing, what is there to calculate? :')
				break;
				case "rest":
					$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Current']['HP'] = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Current']['Max HP'];
					$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Status'] = "Sleep";	// Overriding any status ailment.
					$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Rest'] = 3;	// Sleep timer. On 3, the move will be gone. 
					$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
				break;
				case "conversion":
					$type1 = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Types'][1];
					$type2 = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Types'][2];
					$otype1= $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Types'][1];
					$otype2= $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Types'][2];
					if( $type1 == $otype1 && $type2 == $otype2 )
					{
						return FALSE;												// Can't convert again when it already has.
					} else
					{
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Types'][1] = $otype1;
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Types'][2] = $otype2;
						$config->save_config( "./config/pokebattle.df", $config->df['pokebattle'] );
					}
				break;
				case "substitute":
					$maxhp 	= $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Current']['Max HP'];
					$hp 	= $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Current']['HP'];
					if( isset( $config->df['pokebattle'][strtolower( $attacker )]['Substitute'] ) )
					{
						return FALSE;												// Can't have multiple substitutes.
					} elseif( $hp - floor( $maxhp / 4 ) <= 0 )
					{
						return FALSE;												// Can't make one if your HP are too low.					
					} else
					{
						$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Current']['HP'] = $hp - floor( $maxhp / 4 );
						$config->df['pokebattle'][strtolower( $attacker )]['Substitute'] = floor( $maxhp / 4 );
						$config->save_config( './config/pokebattle.df', $config->df['pokebatle'] );
						return TRUE;												// Substitute will absorb the damage now! 
					}
				break;
			}
		}
		$hit = ( $acc * ( $ata / ( 1 - $dee ) ) );
		if( $hit < 100 )
		{
			$h2 = mt_rand( 1, 100 );									// Let's randomly draw a number. Will our attack land? We want a number less than $hit.
			if( $h2 <= $hit )
			{
				$hits = TRUE;
			} else
			{
				$hits = FALSE;
			}
		}
		if( $hits )
		{
			if( $config->df['pokemoves'][strtolower( $move )]['pwr'] == 0 )	// Our magnificent status moves. 
			{
				switch( $move )
				{
					case "sand attack":
					case "smoke screen":
					case "kinesis":
					case "flash":
						if( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage']['Accuracy'] == -6 )
						{
							return FALSE;
						}
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage']['Accuracy']--;
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
					case "tail whip":
					case "leer":
						if( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage']['Defense'] == -6 )
						{
							return FALSE;
						}
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage']['Defense']--;
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
					case "growl":
						if( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage']['Attack'] == -6 )
						{
							return FALSE;
						}
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage']['Attack']--;
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
					case "sing":
					case "sleep powder":
					case "hypnosis":
					case "lovely kiss":
					case "spore":
						if( isset( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Status'] ) )
						{
							return FALSE;
						}
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Status'] = "sleep";
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
					case "supersonic":
					case "confuse ray":
						if( isset( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Confusion'] ) )
						{
							return FALSE;
						}																						
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Confusion'] = TRUE;
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
					case "disable":
						if( isset( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Disabled'] ) )
						{
							return FALSE;								// Can't disable multiple moves.. to my knowledge? 
						}
						$disable = array();
						foreach( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['moveset']  as $moves => $details )
						{
							if( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['moveset'][$moves]['PP']['Current'] !== 0 )
							{
								$disable[$moves] = $moves;
							}
						}
						if( empty( $disable ) )
						{
							return FALSE;
						}
						$dmove = array_rand( $disable );
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Disabled'] =  $dmove;
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
					case "leech seed":
						if( isset( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Leech Seed'] ) )
						{
							return FALSE;
						}
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Leech Seed'] = TRUE;
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
					case "poison powder":
					case "poison gas":
						if( isset( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Status'] ) )
						{
							return FALSE;
						}
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Status'] = "poison";
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
					case "stun spore":
					case "thunderwave":
					case "glare":
						if( isset( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Status'] ) )
						{
							return FALSE;
						}
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Status'] = "paralyze";
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
					case "string shot":
						if( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage']['Speed'] == -6 )
						{
							return FALSE;
						}
						$spd = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Speed'];
						if( ( $spd - 2 ) < -6 )
						{
							$spd = -6;
						} else
						{
							$spd = $spd - 2;
						}
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage']['Speed'] = $spd;
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
					case "toxic":
						if( isset( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Status'] ) )
						{
							return FALSE;
						}
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Status'] = "poison2";
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
					case "mimic":
						$atk = $config->df['pokebattle'][strtolower( $defender )]['Last Move'];
						$atkinfo = $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['moveset'][$atk];
						if( empty( $atk ) )
						{
							return FALSE;
						} else
						{
							$config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['moveset'][$atk] = $atkinfo;
							unset( $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['moveset']['mimic'] );
							$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
							return TRUE;
						}
					break;
					case "screech":
						if( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage']['Defense'] == -6 )
						{
							return FALSE;
						}
						$def = $config->df['pokebattle'][strtolower( $attacker )][strtolower( $pokemon )]['Info']['Stage']['Defense'];
						if( ( $def - 2 ) < -6 )
						{
							$def = -6;
						} else
						{
							$def = $def - 2;
						}
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage']['Defense'] = $def;
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
					case "smokescreen":
						if( $config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage']['Accuracy'] == -6 )
						{
							return FALSE;
						}
						$config->df['pokebattle'][strtolower( $defender )][strtolower( $target )]['Info']['Stage']['Accuracy']--;
						$config->save_config( './config/pokebattle.df', $config->df['pokebattle'] );
						return TRUE;
					break;
				}
			}
		}
		
	
	function move_list ( )												// We're going to generate our move list (for generation I).
	{																	// Weird moves will need special addins for the function.
		global $config;
		$moves1	= 	array(
			"Pound"			=>	array(									// Move name,
				"type"	=>	"Normal",									// Move type, which will be used for type effectiveness,
				"cat"	=>	"Physical",									// Type of attack, which attack stat is used (Attack or Sp. Attack) and defense stat (Defense, Sp. Defense).
				"pp"	=>	35,											// Power points, pp, how many times it can be used,
				"pwr"	=>	40,											// Power, it's base damage,
				"acc"	=>	100,										// Accuracy, the move's base accuracy.
				"pri"	=>	0,											// Priority. Priority ignores the speed calcs.
				"multi"	=>	"no",										// Will it multihit? 
				"recoil"=>	"no",										// Will it cause Recoil?
				"crit"	=>	"no",
				"extra"	=>	"no",										// Is there any effects the move has?
			),
			"Karate Chop"	=>	array(
				"type"	=>	"Fighting",
				"cat"	=>	"Physical",
				"pp"	=>	25,
				"pwr"	=>	50,
				"acc"	=>	100,
				"crit"	=>	"yes",										// Does it have a higher Critical hit ratio?
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Double Slap"	=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	15,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi" =>	"yes",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Comet Punch"	=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	18,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi"	=>	"yes",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Mega Punch"	=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	80,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Pay Day"		=>	array(									// Note: Drops money for the winner. Will add something for that later. 
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	40,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Fire Punch"	=>	array(
				"type"	=>	"Fire",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	75,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"burn"	=>	10,										// 10% chance of burning.
				),
			),
			"Ice Punch"		=>	array(
				"type"	=>	"Ice",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	75,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"freeze"	=>	10,
				),
			),
			"Thunder Punch"	=>	array(
				"type"	=>	"Electric",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	75,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"paralyze"	=>	10,
				),
			),
			"Scratch"		=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	35,
				"pwr"	=>	40,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Vice Grip"		=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	30,
				"pwr"	=>	55,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Guillotine"	=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	5,
				"pwr"	=>	0,											// This move will kill in one hit if it lands.
				"acc"	=>	$lvl - $olvl + 30,							// This move depends on the level of the user and opponent for its chance of hitting.
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Razor Wind"	=>	array(									// This move takes two turns to execute.
				"type"	=>	"Normal",
				"cat"	=>	"Special",
				"pp"	=>	10,
				"pwr"	=>	80,
				"acc"	=>	100,
				"crit"	=>	"yes",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Swords Dance"	=>	array(									// This move affects the user.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Cut"			=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	30,
				"pwr"	=>	50,
				"acc"	=>	95,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Gust"			=>	array(
				"type"	=>	"Flying",
				"cat"	=>	"Special",									// This move will affect users in stage one of Fly.
				"pp"	=>	35,
				"pwr"	=>	40,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Wing Attack"	=>	array(
				"type"	=>	"Flying",
				"cat"	=>	"Physical",
				"pp"	=>	35,
				"pwr"	=>	60,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Whirlwind"		=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Status",									// Will end the battle when used against wild pokemon. Otherwise, switch pokemon.
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	0,
				"pri"	=>	-6,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Fly"			=>	array(									// Takes two turns, one is invulnerable to *most* attacks.
				"type"	=>	"Flying",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	90,
				"acc"	=>	95,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Bind"			=>	array(									// Trapping move. Goes for 4-5 turns doing 1/16th HP after original damage.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	15,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Slam"			=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	80,
				"acc"	=>	75,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Vine Whip"		=>	array(
				"type"	=>	"Grass",
				"cat"	=>	"Physical",
				"pp"	=>	25,
				"pwr"	=>	45,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Stomp"			=>	array(									// This move has a 30% flinch chance, and will never miss on minimized opponents.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	65,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Double Kick"	=>	array(									// Move always hits twice. (damage calculated independantly).
				"type"	=>	"Fighting",
				"cat"	=>	"Physical",
				"pp"	=>	30,
				"pwr"	=>	30,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"yes",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Mega Kick"		=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	5,
				"pwr"	=>	120,
				"acc"	=>	75,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Jump Kick"		=>	array(									// Will cause recoil of 1/2 the user's MAX HP if it misses.
				"type"	=>	"Fighting",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	100,
				"acc"	=>	95,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Rolling Kick"	=>	array(									// This move has 30% Flinch chance.
				"type"	=>	"Fighting",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	60,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Sand Attack"	=>	array(									// Lowers the accuracy of target. Works on all pokemon.
				"type"	=>	"Ground",
				"cat"	=>	"Status",
				"pp"	=>	15,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Headbutt"		=>	array(									// This move has a 30% flinch chance.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	70,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Horn Attack"	=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	25,
				"pwr"	=>	65,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Fury Attack"	=>	array(									// This move hits 2-5 times.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	15,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi"	=>	"yes",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Horn Drill"	=>	array(									// This move will take all current HP of target on connect.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	5,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Tackle"		=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	35,
				"pwr"	=>	50,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Body Slam"		=>	array(									// This move has a 30% chance of causing paralysis.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	85,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"paralyze"	=> 30,
				),
			),
			"Wrap"		=>	array(										// Trapping move, affects 4-5 turns, doing 1/16 max HP damage.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	15,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Take Down"		=>	array(									// This move's recoil damage is 1/4th the damage they did.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	90,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"yes",
				"extra"	=>	"no",
			),
			"Thrash"		=>	array(									// This move goes for 2 - 3 turns, confuses the user upon conclusion.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	120,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Double Edge"	=>	array(									// This move causes recoil of 1/3rd the damage done.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	120,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"yes",
				"extra"	=>	"no",
			),
			"Tail Whip"		=>	array(									// Reduces target's defense by one level. 
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Poison Sting"	=>	array(									// This move has a 30% Poison chance.
				"type"	=>	"Poison",
				"cat"	=>	"Physical",
				"pp"	=>	35,
				"pwr"	=>	15,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"poison"	=> 30,
				),
			),
			"Twineedle"		=>	array(									// This move hits twice, with two chances to poison.
				"type"	=>	"Bug",
				"cat"	=>	"Physical",
				"pp"	=>	35,
				"pwr"	=>	50,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"yes",
				"recoil"=>	"no",
				"extra"	=>	array(
					"poison" => 20,
				),
			),
			"Pin Missile"	=>	array(									// This move hits two to five times.
				"type"	=>	"Bug",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	25,
				"acc"	=>	95,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Leer"			=>	array(									// This move lowers the target defense by one level.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Bite"			=>	array(									// This move has a 10% flinch chance.
				"type"	=>	"Dark",
				"cat"	=>	"Physical",
				"pp"	=>	25,
				"pwr"	=>	60,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Growl"			=>	array(									// This move lowers the target attack by one level.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	40,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Roar"			=>	array(									// This move will make your pokemon (or the wild opponent, run.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	100,
				"pri"	=>	-6,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Sing"			=>	array(									// If it lands, will always put the target to sleep.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	15,
				"pwr"	=>	0,
				"acc"	=>	55,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"sleep"	=> 100,
				),
			),
			"Supersonic"	=>	array(									// This move causes confusion, if the target isn't already so.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	55,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"confuse"	=>	100,
				),
			),
			"Sonic Boom"	=>	array(									// This move always causes 20 HP of damage, bypassing damage calcs, but misses ghost types.
				"type"	=>	"Normal",
				"cat"	=>	"Special",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Disable"		=>	array(									// This move disables a move that may currently be used. ( has PP left ).
				"type"	=>	"Normal",									// This move lasts four to seven turns.
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Acid"			=>	array(									// This move has a 10% chance of lowering target's Special Defense by 1 stage.
				"type"	=>	"Poison",
				"cat"	=>	"Special",
				"pp"	=>	30,
				"pwr"	=>	40,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Ember"			=>	array(									// This move has a 10% chance of burning the target.
				"type"	=>	"Fire",
				"cat"	=>	"Special",
				"pp"	=>	25,
				"pwr"	=>	40,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"burn"	=>	10,
				),
			),
			"Flamethrower"	=>	array(									// This move has a 10% chance of burning the target.
				"type"	=>	"Fire",
				"cat"	=>	"Special",
				"pp"	=>	15,
				"pwr"	=>	90,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"burn"	=>	10,
				),
			),
			"Mist"			=>	array(									// This move prevents stat altering moves from affecting, for five turns.
				"type"	=>	"Ice",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Water Gun"		=>	array(
				"type"	=>	"Water",
				"cat"	=>	"Special",
				"pp"	=>	25,
				"pwr"	=>	40,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Hydro Pump"	=>	array(
				"type"	=>	"Water",
				"cat"	=>	"Special",
				"pp"	=>	5,
				"pwr"	=>	110,
				"acc"	=>	80,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Surf"			=>	array(
				"type"	=>	"Water",
				"cat"	=>	"Special",
				"pp"	=>	15,
				"pwr"	=>	90,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Ice Beam"		=>	array(									// This move has a 10% chance of freezing the target.
				"type"	=>	"Ice",
				"cat"	=>	"Special",
				"pp"	=>	10,
				"pwr"	=>	90,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"freeze"	=>	10,
				),
			),
			"Blizzard"		=>	array(									// This move has a 10% chance of freezing the target.
				"type"	=>	"Ice",
				"cat"	=>	"Special",
				"pp"	=>	5,
				"pwr"	=>	110,
				"acc"	=>	70,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"freeze"	=>	10,
				),
			),
			"Psybeam"		=>	array(									// This move has a 10% chance of confusing the target.
				"type"	=>	"Psychic",
				"cat"	=>	"Special",
				"pp"	=>	20,
				"pwr"	=>	65,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"confuse"	=>	10,
				),
			),
			"Bubble Beam"	=>	array(									// This move has a 10% chance of dropping target's speed by one level.
				"type"	=>	"Water",
				"cat"	=>	"Special",
				"pp"	=>	20,
				"pwr"	=>	65,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Aurora Beam"	=>	array(									// This move has a 10% chance of dropping target's attack by one level.
				"type"	=>	"Ice",
				"cat"	=>	"Special",
				"pp"	=>	20,
				"pwr"	=>	65,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Hyper Beam"	=>	array(									// This move requires two turns in most situations, with the second being recharge.
				"type"	=>	"Normal",
				"cat"	=>	"Special",
				"pp"	=>	5,
				"pwr"	=>	150,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Peck"			=>	array(
				"type"	=>	"Flying",
				"cat"	=>	"Physical",
				"pp"	=>	35,
				"pwr"	=>	35,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Drill Peck"	=>	array(
				"type"	=>	"Flying",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	80,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Submission"	=>	array(									// This move hits the user with 25% of the damage done in recoil.
				"type"	=>	"Fighting",
				"cat"	=>	"Physical",
				"pp"	=>	25,
				"pwr"	=>	80,
				"acc"	=>	80,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"yes",
				"extra"	=>	"no",
			),
			"Low Kick"		=>	array(									// This move's damage varies by the weight of the target (20 - 120).
				"type"	=>	"Fighting",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	0,											// Weight calculations to be added later.
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Counter"		=>	array(									// This move returns double the damage of a physical attack done to the user.
				"type"	=>	"Fighting",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	100,
				"pri"	=>	-5,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Seismic Toss"	=>	array(									// This move's power is equal to the level of the user, and receives no STAB.
				"type"	=>	"Fighting",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Strength"		=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	80,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Absorb"		=>	array(									// This move returns 50% of the damage dealt in HP to the user.
				"type"	=>	"Grass",
				"cat"	=>	"Special",
				"pp"	=>	25,
				"pwr"	=>	20,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Mega Drain"	=>	array(									// This move returns 50% of the damage dealt in HP to the user.
				"type"	=>	"Grass",
				"cat"	=>	"Special",
				"pp"	=>	15,
				"pwr"	=>	40,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Leech Seed"	=>	array(									// This move takes 1/8th the HP of the target and gives them to the user's current active pokemon.
				"type"	=>	"Grass",									// All grass type pokemon are immune to this move.
				"cat"	=>	"Special",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Growth"		=>	array(									// This move will increase both the attack and sp. attack of the user one stage.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Razor Leaf"	=>	array(									// This move has a high critical hit ratio.
				"type"	=>	"Grass",
				"cat"	=>	"Physical",
				"pp"	=>	25,
				"pwr"	=>	55,
				"acc"	=>	95,
				"crit"	=>	"yes",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Solar Beam"	=>	array(									// This move requires a waiting turn before the attack.
				"type"	=>	"Grass",
				"cat"	=>	"Special",
				"pp"	=>	10,
				"pwr"	=>	120,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Poison Powder"	=>	array(									// Grass types are immune to this move.
				"type"	=>	"Poison",
				"cat"	=>	"Special",
				"pp"	=>	35,
				"pwr"	=>	0,
				"acc"	=>	75,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"poison" => 100,
				),
			),
			"Stun Spore"	=>	array(									// Grass types are immune to this move.
				"type"	=>	"Grass",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	75,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"paralyze" => 100,
				),
			),
			"Sleep Powder"	=>	array(
				"type"	=>	"Grass",
				"cat"	=>	"Status",
				"pp"	=>	15,
				"pwr"	=>	0,
				"acc"	=>	75,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"sleep"	=>	100,
				),
			),
			"Petal Dance"	=>	array(									// This move will go for two to three turns, and confuse the user afterwards.
				"type"	=>	"Grass",
				"cat"	=>	"Special",
				"pp"	=>	10,
				"pwr"	=>	120,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Stringshot"	=>	array(									// This move lowers the speed of the target by two stages.
				"type"	=>	"Bug",
				"cat"	=>	"Status",
				"pp"	=>	40,
				"pwr"	=>	0,
				"acc"	=>	95,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Dragon Rage"	=>	array(									// This move always does 40HP of damage, regardless of stats.
				"type"	=>	"Dragon",
				"cat"	=>	"Special",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Firespin"		=>	array(									// This move traps the target, lasts for four to five turns taking 1/16th of the target's HP.
				"type"	=>	"Fire",
				"cat"	=>	"Special",
				"pp"	=>	15,
				"pwr"	=>	35,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Thunder Shock"	=>	array(
				"type"	=>	"Electric",
				"cat"	=>	"Special",
				"pp"	=>	30,
				"pwr"	=>	40,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"paralyze"	=> 10,
				),
			),
			"Thunderbolt"	=>	array(
				"type"	=>	"Electric",
				"cat"	=>	"Special",
				"pp"	=>	15,
				"pwr"	=>	90,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"paralyze"	=> 10,
				),
			),
			"Thunder Wave"	=>	array(									// This move will paralyze the target. Electric types are immune.
				"type"	=>	"Electric",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"paralyze"	=> 100,
				),
			),
			"Thunder"		=>	array(
				"type"	=>	"Electric",
				"cat"	=>	"Special",
				"pp"	=>	10,
				"pwr"	=>	110,
				"acc"	=>	70,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"paralyze"	=> 30,
				),
			),
			"Rock Throw"	=>	array(
				"type"	=>	"Rock",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	50,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Earthquake"	=>	array(									// This move affects users of dig by double.
				"type"	=>	"Ground",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	100,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Fissure"		=>	array(									// This move will have a one-hit kill.
				"type"	=>	"Ground",
				"cat"	=>	"Physical",
				"pp"	=>	5,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Dig"			=>	array(									// This move requires two turns to execute.
				"type"	=>	"Ground",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	80,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Toxic"			=>	array(									// This move badly poisons the target. It also never misses when a poison-type uses it.
				"type"	=>	"Poison",
				"cat"	=>	"Status",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"poison2"	=>	100,								// Poison2 will be badly poisoned, for the increasing damage algorithm holder.
				),
			),
			"Confusion"		=>	array(
				"type"	=>	"Psychic",
				"cat"	=>	"Special",
				"pp"	=>	25,
				"pwr"	=>	50, 
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"confuse"	=>	10,
				),
			),
			"Psychic"		=>	array(									// This move has a 10% chance of lowering Sp. Defense by one level.
				"type"	=>	"Psychic",
				"cat"	=>	"Special",
				"pp"	=>	10,
				"pwr"	=>	90,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Hypnosis"		=>	array(
				"type"	=>	"Psychic",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	60,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"sleep"	=>	100,
				),
			),
			"Meditate"		=>	array(									// This move raises the user's attack by one level.
				"type"	=>	"Psychic",
				"cat"	=>	"Status",
				"pp"	=>	40,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Agility"		=>	array(									// This move sharply raises the user's speed two levels.
				"type"	=>	"Psychic",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Quick Attack"	=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	30,
				"pwr"	=>	40,
				"acc"	=>	100,
				"pri"	=>	1,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Rage"			=>	array(									// This move gains attack bonus when the user is hit, as long as the move is used.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	20,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Teleport"		=>	array(									// This move only works on wild pokemon.
				"type"	=>	"Psychic",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Night Shade"	=>	array(									// This move will always do equal to the user's level in damage.
				"type"	=>	"Ghost",
				"cat"	=>	"Special",
				"pp"	=>	15,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Mimic"			=>	array(									// This move will copy the last used move by the target, unless the user already knows it.
				"type"	=>	"Normal",									// The move will revert back to mimic following a switch or battle ending.
				"cat"	=>	"Status",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Screech"		=>	array(									// This move will sharply lower the target's defense two levels.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	40,
				"pwr"	=>	0,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Double Team"	=>	array(									// This move raises the evasion of the user by one level.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	15,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Recover"		=>	array(									// This move recovers 50% of the user's HP. 
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Harden"		=>	array(									// This move increases the user's defense by one level.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Minimize"		=>	array(									// This move raises the user's evasiveness one level. 
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Smokescreen"	=>	array(									// This move reduces the target's accuracy one level.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Confuse Ray"	=>	array(									// This move confuses the victim for two to five turns. 
				"type"	=>	"Ghost",
				"cat"	=>	"Status",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"confuse"	=>	100,
				),
			),
			"Withdraw"		=>	array(									// This move raises the user's defense one level. 
				"type"	=>	"Water",
				"cat"	=>	"Status",
				"pp"	=>	40,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Defense Curl"	=>	array(									// This move raises the user's defense one level. 
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	40,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Barrier"		=>	array(									// This move raises the user's defense two levels. 
				"type"	=>	"Psychic",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Light Screen"	=>	array(									// This move cuts special move damage in half for five turns. 
				"type"	=>	"Psychic",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Haze"			=>	array(									// This move removes all stat changes to the pokemon on the field. 
				"type"	=>	"Ice",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Reflect"		=>	array(									// This move cuts physical move damage in half for five turns. 
				"type"	=>	"Psychic",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Focus Energy"	=>	array(									// This move increases the user's critical hit ratio two levels. 
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Bide"			=>	array(									// This move makes the user endure two rounds of damage, then returns double the damage.					 
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	100,
				"pri"	=>	1,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Metronome"		=>	array(									// This move will call up any move at random, with all regular effects. 
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Mirror Move"	=>	array(									// This move will copy the last move the opponent used. 
				"type"	=>	"Flying",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Self-Destruct"	=>	array(									// This move causes the user to faint. 
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	5,
				"pwr"	=>	200,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"yes",
				"extra"	=>	"no",
			),
			"Egg Bomb"		=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	100,
				"acc"	=>	75,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Lick"			=>	array(									// This move has a 30% chance of paralyzing targets.
				"type"	=>	"Ghost",
				"cat"	=>	"Physical",
				"pp"	=>	30,
				"pwr"	=>	20,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"paralyze"	=>	30,
				),
			),
			"Smog"			=>	array(									// This move has a 40% chance of poisoning the target.	
				"type"	=>	"Poison",
				"cat"	=>	"Special",
				"pp"	=>	20,
				"pwr"	=>	30,
				"acc"	=>	70,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"poison"	=>	40,
				),
			),
			"Sludge"		=>	array(									// This move has a 30% chance of poisoning the target.	
				"type"	=>	"Poison",
				"cat"	=>	"Special",
				"pp"	=>	20,
				"pwr"	=>	65,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"poison"	=>	30,
				),
			),
			"Bone Club"		=>	array(									// This move has a 10% flinch chance.
				"type"	=>	"Ground",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	65,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Fire Blast"	=>	array(									// This move has a 10% burn chance, down from 30.
				"type"	=>	"Fire",
				"cat"	=>	"Special",
				"pp"	=>	5,
				"pwr"	=>	110,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"burn"	=>	10,
				),
			),
			"Waterfall"		=>	array(									// This move has a 20% Flinch chance.
				"type"	=>	"Water",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	80,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Clamp"			=>	array(									// This move lasts four to five turns, and is trapping.
				"type"	=>	"Water",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	35,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Swift"			=>	array(									// This move never misses.
				"type"	=>	"Normal",
				"cat"	=>	"Special",
				"pp"	=>	20,
				"pwr"	=>	60,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Skull Bash"	=>	array(									// This move requires two turns to complete.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	130,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Spike Cannon"	=>	array(									// This move lands two to five times.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	20,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"yes",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Constrict"		=>	array(									// This move has a 10% chance of reducing speed.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	35,
				"pwr"	=>	10,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Amnesia"		=>	array(									// This move raises the user's Sp. Defense by two levels.
				"type"	=>	"Psychic",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Kinesis"		=>	array(									// This move lowers the target's accuracy one level.
				"type"	=>	"Psychic",
				"cat"	=>	"Status",
				"pp"	=>	15,
				"pwr"	=>	0,
				"acc"	=>	80,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Soft-Boiled"	=>	array(									// This move returns 50% HP to the user.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"High Jump Kick"=>	array(									// This move will take 50% HP in recoil if it misses.
				"type"	=>	"Fighting",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	130,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Glare"			=>	array(									// This move will paralyze the target.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"paralyze"	=>	100,
				),
			),
			"Soft-Boiled"	=>	array(									// This move returns 50% HP to the user.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Dream Eater"	=>	array(									// This move returns 50% damage in HP to the user, target must be sleeping.
				"type"	=>	"Psychic",
				"cat"	=>	"Special",
				"pp"	=>	15,
				"pwr"	=>	100,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Poison Gas"	=>	array(									// This move poisons the target.
				"type"	=>	"Poison",
				"cat"	=>	"Status",
				"pp"	=>	40,
				"pwr"	=>	0,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"paralyze"	=>	100,
				),
			),
			"Barrage"		=>	array(									// This move hits the target two to five times.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	15,
				"acc"	=>	85,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Leech Life"	=>	array(									// This move returns 50% of the damage in HP to the user.
				"type"	=>	"Bug",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	20,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Lovely Kiss"	=>	array(									// This move puts the target to sleep.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	75,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"sleep"	=>	100,
				),
			),
			"Sky Attack"	=>	array(									// This move takes two turns to execute, and has a 30% flinch opportunity.
				"type"	=>	"Flying",
				"cat"	=>	"Physical",
				"pp"	=>	5,
				"pwr"	=>	140,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Transform"		=>	array(									// This move changes the user into the target pokemon entirely.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Bubble"		=>	array(									// This move has a 10% chance to lower the speed by one level.
				"type"	=>	"Water",
				"cat"	=>	"Special",
				"pp"	=>	30,
				"pwr"	=>	40,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Dizzy Punch"	=>	array(									// This move has a 20% chance of confusing the target.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	70,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"confuse"	=>	20,
				),
			),
			"Spore"			=>	array(									// This move will put the opponent to sleep, sans grass types.
				"type"	=>	"Grass",
				"cat"	=>	"Status",
				"pp"	=>	15,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"sleep"	=>	100,
				),
			),
			"Flash"			=>	array(									// This move lowers to accuracy of the target by one level.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Psywave"		=>	array(
				"type"	=>	"Psychic",
				"cat"	=>	"Special",
				"pp"	=>	15,
				"pwr"	=>	0,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Splash"		=>	array(									// This move does absolutely nothing.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	40,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Acid Armor"	=>	array(									// This move raises the user's defense by two levels. 
				"type"	=>	"Poison",
				"cat"	=>	"Status",
				"pp"	=>	20,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Crabhammer"	=>	array(
				"type"	=>	"Water",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	100,
				"acc"	=>	90,
				"crit"	=>	"yes",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Explosion"		=>	array(									// This move will cause the user to faint.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	5,
				"pwr"	=>	250,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"yes",
				"extra"	=>	"no",
			),
			"Fury Swipes"	=>	array(									// This move hits two to five times.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	18,
				"acc"	=>	80,
				"crit"	=>	"no",
				"multi"	=>	"yes",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Bonemerang"	=>	array(									// This move will hit twice.
				"type"	=>	"Ground",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	50,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"yes",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Rest"			=>	array(									// This move causes the user to sleep two turns, wipes all status ailments, and restores HP.
				"type"	=>	"Psychic",
				"cat"	=>	"Status",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"sleep"	=>	100,
				),
			),
			"Rockslide"		=>	array(									// This move has a 30% flinch chance.
				"type"	=>	"Rock",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	75,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Hyperfang"		=>	array(									// This move has a 10% flinch chance. 
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	15,
				"pwr"	=>	80,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Sharpen"		=>	array(									// This move raises the user's attack by one level.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Conversion"	=>	array(									// This move changes the user's types into the target's. 
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	30,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Tri Attack"	=>	array(									// This move may burn, freeze, or paralyze the target. 
				"type"	=>	"Normal",
				"cat"	=>	"Special",
				"pp"	=>	10,
				"pwr"	=>	80,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	array(
					"burn"		=>	10,
					"freeze"	=>	10,
					"paralyze"	=>	10,
				),
			),
			"Super Fang"	=>	array(									// This move takes half the target's HP.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	90,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Slash"			=>	array(
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	20,
				"pwr"	=>	70,
				"acc"	=>	100,
				"crit"	=>	"yes",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Substitute"	=>	array(									// This move takes 25% of the user's HP and creates a decoy that absorbs damage.
				"type"	=>	"Normal",
				"cat"	=>	"Status",
				"pp"	=>	10,
				"pwr"	=>	0,
				"acc"	=>	0,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
			"Struggle"		=>	array(									// This move will be triggered automatically upon all moves having 0 PP.
				"type"	=>	"Normal",
				"cat"	=>	"Physical",
				"pp"	=>	0,
				"pwr"	=>	50,
				"acc"	=>	100,
				"crit"	=>	"no",
				"multi"	=>	"no",
				"recoil"=>	"no",
				"extra"	=>	"no",
			),
		);
		foreach( $moves1 as $name => $stats )
		{
			if( !isset( $stats['pri'] ) )
			{
				$stats['pri'] = 0;
			}
			$sname = array(
				"name"	=> $name,
			);
			$moves2[strtolower( $name )] = array_merge( $sname, $stats );
		}
		$config->df['pokemoves']['gen1'] = $moves2;
		$config->save_config( "./config/pokemoves.df", $config->df['pokemoves'] );
	}
	
	function create_pokedex ( ) 
	{
		global $config;
		$pokemon = array(
			"Bulbasaur"		=>	array(
				"Types"	=> array(
					1 => "grass",
					2 => "poison",
				),
				"Number"=> "1",
				"Moves"	=> array(
				),
				"Learned"	=>	array(												// Here's where our learned moves will be under.
				 // Move Name		  Level 				
					"Tackle"		=>	1,
					"Growl"			=>	1,
					"Leech Seed"	=>	7,
					"Vine Whip"		=>	13,
					"PoisonPowder"	=>	20,
					"Razor Leaf" 	=>	27,
					"Growth" 		=>	34,
					"Sleep Powder"	=>	41,
					"Solar Beam"	=>	48,
				),
				"EXP"	=> "medium-slow",											// Our EXP class will be used for Leveling up calculation.
				"BaseEXP"	=> 64,													// Our Base EXP given on defeat.
				"EV"	=>	array(													// Our Effort value yield on defeat.
					"Special Attack"	=>	1,
				),
				"Evolve"	=>	array(												// Our evolution stats. These will be checked upon leveling up.
					"Level" => 16,
					"Evolution" => "Ivysaur",										// When it evolves into this, we will recalculate our stats.
				),
				"Stats"	=> array(													// Our Stats will be based on Bulbapedia, Generation VI games. I will set a range for these.
					"HP"             => 45,
					"Attack"         => 49,											// As well as generate the amount gained on leveling up.
					"Defense"        => 49,
					"Special Attack" => 65,
					"Special Defense"=> 65,
					"Speed"          => 45,
				),
			),
			"Ivysaur"		=>	array(
				"Types"	=> array(
					1 => "grass",
					2 => "poison",
				),
				"Number"=> "2",
				"Moves" => array(
				),
				"Learned"	=>	array(												// Here's where our learned moves will be under.
					"Tackle"		=>	1,
					"Growl"			=>	1,
					"Leech Seed"	=>	1,
					"Leech Seed" 	=> 	7,
					"Vine Whip"	 	=> 	13,
					"PoisonPowder" 	=> 	22,
					"Razor Leaf"	=> 	30,
					"Growth" 		=> 	38,
					"Sleep Powder"	=> 	46,
					"Solar Beam" 	=> 	54,
				),
				"EXP"	=> "medium-slow",
				"BaseEXP"	=> 142,
				"EV"	=>	array(
					"Special Attack"	=>	1,
					"Special Defense"	=>	1,
				),
				"Evolve"	=>	array(
					"Level" => 32,
					"Evolution" => "venusaur",
				),
				"Stats"	=> array(													// We would expect the evolution's base stats to be higher.
					"HP"             => 60,
					"Attack"         => 62,											// With more stat increases.
					"Defense"        => 63,
					"Special Attack" => 80,
					"Special Defense"=> 80,
					"Speed"          => 60,
				),
			),
			"Venusaur"		=>	array(
				"Types"	=> array(
					1 => "grass",
					2 => "poison",
				),
				"Number"=> "3",
				"Moves" => array(													// Repeat of above.
					1 => "Tackle",
					2 => "Growl",
					3 => "Leech Seed",
					4 => "Vine Whip",
				),
				"Learned"	=>	array(												// Here's where our learned moves will be under.
					"Tackle"		=>	1,
					"Growl"			=>	1,
					"Leech Seed"	=>	1,
					"Vine Whip"		=>	1,
					"Leech Seed" 	=> 	7,
					"Vine Whip"	 	=> 	13,
					"PoisonPowder" 	=> 	22,
					"Razor Leaf" 	=> 	30,
					"Growth" 		=> 	43,
					"Sleep Powder" 	=> 	55,
					"Solar Beam" 	=> 	65,
				),
				"EXP"	=> "medium-slow",
				"BaseEXP"	=> 236,
				"EV"	=>	array(
					"Special Attack"	=>	2,
					"Special Defense"	=>	1,
				),
				"Evolve"	=>	"No",
				"Stats"	=> array(													// We would expect the evolution's base stats to be higher.
					"HP"             => 80,
					"Attack"         => 82,											// With more stat increases.
					"Defense"        => 83,
					"Special Attack" => 100,
					"Special Defense"=> 100,
					"Speed"          => 80,
				),
			),
			"Charmander"	=>	array(
				"Types"	=> array(
					1 => "fire",
					2 => "",
				),
				"Number"=> "4",
				"Moves"	=> array(
				),
				"Learned"	=>	array(
					"Scratch"		=>	1,
					"Growl"			=>	1,
					"Ember"		 	=> 	7,
					"Leer"	 		=> 	15,
					"Rage"	 		=> 	22,
					"Slash" 		=> 	30,
					"Flamethrower" 	=> 	38,
					"Firespin" 		=> 	46,
				),
				"EXP"	=> "medium-slow",
				"BaseEXP"	=> 62,
				"EV"	=>	array(
					"Speed"	=>	1,
				),
				"Evolve"	=>	array(
					"Level" => 16,
					"Evolution" => "charmeleon",
				),
				"Stats"	=> array(
					"HP"             => 39,
					"Attack"         => 52,													
					"Defense"        => 43,
					"Special Attack" => 60,
					"Special Defense"=> 50,
					"Speed"          => 65,
				),
			),
			"Charmeleon"	=>	array(
				"Types"	=> array(
					1 => "fire",
					2 => "",
				),
				"Number"=> "5",
				"Moves"	=> array(
				),
				"Learned"	=>	array(
					"Scratch"		=>	1,
					"Growl"			=>	1,
					"Ember"			=>	1,
					"Ember" 		=> 	9,
					"Leer"	 		=> 	15,
					"Rage" 			=> 	24,
					"Slash" 		=> 	33,
					"Flamethrower" 	=> 	42,
					"Firespin" 		=> 	56,
				),
				"EXP"	=> "medium-slow",
				"BaseEXP"	=> 142,
				"EV"	=>	array(
					"Speed"				=>	1,
					"Special Attack"	=>	1,
				),
				"Evolve"	=>	array(
					"Level" => 36,
					"Evolution" => "charizard",
				),
				"Stats"	=> array(
					"HP"             => 58,
					"Attack"         => 64,													
					"Defense"        => 58,
					"Special Attack" => 80,
					"Special Defense"=> 65,
					"Speed"          => 80,
				),
			),
			"Charizard"		=>	array(
				"Types"	=> array(
					1 => "fire",
					2 => "flying",
				),
				"Number"=> "6",
				"Moves"	=> array(
				),
				"Learned"	=>	array(
					"Scratch"		=>	1,
					"Growl"			=>	1,
					"Ember"			=>	1,
					"Leer"			=>	1,
					"Ember" 		=> 	9,
					"Leer"	 		=> 	15,
					"Rage" 			=> 	24,
					"Slash" 		=> 	36,
					"Flamethrower" 	=> 	46,
					"Firespin" 		=> 	55,
				),
				"EXP"	=> "Medium-Slow",
				"BaseEXP"	=> 240,
				"EV"	=>	array(
					"Special Attack"	=>	3,
				),
				"Evolve"	=>	"No",
				"Stats"	=> array(
					"HP"             => 78,
					"Attack"         => 84,													
					"Defense"        => 78,
					"Special Attack" => 109,
					"Special Defense"=> 85,
					"Speed"          => 100,
				),
			),
			"Squirtle"		=>	array(
				"Types"	=> array(
					1 => "water",
					2 => "",
				),
				"Number"=> "7",
				"Moves"	=> array(
				),
				"Learned"	=>	array(
					"Tackle"		=>	1,
					"Tail Whip"		=>	1,
					"Bubble" 		=> 	8,
					"Water Gun"	 	=> 	15,
					"Bite" 			=> 	22,
					"Withdraw" 		=> 	28,
					"Skull Bash" 	=> 	35,
					"Hydro Pump" 	=> 	42,
				),
				"EXP"	=> "medium-slow",
				"BaseEXP"	=> 63,
				"EV"	=>	array(
					"Defense"	=>	1,
				),
				"Evolve"	=>	array(
					"Level" => 16,
					"Evolution" => "wartortle",
				),
				"Stats"	=> array(
					"HP"             => 44,
					"Attack"         => 48,													
					"Defense"        => 65,
					"Special Attack" => 50,
					"Special Defense"=> 64,
					"Speed"          => 43,
				),
			),
			"Wartortle"		=>	array(
				"Types"	=> array(
					1 => "water",
					2 => "",
				),
				"Number"=> "8",
				"Moves"	=> array(
				),
				"Learned"	=>	array(
					"Tackle"		=>	1,
					"Tail Whip"		=>	1,
					"Bubble"		=>	1,
					"Bubble" 		=> 	8,
					"Water Gun"	 	=> 	15,
					"Bite" 			=> 	24,
					"Withdraw" 		=> 	31,
					"Skull Bash" 	=> 	39,
					"Hydro Pump" 	=> 	47,
				),
				"EXP"	=> "medium-slow",
				"BaseEXP"	=> 142,
				"EV"	=>	array(
					"Defense"			=>	1,
					"Special Defense"	=>	1,
				),
				"Evolve"	=>	array(
					"Level" => 36,
					"Evolution" => "blastoise",
				),
				"Stats"	=> array(
					"HP"             => 59,
					"Attack"         => 63,													
					"Defense"        => 80,
					"Special Attack" => 65,
					"Special Defense"=> 80,
					"Speed"          => 58,
				),
			),
			"Blastoise"		=>	array(
				"Types"	=> array(
					1 => "water",
					2 => "",
				),
				"Number"=> "9",
				"Moves"	=> array(
				),
				"Learned"	=>	array(
					"Tackle"		=>	1,
					"Tail Whip"		=>	1,
					"Bubble"		=>	1,
					"Water Gun"		=>	1,
					"Bubble" 		=> 	8,
					"Water Gun"	 	=> 	15,
					"Bite" 			=> 	24,
					"Withdraw" 		=> 	31,
					"Skull Bash" 	=> 	42,
					"Hydro Pump" 	=> 	52,
				),
				"EXP"	=> "medium-slow",
				"BaseEXP"	=> 239,
				"EV"	=>	array(
					"Special Defense"	=>	3,
				),
				"Evolve"	=> "No",
				"Stats"	=> array(
					"HP"             => 79,
					"Attack"         => 83,													
					"Defense"        => 100,
					"Special Attack" => 85,
					"Special Defense"=> 105,
					"Speed"          => 78,
				),
			),
			
		);																					// Our Pokedex has been completed ( Will likely add more generations as we go. )
		foreach( $pokemon as $name => $details )
		{
			$pokemon2[strtolower( $name )] = $details;
			$pokemon2[strtolower( $name )]['name'] = $name;			
		}
		$config->df['pokedex'] = $pokemon2;													// Plan on Pokedex.df to be fucking massive. lol
		$config->save_config( "./config/pokedex.df", $config->df['pokedex'] );
	}
	