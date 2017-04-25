# Setup

## Pre-Requirements
1. PHP 7
2. MySql


## Installation
1. Download composer here: https://getcomposer.org/download/
2. Download zip of this github project
3. Open terminal and go into this folder
4. Run composer install

## Configuration

1. signup with mailtrap.io
2. get unique username and password and port
3. add to .env file these credentials(lines 25-27 )
4. lines 7-12 of .env, change db credentials to yours, and then create database of that name in mysql

## DB setup

1. Open terminal and go to this folder.
2. run php artisan migrate
3. should see 4 successful migrations
4. using a DBMS go to the new tables in the database
5. under Users, add a new user filling in email, author_name, year and put role as admin.

## Final steps

1. Open terminal and go to this folder.
2. run php artisan cache:clear
3. run php artisan serve
4. go to the host name given after running the command in step 3.
5. start using the application

## Toroubleshooting
#### Q: Email doesnt send, due to refused connection
A: This is due to a firewall blocking connections, one example would be on the school wifi.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
The twemoji library is used under the creative commons attribution license: https://github.com/twitter/twemoji
The font awesome library is used under the MIT license: http://fontawesome.io/license/
The open sans font is used under the SIL Open Font License: https://fonts.google.com/attribution
