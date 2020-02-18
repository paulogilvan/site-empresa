<?php
// Validação do formulário newsletter
// $_SERVER / Verifica no servidor se a variavel global method="POST" do formulário existe.
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if($_POST['formulario'] == 'email') {
        $erro = '';

        // Verifica se existe todos os campos
        if(!isset($_POST['email'])||
        !isset($_POST['assunto'])||
        !isset($_POST['msg'])) {
            
            $erro = 'Pelo menos um dos campos não existe';
        }

        // Ver se os campos estão preenchidos
        $email = $_POST['email'];
        $assunto = $_POST['assunto'];
        $msg = $_POST['msg'];
        
        if(empty($erro)) {
        // Ver se o email é válido
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erro = 'Endereço de email errado.';
            }
        }

        // Envio de email gmail
        if(empty($erro)) {
            
            include('enviar_email.php');
        } 

    }

    if($_POST['formulario'] == 'newsletter') {
        
        //Verifica se existe campo email 
        if(!isset($_POST['email'])) {
            $erro = 'Campo não foi preenchido!'; 
        }

        // Ver se o email é válido
        $email = $_POST['email'];
        
        if(empty($erro)) {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erro = 'Endereço de email errado.';
            }
        }
                     
        include 'gestor.php';
        $gestor = new Gestor();

        $params = array(':email' => $email);

        $gestor->EXE_NON_QUERY('INSERT INTO emails(email) VALUES(:email)', $params);
    }

    
}
?>

<h1>Formulário de Contatos</h1>

<form action="?p=contatos" method="post">
    <input type="hidden" name="formulario" value="email" />
    <input type="email" name="email" placeholder="Email" required /><br>
    <input type="text" name="assunto" placeholder="Assunto" required /><br>
    <textarea name="msg" cols="60" rows="3" required></textarea><br>
    <input type="submit" value="Enviar Mensagem" />
</form>

<form action="?p=contatos" method="post" class="separador">
    <input type="hidden" name="formulario" value="newsletter" />
    <input type="email" name="email" placeholder="Email" required /><br>
    <input type="submit" value="Receber newsletter" />
</form>

<?php if(!empty($erro)): ?>
    <div style="color: red;"><?php echo $erro; ?></div>
<?php endif; ?>