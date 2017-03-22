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
                        Funcion&aacute;rios
                    </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-6">
                    <form action="{{ route('employee.index') }}" method="get">
                        <div class="input-group">
                            @if($keyword)
                                <span class="input-group-addon">
                                <a href="{{ route('employee.index') }}" title="Limpar busca">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </span>
                            @endif
                            <input class="form-control" type="text" id="keyword" name="keyword" placeholder="Buscar por"
                                   value="{{ $keyword }}" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <a class="btn btn-success" href="{{ route('employee.create') }}"> Cadastrar novo Funcion&aacute;rio
                        +</a>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <table id="provider-table" class="table table-bordred table-striped">
                        <thead>
                        <th>Nome</th>
                        <th>Cpf</th>
                        <th></th>
                        <th></th>
                        </thead>
                        <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>
                                    <a href="{{ route('employee.show', ['id' => $employee->id]) }}">
                                        {{ $employee->name }}
                                    </a>
                                </td>
                                <td>{{ $employee->cpf }}</td>
                                <td>
                                    <a href="{{ route('employee.edit', $employee->id) }}"
                                       class="btn btn-success btn-xs"><span
                                                class="glyphicon glyphicon-pencil"></span></a>

                                </td>
                                <td>
                                    <a href="#"
                                       class="btn btn-danger btn-xs modal-delete" data-title="Excluir"
                                       data-toggle="modal"
                                       data-target="#delete"
                                       rel="{{ route('employee.destroy', $employee->id) }}"><span
                                                class="glyphicon glyphicon-trash"></span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" align="center">Nenhum funcion&aacute;rio foi encontrado.</td>
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
