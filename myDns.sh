#!/bin/bash
SOURCE="${BASH_SOURCE[0]}"
DIR="$( dirname "$SOURCE" )"
while [ -h "$SOURCE" ]
do 
  SOURCE="$(readlink "$SOURCE")"
  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE"
  DIR="$( cd -P "$( dirname "$SOURCE"  )" && pwd )"
done
DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
sudo chmod -R 777 $DIR/app/named
php -f $DIR/app/webroot/dns.php
sudo mv $DIR/app/named/zones/* /var/named/
sudo chown -R root:wheel /var/named/
sudo chmod 644 /var/named/*
sudo mv $DIR/app/named/named.conf /etc/
sudo chown root:wheel /etc/named.conf
sudo chmod 644 /etc/named.conf
sudo rndc reload
sudo rndc flush
sudo dscacheutil -flushcache
