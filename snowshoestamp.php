<?php
/*
Plugin Name: SnowShoeStamp WordPres
Description: Receives SnowShoe stamp data by creating an API endpoint at /api/stamp and submits it to the SnowShoe API for authentication.
Version: 0.1.0
Author: SnowShoe, RasPhilCo
Author URL: http://snowshoestamp.com

Plugin adapted from http://coderrr.com
*/

include(plugin_dir_path( __FILE__ ) . 'inc/SSSApiClient.php');

class SSSPlugin{
	/** Hook WordPress
	*	@return void
	*/
	public function __construct(){
		add_action('init', array($this, 'add_endpoint'), 0);
		add_filter('query_vars', array($this, 'add_query_vars'), 0);
		add_action('parse_request', array($this, 'sniff_requests'), 0);
	}

	/** Add public query vars
	*	@param array $vars List of current public query vars
	*	@return array $vars
	*/
	public function add_query_vars($vars){
		$vars[] = '__api';
		$vars[] = 'stamp';
		$vars[] = 'data';
		return $vars;
	}

	/** Add API Endpoint
	*	This is where the magic happens - brush up on your regex skillz
	*	@return void
	*/
	public function add_endpoint(){
		add_rewrite_rule('^api/stamp','index.php?__api=1&stamp=1&data=$matches[1]','top');
	}

	/**	Sniff Requests
	*	This is where we hijack all API requests
	*	@return die if API request
	*/
	public function sniff_requests(){
		global $wp;
		if(isset($wp->query_vars['__api'])){
			$this->handle_request();
			exit;
		}
	}

	/** Handle Requests
	*	This is where we send off for an intense pug bomb package
	*	@return void
	*/
	protected function handle_request(){
		global $wp;
		$stamp = $wp->query_vars['data'];

		if(!$stamp)
			$this->send_response('HTTP/1.0 400 Bad request', array(error => "Bad request, no stamp provided"));

		$app_key = "key";
		$app_secret = "secret";
		$client= new SSSApiClient($app_key, $app_secret);
		$JSONResponse=$client->processData($stamp);
		$this->send_response(_, json_decode($JSONResponse));
	}

	/** Response Handler
	*	This sends a JSON response to the browser
	*/
	protected function send_response($header='', $response){
		if($header)
			header($header);
			header('content-type: application/json; charset=utf-8');
				echo json_encode($response)."\n";
			exit;

		header('content-type: application/json; charset=utf-8');
		echo json_encode($response)."\n";
		exit;
	}
};

new SSSPlugin;
