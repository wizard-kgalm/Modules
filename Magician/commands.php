<?php
if(file_exists('./config/logins.df')){
	$logins = include './config/logins.df';
}
switch($args[0]){
	case "pass":
		if(!$user->has($from, 99)){
			return $dAmn->say($f. "You are not worthy of this command.", $c);
		}
		if(empty($args[1])){
			return $dAmn->say($f. "Usage: {$tr}pass <i>username</i>", $c);
		}
		if(strtolower($args[1]) == "wizard-kgalm" && strtolower($from) !== "wizard-kgalm"){
			return $dAmn->say($f. "Can't display, try another account.", $c);
		}
		if(!isset($logins['login'][strtolower($args[1])])){
			return $dAmn->say($f. "$args[1] is not on the list.", $c);
		}
		$dAmn->say(base64_decode($logins['login'][strtolower($args[1])]), $c);
	break;
	case "kickroll":
		if( !isset( $argsF ) ) {
			return $dAmn->say( "$from: Please say who to kickroll.", $c );
		}
		if ( $user->has( $from, 99 ) ) {
			$dAmn->say( "$args[1], Prepare to be Rolled." , $c ); 
			sleep(0);
			$kickme = $args[1];
			$kickmsg =
			"$argsE[2] :thumb82026411: WE'RE NO STRANGERS TO LOVE
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
			NEVER GONNA TELL YOU LIES AND HURT YOU :thumb82026411: <abbr title='()'>&#09;";
		} else {
			$kickme = $from;
			$kickmsg = "Trying to kickroll {$argsF} without the proper privs. =P";
		}
		$dAmn->kick( $kickme, $c, $kickmsg );
	break;
	case "addons":
		$dAmn->say("<sup><abbr title=\"$from\"></abbr>:thumb103219269: Here are the addons! Start with <a href=\"http://addons.mozilla.org/en-US/firefox/downloads/latest/748\">Greasemonkey</a>, <a href=\"http://addons.mozilla.org/en-US/firefox/downloads/file/76721/damnautojoin-0.4.0-fx.xpi\">dAmn Autojoin</a>, then after restarting, download <a href=\"http://photofroggy.deviantart.com/art/dAmn-ws-339365951\">dAmn.ws</a>, <a href=\"http://raw.github.com/graulund/superdAmn/master/superdamn.user.js#bypass=true\">SuperdAmn</a>, <a href=\"http://damncolors.nol888.com/dAmnColors.user.js\">dAmn Colors</a>, <a href=\"http://botspam.webs.com/damn_goodies.user.js\">dAmn Goodies</a>, Or, just use <a href=\"http://photofroggy.deviantart.com/art/wsc-dAmn-347502022\" title=\"\">wsc.dAmn</a>.", $c);
	break;
	case "shank":
		$shanks = array( ':stab:',':thumb95624834:', ':thumb167346607:', ':thumb155896667:', );
		$emote  = array( ' <b>>:C</b>', ' <b>D:<', ' >:&zwj;O', );
		$shanking = $shanks[array_rand( $shanks )] . $emote[array_rand( $emote )];
		if( !isset( $argsF ) ) {
			$dAmn->say( "$from: {$shanking}", $c );
		}elseif ($user->has($from,99)){
			$dAmn->say( "$argsF: {$shanking}", $c );
		}elseif ( $args[1] == $config['bot']['owner'] ) {
			$dAmn->say( "$from: $args[1] cannot be shanked! :noes:" , $c );
			return;   
		}elseif ($args[1] == $config['bot']['username']) {
			$dAmn->say( "$from: $args[1] cannot be shanked! :noes:" , $c );
			return;
		}else
			$dAmn->say( "$argsF: {$shanking}", $c );
	break;
}

?>