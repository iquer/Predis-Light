#!/bin/sh
#######################################################################################################################
# This script generates the short version of the libraries

function make_short() {
	cat $1 \
		|grep -v "\$DEBUG" \
		|perl -pi -e 's/\s\s+/ /g;'|perl -pi -e 's/^ //g;' \
		|grep -v -e "\/\*.*\*\/" \
		|grep -v "^$" \
		> $2
}

make_short ../lib/Predis-Light-Debug.php ../lib/Predis-Light.php
