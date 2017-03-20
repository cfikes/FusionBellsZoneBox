#!/bin/bash

# Fusion Bells ZoneBOX
# File Syncing and Caching
#
# Christopher Fikes
# 03/08/2017

# Directory of ZoneBox
zoneDIR="/var/www/html/"
# Get Zone Master
zoneMaster=`cat ${zoneDIR}config/MASTER`
# My Zone Domain
syncUser=`cat ${zoneDIR}config/SYNCUSER`
#Sync Key
syncKey=`cat ${zoneDIR}config/KEY`
#Sync Pass
syncPass=`cat ${zoneDIR}config/SYNCPASS`
# Assign Source of Tones
toneSource="/var/www/fusionpbx/app/fusionbells/tones/"
# Assign Dest of Tones
toneDest="${zoneDIR}tones/"
# Sync Tones
rsync -azv -vvv -e "sshpass -p ${syncPass} ssh -l ${syncUser}" ${zoneMaster}:${toneSource} $toneDest --delete
# Cache Schedule
curl -k -d "call=offlineschedule&key=${syncKey}" -X POST https://${zoneMaster}/app/fusionbells/api.php > ${zoneDIR}Temp.json
#Check File before use
if grep -q Schedule ${zoneDIR}Temp.json; then
 rm -f ${zoneDIR}ScheduleCache.json
 mv ${zoneDIR}Temp.json ${zoneDIR}ScheduleCache.json
fi