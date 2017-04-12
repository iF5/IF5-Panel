@extends('layouts.panel')

@section('title', 'Gest&atilde;o de usu&aacute;rio')

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
                <form action="{{ route($route . '.index') }}" method="get">
                    <div class="input-group">
                        @if($keyword)
                            <span class="input-group-addon">
                                <a href="{{ route($route . '.index') }}" title="Limpar busca">
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
                <a class="btn btn-success" href="{{ route($route . '.create') }}">Cadastrar novo usu&aacute;rio
                    +</a>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                <table id="users-table" class="table table-bordred table-striped">
                    <thead>
                    <th>Nome</th>
                    <th>Cpf</th>
                    <th>Cargo</th>
                    <th>Setor</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th></th>
                    <th></th>
                    </thead>
                    <tbody>

                    @forelse($users as $user)
                        <tr>
                            <td>
                                <a href="{{ route($route . '.show', $user->id) }}">{{ $user->name }}</a>
                            </td>
                            <td>{{ $user->cpf }}</td>
                            <td>{{ $user->jobRole }}</td>
                            <td>{{ $user->department }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route($route . '.edit', $user->id) }}"
                                   class="btn btn-success btn-xs" title="Editar"><span
                                            class="glyphicon glyphicon-pencil"></span></a>
                            </td>
                            <td>
                                <a href=""
                                   class="btn btn-danger btn-xs modal-delete" title="Excluir" data-toggle="modal"
                                   data-target="#delete" rel="{{ route($route . '.destroy', $user->id)  }}">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" align="center">Nenhum usu&aacute;rio foi encontrado.</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

                <div class="clearfix"></div>
                <!-- Paginacao -->
                @if($keyword)
                    {!! $users->appends(['keyword' => $keyword])->links() !!}
                @else
                    {!! $users->links() !!}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
