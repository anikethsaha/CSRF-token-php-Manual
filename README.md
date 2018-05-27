# Manual-csrf_token-php-
In this project I have shown how the SIMPLE idea behind the protection of CROSS-SITE-REQUEST-FORGERY :skull: attacks is implement using CSRF-TOKEN
<p align='center'><img src="https://i.imgur.com/3ILSy0I.gif" title="source: imgur.com" /></p>

## How to start :question:
Simple :metal: Download the zip or clone this repository then run the `index.php` using your localhost server. The Database creation with the Schema of the table is in the `dbconfig.php` Do read the comment in this files

## What I did :sunglasses:
##### Algorithm Used For encryption :muscle:
-> `sha256` for Key and iv encryption
-> `openssl` for session encryption - method used : `AES-256-CBC`
-> `BCRYPT` for csrf_token encryption as this is one way encryption algorithm and we just need to verify the token not decrypt it
###### CSRF protection methology :mortar_board:
-> We get the token from `csrf_token.php` which is giving me the token plus putting the same token in cookie . 
-> We get the token pnly if we visit the `index.php` that means a attacker has to visit this
-> if not then the token wont be valid
-> Considering a situation if somehow the attacker get a valid token ,then he/she will be using that int the request header in a remote   form but this wont be validated as your cookie will be having different token from this
-> You can surely add or contribute in this project to validate the cookie token and header token more precisely :smiley:


## Contributers Are Always Welcome
