@extends('layouts.panel')

@section('title', 'Gest&atilde;o de funcion&aacute;rios')

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

                        <div style="padding: 10px 0px 20px 10px">
                            <strong>Atenção : </strong>todos os campos com o s&iacute;mbolo * s&atilde;o obrigat&oacute;rios.
                        </div>

                        @include('includes.form-validate')

                        <form method="post" action="{{ route($route, $parameters) }}">
                            <div class="row">
                                {{ method_field($method) }}
                                {{ csrf_field() }}

                                <div class="form-group col-xs-12">
                                    <h2>Dados pessoais :</h2>
                                </div>

                                <input type="hidden" name="providerId" value="{{ $employee->providerId }}">

                                <div class="form-group col-xs-4">
                                    <label for="name">Nome * :</label>
                                    <input type="text" id="name" name="name"
                                           value="{{ $employee->name or old('name') }}"
                                           class="form-control" required>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label for="cpf">CPF * : </label>
                                    <input type="text" id="cpf" name="cpf"
                                           value="{{ $employee->cpf or old('cpf') }}" class="form-control" required>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label for="rg">RG * : </label>
                                    <input type="text" id="rg" name="rg"
                                           value="{{ $employee->rg or old('rg') }}" class="form-control" required>
                                </div>

                                <div class="form-group col-xs-4">
                                    <label for="ctps">CTPS Número * : </label>
                                    <input type="text" id="ctps" name="ctps"
                                           value="{{ $employee->ctps or old('ctps') }}" class="form-control" required>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label for="birthDate">Data de nascimento * : </label>
                                    <input type="text" id="birthDate" name="birthDate"
                                           value="{{ $employee->birthDate or old('birthDate') }}"
                                           class="form-control dateMask"
                                           required>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label for="street">Endereço * : </label>
                                    <input type="text" id="street" name="street"
                                           value="{{ $employee->street or old('street') }}" class="form-control"
                                           required>
                                </div>

                                <div class="form-group col-xs-4">
                                    <label for="district">Bairro * : </label>
                                    <input type="text" id="district" name="district"
                                           value="{{ $employee->district or old('district') }}" class="form-control"
                                           required>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label for="city">Cidade * : </label>
                                    <input type="text" id="city" name="city"
                                           value="{{ $employee->city or old('city') }}" class="form-control" required>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label for="state">Estado * : </label>
                                    <select type="text" id="state" name="state" class="form-control">
                                        @foreach($states as $key => $value)
                                            <option value="{{ $key }}"
                                                    @if($employee->state === $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-xs-12">
                                    <h2>Dados profissionais :</h2>
                                </div>

                                <div class="form-group col-xs-4">
                                    <label for="jobRole">Função * : </label>
                                    <input type="text" id="jobRole" name="jobRole"
                                           value="{{ $employee->jobRole or old('jobRole') }}" class="form-control"
                                           required>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label for="salaryCap">Piso salarial * : </label>
                                    <input type="text" id="salaryCap" name="salaryCap"
                                           value="{{ $employee->salaryCap or old('salaryCap') }}"
                                           class="form-control moneyMask"
                                           required>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label for="hiringDate">Data contratação * : </label>
                                    <input type="text" id="hiringDate" name="hiringDate"
                                           value="{{ $employee->hiringDate or old('hiringDate') }}"
                                           class="form-control dateMask" required>
                                </div>

                                <div class="form-group col-xs-4">
                                    <label for="endingDate">Data da rescisão * : </label>
                                    <input type="text" id="endingDate" name="endingDate"
                                           value="{{ $employee->endingDate or old('endingDate') }}"
                                           class="form-control dateMask">
                                </div>
                                <div class="form-group col-xs-4">
                                    <label for="pis">Número do PIS * : </label>
                                    <input type="text" id="pis" name="pis"
                                           value="{{ $employee->pis or old('pis') }}" class="form-control" required>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label for="workingHours">Jornada de trabalho * : </label>
                                    <select id="workingHours" name="workingHours" class="form-control">
                                        @foreach($employee->allWorkingHours() as $workingHours)
                                            <option value="{{ $workingHours }}"
                                                    @if($workingHours === $employee->workingHours) selected @endif>{{ $workingHours }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-xs-4">
                                    <label for="workRegime">Regime de trabalho * : </label>
                                    <select id="workRegime" name="workRegime" class="form-control">
                                        @foreach($employee->allWorkRegime() as $workRegime)
                                            <option value="{{ $workRegime }}"
                                                    @if($workRegime === $employee->workRegime) selected @endif>{{ $workRegime }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label>Filhos menores * : </label>
                                    <div>
                                        <div class="radio-inline">
                                            <label><input type="radio" name="hasChildren" value="1">Sim</label>
                                        </div>
                                        <div class="radio-inline">
                                            <label><input type="radio" name="hasChildren"
                                                          checked="checked" value="0">N&atilde;o</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-xs-4">
                                    <label for="companies">Empresas alocadas * : </label>
                                    <select id="companies" name="companies[]" size="{{ count($companies) }}"
                                            class="form-control" multiple>
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