<?php 

namespace Jump24\FitBit;

class FitBitProfile  extends FitBitBaseApi{

 	public function __construct($consumer_key, $consumer_secret, $access_token, $access_secret)
 	{
 		parent::__construct($consumer_key, $consumer_secret, $access_token, $access_secret);
 	}

 	public function getProfileInfo($user_id = '-')
 	{
 		$profile = $this->get('user/' . $user_id . '/profile.json');

 		var_dump($profile);
 		die();
 	}

}