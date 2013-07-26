<?php
include_once("modules/Magician/functions.php");
switch($args[0]){
	case "rllama":
	case "rspama":
	case "llama":
		if( $args[0] == "llama" && empty($args[1] ) ){
			return $dAmn->say("$from: You must provide a username to send a llama to, or use {$tr}rllama to send it to someone random.",$c);
		}
		//Setting up for a llama sending spree..
		if( $args[0] == "rspama" ){
			//Default loop is set at 50. We assume if $args[1] isn't a number that it's the account you want to send llamas from. .. Fixing that now.
			if( !is_numeric( $args[1] ) ){
				$person2 = strtolower( $args[1] );
			}
			if( empty($args[1] ) ){
				$loopnum = 50;
			}
			//If a number was supplied AND you supplied a second argument, we'll try to use that for llama sending.
			if( isset( $args[2] ) ){
				$loopnum = $args[1];
				$person2 = strtolower( $args[2] );
			}elseif( isset( $args[1] ) && $args[1] <= 77 ){
				$loopnum = $args[1];
			}else $loopnum = 77;
		}
		//If any $args were provided in the rllama command, we'll be using that as $person2, which will be checked against the stored logins list.
		if( $args[0] == "rllama" && isset( $args[1] ) ){
			$person2 = strtolower( $args[1] );
		}
		if( $args[0] == "llama" && isset( $args[2] ) ){
			$person2 = strtolower( $args[2] );
		}
		$login = parse_ini_file( f( "config.ini" ) ); 			//This loads the $login
		if( !empty( $person2 ) ) {								// Unfortunately, $person2 is no longer optional. This is why it's been merged with Magician.
			if( isset( $config->logins['login'][$person2] ) ) { // Checking the logins list (if it exists, otherwise, we cannot go forward in this current version ).
				$username = $person2;							// The password is encoded.
				$password = base64_decode( $config->logins['login'][$person2] );
			}else{
				return $dAmn->say( "$from: {$person[2]} is not a stored login. In order to use llama, you must have Magician to set up the logins list and store accounts for you.", $c );
			}
		}
		if( $args[0] == "llama" ){								// Let's check to see if $username has sent a llama to $args[1] before.
			if( isset( $config->llama[strtolower( $username )][strtolower( $args[1] )] ) ){
				return $dAmn->say( "$from: $username can't send another llama to $args[1].",$c );
			}
		}
		$cookie_jar = $dAmn->getCookie( $username, $password );
		if( isset( $cookie_jar['error'] ) ) {
			return $dAmn->say( "$from: {$cookie_jar['error']}", $c );
		}
		$config->df['llamasend']['llamauser'][$username] = $cookie_jar;
		$config->save_info( "./config/llamasend.df", $config->df['llamasend'] );
		if( strtolower( $args[0] ) == "rllama" ){
			//This is the part where we kick out the info to the llama badge sender. This part is for the random llama so it'll just be sending the cookie and password to use.
			llama( null, $cookie_jar, $password, $username );
			$dAmn->say( "$from: Random llama sent as $username!", $c );
		}elseif( strtolower( $args[0] ) == "llama" ) {
			//This one is for the specified user. It'll kick out the username, cookie, and the password for the account used.
			llama( $args[1], $cookie_jar, $password, $username );
			$dAmn->say( "$from: Llama sent to $args[1] as $username!", $c );
		}elseif( strtolower( $args[0] ) == "rspama" ) {
			//This is where we'll be kicking out the llama loop. 
			for( $i = 0; $i <= $loopnum; $i++ ){
				llama( null, $cookie_jar, $password, $username );
				//$dAmn->pingpong2();
				$dAmn->send( "pong\n" . chr( 0 ) );
			}
			$dAmn->logout( $username, $info );
			if( file_exists( "./modules/rubix/config.php" ) ) {
				if( $args[2] !== "todo-mahem" ){
					parseCommand( "{$tr}hidecoms {$args[2]}", $config->bot['owner'], "!err_plz!", "msg");
				}
			}
			$dAmn->say( "$from: $loopnum llamas sent as $username!", $c );
		}
	break;
	case "fullama":
		if( isset( $args[1] ) ){
			foreach( $config->logins['login'] as $person2 => $password ){
				if( !isset( $config->df['llamasend']['llamauser'][$person2] ) ){
					parseCommand( $config->bot['trigger']."llama {$args[1]} {$person2}", $config->bot['owner'], "#rand", "msg" );
				}else $cookie_jar = $config->df['llamasend']['llamauser'][$person2];
					llama( $args[1], $cookie_jar, $password, $person2 );
					$dAmn->send( "pong\n" . chr( 0 ) );
			}
			$dAmn->say("$from: ".count($config['logins']['login'])." llamas sent to $args[1]!",$c);
		}else{
			foreach( $config->logins['login'] as $person2 => $password ){
				if( !isset($config->df['llamasend']['llamauser'][$person2])){
					parseCommand( $config->bot['trigger']."rllama {$person2}", $config->bot['owner'], "#rand", "msg" );
				}else $cookie_jar = $config->df['llamasend']['llamauser'][$person2];
					llama( null, $cookie_jar, $password, $person2 );
					$dAmn->send( "pong\n" . chr( 0 ) );
			}
			$dAmn->say( "$from: ". count($config->logins['login'])." random llamas sent!", $c );
		}
	break;
	case "cookieclear":
		unset( $config->df['llamasend']['llamauser'] );
		$config->save_info( "./config/llamasend.df", $config->df['llamasend'] );
		$dAmn->say( "$from: Llama user cookies cleared.", $c );
	break;
}
?>