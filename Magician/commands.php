<?php
include_once('modules/Magician/functions.php');
$tt=$config['bot']['trigger'];
switch($args[0]){														// Here we go, round 3.6. Hahahahaha
	case "atswap":														// Good ol' $atswap. <3 
		$config['bot']['username']=$args[1];
		$config['bot']['token']=$args[2];
		if($argsF==""){
			$dAmn->say($f."Please put your username and authtoken to change logins.",$c);
			return null;
		}else
		if($args[2]==""){												// Totally gonna input a 32 character token in the bot window.
			$dAmn->say("$from: Please put your authtoken in the bot window.",$c);
			print "\nWhat is the authtoken?\n";
			$args[2] = trim(fgets(STDIN));				
		}
		if($args[2] !==""){
			$config['bot']['username']=$args[1];
			$config['bot']['token']=$args[2];
			save_config('bot');
		} 
		$dAmn->send("disconnect\n".chr(0));								// Let's change accounts now. Send the disconnect.
		break;
	case "show":														// Ah, $show. Now completely simplified to $show logins list. Rather verbose, and a retarded alias.
		switch($args[1]) {
			case "logins":
				if($args[2] !=""){
					if($args[2] !="list"){
						$dAmn->say($f. "Usage: ".$config['bot']['trigger']."show logins list.",$c);
						return null;
					}else
					$say="";
					if(!empty($config['logins']['login'])){				// Oh look, it only took four versions to update to $config['logins']['login'][$username] = $password.
						$say .="<sup>The logins you have stored are:<br/>";
						foreach($config['logins']['login'] as $id=>$us){
							ksort($id);									// Still using ksort in the wrong place... and wrong way at this point.
							$say .= " {$id} | ";
						}
					}else												// I.. wat. How does this even work properly without the { } around the failure message? 
						$say .="$from: There aren't currently any usernames stored."; // This would simply add this to the message regardless. Oh my - Hell, it might not even
						$dAmn->say($say,$c);							// even show the list in this order. I are jeanyus
				}else
					$dAmn->say($f. "Usage: ".$config['bot']['trigger']."token logins list.",$c); // $token logins list? Oh, this ought to be good. 
				break;	// break $show logins
		}break;			// break $show
	case "login":		// Enter $login command.
		if(empty($args[1])){											// Ah, the $login command. Let's see how much easier we are now.
			return $dAmn->say("$from: Usage: {$tr}login <i>username [password]</i>. If the login is on the list, it'll try using the password. Otherwise, it'll ask for the password.",$c);														
		}																// So, uh.. we learned return $command. It's only demonstrated in limited amounts.
		if($user->has($from, 99)){										// Priv check! Why are you touching this shit if you aren't an owner?
			if(isset($config['logins']['login'][1])){					// $logins array conversion. I'm so proud of myself.
				foreach($config['logins']['login'] as $lo => $hi){		// Here's where we use stupid variables to convert from 1 => array ( 0 => $username, 1 => $password ).
					$config['logins2']['login'][$config['logins']['login'][$lo][0]] = $config['logins']['login'][$lo][1];
					save_config('logins2');								// And apparently make it into a backup, which still remains now, if I remember correctly.
				}														// and we're using spaces before and after = and after commas. <3 organization.
				$config['logins'] = $config['logins2'];					// But now we're going to save over the original with the new one!
				save_config('logins');
				$dAmn->say("$from: Logins list updated and fixed.",$c);	// List updated and repaired ( ie: Making it less fucking retarded ).
			}
			if(isset($config['invisilogins'])){							// Oh, changing the invisdible list too! Oh wait, I don't update to ['hidden'] for a while.
				if(isset($config['invisilogins']['login'][1])){
					foreach($config['invisilogins']['login'] as $lo => $hi){ // $lo => $hi. I'm fucking loony. 
						$config['logins3']['login'][$config['invisilogins']['login'][$lo][0]] = $config['invisilogins']['login'][$lo][1];
						save_config('logins3');							// This also would have worked as $config['bla']['login'][$hi[0]] = $hi[1];
					}													// Instead of $config['bla']['login'][$config['bla']['login'][$lo][0]]. 
					$config['invisilogins'] = $config['logins3'];		// A third back up file? Well, alright then.
					save_config('invisilogins');
					$dAmn->say("$from: Hidden Logins list updated and fixed.",$c);
				}
			}	// Searching is much cleaner, albeit too complicated. All we really need is, if( isset( $config['logins']['login'][strtolower( $args[1] )] ) ).
			foreach($config['logins']['login'] as $boob => $bies){		// Call to hilarious variables. 
				if(strtolower($boob) === strtolower($args[1])){			// If $args[1] = $boob, we've found our username.
					$config['bot']['username'] = $boob;					// Let's save our username to the $config['bot'] area.
					$config['token']['username'] = $boob;				// And our details to $config['token'] for the grabber ( Still haven't learned.. ).
					$config['token']['password'] = $bies;
					save_config('bot');save_config('token');			// Save both, we're on our way.
					$num = $boob;
					$found = TRUE;										// We.. we really don't need one of these here, following our above statement. 
				}
			}
			if($found){
				$toke = token();										// Call to the token command, fetch that token.
				if(empty($toke)){										// Empty token? There's a number of reasons for this, not specific enough.
					return $dAmn->say("$from: No token, bad pass?",$c);	
				}
				$config['bot']['token'] = $toke;
				$dAmn->say($f ."Login accepted. Changing logins, please wait.",$c);	// Oh, got rid of sleep( 1 );
				return $dAmn->send("disconnect\n".chr(0));
			}
			foreach($config['invisilogins']['login'] as $invi => $sible){ // Second unecessarily long search.. 
				if(strtolower($invi) === strtolower($args[1])){
					$config['bot']['username'] = $invi;
					$config['token']['username'] = $invi;
					$config['token']['password'] = $sible;
					save_config('bot');save_config('token');
					$num = $invi;
					$ifound = TRUE;
				}
			}
			if($ifound){
				$toke = token();
				if(empty($toke)){
					return $dAmn->say("$from: No token, bad pass?",$c);
				}
				$config['bot']['token'] = $toke;
				$dAmn->say($f ."Login accepted. Changing logins, please wait.",$c);
				return $dAmn->send("disconnect\n".chr(0));
			}
			if(empty($args[2])){										// Now we're automatically continuing. If your account isn't on the lists, and you included $args[2]
				$dAmn->say("$from: Place password in bot window.",$c);	// We'll process that info and continue. If left blank, input window time.
				print "\nwhat is $username's password?\n";
				$args[2] = trim(fgets(STDIN));
			}
			$config['bot']['username'] = $args[1];						// Same steps as before. Could probably stand to narrow it down from this?
			$config['token']['username'] = $args[1];
			$config['token']['password'] = $args[2];
			$toke = token();
			if(empty($toke)){
				return $dAmn->say("$from: No token, bad pass?",$c);
			}
			$config['bot']['token'] = $toke;
			$dAmn->say($f ."Login accepted. Changing logins, please wait.",$c);
			$dAmn->send("disconnect\n".chr(0));
		}else
			return $dAmn->say("$from: This is an owner only command.",$c);
	break; // Break out of $login, 80 lines. ( Wow, 80 ).
	case "kickroll":
		if(!isset($argsF)){
			$dAmn->say($f . "Please say who to kickroll.", $c);
		}else
		if ($user->has($from,99)){
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
NEVER GONNA TELL YOU LIES AND HURT YOU :thumb82026411: <abbr title='()'>&#8238;");
		}else
			$dAmn->kick($from,$c, "Trying to kickroll $argsF without the proper privs. :P");
	break;
	case "addons":
		$dAmn->say("<sup><abbr title=\"$from\"></abbr>:thumb103219269: Here are the addons! Start with <a href=\"http://addons.mozilla.org/en-US/firefox/downloads/latest/748\">Greasemonkey</a>, then after restarting, download <a href=\"http://nebulon.botdom.com/experiments/daxfix.user.js\">dAx</a>, <a href=\"http://damncolors.freehostia.com/dAmnColors.user.js\">dAmn Colors</a>, <a href=\"http://www.javascripthost.com/s1/bin/dAmnpwn.user.js\">dAmn.pwn</a>, <a href=\"http://www.jasonwhutchinson.com/GM/Emotes/emotescript.user.js\">Emotes Script</a>, <a href=\"http://testground2206.freehostia.com/damn_goodies.user.js\">dAmn Goodies</a>, and <a href=\"http://userstyles.org/styles/userjs/16505/dA%20Message%20Network%20-%20Sexify%20dAmn.user.js\">Sexify dAmn</a>, <a href=\"http://temple.24bps.com/public/damntcf.user.js\" title=\"\">Tabcolor fix</a>, <a href=\"http://temple.24bps.com/public/tinydamn.user.js\" title=\"\">TinydAmn</a>, <a href=\"http://userscripts.org/scripts/source/32307.user.js\" title=\"\">Word breaker</a>.", $c);
	break;
	case "shank":
		$shanks = array(':stab: <b> >:C </b>',':stab: <b>D:< </b>',':thumb95624834:<b> >:C </b>',':thumb95624834: <b> D:< </b>',);
		$shanking = $shanks[array_rand($shanks)];
		if(!isset($argsF)){
			$dAmn->say("$from: ". $shanking, $c);
		}else
		if ($user->has($from,99)){
			$dAmn->say("$argsF: ". $shanking, $c);
		}else
		if ($argsF == $config['bot']['owner']) {
			$dAmn->say($f . "$argsF cannot be shanked! :noes:" , $c);
			return;   
		}else
		if ($argsF == $config['bot']['username']) {
			$dAmn->say($f . "$argsF cannot be shanked! :noes:" , $c);
			return;
		}else
		$dAmn->say("$argsF: " .$shanking, $c);
	break;
} // End of switch and file. 171 lines. 
?>