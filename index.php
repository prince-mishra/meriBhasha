<?php
    session_start();
    include_once "config.php";
    include_once "class.fblinkedtwit.php";

    $fblinkedtwit   =   new FbLinkedTwit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>meriBhasha: Facebook, Twitter & Linkedin Status Update Application</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript">
        var baseUrl =   "<?=$config['base_url']?>";
    </script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="javascript.js"></script>
  
  <! Transliteration Code here>
    
    <script type="text/javascript" src="https://www.google.com/jsapi">
    </script>
    <script type="text/javascript">

      // Load the Google Transliterate API
      google.load("elements", "1", {
            packages: "transliteration"
          });

      var transliterationControl;
      function onLoad() {
        var options = {
            sourceLanguage: 'en',
            destinationLanguage: ['hi','ar','kn','ml','ta','te'],
            transliterationEnabled: true,
            shortcutKey: 'ctrl+g'
        };
        // Create an instance on TransliterationControl with the required
        // options.
        transliterationControl =
          new google.elements.transliteration.TransliterationControl(options);

        // Enable transliteration in the textfields with the given ids.
        //var ids = [ "status", "transl2" ]; 
        //In this case I need to have atleast 2 text fields each for each value, otherwise the language select dropdown wont load 
	var ids = ["status"];
        transliterationControl.makeTransliteratable(ids);

        // Add the STATE_CHANGED event handler to correcly maintain the state
        // of the checkbox.
        transliterationControl.addEventListener(
            google.elements.transliteration.TransliterationControl.EventType.STATE_CHANGED,
            transliterateStateChangeHandler);

        // Add the SERVER_UNREACHABLE event handler to display an error message
        // if unable to reach the server.
        transliterationControl.addEventListener(
            google.elements.transliteration.TransliterationControl.EventType.SERVER_UNREACHABLE,
            serverUnreachableHandler);

        // Add the SERVER_REACHABLE event handler to remove the error message
        // once the server becomes reachable.
        transliterationControl.addEventListener(
            google.elements.transliteration.TransliterationControl.EventType.SERVER_REACHABLE,
            serverReachableHandler);

        // Set the checkbox to the correct state.
        document.getElementById('checkboxId').checked =
          transliterationControl.isTransliterationEnabled();

        // Populate the language dropdown
        var destinationLanguage =
          transliterationControl.getLanguagePair().destinationLanguage;
        var languageSelect = document.getElementById('languageDropDown');
        var supportedDestinationLanguages =
          google.elements.transliteration.getDestinationLanguages(
            google.elements.transliteration.LanguageCode.ENGLISH);
        for (var lang in supportedDestinationLanguages) {
          var opt = document.createElement('option');
          opt.text = lang;
          opt.value = supportedDestinationLanguages[lang];
          if (destinationLanguage == opt.value) {
            opt.selected = true;
          }
          try {
            languageSelect.add(opt, null);
          } catch (ex) {
            languageSelect.add(opt);
          }
        }
      }

      // Handler for STATE_CHANGED event which makes sure checkbox status
      // reflects the transliteration enabled or disabled status.
      function transliterateStateChangeHandler(e) {
        document.getElementById('checkboxId').checked = e.transliterationEnabled;
      }

      // Handler for checkbox's click event.  Calls toggleTransliteration to toggle
      // the transliteration state.
      function checkboxClickHandler() {
        transliterationControl.toggleTransliteration();
      }

      // Handler for dropdown option change event.  Calls setLanguagePair to
      // set the new language.
      function languageChangeHandler() {
        var dropdown = document.getElementById('languageDropDown');
        transliterationControl.setLanguagePair(
            google.elements.transliteration.LanguageCode.ENGLISH,
            dropdown.options[dropdown.selectedIndex].value);
      }

      // SERVER_UNREACHABLE event handler which displays the error message.
      function serverUnreachableHandler(e) {
        document.getElementById("errorDiv").innerHTML =
            "Transliteration Server unreachable";
      }

      // SERVER_UNREACHABLE event handler which clears the error message.
      function serverReachableHandler(e) {
        document.getElementById("errorDiv").innerHTML = "";
      }
      google.setOnLoadCallback(onLoad);

    </script>
  
  
  </head>
  <body>
      <h2>meriBhasha: Facebook, Twitter & Linkedin Status Update in any language</h2>
      <div style="float: left; margin-right: 10px">
      <table border="0" cellspacing="3" cellpadding="3">
          <tr style="background-color: #e6e1e1">
              <td>
                  <div id="login">
                    <fb:login-button v="2" size="large" length="long" onlogin="fbcloggedin();"></fb:login-button>
                  </div>
                  <div id="logout" style="display: none">
                      <b>Facebook Information</b><br />
                      <div style="width: 60px;float:left">
                          <fb:profile-pic uid="loggedinuser" facebook-logo="true" linked="true" ></fb:profile-pic>
                      </div>
                      <div style="margin-left: 10px; float: left">
                          <fb:name uid="loggedinuser" linked="true" useyou="false" ></fb:name><br />
                          <a href="#" onclick="FB.Connect.logoutAndRedirect('<?=$config['base_url']?>')">Facebook Logout</a>
                      </div>
                      <div style="clear:both"></div>
                      <a href="#" onclick="FB.Connect.showPermissionDialog('status_update', '','' ,'' );return false">Give Status Update Permission</a>
                      
                  </div>
              </td>
          </tr>
          <tr style="background-color: #c2cabb">
              <td>
                  <div id="twitinfo" style="display: block">
                      <?php
                        if (isset($_SESSION['twit_oauth_access_token']) && isset($_SESSION['twit_oauth_access_token_secret'])){
                            echo '<b>Twitter Information</b><br />';
                            $data = $fblinkedtwit->twitterGetLoggedinUserInfo($_SESSION['twit_oauth_access_token'], $_SESSION['twit_oauth_access_token_secret']);

                            ?>
                            <table border="0" cellspacing="3" cellpadding="3">
                                <tr><td>Name</td>          <td><a target="_blank" href="http://twitter.com/<?=$data->screen_name?>"><?=$data->name?></a></td></tr>
                                <tr><td>location</td>      <td><?=$data->location?></td></tr>
                                <tr><td>description</td>   <td><?=$data->description?></td></tr>
                                <tr><td>Profile Image</td> <td><img src="<?=$data->profile_image_url?>" alt="" /></td></tr>
                            </table>
                      <?php
                        }
                      ?>
                  </div>
                  <a href='<?=$config['base_url']?>/twitter.php'>Give Twitter Access</a>
              </td>
          </tr>
          <tr style="background-color: #d1dee9">
              <td>
                  <div id="linkedinfo" style="display: block">
                    <?php
                        if (isset($_SESSION['requestToken']) && isset($_SESSION['oauth_verifier']) && isset($_SESSION['oauth_access_token'])){
                            echo '<b>Linkedin Information</b><br />';
                            $data = $fblinkedtwit->linkedinGetLoggedinUserInfo($_SESSION['requestToken'], $_SESSION['oauth_verifier'], $_SESSION['oauth_access_token']);

                            $data = simplexml_load_string($data);
                            ?>
                            <table border="0" cellspacing="3" cellpadding="3">
                                <tr><td>Name</td>          <td><a target="_blank" href="<?=$data->{'public-profile-url'}?>"><?=$data->{'first-name'}?> <?=$data->{'last-name'}?></a></td></tr>
                                <tr><td>Headline</td>      <td><?=$data->headline?></td></tr>
                                <tr><td>Profile Image</td> <td><img src="<?=$data->{'picture-url'}?>" alt="" /></td></tr>
                            </table>
                      <?php
                        }
                      ?>
                  </div>
                  <a href='<?=$config['base_url']?>/linkedin.php'>Give Linkedin Access</a>
              </td>
          </tr>
      </table>
      </div>
      
    <div style="float: left;">
    <!-- The form starts here---->
    
    <div id='translControl'>
      <input type="checkbox" id="checkboxId" onclick="javascript:checkboxClickHandler()"></input>
      Type in <select id="languageDropDown" onchange="javascript:languageChangeHandler()"></select>
    </div>
    
    <form name="fstat" id="fstat" action="<?=$config['base_url']?>/statusupdate.php" method="POST">
 	  <br /> Your Status Message <span style="font-size: 10px">144 Chars Limit</span><br /><br />
 	   <textarea name="status" id="status" rows="4" cols="60"></textarea><br />
	<input type="button" onclick="ajaxCall(); return false;" value="Update Status" />
   	<br />	<span style="font-size:12px">If you give all access then status will update in all sites. </span><br />
              <span style="font-size:12px">We can't update your status in a site if you don't give permission</span><br />
              <span style="font-size:12px">We don't need password for this</span><br />
              
    </form>
    <br><div id="errorDiv"></div>
      <div id="loader" style="display:none">
              <img src="<?=$config['base_url']?>/loader.gif" alt="loader" />
      </div>
      <div id="result" style="width: 400px; height: 200px; overflow:auto;">
      </div>
      
      <!--everything ends--->
      </div>
      <div style="clear:both"></div>
      <div style="font-size: 14px; text-align: center">
        <a href="https://github.com/prince-mishra/meriBhasha/blob/master/README.txt">Read about this project </a>
        <br />
        <a href="https://github.com/prince-mishra/meriBhasha/zipball/master">Download the code</a>
      </div>
    <script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
    <script type="text/javascript">
        FB.init("<?=$config['fb_api']?>", "xd_receiver.htm", {"ifUserConnected" : fbcloggedin});
    </script>
  </body>
</html>
