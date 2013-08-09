<?php
/* Module Header */
// DANTE MODULE ======
// Name: werewolf
// Description: Automation of certain things for the hit game Werewolf. 
// Author: Wizard-Kgalm 
// Version: 1.0a
// Notes: lol
// ====================
//Activated on startup 
$modules[$m] = new Module($m,1); 
//Deactivated on startop
//$modules[$m] = new Module($m,0); //Uncomment to use this option and then comment out the one about.
$modules[$m]->setInfo(__FILE__); //NO TOUCHY or file will not load properly
/* Commands and Events below here */

$modules[$m]->addCmd('play','werewolf',0,1);
$modules[$m]->addHelp("play", "{$tr}play adds you to the game." );

$modules[$m]->addCmd('role','werewolf',0,1);
$modules[$m]->addHelp("role", "{$tr}role <i>player ROLE</i> allows the GameMaster to manually assign a role. The roles are Werewolf, Townie, Oracle, Witch, Defender, Cupid, and Hunter." );

$modules[$m]->addCmd('end','werewolf',0,1);
$modules[$m]->addHelp("end", "{$tr}end will terminate the current session of Werewolf." );

$modules[$m]->addCmd('xrole','werewolf',0,1);
$modules[$m]->addHelp("xrole", "{$tr}xrole <i>player</i> allows the GameMaster to cancel a given role. If he wants to, he may also assign a new one using {$tr}role." );

$modules[$m]->addCmd('gm','werewolf',0,1);
$modules[$m]->addHelp("gm", "{$tr}gm turns the user into the GameMaster if one doesn't currently exist and that user is currently playing in that session of werewolf." );

$modules[$m]->addCmd('assign','werewolf',0,1);
$modules[$m]->addHelp("play", "{$tr}assign is used by the GameMaster to autoassign roles to all the players (excluding the Game Master him/herself). Autoassign has to be enabled for this to work." );

$modules[$m]->addCmd('oracle','werewolf',0,1);

$modules[$m]->addCmd('witch','werewolf',0,1);
$modules[$m]->addHelp("witch", "{$tr}witch displays a description of what the witch does in game and the commands that apply to their role." );

$modules[$m]->addCmd('werewolf','werewolf',0,1);
$modules[$m]->addHelp("werewolf", "{$tr}werewolf displays a description of what the werewolves do in game and the commands that apply to their roles." );

$modules[$m]->addCmd('gamemaster','werewolf',0,1);
$modules[$m]->addHelp("gamemaster", "{$tr}gamemaster displays a description of what the Game Master does and the commands that they have access to." );

$modules[$m]->addCmd('defender','werewolf',0,1);
$modules[$m]->addHelp("defender", "{$tr}defender <i>on/off</i> toggles whether the defender role may be assigned. If used without on or off, it displays a description of what the defender does in game and the commands that apply to their role." );

$modules[$m]->addCmd('townie','werewolf',0,1);
$modules[$m]->addHelp("townie", "{$tr}townie displays a description of what the townie does in game and the commands that apply to their role." );

$modules[$m]->addCmd('cupid','werewolf',0,1);
$modules[$m]->addHelp("cupid", "{$tr}cupid <i>on/off</i> toggles whether the cupid role may be assigned. If used without on or off, itdisplays a description of what cupid does in game and the commands that apply to their role." );

$modules[$m]->addCmd('hunter','werewolf',0,1);
$modules[$m]->addHelp("hunter", "{$tr}hunter <i>on/off</i> toggles whether the hunter role may be assigned. If used without on or off, it displays a description of what the hunter does in game and the commands that apply to their role." );

$modules[$m]->addCmd('autoassign','werewolf',0,1);
$modules[$m]->addHelp("autoassign", "{$tr}autoassign <i>on/off</i> toggles whether or not the autoassigner is on. If it's off, {$tr}assign will not work." );

$modules[$m]->addCmd('backroom','werewolf',0,1);
$modules[$m]->addHelp("backroom", "{$tr}backroom set/clear <i>#room</i> sets or clears the backroom being used for Werewolf." );

$modules[$m]->addCmd('gameroom','werewolf',0,1);
$modules[$m]->addHelp("gameroom", "{$tr}gameroom set/clear <i>#room</i> sets or clears the main room being used for Werewolf. The gameroom is where the game is being hosted." );

$modules[$m]->addCmd('unplay','werewolf',0,1);
$modules[$m]->addHelp("unplay", "{$tr}unplay removes you from the game, or if being used by the GameMaster, may remove a person from the game." );

$modules[$m]->addCmd('assignment','werewolf',0,1);
$modules[$m]->addHelp("assignment", "{$tr}assignment allows each player to see their role in the backroom. " );

$modules[$m]->addCmd('lovers','werewolf',0,1);
$modules[$m]->addHelp("lovers", "{$tr}lovers is the command used by cupid to select the lovers." );

$modules[$m]->addCmd('defend','werewolf',0,1);
$modules[$m]->addHelp("defend", "{$tr}defend is the command used by the defender to select who they want to defend from a <b>Werewolf</b> attack. Does not protect from the witch or lynching." );

$modules[$m]->addCmd('wkill','werewolf',0,1);
$modules[$m]->addHelp("wkill", "{$tr}wkill <i>player</i> is the command used by the wolves to select (vote for) their kill. If they mess up, the werewolf may also use {$tr}xvote to cancel their vote and revote." );

$modules[$m]->addCmd('xvote','werewolf',0,1);
$modules[$m]->addHelp("xvote", "{$tr}xvote is used by the werewolves to cancel their vote for a player to maul." );

$modules[$m]->addCmd('todie','werewolf',0,1);
$modules[$m]->addHelp("todie", "{$tr}todie is the command used by the witch to view who the werewolves have selected to kill and their potion status." );

$modules[$m]->addCmd('saves','werewolf',0,1);
$modules[$m]->addHelp("saves", "{$tr}saves <i>player <b>confirm</b></i> is the command used by the witch to use their save potion on the player that is to die by werewolf." );

$modules[$m]->addCmd('kills','werewolf',0,1);
$modules[$m]->addHelp("kills", "{$tr}kills <i>player <b>confirm</b></i> is the command used by the witch to use their kill potion and kill another player." );

$modules[$m]->addCmd('seek','werewolf',0,1);
$modules[$m]->addHelp("seek", "{$tr}seek <i>player</i> is the command used by the oracle to view the role of one player per turn. It may only be used ONCE per turn." );

$modules[$m]->addCmd('setoracle','werewolf',0,1);
$modules[$m]->addHelp("setoracle", "{$tr}setoracle is used by the game master every turn to set the point so that the oracle may use seek. Otherwise, {$tr}seek will not work." );

$modules[$m]->addCmd('setwitch','werewolf',0,1);
$modules[$m]->addHelp("setwitch", "{$tr}setwitch is used by the game master at the start of the game to set the witch's two potions." );

$modules[$m]->addCmd('sunrise','werewolf',0,1);
$modules[$m]->addHelp("sunrise", "{$tr}sunrise is used by the game master after all the turns have been run at night. This will automatically kill any players who have been tagged to die (unless saved by the defender, if applicable). It also +msg's the player privclass." );

$modules[$m]->addCmd('lynch','werewolf',0,1);
$modules[$m]->addHelp("lynch", "{$tr}lynch <i>player <b>confirm</b></i> is currently being used by the game master to kill the player voted on by the townsfolk to die." );

$modules[$m]->addCmd('hunt','werewolf',0,1);
$modules[$m]->addHelp("hunt", "{$tr}hunt <i>player <b>confirm</b></i> is used by the hunter when the hunter has been killed. This command allows them to take someone to the grave with them." );

$modules[$m]->addCmd('sunset','werewolf',0,1);
$modules[$m]->addHelp("sunset", "{$tr}sunset is used by the Game Master to trigger nightfall and -msg the players." );

$modules[$m]->addCmd('mute','werewolf',0,1);
$modules[$m]->addHelp("mute", "{$tr}mute <i>privclass</i> -msgs the provided privclass." );

$modules[$m]->addCmd('unmute','werewolf',0,1);
$modules[$m]->addHelp("unmute", "{$tr}unmute <i>privclass</i> +msgs the provided privclass." );

$modules[$m]->addHook('recv-join','werewolf');

