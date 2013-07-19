<?php
switch($args[0]){
	
	case "kickroll":
		if(!isset($argsF)){
			$dAmn->say($f . "Please say who to kickroll.", $c);
		}else
		if ($user->has($from,99)){
			$dAmn->say("$args[1], Prepare to be Rolled." , $c); 
			sleep(0);
			$dAmn->kick($args[1], $c, "$argsE[2] :thumb82026411: WE'RE NO STRANGERS TO LOVE
YOU KNOW THE RULES, AND SO DO I
A FULL COMMITMENT'S WHAT I'M THINKING OF
YOU WOULDN'T GET THAT FROM ANY OTHER GUY
I JUST WANT TO TELL YOU HOW I'M FEELING
GOTTA MAKE YOU UNDERSTAND
NEVER GONNA GIVE YOU UP
NEVER GONNA LET YOU DOWN
NEVER GONNA RUN AROUND AND DESERT YOU
NEVER GONNA MAKE YOU CRY
NEVER GONNA SAY GOODBYE
NEVER GONNA TELL YOU LIES AND HURT YOU :thumb82026411: <abbr title='()'>&#09;");
		}else
			$dAmn->kick($from,$c, "Trying to kickroll $argsF without the proper privs. =P");
		break;

	case "addons":
		$dAmn->say("<sup><abbr title=\"$from\"></abbr>:thumb103219269: Here are the addons! Start with <a href=\"http://addons.mozilla.org/en-US/firefox/downloads/latest/748\">Greasemonkey</a>, <a href=\"http://addons.mozilla.org/en-US/firefox/downloads/file/76721/damnautojoin-0.4.0-fx.xpi\">dAmn Autojoin</a>, then after restarting, download <a href=\"http://temple.24bps.com/superdamn/superdamn.user.js\">SuperdAmn</a>, <a href=\"http://damncolors.nol888.com/dAmnColors.user.js\">dAmn Colors</a>, <a href=\"http://botspam.webs.com/damn_goodies.user.js\">dAmn Goodies</a>, and <a href=\"http://userstyles.org/styles/userjs/16505/dA%20Message%20Network%20-%20Sexify%20dAmn.user.js\">Sexify dAmn</a>, <a href=\"http://temple.24bps.com/public/damntcf.user.js\" title=\"\">Tabcolor fix</a>, <a href=\"http://temple.24bps.com/public/tinydamn.user.js\" title=\"\">TinydAmn</a>, <a href=\"http://userscripts.org/scripts/source/32307.user.js\" title=\"\">Word breaker</a>.", $c);
		break;
	case "shank":
		$shanks = array(':stab: <b> >:C </b>',':stab: <b>D:< </b>',':thumb95624834:<b> >:C </b>',':thumb95624834: <b> D:< </b>',);
		$shanking = $shanks[array_rand($shanks)];
		if(!isset($argsF)){
			$dAmn->say("$from: ". $shanking, $c);
		}else
		if ($user->has($from,99)){
			$dAmn->say("$argsF: ". $shanking, $c);
		}else
		if ($args[1] == $config['bot']['owner']) {
			$dAmn->say($f . "$args[1] cannot be shanked! :noes:" , $c);
			return;   
		}else
		if ($args[1] == $config['bot']['username']) {
			$dAmn->say($f . "$args[1] cannot be shanked! :noes:" , $c);
			return;
		}else
		$dAmn->say("$argsF: " .$shanking, $c);
		break;
}

?>