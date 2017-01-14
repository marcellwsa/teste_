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
            <form class="m-t" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-2 control-label">E-Mail</label>

                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('login'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                </div>
                <div class="form-group{{ $errors->has('senha') ? ' has-error' : '' }}">
                    <label for="senha" class="col-md-2 control-label">Senha</label>

                    <div class="col-md-10">
                        <input id="senha" type="password" class="form-control" name="senha" required>

                        @if ($errors->has('senha'))
                            <span class="help-block">
                                <strong>{{ $errors->first('senha') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>Esqueceu a senha?</small></a> //TODO<br>
                <?php $users = Illuminate\Support\Facades\DB::table('users')->get(); 
                if (count($users) < 1) {
                    echo "<a href=\""; ?> 
                    {{ url('/register') }}
                    <?php
                    echo "\"><small>Primeiro acesso?</small></a>";
                }
                ?>
<!--                <p class="text-muted text-center"><small>Não tem uma conta ainda?</small></p>-->
<!--                <a class="btn btn-sm btn-white btn-block" href="register.html">Criar uma conta</a>-->
            </form>
            <p class="m-t">&nbsp;</p>
        </div>
    </div>

    @include('templates.scripts')

</body>
</html>