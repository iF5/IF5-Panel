@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form id="form-login" class="form-horizontal" role="form" method="post"
                          action="{{ route('login') }}" novalidate>
                        {{ csrf_field() }}
                        <h1>Painel IF5</h1>

                        <div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                            <input id="login" type="email" class="form-control" name="login" value="{{ old('email') }}"
                                   placeholder="Login" autofocus>
                        </div>
                        <div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                            <input id="password" type="password" class="form-control" name="password"
                                   placeholder="Senha">
                        </div>
                        <div>
                            <button class="btn btn-default submit" type="submit">Entrar</button>
                            <a class="reset_pass" href="{{ route('password-reset.index') }}">Esqueci minha
                                senha &raquo;</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <div class="clearfix"></div>

                            <div>
                                <p>&copy; 2017 direitos reservados.</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection


