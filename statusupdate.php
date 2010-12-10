<?php
session_start();
include_once "config.php";
include_once "class.fblinkedtwit.php";
$fblinkedtwit   =   new FbLinkedTwit();

$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
if (!empty($status)){
    $status = substr($status, 0, 144);

    //facebook status update
    $fblinkedtwit->facebookStatusUpdate($status);

    //twitter status update
    if (isset($_SESSION['twit_oauth_access_token']) && isset($_SESSION['twit_oauth_access_token_secret'])){
        $fblinkedtwit->twitterStatusUpdate($status, $_SESSION['twit_oauth_access_token'], $_SESSION['twit_oauth_access_token_secret']);
    }

    //linkedin status update
    if (isset($_SESSION['requestToken']) && isset($_SESSION['oauth_verifier']) && isset($_SESSION['oauth_access_token'])){
        $fblinkedtwit->linkedinStatusUpdate($status, $_SESSION['requestToken'], $_SESSION['oauth_verifier'], $_SESSION['oauth_access_token']);
    }
}
?>
