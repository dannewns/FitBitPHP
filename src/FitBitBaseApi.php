<?php 

namespace Jump24\FitBit;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Jump24\FitBit\Exception\UnauthorizedAPIAccessException;
use Jump24\FitBit\Exception\BadAPIRequestException;

class FitBitBaseApi  {

  	protected $auth;

  	protected $route = 'https://api.fitbit.com/';

  	protected $version = '1/';

  	protected $client;

  	private $mock = NULL;

  	private $error = NULL;

  	private $status_code = NULL;

  	private $called_url = NULL;

  	private $reason = NULL;

  	protected $consumer_key;

  	protected $consumer_secret;

  	protected $access_token;

  	protected $access_token_secret;

  	protected $dump_data = false;


 	public function __construct($consumer_key, $consumer_secret)
 	{

 		$this->consumer_key = $consumer_key;

 		$this->consumer_secret = $consumer_secret;

 	
 	}

 	/**
 	 * sets up the access token for the user who is going to be making the request
 	 * @param [type] $access_token        [description]
 	 * @param [type] $access_token_secret [description]
 	 */
 	public function setAccessCredentials($access_token, $access_token_secret)
 	{
 		$this->access_token = $access_token;

 		$this->access_token_secret = $access_token_secret;
 	}

 	/**
 	 * sets up the mock data for the get requests to allow for testing
 	 * @param  GuzzleHttp\Subscriber\Mock $mock_data the Mock object to pass into the system for testing
 	 * @return [type]            [description]
 	 */
 	public function setupMockDataForRequest(\GuzzleHttp\Subscriber\Mock $mock_data)
 	{
 		$this->mock = $mock_data;
 	}

 	/**
 	 * returns the error message on the system
 	 * @return [type] [description]
 	 */
 	public function getErrorMessage()
 	{
 		return $this->error;
 	}

 	/**
 	 * sets up the start and end date variables for the class to use and converts them to carbon format
 	 */
 	protected function convertToCarbon($date)
 	{

 		if (is_null($date)) {

 			return Carbon::now()->setTimezone('UTC');

 		} else 

 			return Carbon::createFromFormat('Y-m-d', $date)->setTimezone('UTC');

 	}

 	public function dumpCallData()
 	{
 		$this->dump_data = true;
 	}


 	/**
 	 * wrapper method to call the api by just suppling a api endpoint url 
 	 * @param  string 	$url the API endpoint to be called
 	 * @param  array 	$query_parameters the query string parameters to pass into the call
 	 * @return 			the result from the call be it the details for a cube or NULL when nothing found
 	 */
 	protected function get($url, $query_parameters = array())
 	{

 		try {	

 			$this->setupClient();

		    $request = $this->client->createRequest('GET', $url);

		    if (!empty($query_parameters)) {

		    	$query = $request->getQuery();

		    	foreach ($query_parameters as $field => $value) {

		    		$query->set($field, $value);

		    	}

		    }

		    $response = $this->client->send($request);

		    if ($response->getStatusCode() != 200)  {

		    	return NULL;
		    
		    }

		    if ($this->dump_data) {

		    	$this->dump_data = false;

		    	$body = $response->getBody();

		    	echo $body;

		    	die();
		    
		    }

		   	$body = $response->json();

		  	return $body;
		
		} catch(ServerException $e) {

			$this->setResponseValues($e->getResponse());

			$this->error = $e->getMessage();

			return NULL;

		} catch(ClientException $e) {

			$message = $this->getErrorMessageFromResponseBody($e->getResponse()->json());

			switch($e->getCode()) {

				case 400:
					
					throw new BadAPIRequestException($message, $e->getCode());
				
				break;
				case 401:
				
					throw new UnauthorizedAPIAccessException($message, $e->getCode());
				
				break;
			
			}


		} catch (RequestException $e) {

			$this->error = $e->getMessage();
			
			return NULL;
		
		}

 	}

 	/**
 	 * sets up the error responses for the exceptions handled
 	 * @param GuzzleHttp\Message\Response $response [description]
 	 */
 	private function setResponseValues(\GuzzleHttp\Message\Response $response)
 	{

		$this->status_code = $response->getStatusCode();

		$this->reason = $response->getReasonPhrase();

		$this->called_url = $response->getEffectiveUrl();
 	
 	}

 	/**
 	 * retrieves the error message from the response
 	 * @param  [type] $body [description]
 	 * @return [type]       [description]
 	 */
 	private function getErrorMessageFromResponseBody($body)
 	{

		$message = false;

		if (array_key_exists('errors', $body)) {

			$error = array_shift($body['errors']);

			$message = $error['message'];

		}

		return $message;
 	}

 	/**
 	 * sets up the guzzle client ready to use the api
 	 * @return [type] [description]
 	 */
 	private function setupClient()
 	{
 		
 		$oauth = new Oauth1([
			    'consumer_key'    => $this->consumer_key,
			    'consumer_secret' => $this->consumer_secret,
			    'token'           => $this->access_token,
			    'token_secret'    => $this->access_token_secret
			]);

 		$this->client = new Client( array(	'base_url' => $this->route . $this->version, 
 											'defaults' => array('auth' => 'oauth') ) );


 		if (!is_null($this->mock)) {

 			$this->client->getEmitter()->attach($this->mock);
 			
 		} 

		$this->client->getEmitter()->attach($oauth);
 	
 	}

}