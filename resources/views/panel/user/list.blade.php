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
                <!-- form the search -->
                @include('includes.form-search')
            </div>

            <div class="col-md-6">
                <a class="btn btn-success" href="{{ route($route . '.create') }}">Cadastrar novo usu&aacute;rio
                    +</a>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                <table id="users-table" class="table table-bordred table-striped">
                    <thead>
                    <th></th>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Setor</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th></th>
                    </thead>
                    <tbody>

                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <span class='glyphicon glyphicon-cog'></span> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route($route . '.show', $user->id) }}">Abrir</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->jobRole }}</td>
                            <td>{{ $user->department }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route($route . '.edit', $user->id) }}"
                                   class="btn btn-success btn-xs" title="Editar"><span
                                            class="glyphicon glyphicon-pencil"></span></a>

                                <a href=""
                                   class="btn btn-danger btn-xs modal-delete" title="Excluir" data-toggle="modal"
                                   data-target="#delete" rel="{{ route($route . '.destroy', $user->id)  }}">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" align="center">Nenhum usu&aacute;rio foi encontrado.</td>
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
