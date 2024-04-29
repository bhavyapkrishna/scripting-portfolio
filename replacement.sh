#!/bin/bash

if [ $# -gt 0 ]; then
replacer=$1;
else
replacer="replacement_text";
fi

curl -s "http://awkscripts.com/datw/out.feds.html" | sed -E "s|<b>(.+)</b>|<b>${replacer}</b>|g" > modified_text.html