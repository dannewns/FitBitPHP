<?php

use Jump24\FitBit\Traits\ValidationTrait;
use Carbon\Carbon;

class ValidationTraitTest extends PHPUnit_Framework_TestCase {

	use ValidationTrait;

    public function setUp() 
    {

    }
    
    public function tearDown() 
    {

    }

    /**
     * tests the is date valid method with an incorrect string which should throw an exception
     * @return [type] [description]
     */
    public function testDateValidWithInvalidStringData()
    {

        $this->setExpectedException('Jump24\FitBit\Exception\InvalidDateFormatException');

        $result = $this->isDateValid('asdsad');

    }

    /**
     * tests the is date in the future method and making sure it handles incorrect date formates
     * @return [type] [description]
     */
    public function testDateValidWithValidDate()
    {

        $result = $this->isDateValid('2014-01-01');

        $this->assertTrue($result);

    }
  
    /**
     * tests that the validation traits is the date in the future method returns the correct response when a date is in the future
     * @return [type] [description]
     */
    public function testStartDateIsInFutureValidation()
    {
    	$date = Carbon::now()->addDays(1);

    	$result = $this->isDateInTheFuture($date->format('Y-m-d'));
   
	    $this->assertTrue($result);
   
    }

    /**
     * tests that the validation trais is the date in the future method returns the correct repsonse when a date is in the past
     * @return [type] [description]
     */
    public function testStartDateIsInThePastValidation()
    {
    	$date = Carbon::now()->subDays(2);

    	$result = $this->isDateInTheFuture($date->format('Y-m-d'));

    	$this->assertFalse($result);
   
    }

    

    /**
     * tests the is end date after start date function with correct dates
     * @return [type] [description]
     */
    public function testIsEndDateAfterStartDate()
    {
        $start_date = Carbon::now()->subDays(5);

        $end_date = Carbon::now();

        $result = $this->isEndDateAfterStartDate($start_date->format('Y-m-d'), $end_date->format('Y-m-d'));

        $this->assertTrue($result);

    }

    /**
     * tests that the validation returns false when the end date is before the start date
     * @return [type] [description]
     */
    public function testIsEndDateAfterStartDateWithEndDateBeforeStart()
    {
        $start_date = Carbon::now();

        $end_date = Carbon::now()->subDays(5);

        $result = $this->isEndDateAfterStartDate($start_date->format('Y-m-d'), $end_date->format('Y-m-d'));

        $this->assertFalse($result);
    
    }
 
}
