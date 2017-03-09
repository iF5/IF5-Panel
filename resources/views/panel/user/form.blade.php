@extends('layouts.panel')

@section('title', 'Gest&atilde;o de usu&aacute;rios')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            <a href="{{ route($routePrefix .'.index') }}" title="Voltar">
                                <span class="glyphicon glyphicon-circle-arrow-left"></span>
                            </a>
                            Gest&atilde;o de
                            <span class="text-primary">usu&aacute;rios</span>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br/>
                        <form id="company-form" method="post" action="{{ route($route, $parameters) }}"
                              data-parsley-validate class="form-horizontal form-label-left">

                            {{ method_field($method) }}
                            {{ csrf_field() }}

                            <table style="width: 100%;" border="0">
                                <tr>
                                    <td>
                                        {!! Session::has('success') ? Session::get("success") : '' !!}
                                        <div class="control-group">
                                            <label class="control-label" for="name">Nome *</label>
                                            <div class="controls">
                                                <input id="name" name="name" value="{{ $user->name }}" type="text"
                                                       placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="email">E-mail *</label>
                                            <div class="controls">
                                                <input id="email" name="email" value="{{ $user->email }}" type="email"
                                                       placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="password">Senha *</label>
                                            <div class="controls">
                                                <input id="password" name="password" value=""
                                                       type="password"
                                                       placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="password">Ter todas as
                                                permissões? </label>
                                            <div class="controls">
                                                <input id="isAllPrivileges" name="isAllPrivileges" type="checkbox"
                                                       {{ $user->isAllPrivileges ? 'checked' : '' }} class="checkbox">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 100px;">
                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" class="btn btn-success">Salvar</button>
                                                <button class="btn btn-primary" type="reset">Limpar</button>
                                                <a href="{{ route($routePrefix .'.index') }}"
                                                   class="btn btn-primary">Cancelar</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </table>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /page content -->
@endsection