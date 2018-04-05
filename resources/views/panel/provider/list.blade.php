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

            <div class="col-md-6">
                <!-- form the search -->
                @include('includes.form-search')
            </div>

            <div class="col-md-6">
                <a class="btn btn-success" href="{{ route('provider.associate') }}">Cadastrar ou incluir novo</a>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                <table id="provider-table" class="table table-bordred table-striped">
                    <thead>
                    <th></th>
                    <th>Nome</th>
                    <th>Nome Fantasia</th>
                    <th>CNPJ</th>
                    <th>Telefone</th>
                    <th></th>
                    </thead>
                    <tbody>

                    @forelse($providers as $provider)
                        <tr @if(!$provider->status) class="line-light-red" @endif>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <span class='glyphicon glyphicon-cog'></span> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('provider.show', ['id' => $provider->id]) }}">Abrir</a>
                                        </li>
                                        @if($provider->status)
                                            <li>
                                                <a href="{{ route('checklist.provider.identify', $provider->id) }}">Checklist
                                                    de documentos</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('employee.identify', [$provider->id]) }}">Funcion&aacute;rios</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('user-provider.identify', ['id' => $provider->id]) }}">Usu&aacute;rios</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $provider->name }}</td>
                            @if($provider->status)
                                <td>{{ $provider->fantasyName }}</td>
                                <td>{{ $provider->cnpj }}</td>
                                <td>{{ $provider->phone }}</td>
                            @else
                                <td colspan="3">
                                    Cadastro aguardando aprova&ccedil;&atilde;o
                                </td>
                            @endif
                            <td>
                                @can('onlyAdmin')
                                <a href="{{ route('provider.edit', $provider->id) }}"
                                   class="btn btn-success btn-xs"><span
                                            class="glyphicon glyphicon-pencil"></span></a>
                                @endcan
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
