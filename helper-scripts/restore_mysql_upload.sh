#!/bin/bash
parent_path=$( cd $(dirname ${BASH_SOURCE[0]}) ; pwd -P )
cd "$parent_path"

source ../.env

log_file=/srv/log/$APP_NAME/restore_mysql_upload.log
CONTAINER=$APP_NAME-mysql-1

BACKUP_FILE_MYSQL=$LOCAL_BACKUP/mysql.dump.zip
RESTORE_FILE_UPLOAD=$LOCAL_BACKUP/upload.tar.gz

echo "-------------------------------------------------"| tee -a "$log_file"

echo "`date`[$APP_NAME] - 1. Начинаем разворачивать бекап базы $MYSQL_DATABASE окружения $APP_NAME [$BACKUP_FILE_MYSQL]" | tee -a "$log_file"
zcat "$BACKUP_FILE_MYSQL" | docker exec -i $CONTAINER /usr/bin/mysql -u root --password=$MYSQL_ROOT_PASSWORD $MYSQL_DATABASE -P $MYSQL_PORT| tee -a "$log_file"
echo "`date`[$APP_NAME] - 2. Закончили разворачивать бекап базы $MYSQL_DATABASE окружения $APP_NAME" | tee -a "$log_file"

echo "`date`[$APP_NAME] - 3. Начинаем разворачивать бекап папки upload окружения $APP_NAME [$RESTORE_FILE_UPLOAD] "| tee -a "$log_file"
echo "`date`[$APP_NAME] - 4. Удаляем папку upload"| tee -a "$log_file"
rm -Rf "../upload/"
echo "`date`[$APP_NAME] - 5. Распаковываем архив "| tee -a "$log_file"
tar -vxf "$RESTORE_FILE_UPLOAD" -C ../
echo "`date`[$APP_NAME] - 6. Закончили разворачивать бекап папки upload окружения $APP_NAME" | tee -a "$log_file"