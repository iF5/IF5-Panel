@extends('layouts.panel')

@section('title', 'Checklist de documentos')

@section('content')
        <!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <!-- menu breadcrumb -->
                @include('includes.breadcrumb')
            </div>

            <div class="col-md-12">
                <div class="row">
                    <object data="{{ $pdf }}" type="application/pdf" width="100%" height="800px">
                        <embed src="{{ $pdf }}" type="application/pdf" width="100%" height="800px"></embed>
                    </object>
                </div>
                <ul class="list-group" style="margin: 40px 0;">
                    <li class="list-group-item"><strong>Status : </strong> {{ $status[$document->status] }}</li>
                    <li class="list-group-item"><strong>Arquivo : </strong> {{ $document->originalFileName }}</li>
                    <li class="list-group-item">
                        <strong>Enviado em : </strong> {{ Period::format($document->sentAt, 'd/m/Y H:i') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Reenviado em : </strong> {{ Period::format($document->resentAt, 'd/m/Y H:i') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Aprovado em : </strong> {{ Period::format($document->approvedAt, 'd/m/Y H:i') }}
                    </li>
                    @if($document->status === 3)
                        <li class="list-group-item">
                            <strong>Reprovado em
                                : </strong> {{ Period::format($document->reusedAt, 'd/m/Y H:i') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Observa&ccedil;&atilde;o : </strong>
                            <font color="#FF4500"> {{ $document->observation }}</font>
                        </li>
                    @endif
                    <li class="list-group-item">
                        <input type="hidden" id="queryStringData"
                               value="{{ $queryStringData }}"/>

                        <a href="{{ route('checklist.company.approve') }}"
                           class="btn btn-success btn-lg checklist-approve" title="Aprovar"
                           rel="0"><span
                                    class="glyphicon glyphicon-thumbs-up"></span></a>

                        <a href="{{ route('checklist.company.disapprove') }}"
                           class="btn btn-danger btn-lg checklist-disapprove" title="Reprovar"
                           rel="0"><span
                                    class="glyphicon glyphicon-thumbs-down"></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
