<?php 

namespace Jump24\FitBit;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class FitBitSubscriptions  extends FitBitBaseApi{

	protected $request_token_url 	= 'https://api.fitbit.com/oauth/request_token';
  
  	protected $authorize_url 		= 'https://api.fitbit.com/oauth/authorise';
  
  	protected $access_token_url 	= 'https://api.fitbit.com/oauth/access_token';

  	protected $auth;

 	public function __construct($consumer_key, $consumer_secret, $call_back_url)
 	{
 		
 	}

 
}