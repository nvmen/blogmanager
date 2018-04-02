<?php
/**
 * Created by PhpStorm.
 * User: tma
 * Date: 3/20/2018
 * Time: 7:10 PM
 */

$mode ="develop";
define('TOKEN_ACCESS_BLOG', 'O2oYPjiKE9JBxbi3vUZmrc1BqMaIyGLXfgxYIUgFoYMbVEegUls4Mx2KD4MBn6GG0R06iyKToKeV7jpxd6TKFaI47fAUzt3RVy5Dy2QRSJNaQamNfhFcuZ5EBVAVawtHkmlsynTCu0nx2g6PSR3WZPGZ0CaWdBKEyTLki5WpjtoBXhVNcifOC9ZACTTVtzo0S6yotYp8');
if($mode == "develop"){

    define('GET_NEW_USER_REGISTER', 'http://localhost/monitablog/wp-json/wp/v2/users/allusers');
    define('UPDATE_STATUS_USER', 'http://localhost/monitablog/wp-json/wp/v2/users/updateuser');
    define('VERIFY_TOKEN_BLOG', 'http://localhost/monitablog/wp-json/jwt-auth/v1/token/validate');

}else{
    define('GET_NEW_USER_REGISTER', 'https://letup.com.vn/wp-json/wp/v2/users/allusers');
    define('UPDATE_STATUS_USER', 'https://letup.com.vn/wp-json/wp/v2/users/updateuser');
    define('VERIFY_TOKEN_BLOG', 'https://letup.com.vn/wp-json/jwt-auth/v1/token/validate');

}