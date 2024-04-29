#!/bin/bash

#count and sort the number of occurrences for each HTTP commands in allcataccess
curl -s "http://awkscripts.com/allcataccess" | awk -F" " '{print substr( $6, 2)}' | grep -o -E 'GET|HEAD|POST|CONNECT|OPTIONS' | sort | uniq -c | sort -n -s -k1,1 -r

