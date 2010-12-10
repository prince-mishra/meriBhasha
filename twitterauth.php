<?php
session_start();
include_once 'config.php';
include_once  $config['twitter_library_path'];

if ((!isset($_SESSION['twit_oauth_access_token'])) || ($_SESSION['twit_oauth_access_token'])=='') {

    $to = new TwitterOAuth($config['twitter_consumer'], $config['twitter_secret'], $_SESSION['twit_oauth_request_token'], $_SESSION['twit_oauth_request_token_secret']);
    $tok = $to->getAccessToken();

 	/* Save tokens for later  - might be wise to
        * store the oauth_token and secret in a database, and
        * only store the oauth_token in a cookie or session for security purposes */
    $_SESSION['twit_oauth_access_token'] =           $token  =   $tok['oauth_token'];
    $_SESSION['twit_oauth_access_token_secret'] =    $secret =   $tok['oauth_token_secret'];

}

$to     =   new TwitterOAuth($config['twitter_consumer'], $config['twitter_secret'], $_SESSION['twit_oauth_access_token'], $_SESSION['twit_oauth_access_token_secret']);

$token  =   $_SESSION['twit_oauth_access_token'];
$secret =   $_SESSION['twit_oauth_access_token_secret'];

header ("Location: " . $config['callback_url']);
exit;
?>
