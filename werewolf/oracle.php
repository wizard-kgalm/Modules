<?php
$gameroom = $config->df['werewolf']['gameroom'];
$backroom = $config->df['werewolf']['backroom'];
switch ( $args[0] ) {
	case "oracle":
		$dAmn->say( "$from: <ul><li><b>Oracle</b>: The oracle is the other major townie role. They are important in that they are allowed to look at one player a turn and learn of their role. If they discover one of the wolves, they are now armed with the knowledge of one of the wolves. Revealing themselves can be a strategic move towards the end of the game to rally the townies to kill the wolves. The Oracle's turn follows after the witch. This is the command the Oracle uses. </li><br>
<ul><li> <b>{$tr}seek <i>player</i></b> displays the role of the player. It may only be used ONCE per round.</li></ul>", $c );
	break;
	case "seek":
		if( strtolower( $c ) !== $backroom ) {
			return $dAmn->say( "$from: This is a dAmnWerewolf command, and is part of the game. As such, it can only be used in the backroom.", $c );
		}
		if( !isset( $config->df['werewolf']['oracle'][strtolower( $from )] ) ) {
			return $dAmn->say( "$from: This can only be used by the Oracle.", $c );
		}
		if( $config->df['werewolf']['oracleview'] === FALSE ) {
			return $dAmn->say( "$from: You have already used your view for this round.", $c );
		}
		if( empty( $args[1] ) ) {
			return $dAmn->say( "$from: See <i>{$tr}seek ? </i> for correct usage.", $c );
		}
		if( !isset( $config->df['werewolf']['roles'][strtolower( $args[1] )] ) ) {
			return $dAmn->say( "$from: This can only be used on active players.", $c );
		}
		if( strtolower( $args[1] ) == $config->df['werewolf']['gamemaster'] ) {
			return $dAmn->say( "$from: That's the GameMaster. You cannot learn anything more about them.", $c );
		}
		if( strtolower( $args[1] ) == strtolower( $from ) ){
			return $dAmn->say( "$from: You're the Oracle. You cannot learn your own role.", $c );
		}
		if( isset( $config->df['werewolf']['seen'][strtolower( $args[1] )] ) ) {
			return $dAmn->say( "$from: You have already viewed {$args[1]}'s role. Please select another player.", $c );
		}
		$role = $config->df['werewolf']['roles'][strtolower( $args[1] )];
		$config->df['werewolf']['seen'][strtolower( $args[1] )] == "yes";
		$config->df['werewolf']['oracleview'] = FALSE;
		$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
		$dAmn->say( "$from: {$args[1]} is {$role}. You may now /part.", $c );
	break;
}
?>