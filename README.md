About The Project:

API where user is authenticated by JWT token and admin can invalidate token of a specific user.


Built With:

Bootstrap5
Vue3
Symfony5
 

Installation:

Set up for API

Dependencies: composer and symfony cli installed

1)Install
cd API 
php composer install

2)To generate the SSL keys run command 
cd API 
php bin/console lexik:jwt:generate-keypair

Set up for client

Dependencies: yarn installed

1)Install
cd client 
yarn install

Usage:

1)Start API server:
cd API
symfony server:start

2)Start client server: 
cd client
yarn serve

Database is included with already saved few users for testing:

  Emails:                 Passwords:
1	admin1@admin.com	      Admin123
2	admin2@admin.com	      Admin123
3	admin3@admin.com        Admin123


4	user1@user.com          User1234	
5	user2@user.com	        User1234
6	user3@user.com	        User1234
7	user4@user.com          User1234
