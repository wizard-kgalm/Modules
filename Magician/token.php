<?php
include_once('modules/Magician/functions.php');
switch( $args[0] ){
	case "login":
	case "token":
	case "ui":
		if( empty( $args[1] ) ){
			return $dAmn->say( "$from: Usage:{$tr}{$args[0]} <i>username [password]</i>. If the username is on the list, it'll try using the password. Otherwise, it'll ask for the password.", $c );
		}
		if( !$user->has( $from, 99 ) ) {												// Don't want random people changing the bot's login, in case the privs were lowered.
			return $dAmn->say( "$from: This is an owner-only command.", $c );			
		}
		$tuser = strtolower( $args[1] );
		if( isset( $config->logins['login'][strtolower( $args[1] )] ) ){				// Is our username on the list? Let's check.
			$tpass = base64_decode( $config->logins['login'][strtolower( $args[1] )] );	// The passwords are encoded.. let's decode the one we'll be using.
		}elseif( isset( $config->logins['hidden'][strtolower( $args[1] )] ) ){			// Perhaps our username isn't on that list. Let's check the secondary one.	
			$tpass = base64_decode( $config->logins['hidden'][strtolower( $args[1] )] );// The passwords are encoded.. let's decode the one we'll be using. 			
		}elseif( !empty($args[2] ) ){													// It's not on either list? If there's a second arg, we'll use that.
			$tpass = $args[2];
		}elseif( empty( $tpass ) ){														// No password. Cannot continue.
			return $dAmn->say("$from: $args[1] is not a stored login. Username and password required for non-stored logins.",$c);
		}																				
		( $args[0] == "ui" ) ? $token = FALSE : $token = TRUE;							// For our userinfo, we only want the cookie. This is for difi calls.
		$tcheck = $dAmn->getCookie( $tuser, $tpass, $token );							// Now for the token grabber. Let's send the username and password.
		if( is_array( $tcheck ) && isset( $tcheck['error'] ) ){							// We got an array. We'll return what went wrong.
			return $dAmn->say("$from: Error returned. {$tcheck['error']}",$c);
		}
		if( $args[0] == "login" ){														// Success! We got an authtoken. Mission accomplished.	
			$config->bot['username'] = $args[1];										// We're gonna change the bot's config info now.
			$config->bot['token']    = $tcheck;
			$config->save_info( "./config/bot.df", $config->bot );
			$dAmn->say( "$from: Login accepted. Changing logins, please wait.", $c );	// Let's send the disconnect and log into the new account!
			$dAmn->send( "disconnect\n".chr( 0 ) );
		} elseif( $args[0] == "ui" ) {
			$cookie = explode( "userinfo=", $tcheck[3] );
			$cookie = $cookie[1];
			$dAmn->say( "ui={$cookie}", $c );
		} else {
			$dAmn->say( "$from: javascript: dAmn_Login(\"{$args[1]}\",\"{$tcheck}\");", $c ); // For token, we're just gonna send the javascript command to the requester.
		}
	break;
	case "atswap":
		if( empty( $argsF ) ){
			return $dAmn->say( "$from: Please put your username and authtoken to change logins. If you don't know what an authtoken is, don't use this command.", $c );
		}elseif( empty( $args[2] ) ){
			return $dAmn->say( "$from: Username and authtoken required. To login with a password, see {$tr}login. Caution: Do not use in public rooms as this is sensitive info.", $c );
		}
		if( strlen( $args[2] ) !== 32 ){ 												// Safeguard to prevent bot killing..
			return $dAmn->say( "$from: The authtoken must be 32 characters. Try again. If you don't know what one is, don't use this command.", $c );
		}
		$config->bot['username'] = $args[1];											// Now to setup for the account switch.. 
		$config->bot['token']    = $args[2];
		$config->save_info( "./config/bot.df", $config->bot );
		$dAmn->say( "$from: Token accepted. Changing logins, please wait.", $c );		// Now for the disconnect.
		$dAmn->send( "disconnect\n".chr( 0 ) );
	break;
}