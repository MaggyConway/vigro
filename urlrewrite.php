<?php
$arUrlRewrite=array (
  1 => 
  array (
    'CONDITION' => '#^/shop/filter/([a-z0-9_\\-\\/]+)/apply/#',
    'RULE' => 'SMART_FILTER_PATH=$1&',
    'ID' => '',
    'PATH' => '/shop/index.php',
    'SORT' => 10,
  ),
  4 => 
  array (
    'CONDITION' => '#^/ideas/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/ideas/index.php',
    'SORT' => 40,
  ),
  5 => 
  array (
    'CONDITION' => '#^/blog/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/blog/index.php',
    'SORT' => 50,
  ),
  16 => 
  array (
    'CONDITION' => '#^/shop/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/shop/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^\\??(.*)#',
    'RULE' => '&$1',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/wishlist/index.php',
    'SORT' => 150,
  ),
);
