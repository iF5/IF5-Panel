@extends('layouts.panel')

@section('title', 'Gest&atilde;o de funcion&aacute;rios')

@section('content')
    <!-- page content -->

    <div class="right_col" role="main">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <!-- menu breadcrumb -->
                    @include('includes.breadcrumb')
                </div>

                <div class="col-md-6">
                    <!-- form the search -->
                    @include('includes.form-search')
                </div>

                <div class="col-md-6">
                    <a class="btn btn-success" href="{{ route('employee.create') }}"> Cadastrar novo Funcion&aacute;rio
                        +</a>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <table id="provider-table" class="table table-bordred table-striped">
                        <thead>
                        <th></th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Fun&ccedil;&atilde;o</th>
                        <th>Data de contrata&ccedil;&atilde;o</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @forelse($employees as $employee)
                            <tr @if(!$employee->status) class="line-light-red" @endif>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            <span class='glyphicon glyphicon-cog'></span> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="{{ route('employee.show', ['id' => $employee->id]) }}">Abrir</a>
                                            </li>
                                            @if($employee->status)
                                                <li>
                                                    <a href="{{ route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>1])}}">Checklist
                                                        de Documentos</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                                <td>{{ $employee->name }}</td>
                                @if($employee->status)
                                    <td>{{ $employee->cpf }}</td>
                                    <td>{{ $employee->jobRole }}</td>
                                    <td>{{ $employee->hiringDate }}</td>
                                @else
                                    <td colspan="3">
                                        Cadastro aguardando aprova&ccedil;&atilde;o
                                    </td>
                                @endif
                                <td>
                                    <a href="{{ route('employee.edit', $employee->id) }}"
                                       class="btn btn-success btn-xs"><span
                                                class="glyphicon glyphicon-pencil" title="Editar"></span></a>
                                    <a href="#"
                                       class="btn btn-danger btn-xs modal-delete" title="Excluir"
                                       data-toggle="modal"
                                       data-target="#delete"
                                       rel="{{ route('employee.destroy', $employee->id) }}"><span
                                                class="glyphicon glyphicon-trash"></span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center">Nenhum funcion&aacute;rio foi encontrado.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="clearfix"></div>
                    <!-- Paginacao -->
                    @if($keyword)
                        {!! $employees->appends(['keyword' => $keyword])->links() !!}
                    @else
                        {!! $employees->links() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
