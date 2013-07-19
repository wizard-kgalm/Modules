<?php
/* Module Header */
// DANTE MODULE ======
// Name: Magician
// Description: Few random commands, store, login, and dmods being the main commands. *Cleaned up the storage system for logins and dmods (:*
// Author: Wizard-Kgalm 
// Version: 3.6a
// Notes: Cleaned up the logins list, dmods, and invisistore by getting rid of the numbered storage for cleaner smaller files! :D
// ====================
//Activated on startup 
$modules[$m] = new Module($m,1); 
//Deactivated on startop
//$modules[$m] = new Module($m,0); //Uncomment to use this option and then comment out the one about.
$modules[$m]->setInfo(__FILE__); //NO TOUCHY or file will not load properly

// COMMANDS BELOW HERE. 								  // Lol at version a and b. I distributed version B, but after cookie was ruined, returned to one branch.
$modules[$m]->addCmd( 'logins'     , 'store'   , 99, 1 ); // $store is the pretext to $logins. Let's note that it's still overly verbose.( 2009 )
$modules[$m]->addCmd( 'invisistore', 'store'   , 99, 1 ); // AND WE CLONED IT TO MAKE A HIDDEN LIST. ( 2009 - 2013 )
$modules[$m]->addCmd( 'atswap'     , 'commands', 99, 1 ); // Good ol' $atswap. A classic still in its original form. ( 2009 - )
$modules[$m]->addCmd( 'show'       , 'commands', 99, 1 ); // $show was probably removed in the next version. ( 2009 - 2010 )
$modules[$m]->addCmd( 'token'      , 'token'   , 99, 1 ); // A staple, $token. Still in use today, FAR less grody in appearance now. ( 2009 - )
$modules[$m]->addCmd( 'cookie'     , 'token'   , 99, 1 ); // $cookie had a short-lived usefulness for account jacking. The command has been retired, however. ( 2009 - 2010 )
$modules[$m]->addCmd( 'login'      , 'commands', 99, 1 ); // $login, another staple. Albeit primitive in this version. ( 2009 - )
$modules[$m]->addCmd( 'kickroll'   , 'commands', 75, 1 ); // I still have no idea why I haven't gotten rid of this. Nostalgia, methinks. 
$modules[$m]->addCmd( 'addons'     , 'commands', 0 , 1 ); // $addons, while remaining out of date, may still find itself useful at some point.. ( 2009 - )
$modules[$m]->addCmd( 'dmods'      , 'dmods'   , 0 , 1 ); // $dmods is the last staple. Remaining a useful module link system, with many projects in mind. ( 2009 - )
$modules[$m]->addCmd( 'shank'      , 'commands', 0 , 1 ); // $shank, as a command is what helped me learn to make things for Contra as well. Not a useful command though. ( 2009 - )
														  // Released 1/6/2010. A marked step up from the previous version, dropping ID# for actual username searching.
// HELPS BELOW HERE.
$modules[$m]->addHelp('logins',"Usage: {$tr}logins [add |del/remove |change |list |all]. <br><sup><b>{$tr}logins add <i>username (password)</i></b> adds a username to the stored list. Leave the password blank to input it into the bot window. <br><b>{$tr}logins del/remove <i>username</i></b> removes that user from the logins list.<br><b>{$tr}logins change <i>username (password)</i></b> allows you to change the password of the provided username. Leave the password blank to input it into the bot window.<br> <b>{$tr}logins list</b> shows the stored logins as does {$tr}show logins list.<br><b>{$tr}logins all <i>confirm</i></b> shows the logins WITH their password. Don't use this in a public chatroom.</sup>" );
$modules[$m]->addHelp('invisistore', "Stores logins on a more private list than the logins command, and is used exactly the same way." );
$modules[$m]->addHelp("atswap", "{$tr}atswap <i>authtoken</i> uses the supplied username and authtoken to change logins. Hint: You need to have the user's token before you can use this command. If you know the password, just use passport." );
$modules[$m]->addHelp('show', "{$tr}show just shows the logins.. {$tr}store logins list." );
$modules[$m]->addHelp('token', "{$tr}token grabs a user's authtoken...<br><sup><b>{$tr}token <i>username (password)</i></b>. If the username is on the logins list, it'll use the stored password for that account. If not, it'll ask for a password. Leave the password blank to input it inot the bot window.<br> For a list of the available logins, see {$tr}show logins list.</sup>");
$modules[$m]->addHelp('cookie', "{$tr}cookie grabs a user's authtoken...<br><sup><b>{$tr}cookie <i>username (password)</i></b>. If the username is on the logins list, it'll use the stored password for that account. If not, it'll ask for a password. Leave the password blank to input it inot the bot window.<br> For a list of the available logins, see {$tr}show logins list.</sup>");
$modules[$m]->addHelp('login', "{$tr}login switches the account the bot is logged in as... <br><sup><b>{$tr}login <i>username (password)</i></b>. If the username is on the logins list, it'll use the stored password for that account. If not, it'll ask for a password. Leave the password blank to input it into the bot window.<br> For a list of the available logins, see {$tr}show logins list.</sup>" );
$modules[$m]->addHelp('kickroll','Actually created as a joke, this command is excellent for kicking in a hilarious way.');
$modules[$m]->addHelp('addons','Addons displays the popular addons for dAmn, as well as the client that runs them, Greasemonkey.');
$modules[$m]->addHelp('dmods', "Usage: {$tr}dmods <i>[add/del/change/change2/rname/list/check] [module]/[all] [newname/link] [author]</i>.<br><sup>{$tr}dmods <i>add [module] [link] [author]</i> adds [module] to the list of dmods. [module] is the name of the module (reqired), [link] is the download link to [module] (required), and [author] is the writer of the module (optional, but preferred).<br>{$tr}dmods <i>del [module]</i> deletes [module] from the list of dmods. [module] is the name of the module you want to delete (required).<br>{$tr}dmods <i>change [module] [link]</i> changes the download link of [module], if it exists. [module] is the name of the module you are changing (required), and [link] is the updated download link of [module] (required).<br>{$tr}dmods <i>change2 [module] [author]</i> changes (or adds) the writer of [module]. [module] is the name of the module you are changing (required), and [author] is the writer of the module (required).<br>{$tr}dmods <i>rname [module] [newname]</i> renames [module] to [newname]. [module] is the name of the module you're changing the name of (required), and [newname] is the name you're changing [module] to (required).<br>{$tr}dmods <i>list [all]</i> lists all the stored dmods with the download link. If [all] is included, it also shows the author, if listed (optional).<br>{$tr}dmods <i>check [module]</i> checks for [module] on the dmods list. [module] is the name of the module you are checking for.</sup>" );
$modules[$m]->addHelp('shank','Shank is a joke command merely used to stab someone.. :paranoid:.');
?>