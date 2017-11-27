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

                    <form class="v-form" method="post" action="{{ route($route, $parameters) }}">
                        {!! method_field($method) !!}
                        {!! csrf_field() !!}

                        <div class="form-group col-xs-4">
                            <label for="name">Razão Social* :</label>
                            <input type="text" id="name" name="name" value="{{ $provider->name or old('name') }}"
                                   class="form-control v-void">
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="fantasyName">Nome Fantasia* :</label>
                            <input type="text" id="fantasyName" name="fantasyName"
                                   value="{{ $provider->fantasyName or old('fantasyName') }}"
                                   class="form-control v-void">
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="activityBranch">Ramo de Atividade* :</label>
                            <input type="text" id="activityBranch" name="activityBranch"
                                   value="{{ $provider->activityBranch or old('activityBranch') }}"
                                   class="form-control v-void">
                        </div>

                        <div class="form-group col-xs-4">
                            @if($provider->cnpjHidden)
                                <label>CNPJ* :</label>
                                <input type="text" value="{{ $provider->cnpj or old('cnpj')}}" class="form-control" disabled>
                                <input type="hidden" id="cnpj" name="cnpj" value="{{ $provider->cnpj or old('cnpj') }}">
                            @else
                                <label for="cpnj">CNPJ* : </label>
                                <input type="text" id="cnpj" name="cnpj"
                                       value="{{ $provider->cnpj or old('cnpj') }}" class="form-control v-cnpj">
                            @endif
                        </div>

                        <div class="form-group col-xs-4">
                            <label for="stateInscription">Inscrição Estadual* :</label>
                            <input type="text" id="stateInscription" name="stateInscription"
                                   value="{{ $provider->stateInscription or old('stateInscription') }}"
                                   class="form-control v-void">
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="municipalInscription">Inscrição Municipal* :</label>
                            <input type="text" id="municipalInscription" name="municipalInscription"
                                   value="{{ $provider->municipalInscription or old('municipalInscription') }}"
                                   class="form-control v-void">
                        </div>


                        <div class="form-group col-xs-4">
                            <label for="mainCnae">CNAE Principal* :</label>
                            <input type="text" id="mainCnae" name="mainCnae"
                                   value="{{ $provider->mainCnae or old('mainCnae') }}"
                                   class="typeahead form-control v-void" data-provide="typeahead" autocomplete="off">
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="phone">Telefone :</label>
                            <input type="phone" id="phone" name="phone"
                                   value="{{ $provider->phone or old('phone') }}"
                                   class="form-control v-void">
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="fax">Fax :</label>
                            <input type="fax" id="fax" name="fax" value="{{ $provider->fax or old('fax') }}"
                                   class="form-control v-void">
                        </div>


                        <div class="form-group col-xs-4">
                            <label for="cep">CEP* :</label>
                            <input type="text" id="cep" name="cep" value="{{ $provider->cep or old('cep') }}"
                                   class="form-control v-cep">
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="street">Logradouro* :</label>
                            <input type="text" id="street" name="street"
                                   value="{{ $provider->street or old('street') }}"
                                   class="form-control v-void">
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="number">Número* :</label>
                            <input type="text" id="number" name="number"
                                   value="{{ $provider->number or old('number') }}"
                                   class="form-control v-number">
                        </div>


                        <div class="form-group col-xs-4">
                            <label for="district">Bairro* :</label>
                            <input type="text" id="district" name="district"
                                   value="{{ $provider->district or old('district') }}"
                                   class="form-control v-void">
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="city">Cidade* :</label>
                            <input type="text" id="city" name="city" value="{{ $provider->city or old('city') }}"
                                   class="form-control v-void">
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="state">UF* :</label>
                            <select type="text" id="state" name="state" class="form-control">
                                @foreach($states as $key => $value)
                                    <option value="{{ $key }}"
                                            @if($provider->state === $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-xs-4">
                            <label for="responsibleName">Nome * :</label>
                            <input type="responsibleName" id="responsibleName" name="responsibleName"
                                   value="{{ $provider->responsibleName or old('responsibleName') }}"
                                   class="form-control v-void">
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="cellPhone">Celular :</label>
                            <input type="cellPhone" id="cellPhone" name="cellPhone"
                                   value="{{ $provider->cellPhone or old('cellPhone') }}"
                                   class="form-control">
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="email">E-mail * :</label>
                            <input type="text" id="email" name="email"
                                   value="{{ $provider->email or old('email') }}"
                                   class="form-control v-void">
                        </div>

                        <!-- Documents -->
                        <div class="form-group col-xs-12" style="margin-top: 15px;">
                            <div class="col-md-12">
                                <div class="panel panel-primary row">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="checkbox-on-all" value=""/>
                                                &nbsp;&nbsp;Selecione os
                                                documentos necess&aacute;rios para o prestrador de servi&ccedil;os
                                            </label>
                                        </h3>
                                    </div>
                                    <div style="width:100%; height:300px; overflow:auto;">
                                        <table class="table table-bordered table-striped">
                                            @foreach($documents as $document)
                                                <tr>
                                                    <td style="width: 5%; text-align: center;">
                                                        <input type="checkbox" value="{{$document->id}}"
                                                               class="checkbox-on-item" name="documents[]"
                                                               @if(in_array($document->id, $selectedDocuments)) checked @endif>
                                                    </td>
                                                    <td>{{$document->name}}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Documents -->

                        <div class="form-group col-xs-3">
                            <label for="startAt">Come&ccedil;ar analisar apartir de* :</label>
                            <input id="startAt" name="startAt"
                                   value="{{ $company->startAt or old('startAt') }}"
                                   class="form-control dateMask v-void">
                        </div>

                        <div class="clearfix"></div>
                        <div class="control-group" style="margin: 30px 0px 0px 12px;">
                            <button type="submit" class="btn btn-success" id="btn-provider-form">Salvar</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection