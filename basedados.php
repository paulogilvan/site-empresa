<?php
include 'gestor.php';

$gestor = new Gestor();
$dados = $gestor->EXE_QUERY("SELECT * FROM emails");

echo '<pre>';
print_r($dados);

die('Terminado!');
