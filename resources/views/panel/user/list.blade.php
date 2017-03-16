@extends('layouts.panel')

@section('title', 'Gest&atilde;o de usu&aacute;rio')

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
                        Usu&aacute;rios
                    </h2>
                    <div class="clearfix"></div>
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
                        <th>E-mail</th>
                        </thead>
                        <tbody>

                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <a href="{{ route($route . '.show', $user->id) }}">{{ $user->name }}</a>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a href="{{ route($route . '.edit', $user->id) }}"
                                       class="btn btn-primary btn-xs" title="Editar"><span
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
                                <td colspan="4" align="center">Nenhum usu&aacute;rio foi encontrado.</td>
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
