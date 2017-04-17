@extends('layouts.panel')

@section('title', 'Gest&atilde;o de prestador de servi&ccedil;os')

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

                        <form id="provider-form" method="post" action="{{ route($route, $parameters) }}">

                            {{ method_field($method) }}
                            {{ csrf_field() }}

                            <div class="form-group col-xs-4">
                                <label for="name">Nome* :</label>
                                <input type="text" id="name" name="name" value="{{ $provider->name or old('name') }}"
                                       class="form-control" required>
                            </div>
                            <div class="form-group col-xs-4">
                                @if(isset($provider->cnpjHidden))
                                    <label>CNPJ* :</label>
                                    {{ $provider->cnpj }}
                                    <input type="hidden" name="cnpj" value="{{ $provider->cnpj }}">
                                @else
                                    <label for="cpnj">CNPJ* : </label>
                                    <input type="text" id="cnpj" name="cnpj"
                                           value="{{ $provider->cnpj or old('cnpj') }}" class="form-control" required>
                                @endif
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="stateInscription">Inscrição Estadual* :</label>
                                <input type="text" id="stateInscription" name="stateInscription" value="{{ $provider->stateInscription or old('stateInscription') }}"
                                       class="form-control" required>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="municipalInscription">Inscrição Municipal* :</label>
                                <input type="text" id="municipalInscription" name="municipalInscription" value="{{ $provider->municipalInscription or old('municipalInscription') }}"
                                       class="form-control" required>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="mainCnae">CNAE Principal* :</label>
                                <input type="text" id="mainCnae" name="mainCnae" value="{{ $provider->mainCnae or old('mainCnae') }}"
                                       class="form-control" required>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="activityBranch">Ramo de Atividade* :</label>
                                <input type="text" id="activityBranch" name="activityBranch" value="{{ $provider->activityBranch or old('activityBranch') }}"
                                       class="form-control" required>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="cep">CEP* :</label>
                                <input type="text" id="cep" name="cep" value="{{ $provider->cep or old('cep') }}"
                                       class="form-control" required>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="number">Número* :</label>
                                <input type="text" id="number" name="number" value="{{ $provider->number or old('number') }}"
                                       class="form-control" required>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="addressComplement">Complemento* :</label>
                                <input type="text" id="addressComplement" name="addressComplement" value="{{ $provider->addressComplement or old('addressComplement') }}"
                                       class="form-control" required>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="phone">Telefone* :</label>
                                <input type="phone" id="phone" name="phone" value="{{ $provider->phone or old('phone') }}"
                                       class="form-control" required>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="fax">Fax :</label>
                                <input type="fax" id="fax" name="fax" value="{{ $provider->fax or old('fax') }}"
                                       class="form-control">
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="email">E-mail* :</label>
                                <input type="email" id="email" name="email" value="{{ $provider->email or old('email') }}"
                                       class="form-control" required>
                            </div>
                            <div class="clearfix"></div>
                            <div class="control-group" style="margin: 30px 0px 0px 12px;">
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection