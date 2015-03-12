GREP_PATTERN=portid=\"$1\"
PORTID=$1
echo $GREP_PATTERN

#array=( `cat "ports_list.cat"` )
FILE=/home/linuxrdp/ports/ports_"$PORTID".lst
cat ports.lst | grep "$GREP_PATTERN" | gawk 'match($0, /addr="([^"]+)"/, x) {print x[1] }' | sort | uniq > $FILE
