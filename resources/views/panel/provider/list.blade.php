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
                        Prestadores de servi&ccedil;os
                    </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-6">
                    <form action="{{ route('provider.index') }}" method="get">
                        <div class="input-group">
                            @if($keyword)
                                <span class="input-group-addon">
                                <a href="{{ route('provider.index') }}" title="Limpar busca">
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
                    <a class="btn btn-success" href="{{ route('provider.associate') }}"> Cadastrar ou Incluir novo
                        Prestador +</a>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <table id="provider-table" class="table table-bordred table-striped">
                        <thead>
                        <th>Nome</th>
                        <th>Cnpj</th>
                        <th>Usu&aacute;rios</th>
                        <th>Funcion&aacute;rios</th>
                        @can('onlyAdmin')
                            <th></th>
                        @endcan
                        <th></th>
                        </thead>
                        <tbody>

                        @forelse($providers as $provider)
                            <tr>
                                <td>
                                    <a href="{{ route('provider.show', ['id' => $provider->id]) }}">{{ $provider->name }}</a>
                                </td>
                                <td>{{ $provider->cnpj }}</td>
                                <td>
                                    <a href="{{ route('user-provider.identify', [0, $provider->id]) }}"
                                       class="btn btn-primary btn-xs"><span
                                                class="glyphicon glyphicon-user"></span></a>
                                </td>
                                <td>
                                    <a href="{{ route('employee.identify', [$provider->id]) }}"
                                       class="btn btn-warning btn-xs"><span
                                                class="glyphicon glyphicon-list-alt"></span></a>

                                </td>
                                @can('onlyAdmin')
                                    <td>
                                        <a href="{{ route('provider.edit', $provider->id) }}"
                                           class="btn btn-success btn-xs"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>

                                    </td>
                                @endcan
                                <td>
                                    <a href="#"
                                       class="btn btn-danger btn-xs modal-delete" data-title="Excluir"
                                       data-toggle="modal"
                                       data-target="#delete"
                                       rel="{{ route('provider.destroy', $provider->id) }}"><span
                                                class="glyphicon glyphicon-trash"></span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" align="center">Nenhum prestador de servi&ccedil;o foi encontrado.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    <div class="clearfix"></div>
                    <!-- Paginacao -->
                    @if($keyword)
                        {!! $providers->appends(['keyword' => $keyword])->links() !!}
                    @else
                        {!! $providers->links() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>



    <!-- /page content -->
@endsection
