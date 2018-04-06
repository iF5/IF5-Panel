@extends('layouts.panel')

@section('title', 'Gest&atilde;o de documentos')

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
                <li class="list-group-item"><strong>Nome : </strong> {{ $document->name }}</li>
                <li class="list-group-item">
                    <strong>Validade: </strong>{{ $document->validity }} {{ ((int) $document->validity > 1) ? 'dias' : 'dia' }}
                </li>
                <li class="list-group-item"><strong>Tipo de documento: </strong> {{ $documentType->name }}</li>
                <li class="list-group-item">
                    <strong>Periodicidade: </strong> {{ $periodicities[$document->periodicity] }}</li>
                <li class="list-group-item">
                    <strong>Status: </strong> {{ $status[$document->isActive] }}</li>
                <li class="list-group-item"><strong>Cadastrado em
                        : </strong> {{ Period::format($document->createdAt, 'd/m/Y H:i') }}
                </li>
                <li class="list-group-item"><strong>&Uacute;ltima atualiza&ccedil;&atilde;o
                        : </strong> {{ Period::format($document->updatedAt, 'd/m/Y H:i') }}
                </li>
                <li class="list-group-item">
                    <a href="{{ route($route . 'edit', $document->id) }}"
                       class="btn btn-success btn-md" title="Editar"><span
                                class="glyphicon glyphicon-pencil"></span></a>
                    <a href="#"
                       class="btn btn-danger btn-md modal-delete" title="Excluir"
                       data-toggle="modal"
                       data-target="#delete"
                       rel="{{ route($route . 'destroy', $document->id) }}"><span
                                class="glyphicon glyphicon-trash"></span></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
