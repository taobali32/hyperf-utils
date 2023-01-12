<?php
ini_set('display_errors',1);

$arr = [];
for ($i = 0; $i < 100000000;$i++){

    $str = "";

    for($j = 0; $j < 100; $j++){
        $str .= "hyperf执行代码无法释放内存hyperf执行代码无法释放内存hyperf执行代码无法释放内存hyperf执行代码无法hyperf执行代码无法释放内存hyperf执行代码无法释放内存hyperf执行代码无法释放内存hyperf执行代码无法hyperf执行代码无法释放内存hyperf执行代码无法释放内存hyperf执行代码无法释放内存hyperf执行代码无法";

    }

    $arr[] = $str;

    var_dump(memory_get_usage());
}
