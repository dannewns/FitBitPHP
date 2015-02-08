<?php

use Jump24\FitBit\FitBitBody;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use Carbon\Carbon as Carbon;

class FitBitBodyTest extends PHPUnit_Framework_TestCase {


    public function setUp() 
    {

    }
    
    public function tearDown() 
    {

    }

    /**
     * tests the get body measurement function with correct data
     * @return [type] [description]
     */
    public function testGetBodyMeasurements()
    {

    	$mock_response =  new Response(200);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/body_measurement.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$fitbit_body = new FitBitBody('tester1', 'tester2');

      	$fitbit_body->setAccessCredentials('token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

        $date = Carbon::now();

      	$body = $fitbit_body->getBodyMeasurements($date->format('Y-m-d'));

      	$this->assertArrayHasKey('body', $body);
    
    }

    /**
     * testing getBodyMeasurement using a date in the future
     * @return [type] [description]
     */
    public function testGetBodyMeasurementsWithDateInFuture()
    {

    	$mock_response =  new Response(200);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/body_measurement.json', 'r+'));

      $mock_response->setBody($mockResponseBody);
  
      $mock = new Mock([ $mock_response ]);
      
      $fitbit_body = new FitBitBody('tester1', 'tester2');
      
      $fitbit_body->setAccessCredentials('token_tester', 'secret_tester');
      
      $fitbit_body->setupMockDataForRequest($mock);
      
      $date = Carbon::now()->addDays(7);

      $body = $fitbit_body->getBodyMeasurements($date->format('Y-m-d'));

   		$this->assertNull($body);
    
    }

    /**
     * testing getBodyMeasurement using a invalid date format
     * @return [type] [description]
     */
    public function testGetBodyMeasurementsWithInvalidDateFormat()
    {

    	$mock_response =  new Response(200);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/body_measurement.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$fitbit_body = new FitBitBody('tester1', 'tester2', 'token_tester');

      	$fitbit_body->setAccessCredentials('token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

      	$body = $fitbit_body->getBodyMeasurements('asdasda');

        $this->assertNull($body);

    
    }

    /**
     * tests to see if the correct exception is thrown when a invalid user id is thrown in
     * @return [type] [description]
     */
    public function testGetBodyMeasurementsWithInvalidUserId()
    {
    	$mock_response =  new Response(400);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/invalid_user_id_body_measurement.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$fitbit_body = new FitBitBody('tester1', 'tester2');

      	$fitbit_body->setAccessCredentials('token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

      	$this->setExpectedException('Jump24\FitBit\Exception\BadAPIRequestException');

      	$body = $fitbit_body->getBodyMeasurements('2014-01-28', 'asadasdas');

    }

    /**
     * tests to see if the correct exception is thrown when a invalid user id is thrown in
     * @return [type] [description]
     */
    public function testGetBodyMeasurementsWithAuthorisedUserId()
    {
    	$mock_response =  new Response(200);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/valid_user_body_measurement.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$fitbit_body = new FitBitBody('tester1', 'tester2');

      	$fitbit_body->setAccessCredentials('token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

         $date = Carbon::now()->subDay();

      	$body = $fitbit_body->getBodyMeasurements($date->format('Y-m-d'), '234HQW');

      	$this->assertArrayHasKey('body', $body);

    }

    /**
     * tests to see if the correct exception is thrown when a invalid user id is thrown in
     * @return [type] [description]
     */
    public function testGetBodyMeasurementsWithUnAuthorisedUserId()
    {
    	$mock_response =  new Response(401);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/unauthorized_user_body_measurement.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$fitbit_body = new FitBitBody('tester1', 'tester2');

      	$fitbit_body->setAccessCredentials('token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

        $date = Carbon::now()->subDay();

      	$this->setExpectedException('Jump24\FitBit\Exception\UnauthorizedAPIAccessException');

      	$body = $fitbit_body->getBodyMeasurements($date->format('Y-m-d'), '234KZC');

    }

    /**
     * tests that correct exception is thrown when body weight is called for in the future
     * @return [type] [description]
     */
    public function testGetBodyWeightWithDateInFuture()
    {
    	$mock_response =  new Response(200);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/body_measurement.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$fitbit_body = new FitBitBody('tester1', 'tester2');

      	$fitbit_body->setAccessCredentials('token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

        $date = Carbon::now()->addDays(7);

      	$body = $fitbit_body->getBodyWeightForDate($date->format('Y-m-d'));

      	$this->assertNull($body);

    }

    /**
     * tests that correct exception is thrown when body weight is called for in the future
     * @return [type] [description]
     */
    public function testGetBodyWeightWithValidDate()
    {
    	$mock_response =  new Response(200);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/valid_body_weight.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$fitbit_body = new FitBitBody('tester1', 'tester2');

      	$fitbit_body->setAccessCredentials('token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

        $date = Carbon::now()->subDay();

      	$body = $fitbit_body->getBodyWeightForDate($date->format('Y-m-d'));

      	$this->assertArrayHasKey('weight', $body);

    }

     /**
     * tests that correct exception is thrown when body weight is called for in the future
     * @return [type] [description]
     */
    public function testGetBodyWeightBetweenRangeWithValidDate()
    {
    	$mock_response =  new Response(200);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/valid_body_weight.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$fitbit_body = new FitBitBody('tester1', 'tester2');

      	$fitbit_body->setAccessCredentials('token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

      	$body = $fitbit_body->getBodyWeightBetweenDateRange('2015-01-31', '2015-02-01');

      	$this->assertArrayHasKey('weight', $body);

    }

      /**
     * tests that correct exception is thrown when body weight is called for in the future
     * @return [type] [description]
     */
    public function testGetBodyWeightBetweenRangeWithEndBeforeStartDate()
    {
    	$mock_response =  new Response(200);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/valid_body_weight.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$fitbit_body = new FitBitBody('tester1', 'tester2');

      	$fitbit_body->setAccessCredentials('token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

      	$body = $fitbit_body->getBodyWeightBetweenDateRange( '2015-02-01', '2015-01-31');

      	$this->assertNull($body);

    }



    /**
     * tests that correct exception is thrown when body weight is called for in the future
     * @return [type] [description]
     */
    public function testGetBodyFatWithDateInFuture()
    {
      $mock_response =  new Response(200);

      $mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/valid_body_fat.json', 'r+'));

        $mock_response->setBody($mockResponseBody);
    
        $mock = new Mock([ $mock_response ]);

        $fitbit_body = new FitBitBody('tester1', 'tester2');

        $fitbit_body->setAccessCredentials('token_tester', 'secret_tester');

        $fitbit_body->setupMockDataForRequest($mock);

        $date = Carbon::now()->addDays(8);

        $body = $fitbit_body->getBodyFatForDate($date->format('Y-m-d'));

        $this->assertNull($body);

    }

    /**
     * test the correct response when the correct date is enetered
     * @return [type] [description]
     */
    public function testGetBodyFatWeightWithValidDate()
    {
      $mock_response =  new Response(200);

      $mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/valid_body_fat.json', 'r+'));

        $mock_response->setBody($mockResponseBody);
    
        $mock = new Mock([ $mock_response ]);

        $fitbit_body = new FitBitBody('tester1', 'tester2');

        $fitbit_body->setAccessCredentials('token_tester', 'secret_tester');

        $fitbit_body->setupMockDataForRequest($mock);

        $date = Carbon::now()->subDay();

        $body = $fitbit_body->getBodyFatForDate($date->format('Y-m-d'));

        $this->assertArrayHasKey('fat', $body);

    }

 
}
