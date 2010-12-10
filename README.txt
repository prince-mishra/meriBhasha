Its very easy to install the program.


Requirements:
1. PHP 5 supported hosting
2. Basic knowledge to know how to setup an application in facebook visit:
3. Basic knowledge to know how to setup twitter application. Visit http://thinkdiff.net/category/twitter/
4. Basic knowledge to know how to setup linkedin application. Visit http://thinkdiff.net/linkedin/integrate-linkedin-api-in-your-site/

Steps:
1. Visit http://www.facebook.com/developers and click setup new application.
2. Provide application name, description.
3. Provide the Connect URL. 
4. Click Save Changes and you'll get api and secret key.
5. Now place those api and secret keys in the config.php
$config['fb_api']               =   'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
$config['fb_secret']            =   'yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy';

6. Create a new application in twitter. Visit this page to learn how to create twitter application. http://thinkdiff.net/category/twitter/
7. In twitter application setup set application website to http://yourdomain/yourproj/index.php. 
8. In twitter application setup set callback url like http://yourdomain/yourproj/twitterauth.php. 
9. After creating application update the config file
$config['twitter_consumer']     =   'xxxxxx your app consumer key';
$config['twitter_secret']       =   'your app secret key';

10. Create a new application in linkedin. 
11. In linkedin application setup set integration url http://yourdomain/yourproj/index.php. 
12. In linkedin application setup set oAuth redirect url to http://yourdomain/yourproj/linkedinauth.php. 
13. After creating application update the config file
$config['linkedin_access']      =   'xxx your linkedin application access key';
$config['linkedin_secret']      =   'yyy your linkedin application secret key';

14. Also update this configuation
$config['base_url']             =   ''; // it would be url without file like http://yoursite/demo/yourproject'
$config['callback_url']         =   ''; // like http://http://yoursite/demo/yourproject/index.php

15. Upload all codes of this project in your hosting.
16. Now visit your application. In my case the url is http://aitoss.net/princemishra/meriBhasha

Also remember: to update facebook status you must have to give status updated permission by clicking Give Status Update Permission

Run:
1. Connect by facebook
2. Give Twitter Access
3. Give Linkedin Access

You may only give any one's permission like, only twitter access or linkedin access as your wish.

Now write something and click Update Status. Now check your sites like twitter,facebook or linkedin to see the update
