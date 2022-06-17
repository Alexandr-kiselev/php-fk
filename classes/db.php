<?php

class db {
    private $link;
    private static $_instance;
    private $dbName;
    const TYPE_INT = 'INT';
    const TYPE_TEXT = 'TEXT';
    const ARGUMENT_NULL = 'NULL';
    const ARGUMENT_NOT_NULL = 'NOT NULL';
    const ARGUMENT_AUTO_INCREMENT = 'AUTO_INCREMENT';
    const ARGUMENT_PRIMARY_KEY = 'PRIMARY KEY';

    // создает экземпляр класса к бд
    public function __construct(){
            $this->connect(); 
    }
    // проверяет есть ли такой экземпляр класса 
    public static function getInstance() {
    // если экзепляра нет то он в конструкторе создает новый объект класса
        if (!isset(self::$_instance)) {
            self::$_instance = new self; 
        }
    // если объект существует то возращает его
        return self::$_instance;
    }

    private function connect(){
     
        $config = config::getConfig('db');
    // фиксирую имя таблицы
        $this->dbName = $config['db_name'];
    // настройки для подключения
        $dsn = 'mysql:host='.$config['host'].';dbname='.$config['db_name'].';charset='.$config['charset'];
    // передаю в переменую класс PDO
        $this->link = new PDO($dsn,$config['username'],$config['password']);
        
    }
    public function creatTable($tableName, $arrayСolumns){
        $columns = [];
    // парсим массив $arrayСolumns
        foreach($arrayСolumns as $column=>$key){
            $columns[] = $column . ' '. implode(' ',$key);
        }
    // собираем колонки в строку для sql запроса 
        $columnsStr = implode(',',$columns);
    // не защищенный запрос в бд через query
    //  $this->link->query("CREATE TABLE `$this->dbName`.`$tableName` ( $columnsStr)");
    // защищенный запрос через execute
     $this->execute("CREATE TABLE `$this->dbName`.`$tableName` ( $columnsStr)");
    }


    public function table_exists($table_name) {

        $sth = $this->link->query("SHOW TABLES LIKE '$table_name'");
        $sth->execute();
        return  $sth->fetch() == false ? false : true;

    }

    public function insert(string $table_name, array $table_values){

        $value = "'". implode("','", array_values($table_values)) ."'";
        $column = implode(',', array_keys($table_values));
        $sql = "INSERT INTO $table_name ($column) VALUES ($value)";
        $sth = $this->link->prepare($sql);
        $sth->execute();
        return $this->link->lastinsertid();

    }

    public function select(string $table_name, string $where = "", $limit = 0) {

        $sth = "SELECT * FROM $table_name ";
        if($where != ''){
            $sth .= "WHERE $where"; 
        }

        if($limit != 0){
            $sth .= "LIMIT $limit";
        }

        $sth = $this->link->prepare($sth);
        $sth->execute();
        return $sth;

    }
  
    public function execute($sql){
        // подготовка SQL запроса (prepare) $sth объект запроса к бд
        $sth = $this->link->prepare($sql);
        return $sth->execute();
    }

    public function __wakeup(){ 
        throw new Exception('error',1);
    }
    
    private function __clone() {
        throw new Exception('error',1);
     }
}
