<?php
	function testlogin($username, $password){ 
		global $dAmn, $config;
		
		// Method to get the cookie! Yeah! :D       
		// Our first job is to open an SSL connection with our host.
		$socket = fsockopen("ssl://www.deviantart.com", 443);
		// If we didn't manage that, we need to exit!
		if($socket === false) {
		return array(
				'status' => 2,
				'error' => 'Could not open an internet connection.');
		}
		// Fill up the form payload
		$POST = '&username='.urlencode($username);
		$POST.= '&password='.urlencode($password);
		$POST.= '&remember_me=1';
		// And now we send our header and post data and retrieve the response.
		$response = $dAmn->send_headers(
			$socket,
			"www.deviantart.com",
			"/users/login",
			"http://www.deviantart.com/users/rockedout",
			$POST
		);
		// Now that we have our data, we can close the socket.
		fclose ($socket);
		//And now we do the normal stuff, like checking if the response was empty or not.
		if(empty($response))
		return array(
				'status' => 3,
				'error' => 'No response returned from the server.'
		);
		if(stripos($response, 'set-cookie') === false)
		return array(
				'status' => 4,
				'error' => 'No cookie returned.'
			);
		// Grab the cookies from the header
		$response=explode("\r\n", $response);
		$cookie_jar = array();
		foreach ($response as $line)
			if (strpos($line, "Set-Cookie:")!== false)
				$cookie_jar[] = substr($line, 12, strpos($line, "; ")-12);

		// Using these cookies, we're gonna go to chat.deviantart.com and get
		// our authtoken from the dAmn client.
		if (($socket = @fsockopen("ssl://www.deviantart.com", 443)) == false)
			 return array(
				'status' => 2,
				'error' => 'Could not open an internet connection.');

		$response = $dAmn->send_headers(
			$socket,
			"chat.deviantart.com",
			"/chat/Botdom",
			"http://chat.deviantart.com",
			null,
			$cookie_jar
		);
		// Now search for the authtoken in the response
		$cookie = null;
		if (($pos = strpos($response, "dAmn_Login( ")) !== false)
		{
			$response = substr($response, $pos+12);
			$cookie = substr($response, strpos($response, "\", ")+4, 32);
		}
		else //$dAmn->say($response ,"#randwewt");
		return array(
			'status' => 4,
			'error' => 'No authtoken found in dAmn client.'
		);
						  
		// Because errors still happen, we need to make sure we now have an array!
		if(!$cookie)
		return array(
				'status' => 5,
				'error' => 'Malformed cookie returned.'
		);
		// We got a valid cookie!
		return $cookie;
	}
		

?>	