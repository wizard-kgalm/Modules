<?php
/* Module Header */
// DANTE MODULE ======
// Name: Magician
// Description: Few random commands, focus being on passport. 
// Author: Wizard-Kgalm 
// Version: 2.0
// Notes: Remade passport, and added storage so the bot could save multiple logins to swap with at your command. Tripled the size of the commands file on it's own.
// ====================
//Activated on startup 
$modules[$m] = new Module( $m, 1 ); 
//Deactivated on startup
//$modules[$m] = new Module($m,0); //Uncomment to use this option and then comment out the one about.
$modules[$m]->setInfo( __FILE__ ); //NO TOUCHY or file will not load properly

// COMMANDS BELOW HERE.
$modules[$m]->addCmd( 'store'   , 'commands', 99, 1 );
$modules[$m]->addCmd( 'atswap'  , 'commands', 99, 1 );
$modules[$m]->addCmd( 'show'    , 'commands', 99, 1 ); 
$modules[$m]->addCmd( 'kickroll', 'commands', 75, 1 );
$modules[$m]->addCmd( 'addons'  , 'commands', 0 , 1 );
$modules[$m]->addCmd( 'shank'   , 'commands', 0 , 1 );

// HELPS BELOW HERE.
$modules[$m]->addHelp( 'store', "Usage: {$tr}store [logins |login |manual][add |del/remove |change |list |all]. Second brakcets deals with {$tr}store logins command. For more info, view the readme included." );
$modules[$m]->addHelp( "atswap","ATSwap Uses the supplied username and authtoken to change logins. Hint: You need to have the user's token before you can use this command. If you know the password, just use store." );
$modules[$m]->addHelp( 'show', "{$tr}show retrieves the authtoken or cookie for a specified username and password, supplied either from a stored ID number given to you from {$tr}store logins, or manually input using {$tr}show token\cookie manual." );
$modules[$m]->addHelp( 'kickroll','Actually created as a joke, this command is excellent for kicking in a hilarious way.' );
$modules[$m]->addHelp( 'addons', 'Addons displays the popular addons for dAmn, as well as the client that runs them, Greasemonkey.' );
$modules[$m]->addHelp( 'shank', 'Shank is a joke command merely used to stab someone.. :paranoid:.' );
?>