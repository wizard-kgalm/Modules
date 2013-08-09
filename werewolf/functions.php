<?php
function autorole() {
	global $config, $dAmn, $Timer;
	$backroom 	 = $config->df['werewolf']['backroom'];					// Let's get this shit loaded. Werewolf is a fucking monster to code for. 
	$hunter   	 = $config->df['werewolf']['sp']['hunter'];					// Hunter. He takes someone down with him in death.
	$cupid    	 = $config->df['werewolf']['sp']['cupid'];				// Cupid. Selects our lovers, who, if either die, the other goes with them.
	$defender 	 = $config->df['werewolf']['sp']['defender'];			// Defender. They have the ability to protect a person from the wolves.
	$gm       	 = $config->df['werewolf']['gamemaster'];				// GameMaster. The R-R-R-Ring leader. :awwyee: They control the game.
	$vidiot		 = $config->df['werewolf']['sp']['villageidiot'];		// Village Idiot wants to get killed. He dies, that's game.
	$harlot		 = $config->df['werewolf']['sp']['harlot'];				// Harlot is the same as the Defender, but instead sleeps with someone to protect them.
	$jester		 = $config->df['werewolf']['sp']['jester'];				// Jester. They're capable of switching two people's roles. HAVOC WILL ENSUE.
	$check    	 = $config->df['werewolf']['roles'];					// This is the list for active roles to be assigned. 
	$check2   	 = $config->df['werewolf']['wolves'];					// This is the list for the wolves.
	$pcnt     	 = $config->df['werewolf']['count'];					// This counts the players so we know how many wolves to have.
	$players	 = $config->df['werewolf']['notassigned'];				// Let's pull up the players here. 
	$assignments = array('oracle', 'witch',);							// Our game default assignments. There are always a single oracle and witch.
	
	if( $pcnt > 04 && $pcnt <= 10 ){									// More than four, but less than ten players, we get two wolves.
		$wolfc = 2;
	}	
	if( $pcnt > 10 && $pcnt <= 14 ){									// More than ten, but less than 14 players, we get three wolves.
		$wolfc = 3;
	}
	if( $pcnt > 14 && $pcnt <= 18 ){									// More than fourteen, less than eighteen, we get four wolves. ( GOOD GOD, EIGHTEEN PLAYERS? )
		$wolfc = 4;
	}
	if( $pcnt > 16 && $pcnt <= 24 ){									// More than sixteen, less than twenty-four players  gets five wolves.
		$wolfc = 5;														
	}
	if( $pcnt > 24 ) {													// 24+ players? HA, That'll be the fucking day. This game's going on forever.
		$wolfc = 5
	}
	if( $hunter ){
		$assignments[] = 'hunter';
	}
	if( $cupid ){
		$assignments[] = 'cupid';
	}
	if( $defender ){
		$assignments[] = 'defender';
	}
	if( $harlot ){
		$assignments[] = 'harlot';
	}
	if( $jester ){
		$assignments[] = 'jester';
	}
	if( $vidiot ){
		$assignments[] = 'vidiot';
	}
	
	foreach( $assignments as $num => $assign ){							// Our special ( non-townie ) roles will be assigned here.
		$player = $config->df['werewolf']['notassigned'][array_rand( $config->df['werewolf']['notassigned'] )];	// We need the players randomized here, inside the loop.
		if( !isset( $check[$player] ) ){								// Let's double check, we don't want multiple roles per player.
			$config->df['werewolf']['roles'][$player]     = $assign;
			$config->df['werewolf'][$assign]              = strtolower( $player );
			//$config->df['werewolf']['learnrole'][$player] = TRUE;
			unset( $config->df['werewolf']['notassigned'][$player] );	// Remove our player from the list.. 
			$config->df['werewolf']['tcount']++;
			note_role( $player );
			$config->df['werewolf']['confirm'][$player] = TRUE;
			$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
			$dAmn->say( "$gm: {$player} is the {$assign}.", $backroom );
		}
	}
		
	for( $i = 0; $i < $wolfc; $i++ ){									// Our werewolves ( Non-special/Non-Townie ) roles done here. This is all that's left.
		if( $config->df['werewolf']['wolves'] < $wolfc ) {
			$player = $config->df['werewolf']['notassigned'][array_rand( $config->df['werewolf']['notassigned'] )];
			if( !isset( $check[$player] ) ) {
				$config->df['werewolf']['roles'][$player] = 'werewolf';
				$config->df['werewolf']['wolves']++;					// The werewolf count, or $wolfc, needs to be jumped up.
				$config->df['werewolf']['wolf'][$player] = $player;
				unset( $config->df['werewolf']['notassigned'][$player] );
				//$config->df['werewolf']['learnrole'][$player] = TRUE;	// LearnRole so that it says what you are upon joining the room. Sets to FALSE afterwards.
				note_role( $player );
				$config->df['werewolf']['confirm'][$player] = TRUE;
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
				$dAmn->say( "$gm: {$player} is a werewolf.", $backroom ); // If everything works out, the most you should see on a usual game is two. 
			}
		}
	}
	
	foreach( $config->df['werewolf']['notassigned'] as $num => $player ){	// Whoever is left becomes a townie.
		if( !isset( $config->df['werewolf']['roles'][$player] ) ){			// Baggage check. Let's make sure they haven't gotten a role already, we don't want fuckups. 
			if( $config->df['werewolf']['wolves'] == $wolfc ){
				$config->df['werewolf']['roles'][$player]     = 'townie';
				$config->df['werewolf']['townies'][$player]   = $player;
				//$config->df['werewolf']['learnrole'][$player] = TRUE;
				$config->df['werewolf']['tcount']++;
				note_role( $player );
				$config->df['werewolf']['confirm'][$player] = TRUE;
				$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
				$dAmn->say( "$gm: {$player} is a townie.", $backroom );
			}
		}
	}
	$dAmn->say( "$gm: All the players have been assigned, tell them to check their notes, and then use {$tr}confirm.", $backroom );
}

function end_game( ){
	global $dAmn, $config;
	$gameroom = $config->df['werewolf']['gameroom'];
	$backroom = $config->df['werewolf']['backroom'];
	$pclass  = array( "Werewolves", "Townies", "Players", "Dead", "GameMaster", "Harlot", "VillageIdiot", "Jester", "Hunter", "Townies", "GameMaster", "Oracle", "Defender", "Cupid" );
	foreach ( $pclass as $cs ) {
		$dAmn->admin( "move users $cs to Audience", $gameroom );
		$dAmn->admin( "move users $cs to Audience", $backroom );
	}
	unset( $config->df['werewolf']['players']    );
	unset( $config->df['werewolf']['gamemaster'] );
	unset( $config->df['werewolf']['roles']      );
	unset( $config->df['werewolf']['assigned']   );
	unset( $config->df['werewolf']['witchz']     );
	unset( $config->df['werewolf']['oraclez']    );
	unset( $config->df['werewolf']['wolves']     );
	unset( $config->df['werewolf']['wolfkill']   );
	unset( $config->df['werewolf']['witchkills'] );
	unset( $config->df['werewolf']['witchkill']  );
	unset( $config->df['werewolf']['count']      );
	unset( $config->df['werewolf']['lovers']     );
	unset( $config->df['werewolf']['hunter']     );
	unset( $config->df['werewolf']['defender']   );
	unset( $config->df['werewolf']['vidiot']     );
	unset( $config->df['werewolf']['harlot']     );
	unset( $config->df['werewolf']['townies']    );
	unset( $config->df['werewolf']['wolf']       );
	unset( $config->df['werewolf']['jester']     );
	unset( $config->df['werewolf']['cupid']      );
	unset( $config->df['werewolf']['dead']       );
	unset( $config->df['werewolf']['seen']       );
	unset( $config->df['werewolf']['canend']     );
	unset( $config->df['werewolf']['learnrole']  );
	unset( $config->df['werewolf']['round']      );
	unset( $config->df['werewolf']['status']     );
	unset( $config->df['werewolf']['turn']       );
	unset( $config->df['werewolf']['muted']      );
	unset( $config->df['werewolf']['day']        );
	unset( $config->df['werewolf']['changed']    );
	$config->save_config( "./config/werewolf.df", $config->df['werewolf'] );
}
function note_role( $player ) {											// We're going to send each player their role via note!
	global $config, $dAmn;
	$username = "Werewolf-Bot";
	$password = base64_decode( $config->df['logins']['werewolf-bot'] );
	if( isset( $config->df['cookiejar']['werewolf-bot'] ) ) {
		$cookie = $config->df['cookiejar']['werewolf-bot'];				// Let's test that cookie.
		$response = $dAmn->send_headers( fsockopen( "tcp://www.deviantart.com", 80), "www.deviantart.com", "/", "", "", $cookie );
		$response = explode( "\r\n", $response );						// Let's check the response for the same cookie.
		$cookie_jar = array();
		foreach( $response as $line ) { 
			if( strpos( $line, "Set-Cookie:" ) !== FALSE ) {
				$cookie_jar[] = substr( $line, 12, strpos( $line, "; " ) -12 );
			}
		}
		$taco = explode( ";", urldecode( $cookie_jar[0] ) );
		if( stristr( $taco[1], "\"username\":\"\"" ) ) {
			echo "That session ended, let's grab a new one. \n";
			$cookie = NULL;
		} else {
			$cookie = $cookie_jar;
		}
	}
	if( $cookie === NULL || empty( $cookie ) ) {
		$cookie = $dAmn->getCookie( $username, $password );
		$config->df['cookiejar'][strtolower( $username )] = $cookie_jar;
		$config->save_info( "./config/cookiejar.df", $config->df['cookiejar'] );
	}
	$devpage = file_get_contents( "http://{$player}.deviantar.com" );
	preg_match( "/gmi-gruser_id=\"(.*)\"/Ums", $devpage, $matches );
	$dev = $matches[1];
	$note = $dAmn->send_headers(
		fsockopen( "ssl://www.deviantart.com", 443 ),
		"www.deviantart.com",
		"/global/notes/form.php?to_user={$dev}&referrer=". urlencode( "http://{$player}.deviantart.com" ),
		"http://www.deviantart.com/",
		"",
		$cookie
	);
	$body = "{$player}, you have been selected as {$config->df['werewolf']['roles'][$player]}. Enjoy this exciting round of Werewolf!";
	$post = scrape( $note, $player, $body );
	$fnote = $dAmn->send_headers(
		fsockopen( "ssl://www.deviantart.com", 443 ),
		"www.deviantart.com",
		$post['url'],
		"http://www.deviantart.com/",
		$post['post'],
		$cookie
	);
}
function note_players( $player1, $player2, $type = FALSE ) {			// We're going to send the selected players their notes.
	global $config, $dAmn;												// For this, we'll be sending the notes from the bot's account.
	$username = "Werewolf-Bot";
	$password = base64_decode( $config->df['logins']['werewolf-bot'] );
	if( isset( $config->df['cookiejar']['werewolf-bot'] ) ) {
		$cookie = $config->df['cookiejar']['werewolf-bot'];				// Let's test that cookie.
		$response = $dAmn->send_headers( fsockopen( "tcp://www.deviantart.com", 80), "www.deviantart.com", "/", "", "", $cookie );
		$response = explode( "\r\n", $response );						// Let's check the response for the same cookie.
		$cookie_jar = array();
		foreach( $response as $line ) { 
			if( strpos( $line, "Set-Cookie:" ) !== FALSE ) {
				$cookie_jar[] = substr( $line, 12, strpos( $line, "; " ) -12 );
			}
		}
		$taco = explode( ";", urldecode( $cookie_jar[0] ) );
		if( stristr( $taco[1], "\"username\":\"\"" ) ) {
			echo "That session ended, let's grab a new one. \n";
			$cookie = NULL;
		} else {
			$cookie = $cookie_jar;
		}
	}
	if( $cookie === NULL || empty( $cookie ) ) {
		$cookie = $dAmn->getCookie( $username, $password );
		$config->df['cookiejar'][strtolower( $username )] = $cookie_jar;
		$config->save_info( "./config/cookiejar.df", $config->df['cookiejar'] );
	}
	$devpage = file_get_contents( "http://{$player1}.deviantart.com/" );	// We need to get the user IDs. 
	preg_match( "/gmi-gruser_id=\"(.*)\"/Ums", $devpage, $matches );
	$dev = $matches[1];
	$devpage2 = file_get_contents( "http://{$player2}.deviantart.com/" );
	preg_match( "/gmi-gruser_id=\"(.*)\"/Ums", $devpage2, $matches2 );
	$dev2 = $matches2[1];
	$note1 = $dAmn->send_headers(
		fsockopen( "ssl://www.deviantart.com", 443 ),
		"www.deviantart.com",
		"/global/notes/form.php?to_user={$dev}&referrer=". urlencode( "http://{$player1}.deviantart.com" ),
		"http://www.deviantart.com/",
		"",
		$cookie
	);
	$note2 = $dAmn->send_headers(
		fsockopen( "ssl://www.deviantart.com", 443 ),
		"www.deviantart.com",
		"/global/notes/form.php?to_user={$dev2}&referrer=" . urlencode( "http://{$player2}.deviantart.com" ),
		"http://www.deviantart.com/",
		"",
		$cookie
	);
	switch ( $type ) {
		case "lovers":
			$body1 = "You, along with {$player2} have been selected as lovers by your very own Cupid! Please enjoy this exciting round of Werewolf.";
			$body2 = "You, along with {$player1} have been selected as lovers by your very own Cupid! Please enjoy this exciting round of Werewolf.";
		break;
		case "jester":
			$body1 = "Your role has been swapped by the ever-so-hilarious Jester! You are now {$config->df['werewolf']['roles'][$player2]}.";
			$body2 = "Your role has been swapped by the ever-so-hilarious Jester! You are now {$config->df['werewolf']['roles'][$player1]}.";
		break;
	}
	$post1 = scrape( $note1, $player1, $body1 );
	$post2 = scrape( $note2, $player2, $body2 );
	$fnote1 = $dAmn->send_headers(
		fsockopen( "ssl://www.deviantart.com", 443 ),
		"www.deviantart.com",
		$post1['url'],
		"http://www.deviantart.com/",
		$post1['post'],
		$cookie
	);
	$fnote2 = $dAmn->send_headers(
		fsockopen( "ssl://www.deviantart.com", 443 ),
		"www.deviantart.com",
		$post2['url'],
		"http://www.deviantart.com/",
		$post2['post'],
		$cookie
	);
}
	
function scrape( $page, $person, $body = FALSE ) {
	preg_match( "/name=\"validate_token\" value=\"(.*)\"/Ums", $page, $matches3 );
	preg_match( "/name=\"validate_key\" value=\"(.*)\"/Ums"  , $page, $matches4 );
	preg_match( "/class=\"b\" for=\"(.*)\">/Ums"             , $page, $matches2 ); // We need to find the weird hex key that generates dynamically on each note page.
	$skey = substr( $matches2[1], 0, 20 );
	$vToken = $matches3[1];
	$vKey = $matches4[1];
	preg_match( "/<style type=\"text\/css\">(.*)<\/style>/Ums", $page, $matches5 );
	$ON = explode( "#l_", $matches5[1] );
	foreach( $ON as $clump => $ONN ){
		if( $ON[0] !== $ONN ){
			if( !stristr( $ONN, "{display:none}" ) ){
				$ONS .= "&" . substr( $ONN, 0, 20 ) . "={$person}";
			}else{
				$ONS .= "&" . substr( $ONN, 0, 20 ) . "=";
			}
		}
	}
	$subject = "Werewolf Note!";
	//$body    = "You, along with {$person2} have been selected as lovers by your very own Cupid! Please enjoy this exciting round of Werewolf.";
	$devpage = file_get_contents( "http://{$person}.deviantart.com/" );
	preg_match( "/gmi-gruser_id=\"(.*)\"/Ums", $devpage, $matches );
	$dev          = $matches[1];
	$notepage     = urlencode( "http://www.deviantart.com/global/notes/form.php?to_user={$dev}&referrer=" ) . urlencode( "http://{$person}.deviantart.com" );
	$post['url']  = "/global/notes/send.php?{$vKey}#send-note";
	$post['post'] = "validate_token={$vToken}&validate_key={$vKey}&recipients=&ref={$notepage}&parentid=0&referrer=" . urlencode( "http://{$person}.deviantart.com" ) . "{$ONS}&friends=&{$skey}={$subject}&body={$body}";
	return $post;
}
?>