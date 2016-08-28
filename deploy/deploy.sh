#!/bin/sh

#
# Software deployment script -- run via jenkins or from the command line
#
# usage: sudo /bin/sh deploy/deploy.sh <environment>
#

PWD=`pwd`
STARTDIR=${PWD}

##################################################################################
# Get config
##################################################################################

if [ $# -ne 1 ]; then
    echo "usage: $0 environment"
    exit 1
fi
TARGET=$1

if [ ! -f deploy/${TARGET}.conf ]; then
    echo "No config file available: deploy/${TARGET}.conf"
    exit 1
fi

cd $STARTDIR
. deploy/${TARGET}.conf
echo "Deploying to ${TARGET}"

##################################################################################
# Build server infrastructure directories
##################################################################################

#
# Set up deployment directories
#
echo "Setting up target directories $TARGETDIR and $TARGETSTORAGE"
mkdir -p ${TARGETDIR}
mkdir -p ${TARGETSTORAGE}
chown -R ${WEBUSER} ${TARGETDIR}
chgrp -R ${WEBGROUP} ${TARGETDIR}

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
    mkdir -p backups
    cp -a $TARGETDIR backups/$BACKDIR
    if [ "$DBBACKUP" = "yes" ]; then
        mysqldump -u $TARGETDBUSER --password=$TARGETDBPASS -h ${TARGETDBHOST} ${TARGETDBNAME} | gzip > backups/${BACKDATE}_${TARGETDBNAME}.sql.gz
    else
        echo "Database backup disabled on $TARGETSERVER. Change DBBACKUP=yes in your config file to enable"
    fi
fi

#
# Deploy web software files
#
cd $STARTDIR
echo "Syncing web files to $TARGETDIR"
rsync -vaz --delete . ${TARGETDIR} > /dev/null

#
# Deploy modified config files
#
echo "Deploying config files in ${STARTDIR}/deploy/${TARGET}"
cd ${STARTDIR}/deploy/${TARGET}
for file in *; do
    if [ -f "$file" ]; then
        TARGETFILE=`echo $file | sed -e 's;+;/;g' -e 's/DOT/\./g'`
        echo "Copying $file to ${TARGETDIR}/${TARGETFILE}"
        /bin/cp -rf $file ${TARGETDIR}/${TARGETFILE}
    fi
done

#
# Install root config files.
#
echo "Installing root configuration files"
cd ${STARTDIR}/deploy/${TARGET}/root
for file in *; do
    TARGETFILE=`echo $file | sed 's;+;/;g'`
    echo "Copying $file to /${TARGETFILE}"
    /bin/cp -rf $file /${TARGETFILE}
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
php artisan route:cache

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
    chmod -R g-w .
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
crontab -u nginx mycron
rm mycron
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
chgrp -R ${WEBGROUP} ${TARGETDIR}
chmod -R g+rwX ${TARGETDIR}
find ${TARGETDIR} -type d -exec chmod g+ws {} \;
chown -R ${WEBUSER} ${TARGETSTORAGE}
chgrp -R ${WEBGROUP} ${TARGETSTORAGE}
chmod -R g+rwX ${TARGETSTORAGE}
chmod -R o-rwx ${TARGETSTORAGE}
find ${TARGETSTORAGE} -type d -exec chmod g+ws {} \;

#
# Reload nginx and php-fpm
#
echo "Reloading nginx and php-fpm"
service nginx reload > /dev/null 2>&1
service php-fpm reload > /dev/null 2>&1