#!/bin/env sh

parent_path=$( cd $(dirname ${BASH_SOURCE[0]}) ; pwd -P )
cd "$parent_path"

source ../.env

DATE=$(date +%Y-%m-%d_%H_%M_%S)
log_file=/srv/log/$APP_NAME/backup_mysql_upload.log

MYSQL_BACKUP=/var/lib/backup
CONTAINER=$APP_NAME-mysql-1
BACKUP_FILE_MYSQL=mysql-$APP_NAME-$DATE.dump.zip

BACKUP_FILE_UPLOAD=$LOCAL_BACKUP/upload/upload-$APP_NAME-$DATE.tar.gz

echo "-------------------------------------------------"| tee -a "$log_file"

echo "`date`[$APP_NAME] - 1. Делаем бекап базы $MYSQL_DATABASE окружения $APP_NAME" | tee -a "$log_file"
docker exec "$CONTAINER" bash -c "mkdir -p $MYSQL_BACKUP && mysqldump -u root -p$MYSQL_ROOT_PASSWORD $MYSQL_DATABASE -P $MYSQL_PORT| gzip >$MYSQL_BACKUP/$BACKUP_FILE_MYSQL"
echo "`date`[$APP_NAME] - 2. Закончили бекап базы $MYSQL_DATABASE окружения $APP_NAME [$BACKUP_FILE_MYSQL]" | tee -a "$log_file"

echo "`date`[$APP_NAME] - 3. Делаем бекап папки upload окружения $APP_NAME" | tee -a "$log_file"
tar -czf "$BACKUP_FILE_UPLOAD" ../upload/
echo "`date`[$APP_NAME] - 4. Закончили бекап папки upload  окружения $APP_NAME [$BACKUP_FILE_UPLOAD]" | tee -a "$log_file"

echo "-------------------------------------------------"| tee -a "$log_file"

echo "Архив дампа базы: $LOCAL_BACKUP/mysql/$BACKUP_FILE_MYSQL"| tee -a "$log_file"
echo "Архив папки upload: $BACKUP_FILE_UPLOAD"| tee -a "$log_file"
