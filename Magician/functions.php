<?php
if( !function_exists( "llama" ) ) {
	function llama( $person, $cookie_jar, $password, $username, $relaunch = FALSE ){	// Alright, updating, we don't want a file now. We just want to check the response.
		global $config, $dAmn;										// Right here, if we were provided a username to send a llama to, we'll be going to their page.
		if( isset( $person ) ) {
			$out = $person;																// If we have $out, we don't want llama launching again. 
		}
		if( $relaunch ) {
			echo "Relaunch is successful. \n";
		}
		( empty( $out ) ) ? $page = "http://www.deviantart.com/random/deviant" : $page = "http://{$out}.deviantart.com";
		$devpage = @file_get_contents( $page );											// We're going somewhere here. 
		if( empty( $person ) ){
			preg_match( "/gmi-name=\"([0-9a-zA-Z\-]+)\"/Ums", $devpage, $matches );
			$person = $matches[1];														// We don't need to log the llamas now, the file is obnoxious.
		}
		preg_match( "/gmi-gruser_id=\"([0-9]+)\"/Ums", $devpage, $matches );			// We're going to adjust at the end as well to check the response
		$dev = $matches[1];																// to see if we've sent a llama to $person.
		$llamapage = $dAmn->send_headers(												// Let's spoof the first time so we can grab the required IDs. 
			fsockopen( "ssl://www.deviantart.com", 443 ),
			"www.deviantart.com",
			"/modal/badge/give?badgetype=llama",
			"https://www.deviantart.com",
			"&to_user={$dev}&trade_id=0&referrer=" . urlencode( "http://{$person}.deviantart.com/" ),
			$cookie_jar
		);																				// Now, let's match that info. 
		preg_match( "/name=\"validate_token\" value=\"([0-9a-zA-Z\W\- ]+)\"/Ums", $llamapage, $matches3 );
		preg_match( "/name=\"validate_key\" value=\"([0-9a-zA-Z\W\- ]+)\"/Ums"  , $llamapage, $matches4 );
		$vToken = $matches3[1];
		$vKey   = $matches4[1];															// Setting up our header for actually sending the badge..
		$toSend = 'subdomain=www&referrer=&quantity=1&userpass='.$password.'&tos=1&_toggle_tos=0&password_remembered=1&_toggle_password_remembered=0&badgetype=llama&to_user='.$dev.="&quantity=1&trade_id=0&validate_token=".$vToken."&validate_key=".$vKey."&referrer=" . urlencode( "http://{$person}.deviantart.com/" );
		$e = $dAmn->send_headers(
			fsockopen( "ssl://www.deviantart.com", 443 ),
			"www.deviantart.com",
			"/modal/badge/process_trade",
			"https://www.deviantart.com",
			$toSend,
			$cookie_jar
		);
		$checker = "/\<li class=\"field_error\" rel=\"quantity\"\>You cannot give any more llama badges to/Ums";
		if( preg_match_all( $checker, $e, $matches ) !== 0 ) { 
			if( empty( $out ) ) {
				echo "Oh shit, we've sent a llama to them before. Let's try again.\n";
				return llama( NULL, $cookie_jar, $password, $username, TRUE );				// We want this to launch again, thank you. 
			} else {
				return "{$username} has already sent {$person} a llama."; 				// We don't want this to keep launching. 
			}
		}	// You have sent a llama, congratulations.
	}
}
?>	