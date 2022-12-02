<?php
$HOST = '127.0.0.1:3307';
$USER = 'root';
$PWD =  '';
$DB = 'br.org.ipti.hb.boquim';
return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=$HOST;dbname=$DB",
    'username' => $USER,
    'password' => $PWD,
    'charset' => 'utf8',
];
