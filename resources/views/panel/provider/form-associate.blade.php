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

                        @include('includes.form-validate')

                        @if($success)
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <p>Inclus&atilde;o realizada com sucesso!</p>
                            </div>
                        @endif

                        <form class="form-inline" method="post" action="{{ route('provider.associate') }}">
                            {{ method_field('POST') }}
                            {{ csrf_field() }}
                            <input type="hidden" name="action" value="search"/>
                            <div class="input-group">
                                <span class="input-group-addon">Digite o CNPJ
                            </span>
                                <input type="text" id="cnpj" name="cnpj" value="{{ $cnpj }}" class="form-control"
                                       required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default" id="form-provider-associate"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                            </div>
                        </form>

                        @if($search and $provider)
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Nome : </strong> {{ $provider->name }}</li>
                                <li class="list-group-item"><strong>CNPJ : </strong> {{ $provider->cnpj }}</li>
                                <li class="list-group-item">
                                    <form method="post" action="{{ route('provider.associate') }}">
                                        {{ method_field('POST') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" name="action" value="associate"/>
                                        <input type="hidden" name="providerId" value="{{ $provider->id }}"/>
                                        <button type="submit" class="btn btn-warning btn-ms">Incluir agora</button>
                                    </form>
                                </li>
                            </ul>
                        @endif

                        @if($search and !$provider)
                            <ul class="list-group">
                                <li class="list-group-item">
                                    Este prestador de serviços <strong>{{ $cnpj }}</strong> está disponivél para
                                    cadastro.
                                </li>
                                <li class="list-group-item">
                                    <a href="{{ url('/provider/create') }}"
                                       class="btn btn-success btn-ms">Cadastrar Agora</a>
                                </li>
                            </ul>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection