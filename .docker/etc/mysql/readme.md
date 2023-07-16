После установки новой базы необходимо:

1) Добавить привилегии mysql пользователю bitrix из под root
   GRANT SESSION_VARIABLES_ADMIN ON *.* TO 'bitrix'@'%';

2) Добавить в файл /bitrix/php_interface/after_connect_d7.php следующие значения 
   $this->queryExecute("SET NAMES 'utf8mb3'");
   $this->queryExecute('SET collation_connection = "utf8mb3_unicode_ci"');
   $this->queryExecute("SET LOCAL time_zone='".date('P')."'");
   $this->queryExecute("SET sql_mode=''");
   $this->queryExecute("SET innodb_strict_mode=0");

3) В этом файле  /bitrix/modules/main/classes/general/site_checker.php 
     поправить ошибки связанные с неправильный подключением connection
     правятся они таким образом  (отследить можно через дебагер)
        if ($character_set_connection == 'utf8mb3')
        {
           $character_set_connection = 'utf8';
        }
   После этого, возможно потребуется переконвертация базы в требуемую кодировку
   
   Возможно в будущем битрикс пофиксит данную проблему.

 