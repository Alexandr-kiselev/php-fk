<?php
include('bootstrap.php');

layout::getInstance()->get_static('style.css');
layout::getInstance()->get_static('script.js');
layout::getInstance()->add_static();


$model = new Product();
$model->set(["name" => "some text2"]);
$model->save();