<?php
    session_start();
    include_once 'config.php';
    include_once  $config['twitter_library_path'];


/*
    Create a new TwitterOAuth object, and then
    get a request token. The request token will be used
    to build the link the user will use to authorize the
    application.

     You should probably use a try/catch here to handle errors gracefully
*/
    $to = new TwitterOAuth($config['twitter_consumer'], $config['twitter_secret']);
    $tok = $to->getRequestToken();

    $request_link = $to->getAuthorizeURL($tok);

    $_SESSION['twit_oauth_request_token']        = $token = $tok['oauth_token'];
    $_SESSION['twit_oauth_request_token_secret'] = $tok['oauth_token_secret'];
    
    header("Location: $request_link");
    exit;
?>