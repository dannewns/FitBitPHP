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
 
}
