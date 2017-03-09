@extends('layouts.panel')

@section('title', 'Gest&atilde;o de usu&aacute;rios')

@section('content')
    <!-- page content -->

    <div class="right_col" role="main">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Gest&atilde;o de
                        <span class="text-primary">usu&aacute;rios</span>
                    </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-6">
                    <form action="{{ route($route . '.index') }}" method="get">
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
                                    <p data-placement="top" data-toggle="tooltip" title="Editar">
                                        <a href="{{ route($route . '.edit', $user->id) }}"
                                           class="btn btn-primary btn-xs"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>
                                    </p>
                                </td>
                                <td>
                                    <p data-placement="top" data-toggle="tooltip" title="Excluir">
                                        <a href=""
                                           class="btn btn-danger btn-xs modal-delete" data-title="Excluir"
                                           data-toggle="modal"
                                           data-target="#delete"
                                           rel="{{ route($route . '.destroy', $user->id)  }}"><span
                                                    class="glyphicon glyphicon-trash"></span></a>
                                    </p>
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
                {!! $users->links() !!}
                <!--
                        <ul class="pagination pull-right">
                            <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a>
                            </li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
                        </ul>
                        -->
                </div>
            </div>
        </div>
    </div>
@endsection
