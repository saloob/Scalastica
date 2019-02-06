<?php

require_once("OAuth.php");

class LinkedIn {
	public $base_url = "http://api.linkedin.com";
	public $secure_base_url = "https://api.linkedin.com";
	public $oauth_callback = "oob";
	public $consumer;
	public $request_token;
	public $access_token;
	public $oauth_verifier;
	public $signature_method;
	public $request_token_path;
	public $access_token_path;
	public $authorize_path;

	function __construct($consumer_key, $consumer_secret, $oauth_callback = NULL)
	{

		if($oauth_callback) {
			$this->oauth_callback = $oauth_callback;
		}

		$this->consumer = new OAuthConsumer($consumer_key, $consumer_secret, $this->oauth_callback);
		$this->signature_method = new OAuthSignatureMethod_HMAC_SHA1();
//		$this->request_token_path = $this->secure_base_url . "/uas/oauth/requestToken";
		$this->request_token_path = $this->secure_base_url . "/uas/oauth/requestToken?scope=r_basicprofile+r_emailaddress+w_share";
# r_contactinfo
# w_messages
# rw_company_admin
# r_fullprofile
# rw_groups
# r_network

		$this->access_token_path = $this->secure_base_url . "/uas/oauth/accessToken";
		$this->authorize_path = $this->secure_base_url . "/uas/oauth/authorize";
	}

	function getRequestToken()
	{
		$consumer = $this->consumer;
		$request = OAuthRequest::from_consumer_and_token($consumer, NULL, "GET", $this->request_token_path);
		$request->set_parameter("oauth_callback", $this->oauth_callback);
		$request->sign_request($this->signature_method, $consumer, NULL);
		$headers = Array();
		$url = $request->to_url();
		$response = $this->httpRequest($url, $headers, "GET");
		parse_str($response, $response_params);
		$this->request_token = new OAuthConsumer($response_params['oauth_token'], $response_params['oauth_token_secret'], 1);
	}

	function generateAuthorizeUrl()
	{
		$consumer = $this->consumer;
		$request_token = $this->request_token;
		return $this->authorize_path . "?oauth_token=" . $request_token->key;
	}

	function getAccessToken($oauth_verifier)
	{
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->request_token, "GET", $this->access_token_path);
		$request->set_parameter("oauth_verifier", $oauth_verifier);
		$request->sign_request($this->signature_method, $this->consumer, $this->request_token);
		$headers = Array();
		$url = $request->to_url();
		$response = $this->httpRequest($url, $headers, "GET");
		parse_str($response, $response_params);
		$this->access_token = new OAuthConsumer($response_params['oauth_token'], $response_params['oauth_token_secret'], 1);
	}

	function getProfile($resource = "~")
	{
		$profile_url = $this->base_url . "/v1/people/" . $resource;
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "GET", $profile_url);
		$request->sign_request($this->signature_method, $this->consumer, $this->access_token);
		$auth_header = $request->to_header("https://api.linkedin.com"); # this is the realm
		# This PHP library doesn't generate the header correctly when a realm is not specified.
		# Make sure there is a space and not a comma after OAuth
		// $auth_header = preg_replace("/Authorization\: OAuth\,/", "Authorization: OAuth ", $auth_header);
		// # Make sure there is a space between OAuth attribute
		// $auth_header = preg_replace('/\"\,/', '", ', $auth_header);

		// $response will now hold the XML document
		$response = $this->httpRequest($profile_url, $auth_header, "GET");
		return $response;
	}

	function setStatus($status)
	{
		$profile_url = $this->base_url . "/v1/people/~";
		$status_url = $this->base_url . "/v1/people/~/current-status";
		echo "Setting status...\n";
		$xml = "<current-status>" . htmlspecialchars($status, ENT_NOQUOTES, "UTF-8") . "</current-status>";
		echo $xml . "\n";
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "PUT", $status_url);
		$request->sign_request($this->signature_method, $this->consumer, $this->access_token);
		$auth_header = $request->to_header("https://api.linkedin.com");

		$response = $this->httpRequest($profile_url, $auth_header, "GET");
		return $response;
	}

	# Parameters should be a query string starting with "?"
	# Example search("?count=10&start=10&company=LinkedIn");
	function search($parameters)
	{
		$search_url = $this->base_url . "/v1/people-search:(people:(id,first-name,last-name,picture-url,site-standard-profile-request,headline),num-results)" . $parameters;
              //  $search_url = $this->base_url . "/v1/people-search:(people:(id,first-name,last-name,picture-url,site-standard-profile-request,headline),num-results)" . $parameters . "&facets=location,industry&facet=location,us:0&facet=industry,4";

		//$search_url = $this->base_url . "/v1/people-search?keywords=facebook";

		echo "Performing search for: " . $parameters . "<br />";
		echo "Search URL: $search_url <br />";
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "GET", $search_url);
		$request->sign_request($this->signature_method, $this->consumer, $this->access_token);
		$auth_header = $request->to_header("https://api.linkedin.com");
                if ($debug) {
                   echo $request->get_signature_base_string() . "\n";
                   echo $auth_header . "\n";
                   }
		$response = $this->httpRequest($search_url, $auth_header, "GET");
		return $response;
	}

	function get_connections($parameters)
	{

/*
http://api.linkedin.com/v1/people/~/connections
http://api.linkedin.com/v1/people/id=12345/connections

http://api.linkedin.com/v1/people/~/connections:(headline,first-name,last-name)
http://api.linkedin.com/v1/people/url=http%3A%2F%2Fwww.linkedin.com%2Fin%2Flbeebe/connections
*/
                $type = $parameters[0];

                switch ($type){

                 case 'by-id':
                   $id = $parameters[1];
                   $connections_url = $this->base_url . "/v1/people/id=".$id."/connections";
                 break;
                 case 'all':
                   $id = $parameters[1];
                   $connections_url = $this->base_url . "/v1/people/~/connections:(id,first-name,last-name,email-address,headline,picture-url)";
                 break;

                } // end switch

		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "GET", $connections_url);
		$request->sign_request($this->signature_method, $this->consumer, $this->access_token);
		$auth_header = $request->to_header("https://api.linkedin.com");
                if ($debug) {
                   echo $request->get_signature_base_string() . "\n";
                   echo $auth_header . "\n";
                   }
		$response = $this->httpRequest($connections_url, $auth_header, "GET");
		return $response;
	}

        # End Get Connections
        #########################
        # Message by ID

	function sendMessageById($id, $ccUser=FALSE, $subject='', $message='') {

      		$messageUrl   =   $this->base_url . "/v1/people/~/mailbox";
 
    		$subject      =   htmlspecialchars($subject, ENT_NOQUOTES, "UTF-8") ;
		$message      =   htmlspecialchars($message, ENT_NOQUOTES, "UTF-8") ;
 
		if ($ccUser){

		   $CCToUser   =   "<recipient>
                             <person path='/people/~'/>
                           </recipient>";
      		  } else {

		  $CCToUser   =   '';

		  }
 
		$xml = "<mailbox-item>
                <recipients>
                    $CCToUser
                    <recipient>
                        <person path='/people/$id' />
                    </recipient>
                </recipients>
                <subject>$subject</subject>
                <body>$message</body>
              </mailbox-item>";
 
		//echo $xml . "\n";
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "POST", $messageUrl);
		$request->sign_request($this->signature_method, $this->consumer, $this->access_token);
		$auth_header = $request->to_header("https://api.linkedin.com");
		if ($debug) {
	           echo $auth_header . "\n";
		   }

		$response = $this->httpRequest($messageUrl, $auth_header, "POST", $xml);
		return $response;

	} // end function

        # End Message
        #########################
        # Curlit

	function httpRequest($url, $auth_header, $method, $body = NULL)
	{
		if (!$method) {
			$method = "GET";
		};

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header)); // Set the headers.

		if ($body) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header, "Content-Type: text/xml;charset=utf-8"));
		}

		$data = curl_exec($curl);
		curl_close($curl);
		return $data;
	}

        # End Curlit
        #########################

}