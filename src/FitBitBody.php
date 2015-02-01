<?php 

namespace Jump24\FitBit;

use Jump24\FitBit\Traits\ValidationTrait;

class FitBitBody  extends FitBitBaseApi{

	use ValidationTrait;

 	public function __construct($consumer_key, $consumer_secret)
 	{
 		parent::__construct($consumer_key, $consumer_secret);
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

 	
	#GET /<api-version>/user/-/body/log/weight/date/<date>.<response-format> 
	#GET /<api-version>/user/-/body/log/weight/date/<base-date>/<period>.<response-format>
	#GET /<api-version>/user/-/body/log/weight/date/<base-date>/<end-date>.<response-format>

 	/**
 	 * returns the body weight for the current authorized user
 	 * @param  string $date the date to get weights for
 	 * @return [type]       [description]
 	 */
 	public function getBodyWeightForDate($date)
 	{

 		if (!$this->isDateValid($date)) return NULL;

 		if ($this->isDateInTheFuture($date)) return NULL;

 		$date =  $this->convertToCarbon($date);

 		$call_url = 'user/-/body/log/weight/date/' . $date->format('Y-m-d') . '.json';

 		$body_weight = $this->get($call_url);

 		if (!is_null($body_weight)) {

 			return $body_weight;
 		
 		} 

 		return NULL;

 	}

 	/**
 	 * returns the body weight readings for a date range with start and end date passed in
 	 * @param  [type] $start_date [description]
 	 * @param  [type] $end_date   [description]
 	 * @return [type]             [description]
 	 */
 	public function getBodyWeightBetweenDateRange($start_date, $end_date)
 	{
 		if (!$this->isDateValid($start_date) || !$this->isDateValid($end_date)) return NULL;

 		if ($this->isDateInTheFuture($start_date) || $this->isDateInTheFuture($end_date)) return NULL;

 		if (!$this->isEndDateAfterStartDate($start_date, $end_date)) return NULL;
 		
 		$start_date =  $this->convertToCarbon($start_date);

 		$end_date = $this->convertToCarbon($end_date);

 		$call_url = 'user/-/body/log/weight/date/' . $start_date->format('Y-m-d') . '/' . $end_date->format('Y-m-d') . '.json';

 		$body_weights = $this->get($call_url);

 		if (!is_null($body_weights)) {

 			return $body_weights;
 		
 		} 

 		return NULL;

 	}

 	public function getBodyWeightForPeriod($date, $period = '1w')
 	{

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