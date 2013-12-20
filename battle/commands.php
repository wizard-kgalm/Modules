<?php
include_once( "./modules/battle/functions.php" );
//Let's get our pokedex established. 

$types	=	array(																	// Despite being Generation I, I will include all currently known types.
	"Normal"	=>	array(
		"Offense"	=>	array(														// We'll need our strengths, weaknesses, and immunities listed.
			"Double"	=>	array(
			),
			"Half"		=>	array(
				1 => "Rock",
				2 => "Steel",
			),
			"None"		=>	array(
				1 => "Ghost",
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Fighting",
			),
			"Half"		=>	array(
			),
			"None"		=>	array(
				1 => "Ghost",
			),
		),
	),
	"Fire"		=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Bug",
				2 => "Grass",
				3 => "Ice",
				4 => "Steel",
			),
			"Half"		=>	array(
				1 => "Dragon",
				2 => "Fire",
				3 => "Rock",
				4 => "Water",
			),
			"None"		=>	array(
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Ground",
				2 => "Rock",
				3 => "Water",
			),
			"Half"		=>	array(
				1 => "Fairy",
				2 => "Bug",
				3 => "Fire",
				4 => "Grass",
				5 => "Ice",
				6 => "Steel",
			),
			"None"		=>	array(
			),
		),
	),
	"Water"		=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Fire",
				2 => "Ground",
				3 => "Rock",
			),
			"Half"		=>	array(
				1 => "Dragon",
				2 => "Grass",
				3 => "Water",
			),
			"None"		=>	array(
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Electric",
				2 => "Grass",
			),
			"Half"		=>	array(
				1 => "Fire",
				2 => "Ice",
				3 => "Steel",
				4 => "Water",
			),
			"None"		=>	array(
			),
		),
	),
	"Grass"		=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Ground",
				2 => "Rock",
				3 => "Water",
			),
			"Half"		=>	array(
				1 => "Bug",
				2 => "Dragon",
				3 => "Fire",
				4 => "Flying",
				5 => "Grass",
				6 => "Poison",
				7 => "Steel",
			),
			"None"		=>	array(
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Bug",
				2 => "Fire",
				3 => "Flying",
				4 => "Ice",
				5 => "Poison",
			),
			"Half"		=>	array(
				1 => "Electric",
				2 => "Grass",
				3 => "Ground",
				4 => "Water",
			),
			"None"		=>	array(
			),
		),
	),
	"Ice"		=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Dragon",
				2 => "Flying",
				3 => "Grass",
				4 => "Ground",
			),
			"Half"		=>	array(
				1 => "Fire",
				2 => "Ice",
				3 => "Steel",
				4 => "Water",
			),
			"None"		=>	array(
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Fighting",
				2 => "Fire",
				3 => "Rock",
				4 => "Steel",
			),
			"Half"		=>	array(
				1 => "Ice",
			),
			"None"		=>	array(
			),
		),
	),
	"Rock"		=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Bug",
				2 => "Fire",
				3 => "Flying",
				4 => "Ice",
			),
			"Half"		=>	array(
				1 => "Fighting",
				2 => "Ground",
				3 => "Steel",
			),
			"None"		=>	array(
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Fighting",
				2 => "Grass",
				3 => "Ground",
				4 => "Steel",
				5 => "Water",
			),
			"Half"		=>	array(
				1 => "Normal",
				2 => "Fire",
				3 => "Flying",
				4 => "Poison",
			),
			"None"		=>	array(
			),
		),
	),
	"Ground"	=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Electric",
				2 => "Fire",
				3 => "Poison",
				4 => "Rock",
				5 => "Steel",
			),
			"Half"		=>	array(
				1 => "Bug",
				2 => "Grass",
			),
			"None"		=>	array(
				1 => "Flying",
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Ice",
				2 => "Grass",
				3 => "Water",
			),
			"Half"		=>	array(
				1 => "Poison",
				2 => "Rock",
			),
			"None"		=>	array(
				1 => "Electric",
			),
		),
	),
	"Electric"	=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Flying",
				2 => "Water",
			),
			"Half"		=>	array(
				1 => "Dragon",
				2 => "Electric",
				3 => "Grass",
			),
			"None"		=>	array(
				1 => "Ground",
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Ground",
			),
			"Half"		=>	array(
				1 => "Electric",
				2 => "Fire",
				3 => "Steel",
			),
			"None"		=>	array(
			),
		),
	),
	"Bug"		=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Dark",
				2 => "Grass",
				3 => "Psychic",
			),
			"Half"		=>	array(
				1 => "Fighting",
				2 => "Fire",
				3 => "Flying",
				4 => "Ghost",
				5 => "Poison",
				6 => "Steel", 
				7 => "Fairy",
			),
			"None"		=>	array(
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Fire",
				2 => "Flying",
				3 => "Rock",
			),
			"Half"		=>	array(
				1 => "Fighting",
				2 => "Grass",
				3 => "Ground",
			),
			"None"		=>	array(
			),
		),
	),
	"Fighting"	=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Normal",
				2 => "Rock",
				3 => "Steel",
				4 => "Ice",
				5 => "Dark",
			),
			"Half"		=>	array(
				1 => "Poison",
				2 => "Flying",
				3 => "Bug",
				4 => "Psychic",
				5 => "Fairy",
			),
			"None"		=>	array(
				1 => "Ghost",
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Flying",
				2 => "Psychic",
				3 => "Fairy",
			),
			"Half"		=>	array(
				1 => "Bug",
				2 => "Dark",
				3 => "Rock",
			),
			"None"		=>	array(
			),
		),
	),
	"Poison"	=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Grass",
				2 => "Fairy",
			),
			"Half"		=>	array(
				1 => "Ghost",
				2 => "Ground",
				3 => "Poison",
				4 => "Rock",
			),
			"None"		=>	array(
				1 => "Steel",
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Ground",
				2 => "Psychic",
			),
			"Half"		=>	array(
				1 => "Bug",
				2 => "Fighting",
				3 => "Poison",
				4 => "Grass",
				5 => "Fairy",
			),
			"None"		=>	array(
			),
		),
	),
	"Ghost"		=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Ghost",
				2 => "Psychic",
			),
			"Half"		=>	array(
				1 => "Dark",
			),
			"None"		=>	array(
				1 => "Normal",
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Dark",
				2 => "Ghost",
			),
			"Half"		=>	array(
				1 => "Bug",
				2 => "Poison",
			),
			"None"		=>	array(
				1 => "Fighting",
				2 => "Normal",
			),
		),
	),
	"Flying"	=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Bug",
				2 => "Fight",
				3 => "Grass",
			),
			"Half"		=>	array(
				1 => "Electric",
				2 => "Rock",
				3 => "Steel",
			),
			"None"		=>	array(
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Electric",
				2 => "Ice",
				3 => "Rock",
			),
			"Half"		=>	array(
				1 => "Bug",
				2 => "Fight",
				3 => "Grass",
			),
			"None"		=>	array(
				1 => "Ground",
			),
		),
	),
	"Psychic"	=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Fighting",
				2 => "Poison",
			),
			"Half"		=>	array(
				1 => "Psychic",
				2 => "Steel",
			),
			"None"		=>	array(
				1 => "Dark",
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Bug",
				2 => "Dark",
				3 => "Ghost",
			),
			"Half"		=>	array(
				1 => "Fighting",
				2 => "Psychic",
			),
			"None"		=>	array(
			),
		),
	),
	"Dragon"	=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Dragon",
			),
			"Half"		=>	array(
				1 => "Steel",
			),
			"None"		=>	array(
				1 => "Fairy",
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Dragon",
				2 => "Ice",
				3 => "Fairy",
			),
			"Half"		=>	array(
				1 => "Electric",
				2 => "Fire",
				3 => "Grass",
				4 => "Water",
			),
			"None"		=>	array(
			),
		),
	),
	"Dark"		=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Ghost",
				2 => "Psychic",
			),
			"Half"		=>	array(
				1 => "Dark",
				2 => "Fighting",
				3 => "Fairy",
			),
			"None"		=>	array(
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Bug",
				2 => "Fighting",
				3 => "Fairy",
			),
			"Half"		=>	array(
				1 => "Dark",
				2 => "Ghost",
			),
			"None"		=>	array(
				1 => "Psychic",
			),
		),
	),
	"Steel"		=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Ice",
				2 => "Rock",
				3 => "Fairy",
			),
			"Half"		=>	array(
				1 => "Electric",
				2 => "Fire",
				3 => "Steel",
				4 => "Water",
			),
			"None"		=>	array(
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Fighting",
				2 => "Fire",
				3 => "Ground",
			),
			"Half"		=>	array(
				1 => "Bug",
				2 => "Dragon",
				3 => "Flying",
				4 => "Grass",
				5 => "Ice",
				6 => "Normal",
				7 => "Psychic",
				8 => "Rock",
				9 => "Steel",
				10 => "Fairy",
			),
			"None"		=>	array(
				1 => "Poison",
			),
		),
	),
	"Fairy"		=>	array(
		"Offense"	=>	array(
			"Double"	=>	array(
				1 => "Fighting",
				2 => "Dragon",
				3 => "Dark",
			),
			"Half"		=>	array(
				1 => "Fire",
				2 => "Poison",
				3 => "Steel",
			),
			"None"		=>	array(
			),
		),
		"Defense"	=>	array(
			"Double"	=>	array(
				1 => "Poison",
				2 => "Steel",
			),
			"Half"		=>	array(
				1 => "Fighting",
				2 => "Bug",
				3 => "Dark",
			),
			"None"		=>	array(
				1 => "Dragon",
			),
		),
	),
);
$config->df['pokeinfo']['types'] = $types;
$config->save_config( "./config/pokeinfo.df", $config->df['pokeinfo'] );
switch ( $args[0] )
{
	case "newgame":
		if( isset( $config->df['pokemon'][strtolower( $from )] ) )
		{
			return $dAmn->say( "$from: You already have a save file. Use {$tr}wipegame <i>confirm</i> or <i>yes</i> to erase this save file. Then, you may begin a new game.", $c );
		}
		if( empty( $args[1] ) || empty( $args[2] ) )
		{
			return $dAmn->say( "$from: Usage: {$tr}newgame [profile name] [gender]. This command sets up your profile for the dAmn Battle pokemon game. You need to include a profile name (your trainer name), and your gender.", $c );
		}
		if( strtolower( $args[2] ) !== "female" && $args[2] !== "male" )
		{
			return $dAmn->say( "$from: Your gender can either be male or female.", $c );
		}
		$config->df['pokemon'][strtolower( $from )] = array (
			"trainer" => $args[1],
			"gender"  => $args[2],
		);
		$starters = array(
			"charmander" => generate_pokemon( "charmander", 56 ),
			"bulbasaur"  => generate_pokemon( "bulbasaur" , 56 ),
			"squirtle"   => generate_pokemon( "squirtle"  , 56 ),
		);
		$config->df['starters'][strtolower( $from )] = $starters;
		$config->save_config( "./config/starters.df", $config->df['starters'] );
		$config->save_config( "./config/pokemon.df", $config->df['pokemon'] );
		$dAmn->say( "$from: Your profile has been started. From this point on, to view your profile, use {$tr}profile.", $c );
		$say = "Here are your starter pokemon options:<br><code> ";
		//$say .= sprintf( "%'".chr(160)."-11s", "Bulbasaur:" );
		$pad = 20;
		foreach( $config->df['starters'][strtolower( $from )] as $pokemon => $deets )
		{
		$say .= sprintf( "%'".chr(160)."-13s", "\n".$pokemon . ": " );
			foreach( $config->df['starters'][strtolower( $from )][$pokemon]['Stats'] as $stat => $quant )
			{
				if( $stat == "HP" )
				{
					$say .= sprintf( "%'".chr(160)."-8s", $stat . ": ". $quant );
				} elseif( $stat == "Special Attack" )
				{
					$say .= sprintf( "%'".chr(160)."-20s", $stat . ": ". $quant );
				} elseif( $stat == "Defense" )
				{
					$say .= sprintf( "%'".chr(160)."-13s", $stat . ": ". $quant );
				} elseif( $stat == "Attack" )
				{
					$say .= sprintf( "%'".chr(160)."-12s", $stat . ": ". $quant );
				}elseif( $stat == "Speed" )
				{
					$say .= sprintf( "%'".chr(160)."-11s", $stat . ": ". $quant );
				}elseif( $stat == "Special Defense" )
				{
					$say .= sprintf( "%'".chr(160)."-21s", $stat . ": ". $quant );
				}
				
			}
		}
		$dAmn->say( $say, $c );
	break;
	case "profile":
		switch( $args[1] )
		{
			default: 
				if( empty( $config->df['pokemon'][strtolower( $from )] ) || !isset( $config->df['pokemon'][strtolower( $from )] ) )
				{
					$dAmn->say( "$from: You are starting a new journey with dAmn Pokemon. This command will show you your profile info, along with your active pokemon. In order to get started, you will want to use {$tr}newgame [trainer name] [gender]. Once that is finished, you will be asked to select a starter! If, for any reason, you are unhappy with the choices you have made, you will use {$tr}wipesave <i>[yes/confirm]</i> to start over.", $c );
				} else
				{
					$say = "Your current game stats are: <br><sup>";
					foreach( $config->df['pokemon'][strtolower( $from )] as $stats => $details )
					{
						$say .= $stats . " => " . $details." <br>";
					}
					$dAmn->say( $say, $c );
				}
			break;
		}
	break;
	case "starter":
		if( empty( $config->df['pokemon'][strtolower( $from )] ) ) 
		{
			return $dAmn->say( "$from: You do not have a profile yet. To get started, type {$tr}newgame [trainer name] [gender].", $c );
		}
		if( isset( $config->df['pokemon'][strtolower( $from )]['starter'] ) )
		{
			return $dAmn->say( "$from: You selected your starter pokemon already. Please use {$tr}pgamehelp for a full list of commands if you require help on what to do next.", $c );
		}
		if( empty( $args[1] ) )
		{
			$dAmn->say( "$from: This command will select your starter pokemon. Your choices are Bulbasaur ({$tr}starter bulbasaur), Charmander ({$tr}starter charmander), or Squirtle ({$tr}starter squirtle). You may only choose one of these, so choose wisely. You will have to {$tr}wipesave in order to start again.", $c );
			$say = "Here are your starter pokemon options:<br><code> ";
			foreach( $config->df['starters'][strtolower( $from )] as $pokemon => $deets )
			{
				$say .= sprintf( "%'".chr(160)."-13s", "\n".$pokemon . ": " );
				foreach( $config->df['starters'][strtolower( $from )][$pokemon]['Stats'] as $stat => $quant )
				{
					if( $stat == "HP" )
					{
						$say .= sprintf( "%'".chr(160)."-8s", $stat . ": ". $quant );
					} elseif( $stat == "Special Attack" )
					{
						$say .= sprintf( "%'".chr(160)."-20s", $stat . ": ". $quant );
					} elseif( $stat == "Defense" )
					{
						$say .= sprintf( "%'".chr(160)."-13s", $stat . ": ". $quant );
					} elseif( $stat == "Attack" )
					{
						$say .= sprintf( "%'".chr(160)."-12s", $stat . ": ". $quant );
					}elseif( $stat == "Speed" )
					{
						$say .= sprintf( "%'".chr(160)."-11s", $stat . ": ". $quant );
					}elseif( $stat == "Special Defense" )
					{
						$say .= sprintf( "%'".chr(160)."-21s", $stat . ": ". $quant );
					}
					
				}
			}
			$dAmn->say( $say, $c );	
		}
		if( strtolower( $args[1] ) !== "squirtle" && strtolower( $args[1] ) !== "bulbasaur" && strtolower( $args[1] ) !== "charmander" )
		{
			return $dAmn->say( "$from: You may only select from the list of starter pokemon in this area, Bulbasaur, Charmander, or Squirtle.", $c );
		}
		if( isset( $config->df['starters'][strtolower( $from )] ) )
		{
			$config->df['pokemon'][strtolower( $from )]['starter'] = strtolower( $args[1] );
			$config->df['pokemon'][strtolower( $from )]['party']   = $config->df['starters'][strtolower( $from )][strtolower( $args[1] )];
			unset( $config->df['starters'][strtolower( $from )] );
			$config->save_config( "./config/pokemon.df", $config->df['starters'] );
			$config->save_config( "./config/pokemon.df", $config->df['pokemon'] );
			$dAmn->say( "$from: You have selected {$args[1]} as your starter and your party now includes {$args[1]}. Please see {$tr}pstats {$args[1]} to see its info.", $c );
		} else 
		{
			$dAmn->say( "$from: An error occurred. Please talk to the bot owner, Wizard-Kgalm", $c );
		}
	break;
	case "wipesave":
		if( empty( $args[1] ) || strtolower( $args[1] ) !== "yes" && strtolower( $args[1] ) !== "confirm" ) 
		{
			return $dAmn->say( "$from: This will wipe your save file, including all of your progress and details. Are you sure? {$tr}wipesave <i>confirm/yes</i>" , $c );
		}
		unset( $config->df['pokemon'][strtolower( $from )] );
		$config->save_config( "./config/pokemon.df", $config->df['pokemon'] );
		$dAmn->say( "$from: Your save file has been wiped! To start a new game, use {$tr}newgame.", $c );
	break;
}
						