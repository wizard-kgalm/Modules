<?php
/* Module Header */
// DANTE MODULE ======
// Name: Magician
// Description: Few random commands, focus being on passport. 
// Author: Wizard-Kgalm 
// Version: 2.0
// Notes: Completely redid the passport command, it now has support for saving alternate logins for the bot to change to at your command. Tripled the size of the commands file on it's own.
// ====================

$modules[$m] = new Module($m,1); 
//$modules[$m] = new Module($m,0);
$modules[$m]->setInfo(__FILE__);


$modules[$m]->addCmd('store','commands',99,1);
$modules[$m]->addHelp('store','Usage: $config[\'bot\'][\'trigger\']store [logins |login |manual][add |del/remove |change |list |all]. Second brakcets deals with $config[\'bot\'][\'trigger\']store logins command. For more info, view "Magician README" included. ');

//Unless you know anything about using authtokens, don't uncomment this command.
//$modules[$m]->addCmd('atswap','commands',99,1);
//$modules[$m]->addHelp("atswap","ATSwap Uses the supplied username and authtoken to change logins. Hint: You need to have the user's token before you can use this command. If you know the password, just use store.");

//Again, unless you know how to use authtokens and cookies (explained in the readme to some extent), leave this disabled.
//$modules[$m]->addCmd('show','commands',99,1);
//$modules[$m]->addHelp('show','"Show" retrieves the authtoken or cookie for a specified username and password, supplied either from a stored ID number given to you from $config[\'bot\'][\'trigger\']store logins, or manually input using $config[\'bot\'][\'trigger\']show token\cookie manual.');

$modules[$m]->addCmd('kickroll','commands',75,1);
$modules[$m]->addHelp('kickroll','Actually created as a joke, this command is excellent for kicking in a hilarious way.');

$modules[$m]->addCmd('addons','commands',0,1);
$modules[$m]->addHelp('addons','Addons displays the popular addons for dAmn, as well as the client that runs them, Greasemonkey.');

$modules[$m]->addCmd('shank','commands',0,1);
$modules[$m]->addHelp('shank','Shank is a joke command merely used to stab someone.. :paranoid:.');


?>