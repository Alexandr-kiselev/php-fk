<?php

class config {
    private static  $setting = [];
    
    public static function getConfig($fileName, $key = ''){
    // fileName - название подключаемого файла

        // проверяем есть ли в ключах setting значение перменой fileName 
        if(!in_array($fileName, array_keys(self::$setting))){

            //проверяем существует ли такой файл по указанному пути 
            if(file_exists(__DIR__ . "/../config/" .$fileName.".php")){
                self::$setting[$fileName] = include(__DIR__ . "/../config/" .$fileName.".php" );
            }
            // если ключ пустой вернуть всё содержимое файла
        } if($key == ''){
            return self::$setting[$fileName]; 
        }  
        // елси ключ существует вернет true и вернет настройку под ключем $key
        elseif(self::$setting[$fileName][$key]){
            return self::$setting[$fileName][$key]; 
        }
    }  
     
}


