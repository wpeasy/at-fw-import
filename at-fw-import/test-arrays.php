<?php


$a = ['.test', '.test2'];
$b = array_map(function ($n) {
    return str_replace('.', '', $n);
}
    , $a);
print_r($b);