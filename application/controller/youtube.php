<?php

class Youtube extends CI_Controller {

	function request_token()
	{
		
		$this->config->load('youtubeoauth');
		$this->config->set_item('youtube_oauth_token', NULL);
		$this->config->set_item('youtube_oauth_token_secret', NULL);

		$connection = new youtubeoauth();

		// Get temporary credentials
		$request_token = $connection->getRequestToken();
	
		$token = $request_token['oauth_token'];
		
		$newdata = array(
           'youtube_oauth_token'	=> $request_token['oauth_token'],
		   'youtube_oauth_token_secret'	=> $request_token['oauth_token_secret']   
        );

		$this->session->set_userdata($newdata);
		
		switch ($connection->http_code) {
		  case 200:
		    // Build authorize URL and redirect user to Youtube.
		    $url = $connection->getAuthorizeURL($token,YOUTUBE_OAUTH_CALLBACK);
		    
		    redirect($url);
		    break;
		  default:
		    // Show notification if something went wrong.
		    echo 'Could not connect to Youtube. Refresh the page or try again later.';
		}
		

	}
    
	function access_token()
	{

		/* If the oauth_token is old redirect to the connect page. */
		if (isset($_REQUEST['oauth_token']) && $this->session->userdata('youtube_oauth_token') !== $_REQUEST['oauth_token']) {
		
		  $this->session->set_userdata('youtube_oauth_status', 'oldtoken');
		  redirect('youtube/clear_sessions');
		 
		}
		
		$this->config->load('youtubeoauth');
		$this->config->set_item('youtube_oauth_token', $this->session->userdata('youtube_oauth_token'));
		$this->config->set_item('youtube_oauth_token_secret', $this->session->userdata('youtube_oauth_token_secret'));
		
		/* Create YoutubeoAuth object with app key/secret and token key/secret from default phase */
		$connection = new YoutubeOAuth();
		
		/* Request access tokens from youtube */
		$access_token = $connection->getAccessToken($_GET['oauth_token']);

		//echo $_GET['oauth_verifier'];
		/* If HTTP response is 200 continue otherwise send to connect page to retry */
		if (200 == $connection->http_code) {
		  /* The user has been verified and the access tokens can be saved for future use */
		  $this->session->set_userdata('youtube_status', 'verified');
		 
		  echo "YOUR OAUTH_TOKEN IS: ".$access_token["oauth_token"];
		  echo "<br />";
		  echo "YOUR OAUTH_TOKEN_SECRET IS: ".$access_token["oauth_token_secret"];
		  
		} else {
		  redirect('youtube/clear_sessions');
		}
		
	}  
	
	
	function clear_sessions() {
	
		$this->session->sess_destroy();
		redirect('youtube/request_token');
	
	}
	function logoff() {
	
		$this->session->sess_destroy();
		redirect('');
	
	}
}