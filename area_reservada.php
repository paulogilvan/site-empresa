<?php if(isset($_SESSION['user'])): ?>

    <h1>Área Reservada</h1>

<?php else: ?>

    <div class="container">
        <div class="row mt-5">
            <div class="offset-3 col-6">
                <form action="?p=area_reservada" method="post">
                    <input type="text" name="text_user" placeholder="Usuário" /><br>
                    <input type="password" name="text_pass" placeholder="Senha" /><br>
                    <input type="submit" value="Entrar" />
                </form>
            </div>
        </div>
    </div>
    
<?php endif; ?>