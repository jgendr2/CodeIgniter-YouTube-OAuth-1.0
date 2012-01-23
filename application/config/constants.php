<?php    if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
PUT THIS AT THE BOTTOM OF YOUR CONSTANTS.PHP FILE THAT ALREADY COMES WITH CODEIGNITER
*/

define('YOUTUBE_CONSUMER_KEY', 'www.yourdomain.com');
define('YOUTUBE_CONSUMER_SECRET', 'SECRET GIVEN FROM GOOGLE');
//NOTICE I AM USING AN .htaccess file with CodeIgniter so I do not have the index.php part of the URL
define('YOUTUBE_OAUTH_CALLBACK', 'http://www.yourdomain.com/youtube/access_token');
//The above line would be (if you are not using an htaccess file):
//define('YOUTUBE_OAUTH_CALLBACK', 'http://www.yourdomain.com/index.php/youtube/access_token');