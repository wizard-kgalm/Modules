<?php
$tt=$config['bot']['trigger'];
if(!isset($config['dmods'])){
	$config['dmods']['modules'] = array (
		  0 => 
		  array (
			0 => 'Colorcheck',
			1 => 'http://download.botdom.com/ap7au/colors.zip',
			2 => 'Wizard-Kgalm',
		  ),
		  1 => 
		  array (
			0 => 'Dice',
			1 => 'http://download.botdom.com/28qs7/dice_for_dante.zip',
			2 => 'tharglet',
		  ),
		  2 => 
		  array (
			0 => 'Dios',
			1 => 'http://download.botdom.com/tx897/dios.zip',
			2 => 'Magaman',
		  ),
		  3 => 
		  array (
			0 => 'Gnote',
			1 => 'http://download.botdom.com/p8u2j/gnote.zip',
			2 => 'cthom06',
		  ),
		  4 => 
		  array (
			0 => 'Gold',
			1 => 'http://download.botdom.com/bodli/Gold.zip',
			2 => 'goldenskl',
		  ),
		  5 => 
		  array (
			0 => 'Input/bZikes(0.10)',
			1 => 'http://download.botdom.com/ux77i/input%20for%200.10%20SVN.zip',
			2 => 'Wizard-Kgalm',
		  ),
		  6 => 
		  array (
			0 => 'Magician(1.0)',
			1 => 'http://download.botdom.com/brr9t/Magician.zip',
			2 => 'Wizard-Kgalm',
		  ),
		  7 => 
		  array (
			0 => 'Magician2.0',
			1 => 'http://download.botdom.com/czo3p/Magician%202.0.zip',
			2 => 'Wizard-Kgalm',
		  ),
		  8 => 
		  array (
			0 => 'Maltriv',
			1 => 'http://download.botdom.com/x2gyh/Maltriv_1.7_dante09abeta.zip',
			2 => 'photofroggy',
		  ),
		  9 => 
		  array (
			0 => 'News',
			1 => 'http://download.botdom.com/eq4ow/news_for_dante.zip',
			2 => 'tharglet',
		  ),
		  10 => 
		  array (
			0 => 'Platinum',
			1 => 'http://download.botdom.com/vsacr/platinum.zip',
			2 => 'Milotic1406',
		  ),
		  11 => 
		  array (
			0 => 'Pokezap',
			1 => 'http://download.botdom.com/virsu/pokezap_1.0_for_dante.zip',
			2 => 'tharglet',
		  ),
		  12 => 
		  array (
			0 => 'Translate',
			1 => 'http://download.botdom.com/0tfw5/translate.zip',
			2 => 'Frozen-Jakalope',
		  ),
		  13 => 
		  array (
			0 => 'Trivia',
			1 => 'http://download.botdom.com/zyc9z/Trivia.zip',
			2 => 'Solitude12',
		  ),
		  14 => 
		  array (
			0 => 'Urban_Dictionary',
			1 => 'http://download.botdom.com/rdy0b/ud.php',
			2 => 'Frozen-Jakalope',
		  ),
		  15 => 
		  array (
			0 => 'Vend_fix',
			1 => 'http://download.botdom.com/tsd82/vend_fix_for_dante.zip',
			2 => 'tharglet',
		  ),
		  16 => 
		  array (
			0 => 'YouTube',
			1 => 'http://download.botdom.com/8tdz1/youtube_1.5.zip',
			2 => 'Kakashi-Sasuke',
		  ),
		  17 => 
		  array (
			0 => 'badwords',
			1 => 'http://download.botdom.com/aedcc/badwords_for_dante_1.5.zip',
			2 => 'tharglet',
		  ),
		  18 => 
		  array (
			0 => 'calc',
			1 => 'http://download.botdom.com/1hcyl/calc.zip',
			2 => 'doofsmack',
		  ),
		  19 => 
		  array (
			0 => 'dANote',
			1 => 'http://downloads.shadowkitsune.net/modules/serve.php?file=DanteNOTE-0.4.1.zip',
			2 => 'ClanCC',
		  ),
		  20 => 
		  array (
			0 => 'define',
			1 => 'http://download.botdom.com/xhrev/searches_fix_1.0_for_dante.zip',
			2 => 'tharglet',
		  ),
		  21 => 
		  array (
			0 => 'echochan',
			1 => 'http://download.botdom.com/8er4r/echochan_1.0_for_dante.zip',
			2 => 'tharglet',
		  ),
		  22 => 
		  array (
			0 => 'firewall',
			1 => 'http://download.botdom.com/9djm3/firewall.zip',
			2 => 'furrylover105',
		  ),
		  23 => 
		  array (
			0 => 'howlong',
			1 => 'http://download.botdom.com/poy4y/howlong_for_dante.zip',
			2 => 'tharglet',
		  ),
		  24 => 
		  array (
			0 => 'kickcounter',
			1 => 'http://download.botdom.com/aw2my/kickcounter_1.0_for_Dante.zip',
			2 => 'tharglet',
		  ),
		  25 => 
		  array (
			0 => 'kicktrivia',
			1 => 'http://download.botdom.com/2ibpn/kicktrivia_1.1_for_dante.zip',
			2 => 'tharglet',
		  ),
		  26 => 
		  array (
			0 => 'last.fm',
			1 => 'http://download.botdom.com/rlx34/lastfm.zip',
			2 => 'Frozen-Jakalope',
		  ),
		  27 => 
		  array (
			0 => 'note_fix',
			1 => 'http://download.botdom.com/ehtts/notes_fix_for_dante.zip',
			2 => 'SubjectX52873M',
		  ),
		  28 => 
		  array (
			0 => 'promoteme',
			1 => 'http://download.botdom.com/jf3ja/promoteme_1.0_for_dante.zip',
			2 => 'tharglet',
		  ),
		  29 => 
		  array (
			0 => 'rsay',
			1 => 'http://download.botdom.com/0e66g/rsay_for_dante.zip',
			2 => 'tharglet',
		  ),
		  30 => 
		  array (
			0 => 'seen',
			1 => 'http://download.botdom.com/391qo/Scripts_Package_for_Dante.zip',
			2 => 'tharglet',
		  ),
		  31 => 
		  array (
			0 => 'spamkick',
			1 => 'http://download.botdom.com/0x8th/spamkick.zip',
			2 => 'Milotic1406',
		  ),
		  32 => 
		  array (
			0 => 'timelog',
			1 => 'http://download.botdom.com/7l9w8/timelog_for_dante.zip',
			2 => 'tharglet',
		  ),
		  33 => 
		  array (
			0 => 'zapper',
			1 => 'http://download.botdom.com/bdcib/zapper_1.0_for_dante.zip',
			2 => 'tharglet',
		  ),
		);
	save_config('dmods');
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
							$found=false;
							$i=0;
							while (!$found){
								if (!isset($config['dmods']['modules'][$i])){
									$found=true;
								} else {
									$i++;
								}		
							}
							$config['dmods']['modules'][$i][]=$dmods['name'];
							$config['dmods']['modules'][$i][]=$dmods['link'];
							if(isset($dmods['by'])){
								$config['dmods']['modules'][$i][]=$dmods['by'];
							}
							sort($config['dmods']['modules']);
							save_config('dmods');
							$dAmn->say("$from: $args[2] has been successfully added as ID $i.",$c);
						}else
							$dAmn->say("$from: $args[2] has already been added!",$c);
					}else
						$dAmn->say("$from: You must provide a download link to the module to add it.",$c);
				}else
					$dAmn->say("$from: Usage: ".$tt."dmods add <i>module</i>.",$c);
				break;
			case "del":
			case "delete":
				$moo = false;
				foreach($config['dmods']['modules'] as $id => $mod){
					$mock = $mod[0];
					if( strtolower($mock) == strtolower($args[2])){
						$moo = true;
						$ho=$args[2];
						$config['dmods']['modules'][$id]=null;
						unset($config['dmods']['modules'][$id]);
						sort($config['dmods']['modules']);
						save_config('dmods');
					}
				}
				if($moo){
					$dAmn->say("$from: $args[2] was successfully removed from the list!",$c);
				}else 
					$dAmn->say("$from: $args[2] isn't a module stored. Type ".$tt."dmods list to see a list of modules stored.",$c);
				break;		
			case "remove":
				if(!empty($args[2])){
					if(is_numeric($args[2])){
						if(!isset($config['dmods']['modules'][$args[2]])){
							$hh=$config['dmods']['modules'][$args[2]];
							array_splice($config['dmods']['modules'], $args[2],1);
							save_config('dmods');
							$dAmn->say($f ."$hh has been deleted successfully.",$c); 
						}else
							$dAmn->say("$from: There is no module stored under $args[2].",$c);
					}else
						$dAmn->say("$from: You must provide an ID# to use this command.",$c);
				}else
					$dAmn->say("$from: Usage: ".$tt."dmods remove <i>(ID#)</i>. See ".$tt."dmods list for a list of stored modules. To change a link, type ".$tt."dmods change <i>(ID#) (link).",$c);
				break;
			case "change":
				if($args[2] !=""){
					if(!isset($config['dmods']['modules'][$args[2]])){
						$dAmn->say($f ."The ID you provided was invalid. Type '" .$tt."dmods list to see a list of modules along with their ID#s.",$c);
						return;
					}
					if($args[3] !=""){
						$config['dmods']['modules'][$args[2]][1]=$args[3];
						save_config('dmods');$dAmn->say($f ."Download link successfully updated.",$c);
					}else
						$dAmn->say($f ."You need to provide a link to change the current one to.",$c);
				}else
					$dAmn->say($f ."You need to provide a valid ID number along with an updated link to change the module information stored for said ID. Type '" .$config['bot']['trigger']."store logins list' for a list of login IDs and the username associated with that ID.",$c);
				break;
			case "change2":
				if($args[2] !=""){
					if(!isset($config['dmods']['modules'][$args[2]])){
						$dAmn->say($f ."The ID you provided was invalid. Type '" .$tt."dmods list to see a list of modules along with their ID#s.",$c);
					}
					if($args[3] !=""){
						$config['dmods']['modules'][$args[2]][2]=$args[3];
						save_config('dmods');$dAmn->say($f ."Author successfully updated.",$c);
					}else
						$dAmn->say($f ."You need to provide an author to change the current one to.",$c);
				}else
					$dAmn->say($f ."You need to provide a valid ID number along with an updated author to change the module information stored for said ID. Type '" .$config['bot']['trigger']."store logins list' for a list of login IDs and the username associated with that ID.",$c);
					break;
			case "list":
				$say="";
				if(!empty($config['dmods'])){
					if($args[2] == ""){
						$say .="<sup>The Modules you have stored on here are: <br/>";
						foreach($config['dmods']['modules'] as $id => $mod){
							$say .=" ID#$id - {$mod[0]} | ";
						}
						$dAmn->say($say,$c);
					}else
					if($args[2] == "links"){
						$say .="<sup>The Modules you have stored on here are: <br/>";
						foreach($config['dmods']['modules'] as $id => $mod){
							$say .=" ID#$id - {$mod[0]} {$mod[1]} <br> ";
						}
						$dAmn->say($say,$c);
					}else
					if($args[2] == "all"){
						$say .="<sup>The Modules you have stored on here are: <br/>";
						foreach($config['dmods']['modules'] as $id => $mod){
						$say .=" ID#$id - {$mod[0]} {$mod[1]} {$mod[2]} <br> ";
						}
						$dAmn->say($say,$c);
					}
				}else
					$dAmn->say("$from: There aren't any modules stored.",$c);
				break;
			default: 
				$say="";
				if(!empty($config['dmods'])){
					$dAmn->say("<sup>These are the modules for Dante:</sup>",$c);
					foreach($config['dmods']['modules'] as $id => $mod){
						if(!empty($mod[2])){
							$dAmn->say("<sup><b><a href='{$mod[1]}' title='{$mod[0]}'>{$mod[0]}</a></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; by&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :dev{$mod[2]}:</sup>",$c);
						}else
							$dAmn->say("<sup><b><a href='{$mod[1]}' title='{$mod[0]}'>{$mod[0]}</a></b></sup>",$c);
					}
					
				}else
					$dAmn->say("$from: To get started, type ".$tt."$dmods add <i>module link (by)</i> to add a module. Leave by blank if you don't know who the author is.",$c);
				break;
			}break;
}