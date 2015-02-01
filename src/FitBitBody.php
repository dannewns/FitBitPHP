<?php 

namespace Jump24\FitBit;

use Jump24\FitBit\Traits\ValidationTrait;

class FitBitBody  extends FitBitBaseApi{

	use ValidationTrait;

 	public function __construct($consumer_key, $consumer_secret, $access_token, $access_secret)
 	{
 		parent::__construct($consumer_key, $consumer_secret, $access_token, $access_secret);
 	}

 	/**
 	 * returns the body measurements for a user on a particular day, you can either use the current authenticated user or pass in a user id
 	 * @param  [type] $date    [description]
 	 * @param  string $user_id [description]
 	 * @return [type]          [description]
 	 */
 	public function getBodyMeasurements($date, $user_id = '-')
 	{

 		if ($this->isDateValid($date)) {

	 		if ($result = $this->isDateInTheFuture($date)) return NULL;

	 		$date = $this->convertToCarbon($date);
	 		
	 		$body_measurement = $this->get('user/' . $user_id . '/body/date/' . $date->format('Y-m-d') . '.json');

	 		if (!is_null($body_measurement)) {

	 			return $body_measurement;
	 		
	 		} 

	 	}

	 	return NULL;

 	}

 	public function getBodyWeightForDate($date, $user_id = '-')
 	{
 		if ($this->isDateInTheFuture($date)) return NULL;

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

 	public function getBodyWeightBetweenDateRange($start_date, $end_date = null, $user_id = '-')
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