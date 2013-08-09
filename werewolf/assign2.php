<?php
function autorole() {
	global $config, $dAmn, $Timer;
		$backroom = $config['werewolf']['backroom'];
	$hunter = $config['werewolf']['hunter'];
	$cupid = $config['werewolf']['cupid'];
	$defender = $config['werewolf']['defender'];
	$gm = $config['werewolf']['gamemaster'];
	$check = $config['werewolf']['roles'];
	$check2 = $config['werewolf']['wolves'];
	$check3 = $config['werewolf']['count'];
	$assignments = array('oracle', 'witch',);
	//To make things neater, we're gonna load up the players here.
	$players = $config['werewolf']['notassigned'];
	//The following 'if' statements are factoring in special roles. This will significantly reduce the complication of the autoassigner.
	if($check3 > 04 && $check3 <= 10){
		$check4 = 2;
	}
	if($check3 > 10 && $check3 <= 12){
		$check4 = 3;
	}
	if($check3 > 12 && $check3 <= 16){
		$check4 = 4;
	}
	if($check3 > 16 && $check3 <= 24){
		$check4 = 5;
	}
	if($hunter){
		$assignments[] = 'hunter';
	}
	if($cupid){
		$assignments[] = 'cupid';
	}
	if($defender){
		$assginments[] = 'defender';
	}
	if($harlot){
		$assigments[] = 'harlot';
	}
	if($jester){
		$assignments[] = 'jester';
	}
	if($vidiot){
		$assignments[] = 'village idiot';
	}
	//Here's where we assign people the special roles. 
	foreach($assignments as $num => $assign){
		//Here's where we randomize the selection.
		$player = $config['werewolf']['notassigned'][array_rand($config['werewolf']['notassigned'])];
		//We're going to DOUBLE CHECK and make sure our player doesn't already have a role. More likely than not, they won't.
		if(!$check[$player]){
			$config['werewolf']['roles'][$player] = $assign;
			//Here's were we unset them from the not-assigned list. This is so their names won't pop back up later. 
			unset($config['werewolf']['notassigned'][$player]);
			$config['werewolf']['learnrole'][$player] = TRUE;
			save_config('werewolf');
			$dAmn->say("$gm: {$player} is the {$assign}.",$backroom);
		}
	}
	
	
	/*while(!$done){
		foreach($assignments as $assignment){
			$player = $players[array_rand($players)];
			if(!in_array($assignment, $config['werewolf']['roles'])){
				$config['werewolf']['roles'][$player] = $assignment;
				unset($config['werewolf']['notassigned'][$player]);
				$config['werewolf']['learnrole'][$player] = TRUE;
				save_config('werewolf');
				$dAmn->say("$gm: {$player} is the {$assignment}.", $backroom);
			}
		}
		$done = TRUE;
	}
	*/
		
	//Here's where the werewolves are assigned. 
	for($i=0; $i<$check4; $i++){
		if($config['werewolf']['wolves'] < $check4){
			//Randomizing the players left for the werewolf role. 
			$player = $config['werewolf']['notassigned'][array_rand($config['werewolf']['notassigned'])];
			if(!$check[$player]){
				$config['werewolf']['roles'][$player] = 'werewolf';
				//Jumping up the werewolf count for various purposes.
				$config['werewolf']['wolves']++;
				unset($config['werewolf']['notassigned'][$player]);
				$config['werewolf']['learnrole'][$player] = TRUE;
				save_config('werewolf');
				$dAmn->say("$gm: {$player} is a werewolf.", $backroom);
			}
		}
	}
	//Finally, we assign whoever's left a townie role.
	foreach($config['werewolf']['notassigned'] as $num => $player){
		//Coat check. Have we seen this person before? If so, they shouldn't be on this list.. bot error.
		if(!isset($config['werewolf']['roles'][$player])){
			if($config['werewolf']['wolves'] == $check4){
				$config['werewolf']['roles'][$player] = 'townie';
				$config['werewolf']['learnrole'][$player] = TRUE;
				save_config('werewolf');
				$dAmn->say("$gm: {$player} is a townie.",$backroom);
			}
		}
	}
}