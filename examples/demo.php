<?php

require '../vendor/autoload.php';

$config = require 'config.php';

use Jump24\FitBit\FitBitBody;

$body = new FitBitBody($config['consumer_key'], $config['consumer_secret']);

$body->setAccessCredentials($_SESSION['token'], $_SESSION['secret']);

$body->dumpCallData();

$measurements = $body->getBodyFatBetweenDateRange('2014-12-31', '2015-01-30');

print_r($measurements);

die();
