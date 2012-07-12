#!/bin/bash
php -f /vh/my.dns/httpdocs/app/webroot/dns.php
sudo mv /var/www/vhosts/my.dns/httpdocs/app/cache/zones/* /var/named/
sudo chown -R root:wheel /var/named/
sudo chmod 644 /var/named/*
sudo mv /var/www/vhosts/my.dns/httpdocs/app/cache/named.conf /etc/
sudo chown root:wheel /etc/named.conf
sudo chmod 644 /etc/named.conf
sudo rndc reload
sudo rndc flush
sudo dscacheutil -flushcache
