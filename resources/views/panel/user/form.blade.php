@extends('layouts.panel')

@section('title', 'Gest&atilde;o de usu&aacute;rio')

@section('content')
        <!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <!-- menu breadcrumb -->
                    @include('includes.breadcrumb')
                </div>
                <div class="x_content">

                    <div style="padding: 10px 0px 20px 0px">
                        <strong>Atenção : </strong>todos os campos com o s&iacute;mbolo * s&atilde;o obrigat&oacute;rios.
                    </div>

                    <!-- form validate -->
                    @include('includes.form-validate')

                    <form id="user-form" method="post" action="{{ route($route, $parameters) }}">

                        {{ method_field($method) }}
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="name">Nome* :</label>
                                <input type="text" id="name" name="name" value="{{ $user->name or old('name') }}"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="cpf">CPF* :</label>
                                <input type="text" id="cpf" name="cpf" value="{{ $user->cpf or old('cpf') }}"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="jobRole">Cargo* :</label>
                                <input type="text" id="jobRole" name="jobRole" value="{{ $user->jobRole or old('jobRole') }}"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="department">Setor* :</label>
                                <input type="text" id="department" name="department" value="{{ $user->department or old('department') }}"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="phone">Telefone :</label>
                                <input type="text" id="phone" name="phone" value="{{ $user->phone or old('phone') }}"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="cellPhone">Celular* :</label>
                                <input type="text" id="cellPhone" name="cellPhone" value="{{ $user->cellPhone or old('cellPhone') }}"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="email">E-mail* :</label>
                                <input type="email" id="email" name="email"
                                       value="{{ $user->email or old('email') }}"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="password">Senha* :</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="control-group" style="margin: 20px 0px 0px 12px;">
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection
