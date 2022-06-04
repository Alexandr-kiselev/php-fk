<?php
class Product extends Model {
    protected $table_name = 'product';
    protected $table_columns = [
        'id'=>[db::TYPE_INT,db::ARGUMENT_NOT_NULL,db::ARGUMENT_AUTO_INCREMENT, db::ARGUMENT_PRIMARY_KEY],
        'name'=>[db::TYPE_TEXT],
    ];
}