#!/bin/bash
sudo chmod -R 777 /vh/my.dns/httpdocs/app/named
php -f /vh/my.dns/httpdocs/app/webroot/dns.php
sudo mv /var/www/vhosts/my.dns/httpdocs/app/named/zones/* /var/named/
sudo chown -R root:wheel /var/named/
sudo chmod 644 /var/named/*
sudo mv /var/www/vhosts/my.dns/httpdocs/app/named/named.conf /etc/
sudo chown root:wheel /etc/named.conf
sudo chmod 644 /etc/named.conf
sudo rndc reload
sudo rndc flush
sudo dscacheutil -flushcache
