<?php 

namespace Jump24\FitBit;

use Jump24\FitBit\Traits\ValidationTrait;

class FitBitBody  extends FitBitBaseApi{

	use ValidationTrait;

 	public function __construct($consumer_key, $consumer_secret, $access_token, $access_secret)
 	{
 		parent::__construct($consumer_key, $consumer_secret, $access_token, $access_secret);
 	}

 	public function getBodyMeasurements($user_id = '-', $date)
 	{

 		if ($this->isDateValid($date)) {

	 		if ($result = $this->isDateInTheFuture($date)) return NULL;

	 		$date = $this->convertToCarbon($date);
	 		
	 		$profile = $this->get('user/' . $user_id . '/body/date/' . $date->format('Y-m-d') . '.json');

	 		if (!is_null($profile)) {

	 			return $profile;
	 		
	 		} 

	 	}

	 	return NULL;

 	}

 	public function getBodyWeightBetweenDateRange($user_id = '-', $start_date, $end_date = null)
 	{

 		if ($this->isDateInTheFuture($start_date)) return NULL;

 		if (!is_null($end_date) && $this->isDateInTheFuture($end_date)) return NULL;

 		if (!is_null($end_date) && $this->isEndDateAfterStartDate($start_date, $end_date)) return NULL;

 		$start_date =  $this->convertToCarbon($start_date);

 		$call_url = 'user/' . $user_id . '/body/log/weight/date/' . $start_date->format('Y-m-d');

 		if (!is_null($end_date)) {

 			$end_date = $this->convertToCarbon($end_date);

 			$call_url .= '/';
 	
 		}

 		//$urll

 		return $this->get();

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