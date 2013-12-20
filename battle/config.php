<?php
/* Module Header */
// DANTE MODULE ======
// Name: battle
// Description: This module is basically a pokemon battle port for dAmn. Purely experimental. 
// Author: Wizard-Kgalm
// Version: 0.1
// Notes: Will probably turn this into the ringleader module and make a module for other bots, we'll see how it runs.
// ====================
//Activated on startup 
$modules[$m] = new Module($m,1); 
//Deactivated on startup
//$modules[$m] = new Module($m,0); //Uncomment to use this option and then comment out the one above out.
$modules[$m]->setInfo(__FILE__); //NO TOUCHY or file will not load properly

//Commands below here! (no commands yet, huehue) 
$modules[$m]->addCmd( 'newgame'    , 'commands', 0 , 1 );	// This spawns your profile, so that you may begin the game.
$modules[$m]->addCmd( 'profile'    , 'commands', 0 , 1 );	// These are commands for you to set up your profile, and display your details afterwards.
$modules[$m]->addCmd( 'starter'    , 'commands', 0 , 1 );	// This command is for selecting your starter pokemon.
$modules[$m]->addCmd( 'wipesave'   , 'commands', 0 , 1 );	// This command is for deleting your profile.