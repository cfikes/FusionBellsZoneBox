#!/bin/bash

# Fusion Bells ZoneBOX
# File Syncing and Caching
#
# Christopher Fikes
# 03/08/2017

# Directory of ZoneBox
zoneDIR="/var/www/html/"
# Get Zone Master
zoneMaster=`cat ${zoneDIR}MASTER`
# My Zone Domain
zoneDOMAIN=`cat ${zoneDIR}DOMAIN`
#Sync Key
syncKey=`cat ${zoneDIR}KEY`
#Sync Pass
syncPass=`cat ${zoneDIR}PASS`
# Assign Source of Tones
toneSource="${zoneMaster}:/var/www/fusionpbx/app/fusionbells/tones/"
# Assign Dest of Tones
toneDest="${zoneDIR}tones/"
# Sync Tones
sshpass -p '${syncPass}' rsync -az -e ssh ${syncUser}@${toneSource} $toneDest --delete
# Cache Schedule
curl -k -d call=offlineschedule,key=${syncKey} https://${zoneMaster}app/fusionbells/api.php > ${zoneDIR}Temp.json
#Check File Empty before use
if [ -s ${zoneDIR}Temp.json ]
then
     #Not Empty
	 rm -f ${zoneDIR}ScheduleCache.json
	 mv ${zoneDIR}Temp.json ${zoneDIR}ScheduleCache.json
else
     #Empty
	 rm -f ${zoneDIR}Temp.json
fi
