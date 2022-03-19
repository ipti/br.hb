<?php
$HOST = getenv("DB_HOST");
$USER = getenv("DB_USER");
$PWD = getenv("DB_PWD");
$DB = getenv("DB_NAME");
return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=$HOST;dbname=$DB",
    'username' => $USER,
    'password' => $PWD,
    'charset' => 'utf8',
];
