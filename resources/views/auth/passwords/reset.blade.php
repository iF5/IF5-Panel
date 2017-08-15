@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form id="form-password-reset" class="form-horizontal" method="post"
                          action="{{ route('password-reset.update') }}" novalidate>
                        {{ csrf_field() }}
                        <h1>Painel IF5</h1>

                        <div class="control-group">
                            <span class="help-block" id="flash-message">
                                @if (\Session::has('message'))
                                    <p class="{{ (\Session::get('success'))? 'text-success': 'text-danger' }}">
                                        {{ \Session::get('message') }}
                                    </p>
                                @endif
                            </span>

                            <input type="hidden" name="token" value="{{$token}}">
                            <input id="password" type="password" class="form-control" name="password" value=""
                                   placeholder="Digite sua nova senha">
                        </div>
                        <div class="control-group">
                            <input id="passwordConfirm" type="password" class="form-control" name="passwordConfirm"
                                   value=""
                                   placeholder="Confirme sua nova senha">
                        </div>

                        <div class="control-group" style="margin: 20px 0px;">
                            <button class="btn btn-default submit" type="submit">Enviar</button>
                        </div>
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


