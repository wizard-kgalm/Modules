<?php
/* Module Header */
// DANTE MODULE ======
// Name: Magician
// Description: Few random commands, store, login, and dmods being the main commands.
// Author: Wizard-Kgalm 
// Version: 5.0
// Notes: Entered yet another revision! Changed the storage type, combined $istore and $logins, organized the list command, and updated helps.
// ====================
// Activated on startup 
$modules[$m] = new Module($m,1); 
// Deactivated on startup
//$modules[$m] = new Module($m,0); // Uncomment to use this option and then comment out the one above.
$modules[$m]->setInfo(__FILE__); //NO TOUCHY or file will not load properly

/* We're going to convert your config, this time, to a new saving feature.*/
if(!file_exists("./config/logins.df")){
	$logins['login'] = $config['logins']['login'];
	foreach($config['logins']['hidden'] as $name => $pass){
		$config['logins']['hidden'][$name] = @base64_encode($pass);
		save_config("logins");
	}
	$logins['hidden'] = $config['logins']['hidden'];
	save_info("./config/logins.df", $logins);
}													  // Ironically, this converting feature is removed in favor of converting the entire config system next ( current ) version.
if(!file_exists("./config/dmods.df") && file_exists("./config/dmods.vudf")){
	foreach($config['dmods']['modules'] as $dmod => $details){
		$dmods['modules'][strtolower($dmod)] = $details;
	}
	save_info('./config/dmods.df', $dmods);
}
	
// COMMANDS BELOW HERE.								   // Version 5.0 has never been released. However, it does exist, and it is a marked improvement over 4.5. 
$modules[$m]->addCmd( 'logins'  , 'store'   , 99, 1 ); // $logins. The storage system for accounts. Perfect for swapping accounts or grabbing tokens. ( 2010 - )
$modules[$m]->addCmd( 'istore'  , 'store'   , 99, 1 ); // $invisistore, transformed into $istore. The hidden logins list. As invisistore: ( 2009 - 2011 ). ( 2011 - ).
$modules[$m]->addCmd( 'atswap'  , 'token'   , 99, 1 ); // Good ol' $atswap. A classic red-headed step-child. Input removed on this one. ( 2009 - )
$modules[$m]->addCmd( 'token'   , 'token'   , 99, 1 ); // A staple, $token. Still in use today, FAR less grody in appearance now. ( 2009 - )
$modules[$m]->addCmd( 'pass'    , 'commands', 99, 1 ); // $pass was made because I got tired of fetching passwords the long way. ( I use accounts to test things ). ( 2013 - ).
$modules[$m]->addCmd( 'login'   , 'token'   , 99, 1 ); // $login, another staple. Albeit primitive in this version. ( 2009 - )
$modules[$m]->addCmd( 'kickroll', 'commands', 75, 1 ); // I still have no idea why I haven't gotten rid of this. Nostalgia, methinks. ( 2009 - )
$modules[$m]->addCmd( 'addons'  , 'commands', 0 , 1 ); // $addons, more current, may still find itself useful at some point.. ( 2009 - )
$modules[$m]->addCmd( 'dmods'   , 'dmods'   , 0 , 1 ); // $dmods is the last staple. Remaining a useful module link system, with many projects in mind. ( 2009 - )
$modules[$m]->addCmd( 'shank'   , 'commands', 0 , 1 ); // $shank is what helped me learn to make things for Contra as well. Not a useful command though. ( 2009 - )
													   // I lied, $me and $npmsg were moved to input. haha
// HELPS BELOW HERE.
$modules[$m]->addHelp('shank','Shank is a joke command merely used to stab someone.. :paranoid:.');
$storecmd = array('logins', 'istore',);
foreach($storecmd as $storecom){
	( $storecom == "logins" ) ? $listype = "logins" : $listype = "hidden";
	$modules[$m]->addHelp($storecom, "Usage: {$tr}{$storecom} <i>[add/del/change/list/all]  [username/confirm] [password]</i>. <br><sup>{$tr}{$storecom} <i>add [username] [password]</i> adds a username to the stored list. [username] is the dA username you wish to add to the list, and [password] is the dA password. It will kick it out to a token grabber to verify that the password is correct before adding it.<br>{$tr}{$storecom} <i>del [username]</i> removes [username] from the {$listype} list. [username] is the username you're deleting off that list.<br>{$tr}{$storecom} <i>change [username] [password]</i> allows you to change [username]'s stored password with [password]. [username] is the dA username you are changing the password to, and [password] is the password you are changing it with. It will kick it out to a token grabber to verify that the password is correct before changing it.<br>{$tr}{$storecom} <i>list [dev]</i> shows the stored logins. If you include [dev] it will give you te deviantART account (adding :dev: to the username and is optional).<br>{$tr}{$storecom} <i>all [confirm]</i> shows the logins WITH their password. You must include confirm, or it won't work, and is not recommended for public chatrooms.<br>{$tr}{$storecom} <i>[username]</i> checks the list for [username].</sup>");
}
$modules[$m]->addHelp('pass', "Usage: {$tr}pass <i>username</i>. Displays the stored password for [username].");
$modules[$m]->addHelp('dmods',"Usage: {$tr}dmods <i>[add/del/change/change2/rname/list/check] [module]/[all] [newname/link] [author]</i>.<br><sup>{$tr}dmods <i>add [module] [link] [author]</i> adds [module] to the list of dmods. [module] is the name of the module (reqired), [link] is the download link to [module] (required), and [author] is the writer of the module (optional, but preferred).<br>{$tr}dmods <i>del [module]</i> deletes [module] from the list of dmods. [module] is the name of the module you want to delete (required).<br>{$tr}dmods <i>change [module] [link]</i> changes the download link of [module], if it exists. [module] is the name of the module you are changing (required), and [link] is the updated download link of [module] (required).<br>{$tr}dmods <i>change2 [module] [author]</i> changes (or adds) the writer of [module]. [module] is the name of the module you are changing (required), and [author] is the writer of the module (required).<br>{$tr}dmods <i>rname [module] [newname]</i> renames [module] to [newname]. [module] is the name of the module you're changing the name of (required), and [newname] is the name you're changing [module] to (required).<br>{$tr}dmods <i>list [all]</i> lists all the stored dmods with the download link. If [all] is included, it also shows the author, if listed (optional).<br>{$tr}dmods <i>check [module]</i> checks for [module] on the dmods list. [module] is the name of the module you are checking for.</sup>");
$modules[$m]->addHelp('addons',"Addons displays the popular addons for dAmn, as well as the client that runs them, Greasemonkey.");
$modules[$m]->addHelp('kickroll',"Actually created as a joke, this command is excellent for kicking in a hilarious way.");
$modules[$m]->addHelp('login',"<sup><b>{$tr}login <i>username (password)</i></b>. If the username is on the logins list, it'll use the stored password for that account. If not, it'll ask for a password. Leave the password blank to input it inot the bot window.<br> For a list of the available logins, see {$tr} logins list.</sup>");
$modules[$m]->addHelp('token',"{$tr}token <i>username (password)</i></b>. If the username is on the logins list, it'll use the stored password for that account. If not, it'll ask for a password. Leave the password blank to input it inot the bot window.<br> For a list of the available logins, see {$tr}logins list.</sup>");
$modules[$m]->addHelp('atswap',"{$tr}atswap uses the supplied username and authtoken to change logins. Hint: You need to have the user's token before you can use this command. If you know the password, just use <s>passport</s> login."); // Again, I find this says passport. I really haven't read my own helps in a long time. ( 7/19/2013 ).
?>