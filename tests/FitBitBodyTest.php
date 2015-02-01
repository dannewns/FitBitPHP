<?php

use Jump24\FitBit\FitBitBody;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

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

      	$fitbit_body = new FitBitBody('tester1', 'tester2', 'token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

      	$body = $fitbit_body->getBodyMeasurements('2015-01-28');

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

      	$fitbit_body = new FitBitBody('tester1', 'tester2', 'token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

      	$body = $fitbit_body->getBodyMeasurements('2017-01-28');

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

      	$fitbit_body = new FitBitBody('tester1', 'tester2', 'token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

      	$this->setExpectedException('Jump24\FitBit\Exception\InvalidDateFormatException');

      	$body = $fitbit_body->getBodyMeasurements('asdasda');

    
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

      	$fitbit_body = new FitBitBody('tester1', 'tester2', 'token_tester', 'secret_tester');

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

      	$fitbit_body = new FitBitBody('tester1', 'tester2', 'token_tester', 'secret_tester');

      	$fitbit_body->setupMockDataForRequest($mock);

      	$body = $fitbit_body->getBodyMeasurements('2014-01-28', '234HQW');

      	$this->assertArrayHasKey('body', $body);

    }
 
}
