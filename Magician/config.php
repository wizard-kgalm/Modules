<?php
/* Module Header */
// DANTE MODULE ======
// Name: Magician
// Description: Few random commands, store, login, and dmods being the main commands.
// Author: Wizard-Kgalm 
// Version: 4.5
// Notes: Cleaned up the token and logins commands and added comments. They're now half the size and sanitary.
// ====================
//Activated on startup 
$modules[$m] = new Module($m,1); 
//Deactivated on startup
//$modules[$m] = new Module($m,0); //Uncomment to use this option and then comment out the one about.
$modules[$m]->setInfo(__FILE__); //NO TOUCHY or file will not load properly

// COMMANDS BELOW HERE.								   // Version 4.5 was released 7/30/2011. SAME MONTH ( fourteen days ) after the previous release.
$modules[$m]->addCmd( 'logins'  , 'store'   , 99, 1 ); // $logins. The storage system for accounts. Perfect for swapping accounts or grabbing tokens. ( 2010 - )
$modules[$m]->addCmd( 'istore'  , 'store'   , 99, 1 ); // $invisistore, transformed into $istore. The hidden logins list. As invisistore: ( 2009 - 2011 ). ( 2011 - ).
$modules[$m]->addCmd( 'atswap'  , 'token'   , 99, 1 ); // Good ol' $atswap. A classic red-headed stepchild. Input removed on this one. ( 2009 - )
$modules[$m]->addCmd( 'token'   , 'token'   , 99, 1 ); // A staple, $token. Still in use today, FAR less grody in appearance now. ( 2009 - )
$modules[$m]->addCmd( 'login'   , 'token'   , 99, 1 ); // $login, another staple. Albeit primitive in this version. ( 2009 - )
$modules[$m]->addCmd( 'kickroll', 'commands', 75, 1 ); // I still have no idea why I haven't gotten rid of this. Nostalgia, methinks. ( 2009 - )
$modules[$m]->addCmd( 'addons'  , 'commands', 0 , 1 ); // $addons, more current, may still find itself useful at some point.. ( 2009 - )
$modules[$m]->addCmd( 'dmods'   , 'dmods'   , 0 , 1 ); // $dmods is the last staple. Remaining a useful module link system, with many projects in mind. ( 2009 - )
$modules[$m]->addCmd( 'shank'   , 'commands', 0 , 1 ); // $shank, as a command is what helped me learn to make things for Contra as well. Not a useful command though. ( 2009 - )
													   // I lied, $me and $npmsg were moved to input. haha
// HELPS BELOW HERE.
$modules[$m]->addHelp('shank','Shank is a joke command merely used to stab someone.. :paranoid:.');
$modules[$m]->addHelp('logins',"Usage: {$tr}logins [add |del/remove |change |list |all]. <br><sup><b>{$tr}logins add <i>username (password)</i></b> adds a username to the stored list. Leave the password blank to input it into the bot window. <br><b>{$tr}logins del/remove <i>username</i></b> removes that user from the logins list.<br><b>{$tr}logins change <i>username (password)</i></b> allows you to change the password of the provided username. Leave the password blank to input it into the bot window.<br> <b>{$tr}logins list</b> shows the stored logins as does {$tr}show logins list.<br><b>{$tr}logins all <i>confirm</i></b> shows the logins WITH their password. Don't use this in a public chatroom.</sup>");
$modules[$m]->addHelp('istore',"Stores logins on a different list than the logins command, and is used exactly the same way.");
$modules[$m]->addHelp('dmods',"Usage: {$tr}dmods add/del/remove/change/check/list. <sup><br><b>{$tr}dmods add <i>name link (by)</i></b> adds a module to the list. Name is the module name, link is the download link (starting with http://), and (by) is optional.. only include if you know who the author is. <br><b>{$tr}dmods del/delete/remove <i>name</i></b> deletes a module based on name. To see a list, type {$tr}dmods list.<br><b>{$tr}dmods change <i>Name link</i></b> changes the link for the module. <br><b>{$tr}dmods change2 <i>Name by</i></b> changes the author for the module under the given ID#. <br><b>{$tr}dmods list <i>(links) (all)</i></b> lists the stored modules. If you just type <b>{$tr}dmods list</b>, it\'ll just list the stored module names and ID#. If you type <b>{$tr}dmods list links</b>, it will show the associated links with the module names. If you type <b>{$tr}dmods list all</b>, it will show all the information, module name, link, and author (if one was given).<br><b>{$tr}dmods without any options</b> shows all the modules with formatting (if there any stored, otherwise it just instructs you to add some).<br><b>{$tr}dmods check <i>Name</i></b> allows you to check for single module based on its name rather than showing the whole list.");
$modules[$m]->addHelp('addons',"Addons displays the popular addons for dAmn, as well as the client that runs them, Greasemonkey.");
$modules[$m]->addHelp('kickroll',"Actually created as a joke, this command is excellent for kicking in a hilarious way.");
$modules[$m]->addHelp('login',"<sup><b>{$tr}login <i>username (password)</i></b>. If the username is on the logins list, it'll use the stored password for that account. If not, it'll ask for a password. Leave the password blank to input it inot the bot window.<br> For a list of the available logins, see {$tr} logins list.</sup>");
$modules[$m]->addHelp('token',"{$tr}token <i>username (password)</i></b>. If the username is on the logins list, it'll use the stored password for that account. If not, it'll ask for a password. Leave the password blank to input it inot the bot window.<br> For a list of the available logins, see {$tr}logins list.</sup>");
$modules[$m]->addHelp('atswap',"{$tr}atwap uses the supplied username and authtoken to change logins. Hint: You need to have the user's token before you can use this command. If you know the password, just use {$tr}login."); //lol use passport. Have I ever read this? 
//Just gonna do a quick check of the logins list below. Updating is essential for people who have the old storage style.. 
if(is_array($config['logins']['login'][1])){
	//Going to tear down the login storage and change it from logins => array( ID# => array( 0 => username, 1 => password), ), to an array of just logins => array( username => password). Much nicer, no? :)
	foreach($config['logins']['login'] as $ID => $info){
		$config['logins2']['login'][strtolower($config['logins']['login'][$ID][0])] = $config['logins']['login'][$ID][1];
		//I figured it would be ok to make this into a backup. THEN save over the original logins config with this. >> ( 7/18/2013) REALLY? I DID? WHY DID I THINK THAT?
		save_config('logins2');
	}	//Here's where we overwrite it with the backup file created. This will come in handy incase something should vanish. Of course, there is no backup file if you started using it after the storage change.
	$config['logins'] = $config['logins2'];
	save_config('logins');
	$dAmn->say("Logins list updated and fixed.",$config['bot']['HomeRoom']);
}//Doing the same as above to the hidden logins. By hidden, I mean they're on a secondary list.
if(isset($config['invisilogins']['login'][1])){
	foreach($config['invisilogins']['login'] as $ID => $info){
		$config['logins3']['login'][strtolower($config['invisilogins']['login'][$ID][0])] = $config['invisilogins']['login'][$ID][1];
		save_config('logins3');
	}
	$config['invisilogins'] = $config['logins3'];
	save_config('invisilogins');
	$dAmn->say("Hidden Logins list updated and fixed.",$config['bot']['HomeRoom']);
}//Alllrighty then, new update, moving invisilogins to logins => hidden. Keeps them all in the same file and still has a degree of seperation!
if(isset($config['invisilogins']['login'])){
	$config['logins']['hidden'] = $config['invisilogins']['login'];
	unset($config['invisilogins']['login']);
	save_config('invisilogins');
	save_config('logins');
	$dAmn->say("Moved invisilogins list to logins => hidden." , $config['bot']['HomeRoom']);
} // Close list updates. I put them here because they execute on bot launch. Also, if I'm not mistaken, this is the last widespread release, until I finish updating Dante.
?>