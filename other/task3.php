<?php

$sql = "create table `tests` (`id` bigint unsigned not null auto_increment primary key, `script_name` char(25) not null, `start_time`
    int not null, `end_time` int not null, `result` enum('normal', 'illegal', 'failed', 'success') not null)";

try {

    $conn = new PDO("mysql:host=localhost;dbname=only-test;port=33060", 'local-user', 'local-password');
    $conn->query('select * from cars');
} catch (PDOException $e) {
    var_dump($e);
}

//$db = new mysqli('localhost', 'local-user', 'local-password', 'only-test', 3308);

//var_dump($conn->query('select * from cars'));
