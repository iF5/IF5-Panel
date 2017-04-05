@extends('layouts.panel')

@section('title', 'Gest&atilde;o de prestador de servi&ccedil;os')

@section('content')
    <!-- page content -->

    <div class="right_col" role="main">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <!-- menu breadcrumb -->
                    @include('includes.breadcrumb')
                </div>

                <ul class="list-group">
                    <li class="list-group-item"><strong>Nome : </strong> {{ $provider->name }}</li>
                    <li class="list-group-item"><strong>CNPJ : </strong> {{ $provider->cnpj }}</li>
                    <li class="list-group-item"><strong>Status : </strong> {{ ($provider->status)? 'Ok' : 'Aguardando aprovação' }}</li>
                    <li class="list-group-item">
                        @if(!$provider->status && \Auth::user()->role === 'admin')
                            <a href="#"
                               class="btn btn-success btn-md modal-update" title="Aprovar"
                               data-toggle="modal"
                               data-target="#update"
                               rel="{{ route('pendency.approve', ['companyId' => $provider->companyId, 'id' => $provider->id, 'source' => 'provider']) }}"
                               rev="Tem certeza que deseja aprovar este registro?"><span
                                        class="glyphicon glyphicon-thumbs-up"></span></a>
                        @else
                            <a href="{{ route('user-provider.identify', ['id' => $provider->id]) }}"
                               class="btn btn-primary btn-md"><span
                                        class="glyphicon glyphicon-user"></span></a>

                            <a href="{{ route('employee.identify', [$provider->id]) }}"
                               class="btn btn-warning btn-md"><span
                                        class="glyphicon glyphicon-list-alt"></span></a>

                            <a href="{{ route('provider.edit', $provider->id) }}"
                               class="btn btn-success btn-md"><span
                                        class="glyphicon glyphicon-pencil"></span></a>

                            <a href="#"
                               class="btn btn-danger btn-md modal-delete" data-title="Excluir"
                               data-toggle="modal"
                               data-target="#delete"
                               rel="{{ route('provider.destroy', $provider->id) }}"><span
                                        class="glyphicon glyphicon-trash"></span></a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
