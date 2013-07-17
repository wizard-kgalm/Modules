<?php
/* Module Header */
// DANTE MODULE ======
// Name: Magician
// Description: Just some commands thrown together from scripts, as well as a few new ones. 
// Author: Wizard-Kgalm
// Version: 0.4B
// Notes: Seperated the token grabber so now it's in a file by itself within the module. A couple of ideas were taken from Jackal.
// ====================
//Activated on startup 
$modules[$m] = new Module($m,1); 
//Deactivated on startop
//$modules[$m] = new Module($m,0); //Uncomment to use this option and then comment out the one about.
$modules[$m]->setInfo(__FILE__); //NO TOUCHY or file will not load properly
/* Commands and Events below here */

$modules[$m]->addCmd('passport','commands',99,1);
$modules[$m]->addHelp('passport','"Passport" Uses the supplied username and password to grab the authtoken and then uses the username and authtoken to change logins.');

$modules[$m]->addCmd('atswap','commands',99,1);
$modules[$m]->addHelp("atswap","ATSwap Uses the supplied username and authtoken to change logins. Hint: You need to have the user's token before you can use this command. If you know the password, just use passport.");

$modules[$m]->addCmd('token','commands',0,1);
$modules[$m]->addHelp('token','"Token" retrieves the authtoken for a specified username and password.');

$modules[$m]->addCmd('kickroll','commands',75,1);
$modules[$m]->addHelp('kickroll','Actually created as a joke, this command is excellent for kicking in a hilarious way.');

$modules[$m]->addCmd('addons','commands',0,1);
$modules[$m]->addHelp('addons','Addons displays the popular addons for dAmn, as well as the client that runs them, Greasemonkey.');

$modules[$m]->addCmd('shank','commands',0,1);
$modules[$m]->addHelp('shank','Shank is a joke command merely used to stab someone.. :paranoid:.');


?>