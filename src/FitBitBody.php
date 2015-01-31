<?php 

namespace Jump24\FitBit;

class FitBitBody  extends FitBitBaseApi{

 	public function __construct($consumer_key, $consumer_secret, $access_token, $access_secret)
 	{
 		parent::__construct($consumer_key, $consumer_secret, $access_token, $access_secret);
 	}

 	public function getBodyMeasurements($user_id = '-', $date)
 	{

 		$date = $this->convertToCarbon($date);
 		
 		$profile = $this->get('user/' . $user_id . '/body/date/' . $date->format('Y-m-d') . '.json');

 		var_dump($profile);
 		die();
 	}

 	public function getBodyWeight($user_id = '-', $date )
 	{

 		$date= $this->convertToCarbon($date);

 		$body_weight = $this->get('user/' . $user_id . '/body/date/' . $date->format('Y-m-d'));

 		var_dump($body_weight);
 		die();

 	}


 	public function getBodyFat()
 	{

 	}

 	public function getBodyWeightGoal()
 	{

 	}


 	public function getBodyFatGoal()
 	{

 	}

}