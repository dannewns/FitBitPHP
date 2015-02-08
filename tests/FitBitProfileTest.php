<?php

use Jump24\FitBit\FitBitProfile;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use Carbon\Carbon as Carbon;

class FitBitProfileTest extends PHPUnit_Framework_TestCase {


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
    public function testGetProfileInfoForCurrentUserWithAuthorisation()
    {

    	$mock_response =  new Response(200);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/profile.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$profile = new FitBitProfile('tester1', 'tester2');

      	$profile->setAccessCredentials('token_tester', 'secret_tester');

      	$profile->setupMockDataForRequest($mock);

      	$auth_user_profile = $profile->getProfileInfo();

      	$this->assertArrayHasKey('user', $auth_user_profile);
    
    }

    /**
     * tests that when the getProfileInfo method is called for the current user when not authorised  to make sure it calls the correct exception with the correct message
     * 
     * @return [type] [description]
     */
    public function testGetProfileInfoForCurrentUserWithoutAuthorisation()
    {
    	$mock_response =  new Response(400);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/no_authorisation_current_user_profile.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$profile = new FitBitProfile('tester1', 'tester2');

      	$profile->setupMockDataForRequest($mock);

      	$this->setExpectedException('Jump24\FitBit\Exception\BadAPIRequestException');

      	$auth_user_profile = $profile->getProfileInfo();

    }

    /**
     * tests getProfileInfo with invalid user id without authentication
     * @return [type] [description]
     */
    public function testGetProfileInfoForInvalidUserIdWithAuthentication()
    {

    	$mock_response =  new Response(400);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/no_authorisation_current_user_profile.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$profile = new FitBitProfile('tester1', 'tester2');

      	$profile->setAccessCredentials('token_tester', 'secret_tester');

      	$profile->setupMockDataForRequest($mock);

      	$this->setExpectedException('Jump24\FitBit\Exception\BadAPIRequestException');

      	$auth_user_profile = $profile->getProfileInfo('12312312312312');
    
    }

    /**
     * tests the getProfileInfo method with a valid user id without authentication
     * the api returns a basic public profile
     * @return [type] [description]
     */
    public function testGetProfileInfoForValidUserIdWithoutAuthentication()
    {
    	
    	$mock_response =  new Response(200);

     	$mockResponseBody = Stream::factory(fopen(__DIR__ . '/files/profile.json', 'r+'));

      	$mock_response->setBody($mockResponseBody);
    
      	$mock = new Mock([ $mock_response ]);

      	$profile = new FitBitProfile('tester1', 'tester2');

      	$profile->setupMockDataForRequest($mock);

      	$user_profile = $profile->getProfileInfo('234HQW');

      	$this->assertArrayHasKey('user', $user_profile);
    }

 
}
