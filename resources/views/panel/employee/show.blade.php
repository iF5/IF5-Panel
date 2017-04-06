@extends('layouts.panel')

@section('title', 'Gest&atilde;o de funcion&aacute;rios')

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
                        <a href="{{ route('employee.index') }}">
                            <span class="text-primary">Funcion&aacute;rios</span>
                        </a>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        {{ $employee->name }}
                    </h2>
                    <div class="clearfix"></div>
                </div>

                <ul class="list-group">
                    <li class="list-group-item"><strong>Nome : </strong> {{ $employee->name }}</li>
                    <li class="list-group-item"><strong>CPF : </strong> {{ $employee->cpf }}</li>

                    <li class="list-group-item">
                        @if(!$employee->status && \Auth::user()->role === 'admin')
                            <a href="#"
                               class="btn btn-success btn-md modal-update" title="Aprovar"
                               data-toggle="modal"
                               data-target="#update"
                               rel="{{ route('pendency.approve', ['companyId' => 0, 'id' => $employee->id, 'source' => 'employee']) }}"
                               rev="Tem certeza que deseja aprovar este registro?"><span
                                        class="glyphicon glyphicon-thumbs-up"></span></a>
                        @else
                            <a href="{{ route('employee.edit', $employee->id) }}"
                               class="btn btn-success btn-md"><span
                                        class="glyphicon glyphicon-pencil"></span></a>

                            <a href="#"
                               class="btn btn-danger btn-md modal-delete" data-title="Excluir"
                               data-toggle="modal"
                               data-target="#delete"
                               rel="{{ route('employee.destroy', $employee->id) }}"><span
                                        class="glyphicon glyphicon-trash"></span></a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
