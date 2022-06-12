<?php
class Model {
    protected $table_columns; //Колонки таблицы (ключ - название, значение - типы)
    protected $table_name; //Имя таблицы
    protected $properties; //Массив в котором хранятся записи таблицы 
    protected $loaded; //состояние модели (загружена или нет)
    protected $table_cache = []; //тут хранится кеш всех таблиц (их имена)
    protected $primary_key = "id"; //стандартный первичный ключ

    public function __construct($id = 0) {
        /**
         * 1. Вызываем метод проверки существования таблицы
         * 2. Делаем проверку на переданный id
         * 3. Если id есть, то вызываем метод, в котором достаем модель по айди
         */
        $this->table_check();
    }

    protected function table_check() {
        /**
         * 1. Проверяем существует ли имя таблицы в кеше
         * 2. Если имени таблицы в кеше нет, то добавляем ее в кеш
         * 2.1. Также если в кеше нет имени таблицы проверяем существует ли таблицы в БД
         * 2.2. Если таблицы нигде нет, то вызываем метод создания таблицы
         */
        if(!in_array($this->table_name,$this->table_cache)){

           if(db::getInstance()->table_exists($this->table_name)){
            $this->table_cache[] = $this->table_name;

           }else{
                $this->create_table($this->table_name,$this->table_columns);
           }
         
        }
       
        
    }

    protected function create_table($table_name, $table_columns) {
        /**
         * 1. Проверяем, если ключ в массиве колонок равен первичному ключу, то добавляем константы ARGUMENT_AUTO_INCREMENT и ARGUMENT_PRIMARY_KEY
         * 2. На выходе мы должны получить готовый массив колонок, в котором присутствует первичный ключ, закидываем его в метод создания таблицы класса bd
         */
        db::TYPE_INT;
        if(!array_key_exists($primary_key,$table_columns)){
           $table_columns['id'] = "db::ARGUMENT_AUTO_INCREMENT, db::ARGUMENT_PRIMARY_KEY";

        }
        db::getInstance()->creatTable($table_name, $table_columns);
    }

    public function save() {
        /**
         * 1. Делаем проверку на загруженность модели
         * 2. Если загружена, то вызываем метод обновления модели
         * 3. Если не загружена, то вызываем метода создания модели
         */
    }

    public function update() {
        //Этот метод реализуется в последней лекции :)
    }

    public function create() {
        /**
         * 1. Указываем, что модель загружена
         * 2. Добавляем запись в таблицу вызовом метода добавления из класса bd
         */
    }

    public function set($properties) {
        /**
         * Здесь в цикле необходимо засетить запись, пробежавшись циклом по $properties. 
         * Здесь идет взаимодействие с __get и __set, почитай про геттеры и сеттеры
         */
    }

    protected function get($id) {
        /**
         * 1. Вызываем метод выборки записей из класса bd. Выборку производить по id модели
         * 2. Полученные записи необходимо сохранить посредством метода set
         */
    }

    //Для упрощения оставил геттеры и сеттеры. Погугли про них в инете
    public function __set($name, $value) {
        if(in_array($name, array_keys($this->table_columns))) {
            $this->properties[$name] = $value;
        }
    }

    public function __get($name) {
        if(in_array($name, array_keys($this->table_columns))) {
            echo $this->properties[$name];
        }
    }
}