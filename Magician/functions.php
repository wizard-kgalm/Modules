<?php
		function token(){ 																// First of all, this is just as bad as the token grabber that was originally in Dante.
		internalMessage( "Getting authtoken..." );
		global $event,$config;															// I'm fairly certain events shouldn't be called upon for this.
		$UN=$config['token']['username']; $UP=$config['token']['password'];				// This is so ass backwards, I'm almost in tears at how round about I used to be.
		$query = "ref=https%3A%2F%2Fwww.deviantart.com%2Fusers%2Flogin&username=" . $UN . "&password=" . $UP . "&reusetoken=1";

		$a = fsockopen( "ssl://www.deviantart.com", 443, $errno, $errstr );				// Looking at this, I can see this would still actually work today, but only for the cookie.

		fputs( $a, "POST /users/login HTTP/1.1\n" );									// This isn't needed, as we have $dAmn->send_headers covering this bit.
		fputs( $a, "Host: www.deviantart.com\n" );
		fputs( $a, "User-Agent: " . BotUserAgent . "\n" );
		fputs( $a, "Accept: text/html\n" );
		fputs( $a, "Cookie: skipintro=1\n" );
		fputs( $a, "Content-Type: application/x-www-form-urlencoded\n" );
		fputs( $a, "Content-Length: " . strlen( $query ) . "\n\n" . $query );

		$response = "";
		while( !feof( $a ) ) $response .= fgets( $a, 8192 );
		fclose( $a );

		if( !empty( $response ) ) {
			$full1 = explode( "Set-Cookie: ", $response );
			$full1 = explode( ";", $full1[1] );
			$fullcookie = $full1[0] . ';';
			$response = urldecode( $response );

			if( stristr( $response, "Set-Cookie: " ) && stristr( $response, "authtoken" ) ) {	// Tokens no longer included directly in your cookie, it allowed circumventing bans.
				$bits = explode( "userinfo=", $response );
				$cookie = substr( $bits[1], 0, strpos( $bits[1], "; expir" ) );
				$cookie = unserialize( $cookie );
				if( !empty( $cookie['authtoken'] ) ){										// lol this would be so much easier if that were the case.
					$config['token']['token']=$cookie['authtoken']; save_config('token');
					$config['bot']['token']=$cookie['authtoken']; save_config('bot');
					internalMessage( "Authtoken: " . $cookie['authtoken'] );
					$event = "authtoken";
					include f( "system/callables/event.php" );
					return $cookie['authtoken'];
					$config['bot']['token']=$cookie['authtoken']; save_config('bot');break;
				 }else{
					internalMessage( "Oops, couldn't get the authtoken. You may need to find it yourself." );$login = parse_ini_file( f( "config.ini" ) );$config['token']['password']=$login['password'];$config['token']['username']=$login['username'];save_config('token');$config['bot']['username']=$login['username'];$config['bot']['token']=token();save_config('bot');$event = "authtoken-fail";					// Oh my god, this is so beyond sloppy. All that shit jumbled up on a SINGLE LINE? 
					include f( "system/callables/event.php" );
					return FALSE;
				}
			} else {
				internalMessage( "Oops, couldn't get the authtoken. You may need to find it yourself." );$login = parse_ini_file( f( "config.ini" ) );$config['token']['password']=$login['password'];$config['token']['username']=$login['username'];save_config('token');$config['bot']['username']=$login['username'];$config['token']['token']=token();save_config('bot');$event = "authtoken-fail";							// LET'S COPY PASTE IT AGAIN!
					include f( "system/callables/event.php" );
					return FALSE;
			}
		} else {
			internalMessage( "Oops, couldn't get the authtoken. You may need to find it yourself." );$login = parse_ini_file( f( "config.ini" ) );$config['token']['password']=$login['password'];$config['token']['username']=$login['username'];save_config('token');$config['bot']['username']=$login['username'];$config['bot']['token']=token();save_config('bot');$event = "authtoken-fail";												// ROUND THREE. I like how it's basically the core's token grabber.
					include f( "system/callables/event.php" );
					return FALSE;
		}break;
	
}

?>	