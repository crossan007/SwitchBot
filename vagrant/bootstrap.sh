#!/usr/bin/env bash

#=============================================================================
# DB Setup
DB_USER="root"
DB_PASS="root"
DB_HOST="localhost"

SB_DB_INSTALL_SCRIPT="/vagrant/src/mysql/install/Install.sql"
SB_DB_VAGRANT_SCRIPT="/vagrant/vagrant/vagrant.sql"
SB_DB_USER="switchbot"
SB_DB_PASS="switchbot"
SB_DB_NAME="switchbot"

echo "=========================================================="
echo "====================   DB Setup  ========================="
echo "=========================================================="
sudo sed -i 's/^bind-address.*$/bind-address=0.0.0.0/g' /etc/mysql/my.cnf
sudo service mysql restart
RET=1
while [[ RET -ne 0 ]]; do
    echo "Database: Waiting for confirmation of MySQL service startup"
    sleep 5
    sudo mysql -u"$DB_USER" -p"$DB_PASS" -e "status" > /dev/null 2>&1
    RET=$?
done

echo "Database: mysql started"

sudo mysql -u"$DB_USER" -p"$DB_PASS" -e "DROP DATABASE $SB_DB_NAME;"
sudo mysql -u"$DB_USER" -p"$DB_PASS" -e "DROP USER '$SB_DB_USER';"
echo "Database: cleared"

sudo mysql -u"$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE $SB_DB_NAME CHARACTER SET utf8;"

echo "Database: created"

sudo mysql -u"$DB_USER" -p"$DB_PASS" -e "CREATE USER '$SB_DB_USER'@'%' IDENTIFIED BY '$SB_DB_PASS';"
sudo mysql -u"$DB_USER" -p"$DB_PASS" -e "GRANT ALL PRIVILEGES ON $SB_DB_NAME.* TO '$SB_DB_NAME'@'%' WITH GRANT OPTION;"
sudo mysql -u"$DB_USER" -p"$DB_PASS" -e "FLUSH PRIVILEGES;"
echo "Database: user created with needed PRIVILEGES"

sudo mysql -u"$SB_DB_USER" -p"$SB_DB_PASS" "$SB_DB_NAME" < $SB_DB_INSTALL_SCRIPT

echo "Database: tables and metadata deployed"

echo "=========================================================="
echo "==============   Development DB Setup  ==================="
echo "=========================================================="

sudo mysql -u"$SB_DB_USER" -p"$SB_DB_PASS" "$SB_DB_NAME" < $SB_DB_VAGRANT_SCRIPT

echo "Database: development seed data deployed"

echo "=========================================================="
echo "=================   MailCatcher Setup  ==================="
echo "=========================================================="

sudo pkill mailcatcher
sudo /home/vagrant/.rbenv/versions/2.2.2/bin/mailcatcher --ip 0.0.0.0

echo "=========================================================="
echo "=================   Composer Update  ==================="
echo "=========================================================="

sudo /usr/local/bin/composer self-update
cd /vagrant/src
composer update

echo "=========================================================="
echo "====== Visit  http://192.168.33.15/               ========"
echo "====== login username            : admin          ========"
echo "====== initial admin password    : changeme       ========"
echo "=========================================================="
echo "=========================================================="
