<?php
function autoassign($player){
	global $config, $dAmn, $Timer;
	$backroom = $config['werewolf']['backroom'];
	$hunter = $config['werewolf']['hunter'];
	$cupid = $config['werewolf']['cupid'];
	$defender = $config['werewolf']['defender'];
	$gm = $config['werewolf']['gamemaster'];
	if($hunter && $cupid && $defender){
		if($config['werewolf']['count'] <= 10){
			if($config['werewolf']['wolves'] < 2){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter', 'cupid', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 2){
				$possible = array('townie', 'witch', 'oracle', 'hunter', 'cupid', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 10 && $config['werewolf']['count'] <= 12){
			if($config['werewolf']['wolves'] < 3){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter', 'cupid', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 3){
				$possible = array('townie', 'witch', 'oracle', 'hunter', 'cupid', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 12 && $config['werewolf']['count'] <= 16){
			if($config['werewolf']['wolves'] < 4){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter', 'cupid', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 4){
				$possible = array('townie', 'witch', 'oracle', 'hunter', 'cupid', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 16 && $config['werewolf']['count'] <= 24){
			if($config['werewolf']['wolves'] < 5){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter', 'cupid', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 5){
				$possible = array('townie', 'witch', 'oracle', 'hunter', 'cupid', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}
	}else
	if($hunter && $cupid){
		if($config['werewolf']['count'] <= 10){
			if($config['werewolf']['wolves'] < 2){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter', 'cupid',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 2){
				$possible = array('townie', 'witch', 'oracle', 'hunter', 'cupid',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 10 && $config['werewolf']['count'] <= 12){
			if($config['werewolf']['wolves'] < 3){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter', 'cupid',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 3){
				$possible = array('townie', 'witch', 'oracle', 'hunter', 'cupid',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 12 && $config['werewolf']['count'] <= 16){
			if($config['werewolf']['wolves'] < 4){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter', 'cupid',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 4){
				$possible = array('townie', 'witch', 'oracle', 'hunter', 'cupid',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 16 && $config['werewolf']['count'] <= 24){
			if($config['werewolf']['wolves'] < 5){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter', 'cupid',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 5){
				$possible = array('townie', 'witch', 'oracle', 'hunter', 'cupid',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}
	}else
	if($hunter && $defender){
		if($config['werewolf']['count'] <= 10){
			if($config['werewolf']['wolves'] < 2){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter','defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 2){
				$possible = array('townie', 'witch', 'oracle', 'hunter','defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 10 && $config['werewolf']['count'] <= 12){
			if($config['werewolf']['wolves'] < 3){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 3){
				$possible = array('townie', 'witch', 'oracle', 'hunter', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 12 && $config['werewolf']['count'] <= 16){
			if($config['werewolf']['wolves'] < 4){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 4){
				$possible = array('townie', 'witch', 'oracle', 'hunter', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 16 && $config['werewolf']['count'] <= 24){
			if($config['werewolf']['wolves'] < 5){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 5){
				$possible = array('townie', 'witch', 'oracle', 'hunter', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}
	}else
	if($cupid && $defender){
		if($config['werewolf']['count'] <= 10){
			if($config['werewolf']['wolves'] < 2){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'cupid', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 2){
				$possible = array('townie', 'witch', 'oracle', 'cupid', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 10 && $config['werewolf']['count'] <= 12){
			if($config['werewolf']['wolves'] < 3){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'cupid', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 3){
				$possible = array('townie', 'witch', 'oracle', 'cupid', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 12 && $config['werewolf']['count'] <= 16){
			if($config['werewolf']['wolves'] < 4){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'cupid', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 4){
				$possible = array('townie', 'witch', 'oracle', 'cupid', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 16 && $config['werewolf']['count'] <= 24){
			if($config['werewolf']['wolves'] < 5){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'cupid', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 5){
				$possible = array('townie', 'witch', 'oracle', 'cupid', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}
	}else
	if($hunter){
		if($config['werewolf']['count'] <= 10){
			if($config['werewolf']['wolves'] < 2){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 2){
				$possible = array('townie', 'witch', 'oracle', 'hunter',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 10 && $config['werewolf']['count'] <= 12){
			if($config['werewolf']['wolves'] < 3){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 3){
				$possible = array('townie', 'witch', 'oracle', 'hunter',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 12 && $config['werewolf']['count'] <= 16){
			if($config['werewolf']['wolves'] < 4){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 4){
				$possible = array('townie', 'witch', 'oracle', 'hunter',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 16 && $config['werewolf']['count'] <= 24){
			if($config['werewolf']['wolves'] < 5){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'hunter',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 5){
				$possible = array('townie', 'witch', 'oracle', 'hunter',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}
	}else
	if($cupid){
		if($config['werewolf']['count'] <= 10){
			if($config['werewolf']['wolves'] < 2){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'cupid',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 2){
				$possible = array('townie', 'witch', 'oracle', 'cupid',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 10 && $config['werewolf']['count'] <= 12){
			if($config['werewolf']['wolves'] < 3){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'cupid',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 3){
				$possible = array('townie', 'witch', 'oracle', 'cupid',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 12 && $config['werewolf']['count'] <= 16){
			if($config['werewolf']['wolves'] < 4){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'cupid',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 4){
				$possible = array('townie', 'witch', 'oracle', 'cupid',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 16 && $config['werewolf']['count'] <= 24){
			if($config['werewolf']['wolves'] < 5){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'cupid',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 5){
				$possible = array('townie', 'witch', 'oracle', 'cupid',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}
	}else
	if($defender){
		if($config['werewolf']['count'] <= 10){
			if($config['werewolf']['wolves'] < 2){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 2){
				$possible = array('townie', 'witch', 'oracle', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 10 && $config['werewolf']['count'] <= 12){
			if($config['werewolf']['wolves'] < 3){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 3){
				$possible = array('townie', 'witch', 'oracle', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 12 && $config['werewolf']['count'] <= 16){
			if($config['werewolf']['wolves'] < 4){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 4){
				$possible = array('townie', 'witch', 'oracle', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 16 && $config['werewolf']['count'] <= 24){
			if($config['werewolf']['wolves'] < 5){
				$possible = array('werewolf', 'townie', 'witch', 'oracle', 'defender',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 5){
				$possible = array('townie', 'witch', 'oracle', 'defender',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}
	}else
	if(!$hunter && !$defender && !$cupid){

		if($config['werewolf']['count'] <= 10){
			if($config['werewolf']['wolves'] < 2){
				$possible = array('werewolf', 'townie', 'witch', 'oracle',);
				$werewolf = TRUE;
			}
			if($config['werewolf']['wolves'] == 2){
				$possible = array('townie', 'witch', 'oracle',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 10 && $config['werewolf']['count'] <= 12){
			if($config['werewolf']['wolves'] < 3){
				$possible = array('werewolf', 'townie', 'witch', 'oracle',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 3){
				$possible = array('townie', 'witch', 'oracle',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 12 && $config['werewolf']['count'] <= 16){
			if($config['werewolf']['wolves'] < 4){
				$possible = array('werewolf', 'townie', 'witch', 'oracle',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 4){
				$possible = array('townie', 'witch', 'oracle',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}else
		if($config['werewolf']['count'] > 16 && $config['werewolf']['count'] <= 24){
			if($config['werewolf']['wolves'] < 5){
				$possible = array('werewolf', 'townie', 'witch', 'oracle',);
				$werewolf = TRUE;
			}else
			if($config['werewolf']['wolves'] == 5){
				$possible = array('townie', 'witch', 'oracle',);
				$werewolf = FALSE;
			}
			$assigns = $possible[array_rand($possible)];
		}
	}
			$witchz = $config['werewolf']['witchz'];
			$hunterz = $config['werewolf']['hunterz'];
			$oraclez = $config['werewolf']['oraclez'];
			$cupidz = $config['werewolf']['cupidz'];
			$defenderz = $config['werewolf']['defenderz'];
	
		if($witchz && $oraclez && !$werewolf && !$hunter && !$cupid && !$defender){
			$assigns = "townie";
		}
		if($witchz && $oraclez && !$werewolf && $hunterz && !$cupid && !$defender){
			$assigns = "townie";
		}
		if($witchz && $oraclez && !$werewolf && $hunterz && $cupidz && !$defender){
			$assigns = "townie";
		}
		if($witchz && $oraclez && !$werewolf && $hunterz && $defenderz && !$cupid){
			$assigns = "townie";
		}
		if($witchz && $oraclez && !$werewolf && $defenderz && !$hunter && !$cupid){
			$assigns = "townie";
		}
		if($witchz && $oraclez && !$werewolf && $defenderz && $cupidz && !$hunter){
			$assigns = "townie";
		}
		if($witchz && $oraclez && !$werewolf && $cupidz && !$defender && !$hunter){
			$assigns = "townie";
		}
	if(!isset($config['werewolf']['roles'][$player])){
		$config['werewolf']['roles'][$player] = $assigns;
		if($assigns == "witch"){
			if($witchz){
				unset($config['werewolf']['roles'][$player]);
				save_config('werewolf');
			}else
			if(!$witchz){
				$config['werewolf']['assigned']++;
				$config['werewolf']['witchz'] = TRUE;
				save_config('werewolf');
				$dAmn->say("$gm: The Witch is {$player}.",$backroom);
			}
		}
		if($assigns == "oracle"){
			if($oraclez){
				unset($config['werewolf']['roles'][$player]);
				save_config('werewolf');
			}else
			if(!$oraclez){
				$config['werewolf']['assigned']++;
				$config['werewolf']['oraclez'] = TRUE;
				save_config('werewolf');
				$dAmn->say("$gm: The Oracle is {$player}.",$backroom);
			}
		}
		if($assigns == "hunter"){
			if($hunterz){
				unset($config['werewolf']['roles'][$player]);
				save_config('werewolf');
			}else
			if(!$hunterz){
				$config['werewolf']['assigned']++;
				$config['werewolf']['hunterz'] = TRUE;
				save_config('werewolf');
				$dAmn->say("$gm: The Hunter is {$player}.",$backroom);
			}
		}
		if($assigns == "cupid"){
			if($cupidz){
				unset($config['werewolf']['roles'][$player]);
				save_config('werewolf');
			}else
			if(!$cupidz){
				$config['werewolf']['assigned']++;
				$config['werewolf']['cupidz'] = TRUE;
				save_config('werewolf');
				$dAmn->say("$gm: Cupid is {$player}.",$backroom);
			}
		}
		if($assigns == "defender"){
			if($defenderz){
				unset($config['werewolf']['roles'][$player]);
				save_config('werewolf');
			}else
			if(!$defenderz){
				$config['werewolf']['assigned']++;
				$config['werewolf']['defenderz'] = TRUE;
				save_config('werewolf');
				$dAmn->say("$gm: The Defender is {$player}.",$backroom);
			}
		}
		if($assigns == "werewolf"){
				$config['werewolf']['assigned']++;
				$config['werewolf']['wolves']++;
				save_config('werewolf');
				$dAmn->say("$gm: {$player} is a werewolf.",$backroom);
		}
		if($config['werewolf']['wolves'] > 2){
			unset($config['werewolf']['roles'][$player]);
			save_config('werewolf');
		}
		if($assigns == "townie"){
			if( !$witchz && !$oraclez){
				unset($config['werewolf']['roles'][$player]);
				save_config('werewolf');
			}else
			if( $witchz && $oraclez){
					$config['werewolf']['assigned']++;
					save_config('werewolf');
					$dAmn->say("$gm: {$player} is a townie.",$backroom);
				
			}
		
		}
	}
		
	
}
					