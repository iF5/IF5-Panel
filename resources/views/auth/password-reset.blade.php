@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form class="form-horizontal" role="form" method="post" action="{{ route('password-reset.check') }}">
                        {{ csrf_field() }}
                        <h1>Painel IF5</h1>

                        <div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                            <input id="email" type="email" class="form-control" name="email" value=""
                                   placeholder="Digite seu e-mail cadastrado" required autofocus>
                        </div>
                        <div>
                            <button class="btn btn-default submit" type="submit">Enviar</button>
                            <a class="reset_pass" href="{{ route('login') }}">&laquo; Voltar</a>
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


