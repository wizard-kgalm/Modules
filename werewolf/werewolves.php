<?php
$gameroom = $config->df['werewolf']['gameroom'];
$backroom = $config->df['werewolf']['backroom'];
switch ( $args[0] ) {
	case "werewolf":
	case "werewolves":
		$dAmn->say("$from: <li> <b>Werewolves</b>: The werewolf role is the antagonist of the game. The townies seek to weed out the few werewolves among them. If there are no lovers, the werewolves win when the number of townies is less than or equal to the number of wolves. The goal of the werewolves are to blend in unnoticeably amongst the townspeople. The werewolves turn is at the start of each night round and consists of them gathering in the backroom and voting for a player to kill. These are the commands they use:</li><br>
		<ul><li> <b>{$tr}wkill <i>player</i></b> is used by EACH wolf to vote/select their kill. The goal is to unanimously vote on one player. If they don't, then no one is killed. If they mess up and would like to revote, {$tr}xvote will clear their vote.</li>
		<li> <b>{$tr}xvote</b> clears the user's vote, so they may reselect their kill.</li></ul>", $c );
	break;
	case "wkill":
		if( strtolower( $c ) !== strtolower( $backroom ) ) {
			return $dAmn->say( "$from: This command is part of the dAmnWerewolves game and cannot be used outside of the game's backroom, {$backroom}" , $c );
		}
		if( !isset( $config->df['werewolf']['wolf'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: This command is for the werewolves only.", $c );
		}
		if( empty( $args[1] ) ) {
			return $dAmn->say( "$from: See <i>{$tr}wkill ?</i> for correct usage.", $c );
		}
		if( strtolower( $args[1] ) == $config->df['werewolf']['gamemaster'] ) {
			return $dAmn->say( "$from: You cannot vote to kill the GameMaster", $c );
		}
		if( !isset( $config->df['werewolf']['roles'][strtolower( $args[1] )] ) ) {
			return $dAmn->say( "$from: You can only vote to kill an active player.", $c );
		}
		if( isset( $config->df['werewolf']['wolf'][strtolower( $args[1] )] ) && ( strtolower( $args[2] ) !== "yes" || strtolower( $args[2] ) !== "confirm" ) ) {
			return $dAmn->say( "$from: To elect to kill a werewolf, you must use {$tr}wkill {$args[1]} <i>yes/confirm</i>.", $c );
		}
		$config->df['werewolf']['wolfvotes']++;
		$config->df['werewolf']['hasvoted'][strtolower( $from )] = $args[1];
		$config->df['werewolf']['killvote'][strtolower( $args[1] )]++;
		if( ( $config->df['werewolf']['werewolves'] / 2 + 1 ) <= $config->df['werewolf']['killvote'][strtolower( $args[1] )] ) {
			$config->df['werewolf']['tokill'] = strtolower( $args[1] );
		}
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->say( "$from: You have voted to kill {$args[1]}. {$args[1]} has {$config->df['werewolf']['killvote'][strtolower( $args[1] )]} votes out of {$config->df['werewolf']['werewolves']} votes. To change your vote, use {$tr}xvote.", $c );
		if( $config->df['werewolf']['wolfvotes'] == $config->df['werewolf']['wolves'] ) {
			if( isset( $config->df['werewolf']['tokill'] ) ) {
				$dAmn->say( "The wolves have selected to kill {$config->df['werewolf']['tokill']}. You may all /part now.", $c );
			} else {
				$dAmn->say( "You do not have a majority vote to kill anyone. Please use {$tr}xvote and select a single target.", $c );
			}
		}
	break;
	case "xvote":
		if( strtolower( $c ) !== strtolower( $backroom ) ) {
			return $dAmn->say( "$from: This command is part of the dAmnWerewolves game and cannot be used outside of the game's backroom, {$backroom}" , $c );
		}
		if( !isset( $config->df['werewolf']['wolf'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: This command is for the werewolves only.", $c );
		}
		if( !isset( $config->df['werewolf']['hasvoted'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: You haven't voted yet, so you cannot repeal your vote.", $c );
		}
		$vote = $config->df['werewolf']['hasvoted'][strtolower( $from )]; 
		$config->df['werewolf']['killvote'][$vote]--;
		$config->df['werewolf']['wolfvotes']--;
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->say( "$from: Your vote has been removed.", $c );
	break;
}
?>