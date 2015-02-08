<?php

require '../vendor/autoload.php';

$config = require 'config.php';

use Jump24\FitBit\FitBitProfile;

$profile = new FitBitProfile($config['consumer_key'], $config['consumer_secret']);

//$profile->setAccessCredentials($config['auth_token'], $config['auth_secret']);

//$profile->dumpCallData();

$info = $profile->getProfileInfo('234HQW');

var_dump($info);

die();
