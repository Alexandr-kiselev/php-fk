<?php
include('../bootstrap.php');

layout::getInstance()->get_static('style.css');
layout::getInstance()->get_static('script.js');
layout::getInstance()->add_static();

$product_bd =[
    [
    'category'=>'phone',
    'product_name'=>'Смартфон SY 17',
    'price'=>'25000',
    'product_img'=>'../static/img/1.webp'
    ],
    [
    'category'=>'phone',
    'product_name'=>'Смартфон SY 20',
    'price'=>'35000',
    'product_img'=>'../static/img/2.webp'
    ],
    [
    'category'=>'phone',
    'product_name'=>'Смартфон Samsung s18',
    'price'=>'20000',
    'product_img'=>'../static/img/3.webp'
    ],
    [
    'category'=>'phone',
    'product_name'=>'Смартфон Samsung s21',
    'price'=>'21000',
    'product_img'=>'../static/img/4.webp'
    ],
    [
    'category'=>'phone',
    'product_name'=>'Смартфон Nicon 27',
    'price'=>'15000',
    'product_img'=>'../static/img/5.webp'
    ],
    
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог</title>
</head>
<body>
    <div class="container">
        <div class="catalog_block">
            <?php 
            foreach($product_bd as $products): ?>
                <div class="catalog_item">
                    <img class="product_img" src="<?=$products['product_img'];?>" alt="">
                    <span class="product_name"><?=$products['product_name'];?></span>
                    <span class="price"><?=$products['price'];?> ₽</span> 
                </div>
            <?php endforeach ?>

        </div>
    </div>
    <?php  
    $arr = [
        'id'=>'13',
        'name' => 'phone1'
    ];
   print_r(db::getInstance()->insert('catalog',$arr));   
   
   
?>
</body>
</html>

