@extends('layouts.panel')

@section('title', 'Gest&atilde;o de funcion&aacute;rios')

@section('content')
        <!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <a href="{{ route('company.index') }}">
                            <span class="text-primary">Empresas</span>
                        </a>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <a href="{{ route('provider.index') }}">
                            <span class="text-primary">Prestadores de servi&ccedil;os</span>
                        </a>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <a href="{{ route('employee.index') }}">
                            <span class="text-primary">Funcion&aacute;rios</span>
                        </a>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        {{ ($method === 'PUT')? 'Editar' : 'Cadastrar' }}
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div style="padding: 10px 0px 20px 10px">
                        <strong>Atenção : </strong>todos os campos com o s&iacute;mbolo * s&atilde;o obrigat&oacute;rios.
                    </div>

                    @include('includes.form-validate')

                    <form method="post" action="{{ route($route, $parameters) }}">
                        <div class="row">
                            {{ method_field($method) }}
                            {{ csrf_field() }}

                            <input type="hidden" name="providerId" value="{{ $employee->providerId }}">

                            <div class="form-group col-xs-4">
                                <label for="name">Nome* :</label>
                                <input type="text" id="name" name="name"
                                       value="{{ $employee->name or old('name') }}"
                                       class="form-control" required>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="cpf">CPF* : </label>
                                <input type="text" id="cpf" name="cpf"
                                       value="{{ $employee->cpf or old('cpf') }}" class="form-control" required>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-xs-6">
                                <label for="companies">Empresas : </label>
                                <select class="form-control" id="companies" name="companies[]" size="{{ count($companies) }}" multiple>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}"
                                                @if($company->companyId && $method = 'PUT') selected @endif>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="control-group col-xs-4" style="margin-top: 30px;">
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