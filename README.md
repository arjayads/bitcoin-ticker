# bitcoin-ticker 
Note: https://btc-e.com/api/3/ticker/btc_usd may its fields.

Overview:

This is a simple project that ingrates PHP, MySQL, Json and 3rd party API

Requirements:

Assumed that PHP, MySQL Database and Apache Web server are installed correctly.

Resource: https://btc­e.com/api/3/btc_usd/ticker

Steps for Greenfield Deployment:

1. Create a database and name it bitcoin.
2. Create a user with the ff credentials:
username: bitcoin
password: bitcoin

and grant access to bitcoin database

3. Create a table that will be used to store the data coming from the resource

CREATE TABLE `ticker` (
`high` DECIMAL(18,8) NULL DEFAULT NULL,
`low` DECIMAL(18,8) NULL DEFAULT NULL,
`avg` DECIMAL(18,8) NULL DEFAULT NULL,
`vol` DECIMAL(18,8) NULL DEFAULT NULL,
`vol_cur` DECIMAL(18,8) NULL DEFAULT NULL,
`last` DECIMAL(18,8) NULL DEFAULT NULL,
`buy` DECIMAL(18,8) NULL DEFAULT NULL,
`sell` DECIMAL(18,8) NULL DEFAULT NULL,
`updated` INT(11) NULL DEFAULT NULL,
`server_time` INT(11) NULL DEFAULT NULL,
`hi_low_diff` DECIMAL(18,8) NULL DEFAULT '0.00000000',
`hi_last_market_diff` DECIMAL(18,8) NULL DEFAULT '0.00000000',
`low_last_market_diff` DECIMAL(18,8) NULL DEFAULT '0.00000000',
`updated_date_time` DATETIME NULL
) ENGINE=MyISAM;

4. Check out source

5. Edit your hosts file and add the ff:

127.0.0.1 bitcoin.dev

6. Edit your apache vhosts and add the ff:

<VirtualHost *:80>
  ServerName bitcoin.dev
  DocumentRoot "{absolute path of the repository directory}"
  DirectoryIndex index.php index.html
  <Directory "{absolute path of the repository directory}”>
    Options All
    AllowOverride All
    Allow from All
  </Directory>
</VirtualHost>

7. Restart apache

8. Create cron job with ff entry:

*/15 * * * * php path/to/cron.php

9. On your browser’s Web Address Area, type or paste http://bitcoin.dev/ and the index page of the project shall display

10. Enjoy!
