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

		$this->addCmd('shank', 'c_shank', 0);
		$this->addCmd('google', 'c_google', 0);
		$this->addCmd('llama', 'c_llama', 0);
		$this->addCmd('rllama', 'c_llama', 0);
		$this->addCmd('rspama', 'c_llama', 99);
		$this->addCmd('logins', 'c_logins', 99);
		$this->addCmd('token', 'c_token', 99);
		$this->addCmd('login', 'c_token', 99);
		$this->addCmd('symbols', 'c_symbols', 99);
		$this->addCmd('sr', 'c_responses', 50);
		$this->addCmd('r', 'c_cock', 99);
		$this->addCmd('input', 'c_input', 99);
		$this->switch_input();
		$this->addCmd('bzikes', 'c_bZikes', 75);
		$this->addCmd('me', 'c_me', 75);
		$this->addCmd('npmsg', 'c_npmsg', 75);
		$this->addCmd('colors', 'c_colors', 25);
		$this->addCmd('shout', 'c_shout', 25);
		$this->addCmd('shouts', 'c_shouts', 25);
		$this->hook('shout_msg', 'recv_msg');
		$this->hook('shout_msg', 'recv_action');

		
		$this->hook('e_input', 'loop');

		$tr = $this->Bot->trigger;
		
		$this->cmdHelp('llama', "{$tr}llama [username] {user2} where username is a specified dA username. This sends the specified username a llama. {user2} is an optional parameter. If specified, the bot will try to send the username a llama from that dA account instead of the bot's.");
		$this->cmdHelp('rllama', "{$tr}rllama {user} Sends a llama to a random user. {user} is an optional parameter. If specified, the bot will try to send a llama from that dA account instead of the bot's. ");
		$this->cmdHelp('rspama', "{$tr}rspama # {user} Sends llamas to either a specified number of random deviants or 50. If you provide a number and {user} it'll try and send those random people llamas from that account.");
	
		$this->cmdHelp('shout', 'Shout records everything that users in the chatrooms the bot is in yells in all caps. IF it\'s 3 words or longer, it records it to the list. '.$tr.'shout on/off turns the response on and off. If on, when someone yells something in all caps, it will shout back at the person who yelled.');
		
		$this->cmdHelp('shouts', 'This command is used to display everything a certain user has shouted, if they\'ve shouted anything. '.$tr.'shouts find <i>[SHOUT]</i>, will look up the info of the specified shout, such as who yelled it, and the date.');

		$this->cmdHelp('shank', 'Shank is a joke command. It shanks either the username provided if given, or it shanks the person who used the command.<b> '.$tr.'shank <i>username</i></b>.');
		
		$this->cmdHelp('logins', 'logins uses a username/password combo to store logins to a file so that they can be used for token, cookie, and/or login.<sup><br><b> '.$tr.'logins add <i>username (password)</i></b> Leave the password blank to input into the bot window. <br><b> '.$tr.'logins del <i>username</i></b>.<br><b> '.$tr.'logins list</b> (either type list or leave blank and it\'ll display a list as well).');
		
		$this->cmdHelp('token', 'token uses either a username/password combo, or it can use one of the stored logins to return a token for that account. <sup><b><br>'.$tr.'token <i>username (password)</i></b> Leave the password blank to input into the bot window.');
		
		//$this->cmdHelp('cookie', 'cookie uses either a username/password combo, or it can use one of the stored logins to return a cookie for that account. <sup><b><br>'.$tr.'cookie <i>username (password)</i></b> Leave the password blank to input into the bot window.');
		
		$this->cmdHelp('me', 'Use /me in the input window for actions.');
		
		$this->cmdHelp('npmsg', 'Use /npmsg in the input window as the same thing as holding shift when you hit enter.');
		
		$this->cmdHelp('login', 'login uses either a username/password combo, or it can use one of the stored logins to change to that account. <sup><b><br>'.$tr.'login <i>username (password)</i> Leave the password blank to input into the bot window. It will login to the account provided.');
		
		$this->cmdHelp('sexy', 'Sexy is a speech module. It responds with a sentence from a list of \'sexy\' responses, to a list of users that you make by adding people with suser add. To use it, just type <b><i>'.$tr.'sexy on/off</i></b>.');
		
		$this->cmdHelp('sr', 'sr is the command that adds responses to the sexy response list. <sup><br><b>'.$tr.'sr add <i>response</i></b> adds a response to the list.<br><b>'.$tr.'sr del <i>NUMBER</i></b> deletes a response, based on the numeric ID of that response.<br><b>'.$tr.'sr list </b> displays the list of responses.</sup>');
		
		$this->cmdHelp('bzikes', 'bZikes is the implementing of Zikes on PHP bots, so that their inputs can take advantage of the Zikes emotes. It is customizable. To toggle whether or not it\'s on and being used by input, type <b>'.$tr.'bzikes on/off</b><sup><br><b>'.$tr.'bzikes refresh</b> Tells the bot to check the list and download the list again. You can use this to keep it up to date if you know emotes have been added to the public list.<br><b>'.$tr.'bzikes check <i>:code:</i></b> checks the list of emotes for one using that code.</sup>');
		
		$this->cmdHelp('input', 'Input is the ability to control the bot from another cmd Prompt window, without the OWNER actually needing to be on dAmn. To enable it, type '.$tr.'input on/off. The prompt that allows input was provided. When using the window, type lt; for <, gt; for >, %v for |, and %a for &. If you\'re just using say, type the room you want the bot to talk in first, then your message. You don\'t need to include the room in the message unless you\'re changing what room the bot is talking in. To use another command, type "/ [cmd name] [other]".');
		
		$this->cmdHelp('spell', 'Spell is the same as the Dante command. To use, just type '.$tr.'spell <i>word</i>.');
		
		$this->cmdHelp('colors', 'Colors checks the dAmn colors list for the colors of the provided user. It can also set/change colors or create a dAmnColors account.<sup><br><b>'.$tr.'colors (check) <i>username</i></b> checks the colors of the provided user. The check parameter is optional.<br><b>'.$tr.'colors change/set <i>username password color1 color2</i></b> Changes the colors of the username given. The password is your dAmnColors Password, not your dA. If you leave the password, color1, and color2 blank, you can do the rest in the bot window. You can include the password and just do the colors from the window, and you can leave only the second color blank and put in to the window. You must provide 2 colors, and one must be different than the ones you already have.');
		if(file_exists('./storage/logins.cf')){
			$adding = include './storage/logins.cf';
		
			if(isset($adding['login'][0])){
				foreach($adding['login'] as $logins => $list){
					$adding['login'][$adding['login'][$logins][0]] = $adding['login'][$logins][1];
					unset($adding['login'][$logins]);
					sort($adding['login']);
					save_config('./storage/logins.cf',$adding);
				}
			}
			if(isset($adding['login'][1])){
				foreach($adding['login'] as $logins => $list){
					$adding['login'][$adding['login'][$logins][0]] = $adding['login'][$logins][1];
					unset($adding['login'][$logins]);
					sort($adding['login']);
					save_config('./storage/logins.cf',$adding);
				}
			}
		}
		if(file_exists("./storage/logins.cf")){
			$lg = include "./storage/logins.cf";
			if(!isset($lg['encoded'])){
				foreach($lg['login'] as $who => $wat){
					$lg['login'][$who] = base64_encode($wat);
				}
				$lg['encoded'] = TRUE;
				save_config("./storage/logins.cf",$lg);
				echo "Logins passwords encoded c:".chr(10);
			}
		}
				
		if(file_exists('./storage/bzikes.cf')){
			$checker = include './storage/bzikes.cf';
		
			if(!empty($checker['codes'])){
				$adding = unserialize(file_get_contents('http://www.thezikes.org/publicemotes.php?format=php&ip=12.234.156.78'));
				save_config('./storage/bzikes.cf',$adding);
				foreach($adding as $test => $emotes){
					$adding[$test] = $emotes['devid'];
				}
				$adding['status'] = TRUE;
				save_config('./storage/bzikes.cf',$adding);
			}
		}
	}
	
	function c_llama($ns, $from, $message, $target) {
		$person = args($message, 1);
		$spamnum = args($message, 1);
		$sending = args($message, 0);
		$person2 = args($message, 2);
		$tr = $this->Bot->trigger;
		if(!empty($person2)){
			$person2 = strtolower( $person2 );
		}
		//Let's just load a all the config stuff.. we'll be using that.
		if(file_exists('./storage/config.cf')){
			$pass = include './storage/config.cf';
		}
		if(file_exists('./storage/logins.cf')){
			$logins = include './storage/logins.cf';
		}
		if(file_exists('./storage/llama.cf')){
			$Llama = include './storage/llama.cf';
		}
		switch($sending){
			case "rspama":
			case "rllama":
			case "llama":
				if(strtolower($sending) == "llama"){
					if( empty ( $person ) ){
						return $this->dAmn->say($ns, "{$from}: You must specify your llama recipient. Use rllama to send a random person one.");
					}
				}
				//For random llamas if you specified a username, we'll try to use that dA account for the llama sending process.
				if($sending == "rllama" && isset($person)){
					$person2 = $person;
				}
				//Setting up our llama looper.. We max out at 77 so.. That's where we'll force the loop to end.
				if($sending == "rspama"){
					//Default loop is set at 50. We assume if $args[1] isn't a number that it's the account you want to send llamas from.
					if(!is_numeric($spamnum)){
						$loopnum = 50;
						$person2 = $spamnum;
					}
					if(empty($spamnum)){
						$loopnum = 50;
					}
					//If a number was supplied AND you supplied a second argument, we'll try to use that for llama sending.
					elseif(is_numeric($spamnum) && $spamnum <= 77){
						$loopnum = $spamnum;
					}else $loopnum = 77;
				}
				//Here's where we check to see if the username provided is in your logins list.. assuming you have one, of course.
				if( isset( $person2 ) && isset( $logins['login'][strtolower( $person2 )] ) ){
					$username = $person2;
					$password = base64_decode($logins['login'][$person2]);
				
				//UPDATE: Since Contra no longer uses a stored password, oAuth would make this part useless. Going to rig this part for engaging only on older bots. :)
				}elseif( !empty( $pass['info']['password'] ) && empty( $password ) ){
					//IF you provided an account name and it was not found, we'll be using the bot's account. 
					$username = $this->Bot->username;
					$password = $pass['info']['password'];
				}
				if( empty( $password ) ){
					return $this->dAmn->say( $ns, "$from: $person2 is not a stored account, and we cannot proceed with llama. Please use an account that's on the logins list.<br>----<br><sup>To see a list of your stored accounts, use <i>{$tr}logins list</i>." );
				}
				//Checking to see if $username has already sent $person a llama before.. no sense in proceeding if they have, each person can only send a llama once to another user.
				if(isset($Llama['list'][strtolower( $username )][strtolower($person)])){
					return $this->dAmn->say($ns, "$from: $username can't send another llama to $person.");
				}
				//Method to get the cookie! Yeah! :D
				//Our first job is to open an SSL connection with our host.
				$socket = fsockopen("ssl://www.deviantart.com", 443);
				// If we didn't manage that, we need to exit!
				if($socket === false) {
					return array(
						'status' => 2,
						'error' => 'Could not open an internet connection'
					);
				}
				// Fill up the form payload
				$POST = '&username='.urlencode($username);
				$POST.= '&password='.urlencode($password);
				$POST.= '&remember_me=1';
				//echo "We are at part 1.".chr(10);
				// And now we send our header and post data and retrieve the response.
				$response = $this->dAmn->send_headers(
					$socket,
					"www.deviantart.com",
					"/users/login",
					"http://www.deviantart.com/users/rockedout",
					$POST
				);
				// Now that we have our data, we can close the socket.
				fclose ($socket);
				// And now we do the normal stuff, like checking if the response was empty or not.
				if(empty($response))
				return array(
						'status' => 3,
						'error' => 'No response returned from the server'
				);
				if(stripos($response, 'set-cookie') === false)
				return array(
					'status' => 4,
					'error' => 'No cookie returned'
				);
				// Grab the cookies from the header
				$response=explode("\r\n", $response);
				$cookie_jar = array();
				foreach ($response as $line)
					if (strpos($line, "Set-Cookie:")!== false)
						$cookie_jar[] = substr($line, 12, strpos($line, "; ")-12);
					if(strtolower($sending) == "rllama"){
						//This is the part where we kick out all the necessary info to send a random llama out. Username is included for record keeping purposes. You'll see below.
						$this->llama(null, $cookie_jar, $password, $username);
						$this->dAmn->say($ns, "$from: Random llama sent as $username!");
					}if( strtolower($sending) == "llama"){
						//As above, this is for the llama sent to a specified user. Username is included for record keeping purposes.
						$this->llama($person, $cookie_jar, $password, $username);
						$this->dAmn->say($ns, "$from: Llama sent to $person as $username!");
					}if( $sending == "rspama"){
						//Now to loop our llama sender. This will probably lag a bit. 
						for($i = 0; $i <= $loopnum; $i++){
							$this->llama(null, $cookie_jar, $password, $username);
							$this->dAmn->send( "pong\n" . chr( 0 ) );
						}
						$this->dAmn->say($ns, "$from: $loopnum Llamas sent as $username!");
					}
			break;
		}
		
	}
	
	function llama($person, $cookie_jar, $password, $username){
		//We start by loading the config info.. 
		$tr = $this->Bot->trigger;
		if(file_exists('./storage/config.cf')){
			$pass = include './storage/config.cf';
		}
		if(file_exists('./storage/llama.cf')){
			$Llama = include './storage/llama.cf';
		}
		//If we have a provided username, we'll be visiting their page to steal some required info.
		if(isset($person)){
			$devpage = @file_get_contents("http://".strtolower($person).".deviantart.com/");
		}else{
			//If we're going random, We'll be going to a random deviant's page for this info.
			$devpage = @file_get_contents('http://www.deviantart.com/random/deviant');
			preg_match("/gmi-name=\"(.*)\"/Ums", $devpage, $matches);
			$person = $matches[1];
		}
		//Let's just mark the date and time we sent this person a llama down on a list. We're gonna keep track of that by username.
		$Llama['list'][strtolower($username)][strtolower($person)] = date('d-m-y', time());
		//So.. $username is the account being used for the llama sending, $person is the person we're sending the llama to.
		save_config('./storage/llama.cf',$Llama);
		//Now then, hunting their page for their user id.
		preg_match("/gmi-gruser_id=\"(.*)\"/Ums", $devpage, $matched);
		$dev = $matched[1];
		$devpage2 = urlencode("http://{$person}.deviantart.com/");
		//Assuming we got the ID, let's send all of this so we get to the llama giving.
		$llamapage = $this->dAmn->send_headers(
			fsockopen("tcp://www.deviantart.com", 80),
			"www.deviantart.com",
			"/modal/badge/give?badgetype=llama&to_user={$dev}&trade_id=0&referrer={$devpage2}",
			"http://www.deviantart.com",
			null,
			$cookie_jar
			);
		//If we're successful in sending that, we'll be grabbing the token for the transaction.
		preg_match("/name=\"token\" value=\"(.*)\"/Ums", $llamapage, $matches2);
		preg_match("/name=\"validate_token\" value=\"(.*)\"/Ums", $llamapage, $matches3);
		preg_match("/name=\"validate_key\" value=\"(.*)\"/Ums", $llamapage, $matches4);
		$token = $matches2[1];
		$vToken = $matches3[1];
		$vKey = $matches4[1];
		//Let's set up the final portion of the required info so we can send the badge. 
		$toSend = "&quantity=1&userpass={$password}&tos=1&_toggle_tos=0&password_remembered=1&_toggle_password_remembered=0&badgetype=llama&to_user={$dev}&token={$token}&validate_token={$vToken}&validate_key={$vKey}";
		//Finally, we send out the llama badge with all the required info.
		$e = $this->dAmn->send_headers(
			fsockopen("tcp://www.deviantart.com", 80),
			"www.deviantart.com",
			"/modal/badge/process_trade?",
			"http://www.deviantart.com",
			$toSend,
			$cookie_jar
			);
			//Voila! If all the login info was correct, check your llama list for the most recent person and go to their page to see that you sent the llama. Have fun with that.
	}

		
	function c_shank($ns, $from, $message, $target) {
		$tg = args($message, 1);
		$tr = $this->Bot->trigger;
		$shanks = array(':stab: <b> >:C </b>',':stab: <b>D:< </b>',':thumb95624834:<b> >:C </b>',':thumb95624834: <b> D:< </b>',); //Set up the response list
		$shanking = $shanks[array_rand($shanks)]; //randomize the response list so it's not just one standard one
		if(empty($tg)){
			return $this->dAmn->say($ns,$from.": ". $shanking); //If you don't give someone to shank, it just shanks you instead :D
		}else
		foreach($this->user->list[100] as $mem => $k) { 					
			if(strtolower($k)==strtolower($from)) {							
				$cando = TRUE;
				$mj = $k;															
			}
		}
		if ($cando){
			return $this->dAmn->say($ns,$tg.": ". $shanking); 
			//If you're the owner, it just shanks who or whatever you tell it to. If not, it runs a filter stopping you from shanking the owner or bot. SAFETY! ;O
		}else 
			$noshank = FALSE;
			foreach($this->user->list[100] as $mem => $k) { 
				if(strtolower($k)==strtolower($tg)) {	
					$noshank = TRUE;
				}
			}
			if ($noshank) {
				return $this->dAmn->say($ns, $from.": ".$tg." cannot be shanked! :noes:");    //No touchy the owner. :C
			}else
			if (strtolower($tg) == strtolower($this->Bot->username)) {
				return $this->dAmn->say($ns, $from.": ".$tg." cannot be shanked! :noes:"); //No touchy the bot. :C
			}else
		return $this->dAmn->say($ns, $tg.": " .$shanking);	//Shanking time! C:
		}
	
	
	function c_google($ns,$from,$message,$target){
		$wat = args($message,1, true);
		$watt = args($message,1);
		$tr = $this->Bot->trigger;
		if(substr($watt,0,1)=='#' && is_numeric(str_replace('#','',$watt))){
			$lim=str_replace('#','',$watt);
			if($lim>4){
				$lim=4;
			}
			$quer=$wat;
		}else{
			$lim=3;
			$quer=$wat;
		}
		if($quer){
			$url="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=".$quer;
			$raw=file_get_contents($url);
			$json = json_decode($raw);
			if($json->responseStatus==200){
				$i=0;
				$say="<ul>";
				do{
					if($json->responseData->results[$i]->titleNoFormatting){
						$say.="<li><b><a href=\"".$json->responseData->results[$i]->url."\">".$json->responseData->results[$i]->titleNoFormatting."</a></b><br/><sub>".$json->responseData->results[$i]->content."<br/>".$json->responseData->results[$i]->visibleUrl." | <a href=\"".$json->responseData->results[$i]->cacheUrl."\">[Cache]</a></sub></li>";
						$i++;
					}
				}while($i!=$lim);
			}else{
				$say="fail: ".$json->responseDetails;
			}
		}else{
			$say="$from, I need at least one word to search.";
		}
		$this->dAmn->say($ns,$say);
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
					


	function token ($username, $password) {
	// Method to get the cookie! Yeah! :D       
		// Our first job is to open an SSL connection with our host.
		$socket = fsockopen("ssl://www.deviantart.com", 443);
		// If we didn't manage that, we need to exit!
		if($socket === false) {
		return array(
				'status' => 2,
				'error' => 'Could not open an internet connection.');
		}
		// Fill up the form payload
		$POST = '&username='.urlencode($username);
		$POST.= '&password='.urlencode($password);
		$POST.= '&remember_me=1';
		// And now we send our header and post data and retrieve the response.
		$response = $this->dAmn->send_headers(
			$socket,
			"www.deviantart.com",
			"/users/login",
			"http://www.deviantart.com/users/rockedout",
			$POST
		);
		// Now that we have our data, we can close the socket.
		fclose ($socket);
		//And now we do the normal stuff, like checking if the response was empty or not.
		if(empty($response))
		return array(
				'status' => 3,
				'error' => 'No response returned from the server.'
		);
		if(stripos($response, 'set-cookie') === false)
		return array(
				'status' => 4,
				'error' => 'No cookie returned.'
			);
		// Grab the cookies from the header
		$response=explode("\r\n", $response);
		$cookie_jar = array();
		foreach ($response as $line)
			if (strpos($line, "Set-Cookie:")!== false)
				$cookie_jar[] = substr($line, 12, strpos($line, "; ")-12);

		// Using these cookies, we're gonna go to chat.deviantart.com and get
		// our authtoken from the dAmn client.
		if (($socket = @fsockopen("ssl://www.deviantart.com", 443)) == false)
			 return array(
				'status' => 2,
				'error' => 'Could not open an internet connection.');

		$response = $this->dAmn->send_headers(
			$socket,
			"chat.deviantart.com",
			"/chat/Botdom",
			"http://chat.deviantart.com",
			null,
			$cookie_jar
		);
		// Now search for the authtoken in the response
		$cookie = null;
		if (($pos = strpos($response, "dAmn_Login( ")) !== false)
		{
			$response = substr($response, $pos+12);
			$cookie = substr($response, strpos($response, "\", ")+4, 32);
		}
		else //$dAmn->say($response ,"#randwewt");
		return array(
			'status' => 4,
			'error' => 'No authtoken found in dAmn client.'
		);
						  
		// Because errors still happen, we need to make sure we now have an array!
		if(!$cookie)
		return array(
				'status' => 5,
				'error' => 'Malformed cookie returned.'
		);
		// We got a valid cookie!
		return $cookie;
	}

} 

		

new dAmn_Magician($core);