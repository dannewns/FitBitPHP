<?php

require 'vendor/autoload.php';

$config = require 'config.php';

use Jump24\FitBit\FitBitBody;

$body = new FitBitBody($config['consumer_key'], $config['consumer_secret'], $_SESSION['token'], $_SESSION['secret']);

$body->getBodyMeasurements('-', '2014-01-31');

var_dump($body);
die();
