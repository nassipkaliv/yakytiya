<h1>Backup / Restore данных с сайта</h2>

<h2>скрипт backup_mysql_upload</h2>
Делает backup данных сайта (папки upload и дамп базы ) актуального состояния

запуск скрипта на selectel: <br>
<code> bash /srv/www/dev.yakytiya/helper-scripts/backup_mysql_upload.sh </code>

После обработки файлов, данные будут помещены в директорию с бекапом проекта<br>
<code> /srv/backup/dev_yakutsk/mysql/</code> <br>
<code>/srv/backup/dev_yakutsk/upload</code>

<h2>скрипт restore_mysql_upload</h2>
Разворачивает базу и папку upload в проект

Скаченные архивы поместить в директорию с бекапом проекта <br>
Директория с бекапом проекта задается в переменной <code>LOCAL_BACKUP</code> в .env
<code>/srv/backup/dev_yakutsk/mysql.dump.zip</code> <br>
<code>/srv/backup/dev_yakutsk/upload.tar.gz</code>

Названия файлов должны точно соответствовать <br>
дамп mysql: <code>mysql.dump.zip</code> <br>
архив upload: <code>upload.tar.gz</code> <br>

После этого запустить скрипт: <br>
<code>bash /helper-scripts/restore_mysql_upload.sh</code>