<?php
include_once("modules/Magician/functions.php");
switch($args[0]){
	case "rllama":
	case "rspama":
	case "llama":
		if( $args[0] == "llama" && empty($args[1] ) ){
			return $dAmn->say("$from: You must provide a username to send a llama to, or use {$tr}rllama to send it to someone random.",$c);
		}																// Setting up for a llama sending spree..
		if( $args[0] == "rspama" ){										// We need a person to send the llamas.
			if( !is_numeric( $args[1] ) ){								// I should probably rewrite this to be less stupid. :I
				$person2 = strtolower( $args[1] );
			}
			if( empty($args[1] ) ){
				$loopnum = 50;
			}
			if( $args[1] <= 77 ) {
				$loopnum = $args[1];
			} else {
				$loopnum = 77;
			}
			if( isset( $args[2] ) ){
				$person2 = strtolower( $args[2] );
			} else {
				$person2 = strtolower( $config->bot['username'] );
			}
		}
		if( $args[0] == "rllama" && isset( $args[1] ) ){
			$person2 = strtolower( $args[1] );
		}
		if( $args[0] == "llama" && isset( $args[2] ) ){
			$person2 = strtolower( $args[2] );
		}
		if( !empty( $person2 ) ) {								// Unfortunately, $person2 is no longer optional. This is why it's been merged with Magician.
			if( isset( $config->df['llamasend']['users'][$person2] ) ) {
				$cookie_jar = $config->df['llamasend']['users'][$person2];	// We're going to test dat cookie and make sure it's active.
				$response = $dAmn->send_headers( fsockopen( "tcp://www.deviantart.com", 80), "www.deviantart.com", "/", "", "", $cookie_jar );
				$response = explode( "\r\n", $response );
				$cookie_jar = array();
				foreach( $response as $line ) { 
					if( strpos( $line, "Set-Cookie:" ) !== FALSE ) {
						$cookie_jar[] = substr( $line, 12, strpos( $line, "; " ) -12 );
					}
				}
				$taco = explode( ";", urldecode( $cookie_jar[0] ) );
				if( stristr( $taco[1], "\"username\":\"\"" ) ) {
					echo "That session ended, let's grab a new one. \n";
					$cookie_jar = NULL;
				} else {
					$username = $person2;
					$password = base64_decode( $config->logins['login'][$person2] );	// Whoops, forgot that, round 1. 
					$cookie_jar = $config->df['llamasend']['users'][$person2];
				}
			}
			if( $cookie_jar === NULL || empty( $cookie_jar ) ) {	
				if( isset( $config->logins['login'][$person2] ) ) { // Checking the logins list (if it exists, otherwise, we cannot go forward in this current version ).
					$username = $person2;							// The password is encoded.
					$password = base64_decode( $config->logins['login'][$person2] );
					$cookie_jar = $dAmn->getCookie( $username, $password );
					if( isset( $cookie_jar['error'] ) ) {
						return $dAmn->say( "$from: {$cookie_jar['error']}", $c );
					}
					$config->df['llamasend']['users'][$username] = $cookie_jar;
					$config->save_info( "./config/llamasend.df", $config->df['llamasend'] );
				}else{
					return $dAmn->say( "$from: {$person[2]} is not a stored login. In order to use llama, you must have Magician to set up the logins list and store accounts for you.", $c );
				}
			}
		}															// No more checking the file.. let's instead see if we get a response from llama.
		if( $args[0] !== "rspama" ) {
			( $args[0] == "llama" ) ? $to = $args[1] : $to = NULL;	// Command specific. We want $to blank for rllama so it goes to random deviant.
			$response = llama( $to, $cookie_jar, $password, $username );// Let's kick it out to the llama function.
			if( is_string( $response ) ) {
				return $dAmn->say( $response , $c );
			}
			( empty( $to ) ) ? $say = "Random llama sent as $username!" : $say = "Llama sent to {$args[1]} as $username!";
			$dAmn->say( "$from: {$say}", $c );
		} else {													// For rspama, we're going to spawn a loop. No more than 77, as this is the limit
			for( $i = 0; $i <= $loopnum; $i++ ){					// before dA's spamfilter is tripped, blocking you from sending llamas.
				llama( null, $cookie_jar, $password, $username );
				$dAmn->send( "pong\n" . chr( 0 ) );					// We'll need this to prevent the bot from timing out. 
			}
			if( file_exists( "./modules/rubix/config.php" ) ) {
				if( $args[2] !== "todo-mahem" ){
					parseCommand( "{$tr}hidecoms {$args[2]}", $config->bot['owner'], "!err_plz!", "msg");
				}
			}
			registerChat( "[$c] <{$config->bot['username']}> $from: $loopnum llamas sent as $username!", $c, TRUE );	// For llamabot. I'm getting rid of all
			//$dAmn->say( "$from: $loopnum llamas sent as $username!", $c );											// spam command related messages. :D
		}
	break;
	case "fullama":
		if( isset( $args[1] ) ){
			foreach( $config->logins['login'] as $person2 => $password ){
				if( !isset( $config->df['llamasend']['users'][$person2] ) ){
					parseCommand( $config->bot['trigger']."llama {$args[1]} {$person2}", $config->bot['owner'], "#rand", "msg" );
				}else $cookie_jar = $config->df['llamasend']['users'][$person2];
					llama( $args[1], $cookie_jar, $password, $person2 );
					$dAmn->send( "pong\n" . chr( 0 ) );
			}
			$dAmn->say("$from: ".count($config->df['logins']['login'])." llamas sent to $args[1]!",$c);
		}else{
			foreach( $config->logins['login'] as $person2 => $password ){
				if( !isset($config->df['llamasend']['users'][$person2])){
					parseCommand( $config->bot['trigger']."rllama {$person2}", $config->bot['owner'], "#rand", "msg" );
				}else $cookie_jar = $config->df['llamasend']['users'][$person2];
					llama( null, $cookie_jar, $password, $person2 );
					$dAmn->send( "pong\n" . chr( 0 ) );
			}
			$dAmn->say( "$from: ". count($config->df['logins']['login'])." random llamas sent!", $c );
		}
	break;
	case "cookieclear":
		unset( $config->df['llamasend']['users'] );
		$config->save_info( "./config/llamasend.df", $config->df['llamasend'] );
		$dAmn->say( "$from: Llama user cookies cleared.", $c );
	break;
}
?>