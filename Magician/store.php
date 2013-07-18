<?php
include_once('modules/Magician/functions.php');
$tt=$config['bot']['trigger'];
switch($args[0]) {
	case "store":
		if($from ==$config['bot']['owner']){
			switch($args[1]) {
				case "logins":
				if($args[2] ==""){
					if(empty ($config['logins'])){
						$dAmn->say($f ."You haven't created a list of built in logins yet. Type ".$config['bot']['trigger']."store logins add 'Username' 'password' to start compiling a list.", $c);
						return null;
					}
					else $dAmn->say($f ."Usage: ".$config['bot']['trigger']."store logins add/change/del/list",$c);}else 
				switch($args[2]) {
					case "add":
						if($args[3]==""){
							$dAmn->say($f ."Type a username and password to add to the bot's stored login file.",$c);
							return null;
						}
						if($args[4]==""){
							$dAmn->say("$from: Please put your password in the bot window.",$c);
							print "\nWhat is the password?\n";
							$args[4] = trim(fgets(STDIN));
						}
						if($args[4] !=""){
							$logins = array( 'username' => $args[3], 'password' => $args[4], ); 
							if(!in_array(  $logins['username'], $config['logins']['login'])){
								$found=false;
								$i=0;
								while (!$found){
									if (!isset($config['logins']['login'][$i])){
										$found=true;
									} else {
									$i++;
									}		
								}
								
								$config['logins']['login'][$i][]=$logins['username'];
								$config['logins']['login'][$i][]=$logins['password'];
								
								save_config('logins'); 
								$say = "$from: $args[3] has been successfully added as ID $i.";
							} else 
								$say = "$from: You've already added this username. Please check the file to make sure it's correct if you're sure you haven't.";
						}else
							$dAmn->say($f ."You need to put a password in order to add an account to the list.",$c);
						$dAmn->say($say, $c);
						break;
					case "change":
						if($args[3] !=""){
							if(!isset($config['logins']['login'][$args[3]])){
								$dAmn->say($f ."The ID you provided was invalid. Type '" .$config['bot']['trigger']."store logins list' for a list of login IDs and the username associated with that ID.",$c);
							}else
						if($args[4]==""){
							$dAmn->say($f ."Please put your password in the bot window.",$c);
							print "\nWhat is the password?\n";
							$args[4] = trim(fgets(STDIN));
						}
						if($args[4] !=""){
							$config['logins']['login'][$args[3]][1]=$args[4];
							save_config('logins');
							$dAmn->say($f ."Password successfully updated.",$c);
						}else
							$dAmn->say($f ."You need to provide a password to change the current one to.",$c);
						}else 
							$dAmn->say($f ."You need to provide a valid ID number along with an updated password to change the login information stored for said ID. Type '" .$config['bot']['trigger']."store logins list' for a list of login IDs and the username associated with that ID.",$c);
						break;
					case "list":
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
						break;
					case "all":
						$say="";
						if(!empty($config['logins']['login'])){
							if($args[3] !=""){
								if($args[3] !="confirm"){
									$dAmn->say($f. "This command will show the stored passwords as well as the usernames. Type ".$config['bot']['trigger']."store logins all confirm to use this command.",$c);
									return null;
								}else
									$say .="<sup>The logins you have stored are:<br/>";
									foreach($config['logins']['login'] as $id=>$us){
										ksort($us);
										$say .= " ID#$id {$us[0]} ==> {$us[1]} | ";
									}						
							}else
								$dAmn->say($f. "This command will show the stored passwords as well as the usernames. Type ".$config['bot']['trigger']."store logins all confirm to use this command.",$c);
						}else
							$say .="$from: There aren't currently any usernames stored.";
							$dAmn->say($say,$c);
						break;
					case "delete":
						foreach($config['logins']['login'] as $id => $mod){
							$mock = $mod[0];
							$moo = false;
							if(strtolower($args[3])== strtolower($mock)){
								$moo = true;
							}
						}
						if(in_array(strtolower($args[3]),strtolower($mock))){
							$ho=$args[3];
						}
						foreach($config['logins']['login'] as $h=>$o){
							if (strtolower($ho) == strtolower($o[0])){
								$d=true;
								$config['logins']['login'][$h]=strtolower($o[0]);
								$config['logins']['login'][$h]=null;
							}
						}
						if($moo){
							unset($config['logins']['login'][$h]);
							sort($config['logins']['login']);
							save_config('logins');
							$dAmn->say("$from: $args[2] was successfully removed from the list!",$c);
						}else
							$dAmn->say("$from: $args[2] isn't a login stored. Type ".$tt."store logins list to see a list of usernames stored.",$c);
						break;	
					case "del":
					case "remove":
						if(!empty($config['logins']['login'])){
							if($args[3] !=""){
								if(!isset($config['logins']['login'][$args[3]])){
									$dAmn->say($f ."The ID you provided either does not exist, there aren't any logins stored, or an error has occurred. Please check the file to make sure everything is correct before continuing. Type '" .$config['bot']['trigger']."store logins list' to see the list of login IDs and the username associated with the IDs.",$c);
									return null;
								}else
								array_splice($config['logins']['login'], $args[3],1);
								save_config('logins');
								$dAmn->say($f ."Username ID $args[3] has been deleted successfully.",$c);
							}else
								$dAmn->say($f ."Type a username ID to remove from the list of logins.",$c);
						}else
							$dAmn->say($f ."There aren't any IDs for you to remove. Type ".$config['bot']['trigger']."store logins add 'Username' 'password' to start compiling a list.", $c);
						break;
					}break;
				default:
					$dAmn->say($f."Usage: ".$config['bot']['trigger']."store logins add/del/change/list. See ".$config['bot']['trigger']."store logins for the logins command list. Login allows you to use the IDs given to each account to input into the logins file the bot stores. To add, delete, change, or view the accounts stored on here, type ".$config['bot']['trigger']."store logins add/del/remove/list.",$c); 
					break;
				}
		break;
		}else
			$dAmn->say($f. "This command is for the bot owner only.",$c);
			return null;
			break;
	case "invisistore":
		switch($args[1]){
			case "add":
				if(!empty($args[2])){
					if(empty($args[3])){
						$dAmn->say("$from: Please put your password in the bot window.",$c);
						print "\nWhat is the password?\n";
						$args[3] = trim(fgets(STDIN));
					}
					$logins = array( 'username' => $args[2], 'password' => $args[3], ); 
					if(!in_array(  strtolower($logins['username']), $config['invisilogins']['login'])){
						$found=false;
						$i=0;
						while (!$found){
							if (!isset($config['invisilogins']['login'][$i])){
								$found=true;
							} else {
							$i++;
							}		
						}
						$config['invisilogins']['login'][$i][]=strtolower($logins['username']);
						$config['invisilogins']['login'][$i][]=$logins['password'];
						save_config('invisilogins'); 
						$dAmn->say("$from: $args[2] has been successfully added as ID $i.",$c);
					}else
						$dAmn->say("$from: $args[2] is already invisistored.",$c);
				}else
					$dAmn->say("$from: Usage: ".$tr."invisistore add <i>username password*</i>. If you leave password blank, and you're running the bot, you can put the password into the console window.",$c);
				break;
			case "change":
				if($args[2] !=""){
					if(!isset($config['invisilogins']['login'][$args[2]])){
						$dAmn->say($f ."The ID you provided was invalid. Type '" .$config['bot']['trigger']."invisistore list' for a list of login IDs and the username associated with that ID.",$c);
					}else
					if($args[3]==""){
						$dAmn->say($f ."Please put your password in the bot window.",$c);
						print "\nWhat is the password?\n";
						$args[3] = trim(fgets(STDIN));
					}
					if($args[3] !=""){
						$config['invisilogins']['login'][$args[2]][1]=$args[4];
						save_config('invisilogins');
						$dAmn->say($f ."Password successfully updated.",$c);
					}else
						$dAmn->say($f ."You need to provide a password to change the current one to.",$c);
				}else 
					$dAmn->say($f ."You need to provide a valid ID number along with an updated password to change the login information stored for said ID. Type '" .$config['bot']['trigger']."store logins list' for a list of login IDs and the username associated with that ID.",$c);
					break;
			case "delete":
			case "del":
				$moo = false;
				foreach($config['invisilogins']['login'] as $id => $mod){
					$mock = $mod[0];
					if(strtolower($mock)== strtolower($args[2])){
						$moo = true;
						$config['invisilogins']['login'][$id] = NULL;
						unset($config['invisilogins']['login'][$id]);
						save_config('invisilogins');
					}
				}
				if($moo){
					$dAmn->say("$from: $args[2] was successfully removed from the list!",$c);
				}else
					$dAmn->say("$from: $args[2] isn't an invisilogin stored. Type ".$tt."invisistore list to see a list of usernames invisistored.",$c);
				break;
			case "list":
				if(!empty($config['invisilogins'])){
					$say = "<sup>The invisilogins you have stored are:</sup><br>";
					foreach($config['invisilogins']['login'] as $id => $mod){
						$say .= " ID#{$id} -- {$mod[0]} | ";
					}
					$dAmn->say($say, $c);
				}else
					$dAmn->say("$from: There aren't any invislogins stored.",$c);
				break;
		}break;
}