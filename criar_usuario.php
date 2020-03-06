<?php
include 'gestor.php';

$gestor = new Gestor();

$user = 'Lucineia';
$pass = 'abc123';

$params = array(
    ':user' => $user,
    ':pass' => password_hash($pass, PASSWORD_DEFAULT)
);

$gestor->EXE_NON_QUERY(
    "INSERT INTO users VALUES(0, :user, :pass)", $params);

echo 'Terminado!';