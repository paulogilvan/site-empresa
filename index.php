<?php
session_start();

include("layout/html_header.php");
include("layout/nav.php");
include("layout/user.php");

// Rotas (Routes) - Roteamento das páginas
$page = "main";

if(isset($_GET["p"])) {
    $page = $_GET["p"];
}

switch ($page) {
    //logout
    case 'logout':
        session_destroy();
        Header('Location: '.$_SERVER['PHP_SELF']);
        return;
        break;
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
    case 'area_reservada':
        //Verifica se houve envio de formulario
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(verificarLogin()) {
                include("layout/user.php"); 
            }
        }
        include("area_reservada.php");
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

function verificarLogin() {
    /*
    Buscar os dados do user na base de dados
        - se user não existir = login inválido
        - se user existir?
            -verificar se a senha é válida
                -se sim = cria sessão
                -se não = login inválido
    */
    $user = trim($_POST['text_user']); //trim retira todos os espaços em brancos
    $pass = trim($_POST['text_pass']);

    include 'gestor.php';
    $gestor = new Gestor();
    $params = array(
        ':user' => $user
    );
    $resul = $gestor->EXE_QUERY("SELECT * FROM users WHERE user = :user", $params);
    
    if(count($resul) == 0) {
        //Login invalido (usuario não existe no BD)
        return false;
    } else {
        //Usuario existe
        $pass_bd = $resul[0]['pass'];
        //Verificação do password
        if(password_verify($pass, $pass_bd)) {
            //Senha valida
            $_SESSION['user'] = $resul[0]['user']; 
            return true;
        } else {
            //Senha invalida
            return false;
        }
    }        
}