<?php 


// for csrf attack protection I have created this csrf token manually as I am not using any framework 
// but if using framework I would have used there prebuilt token 
 session_start();
 session_regenerate_id();
 $options = [
    	'cost' => 10 
    // 'salt' => base64_encode("anyEncryptedRandomString__") // I am using php 7.1.0 where salt option is removed
];
 
 $token =  password_hash(session_id(), PASSWORD_BCRYPT ,$options);
 

 $cookie_name = "CSRF_TOKEN_ANIKETH";
 $expire = time() + (86400 * 30);
 $path = "/";
 $domain = ""; // your domain name for the cookie validation
 $secure = true; // for the ssl encrypted cookie
 $httponly = true;

 setcookie($cookie_name, $token, $expire, $path, $domain, $secure, $httponly );

 ?>
