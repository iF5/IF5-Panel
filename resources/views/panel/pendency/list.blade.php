@extends('layouts.panel')

@section('title', 'Gest&atilde;o de pend&ecirc;ncias')

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
                <form action="{{ route('pendency.index') }}" method="get">
                    <div class="input-group">
                        @if($keyword)
                            <span class="input-group-addon">
                                <a href="{{ route('pendency.index') }}" title="Limpar busca">
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

            <div class="col-md-6"></div>

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
                        <tr @if(!$provider->status) class="line-light-red" @endif>
                            <td>
                                <a href="{{ route('provider.show', ['id' => $provider->id]) }}">{{ $provider->name }}</a>
                            </td>
                            <td>{{ $provider->cnpj }}</td>
                            @if(!$provider->status)
                                <td colspan="4">
                                    Cadastro aguardando aprova&ccedil;&atilde;o
                                </td>
                            @else
                                <td>
                                    <a href="{{ route('user-provider.identify', ['id' => $provider->id]) }}"
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
                            @endif

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" align="center">Nenhum prestador de servi&ccedil;o foi encontrado.</td>
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
