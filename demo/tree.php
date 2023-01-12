<?php

ini_set('display_errors',1);
require '../vendor/autoload.php';


$foo = [
    ['id' => 1, 'name' => '食物', 'parent_id' => 0],
    ['id' => 4, 'name' => '饮料', 'parent_id' => 1],
    ['id' => 5, 'name' => '矿泉水', 'parent_id' => 4],
    ['id' => 6, 'name' => '食品', 'parent_id' => 1],
];

$tree = (new \EasyTree\Tree\TreeBuilder($foo))
    ->setIdKey('id')
    ->setParentKey('parent_id')
    ->setChildrenKey('children')
    ->build();

print_r($tree->toArray());

