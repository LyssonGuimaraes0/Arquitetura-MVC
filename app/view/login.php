<!DOCTYPE html>
<html lang="pt-BR">
<?php /* include_once COMPONENTS_PATH . "/head.php"; */ ?>

<body>
    <section class="login-section">
        <div class="section-container">
            <div class="container-login">
                <form method="post" class="login-form" id="form-login">
                    <div class="head-login">
                        <h1>Login</h1>
                    </div>
                    <div class="body-login">
                        <label class="error-mensagem"></label>
                        <div class="input-container">
                            <label>Usuario:</label>
                            <input type="text" placeholder="usuario" name="username" class="input-login" required>
                        </div>
                        <div class="input-container">
                            <label>Senha:</label>
                            <input type="password" placeholder="Senha" name="password" class="input-login" required>
                        </div>
                        <button type="submit" class="btn-login" >
                            <!--Animação de Login ao tentar logar-->
                            <div class="loading">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script type="module" src="public/assets/js/page/login.js"></script>
</body>

</html>