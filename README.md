# About The Project:

Application where user is authenticated by JWT token and admin can invalidate token of a specific user.


# Built With:

* Bootstrap5<br/> 
* Vue3<br/> 
* Symfony5<br/>
 

# Installation:

## Set up for API

Dependencies: composer and symfony cli installed

1. Install:<br/>
cd API<br/> 
composer install<br/>

2. To generate the SSL keys run command:<br/> 
cd API<br/> 
php bin/console lexik:jwt:generate-keypair<br/>

## Set up for client<br/>

Dependencies: yarn installed<br/>

1. Install:<br/>
cd client <br/>
yarn install<br/>

# Usage:

1. Start API server:<br/>
cd API<br/>
symfony server:start<br/>

2. Start client server:<br/> 
cd client<br/>
yarn serve<br/>

## Database is included with already saved few users for testing:

* admin1@admin.com:Admin123<br/>
* admin2@admin.com:Admin123<br/>
* admin3@admin.com:Admin123<br/>


* user1@user.com:User1234<br/>	
* user2@user.com:User1234<br/>
* user3@user.com:User1234<br/>
* user4@user.com:User1234<br/>
