#!/bin/sh

#
# Software deployment script -- run via jenkins or from the command line
#
# usage: /bin/sh deploy/deploy.sh <environment>
#

##################################################################################
# Set these variables in Jenkins via its Environment Injection
##################################################################################

APPKEY=${APPKEY}
TRUSTEDPROXIES=${TRUSTEDPROXIES}

TARGETDIR=${TARGETDIR}
TARGETSTORAGE=${TARGETSTORAGE}
TARGETDEPLOYDB=${TARGETDEPLOYDB}

DBBACKUP=${DBBACKUP}

TARGETDBAPASS=${TARGETDBAPASS}
TARGETDBHOST=${TARGETDBHOST}
TARGETDBNAME=${TARGETDBNAME}
TARGETDBUSER=${TARGETDBUSER}
TARGETDBPASS=${TARGETDBPASS}

WEBUSER=${WEBUSER}
WEBGROUP=${WEBGROUP}

STARTDIR=${PWD}

##################################################################################
# Get config
##################################################################################

if [ $# -ne 1 ]; then
    echo "usage: $0 environment"
    exit 1
fi
TARGET=$1

cd ${STARTDIR}
echo "Deploying to ${TARGET}"

##################################################################################
# Build server infrastructure directories
##################################################################################

#
# Set up deployment directories
#
echo "Setting up target directories $TARGETDIR and $TARGETSTORAGE"
sudo mkdir -p ${TARGETDIR}
sudo mkdir -p ${TARGETSTORAGE}
sudo chown -R ${WEBUSER} ${TARGETDIR}
sudo chgrp -R ${WEBGROUP} ${TARGETDIR}

##################################################################################
# Deploy web site software
##################################################################################

#
# Make a backup before starting
#
if [ "$TARGETDEPLOYDB" != "new" ]; then
    echo "Backing up existing web files and database"
    BACKDATE=`date '+%Y%m%d_%H%M'`
    DIR=`basename $TARGETDIR`
    BACKDIR=${BACKDATE}_${DIR}
    cd $TARGETDIR
    cd ..
    sudo mkdir -p backups
    cp -a $TARGETDIR backups/$BACKDIR
    if [ "$DBBACKUP" = "yes" ]; then
        mysqldump -u $TARGETDBUSER --password=$TARGETDBPASS -h ${TARGETDBHOST} ${TARGETDBNAME} | gzip > backups/${BACKDATE}_${TARGETDBNAME}.sql.gz
    else
        echo "Database backup disabled on $TARGETSERVER. Change DBBACKUP=yes in your config file to enable"
    fi
fi

#
# Loading sources to deploy
#
cd $STARTDIR/deploy
. ./sources.conf

#
# Deploy web software files
#
cd $STARTDIR
echo "Syncing web files to $TARGETDIR"
sudo rsync -vaz --delete ${SOURCES} ${TARGETDIR} > /dev/null

#
# Deploy modified config files
#
echo "Deploying config files in ${STARTDIR}/deploy/${TARGET}"
cd ${STARTDIR}/deploy/${TARGET}
for file in *; do
    if [ -f "$file" ]; then
        TARGETFILE=`echo $file | sed -e 's;+;/;g' -e 's/DOT/\./g'`
        echo "Copying $file to ${TARGETDIR}/${TARGETFILE}"
        sudo /bin/cp -rf $file ${TARGETDIR}/${TARGETFILE}
    fi
done

#
# Replace values in DOTenv from Jenkins environment
#
echo "Replacing DOTenv files to correct values"
cd ${TARGETDIR}
sudo sed -i "/APP_KEY=/c\APP_KEY=${APPKEY}" .env
sudo sed -i "/DB_DATABASE=/c\DB_DATABASE=${TARGETDBNAME}" .env
sudo sed -i "/DB_USERNAME=/c\DB_USERNAME=${TARGETDBUSER}" .env
sudo sed -i "/DB_PASSWORD=/c\DB_PASSWORD=${TARGETDBPASS}" .env
sudo sed -i "/DBA_PASSWORD=/c\DBA_PASSWORD=${TARGETDBAPASS}" .env
sudo sed -i "/TRUSTED_PROXIES=/c\TRUSTED_PROXIES=${TRUSTEDPROXIES}" .env

#
# Install root config files.
#
echo "Installing root configuration files"
cd ${STARTDIR}/deploy/${TARGET}/root
for file in *; do
    TARGETFILE=`echo $file | sed 's;+;/;g'`
    echo "Copying $file to /${TARGETFILE}"
    sudo /bin/cp -rf $file /${TARGETFILE}
done

#
# Web user config post install
#
cd $TARGETDIR
if [ -f composer.lock ]; then
    /usr/local/bin/composer install --no-interaction
else
    /usr/local/bin/composer update --no-interaction
fi

##################################################################################
# Deploy database
##################################################################################

if [ "$TARGETDEPLOYDB" = "new" ]; then
    echo "Creating new database"
    #
    # Drop and recreate the database to ensure it's clean.
    #
    cd ${TARGETDIR}
    mysql -uroot --password=${TARGETDBAPASS} -h ${TARGETDBHOST} \
<< EOFDB
    SET FOREIGN_KEY_CHECKS=0;
    DROP DATABASE IF EXISTS ${TARGETDBNAME};
    CREATE DATABASE ${TARGETDBNAME} CHARACTER SET utf8;
    GRANT ALL ON ${TARGETDBNAME}.* TO ${TARGETDBUSER}@localhost IDENTIFIED BY '${TARGETDBPASS}';
EOFDB
fi

#
# Run the database migration.
#
if [ "$TARGETDEPLOYDB" != "none" ]; then
    echo "Running database migration"
    cd ${TARGETDIR}
    sudo chmod -R g-w .
    php artisan migrate --force
fi

#
# Run the database seed only on a new database.
#
if [ "$TARGETDEPLOYDB" = "new" ]; then
    echo "Running database seed"
    cd ${TARGETDIR}
    php artisan db:seed
fi

##################################################################################
#
# Common section
#
##################################################################################

#
# Add crontab
#
echo "Setting up artisan scheduler CRON Job"
# Run artisan scheduler every minute
echo "* * * * * php ${TARGETDIR}/artisan schedule:run 1>> /dev/null 2>&1" >> mycron
# Add a blank line, required for CRON to properly function
echo '' >> mycron
sudo crontab -u nginx mycron
sudo rm mycron
echo "CRON Job for artisan scheduler created"

#
# Add Route Caching
#
echo "Add Route Caching"
cd ${TARGETDIR}
php artisan route:cache > /dev/null 2>&1

#
# Reset permissions
#
echo "Fixing permissions"
sudo chown -R ${WEBUSER} ${TARGETDIR}
sudo chgrp -R ${WEBGROUP} ${TARGETDIR}
sudo chmod -R g+rwX ${TARGETDIR}
sudo find ${TARGETDIR} -type d -exec chmod g+ws {} \;
sudo chown -R ${WEBUSER} ${TARGETSTORAGE}
sudo chgrp -R ${WEBGROUP} ${TARGETSTORAGE}
sudo chmod -R g+rwX ${TARGETSTORAGE}
sudo chmod -R o-rwx ${TARGETSTORAGE}
sudo find ${TARGETSTORAGE} -type d -exec chmod g+ws {} \;

#
# Reload nginx and php-fpm
#
echo "Reloading nginx and php-fpm"
sudo service nginx reload > /dev/null 2>&1
sudo service php-fpm reload > /dev/null 2>&1

#
# Import elasticsearch indexes
#
if [ "$TARGETDEPLOYDB" = "new" ]; then
    echo "Importing elasticsearch indexes"
    cd ${TARGETDIR}
    php artisan elasticsearch:importIndex
fi
