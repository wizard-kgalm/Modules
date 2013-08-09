<?php
/* Module Header */
// DANTE MODULE ======
// Name: werewolf
// Description: Automation of certain things for the hit game Werewolf. 
// Author: Wizard-Kgalm 
// Version: 2.0
// Notes: NOW WITH HARLOT, JESTER, AND VILLAGE IDIOT!
// ====================
//Activated on startup 
$modules[$m] = new Module($m,1); 
//Deactivated on startop
//$modules[$m] = new Module($m,0); //Uncomment to use this option and then comment out the one above.
$modules[$m]->setInfo(__FILE__); //NO TOUCHY or file will not load properly
$vidiot = "villageidiot"; $gm = "gamemaster"; $aa = "autoassign";

/* COMMANDS BELOW HERE. */
// Werewolf File, basic commands.
$modules[$m]->addCmd( 'play'      , 'werewolf'  , 0, 1 );	// $play adds you to the game.
$modules[$m]->addCmd( 'unplay'    , 'werewolf'  , 0, 1 );	// $unplay removes you from the game. Also unsets your role, if a game is in progress.
$modules[$m]->addCmd( 'townie'    , 'werewolf'  , 0, 1 );	// $townie gives you a description of the townie role.
$modules[$m]->addCmd( 'vidiot'    , 'werewolf'  , 0, 1 );	// $vidiot gives you a description of the village idiot, and allows the game master to turn it on or off.
$modules[$m]->addCmd( $vidiot     , 'werewolf'  , 0, 1 );	// $villageidiot is an alias of $vidiot, and gives you a description of the role.
$modules[$m]->addCmd( 'crole'     , 'werewolf'  , 0, 1 );	// $crole is confirm role. This allows the bot to know if everyone has confirmed learning their role.
$modules[$m]->addCmd( 'mute'      , 'werewolf'  , 0, 1 );	// $mute allows the GameMaster to mute the Players. ( Manually, as the bot does it automatically at sunset ).
$modules[$m]->addCmd( 'unmute'    , 'werewolf'  , 0, 1 );	// $unmute allows the GameMaster to unmute the players, which is done automatically at sunrise.
$modules[$m]->addCmd( 'gm'        , 'werewolf'  , 0, 1 );	// $gm allows the first player to use it to become the GameMaster.
// GameMaster File, Game Master commands.
$modules[$m]->addCmd( 'gamemaster', 'gm'        , 0, 1 );	// $gamemaster gives a description of what the GameMaster's role is.
$modules[$m]->addCmd( 'gameroom'  , 'gm'        , 0, 1 );	// $gameroom sets the main room for werewolf.
$modules[$m]->addCmd( 'backroom'  , 'gm'        , 0, 1 );	// $backroom sets the backroom for Werewolf. ( No games hosted externally, at current ).
$modules[$m]->addCmd( 'autoassign', 'gm'        , 0, 1 );	// $autoassign is the command used to enable/disable the autoassigner.
$modules[$m]->addCmd( 'assign'    , 'gm'        , 0, 1 );	// $assign launches the autoassigner, which is optional.
$modules[$m]->addCmd( 'role'      , 'gm'        , 0, 1 );	// $role is the command the GameMaster uses to manually assign a role to a player.
$modules[$m]->addCmd( 'xrole'     , 'gm'        , 0, 1 );	// $xrole allows the GameMaster to cancel a role given to a player, so they may be reassigned.
$modules[$m]->addCmd( 'setoracle' , 'gm'        , 0, 1 );	// $setoracle allows the GM to manually allow the oracle to use their command. ( Automatic at $sunset )
$modules[$m]->addCmd( 'setwitch'  , 'gm'        , 0, 1 );	// $setwitch allows the GM to manually allow the witch to use their commands. ( automatic with $assign )
$modules[$m]->addCmd( 'sunrise'   , 'gm'        , 0, 1 );	// $sunrise launches daytime, and the deaths of all the players from the night round ( wolves and witch );
$modules[$m]->addCmd( 'sunset'    , 'gm'        , 0, 1 );	// $sunset launches the night round, wolves, witch, oracle, and first round, cupid.
$modules[$m]->addCmd( 'lynch'     , 'gm'        , 0, 1 );	// $lynch is used by the GM to kill the townie elect suspected of being a werewolf. ( automation in progress )
$modules[$m]->addCmd( 'end'       , 'gm'        , 0, 1 );	// $end allows the GameMaster ( or person in the privclass ) to end the game.
// Witch file, Witch commands.
$modules[$m]->addCmd( 'witch'     , 'witch'     , 0, 1 );	// $witch gives a description of the witch role.
$modules[$m]->addCmd( 'todie'     , 'witch'     , 0, 1 );	// $todie tells the witch who the wolves have elected to kill.
$modules[$m]->addCmd( 'saves'     , 'witch'     , 0, 1 );	// $saves allows the Witch the opportunity to save who the wolves are going to kill, once per game.
$modules[$m]->addCmd( 'wkill'     , 'witch'     , 0, 1 );	// $wkill allows the Witch to kill a single player ( usually a suspected wolf ), once per game.
// Oracle file, Oracle commands.
$modules[$m]->addCmd( 'oracle'    , 'oracle'    , 0, 1 );	// $oracle gives a description of the Oracle role.
$modules[$m]->addCmd( 'seek'      , 'oracle'    , 0, 1 );	// $seek allows the oracle a view of a single person's true role, once per turn.
// Werewolves file, werewolf commands.
$modules[$m]->addCmd( 'werewolf'  , 'werewolves', 0, 1 );	// $werewolf gives a description of the Werewolf role.
$modules[$m]->addCmd( 'kills'     , 'werewolves', 0, 1 );	// $kills is the vote command used for the wolves to elect a kill.
$modules[$m]->addCmd( 'xvote'     , 'werewolves', 0, 1 );	// $xvote cancels the vote, and allows the wolf to change their vote.
// Defender file, Defender commands.
$modules[$m]->addCmd( 'defender'  , 'defender'  , 0, 1 );	// $defender gives a description of the Defender role, and allows the GM to enable or disable it.
$modules[$m]->addCmd( 'defend'    , 'defender'  , 0, 1 );	// $defend is the command the defender uses to protect a player from the werewolves.
// Harlot file, Harlot commands.
$modules[$m]->addCmd( 'harlot'    , 'harlot'    , 0, 1 );	// $harlot gives a description of the Harlot role, and allows the GM to enable or disable it.
//$modules[$m]->addCmd( 'sleep'     , 'harlot'    , 0, 1 );	// $sleep is the command the Harlot uses to protect a player from the werewolves or witch. ( disabled currently ).
// Jester file, jester commands.
$modules[$m]->addCmd( 'jester'    , 'jester'    , 0, 1 );	// $jester gives a description of the Jester role, and allows the GM to enable or disable it.
$modules[$m]->addCmd( 'swaprole'  , 'jester'    , 0, 1 );	// $swaprole swaps the roles of two players, at the jester's discretion, once per game.
// Cupid file, cupid commands.
$modules[$m]->addCmd( 'cupid'     , 'cupid'     , 0, 1 );	// $cupid gives a description of the Cupid role, and allows the GM to enable or disable it.
$modules[$m]->addCmd( 'lovers'    , 'cupid'     , 0, 1 );	// $lovers selects the two lucky players to be lovers ( bound in death, and victory ).
// Hunter file, hunter commands.
$modules[$m]->addCmd( 'hunter'    , 'hunter'    , 0, 1 );	// $hunter gives a description of the Hunter role, and allows the GM to enable or disable it.
$modules[$m]->addCmd( 'hunt'      , 'hunter'    , 0, 1 );	// $hunt allows the hunter to avenge their death and take someone with them. 

/* HELPS BELOW HERE. */
// General Help.
$modules[$m]->addHelp( "play"     , "{$tr}play adds you to the game." );
$modules[$m]->addHelp( "unplay"   , "{$tr}unplay removes you from the game, or if being used by the GameMaster, may remove a person from the game." );
$modules[$m]->addHelp( "townie"   , "{$tr}townie displays a description of what the townie does in game and the commands that apply to their role." );
$modules[$m]->addHelp( "vidiot"   , "{$tr}vidiot [on/off] enables or disables the Village Idiot role, or, left blank, just displays a description of the role." );
$modules[$m]->addHelp( $vidiot    , "{$tr}{$vidiot} just displays a description of the Village Idiot role." );
$modules[$m]->addHelp( "crole"    , "{$tr}crole allows the player to confirm that they have received the note telling them ther role." );
$modules[$m]->addHelp( "mute"     , "{$tr}mute <i>[privclass]</i> silences the provided privclass." );
$modules[$m]->addHelp( "unmute"   , "{$tr}unmute <i>[privclass]</i> unsilences the provided privclass." );
$modules[$m]->addHelp( "gm"       , "{$tr}gm allows the first <i>active player</i> to use it to take up the role of GameMaster." );
// GameMaster Help.
$modules[$m]->addHelp( $gm        , "{$tr}gamemaster displays a description of what the Game Master does and the commands that they have access to." );
$modules[$m]->addHelp( "gameroom" , "{$tr}gameroom [set/clear] [#room] sets or clears the main room being used for Werewolf. The gameroom is where the game is being hosted." );
$modules[$m]->addHelp( "backroom" , "{$tr}backroom [set/clear] [#room] sets or clears the backroom being used for Werewolf." );
$modules[$m]->addHelp( $aa        , "{$tr}autoassign [on/off] toggles whether or not the autoassigner is on. If it's off, {$tr}assign will not work." );
$modules[$m]->addHelp( "assign"   , "{$tr}assign uses the autoassigner to divvy out the roles to all the players, excluding the GM." );
$modules[$m]->addHelp( "role"     , "{$tr}role [player] [role] allows the GM to manually assign any of the currently used roles." );
$modules[$m]->addHelp( "xrole"    , "{$tr}xrole [player] allows the GM to cancel a given role, so that they may be reassigned another using {$tr}role." );
$modules[$m]->addHelp( "setoracle", "{$tr}setoracle manually allows the oracle to use their command. It's automatically triggered by {$tr}sunset, however." );
$modules[$m]->addHelp( "setwitch" , "{$tr}setwitch manually allows the witch to use their save/kill potions. Automatically triggered at the start of the game." );
$modules[$m]->addHelp( "sunrise"  , "{$tr}sunrise triggers all the deaths of the players selected by the wolves and the witch, and starts the <i>day</i> round." );
$modules[$m]->addHelp( "sunset"   , "{$tr}sunset triggers the <i>night</i> round, wherein the wolves, witch, oracle, defender/harlot, and cupid have their turns." );
$modules[$m]->addHelp( "lynch"    , "{$tr}lynch [player] <i>confirm</i> currently used by the GM kills the player suspected by the townies to be a werewolf." );
$modules[$m]->addHelp( "end"      , "{$tr}end will terminate the current session of Werewolf. Autorun by the death of the idiot, all the wolves or most of the townies." );
// Witch Help
$modules[$m]->addHelp( "witch"    , "{$tr}witch displays a description of what the witch does in game and the commands that apply to their role." );
$modules[$m]->addHelp( "todie"    , "{$tr}todie tells the witch who the werewolves have selected to kill." );
$modules[$m]->addHelp( "saves"    , "{$tr}saves [player] <i>confirm</i> allows the witch to save [player] from the werewolves." );
$modules[$m]->addHelp( "kills"    , "{$tr}kills [player] <i>confirm</i> allows the witch to kill a player ( usually suspected of being a wolf )." );
// Werewolf Help.
$modules[$m]->addHelp( "werewolf" , "{$tr}werewolf shows a description of the Werewolf role, and their applicable commands." );
$modules[$m]->addHelp( "wkill"    , "{$tr}wkill [player] counts the wolf's vote to kill [player]. [Player] will be selected upon a majority vote." );
$modules[$m]->addHelp( "xvote"    , "{$tr}xvote allows the wolves to cancel their vote and change it to another player." );
// Oracle Help.
$modules[$m]->addHelp( "oracle"   , "{$tr}oracle shows a description of the Oracle role, and their applicable commands." );
$modules[$m]->addHelp( "seek"     , "{$tr}seek [player] gives the oracle the true role of [player]. Usable once per night." );
// Defender Help.
$modules[$m]->addHelp( "defender" , "{$tr}defender [on/off] enables/disables the Defender role, or displays the description of the role and the Defender's commands." );
$modules[$m]->addHelp( "defend"   , "{$tr}defend [player] defends [player] from the wolves. Cannot defend a player two turns in a row, and can only defend themselves once." );
// Harlot Help.
$modules[$m]->addHelp( "harlot"   , "{$tr}harlot [on/off] enables/disables the Harlot role, or displays the description of the role and the Harlot's commands." );
$modules[$m]->addHelp( "sleep"    , "{$tr}sleep [player] defends [player] from the wolves. Cannot sleep with a player two turns in a row, and prevents the wolves from attacking." );
// Jester Help.
$modules[$m]->addHelp( "jester"   , "{$tr}jester [on/off] enables/disables the Jester role, or displays the description of the role and the Jester's commands." );
$modules[$m]->addHelp( "swaprole" , "{$tr}swaprole [player1] [player2] <i>confirm</i> swaps player1 and player2's roles. This can be done any night round first thing." );
// Cupid Help.
$modules[$m]->addHelp( "cupid"    , "{$tr}cupid [on/off] enables/disables the Cupid role, or displays the description of the role and Cupid's commands." );
$modules[$m]->addHelp( "lovers"   , "{$tr}lovers [player1] [player2] binds [player1] with player2 as lovers, wherein they either die or win together." );
// Hunter Help.
$modules[$m]->addHelp( "hunter"   , "{$tr}hunter [on/off] enables/disables the Hunter role, or displays a description of the role and the Hunter's commands." );
$modules[$m]->addHelp( "hunt"     , "{$tr}hunt [player] <i>confirm</i> kills [player]. Usable only after the Hunter has been killed." );
?>