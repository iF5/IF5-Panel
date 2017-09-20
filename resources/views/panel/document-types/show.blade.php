@extends('layouts.panel')

@section('title', 'Gest&atilde;o de tipos de documentos')

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
                <li class="list-group-item"><strong>Nome : </strong> {{ $documentType->name }}</li>
                <li class="list-group-item"><strong>Cadastrado em
                        : </strong> {{ \Carbon\Carbon::parse($documentType->createdAt)->format('d/m/Y H:i:s') }}</li>
                <li class="list-group-item"><strong>&Uacute;ltima atualiza&ccedil;&atilde;o
                        : </strong> {{ \Carbon\Carbon::parse($documentType->updatedAt)->format('d/m/Y H:i:s') }}</li>
                <li class="list-group-item">
                    <a href="{{ route('document-types.edit', $documentType->id) }}"
                       class="btn btn-success btn-md" title="Editar"><span
                                class="glyphicon glyphicon-pencil"></span></a>
                    <a href="#"
                       class="btn btn-danger btn-md modal-delete" title="Excluir"
                       data-toggle="modal"
                       data-target="#delete"
                       rel="{{ route('document-types.destroy', $documentType->id) }}"><span
                                class="glyphicon glyphicon-trash"></span></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
