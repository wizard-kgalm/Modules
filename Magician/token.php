<?php
include_once('modules/Magician/functions.php');
$tt=$config['bot']['trigger'];
switch($args[0]){
	case "token":
		if ($user->has($from,99)){
			switch($args[1]) {
				case "grab":																		// $token grab ID#. Fuck user-friendly. :')
					$say = "";
						if($args[2] !=""){															// I seem to have a penchant for trying to be overly obvious.
							if(is_numeric($args[2])){
								if(!isset($config['logins']['login'][$args[2]])){					// We learned how to use isset.
									$dAmn->say($f ."The ID you provided either does not exist, there aren't any logins stored, or an error has occurred. Please check the file to make sure everything is correct before continuing. Type '" .$config['bot']['trigger']."store logins list' to see the list of login IDs and the username associated with the IDs.",$c);
									return null;
								}else{
									$config['token']['username']=$config['logins']['login'][$args[2]][0];
									$config['token']['password']=$config['logins']['login'][$args[2]][1];
									save_config('token');
								}
								$dAmn->say($f."ID accepted. Grabbing authtoken.",$c); sleep(1);
								$say .="$from: ".token();
							}else
								$say .="$from: Usage: '".$config['bot']['trigger']."show token grab [#]'. See ".$config['bot']['trigger']."show logins list for the list of IDs stored.";
						}else
							$say .="$from: Usage: '".$config['bot']['trigger']."show token grab  [#]'. See ".$config['bot']['trigger']."show logins list for the list of IDs stored.";
							$dAmn->say($say, $c);
							break;
					case "manual":
						$say="";
						if($args[2] !=""){
							if($args[3] ==""){
								$dAmn->say("$from: Please put your password in the bot window.",$c);
								print "\nWhat is the password?\n";
								$args[3] = trim(fgets(STDIN));						
							}else
							if($args[3] !=""){
								$PW=$args[3];
								$UN=$args[2];
								$config['token']['username']=$UN;
								$config['token']['password']=$PW;
								save_config('token');
								$say .="$from: ".token();
							}else
								$say .="$from: You need to specify a username and password for this to work.";
						}else
							$say .="$from: Usage: ".$config['bot']['trigger']."show token manual 'username' 'password'. <br> *You can leave the password spot blank in either case to input the password directly to the bot.";
							$dAmn->say($say,$c);
						break;
							default:
								$dAmn->say($f."Usage: ".$config['bot']['trigger']."token grab/manual. Grab shows the user-specified ID's authtoken. If you don't know what authtokens are for or how to use them, I suggest you don't use this command.",$c);
			}break;
		}else
			$dAmn->say($f. "This command is for the bot owner only.",$c);
			return null;
			break;
	case "cookie":															// Cookie, doing 100% the same damn thing as $token.
		if($user->has($from,99)){
			switch($args[1]) {
				case "grab":												// $cookie grab ID#. I will say it again. Screw simplicity and fuck user-friendly. :')
					$say = "";
					if($args[2] !=""){
						if(is_numeric($args[2])){
							if(!isset($config['logins']['login'][$args[2]])){
								$dAmn->say($f ."The ID you provided either does not exist, there aren't any logins stored, or an error has occurred. Please check the file to make sure everything is correct before continuing. Type '" .$config['bot']['trigger']."store logins list' to see the list of login IDs and the username associated with the IDs.",$c);
							return null;
							}else{
								$config['token']['username']=$config['logins']['login'][$args[2]][0];
								$config['token']['password']=$config['logins']['login'][$args[2]][1];
								save_config('token');
							}
							$dAmn->say($f."ID accepted. Grabbing cookie.",$c); sleep(1);
							$say .="$from: ".cookie();
						}else
							$say .="$from: Usage: '".$config['bot']['trigger']."show cookie grab [#]'. See ".$config['bot']['trigger']."show logins list for the list of IDs stored.";
					}else
						$say .="$from: Usage: '".$config['bot']['trigger']."show cookie grab  [#]'. See ".$config['bot']['trigger']."show logins list for the list of IDs stored.";
			$dAmn->say($say, $c);
			break;
				case "manual":
					$say="";
					if($args[2] !=""){
						if($args[3] ==""){
							$dAmn->say("$from: Please put your password in the bot window.",$c); print "\nWhat is the password?\n"; $args[4] = trim(fgets(STDIN));
						}else
						if($args[3] !=""){
							$PW=$args[3];
							$UN=$args[2];
							$config['token']['username']=$UN;
							$config['token']['password']=$PW;
							save_config('token');
							$say .="$from: ".cookie();
						}else
							$say .="$from: You need to specify a username and password for this to work.";
					}else
						$say .="$from: Usage: ".$config['bot']['trigger']."show cookie manual 'username' 'password'. <br> *You can leave the password spot blank in either case to input the password directly to the bot.";
			$dAmn->say($say,$c);
			break;
				default:
					$dAmn->say($f."Usage: ".$config['bot']['trigger']."show cookie grab/manual. Grab shows the user-specified ID's cookie. If you don't know what cookies are for or how to use them, I strongly suggest you don't use this command.",$c);
				break; 
			}break;
		}else
			$dAmn->say($f. "This command is for the bot owner only.",$c);
			return null;
			break;
}