#!/bin/bash

#
# ZoneBox Installation
# 2017-03-20
# Christopher Fikes
#


apt-get update && apt-get upgrade
apt-get install apache2 php5 git sshpass curl -y

cd /var/www/html
git clone https://github.com/cfikes/FusionBellsZoneBox
mv FusionBellsZoneBox/* ./
mkdir /var/www/html/tones
chown -R www-data:www-data *
chmod -R 775 *
rm -f index.html

echo "#FusionBells Syncing and Ringing" > /etc/cron.d/FusionBells
echo "* * * * *  root bash /usr/bin/php5 /var/www/html/ring.php" >> /etc/cron.d/FusionBells
echo "*/5 * * * * root bash /var/www/html/Syncing.sh" >> /etc/cron.d/FusionBells