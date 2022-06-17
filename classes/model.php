<?php
class Model {
    protected $table_columns;
    protected $table_name; 
    protected $properties; 
    protected $loaded = false;
    protected $table_cache = []; 
    protected $primary_key = "id";

    public function __construct($id = 0) {

        $this->table_check();

        if($id){
            $this->get($id);
        }
    }

    protected function table_check() {

        if(!in_array($this->table_name,$this->table_cache)){

           if(db::getInstance()->table_exists($this->table_name)){
            $this->table_cache[] = $this->table_name;

           }else{
                $this->create_table($this->table_name,$this->table_columns);
           }
         
        }
       
    }

    protected function create_table() {

        if(!array_key_exists($this->primary_key,$this->table_columns)){
            $this->table_columns['id'] = [db::TYPE_INT,db::ARGUMENT_NOT_NULL,db::ARGUMENT_AUTO_INCREMENT, db::ARGUMENT_PRIMARY_KEY];
        }

        db::getInstance()->creatTable($this->table_name,$this->table_columns);

    }

    public function save() {

        if($this->loaded){
            $this->update();
        }else {
            $this->create();
        }
        
    }

    public function update() {
        echo 'update';
    }

    public function create() {

        $this->loaded = true;
        db::getInstance()->insert($this->table_name,$this->properties);

    } 

    public function set($properties) {

        foreach($properties as $key => $value){
            $this->$key = $value;
        }

    }

    protected function get($id) {

        $stm = db::getInstance()->select($id);
        $row = $stm->fetch();

        if($row){
            $this->set($row);
        }
        
    }

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