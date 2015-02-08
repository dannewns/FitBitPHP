<?php

namespace Jump24\FitBit\Traits;

use Carbon\Carbon;
use Jump24\FitBit\Exception\InvalidDateFormatException;

trait ValidationTrait {

	public $validation_error = NULL;

	/**
	 * checks to see if the date is a valid format
	 * @param  [type]  $date [description]
	 * @return boolean       [description]
	 */
	public function isDateValid($date)
	{
		try {

			$date = Carbon::createFromFormat('Y-m-d', $date);

			return isset($date);
		
		} catch (\InvalidArgumentException $e) {

			$this->validation_error = 'The date you have supplied is in a invalid format';

			return false;

		}

	}

	/**
	 * validates to check if the date being passed in is in the future or not
	 * @param  string  $date the date to validate
	 * @return boolean       the result of the future check
	 */
	public function isDateInTheFuture($date)
	{
	
		$date = Carbon::createFromFormat('Y-m-d', $date);

		if ($date->isFuture()) {

			return true;
		
		} 

		return false;
	
	}

	/**
	 * validates that the start date is actually before the end date
	 * @param  string  $start_date the start date being used 
	 * @param  string  $end_date   the end date to evaluate against
	 * @return boolean             the result
	 */
	public function isEndDateAfterStartDate($start_date, $end_date)
	{

		$start_date = Carbon::createFromFormat('Y-m-d', $start_date);

		$end_date = Carbon::createFromFormat('Y-m-d', $end_date);

		$difference = $start_date->diffInDays($end_date, false);
    
 		if ($difference  >= 0)

 			return true;

 		else {

 			return false;
 		}
 		
	}

	/**
	 * validates that the period past to it is valid
	 * @param  [type]  $period [description]
	 * @return boolean         [description]
	 */
	public function isValidPeriodFormat($period)
	{
		
		if (in_array($period, ['1d', '7d', '30d', '1w', '1m'])) return true;

		else {

			$this->validation_error = 'The period you have supplied is not valid';
		
			return false;

		}

	}

}