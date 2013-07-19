<?php
	function testlogin($username, $password){
		global $dAmn, $config;											// Method to get the cookie! Yeah! :D
		$socket = fsockopen("ssl://www.deviantart.com", 443);			// Our first job is to open an SSL connection with our host.
		if($socket === false) {											// If we didn't manage that, we need to exit!
		return array(
			'status' => 2,
			'error' => 'Could not open an internet connection.');
		}
		$POST = '&username='.urlencode($username);						// Fill up the form payload
		$POST.= '&password='.urlencode($password);
		$POST.= '&remember_me=1';
		$response = $dAmn->send_headers(								// And now we send our header and post data and retrieve the response.
			$socket,
			"www.deviantart.com",
			"/users/login",
			"http://www.deviantart.com/users/rockedout",
			$POST
		);
		fclose ($socket);												// Now that we have our data, we can close the socket.
		if(empty($response))											// And now we do the normal stuff, like checking if the response was empty or not.
		return array(
			'status' => 3,
			'error' => 'No response returned from the server.'
		);
		if(stripos($response, 'set-cookie') === false)
		return array(
				'status' => 4,
				'error' => 'No cookie returned.'
			);
		$response=explode("\r\n", $response);							// Grab the cookies from the header
		$cookie_jar = array();
		foreach ($response as $line) {
			if (strpos($line, "Set-Cookie:")!== false) {
				$cookie_jar[] = substr($line, 12, strpos($line, "; ")-12);
			}
		}
		if (($socket = @fsockopen("ssl://www.deviantart.com", 443)) == false){
			 return array(
				'status' => 2,
				'error' => 'Could not open an internet connection.'
			);
		}
		$response = $dAmn->send_headers(								// Using these cookies, we're gonna go to chat.deviantart.com and get
			$socket,													// our authtoken from the dAmn client.
			"chat.deviantart.com",
			"/chat/Botdom",
			"http://chat.deviantart.com",
			null,
			$cookie_jar
		);
		$cookie = null;													// Now search for the authtoken in the response
		if (($pos = strpos($response, "dAmn_Login( ")) !== false) {
			$response = substr($response, $pos+12);
			$cookie = substr($response, strpos($response, "\", ")+4, 32);
		}
		else															// Because errors still happen, we need to make sure we now have an array!
		return array(
			'status' => 4,
			'error' => 'No authtoken found in dAmn client.'
		);
		if(!$cookie) 
		return array(
			'status' => 5,
			'error' => 'Malformed cookie returned.'
		);																// We got a valid cookie!
		return $cookie;
	}
?>	