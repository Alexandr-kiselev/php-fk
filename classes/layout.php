<?php
class layout {
    private static $_instance;
    private $static_types = [
        "styles" => ["css"], 
        "scripts" => ["js"]
    ];
    private $arr_result = [];

    private function __construct() {
        $this->get_static('bootstrap.css');
        // $this->get_fonts('Roboto');
       $this->get_fonts(config::getConfig('layout', 'fonts'));
    }
    public function __wakeup(){
        throw new Exception('error',1);
    }
    public function __clone() {
        throw new Exception('error',1);
     }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new self; 
        }
 
        return self::$_instance;
    }

    function get_static($style){
       $style_info = pathinfo($style);
       $style_var =  $style_info['extension'];
        foreach($this->static_types as $key=>$item){
            if(in_array($style_var,$item)){
                $this->arr_result[] =  '/static/'. $style_var . '/'. $style;
            }
        }
    }
    function get_fonts($fonts){
        echo '
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family='. str_replace(' ','+',$fonts) .':wght@300;400&display=swap" rel="stylesheet">
        <style>
            :root{
                font-family:' . $fonts. ', sans-serif;
            }
        </style>
        ';
    }


    public function add_static(){
        foreach($this->arr_result as $val){
            if (strpos($val,".css")) {
                echo "<link rel='stylesheet' href='" .$val. "'>";
            }elseif(strpos($val,".js")){
                echo "<script src='" .$val. "'></script>";
            }
        }
    }


}


