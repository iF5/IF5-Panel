@extends('layouts.panel')

@section('title', 'Gest&atilde;o de prestador de servi&ccedil;os')

@section('content')
    <!-- page content -->

    <div class="right_col" role="main">

        <div class="row">
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
                        {{ $provider->name }}
                    </h2>
                    <div class="clearfix"></div>
                </div>

                <ul class="list-group">
                    <li class="list-group-item"><strong>Nome : </strong> {{ $provider->name }}</li>
                    <li class="list-group-item"><strong>CNPJ : </strong> {{ $provider->cnpj }}</li>
                    <li class="list-group-item">
                        <a href="{{ route('provider.edit', $provider->id) }}"
                           class="btn btn-success btn-xs"><span
                                    class="glyphicon glyphicon-pencil"></span></a>

                        <a href="#"
                           class="btn btn-danger btn-xs modal-delete" data-title="Excluir"
                           data-toggle="modal"
                           data-target="#delete"
                           rel="{{ route('provider.destroy', $provider->id) }}"><span
                                    class="glyphicon glyphicon-trash"></span></a>

                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
