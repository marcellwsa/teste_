<!DOCTYPE html>
<html>
    <head>
        @include('templates.top')
        <title>ON TECH | Login</title>
    </head>
<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
          <div>
                <h1 class="logo-name">ON</h1>
            </div>
            <h3>Bem Vindo!</h3>
            <p>On Tech é um sistema para gerenciamento de chamados.<!--Continually expanded and constantly improved Inspinia Admin Them (IN+)--></p>
            <p>&nbsp;</p>
            <form class="m-t" role="form" action="index.html">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="E-mail" name="usuario" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Senha" name="senha" required>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>Esqueceu a senha?</small></a> //TODO
<!--                <p class="text-muted text-center"><small>Não tem uma conta ainda?</small></p>-->
<!--                <a class="btn btn-sm btn-white btn-block" href="register.html">Criar uma conta</a>-->
            </form>
            <p class="m-t">&nbsp;</p>
        </div>
    </div>

    @include('templates.scripts')

</body>
</html>