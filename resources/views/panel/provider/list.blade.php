@extends('layouts.panel')

@section('title', 'Gest&atilde;o de prestadores de servi&ccedil;os')

@section('content')
    <!-- page content -->

    <div class="right_col" role="main">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        Gest&atilde;o de
                        <span class="text-primary">prestadores de servi&ccedil;os</span>
                    </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-6">
                    <form action="{{ route('provider.index') }}" method="get">
                        <div class="input-group">
                            <input class="form-control" id="system-search" name="q" placeholder="Buscar por" required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <a class="btn btn-success" href="{{ route('provider.create') }}"> Cadastrar novo prestador +</a>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <table id="users-table" class="table table-bordred table-striped">
                        <thead>
                        <th>Nome</th>
                        <th>Cnpj</th>
                        <th>Usu&aacute;rios</th>
                        </thead>
                        <tbody>

                        @forelse($providers as $provider)
                            <tr>
                                <td>{{ $provider->name }}</td>
                                <td>{{ $provider->cnpj }}</td>
                                <td>
                                    <a href="{{ route('user-provider.identify', [$provider->companyId, $provider->id]) }}"
                                       class="btn btn-primary btn-xs"><span
                                                class="glyphicon glyphicon-user"></span></a>
                                </td>
                                <td>
                                    <a href="{{ route('provider.edit', $provider->id) }}"
                                       class="btn btn-success btn-xs"><span
                                                class="glyphicon glyphicon-pencil"></span></a>

                                </td>
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
                    {!! $providers->links() !!}

                </div>
            </div>
        </div>
    </div>



    <!-- /page content -->
@endsection
