<?php
   /*
    *   Magician extension for contra
    *   
    *   these are all of the commands from the Magician module for Dante, with quite a few others.. :P!
    *   programmed by http://wizard-kgalm.deviantart.com
    *   
    *   most should be self explanitory.
    */
    
class dAmn_Magician extends extension {

    public $name = 'Skittles';
    public $version = '4.0';
    public $about = 'A rainbow of commands! (Ported from Magician for Dante) ';
    public $status = true;
    public $author = 'Wizard-Kgalm';
    public $type = EXT_CUSTOM;
	public $Events;
    function init() {
		// COMMANDS ARE BELOW HERE.						// BRIEF INFO ON THE COMMANDS COMMENTED BELOW HERE. (lol I just like spamming comments in my own modules now ).
		$this->addCmd( 'shank'  , 'c_shank'    , 0  );	// $shank. A Magician Original. This one helped me make sure I knew Contra's function system so I could write this.
		$this->addCmd( 'google' , 'c_google'   , 0  );	// $google is just here so that contra has the ability to do so as well. 
		$this->addCmd( 'llama'  , 'c_llama'    , 0  );	// $llama. Send a specified user a llama from a specified user on your $logins list.
		$this->addCmd( 'rllama' , 'c_llama'    , 0  );	// $rllama. Random llama. Send a llama to a random deviant!
		$this->addCmd( 'rspama' , 'c_llama'    , 99 );	// $rspama. Spam up to 77 llamas to 77 random deviants from one account.
		$this->addCmd( 'logins' , 'c_logins'   , 99 );	// $logins. Your storage for all of your accounts on the bot. 
		$this->addCmd( 'token'  , 'c_token'    , 99 );	// $token. Grabs the authtoken for an account. No password needed for stored ones. 
		$this->addCmd( 'login'  , 'c_token'    , 99 );	// $login. Changes logins on the bot to the provided one. No password needed for stored ones.
		$this->addCmd( 'symbols', 'c_symbols'  , 99 );	// $symbols. Turns on symbols so your bot speaks with chosen symbols from the charmap.
		$this->addCmd( 'r'      , 'c_cock'     , 99 );	// $r. Rape. Rape a chatroom! Might remove this one later. lol
		$this->addCmd( 'input'  , 'c_input'    , 99 );	// $input. Allows use of an input window so you may talk directly from the bot.
		$this->addCmd( 'bzikes' , 'c_bZikes'   , 75 );	// $bzikes. Gives the bot use of the zikes emote database. ( So messages may be converted from the input window ).
		$this->addCmd( 'me'     , 'c_me'       , 75 );	// $me. Fast access to /me actions for the input window.
		$this->addCmd( 'npmsg'  , 'c_npmsg'    , 75 );	// $npmsg. Same as holding shift. Sends a non-parsed message.
		$this->addCmd( 'colors' , 'c_colors'   , 25 );	// $colors. Check the dAmnColors database for the colors of a specific user (or set your own). No one uses anymore.
		$this->addCmd( 'shout'  , 'c_shout'    , 25 );	// $shout. RECORDS MESSAGES IN ALL CAPS. When activated, picks a random one to respond to users shouting with.
		$this->addCmd( 'shouts' , 'c_shouts'   , 25 );	// $shouts. Find a previously shouted message, and get its details. 
		
		// EVENTS ARE BELOW HERE.
		$this->hook('shout_msg', 'recv_msg');
		$this->hook('shout_msg', 'recv_action');	
		$this->switch_input();
		$this->hook('e_input', 'loop');
		$tr = $this->Bot->trigger;
		
		// HELPS ARE BELOW HERE.
		$this->cmdHelp('llama', "{$tr}llama [username] {user2} where username is a specified dA username. This sends the specified username a llama. {user2} is an optional parameter. If specified, the bot will try to send the username a llama from that dA account instead of the bot's.");
		$this->cmdHelp('rllama', "{$tr}rllama {user} Sends a llama to a random user. {user} is an optional parameter. If specified, the bot will try to send a llama from that dA account instead of the bot's. ");
		$this->cmdHelp('rspama', "{$tr}rspama # {user} Sends llamas to either a specified number of random deviants or 50. If you provide a number and {user} it'll try and send those random people llamas from that account.");
	
		$this->cmdHelp('shout', 'Shout records everything that users in the chatrooms the bot is in yells in all caps. IF it\'s 3 words or longer, it records it to the list. '.$tr.'shout on/off turns the response on and off. If on, when someone yells something in all caps, it will shout back at the person who yelled.');
		
		$this->cmdHelp('shouts', 'This command is used to display everything a certain user has shouted, if they\'ve shouted anything. '.$tr.'shouts find <i>[SHOUT]</i>, will look up the info of the specified shout, such as who yelled it, and the date.');

		$this->cmdHelp('shank', 'Shank is a joke command. It shanks either the username provided if given, or it shanks the person who used the command.<b> '.$tr.'shank <i>username</i></b>.');
		
		$this->cmdHelp('logins', 'logins uses a username/password combo to store logins to a file so that they can be used for token, cookie, and/or login.<sup><br><b> '.$tr.'logins add <i>username (password)</i></b> Leave the password blank to input into the bot window. <br><b> '.$tr.'logins del <i>username</i></b>.<br><b> '.$tr.'logins list</b> (either type list or leave blank and it\'ll display a list as well).');
		
		$this->cmdHelp('token', 'token uses either a username/password combo, or it can use one of the stored logins to return a token for that account. <sup><b><br>'.$tr.'token <i>username (password)</i></b> Leave the password blank to input into the bot window.');
		
		$this->cmdHelp('me', 'Use /me in the input window for actions.');
		
		$this->cmdHelp('npmsg', 'Use /npmsg in the input window as the same thing as holding shift when you hit enter.');
		
		$this->cmdHelp('login', 'login uses either a username/password combo, or it can use one of the stored logins to change to that account. <sup><b><br>'.$tr.'login <i>username (password)</i> Leave the password blank to input into the bot window. It will login to the account provided.');
		
		$this->cmdHelp('sexy', 'Sexy is a speech module. It responds with a sentence from a list of \'sexy\' responses, to a list of users that you make by adding people with suser add. To use it, just type <b><i>'.$tr.'sexy on/off</i></b>.');
		
		$this->cmdHelp('bzikes', 'bZikes is the implementing of Zikes on PHP bots, so that their inputs can take advantage of the Zikes emotes. It is customizable. To toggle whether or not it\'s on and being used by input, type <b>'.$tr.'bzikes on/off</b><sup><br><b>'.$tr.'bzikes refresh</b> Tells the bot to check the list and download the list again. You can use this to keep it up to date if you know emotes have been added to the public list.<br><b>'.$tr.'bzikes check <i>:code:</i></b> checks the list of emotes for one using that code.</sup>');
		
		$this->cmdHelp('input', 'Input is the ability to control the bot from another cmd Prompt window, without the OWNER actually needing to be on dAmn. To enable it, type '.$tr.'input on/off. The prompt that allows input was provided. When using the window, type lt; for <, gt; for >, %v for |, and %a for &. If you\'re just using say, type the room you want the bot to talk in first, then your message. You don\'t need to include the room in the message unless you\'re changing what room the bot is talking in. To use another command, type "/ [cmd name] [other]".');
		
		$this->cmdHelp('spell', 'Spell is the same as the Dante command. To use, just type '.$tr.'spell <i>word</i>.');
		
		$this->cmdHelp('colors', 'Colors checks the dAmn colors list for the colors of the provided user. It can also set/change colors or create a dAmnColors account.<sup><br><b>'.$tr.'colors (check) <i>username</i></b> checks the colors of the provided user. The check parameter is optional.<br><b>'.$tr.'colors change/set <i>username password color1 color2</i></b> Changes the colors of the username given. The password is your dAmnColors Password, not your dA. If you leave the password, color1, and color2 blank, you can do the rest in the bot window. You can include the password and just do the colors from the window, and you can leave only the second color blank and put in to the window. You must provide 2 colors, and one must be different than the ones you already have.');
	
		if( file_exists( "./storage/bzikes.cf" ) ){										// No more logins conversions.. No one could possibly have that version.
			$ef = include "./stroage/bzikes.cf";
		}
		if( empty( $ef ) ) {
			$newfile = unserialize( file_get_contents( 'http://www.thezikes.org/publicemotes.php?format=php&ip=12.234.156.78' ) );
			foreach( $newfile as $code => $emotes ) {									// Now to sort the list down. 
				$ef['bzikes'][$code] = $emotes['devid'];
			}
			$stat['status'] = TRUE;														// Automatic start up. Should always be on.
			save_config( "./storage/bzikes.cf", $ef['bzikes'] );
			save_config( "./storage/bzikes2.cf", $stat );			
		}
	}
	
	function c_llama( $ns, $from, $message, $target ) {									// Sweet llama command. Should almost mirror Magician when I'm done.
		$person  = args( $message, 1 );	// $person is our target. Who we'll be sending the llama to.
		$loops   = args( $message, 1 );	// $loops is for $rspama. The number of loops we'll attempt.
		$com     = args( $message, 0 );	// $com is obviously the command. 
		$person2 = args( $message, 2 );	// $person2 is the person sending the llama. We'll be working this out below. :D
		$tr      = $this->Bot->trigger;
		if( !empty( $person2 ) ){
			$person2 = strtolower( $person2 );											// Always strtolower. Always.
		}
		switch ( $com ) {
			case "llama":
			case "rspama": 
				if( empty( $person2 ) ) {												// This is very convoluted. lol 
					( $com != "rspama" ) ? $person2 = strtolower( $this->bot->username ) : ( ( is_numeric( $loops ) ) ? $person2 = strtolower( $this->bot->username ) : $person2 = strtolower( $loops ) );
				}
				if( $com == "rspama" ) {
					if( is_numeric( $loops ) ){
						( $loops >= 77 ) ? $loops = 77 : $loops = $loops;
					}
				} $llu = substr( $person2, 0, 3 ) ."llama";								// We want our llama file so we can check for previously sent llamas.
				if( $com == "llama" && file_exists( "./storage/{$llu}.cf" ) ) {
					$check = include "./storage/{$llu}.cf";
					if( isset( $check[$person2][$person] ) ) {
						return $this->dAmn->say( $ns, "$from: {$person2} cannot send any more llamas to {$person}" );
					}
				}							
			break;
			case "rllama":
				( isset( $person ) ) ? $person2 = strtolower( $person ) : $person2 = strtolower( $this->bot->username );
			break;
		}																				// Now that we straightened all of that out.. let's check the logins.
		if( file_exists( "./storage/logins.cf" ) ) {
			$logins = include "./storage/logins.cf";
		}
		if( file_exists( "./storage/session.cf" ) ) {									// This is where we store our cookie from the previous run. 
			$reuse = include "./storage/session.cf";									// We want this so the bot isn't logging in hundreds of times
		}																				// Just to send llamas (or do anything else cookie related ).
		if( !empty( $logins ) ) {														// Because you might not have one, we need this checkpoint.
			if( isset( $logins['login'][$person2] ) ){									// Let's set these variables here for the cookie grabbing.
				$username = $person2;
				$password = base64_decode( $logins['login'][$person2] );
			}
			if( empty( $username ) ){
				if( isset( $logins['login'][strtolower( $this->bot->username ) ] ) ) {
					$username = strtolower( $this->bot->username );
					$password = base64_decode( $logins['login'][strtolower( $this->bot->username ) ] ); 
					echo "We couldn't find that name on the list. Switching to bot's account.\n";
				} else {
					return $this->dAmn->say( $ns, "$from: {$person[2]} is not a stored login. In order to use llama, you must set up the logins list and store the accounts." );
				}
			}
		}
		if( !empty( $reuse ) ) {														// Here's where we test the former session. 
			if( isset( $reuse['users'][$username] ) ) {
				$cookie_jar = $reuse['users'][$username];								// Set our cookie_jar.
				$response = $this->dAmn->send_headers( fsockopen( "tcp://www.deviantart.com", 80 ), "www.deviantart.com", "/", "", "", $cookie_jar );
				$response = explode( "\r\n", $response );
				$jar2 = array();
				foreach( $response as $line ) { 
					if( strpos( $line, "Set-Cookie:" ) !== FALSE ) {
						$jar2[] = substr( $line, 12, strpos( $line, "; " ) -12 );
					}
				}
				$taco = explode( ";", urldecode( $jar2[0] ) );							// Make sure that the cookie response includes the username.
				if( stristr( $taco[1], "\"username\":\"\"" ) ) {						// If it does, that session ended. We need a new cookie. 
					echo "That session ended, let's grab a new one. \n";
					$cookie_jar = NULL;
				}
			}
		}
		if( empty( $cookie_jar ) || $cookie_jar === NULL ) {							// Our cookie expired. :( Grab a new one!
			$cookie_jar = $this->get_cookie( $username, $password );
			if( isset( $cookie_jar['error'] ) ){
				return $this->dAmn->say( $ns, "$from: {$cookie_jar['error']}" ); 		// Oops, something went wrong. :( 
			}
			$reuse['users'][$username] = $cookie_jar; 									// Let's save that session.
			save_config( "./storage/session.cf", $reuse );
		}																				// We now have our cookie.
		if( $com != "rspama" ) {
			( $com = "llama" ) ? $to = $person : $to = NULL;
			$this->llama( $to, $cookie_jar, $password, $username );						// Let's kick it out to the llama function.
			( empty( $to ) ) ? $say = "Random llama sent as $username!" : $say = "Llama sent to {$args[1]} as $username!";
			$this->dAmn->say( $ns, "$from: {$say}" );
		} else {
			for( $i = 0; $i < $loop; $i++ ) {
				$this->llama( NULL, $cookie_jar, $password, $username );
			}
			$this->dAmn->say( $ns, "$from: {$loop} llamas sent as $username!" );
		}
	} 		// END c_llama. Down to 90 Lines from.. 126. Nice improvement in functionality too. (Exported cookie grabber, imported use of previous cookie).
	
	function llama( $person, $cookie_jar, $password, $username ){	// Here's our llama function. For to be sending badges, we'll need this thing's a-game.
		$tr = $this->Bot->trigger;														// Let's load our shit.. 
		$llu = substr( $username, 0, 3 ) . "llama";										// Personal llama files. Otherwise, a centralized one fills up too quickly.
		if( file_exists( "./storage/{$llu}.cf" ) ) { 
			$file = include "./storage/{$llu}.cf";
		}
		if( isset( $person ) ) {														// We have a recipient lined up. Let's do it, son. 
			$devpage = @file_get_contents( "http://" . strtolower( $person ) . ".deviantart.com/" );	
		} else {																		// We have no recipient. to /random/deviant!
			$devpage = @file_get_contents( 'http://www.deviantart.com/random/deviant' );
			preg_match( "/gmi-name=\"(.*)\"/Ums", $devpage, $matches );					// Look through the page for their username..
			$person = $matches[1];
			if( isset( $file[$llu][$username][strtolower( $person )] ) ) {
				return $this->llama( NULL, $cookie_jar, $password, $username );			// ROUND TWO. Let's keep trying, we want the random llama to go out.
			}
		}																				//ANOTHER UPDATE BROKE THE MODULE. Fixed, v2.0.
		$file[$llu][$username][strtolower( $person )] = date( 'd-m-y', time() ); 		// Our file will be first 3 letters + llama of $username.
		save_info( "./storage/{$llu}.df", $file[$llu] );								// Now, since I've fucked this up so many times.. 
		preg_match( "/gmi-gruser_id=\"(.*)\"/Ums", $devpage, $matches );				// We're going to adjust at the end as well to check the response
		$dev = $matches[1];																// to see if we've sent a llama to $person.
		$llamapage = $this->dAmn->send_headers(											// Let's spoof the first time so we can grab the required IDs. 
			fsockopen( "ssl://www.deviantart.com", 443 ),
			"www.deviantart.com",
			"/modal/badge/give?badgetype=llama",
			"https://www.deviantart.com",
			"&to_user={$dev}&trade_id=0&referrer=" . urlencode( "http://{$person}.deviantart.com/" ),
			$cookie_jar
		);																				// Now, let's match that info. 
		preg_match( "/name=\"validate_token\" value=\"([0-9a-zA-Z\W\- ]+)\"/Ums", $llamapage, $matches3 );
		preg_match( "/name=\"validate_key\" value=\"(.*)\"/Ums"  , $llamapage, $matches4 );
		$vToken = $matches3[1];
		$vKey   = $matches4[1];															// Setting up our header for actually sending the badge..
		$toSend = 'subdomain=www&referrer=&quantity=1&userpass='.$password.'&tos=1&_toggle_tos=0&password_remembered=1&_toggle_password_remembered=0&badgetype=llama&to_user='.$dev.="&quantity=1&trade_id=0&validate_token=".$vToken."&validate_key=".$vKey."&referrer=" . urlencode( "http://{$person}.deviantart.com/" );
		$e = $this->dAmn->send_headers(
			fsockopen( "ssl://www.deviantart.com", 443 ),
			"www.deviantart.com",
			"/modal/badge/process_trade",
			"https://www.deviantart.com",
			$toSend,
			$cookie_jar
		);
		$checker = "/\<li class=\"field_error\" rel=\"quantity\"\>You cannot give any more llama badges to/Ums";
		if( preg_match_all( $checker, $e, $matches ) !== 0 && $person === NULL ) { 
			echo "Oh shit, we've sent a llama to them before. Let's try again.\n";
			return llama( NULL, $cookie_jar, $password, $username );
		}																				// Llama sent, if all of this works. Otherwise, suck a dick, stupid function. lol
	}
} // END llama. 50 lines.

		
	function c_shank( $ns, $from, $message, $target ) {
		$tg = args( $message, 1 );
		$tr = $this->Bot->trigger;
		$shanks = array( ':stab:',':thumb95624834:', ':thumb167346607:', ':thumb155896667:', ':thumb179198418:', ':thumb126635871:', );
		$emote  = array( ' <b>>:C</b>', ' <b>D:<', ' >:&zwj;O', );						// Set up the response list
		$shanking = $shanks[array_rand( $shanks )] . $emote[array_rand( $emote )];	 	// Randomize the response list so it's not just one standard one
		if( empty( $tg ) ){
			return $this->dAmn->say( $ns, "$from: {$shanking}" ); 						// If you don't give someone to shank, it just shanks you instead :D
		} else
		if( in_array( $from, $this->user->list[100] ) ) {
			return $this->dAmn->say( $ns, "{$tg}: {$shanking}" ); 						// You're an owner? Shank away, son. 
		} else 
			if( in_array( $tg, $this->user->list[100] ) ) {
				return $this->dAmn->say( $ns, "$from: {$tg} cannot be shanked! :noes:");//No touchy the owner. :C
			}
			if ( strtolower( $tg ) == strtolower( $this->Bot->username ) ) {
				return $this->dAmn->say($ns, "$from: {$tg} cannot be shanked! :noes:" );// No touchy the bot. :C
			}
		$this->dAmn->say( $ns, "{$tg}: {$shanking}" );									//Shanking time! C:
	}
		
	function c_google( $ns, $from, $message, $target ){
		$wat  = args( $message, 1, true );
		$watt = args( $message, 1 );
		$tr   = $this->Bot->trigger; 
		if( substr( $watt, 0, 1 ) == '#' && is_numeric( str_replace( '#', '', $watt ) ) ) {
			$lim = str_replace( '#', '', $watt );
			if( $lim > 4 ) {
				$lim = 4;
			}
			$quer = str_replace( " ", "+", $watt );
		} else {
			$lim = 3;
			$quer = str_replace( " ", "+", $watt );
		}
		if( $quer ) {
			$url  = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=" . $quer;
			$raw  = file_get_contents( $url );
			$json = json_decode( $raw );
			if( $json->responseStatus == 200){
				$i = 0;
				$say = "<ul>";
				do{
					if( $json->responseData->results[$i]->titleNoFormatting ) {
						$say .= "<li><b><a href=\"" . $json->responseData->results[$i]->url . "\">" . $json->responseData->results[$i]->titleNoFormatting . "</a></b><br/><sub>" . $json->responseData->results[$i]->content . "<br/>" . $json->responseData->results[$i]->visibleUrl. " | <a href=\"" . $json->responseData->results[$i]->cacheUrl . "\">[Cache]</a></sub></li>";
						$i++;
					}
				} while( $i != $lim );
			}else{
				$say = "fail: " . $json->responseDetails;
			}
		} else {
			$say = "$from, I need at least one word to search.";
		}
		$this->dAmn->say( $ns, $say );
	}
	
	function c_logins($ns, $from, $message, $target){
		$action = args($message, 1);
		$user = args($message, 2);
		$pass = args($message, 3);
		$tr = $this->Bot->trigger;
		if( file_exists( "./storage/logins.cf" ) ){
			$logins = include "./storage/logins.cf";
		}
		//So I don't have to type $this->Bot->trigger fifty times. :)
		$tr = $this->Bot->trigger;
		if( empty ($action ) ){
			return $this->dAmn->say( $ns, "$from: Usage {$tr}logins [add/change/del/list/check] [username] [password/confirm].<br><sub>{$tr}logins <i>add/change</i> [username] [password] will first check the login info. If it's correct, it will add [username] to the list of stored accounts. If you use change, it will bypass checking for [username] on the list and update the stored password.<br>{$tr}logins <i>del</i> [username] checks the list for [username] and deletes it.<br>{$tr}logins list displays all the stored accounts. <br>{$tr}logins <i>check</i> [username] <i>confirm</i> checks the list for [username], and responds whether or not it is. If you include <i>confirm</i>, it will instead respond with it's password. Use at your own discretion." );
		}
		switch( $action ){
			//Combining add/change because why does it need to be seperate? They both end up doing the same thing. But add is set up to stop if the name is already on the list.
			case "add":
			case "change":
				if( empty( $user ) || empty( $pass ) ){
					return $this->dAmn->say( $ns, "$from: Usage: {$tr}logins {$action} <i>[username] [password]</i>. This takes [username] and [password] and adds them to the list of accounts stored on the bot, after encoding the password, and checking to make sure the login info is correct. <br>----<br><sub>If using {$tr}logins <i>change</i> [username] [password], you can change the [password] stored for [username]." );
				}
				if( $action == "add" && isset( $logins['login'][strtolower( $user )] ) ){
					return $this->dAmn->say( $ns, "$from: $user is already on the list. <br>----<br><sub>To change {$user}'s info, use <i>{$tr}logins change {$user} {$pass}. To see your current list, use <i>{$tr}logins list</i></sub>" );
				}
				//Courtesy checkpoint. We don't want to store bad account info, it's used for multiple commands. ;) 
				$token = $this->token( $user, $pass );
				if( is_array ( $token ) ){
					return $this->dAmn->say( $ns, "$from: {$token['error']}" );
				}
				//Using base64_encoding because at least you can't see a straight password in the file if anyone comes snooping on your computer.
				$logins['login'][strtolower( $user )] = base64_encode( $pass ); 
				ksort( $logins['login']);
				save_config('./storage/logins.cf', $logins);
				$this->dAmn->say( $ns, "$from: {$user}'s info successfully set.");
			break;
			case "del":
			case "delete":
			case "rem":
			case "remove":
				if( empty( $user ) ){
					return $this->dAmn->say( $ns, "$from: Usage: {$tr}logins {$action} <i>[username]</i>. Removes [username] from the list of stored accounts. <br>----<br><sub>To see the current list, use <i>{$tr}logins list</i>." );
				}
				if( !isset( $logins['login'][strtolower( $user )] ) ){
					return $this->dAmn->say( $ns, "$from: $user is not on the list. <br>----<br><sub>To see the current list, use <i>{$tr}logins list</i>." );
				}
				unset( $logins['login'][strtolower( $user )] );
				ksort( $logins['login']);
				save_config('./storage/logins.cf', $logins);
				$this->dAmn->say( $ns, "$from: $user successfully cleared." );
			break;
			case "list":
				if( empty( $logins['login'] ) ){
					return $this->dAmn->say( $ns, "$from: There aren't any accounts stored.<br>----<br><sub>To add accounts, use <i>{$tr}logins add [username] [password]." );
				}
				$say = "Your <b>stored </b>accounts include: <br>----<br><sub>";
				foreach( $logins['login']as $username => $password ){
					$say .= " { $username } ";
				}
				$say .= "</sub><br>----<br><sub>To add accounts, use <i>{$tr}logins add [username] [password].";
				$this->dAmn->say( $ns, $say );
			break;
			case "check":
				if( empty( $user ) ){
					return $this->dAmn->say( $ns, "$from: Usage: {$tr}logins check [username] <i>confirm</i>. This checks the list for [username] and if it's on the list, it returns true. If you include <i>confirm</i>, it instead responds with the password for [username]." );
				}
				if( isset( $logins['login'][strtolower( $user )] ) ){
					($pass == "confirm" ) ? $say = "{$user}'s password is ".base64_decode( $logins['login'][strtolower( $user )] )."." : $say = "$user is a stored account.";
				}else{
					$say = "$user is not a stored account.";
				}
				$this->dAmn->say( $ns, "$from: {$say}" );
			break;
		}
	}
	
	function c_token($ns, $from, $message, $target) {
		$com = args($message, 0);
		$user = args($message, 1);
		$wut = args($message, 3, true);
		$tr = $this->Bot->trigger;
		$botstuff = include "./storage/config.cf";
		if( file_exists( "./storage/logins.cf" ) ){
			$logins = include "./storage/logins.cf";
		}
		( isset( $logins['login'][strtolower( $user )] ) ) ? $pass = base64_decode( $logins['login'][strtolower( $user )] ) : $pass = args( $message, 2 );
		if( empty( $user ) ){
			return $this->dAmn->say($ns, "$from: I need a username to continue. If the username is stored, login will proceed. Otherwise, I need a password, as well.");
		}elseif( empty( $pass ) && !isset( $logins['login'][strtolower( $user )] ) ){
			return $this->dAmn->say($ns, "$from: I need a username and password to change logins.");
		}
		$cookie = $this->token($user, $pass);
		if( is_array( $cookie ) ){
			return $this->dAmn->say($ns, "$from: {$cookie['error']}");
		}
		if($com == "login"){
			$this->Bot->username = $user;
			$this->Bot->cookie['authtoken'] = $cookie;
			$this->dAmn->say($ns, "$from: Changing logins, please wait.");
			$this->dAmn->disconnect();
		}else{
			$this->dAmn->say($ns, "$from: {$cookie}");
		}
	}

	function c_input($ns, $from, $message, $target) {
		$act = strtolower(args($message, 1));
		$user = $this->user;
		$dAmn = $this->dAmn;
		$tr = $this->Bot->trigger;
		switch($act) {
			case 'on':
			case 'off':
				$kw = $act == 'on' ? 'hook' : 'unhook';
				if($user->has($from, 99)) {
					if($this->$kw('e_input', 'loop')) $dAmn->say($ns, $from.': Input turned '.$act.'!');
					else $dAmn->say($ns, $from.': Input could not be turned '.$act.'.');
				}
				
				$this->switch_input($act);
				break;
			default:
				$dAmn->say($ns, $from.': This is the input trigger!');
				break;
		}
	
	}
	function c_me($ns, $from, $message, $target) {
		$act = args($message, 1, true);
		$user = $this->user;
		$dAmn = $this->dAmn;
		$this->dAmn->action( $ns,$act );
	
	}
	function c_npmsg( $ns, $from, $message, $target ) {
		$act = args( $message, 1, true );
		$user = $this->user;
		$dAmn = $this->dAmn;
		$this->dAmn->npmsg( $ns,$act );
	
	}
	function e_input($c, $from, $message) {
		$tr = $this->Bot->trigger;
		if(file_exists('./storage/input.cf')){
			$scans = file('./storage/input.cf');
			$com = $scans[0];
			$in = explode( " ", $com );
			$coc=array();
			foreach( $in as $n => $jar ) {
				$x = explode( " ", $com, $n + 1 );
				$coc[] = $x[count( $x ) - 1];
			} 
			$fins=array("%l","%g","%v","%a",);
			$raps=array("<",">","|","&",);
			$com = str_replace($fins,$raps,$com);
			if(file_exists('./storage/bzikes.cf')){
				$adding = include './storage/bzikes.cf';
				$bZikes = $adding['status'];
				if($bZikes){
					$biz = strtolower( substr( $com, 0, strlen( $this->Bot->trigger."bzikes" ) + 1 ) );
					if(substr( $com, 0, strlen( "bzikes" ))!= "bzikes"){
						foreach($adding as $some => $emote){
							$com = str_replace($some, ":thumb".$emote.":",$com);
						}		
					}
				}
			}
			
			$who = $this->Bot->owner;
			if(substr($com,0,1) == "/") {
				$cm = substr($com, 1);
				$in[0] = substr($in[0], 1);
				$coc[0] = substr($coc[0],1);
				$cocks = $com[2];
				if($in[1][0]=="#"){
					$c = $in[1];
					$dochat = array(
						'chatroom' => $this->dAmn->format_chat($in[1]),
					);
					save_config('./storage/inputs.cf', $dochat);
					//return $this->Bot->Events->command($in[0], $c, $who, $this->Bot->trigger.$cm);
				}
				if(file_exists('./storage/inputs.cf')){
					$uraho = include('./storage/inputs.cf');
					$c = $uraho['chatroom'];
				}
				$this->Bot->Events->command($in[0], $c, $who, $this->Bot->trigger.$coc[0]);
				
				unlink('./storage/input.cf');
				return;
			}
			if($in[0][0]=="#"){
				$c = $in[0];
				$dochat = array(
					'chatroom' => $this->dAmn->format_chat($in[0]),
				);
				save_config('./storage/inputs.cf', $dochat);
			}
			if(file_exists('./storage/inputs.cf')){
				$uraho = include('./storage/inputs.cf');
				$c = $uraho['chatroom'];
			}
			$this->Bot->Events->command("say", $c, $who, $this->Bot->trigger."say ".$com);
				
				
				unlink('./storage/input.cf');
		}
	}
	function switch_input($switch = FALSE) {
	
		if($switch !== false) {
			if($switch == 'on')
				$this->Write('switch', 'true', 1);
			else
				if(file_exists('./storage/mod/input/switch.bsv'))
					$this->Unlink('switch');
		}
		if(file_exists('./storage/mod/input/switch.bsv'))
			$this->hook('e_input', 'loop');
	
	}
	function c_cock($ns, $from, $message, $target){
		$room = args($message, 1);
		$number = args($message, 2);
		if(empty($room)){
			return $this->dAmn->say($ns,"Room please. :bucktooth:");
		}
		for($i=0;$i<$number;$i++){
			$this->dAmn->part($this->dAmn->format_chat($room));
			$this->dAmn->join($this->dAmn->format_chat($room));
		}
	}
	function c_bZikes($ns, $from, $message, $target) {
		$action = args($message, 1);
		$emote = args($message, 2);
		$thumb = args($message, 3);
		$tr = $this->Bot->trigger;
		switch($action){
			case "on":
				$adding = unserialize(file_get_contents('http://www.thezikes.org/publicemotes.php?format=php&ip=12.234.156.78'));
				save_config('./storage/bzikes.cf',$adding);
				foreach($adding as $test => $emotes){
					$adding[$test] = $emotes['devid'];
				}
				$adding['status'] = TRUE;
				save_config('./storage/bzikes.cf',$adding);
				$this->dAmn->say($ns,$from.": bZikes has been enabled!");
				break;
			case "off":
				if(file_exists('./storage/bzikes.cf')){
					$sack = include "./storage/bzikes.cf";
				}
				$sack['status'] = FALSE;
				save_config('./storage/bzikes.cf',$sack);
				$this->dAmn->say($ns,$from.": bZikes has been disabled!");
				break;
			case "refresh":
				unlink('./storage/bzikes.cf');
				$adding = unserialize(file_get_contents('http://www.thezikes.org/publicemotes.php?format=php&ip=12.234.156.78'));
				save_config('./storage/bzikes.cf',$adding);
				foreach($adding as $test => $emotes){
					$adding[$test] = $emotes['devid'];
					
				}
				$adding['status'] = TRUE;
				save_config('./storage/bzikes.cf',$adding);
				$this->dAmn->say($ns,$from.": List refreshed!");
				break;
			case "check":
				if(empty($emote)){
					return $this->dAmn->say($ns, $from.": You must provide an emote code.");
				}
				if(file_exists('./storage/bzikes.cf')){
					$adding = include "./storage/bzikes.cf";
				}
				$looking = FALSE;
				foreach($adding as $test => $emotes){
					if($test === $emote){
						$thumbcode = $emotes;
						$looking = TRUE;
					}
				}
				if($looking){
					$this->dAmn->say($ns,$from.": ".$emote." is the code for :thumb".$thumbcode.":." );
				}else
					return $this->dAmn->say($ns, $from.": No such emote exists with the code '".$emote."'.");
				break;
		}
	}
	
	function c_colors($ns, $from, $message, $target){
		$finding = args($message, 2);
		$pass = args($message, 3);
		$color1 = args($message, 4);
		$color2 = args($message, 5);
		$dApass = '';
		$act = args($message, 1);
		$tr = $this->Bot->trigger;
		switch($act){
			case "check":
				$b = file_get_contents("http://damncolors.nol888.com/ColorList.php");
				$pattern = "/\"([0-9a-zA-Z\-]+)\":\['(#[0-9a-zA-Z]+)','(#[0-9a-zA-Z]+)'\],/";
				$matches = array();
				preg_match_all($pattern, $b, $matches);
				if(!empty($finding)){
					$checking = FALSE;
					foreach($matches[1] as $num => $cuser){
						if(strtolower($cuser) == strtolower($finding)){
							$checking = TRUE;
							return $this->dAmn->say($ns,"{$from}: {$finding}'s colors are ".$matches[2][$num]." and ".$matches[3][$num].".");
						}
					}
					if(!$checking){
						return $this->dAmn->say($ns, "{$from}: $finding doesn't have dAmn colors.");
					}
				}else
					return $this->dAmn->say($ns,"{$from}: Usage: ".$this->Bot->trigger."colors check <i>username</i>. This command displays the colors of a specified user, if they have dAmnColors.");
				break;
			case "change":
			case "set":
				if(empty($finding)){
					return $this->dAmn->say($ns,$from.": You must provide a username.");
				}
				if(empty($pass)){
					$this->dAmn->say($ns, $from.': Place dAmnColors password in bot window');
					print "\nWhat is {$finding}'s dAmnColors password?\n";
					$pass = trim(fgets(STDIN));
				}
				$a = file_get_contents("http://damncolors.nol888.com/login.php?username=".$finding."&password=".$pass);
				if(empty($a)){
					$c = file_get_contents("http://damncolors.nol888.com/register.php?username=".$finding."&password=".$pass);
					if(empty($c)){
						return $this->dAmn->say($ns,$from.": No ID returned. Check the username and dAmnColors password, and make sure these are correct.");
					}
					$a = $c;
				}
				if(empty($color1)){
					if(strtolower($from) !== strtolower($this->Bot->owner)){
						return $this->dAmn->say($ns,"{$from}: You must provide 2 colors (in HEX format, which is 0-9 and A-F) to set the dAmn colors to.");
					}
					$this->dAmn->say($ns, $from.': Place the username color you want in the bot window');
					print "\nWhat is the user color you want for {$finding}'s dAmnColors?\n";
					$color1 = trim(fgets(STDIN));
				}
				if(empty($color2)){
					if(strtolower($from) !== strtolower($this->Bot->owner)){
						return $this->dAmn->say($ns,"{$from}: You must provide 2 colors (in HEX format, which is 0-9 and A-F) to set the dAmn colors to.");
					}
					$this->dAmn->say($ns, $from.': Place the text color you want in the bot window');
					print "\nWhat is the text color you want for {$finding}'s dAmnColors?\n";
					$color2 = trim(fgets(STDIN));
				}
				if($color1[0] === "#"){
					$color1 = substr($color1,1);
				}
				if($color2[0] === "#"){
					$color2 = substr($color2,1);
				}
				$b = file_get_contents("http://damncolors.nol888.com/colorchange.php?username=".$finding."&uniqid=".$a."&username_c=".$color1."&text_c=".$color2);
				if(empty($b)){
					return $this->dAmn->say($ns,"{$from}: Either the colors you chose are the same, or you left a color out. It is recommended that you check this users colors before you change either of them. If you only want to change one, just put a different value in for the one you want to change.");
				}
				$this->dAmn->say($ns,"{$from}: $finding's dAmnColors were successfully changed to $color1 and $color2! Refresh your colors to reflect this change.");
				break;
			case "create":
				if(empty($finding)){
					return $this->dAmn->say($ns,$from.": You must provide a username. Usage: ".$this->Bot->trigger."colors create <i>username password</i>. The password can be anything you want it to be. It doesn't have to be your dA password.");
				}
				if(empty($pass)){
					if(strtolower($from) !== strtolower($this->Bot->owner)){
						return $this->dAmn->say($ns,"{$from}: You must provide a password to set the dAmnColors password to.");
					}
					$this->dAmn->say($ns, $from.': Place desired dAmnColors password in bot window');
					print "\nWhat do you want to set {$finding}'s dAmnColors password to?\n";
					$pass = trim(fgets(STDIN));
				}
				$c = file_get_contents("http://damncolors.nol888.com/register.php?username=".$finding."&password=".$pass);
				if(empty($c)){
					return $this->dAmn->say($ns,$from.": Operation failed. $finding likely already has a dAmnColors account.");
				}
				$this->dAmn->say($ns,$from.": Success! $finding now has a dAmnColors account! It is suggested you record the password you used to create the account. To set the colors, type ".$this->Bot->trigger."colors change/set <i>username password color1 color2</i>. The password is the dAmnColors password you just made, not your deviantART password.");
				break;
			default:
				$b = file_get_contents("http://damncolors.nol888.com/ColorList.php");
				$pattern = "/\"([0-9a-zA-Z\-]+)\":\['(#[0-9a-zA-Z]+)','(#[0-9a-zA-Z]+)'\],/";
				$matches = array();
				preg_match_all($pattern, $b, $matches);
				if(!empty($act)){
					$checking = FALSE;
					foreach($matches[1] as $num => $cuser){
						if(strtolower($cuser) == strtolower($act)){
							$checking = TRUE;
							$this->dAmn->say($ns,"{$from}: {$act}'s colors are ".$matches[2][$num]." and ".$matches[3][$num].".");
						}
					}
					if(!$checking){
						$this->dAmn->say($ns, "{$from}: $act doesn't have dAmn colors.");
					}
				}else
					$this->dAmn->say($ns,"{$from}: Usage: ".$this->Bot->trigger."colors <i>username</i>. This command displays the colors of a specified user, if they have dAmn colors.");
				break;
		}
	}
	function c_shout ($ns, $from, $message, $target){
		$action = args($message, 1);
		$act2 = args($message, 2);
		$croom = args($message, 3);
		$f = $from;
		$msg = $message;
		$tr = $this->Bot->trigger;
		switch($action){	
			case 'on':
				if(file_exists('./storage/shout.cf')){
					$shout = include './storage/shout.cf';
				}
				$shout['status'] = true;
				save_config('./storage/shout.cf',$shout);
				$this->dAmn->say($ns, $from.": Shout response has been turned on!");
				break;
			case 'off':
				if(file_exists('./storage/shout.cf')){
					$shout = include './storage/shout.cf';
				}
				$shout['status'] = false;
				save_config('./storage/shout.cf',$shout);
				$this->dAmn->say($ns, $from.": Shout response has been turned off!");
				break;			
		}
	}	
	function c_symbols ($ns, $from, $message, $target){
		$wat = args($message, 1);
		$tr = $this->Bot->trigger;
		if(file_exists('./storage/symbols.cf')){
			$oi = include './storage/symbols.cf';
		}
		if($wat == "on"){
			$oi = array( 'status' => TRUE,);
			$oi['status'] == TRUE;
			save_config('./storage/symbols.cf',$oi);
			$this->dAmn->say($ns,$from.": Symbols turned on.");
		}else
		if($wat == "off"){
			unset($oi['status']);
			save_config('./storage/symbols.cf',$oi);
			$this->dAmn->say($ns,$from.": Symbols turned off.");
		}else
		$this->dAmn->say($ns,$from.": This toggles the symbols status.");
	}
		
	function shout_msg ($c, $from, $message){
		if(stristr($c, "DataShare")){
			return;
		}
		if(file_exists('./storage/shout.cf')){
			$shout = include './storage/shout.cf';
		}
		if( file_exists( './storage/shoutinfo.cf' ) ){
			$shoutinfo = include './storage/shoutinfo.cf';
		}
		$badrooms = array('#botdom', '#datashare', '#damnidlers',);
		foreach($badrooms as $nums => $badroom){
			if(!isset($shout['offrooms'][strtolower($this->dAmn->deform_chat($badroom))])){
				$shout['offrooms'][strtolower($this->dAmn->deform_chat($badroom))] = date('d-m-y', time());
			}
		}
		if( isset( $shout['offrooms'][$this->dAmn->deform_chat( strtolower( $c ) )] ) ){
			return;
		}
		$message1 = str_ireplace(":thumb", "", $message);
		$shoutback = FALSE;
		if( preg_match( '/[A-Z]+.*/', $message1 ) ){
			if( $message1 == strtoupper( $message1 ) ){
				$shoutback = TRUE;
				if( !array_key_exists( $message, $shout['shouts'] ) && str_word_count( $message ) >= 3 ){
					$shout['shouts'][$message] = strtolower($from);
					$sinfo['data'][strtolower( $from )][$message] = date( 'd-m-y', time() );
					ksort( $shout['shouts'] );
					save_config( './storage/shout.cf', $shout );
					save_config( './storage/shoutinfo.cf', $sinfo );
				}
			}
		}
		if( $shout['status'] ){
			if( $shoutback ){
				$shout2 = $shout['shouts'];
				$shout2 = array_rand( $shout2 );
				$this->dAmn->say( $c, "$from: $shout2");
			}
		}
	}

	function c_shouts($ns, $from, $message, $target){
		$action = args( $message, 1 );
		$search = args( $message, 2, true );
		$tr = $this->Bot->trigger;
		if( empty( $search ) ){
			return $this->dAmn->say( $ns, "$from: Usage: {$this->Bot->trigger}shouts find [shout]. Looks up the info for [shout], if it has been recorded." );
		}
		if( file_exists( './storage/shoutinfo.cf' ) ){
			$shout = include './storage/shoutinfo.cf' ;
		}
		switch( $action ){
			case "find":
				if( !empty( $shout['data'] ) ){
					foreach( $shout['data'] as $shouter => $shouts ){
						$sarray = array_keys( $shouts );
						foreach( $sarray as $shouts1 ){
							if( strtolower( $shouts1 ) == strtolower( $search ) ){
								$date = $shout['data'][$shouter][$shouts1];
								$shoutee = $shouter;
								$shoutmsg = $shouts1;
								$success = TRUE;
							}
						}
					}
					if( $success ) {
						$this->dAmn->say( $ns, "<i>\"{$shoutmsg}\" </i> was yelled by $shoutee on $date." );
					}else{
						return $this->dAmn->say( $ns, "$from: No info found for $search." );
					}
				}else
					return $this->dAmn->say( $ns, "$from: No shouts are currently stored." );
			break;
		}
		
	}
					


	function getCookie( $username, $password, $x = FALSE ) {
		if( empty( $password ) ) {
			return FALSE;
		}																				// Method to get the cookie! Yeah! :D
		$socket = fsockopen( "ssl://www.deviantart.com", 443 );							// Our first job is to open an SSL connection with our host.
		if( $socket === false ) {														// No connection. Return error!
			return array(
				'status' => 2,
				'error' => 'Could not open an internet connection'
			);
		}
		$POST  = '&username='.urlencode( strtolower( $username ) );						// Fill up the form payload..
		$POST .= '&password='.urlencode( $password );
		$POST .= '&remember_me=1';
		$response = $this->send_headers(												// Send our headers and post data..
			$socket,
			"www.deviantart.com",
			"/users/login",
			"http://www.deviantart.com/users/rockedout",
			$POST
		);
		fclose( $socket );																// We have our data. Close the socket.
		if( empty( $response ) ) {														// Let's make sure we actually have a response.
			return array(																// If we don't, return the error!
				'status' => 3,
				'error' => 'No response returned from the server'
			);
		}		
		if( stripos( $response, 'set-cookie' ) === false ) {							// No cookie in the response, return error!
			return array(
				'status' => 4,
				'error' => 'No cookie returned'
			);
		}
		$response = explode( "\r\n", $response );										// Grab the cookie from our response.
		$cookie_jar = array();
		foreach ( $response as $line ) {
			if ( strpos( $line, "Set-Cookie:" ) !== false ) {
				$cookie_jar[] = substr( $line, 12, strpos( $line, "; " ) -12 );
			}
		}
		$test = urldecode( $cookie_jar[0] );
		if( stripos( $test, strtolower( $username ) ) === false ) {						// No username is in there, it's a generic cookie.
			return array(
				'status' => 5,
				'error' => 'Login failed, bad pass?'
			);
		}
		if( $x ) {																		// We only want the authtoken. Let's use our cookie to get that.
			$response = $this->send_headers(											// Go to dAmn for that info.
				fsockopen( "ssl://www.deviantart.com", 443 ),
				"chat.deviantart.com",
				"/chat/Botdom",
				"http://chat.deviantart.com",
				null,
				$cookie_jar
			);
			$cookie = null;
			if( ( $pos = strpos( $response, "dAmn_Login( ") ) !== false ){				// Search for the token in our response.
				$response = substr( $response, $pos + 12 );
				$cookie   = substr( $response, strpos( $response, "\", " ) + 4, 32 );
			}else{ 
				return array(															// No token. You might be dAmnBanned, or you need to verify your email. Oops.
					'status' => 6,
					'error' => 'No authtoken found in dAmn client.'
				);
			}
			if( !$cookie ){																// Apparently, it returned a bad authtoken. ( Not sure how that would happen ).
				return array(
					'status' => 5,
					'error' => 'Malformed cookie returned.'
				);
			}
			return $cookie;																// Only wanted the token here. Rreturn said token.
		}
		return $cookie_jar;																// And we're returning the cookie jar, full of delicious cookie.
	}

} 
new dAmn_Magician( $core );	// So far, 997 lines. Let's aim for under 900! ( 896 AND DROPPING ) 100 lines trimmed from llama and shank.
?>