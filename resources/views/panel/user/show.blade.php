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

                <ul class="list-group">
                    <li class="list-group-item"><strong>Nome : </strong> {{ $user->name }}</li>
                    <li class="list-group-item"><strong>E-mail : </strong> {{ $user->email }}</li>
                    <li class="list-group-item"><strong>Cpf : </strong> {{ $user->cpf }}</li>
                    <li class="list-group-item"><strong>Cargo : </strong> {{ $user->jobRole }}</li>
                    <li class="list-group-item"><strong>Setor : </strong> {{ $user->department }}</li>
                    <li class="list-group-item"><strong>Telefone : </strong> {{ $user->phoneNumber }}</li>
                    <li class="list-group-item"><strong>Celular : </strong> {{ $user->cellPhoneNumber }}</li>

                    <li class="list-group-item">
                        @if($routePrefix === 'profile')
                            <a href="{{ route('profile.edit') }}"
                               class="btn btn-success btn-md" title="Editar"><span
                                        class="glyphicon glyphicon-pencil"></span>
                            </a>

                            <a href="{{ route('profile.image') }}"
                               class="btn btn-primary btn-md" title="Minha Foto"><span
                                        class="glyphicon glyphicon-picture"></span>
                            </a>
                        @else
                            <a href="{{ route( $routePrefix . '.edit', $user->id) }}"
                               class="btn btn-success btn-md" title="Editar"><span
                                        class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <a href="#"
                               class="btn btn-danger btn-md modal-delete"
                               data-toggle="modal" data-target="#delete" title="Excluir"
                               rel="{{ route($routePrefix . '.destroy', $user->id) }}"><span
                                        class="glyphicon glyphicon-trash"></span>
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
