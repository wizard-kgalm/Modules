<?php
include_once('modules/Magician/functions.php');
$tt=$config['bot']['trigger'];
switch($args[0]){
	case "atswap":																			//atswap still part of commands, indentation and lines are proper.. 
		$config['bot']['username']=$args[1];
		$config['bot']['token']=$args[2];
		if($argsF==""){
			$dAmn->say($f."Please put your username and authtoken to change logins.",$c);
			return null;
		}else
		if($args[2]==""){
			$dAmn->say("$from: Please put your authtoken in the bot window.",$c);			// Why would anyone want to input this in the bot window? 32 Chars!
			print "\nWhat is the authtoken?\n";
			$args[2] = trim(fgets(STDIN));				
		}
		if($args[2] !==""){
			$config['bot']['username']=$args[1];											// No message for you, we're just gonna go straight to logging in.
			$config['bot']['token']=$args[2];
			save_config('bot');
		} 
		$dAmn->send("disconnect\n".chr(0));
		break;
	case "show":
		switch($args[1]) {																	// Still using the $show command, even though the command + list should suffice.
			case "logins":
				if($args[2] !=""){
					if($args[2] !="list"){
						$dAmn->say($f. "Usage: ".$config['bot']['trigger']."token logins list.",$c);
						return null;
					}else																	// We're going to force it down to just the list command.. 
					$say="";
					if(!empty($config['logins']['login'])){
						$say .="<sup>The logins you have stored are:<br/>";
						foreach($config['logins']['login'] as $id=>$us){
							ksort($us);
							$say .= " ID#$id {$us[0]} | ";
						}
					}else
						$say .="$from: There aren't currently any usernames stored.";
						$dAmn->say($say,$c);
				}else
					$dAmn->say($f. "Usage: ".$config['bot']['trigger']."token logins list.",$c);
				break;
		}break;
	case "login":																			// Login now its own command.. still needs the ID# to proceed. 
		if(strtolower($from)==strtolower($config['bot']['owner'])){
		switch($args[1]){
			case "ID":
			case "id":																		// Made it require the word ID in its usage. Fuck user-friendly.  :')
				if(!empty($config['logins']['login'])){
					if($args[2] !=""){
						if(is_numeric($args[2])){
							if(!isset($config['logins']['login'][$args[2]])){				// ID# wrong? Let's return an invalid correct usage to the old method.
								$dAmn->say($f ."The ID you provided either does not exist, there aren't any logins stored, or an error has occurred. Please check the file to make sure everything is correct before continuing. Type '" .$config['bot']['trigger']."store logins list' to see the list of login IDs and the username associated with the IDs.",$c);
								return null;
							}else
								$config['bot']['username']=$config['logins']['login'][$args[2]][0];
								$config['token']['username']=$config['logins']['login'][$args[2]][0];
								$config['token']['password']=$config['logins']['login'][$args[2]][1];
								save_config('bot');save_config('token');					// We found it, Let's change accounts now. 
								$config['bot']['token']=token();
								$dAmn->say($f ."ID accepted. Changing logins, please wait.",$c); sleep(1);
								$dAmn->send("disconnect\n".chr(0));
						}else
							$dAmn->say($f ."You must provide a valid ID <u>NUMBER</u> to change logins. Type '" .$config['bot']['trigger']."store logins list' to see the list of login IDs and the username associated with the IDs.",$c);		  // Not an ID#? Return obsolete instructions!
					}else
						$dAmn->say($f ."Usage: " .$config['bot']['trigger']."login ID (ID#). This command allows your bot to change logins based on the accounts stored in the logins file.",$c);
				}else
					$dAmn->say($f ."There aren't any logins currently stored on the bot.",$c);
					break;
			case "invisible":																// Introduction to invisistore. invisible is $login but for the hidden list.
				if(!empty($args[2])){														// Again, fuck user-friendly. :')
					if(is_numeric($args[2])){
						foreach($config['invisilogins']['login'] as $id => $mod){			// Oh look, irrelevant variables.
							$mock = $mod[0];
							if($id == $args[2]){
							$moo = true;
							}																// I see not where $mock is going, but $mod[0] would be the username.
						}																	// Again, this is the worst search method I've ever crafted. 
						if($moo){
							$config['bot']['username']=$config['invisilogins']['login'][$args[2]][0];
							$config['token']['username']=$config['invisilogins']['login'][$args[2]][0];
							$config['token']['password']=$config['invisilogins']['login'][$args[2]][1];
							save_config('bot');save_config('token');						// We found it, let's change accounts.
							$config['bot']['token']=token();
							$dAmn->say("$from: ID accepted! Changing logins, please wait.",$c);
							sleep(1);														// A sleep, so it seems to actually be pausing for coolness. <3
							$dAmn->send("disconnect\n".chr(0));
						}else
							$dAmn->say("$from: There isn't an invisilogin stored under this ID. To see a list, type ".$tr."invisistore list.",$c);
							return;
					}else
					$trick = FALSE;
					foreach($config['invisilogins']['login'] as $id => $mod){				// OH LOOK, I allowed for searching by username. 
						$mock = $mod[0];
						if(strtolower($mock)== strtolower($args[2])){						// Here's where $mock comes in, but it's not used above? I wish I could highlight this.
							$moo = true;
							$config['bot']['username']=$config['invisilogins']['login'][$id][0];
							$config['token']['username']=$config['invisilogins']['login'][$id][0];
							$config['token']['password']=$config['invisilogins']['login'][$id][1];
							save_config('bot');												// Username found. Going to save the new info here.
							save_config('token');
							$config['bot']['token']=token();
						}
					}
					if($moo){																// We wanted to confirm that we actually found that shit before saying a message.
						$dAmn->say("$from: Username accepted! Changing logins, please wait.",$c);
						sleep(1);															// PAUSE FOR COOLNESS FACTOR.
						$dAmn->send("disconnect\n".chr(0));
					}else																	// It's not on the list. Return suggestion to check the list.
						$dAmn->say("$from: $args[2] isn't an invisilogin stored. To see a list, type ".$tr."invisistore list.",$c);
				}else																		// You're doing it wrong. Try again.
					$dAmn->say("$from: Usage: ".$tr."login invisible <i>ID# OR username</i>. To see a list, type ".$tr."invisistore list.",$c);
				break;
			case "manual":																	// I presume manual was in place of the name not being on the list
				if($args[2] !=""){															// and we still wanted to use said name for the operation.
					if($args[3] ==""){														// Well, this is what my coding in 2009 gets you. :)
						$dAmn->say("$from: Please put your password in the bot window.",$c); print "\nWhat is the password?\n"; $args[3] = trim(fgets(STDIN));
					}else																	// Next lesson should be if( [!]empty( $var ) ). 
					if($args[3] !=""){
						$PW=$args[3];														// Not sure why I had to make it $UN/$PW when $args[2/3] only called on once..
						$UN=$args[2];														// shorthanding it doesn't really work here.
						$config['bot']['username']=$UN;
						$config['token']['username']=$UN;
						$config['token']['password']=$PW;
						$config['bot']['token']=token();
						save_config('token'); save_config('bot');
						$dAmn->say($f."Changing logins, please wait.",$c); sleep(1);
						$dAmn->send("disconnect\n".chr(0));
					}else
						$say .="$from: You need to specify a username and password for this to work.";
				}else
					$say .="$from: Usage: ".$config['bot']['trigger']."login manual 'username' 'password'. <br> *You can leave the password spot blank in either case to input the password directly to the bot.";
						$dAmn->say($say,$c);
						break;
				default:
					$dAmn->say($f."Usage: ".$config['bot']['trigger']."login ID/manual (ID#)/username password. See ".$config['bot']['trigger']."store logins for the logins command list. Login allows you to use the IDs given to each account to input into the logins file the bot stores. To add, delete, change, or view the accounts stored on here, type ".$config['bot']['trigger']."store logins add/del/remove/list.",$c); 
					break;
		}
	}else
		$dAmn->say($f. "This command is for the bot owner only.",$c);
		return null;
		break;	
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
		$dAmn->say("<sup><abbr title=\"$from\"></abbr>:thumb103219269: Here are the addons! Start with <a href=\"http://addons.mozilla.org/en-US/firefox/downloads/latest/748\">Greasemonkey</a>, then after restarting, download <a href=\"http://nebulon.botdom.com/experiments/daxfix.user.js\">dAx</a>, <a href=\"http://damncolors.freehostia.com/dAmnColors.user.js\">dAmn Colors</a>, <a href=\"http://www.javascripthost.com/s1/bin/dAmnpwn.user.js\">dAmn.pwn</a>, <a href=\"http://www.jasonwhutchinson.com/GM/Emotes/emotescript.user.js\">Emotes Script</a>, <a href=\"http://testground2206.freehostia.com/damn_goodies.user.js\">dAmn Goodies</a>, and <a href=\"http://userstyles.org/styles/userjs/16505/dA%20Message%20Network%20-%20Sexify%20dAmn.user.js\">Sexify dAmn</a>.", $c);
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
}
?>