@extends('layouts.panel')

@section('title', 'Gest&atilde;o de usu&aacute;rios')

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
                        <a href="{{ route($routePrefix . '.index') }}">
                            <span class="text-primary">Usu&aacute;rios</span>
                        </a>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        {{ $user->name }}
                    </h2>
                    <div class="clearfix"></div>
                </div>

                <ul class="list-group">
                    <li class="list-group-item"><strong>Nome : </strong> {{ $user->name }}</li>
                    <li class="list-group-item"><strong>E-mail : </strong> {{ $user->email }}</li>
                    <li class="list-group-item">
                        <a href="{{ route( $routePrefix . '.edit', $user->id) }}"
                           class="btn btn-success btn-xs"><span
                                    class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="#"
                           class="btn btn-danger btn-xs modal-delete"
                           data-toggle="modal" data-target="#delete"
                           rel="{{ route($routePrefix . '.destroy', $user->id) }}"><span
                                    class="glyphicon glyphicon-trash"></span>
                        </a>

                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
