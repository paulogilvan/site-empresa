<?php
include("layout/html_header.php");
include("layout/nav.php");

// Rotas (Routes) - Roteamento das páginas
$page = "main";

if(isset($_GET["p"])) {
    $page = $_GET["p"];
}

switch ($page) {
    case 'main':
        include("main.php");
        break;
    case 'empresa':
        include("empresa.php");
        break;
    case 'servicos':
        include("servicos.php");
        break;
    case 'contatos':
        include("contatos.php");
        break;
    default:
        include("main.php");
        break;
}

//if($page == "main") {
//    include("main.php");
//} elseif($page == "empresa") {
//    include("empresa.php");
//} elseif($page == "servicos") {
//    include("servicos.php");
//} elseif($page == "contatos") {
//    include("contatos.php");
//} else {
//    include("main.php");   
//}

include("layout/footer.php");
include("layout/html_footer.php");