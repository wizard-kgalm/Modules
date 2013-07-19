<?php
if(file_exists('./config/dmods.df')){
	$dmods = include './config/dmods.df';
}
if(empty($dmods)){
	$dmods['modules'] = array (
		'Dante(0.12.3)' => 
		array (
			'link' => 'http://download.botdom.com/3o7ye/Dante%200.12.3.zip',
			'by' => 'KnightOfBreath',
		),
		'Colorcheck' => 
		array (
			'link' => 'http://download.botdom.com/eckgu/colors.zip',
			'by' => 'Wizard-Kgalm',
		),
		'Contra(5.6.5)' => 
		array (
			'link' => 'http://download.botdom.com/nxp53/Contra_5.6.5.zip',
			'by' => 'photofroggy',
		),
		'Dice' => 
		array (
			'link' => 'http://download.botdom.com/28qs7/dice_for_dante.zip',
			'by' => 'tharglet',
		),
		'Dios' => 
		array (
			'link' => 'http://download.botdom.com/tx897/dios.zip',
			'by' => 'Magaman',
		),
		'Gold' => 
		array (
			'link' => 'http://download.botdom.com/bodli/Gold.zip',
			'by' => 'goldenskl',
		),
		'Input(0.10)' => 
		array (
			'link' => 'http://download.botdom.com/ux77i/input%20for%200.10%20SVN.zip',
			'by' => 'Wizard-Kgalm',
		),
		'Magician(4.5)' => 
		array (
			'link' => 'http://download.botdom.com/mt5ni/Magician4.5.zip',
			'by' => 'Wizard-Kgalm',
		),
		'Maltriv' => 
		array (
			'link' => 'http://download.botdom.com/x2gyh/Maltriv_1.7_dante09abeta.zip',
			'by' => 'photofroggy',
		),
		'News' => 
		array (
			'link' => 'http://download.botdom.com/eq4ow/news_for_dante.zip',
			'by' => 'tharglet',
		),
		'Platinum' => 
		array (
			'link' => 'http://download.botdom.com/vsacr/platinum.zip',
			'by' => 'Milotic1406',
		),
		'Pokezap' => 
		array (
			'link' => 'http://download.botdom.com/virsu/pokezap_1.0_for_dante.zip',
			'by' => 'tharglet',
		),
		'Translate' => 
		array (
			'link' => 'http://download.botdom.com/0tfw5/translate.zip',
			'by' => 'Frozen-Jakalope',
		),
		'Trivia' => 
		array (
			'link' => 'http://download.botdom.com/zyc9z/Trivia.zip',
			'by' => 'Solitude12',
		),
		'Urban_Dictionary' => 
		array (
			'link' => 'http://download.botdom.com/rdy0b/ud.php',
			'by' => 'Frozen-Jakalope',
		),
		'Vend_fix' => 
		array (
			'link' => 'http://download.botdom.com/tsd82/vend_fix_for_dante.zip',
			'by' => 'tharglet',
		),
		'YouTube' => 
		array (
			'link' => 'http://download.botdom.com/8tdz1/youtube_1.5.zip',
			'by' => 'Kakashi-Sasuke',
		),
		'badwords' => 
		array (
			'link' => 'http://download.botdom.com/aedcc/badwords_for_dante_1.5.zip',
			'by' => 'tharglet',
		),
		'calc' => 
		array (
			'link' => 'http://download.botdom.com/1hcyl/calc.zip',
			'by' => 'doofsmack',
		),
		'define' => 
		array (
			'link' => 'http://download.botdom.com/xhrev/searches_fix_1.0_for_dante.zip',
			'by' => 'tharglet',
		),
		'echochan' => 
		array (
			'link' => 'http://download.botdom.com/8er4r/echochan_1.0_for_dante.zip',
			'by' => 'tharglet',
		),
		'firewall' => 
		array (
			'link' => 'http://download.botdom.com/9djm3/firewall.zip',
			'by' => 'furrylover105',
		),
		'howlong' => 
		array (
			'link' => 'http://download.botdom.com/poy4y/howlong_for_dante.zip',
			'by' => 'tharglet',
		),
		'kickcounter' => 
		array (
			'link' => 'http://download.botdom.com/aw2my/kickcounter_1.0_for_Dante.zip',
			'by' => 'tharglet',
		),
		'kicktrivia' => 
		array (
			'link' => 'http://download.botdom.com/2ibpn/kicktrivia_1.1_for_dante.zip',
			'by' => 'tharglet',
		),
		'last.fm' => 
		array (
			'link' => 'http://download.botdom.com/rlx34/lastfm.zip',
			'by' => 'Frozen-Jakalope',
		),
		'note_fix' => 
		array (
			'link' => 'http://download.botdom.com/ehtts/notes_fix_for_dante.zip',
			'by' => 'SubjectX52873M',
		),
		'promoteme' => 
		array (
			'link' => 'http://download.botdom.com/jf3ja/promoteme_1.0_for_dante.zip',
			'by' => 'tharglet',
		),
		'rsay' => 
		array (
			'link' => 'http://download.botdom.com/0e66g/rsay_for_dante.zip',
			'by' => 'tharglet',
		),
		'seen' => 
		array (
			'link' => 'http://download.botdom.com/391qo/Scripts_Package_for_Dante.zip',
			'by' => 'tharglet',
		),
		'spamkick' => 
		array (
			'link' => 'http://download.botdom.com/0x8th/spamkick.zip',
			'by' => 'Milotic1406',
		),
		'timelog' => 
		array (
			'link' => 'http://download.botdom.com/7l9w8/timelog_for_dante.zip',
			'by' => 'tharglet',
		),
		'zapper' => 
		array (
			'link' => 'http://download.botdom.com/bdcib/zapper_1.0_for_dante.zip',
			'by' => 'tharglet',
		),
		'llama_giver' =>
		array (
			'link' => 'http://download.botdom.com/qluka/llama.zip',
			'by' => 'Wizard-Kgalm',
		),
	);
	foreach($dmods['modules'] as $name => $payload){
		$dmods['modules'][strtolower($name)] = $payload;
	}
	ksort($dmods['modules']);
	save_info('./config/dmods.df', $dmods);
}
switch ($args[0]){
	case "dmods":
		switch($args[1]){
			case "add":
				if(empty($args[2]) || empty($args[3])){
					return $dAmn->say($f. "Usage: {$tr}dmods <i>add [module] [link] [author]</i>. [module] is the name of the module, [link] is the download link to the module, [author] is an optional, but preferably included, parameter, and is the person (dA username) who made the module.", $c);
				}
				if(isset($dmods['modules'][$args[2]]) || isset($dmods['modules'][strtolower($args[2])])){
					return $dAmn->say($f. "The {$args[2]} module is already listed.", $c);
				}
				if(!empty($args[4])){
					$dmods['modules'][strtolower($args[2])] = array('link' => $args[3], 'by' => $args[4],);
				}else{
					$dmods['modules'][strtolower($args[2])] = array('link' => $args[3],);
				}
				save_info("./config/dmods.df", $dmods);
				$dAmn->say($f. "Module {$args[1]} has been added successfully.", $c);
				break;
			case "del":
			case "delete":
			case "remove":
				if(empty($args[2])){
					return $dAmn->say($f. "Usage: {$tr}dmods del [module]. [module] is the name of the module you would like to delete.", $c);
				}
				if(!isset($dmods['modules'][strtolower($args[2])]) || !isset($dmods['modules'][$args[2]])){
					return $dAmn->say($f. "Module $args[2] is not on the list. See {$tr}dmods list.", $c);
				}
				unset($dmods['modules'][strtolower($args[2])]); unset($dmods['modules'][$args[2]]);
				ksort($dmods['modules']);
				save_info('./config/dmods.df', $dmods);
				$dAmn->say($f. "Module {$args[1]} has been removed successfully.", $c);
			break;
			case "change":
				if(empty($args[2]) || empty($args[3])){
					return $dAmn->say($f. "Usage: {$tr}dmods change <i>[module] [link]</i>. [module] is the name of the module, and [link] is the new/updated link to the module. This command is for updating the download link.", $c);
				}
				if(!isset($dmods['modules'][strtolower($args[2])]) || !isset($dmods['modules'][$args[2]])){
					return $dAmn->say($f. "Module $args[2] is not on the list. See {$tr}dmods list.", $c);
				}
				$dmods['modules'][strtolower($args[2])]['link'] = $args[3];
				save_info("./config/dmods.df", $dmods);
				$dAmn->say($f. "Module {$args[2]}'s download link updated successfully.", $c);
			break;
			case "change2":
				if(empty($args[2]) || empty($args[3])){	
					return $dAmn->say($f. "Usage: {$tr}dmods change2 <i>[module] [author]</i>. [module] is the name of the module, and [author] is the dA username who made the module.", $c);
				}
				if(!isset($dmods['modules'][strtolower($args[2])]) || !isset($dmods['modules'][$args[2]])){
					return $dAmn->say($f. "Module $args[2] is not on the list. See {$tr}dmods list.", $c);
				}
				$dmods['modules'][strtolower($args[2])]['by'] = $args[3];
				save_info("./config/dmods.df", $dmods);
				$dAmn->say($f. "Module {$args[2]}'s author has been updated successfully.", $c);
			break;
			case "rname":
				if(empty($args[2]) || empty($args[3])){
					return $dAmn->say($f. "Usage: {$tr}dmods rname <i>[module] [newname]</i>. [module] is the name of the module you're changing the name of, and [newname] is the name you wish to change it to.", $c);
				}
				if(!isset($dmods['modules'][strtolower($args[2])]) || !isset($dmods['modules'][$args[2]])){
					return $dAmn->say($f. "Module $args[2] is not on the list. See {$tr}dmods list.", $c);
				}
				if(isset($dmods['modules'][strtolower($args[2])]) || isset($dmods['modules'][$args[2]])){
					if(isset($dmods['modules'][strtolower($args[3])]) || isset($dmods['modules'][$args[3]])){
						return $dAmn->say($f. "Module {$args[3]} already exists.", $c);
					}
					$dmods['modules'][strtolower($args[3])] = $dmods['module'][strtolower($args[2])];
					unset($dmods['modules'][strtolower($args[2])]);
					save_info('./config/dmods.df', $dmods);
					$dAmn->say($f. "Module {$args[2]} has successfully been renamed {$args[3]}.", $c);
				}
			break;
			case "list":
				$say = "";
				if(empty($dmods)){
					return $dAmn->say($f. "File not created properly by the bot. Check the config folder for 'dmods.df'.", $c);
				}
				$say .= "Your stored modules include: <br/><sup>";
				foreach($dmods['modules'] as $mod => $info){
					if(empty($args[2]) || strtolower($args[2]) !== "all"){
						$say .= " [ <a href=\"{$dmods['modules'][$mod]['link']}\" title=\"{$mod}\">{$mod}</a> ],";
					}else{
						$say .= " <a href=\"{$dmods['modules'][$mod]['link']}\" title=\"{$mod}\">{$mod}</a> by :dev{$dmods['modules'][$mod]['by']}:,";
					}
				}
				$dAmn->say($say, $c);
			break;
			case "check":
				if(empty($dmods)){
					return $dAmn->say($f. "File not created properly by the bot. Check the config folder for 'dmods.df'.", $c);
				}
				if(empty($args[2])){
					return $dAmn->say($f. "Usage: {$tr}dmods check [module]. [module] is the module you're checking for on the list.", $c);
				}
				if(!isset($dmods['modules'][strtolower($args[2])]) || !isset($dmods['modules'][$args[2]])){
					return $dAmn->say($f. "Module $args[2] is not on the list. See {$tr}dmods list.", $c);
				}
				$dAmn->say("<a href=\"{$dmods['modules'][strtolower($args[2])]['link']}\" title=\"{$args[2]}\">$args[2]</a> by :dev{$dmods['modules'][strtolower($args[2])]['by']}:", $c);
			break;
			default: 
				$dAmn->say($f. "Usage: {$tr}dmods <i>[add/del/change/change2/rname/list/check] [module]/[all] [newname/link] [author]</i>.<br><sup>{$tr}dmods <i>add [module] [link] [author]</i> adds [module] to the list of dmods. [module] is the name of the module (reqired), [link] is the download link to [module] (required), and [author] is the writer of the module (optional, but preferred).<br>{$tr}dmods <i>del [module]</i> deletes [module] from the list of dmods. [module] is the name of the module you want to delete (required).<br>{$tr}dmods <i>change [module] [link]</i> changes the download link of [module], if it exists. [module] is the name of the module you are changing (required), and [link] is the updated download link of [module] (required).<br>{$tr}dmods <i>change2 [module] [author]</i> changes (or adds) the writer of [module]. [module] is the name of the module you are changing (required), and [author] is the writer of the module (required).<br>{$tr}dmods <i>rname [module] [newname]</i> renames [module] to [newname]. [module] is the name of the module you're changing the name of (required), and [newname] is the name you're changing [module] to (required).<br>{$tr}dmods <i>list [all]</i> lists all the stored dmods with the download link. If [all] is included, it also shows the author, if listed (optional).<br>{$tr}dmods <i>check [module]</i> checks for [module] on the dmods list. [module] is the name of the module you are checking for.</sup>", $c);
			break;
		}
	break;
}