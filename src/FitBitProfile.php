<?php 

namespace Jump24\FitBit;

class FitBitProfile  extends FitBitBaseApi{

 	public function __construct($consumer_key, $consumer_secret)
 	{
 		parent::__construct($consumer_key, $consumer_secret);
 	}


 	/**
 	 * returns a users profile from the system
 	 * @param  string $user_id the user id to get profile information for
 	 * @return [type]          [description]
 	 */
 	public function getProfileInfo($user_id = '-')
 	{
 		if ($profile = $this->get('user/' . $user_id . '/profile.json')) {

 			return $profile;

 		}

 		return false;

 	}

}