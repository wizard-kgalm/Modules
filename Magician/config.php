<?php
/* Module Header */
// DANTE MODULE ======
// Name: Magician
// Description: Few random commands, store, login, and dmods being the main commands. Now merged with Llama, because of the logins!
// Author: Wizard-Kgalm 
// Version: 5.4
// Notes: Cleaned up the token and logins commands and added comments. They're now half the size and sanitary.
// ====================
//Activated on startup 
$modules[$m] = new Module($m,1); 
//Deactivated on startup
//$modules[$m] = new Module($m,0); //Uncomment to use this option and then comment out the one above out.
$modules[$m]->setInfo(__FILE__); //NO TOUCHY or file will not load properly

// COMMANDS BELOW HERE.
$modules[$m]->addCmd ('logins'     , 'store'   , 99, 1 );
$modules[$m]->addCmd( 'pass'       , 'commands', 0 , 1 );
$modules[$m]->addCmd( 'istore'     , 'store'   , 99, 1 );
$modules[$m]->addCmd( 'atswap'     , 'token'   , 99, 1 );
$modules[$m]->addCmd( 'token'      , 'token'   , 99, 1 );
$modules[$m]->addCmd( 'login'      , 'token'   , 99, 1 );
$modules[$m]->addCmd( 'kickroll'   , 'commands', 75, 1 );
$modules[$m]->addCmd( 'addons'     , 'commands', 0 , 1 );
$modules[$m]->addCmd( 'dmods'      , 'dmods'   , 0 , 1 );
$modules[$m]->addCmd( 'shank'      , 'commands', 0 , 1 );
$modules[$m]->addCmd( 'rllama'     , 'llama'   , 0 , 1 );
$modules[$m]->addCmd( 'llama'      , 'llama'   , 0 , 1 );
$modules[$m]->addCmd( 'rspama'     , 'llama'   , 99, 1 );
$modules[$m]->addCmd( 'fullama'    , 'llama'   , 99, 1 );
$modules[$m]->addCmd( 'cookieclear', 'llama'   , 99, 1 ); 

// HELPS BELOW HERE.
$modules[$m]->addHelp('shank','Shank is a joke command merely used to stab someone.. :paranoid:.');
$storecmd = array('logins', 'istore',);
foreach($storecmd as $storecom){
	if($storecom == "logins"){
		$listype = "logins";
	}else{
		$listype = "hidden";
	}
	$modules[$m]->addHelp($storecom, "Usage: {$tr}{$storecom} <i>[add/del/change/list/all]  [username/confirm] [password]</i>. <br><sup>{$tr}{$storecom} <i>add [username] [password]</i> adds a username to the stored list. [username] is the dA username you wish to add to the list, and [password] is the dA password. It will kick it out to a token grabber to verify that the password is correct before adding it.<br>{$tr}{$storecom} <i>del [username]</i> removes [username] from the {$listype} list. [username] is the username you're deleting off that list.<br>{$tr}{$storecom} <i>change [username] [password]</i> allows you to change [username]'s stored password with [password]. [username] is the dA username you are changing the password to, and [password] is the password you are changing it with. It will kick it out to a token grabber to verify that the password is correct before changing it.<br>{$tr}{$storecom} <i>list [dev]</i> shows the stored logins. If you include [dev] it will give you te deviantART account (adding :dev: to the username and is optional).<br>{$tr}{$storecom} <i>all [confirm]</i> shows the logins WITH their password. You must include confirm, or it won't work, and is not recommended for public chatrooms.<br>{$tr}{$storecom} <i>[username]</i> checks the list for [username].</sup>");
}
$modules[$m]->addHelp('pass', "Usage: {$tr}pass <i>username</i>. Displays the stored password for [username].");
$modules[$m]->addHelp('istore',"Stores logins on a different list than the logins command, and is used exactly the same way.");
$modules[$m]->addHelp('dmods',"Usage: {$tr}dmods <i>[add/del/change/change2/rname/list/check] [module]/[all] [newname/link] [author]</i>.<br><sup>{$tr}dmods <i>add [module] [link] [author]</i> adds [module] to the list of dmods. [module] is the name of the module (reqired), [link] is the download link to [module] (required), and [author] is the writer of the module (optional, but preferred).<br>{$tr}dmods <i>del [module]</i> deletes [module] from the list of dmods. [module] is the name of the module you want to delete (required).<br>{$tr}dmods <i>change [module] [link]</i> changes the download link of [module], if it exists. [module] is the name of the module you are changing (required), and [link] is the updated download link of [module] (required).<br>{$tr}dmods <i>change2 [module] [author]</i> changes (or adds) the writer of [module]. [module] is the name of the module you are changing (required), and [author] is the writer of the module (required).<br>{$tr}dmods <i>rname [module] [newname]</i> renames [module] to [newname]. [module] is the name of the module you're changing the name of (required), and [newname] is the name you're changing [module] to (required).<br>{$tr}dmods <i>list [all]</i> lists all the stored dmods with the download link. If [all] is included, it also shows the author, if listed (optional).<br>{$tr}dmods <i>check [module]</i> checks for [module] on the dmods list. [module] is the name of the module you are checking for.</sup>");
$modules[$m]->addHelp('addons',"Addons displays the popular addons for dAmn, as well as the client that runs them, Greasemonkey.");
$modules[$m]->addHelp('kickroll',"Actually created as a joke, this command is excellent for kicking in a hilarious way.");
$modules[$m]->addHelp('login',"<sup><b>{$tr}login <i>username (password)</i></b>. If the username is on the logins list, it'll use the stored password for that account. If not, it'll ask for a password. Leave the password blank to input it inot the bot window.<br> For a list of the available logins, see {$tr} logins list.</sup>");
$modules[$m]->addHelp('token',"{$tr}token <i>username (password)</i></b>. If the username is on the logins list, it'll use the stored password for that account. If not, it'll ask for a password. Leave the password blank to input it inot the bot window.<br> For a list of the available logins, see {$tr}logins list.</sup>");
$modules[$m]->addHelp('atswap',"{$tr}atswap uses the supplied username and authtoken to change logins. Hint: You need to have the user's token before you can use this command. If you know the password, just use <s>passport</s> {$tr}login."); // LOL in the current version, still says passport. Fixed! ( 7/19/2013 ).
$modules[$m]->addHelp('cookieclear', "{$tr}cookieclear. Clears the cookies of all the stored logins for llama purposes.");
$modules[$m]->addHelp('fullama',"{$tr}fullama [username] sends a llama to the specified username with ALL the accounts on the logins list. It will take a while.");
$modules[$m]->addHelp('rspama',"{$tr}rspama # {user} Sends llamas to either a specified number of random deviants or 50. If you provide a number and {user} it'll try and send those random people llamas from that account.");
$modules[$m]->addHelp('rllama',"{$tr}rllama {username} Sends a llama to a random user. If you include a username there and it's on your logins list, it'll use that dA account instead. ");
$modules[$m]->addHelp('llama',"{$tr}llama [username] {user2} where username is a specified dA username. This sends the specified username a llama. If you include another name for user2, it'll use that dA account to send the llama.");


?>