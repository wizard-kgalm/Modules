<?php
$gameroom = $config->df['werewolf']['gameroom'];
$backroom = $config->df['werewolf']['backroom'];
switch ( $args[0] ) {
	case "witch":
		$dAmn->say( "$from: <li> <b>Witch</b>: The witch is an essential role to the game. They have 2 potions, one can save a player that is chosen to die by the werewolves, the other can kill a person of their choice. Their turn follows the werewolves, and they're told the person who the werewolves have chosen to kill and given the option of using those two potions. These are the commands the Witch uses:</li><br>
		<ul><li> <b>{$tr}todie</b> Tells the witch who the wolves have chosen and reminds them which potions they have left.</li>
		<li> <b>{$tr}saves <i>player</i> <u>confirm</u></b> is used to save the player the wolves have chosen to kill. This may only be used once per game.</li>
		<li> <b>{$tr}kills <i>player</i> <u>confirm</u></b> is used to kill a player of the witch's choice. Used correctly, it could very well change the tide of the game. It may only be used once per game.</li></ul>", $c );
	break;
	case "todie":
		if( strtolower( $c ) !== $backroom ) {
			return $dAmn->say( "$from: This is a dAmnWerewolf command, and is part of the game. As such, it can only be used in the backroom.", $c );
		}
		if( !isset( $config->df['werewolf']['witch'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: This can only be used by the Witch.", $c );
		}
		if( !isset( $config->df['werewolf']['todie'] ) ) {
			$dAmn->say( "$from: The wolves do not have anyone selected to die.", $c );
		} else {
			$dAmn->say( "$from: The wolves have selected {$config->df['werewolf']['tokill']} to kill.", $c );
		}
		if( $config->df['werewolf']['witchsave'] === TRUE ) {
			$dAmn-say( "$from: You can save. Do you wish to save the victim? <i>{$tr}saves {$config->df['werewolf']['tokill']} yes/confirm</i> will do so, but know that it cannot be undone, and you will not be able to save anyone else.", $c );
		} else {
			$dAmn->say( "$from: You cannot save.", $c );
		}
		if( $config->df['werewolf']['witchkill'] === TRUE ) {
			$dAmn->say( "$from: You can kill. Do you wish to kill someone? <i>{$tr}kill [player] yes/confirm</i> will select them to die.", $c );
		} else {
			$dAmn->say( "$from: You cannot kill.", $c );
		}
		$dAmn->say( "$from: After you have made your decisions, you may /part." , $c );
	break;
	case "saves":
		if( strtolower( $c ) !== $backroom ) {
			return $dAmn->say( "$from: This is a dAmnWerewolf command, and is part of the game. As such, it can only be used in the backroom.", $c );
		}
		if( !isset( $config->df['werewolf']['witch'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: This can only be used by the Witch.", $c );
		}
		if( $config->df['werewolf']['witchsave'] === FALSE ) {
			return $dAmn->say( "$from: You have already used your save potion.", $c );
		}
		if( empty( $args[1] ) ) {
			return $dAmn->say( "$from: See <i>{$tr}save ? </i> for correct usage.", $c );
		}
		if( strtolower( $args[2] ) !== "yes" || strtolower( $args[2] ) !== "confirm" ) {
			return $dAmn->say( "$from: Are you sure you want to save them? <i>{$tr}saves [player] yes/confirm</i>.", $c );
		}
		if( !isset( $config->df['werewolf']['roles'][strtolower( $args[1] )] ) ) {
			return $dAmn->say( "$from: This can only be used on active players.", $c );
		}
		if( strtolower( $args[1] ) !== $config->df['werewolf']['tokill'] ) {
			return $dAmn->say( "$from: You can only save the player the werewolves have selected to die.", $c );
		}
		unset( $config->df['werewolf']['tokill'] );
		$config->df['werewolf']['witchsave'] = FALSE;
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->say( "$from: You have saved {$args[1]} from the werewolves.", $c );
	break;
	case "kills":
		if( strtolower( $c ) !== $backroom ) {
			return $dAmn->say( "$from: This is a dAmnWerewolf command, and is part of the game. As such, it can only be used in the backroom.", $c );
		}
		if( !isset( $config->df['werewolf']['witch'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: This can only be used by the Witch.", $c );
		}
		if( $config->df['werewolf']['witchkill'] === FALSE ) {
			return $dAmn->say( "$from: You have already used your kill potion.", $c );
		}
		if( empty( $args[1] ) ) {
			return $dAmn->say( "$from: See <i>{$tr}save ? </i> for correct usage.", $c );
		}
		if( strtolower( $args[2] ) !== "yes" || strtolower( $args[2] ) !== "confirm" ) {
			return $dAmn->say( "$from: Are you sure you want to save them? <i>{$tr}saves [player] yes/confirm</i>.", $c );
		}
		if( !isset( $config->df['werewolf']['roles'][strtolower( $args[1] )] ) ) {
			return $dAmn->say( "$from: This can only be used on active players.", $c );
		}
		if( strtolower( $args[1] ) == $config->df['werewolf']['gamemaster'] ) {
			return $dAmn->say( "$from: You cannot kill the GameMaster.", $c );
		}
		if( strtolower( $args[1] ) == $config->df['werewolf']['tokill'] ) {
			return $dAmn->say( "$from: You can't kill someone the werewolves have already selected to die.", $c );
		}
		$config->df['werewolf']['wtodie'] = strtolower( $args[1] );
		$config->df['werewolf']['witchkill'] = FALSE;
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->say( "$from: You have selected to kill {$args[1]}.", $c );
	break;
}
?>