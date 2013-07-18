<?php
/* Module Header */
// DANTE MODULE ======
// Name: Magician
// Description: Few random commands, store, login, and dmods being the main commands. :<b></b>D Version a has everything enabled. Version b has the iffy commands disabled.
// Author: Wizard-Kgalm 
// Version: 3.0a
// Notes: Added dmods and invisistore! :D
// ====================
//Activated on startup 
$modules[$m] = new Module($m,1); 
//Deactivated on startop
//$modules[$m] = new Module($m,0); //Uncomment to use this option and then comment out the one about.
$modules[$m]->setInfo(__FILE__); //NO TOUCHY or file will not load properly

// COMMANDS BELOW HERE. 								  // Lol at version a and b. I distributed version B, but after cookie was ruined, returned to one branch.
$modules[$m]->addCmd( 'store'      , 'store'   , 99, 1 ); // $store is the pretext to $logins. Let's note that it's still overly verbose.( 2009 )
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
//$modules[$m]->addCmd( 'invisible', 'commands', 0 , 1 ); // Take note we forgot to even add this line that I just typed in, 7/18/2013. 3.9 years later. ( 2009 )
														  // This version was released 10/26/2009. In one year, I made two versions of this, and improved gradually.
// HELPS BELOW HERE.
$modules[$m]->addHelp('store', "Usage {$tr}store logins [add |del/remove |change |list |all]. <br><sup><b> {$tr}store logins add <i>username (password)</i></b> adds a username to the stored list. Leave the password blank to input it into the bot window. <br><b>{$tr}store logins del/remove <i>(ID#)</i></b> removes the login of the ID#.<br><b>{$tr}store logins change <i>(ID#)(password)</i></b> allows you to change the password of the account stored under that ID#. Leave the password blank to input it into the bot window.<br> <b>{$tr}store logins list</b> shows the stored logins as does {$tr}show logins list.<br><b>{$tr}store logins all <i>confirm</i></b> shows the logins WITH their password. Don't use this in a public chatroom.</sup> ");
$modules[$m]->addHelp('invisistore', "Stores logins on a more private list than the store command, and is used exactly the same way.");
$modules[$m]->addHelp("atswap","ATSwap Uses the supplied username and authtoken to change logins. Hint: You need to have the user's token before you can use this command. If you know the password, just use passport.");
$modules[$m]->addHelp('show', "{$tr}show just shows the logins.. {$tr}store logins list.");
$modules[$m]->addHelp('token', "{$tr}token grabs a user's authtoken...<br><sup><b> {$tr}token grab (ID#)</b> (To grab authtokens based on the stored account's ID#)<br> <b>{$tr}token manual <i>username (password)</i></b> (To manually input a username and password). Leave the password blank to input it into the bot window.<br>For a list of the available accounts to grab authtokens for, see {$tr}show logins list.");
$modules[$m]->addHelp('cookie', "{$tr}cookie grabs a user's login cookies...<br><sup><b> {$tr}cookie grab (ID#)</b> (To grab cookies based on the stored account's ID#)<br><b>{$tr}cookie manual <i>username (password)</i></b> (To manually input a username and password). Leave the password blank to input it into hte bot window.<br>For a list of the available accounts to grab a cookie for, see {$tr}show logins list.</sup>");
$modules[$m]->addHelp('login', "{$tr}login switches the account the bot is logged in as... <br><sup><b>{$tr}login ID (ID#)</b> (To change accounts based on the stored account's ID#..)<br><b>{$tr}login manual <i>username (password)</i></b> (To manually input a username and password). Leave the password blank to input it inot the bot window.<br> For a list of the available logins, see {$tr}show logins list.</sup>");
$modules[$m]->addHelp('kickroll','Actually created as a joke, this command is excellent for kicking in a hilarious way.');
$modules[$m]->addHelp('addons','Addons displays the popular addons for dAmn, as well as the client that runs them, Greasemonkey.');
$modules[$m]->addHelp('dmods', "Usage: {$tr}dmods add/del/remove/change/list. <sup><br><b>{$tr}dmods add <i>name link (by)</i></b> adds a module to the list. Name is the module name, link is the download link (starting with http://), and (by) is optional.. only include if you know who the author is. <br><b>{$tr}dmods del/delete <i>name</i></b> deletes a module based on name. To see a list, type {$tr}dmods list.<br><b>{$tr}dmods remove <i>(ID#)</i></b> removes a module based on the ID number.<br><b>{$tr}dmods change <i>(ID#) link</i></b> changes the link for the module under the given ID#. <br><b>{$tr}dmods change2 <i>(ID#) by</i></b> changes the author for the module under the given ID#. <br><b>{$tr}dmods list <i>(links) (all)</i></b> lists the stored modules. If you just type <b>{$tr}dmods list</b>, it'll just list the stored module names and ID#. If you type <b>{$tr}dmods list links</b>, it will show the associated links with the module names and their ID#s. If you type <b>{$tr}dmods list all</b>, it will show all the information, module name, link, and author (if one was given).<br><b>{$tr}dmods without any options</b> shows all the modules with formatting (if there any stored, otherwise it just instructs you to add some).");
$modules[$m]->addHelp('shank','Shank is a joke command merely used to stab someone.. :paranoid:.');
?>