<?php

require '../vendor/autoload.php';

$config = require 'config.php';

use Jump24\FitBit\FitBitBody;

$body = new FitBitBody($config['consumer_key'], $config['consumer_secret']);

$body->setAccessCredentials($_SESSION['token'], $_SESSION['secret']);

$measurements = $body->getBodyWeightForDate('2015-02-01');

print_r($measurements);

die();
