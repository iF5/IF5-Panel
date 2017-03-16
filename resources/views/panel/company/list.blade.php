@extends('layouts.panel')

@section('title', 'Gest&atilde;o de empresa')

@section('content')
    <!-- page content -->

    <div class="right_col" role="main">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Empresas</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-6">
                    <form action="{{ route('company.index') }}" method="get">
                        <div class="input-group">
                            @if($keyword)
                                <span class="input-group-addon">
                                <a href="{{ route('company.index') }}" title="Limpar busca">
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
                    <a class="btn btn-success" href="{{ route('company.create') }}"> Cadastrar nova empresa +</a>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <table id="users-table" class="table table-bordred table-striped">
                        <thead>
                        <th>Nome</th>
                        <th>Cnpj</th>
                        <th>Usu&aacute;rios</th>
                        <th>Prestadores de servi&ccedil;os</th>
                        <th></th>
                        <th></th>
                        </thead>
                        <tbody>

                        @forelse($companies as $company)

                            <tr>
                                <td>
                                    <a href="{{ route('company.show', ['id' => $company->id]) }}">{{ $company->name }}</a>
                                </td>
                                <td>{{ $company->cnpj }}</td>
                                <td>
                                    <a href="{{ route('user-company.identify', $company->id) }}"
                                       class="btn btn-primary btn-xs"><span
                                                class="glyphicon glyphicon-user"></span></a>
                                    {{--
                                        <p data-placement="top" data-toggle="tooltip" title="Visualizar">
                                            <a href="{{ route('user-company.identify', $company->id) }}"
                                               class="btn btn-success btn-xs"><span
                                                        class="glyphicon glyphicon-user"></span></a>
                                        </p>
                                     --}}
                                </td>
                                <td>
                                    <a href="{{ route('provider.identify', $company->id) }}"
                                       class="btn btn-warning btn-xs"><span
                                                class="glyphicon glyphicon-hand-right"></span></a>
                                </td>
                                <td>
                                    <a href="{{ route('company.edit', $company->id) }}"
                                       class="btn btn-success btn-xs"><span
                                                class="glyphicon glyphicon-pencil"></span></a>

                                </td>
                                <td>
                                    <a href="#"
                                       class="btn btn-danger btn-xs modal-delete" data-title="Excluir"
                                       data-toggle="modal"
                                       data-target="#delete"
                                       rel="{{ route('company.destroy', $company->id) }}"><span
                                                class="glyphicon glyphicon-trash"></span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center">Nenhuma empresa foi encontrada.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    <div class="clearfix"></div>
                    <!-- Paginacao -->
                    @if($keyword)
                        {!! $companies->appends(['keyword' => $keyword])->links() !!}
                    @else
                        {!! $companies->links() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>



    <!-- /page content -->
@endsection
