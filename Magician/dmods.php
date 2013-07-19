<?php
$tt=$config['bot']['trigger'];
if(!isset($config['dmods2'])){
	$config['dmods2']['modules'] = array (
	'Dante(0.10)' => 
		array (
		'link' => 'http://download.botdom.com/k3b0d/Dante%200.10.zip',
		),
		'Colorcheck' => 
		array (
		'link' => 'http://download.botdom.com/ap7au/colors.zip',
		'by' => 'Wizard-Kgalm',
		),
		'Contra(4.0)' => 
		array (
		'link' => 'http://download.botdom.com/jug5w/Contra_4_public.zip',
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
		'Gnote' => 
		array (
		'link' => 'http://download.botdom.com/p8u2j/gnote.zip',
		'by' => 'cthom06',
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
		'Magician(3.5)' => 
		array (
		'link' => 'http://download.botdom.com/y91up/Magician3.0a.zip',
		'by' => 'Wizard-Kgalm',
		),
		'Magician(3.6)' => 
		array (
		'link' => 'http://download.botdom.com/e1ysu/Magician3.6.zip',
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
		'dANote' => 
		array (
		'link' => 'http://downloads.shadowkitsune.net/modules/serve.php?file=DanteNOTE-0.4.1.zip',
		'by' => 'ClanCC',
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
	);
	$config['dmods'] = $config['dmods2'];
	save_config('dmods');
	save_config('dmods2');
}
if(isset($config['dmods']['modules'][1])){
	$config['dmods'] = $config['dmods2'];
	save_config('dmods');
	$dAmn->say("$from: Dmods list updated successfully.",$c);
}
switch ($args[0]){
	case "dmods":
		switch($args[1]){
			case "add":
				if(!empty($args[2])){
					if(!empty($args[3])){
						if(!empty($args[4])){
							$dmods = array('name'=>$args[2], 'link'=>$args[3], 'by'=>$args[4],);
						}else
							$dmods = $dmods = array('name'=>$args[2], 'link'=>$args[3],);
						$moo = false;
						foreach($config['dmods']['modules'] as $id => $mod){ $mock = $mod[0]; 
							if(strtolower($mock) == strtolower($args[2])){
							$moo = true;
							}
						}
						if(!$moo){
							$config['dmods']['modules'][$dmods['name']]['link'] = $dmods['link'];
							if(isset($dmods['by'])){
								$config['dmods']['modules'][$dmods['name']]['by'] = $dmods['by'];
							}
							ksort($config['dmods']['modules']);
							save_config('dmods');
								$dAmn->say("$from: $args[2] has been successfully added!",$c);
						}else
							$dAmn->say("$from: $args[2] has already been added!",$c);
					}else
						$dAmn->say("$from: You must provide a download link to the module to add it.",$c);
				}else
					$dAmn->say("$from: Usage: ".$tt."dmods add <i>module</i>.",$c);
				break;
			case "del":
			case "delete":
			case "remove":
				if(isset($config['dmods'])){
					if(empty($args[2])){	
						return $dAmn->say("$from: You must include the name of the module you want to delete.",$c);
					}
					$remove = FALSE;
					foreach($config['dmods']['modules'] as $name => $info){
						if(strtolower($name) === strtolower($args[2])){
							unset($config['dmods']['modules'][$name]);
							ksort($config['dmods']['modules']);
							save_config('dmods');
							$remove = TRUE;
						}
					}
					if($remove){
						$dAmn->say("$from: $args[2] has been removed from the list!",$c);
					}else
						$dAmn->say("$from: $args[2] was not found on the list. Check to make sure it exists using {$tr}dmods check <i>name</i>",$c); 
				}else
					return $dAmn->say("$from: There aren't any modules stored yet.",$c);
				break;
			case "change":
				if($args[2] !=""){
					if(!isset($config['dmods']['modules'][$args[2]])){
						return $dAmn->say($f ."$args[2] was not found on the list. Type {$tr}dmods list to see the full list of names.",$c);
					}
					if($args[3] !=""){
						$config['dmods']['modules'][$args[2]]['link'] = $args[3];
						save_config('dmods');
						$dAmn->say($f ."Download link successfully updated.",$c);
					}else
						$dAmn->say($f ."You need to provide a link to change the current one to.",$c);
				}else
					$dAmn->say($f ."You need the name of a module and a download link to change that module's download link to.",$c);
				break;
			case "change2":
				if($args[2] !=""){
					if(!isset($config['dmods']['modules'][$args[2]])){
						return $dAmn->say($f ."$args[2] was not found. {$tr}dmods list will display a list of all the available modules.",$c);
					}
					if($args[3] !=""){
						$config['dmods']['modules'][$args[2]]['by'] = $args[3];
						save_config('dmods');$dAmn->say($f ."Author successfully updated.",$c);
					}else
						$dAmn->say($f ."You need to provide an author to change the current one to.",$c);
				}else
					$dAmn->say($f ."You need the name of a module and the name of the author of that module to change this.",$c);
					break;
			case "rname":
				if(!empty($args[2])){
					if(!empty($args[3])){
						foreach($config['dmods']['modules'] as $id => $mod){
							if(strtolower($id) == strtolower($args[2])){
								$config['dmods']['modules'][$args[3]] = $config['dmods']['modules'][$id];
								unset($config['dmods']['modules'][$id]);
								save_config('dmods');
								$founding = TRUE;
							}
						}
						if($founding){
							$dAmn->say("$from: Module $args[2] has been renamed $args[3]!",$c);
						}else
							$dAmn->say("$from: Module $args[2] could not be found.",$c);
					}else
						$dAmn->say("$from: You must provide a name to rename the module to.",$c);
				}else
					$dAmn->say("$from: Usage: ".$tr."dmods rname <i>modulename <b>RENAME</b></i>.",$c);
				break;
			case "list":
				$say="";
				if(!empty($config['dmods'])){
					if($args[2] == ""){
						$say .="<sup>The Modules stored are: <br/>";
						foreach($config['dmods']['modules'] as $id => $mod){
							$say .=" {$id} | ";
						}
						$dAmn->say($say,$c);
					}else
					if($args[2] == "links"){
						$say .="<sup>The Modules you have stored on here are: <br/>";
						foreach($config['dmods']['modules'] as $id => $mod){
							$say .=" {$id} {$config['dmods']['modules'][$id]['link']} <br> ";
						}
						$dAmn->say($say,$c);
					}else
					if($args[2] == "all"){
						$say .="<sup>The Modules you have stored on here are: <br/>";
						foreach($config['dmods']['modules'] as $id => $mod){
						$say .=" {$id} {$config['dmods']['modules'][$id]['link']} {$config['dmods']['modules'][$id]['by']} <br> ";
						}
						$dAmn->say($say,$c);
					}
				}else
					$dAmn->say("$from: There aren't any modules stored.",$c);
				break;
			case "check":
				if(!empty($config['dmods'])){
					if($args[2] !=""){
						$finding = FALSE;
						foreach($config['dmods']['modules'] as $id => $mod){
							if(strtolower($id) == strtolower($args[2])){
								$finding = TRUE;
								$link= $config['dmods']['modules'][$id]['link'];
								$by = $config['dmods']['modules'][$id]['by'];
								$name = $id;
							}
						}
						if($finding){
							if(isset($by)){
								$dAmn->say("$from: <b><a href=\"".$link."\" title=\"{$name}\">{$name}</a></b> by :dev{$by}:",$c);
							}else
								$dAmn->say("$from: <b><a href=\"".$link."\" title=\"{$name}\">{$name}</a></b>",$c);
						}else
							$dAmn->say("$from: No {$args[2]} module exists.",$c);
					}else
						$dAmn->say("$from: Usage: ".$tr."dmods check <i>NAME</i>",$c);
				}else
					$dAmn->say("$from: You have no mods stored.",$c);
				break;
			default: 
				$say="";
				if(!empty($config['dmods'])){
					$say .= "<sup>These are the modules for Dante:</sup><br>";
					$i = 0;
					foreach($config['dmods']['modules'] as $id => $mod){
						$link = $config['dmods']['modules'][$id]['link'];
						$by = $config['dmods']['modules'][$id]['by'];
						while($i < 1){
							if(isset($by)){
								$say .= " <sub><sub><b><a href=\"".$link."\" title=\"{$id}\">{$id}</a></b> by :dev{$by}:</sub></sub> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							}else{
								$say .= " <sub><sub><b><a href=\"".$link."\" title=\"{$id}\">{$id}</a></b></sub></sub>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
							}$i++;
						}$i++;

						if($i == 3){
							if(isset($by)){
								$say .= " <sub><sub><b><a href=\"".$link."\" title=\"{$id}\">{$id}</a></b> by :dev{$by}:</sub></sub><br>";
								$i = 0;
							}else
								$say .= " <sub><sub><b><a href=\"".$link."\" title=\"{$id}\">{$id}</a></b></sub></sub><br>";
								$i = 0;
						}
					}	
					$dAmn->say($say,$c);
				}else
					$dAmn->say("$from: To get started, type ".$tt."$dmods add <i>module link (by)</i> to add a module. Leave by blank if you don't know who the author is.",$c);
				break;
			}break;
}