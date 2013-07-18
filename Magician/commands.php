<?php
include_once('modules/Magician/functions.php');
switch($args[0]) {
	case "store":	// Store. The pretext to $logins. It's an $argument too deep. I felt that when I made it, but I simply ignored that instinct.
		if($from ==$config['bot']['owner']){	// Because only I may add logins to MY bot.
			switch($args[1]) {
				case "logins":	// This is where it really began. Honestly, {$tr}store was unnecessary. The pretext to this was {$tr}passport, which I still think is a cool name.
					if($args[2] ==""){
					if(empty ($config['logins'])){  $dAmn->say($f ."You haven't created a list of built in logins yet. Type ".$config['bot']['trigger']."store logins add 'Username' 'password' to start compiling a list.", $c); return null;} // I'm not really sure I understand why I put this here.
					else $dAmn->say($f ."Usage: ".$config['bot']['trigger']."store logins add/change/del/list",$c);}else 
					switch($args[2]) {
						case "add":
							if($args[3]==""){$dAmn->say($f ."Type a username and password to add to the bot's stored login file.",$c); return null;} //Ugh, that dreaded input.
							if($args[4]==""){$dAmn->say("$from: Please put your password in the bot window.",$c); print "\nWhat is the password?\n"; $args[4] = trim(fgets(STDIN));}
							if($args[4] !=""){$logins = array( 'username'=>$args[3], 'password'=>$args[4],); // Lol array. 
							if(!in_array(  $logins['username']  , $config['logins']['login'])){	// A bunch of if statements on the same indentation. 
								$found=false; $i=0; while (!$found){	// This is the worst method of searching I've ever seen. 
									if (!isset($config['logins']['login'][$i])){ // Not sure what's with the waste of lines here, but I'm condensing this as I go along.
									 $found=true;
									} else {
									$i++;}		}	// I.. wow. That was a waste of time, for an ID system that would have simply worked as $config['logins'][] = $logins; Oh well.
								$config['logins']['login'][$i][]=$logins['username'];
								$config['logins']['login'][$i][]=$logins['password']; // </space> below.
								save_config('logins'); $say="$from: $args[3] has been successfully added as ID $i.";} else $say="$from: You've already added this username. Please check the file to make sure it's correct if you're sure you haven't."; // Uh. and with no strtolower( $args[3] ); either. I'm a real winrar.
								} else	$dAmn->say($f ."You need to put a password in order to add an account to the list.",$c);
								$dAmn->say($say, $c);
								break;
						case "change":
							if($args[3] !=""){								// Ah, the good ol' change command.
								if(!isset($config['logins']['login'][$args[3]])){
									$dAmn->say($f ."The ID you provided was invalid. Type '" .$config['bot']['trigger']."store logins list' for a list of login IDs and the username associated with that ID.",$c);}		// Because relying on an ID system was awesome.. (instead of a username)
										else if($args[4]==""){$dAmn->say($f ."Please put your password in the bot window.",$c); print "\nWhat is the password?\n"; $args[4] = trim(fgets(STDIN));}						// More of that fucking input stuff. Works great if you're actually hosting the bot. 
										if($args[4] !=""){
									$config['logins']['login'][$args[3]][1]=$args[4]; // Mm good ol' ID - password.
								save_config('logins');$dAmn->say($f ."Password successfully updated.",$c);}
								else $dAmn->say($f ."You need to provide a password to change the current one to.",$c);} // It's easier to do an if( empty( $args ) ) and return there.
							else $dAmn->say($f ."You need to provide a valid ID number along with an updated password to change the login information stored for said ID. Type '" .$config['bot']['trigger']."store logins list' for a list of login IDs and the username associated with that ID.",$c);
							break;
						case "list":
							$say="";	// Setting up the list.. Checking it twice.
							if(!empty($config['logins']['login'])){
							$say .="<sup>The logins you have stored are:<br/>";
							foreach($config['logins']['login'] as $id=>$us){ // We want $us[0] because the username is under the first entry.							
							ksort($us);										 // Doesn't really make sense to sort it here, but alright. 
							$say .= " ID#$id {$us[0]} | ";}					 // Want to share the ID number so you can change entries there. 
							} else $say .="$from: There aren't currently any usernames stored.";
							$dAmn->say($say,$c);							 // All done, let's output the final message.
							break;
						case "all":											 // This is for showing ID# Username => Password. 
							$say="";
							if(!empty($config['logins']['login'])){			 // Must make sure the list isn't empty.
							if($args[3] !=""){								 // We want a third argument (confirm) so we know you're aware you're about to show the passwords.
							if($args[3] !="confirm"){						 // You gave a third arg, but it wasn't confirm. return correct usage.
							$dAmn->say($f. "This command will show the stored passwords as well as the usernames. Type ".$config['bot']['trigger']."store logins all confirm to use this command.",$c);return null;}
							else											 // Now, we'll set up the list. It's exactly the same as the previous command.
							$say .="<sup>The logins you have stored are:<br/>";
							foreach($config['logins']['login'] as $id=>$us){							
							ksort($us);
							$say .= " ID#$id {$us[0]} ==> {$us[1]} | ";}							
							}else $dAmn->say($f. "This command will show the stored passwords as well as the usernames. Type ".$config['bot']['trigger']."store logins all confirm to use this command.",$c);}							// No third argument, return correct usage.
							else $say .="$from: There aren't currently any usernames stored.";
							$dAmn->say($say,$c);
							break;
						case "del":
						case "remove":
							if(!empty($config['logins']['login'])){			  // We used just del/remove for this one. Flexibility is key in satisfying the masses.
							if($args[3] !=""){
							if(!isset($config['logins']['login'][$args[3]])){ // If your ID number is invalid, let's suggest you check the list. 
								$dAmn->say($f ."The ID you provided either does not exist, there aren't any logins stored, or an error has occurred. Please check the file to make sure everything is correct before continuing. Type '" .$config['bot']['trigger']."store logins list' to see the list of login IDs and the username associated with the IDs.",$c); return null;}
							else						
						array_splice($config['logins']['login'], $args[3],1); // array_splice to remove that segment of the array. (instead of unset). 
						save_config('logins');
						$dAmn->say($f ."Username ID $args[3] has been deleted successfully.",$c);} 					
						else $dAmn->say($f ."Type a username ID to remove from the list of logins.",$c); }
						else $dAmn->say($f ."There aren't any IDs for you to remove. Type ".$config['bot']['trigger']."store logins add 'Username' 'password' to start compiling a list.", $c);											 // You gave the wrong ID. Return correct usage.
						break;												  // Break out of store logins delete.
						} break;											  // Break out of store logins.
				case "login":												  // store login changes the bot's login. This is the remake of $passport using stored accounts.
				if(!empty($config['logins']['login'])){
					if($args[2] !=""){
						if(is_numeric($args[2])){
							if(!isset($config['logins']['login'][$args[2]])){ // No ID number exists. Suggest consulting the logins list.
								$dAmn->say($f ."The ID you provided either does not exist, there aren't any logins stored, or an error has occurred. Please check the file to make sure everything is correct before continuing. Type '" .$config['bot']['trigger']."store logins list' to see the list of login IDs and the username associated with the IDs.",$c); return null;}
							else $config['bot']['username']=$config['logins']['login'][$args[2]][0]; // Replace bot username with new username.
								$config['token']['username']=$config['logins']['login'][$args[2]][0];// Replace the token command username with new username.
								$config['token']['password']=$config['logins']['login'][$args[2]][1];// Add in the password so it can grab the token.
								save_config('bot');save_config('token');							 // Save those config files, so it can get to work.
								$config['bot']['token']=token();									 // Grab new token..
								$dAmn->say($f ."ID accepted. Changing logins, please wait.",$c); sleep(1);
								$dAmn->send("disconnect\n".chr(0));}								 // Success? Let's send the disconnect packet to change accounts.
						else $dAmn->say($f ."You must provide a valid ID <u>NUMBER</u> to change logins. Type '" .$config['bot']['trigger']."store logins list' to see the list of login IDs and the username associated with the IDs.",$c);}					// Didn't use a number, return correct usage.
					else $dAmn->say($f ."Usage: " .$config['bot']['trigger']."store login (ID#). This command allows your bot to change logins based on the accounts stored in the logins file.",$c);}
					else $dAmn->say($f ."There aren't any logins currently stored on the bot.",$c);
					break;
				case "manual":
					if($args[2] !=""){
						if($args[3] ==""){
						$dAmn->say("$from: Please put your password in the bot window.",$c); print "\nWhat is the password?\n"; $args[3] = trim(fgets(STDIN));
						}else if($args[3] !=""){
						$PW=$args[3];
						$UN=$args[2];
						$config['bot']['username']=$UN;
						$config['token']['username']=$UN;
						$config['token']['password']=$PW;
						$config['bot']['token']=token();
						save_config('token'); save_config('bot');
						$dAmn->say($f."Changing logins, please wait.",$c); sleep(1);
						$dAmn->send("disconnect\n".chr(0));
						}else $say .="$from: You need to specify a username and password for this to work.";
						}else $say .="$from: Usage: ".$config['bot']['trigger']."store manual 'username' 'password'. <br> *You can leave the password spot blank in either case to input the password directly to the bot.";
						$dAmn->say($say,$c);
						break;
				default:
					$dAmn->say($f."Usage: ".$config['bot']['trigger']."store logins/login/manual. See ".$config['bot']['trigger']."store logins for the logins command list. Login allows you to use the IDs given to each account to input into the logins file the bot stores. To add, delete, change, or view the accounts stored on here, type ".$config['bot']['trigger']."store logins add/del/remove/list.",$c); 
					break;
				}
		break;}else $dAmn->say($f. "This command is for the bot owner only.",$c); return null; break;
	case "atswap":
		$config['bot']['username']=$args[1];$config['bot']['token']=$args[2];
		if($argsF==""){$dAmn->say($f."Please put your username and authtoken to change logins.",$c);return null;
		}else if($args[2]==""){$dAmn->say("$from: Sorry, but you must put both your username and authtoken to use this command.",$c);return null;}
		if($args[2] !==""){$config['bot']['username']=$args[1];$config['bot']['token']=$args[2]; save_config('bot');} $dAmn->send("disconnect\n".chr(0));
		break;
	case "show":								// This command is simply to "show" what we have. The list, or grab the token/cookie.
		if($from ==$config['bot']['owner']){
		switch($args[1]) {
			case "logins":
					if($args[2] !=""){
					if($args[2] !="list"){
					$dAmn->say($f. "Usage: ".$config['bot']['trigger']."token logins list.",$c);return null;}
					else $say="";
							if(!empty($config['logins']['login'])){
							$say .="<sup>The logins you have stored are:<br/>";
							foreach($config['logins']['login'] as $id=>$us){
							
							ksort($us);
							$say .= " ID#$id {$us[0]} | ";}
							} else $say .="$from: There aren't currently any usernames stored.";
							$dAmn->say($say,$c);}
					else $dAmn->say($f. "Usage: ".$config['bot']['trigger']."token logins list.",$c);
							break;
			case "token":
				switch($args[2]) {
					case "grab":
						$say = "";
							if($args[3] !=""){
							if(is_numeric($args[3])){
								if(!isset($config['logins']['login'][$args[3]])){
									$dAmn->say($f ."The ID you provided either does not exist, there aren't any logins stored, or an error has occurred. Please check the file to make sure everything is correct before continuing. Type '" .$config['bot']['trigger']."store logins list' to see the list of login IDs and the username associated with the IDs.",$c); return null;}
								else {$config['token']['username']=$config['logins']['login'][$args[3]][0];
									$config['token']['password']=$config['logins']['login'][$args[3]][1];
									save_config('token');}
									$dAmn->say($f."ID accepted. Grabbing authtoken.",$c); sleep(1);
									$say .="$from: ".token();
								}else $say .="$from: Usage: '".$config['bot']['trigger']."show token grab [#]'. See ".$config['bot']['trigger']."show logins list for the list of IDs stored.";
							} else $say .="$from: Usage: '".$config['bot']['trigger']."show token grab  [#]'. See ".$config['bot']['trigger']."show logins list for the list of IDs stored.";
							$dAmn->say($say, $c);
							break;
					case "manual":
						$say="";
						if($args[3] !=""){
						if($args[4] ==""){
						$dAmn->say("$from: Please put your password in the bot window.",$c); print "\nWhat is the password?\n"; $args[4] = trim(fgets(STDIN));
						}else if($args[4] !=""){
						$PW=$args[4];
						$UN=$args[3];
						$config['token']['username']=$UN;
						$config['token']['password']=$PW;
						save_config('token');
						$say .="$from: ".token();
						}else $say .="$from: You need to specify a username and password for this to work.";
						}else $say .="$from: Usage: ".$config['bot']['trigger']."show token manual 'username' 'password'. <br> *You can leave the password spot blank in either case to input the password directly to the bot.";
						$dAmn->say($say,$c);
						break;
					default:
						$dAmn->say($f."Usage: ".$config['bot']['trigger']."show token grab/manual. Grab shows the user-specified ID's authtoken. If you don't know what authtokens are for or how to use them, I suggest you don't use this command.",$c);
						}
					break;
			case "cookie":
				switch($args[2]) {
				case "grab":
					$say = "";
						if($args[3] !=""){
						if(is_numeric($args[3])){
							if(!isset($config['logins']['login'][$args[3]])){
								$dAmn->say($f ."The ID you provided either does not exist, there aren't any logins stored, or an error has occurred. Please check the file to make sure everything is correct before continuing. Type '" .$config['bot']['trigger']."store logins list' to see the list of login IDs and the username associated with the IDs.",$c); return null;}
							else {$config['token']['username']=$config['logins']['login'][$args[3]][0];
								$config['token']['password']=$config['logins']['login'][$args[3]][1];
								save_config('token');}
								$dAmn->say($f."ID accepted. Grabbing cookie.",$c); sleep(1);
								$say .="$from: ".cookie();
							}else $say .="$from: Usage: '".$config['bot']['trigger']."show cookie grab [#]'. See ".$config['bot']['trigger']."show logins list for the list of IDs stored.";
						} else $say .="$from: Usage: '".$config['bot']['trigger']."show cookie grab  [#]'. See ".$config['bot']['trigger']."show logins list for the list of IDs stored.";
						$dAmn->say($say, $c);
						break;
				case "manual":
					$say="";
					if($args[3] !=""){
					if($args[4] ==""){
					$dAmn->say("$from: Please put your password in the bot window.",$c); print "\nWhat is the password?\n"; $args[4] = trim(fgets(STDIN));
					}else if($args[4] !=""){
					$PW=$args[4];
					$UN=$args[3];
					$config['token']['username']=$UN;
					$config['token']['password']=$PW;
					save_config('token');
					$say .="$from: ".cookie();
					}else $say .="$from: You need to specify a username and password for this to work.";
					}else $say .="$from: Usage: ".$config['bot']['trigger']."show cookie manual 'username' 'password'. <br> *You can leave the password spot blank in either case to input the password directly to the bot.";
					$dAmn->say($say,$c);
					break;
				default:
					$dAmn->say($f."Usage: ".$config['bot']['trigger']."show cookie grab/manual. Grab shows the user-specified ID's cookie. If you don't know what cookies are for or how to use them, I strongly suggest you don't use this command.",$c);
					} break;
				}break;
				}else $dAmn->say($f. "This command is for the bot owner only.",$c); return null; break;
	case "kickroll":
		if(!isset($argsF)){ $dAmn->say($f . "Please say who to kickroll.", $c);
		}else if ($user->has($from,99)){
			$dAmn->say("$argsE[1], Prepare to be Rolled." , $c); 
			sleep(0);
				$dAmn->kick($argsE[1], $c, "$argsE[2] :thumb82026411: WE'RE NO STRANGERS TO LOVE
YOU KNOW THE RULES, AND SO DO I
A FULL COMMITMENT'S WHAT I'M THINKING OF
YOU WOULDN'T GET THAT FROM ANY OTHER GUY
I JUST WANT TO TELL YOU HOW I'M FEELING
GOTTA MAKE YOU UNDERSTAND
NEVER GONNA GIVE YOU UP
NEVER GONNA LET YOU DOWN
NEVER GONNA RUN AROUND AND DESERT YOU
NEVER GONNA MAKE YOU CRY
NEVER GONNA SAY GOODBYE
NEVER GONNA TELL YOU LIES AND HURT YOU :thumb82026411: <abbr title='(autokicked)'>&#8238;");
		}else $dAmn->kick($from,$c, "Trying to kickroll $argsF without the proper privs. :P");break;

	case "addons":
		$dAmn->say("<sup><abbr title=\"$from\"></abbr>:thumb103219269: Here are the addons! Start with <a href=\"http://addons.mozilla.org/en-US/firefox/downloads/latest/748\">Greasemonkey</a>, then after restarting, download <a href=\"http://nebulon.botdom.com/experiments/daxfix.user.js\">dAx</a>, <a href=\"http://damncolors.freehostia.com/dAmnColors.user.js\">dAmn Colors</a>, <a href=\"http://www.javascripthost.com/s1/bin/dAmnpwn.user.js\">dAmn.pwn</a>, <a href=\"http://www.jasonwhutchinson.com/GM/Emotes/emotescript.user.js\">Emotes Script</a>, <a href=\"http://testground2206.freehostia.com/damn_goodies.user.js\">dAmn Goodies</a>, and <a href=\"http://userstyles.org/styles/userjs/16505/dA%20Message%20Network%20-%20Sexify%20dAmn.user.js\">Sexify dAmn</a>.", $c);break;
	case "shank":
		if(!isset($argsF)){ $dAmn->say($f . "Please specify a user to shank!", $c);return; }
		else
		if ($user->has($from,99)){
		$dAmn->say("$argsF: :stab: <b> >:C </b>" , $c);
		}else
		if ($argsF == $config['bot']['owner']) {
		$dAmn->say($f . "$argsF cannot be shanked! :noes:" , $c);return;   
		}else
			if ($argsF == $config['bot']['username']) {
				$dAmn->say($f . "$argsF cannot be shanked! :noes:" , $c);return;
		}else
		$dAmn->say("$argsF: :stab: <b> D:<</b>" , $c);break;
}

?>