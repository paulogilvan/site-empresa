<?php
$erro_newsletter = '';
$sucesso_newsletter = '';
// Validação do formulário newsletter
// $_SERVER / Verifica no servidor se a variavel global method="POST" do formulário existe.
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Formulario de Email
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
    
    //Formulario de Newsletter
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

        //Verificar se o email existe no banco de dados
        $resultado = $gestor->EXE_QUERY("SELECT email FROM emails WHERE email = :email", $params);
        if(count($resultado) != 0) {
            //Resultado ja existe
            $erro_newsletter = 'O email já esta registrado!';
        } else {
            //Inserir novo email no banco de dados
             $gestor->EXE_NON_QUERY('INSERT INTO emails(email) VALUES(:email)', $params);
             $sucesso_newsletter = 'Obrigado por ter registrado o seu email!';
        }        
        
    }
    
}
?>
<!--Mensagem alerta se ja existe ou não email, aparecerá no topo-->
<div class="container">
    <div class="row">
        <div class="offset-3 col-6 text-center mt-2">
            <?php if(!empty($erro_newsletter)): ?>
                <div class="alert alert-danger">
                    <?php echo $erro_newsletter; ?>
                </div>
            <?php endif; ?>
            <?php if(!empty($sucesso_newsletter)): ?>
                <div class="alert alert-success">
                    <?php echo $sucesso_newsletter; ?>
                </div>
            <?php endif; ?>
        </div>  
    </div>
</div>

<div class="container">
    <div class="row mt-5 mb-3">
        <div class="offset-3 col-6">
            <h1>Formulário de Contatos</h1>
            <form action="?p=contatos" method="post">
                <input type="hidden" name="formulario" value="email" />
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required />
                </div>
                <div class="form-group">
                    <input type="text" name="assunto" class="form-control" placeholder="Assunto" required />
                </div>
                <div class="form-group">
                    <textarea name="msg" cols="60" rows="3" class="form-control" required></textarea>
                </div>
                <div class="text-center">
                    <input type="submit" value="Enviar Mensagem" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>
    
    <div style="margin-top: 200px">
        <div class="offset-3 col-6">
            <h1 class="text-center">Newsletter</h1>
            <form action="?p=contatos" method="post">
                <input type="hidden" name="formulario" value="newsletter" />
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required />
                </div>
                <div class="text-center">
                    <input type="submit" value="Receber Newsletter" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>
</div>

<?php if(!empty($erro)): ?>
    <div style="color: red;"><?php echo $erro; ?></div>
<?php endif; ?>