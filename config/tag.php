<?php
$HOST = getenv("DB_HOST");
$USER = getenv("DB_USER");
$PWD = getenv("DB_PWD");
$TAGDB = getenv("TAG_DB_NAME");

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=$HOST;dbname=$TAGDB",
    'username' => $USER,
    'password' => $PWD,
    'charset' => 'utf8',
];