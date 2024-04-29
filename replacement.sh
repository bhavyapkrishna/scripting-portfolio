#!/bin/bash

#count the number of command line arguments
#if there is a command-line argument, set "replacer" to it
if [ $# -gt 0 ]; then
replacer=$1;
else
replacer="replacement_text";
fi

#replace every bolded word with the replacer variable
curl -s "http://awkscripts.com/datw/out.feds.html" | sed -E "s|<b>(.+)</b>|<b>${replacer}</b>|g" > modified_text.html