<?php 

require '../vendor/autoload.php';

$config = require 'config.php';

use Jump24\FitBit\FitBitAuth;

$auth = new FitBitAuth($config['consumer_key'], $config['consumer_secret'], $config['callback_url']);

$access_token = $auth->getAccessToken();

if ($access_token) {
  
    $_SESSION['token'] = $access_token->value['oauth_token'];
    
    $_SESSION['secret'] = $access_token->value['oauth_token_secret'];
    //

    header("Location: demo.php");
   
    exit;

}
