@extends('layouts.panel')

@section('title', 'Gest&atilde;o de empresa')

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
                            {{ ($method === 'PUT')? 'Editar' : 'Cadastrar' }}
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div style="padding: 10px 0px 20px 10px">
                            <strong>Atenção : </strong>todos os campos com o s&iacute;mbolo * s&atilde;o obrigat&oacute;rios.
                        </div>

                        @if( Session::has('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <p>
                                    {!! Session::get('success') !!}
                                </p>
                                <p>
                                    <a href="{{ route('company.show', ['id' => Session::get('id')]) }}"
                                       class="btn btn-default">
                                        Clique aqui para visualizar
                                    </a>
                                </p>

                            </div>
                        @endif
                        @if( isset($errors) && count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form id="company-form" method="post" action="{{ route($route, $parameters) }}">

                            {{ method_field($method) }}
                            {{ csrf_field() }}

                            <div class="form-group col-xs-4">
                                <label for="name">Nome* :</label>
                                <input type="text" id="name" name="name" value="{{ $company->name or old('name') }}"
                                       class="form-control" required>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="cpnj">CNPJ* :</label>
                                <input type="text" id="cnpj" name="cnpj" value="{{ $company->cnpj or old('cnpj') }}"
                                       class="form-control" required>
                            </div>

                            <div class="clearfix"></div>
                            <div class="control-group" style="margin: 30px 0px 0px 12px;">
                                <button type="submit" class="btn btn-success">Salvar</button>
                                {{--
                                <a href="{{ route('company.index') }}"
                                   class="btn btn-primary">Cancelar</a>
                                --}}
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /page content -->
@endsection