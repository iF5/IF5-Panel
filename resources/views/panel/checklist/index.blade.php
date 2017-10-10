@extends('layouts.panel')

@section('title', 'Empresa/Prestador')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main" xmlns="http://www.w3.org/1999/html">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <!-- menu breadcrumb -->
                    @include('includes.breadcrumb')
                </div>

                <div class="col-md-3">
                    <form action=""
                          method="get">
                        <div class="input-group">
                            @if($referenceDate)
                                <span class="input-group-addon">
                                <a href="{{ route('checklist.company.index', ['periodicity' => $periodicity]) }}"
                                   title="Limpar busca">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </span>
                            @endif
                            <input class="form-control referenceDate" type="text" name="referenceDate"
                                   title="Data Referencia - Mes e Ano" placeholder="mm/aaaa"
                                   value="{{ $referenceDate or '' }}" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-12">
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-16">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        @foreach($periodicities as $key => $value)
                            <li @if($key === $periodicity) class="active" @endif>
                                <a href="{{route('checklist.company.index', ['periodicity' => $key])}}">{{ $value }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-md-16">

                    <input type="hidden" id="periodicity" value="{{ $periodicity }}"/>

                    <!-- Tab panes -->
                    <table id="checklist-table" class="table table-bordred table-striped">
                        <thead>
                        <th></th>
                        <th>Documento</th>
                        <th>Data refer&ecirc;ncia *</th>
                        <th>Validade *</th>
                        <th>Status</th>
                        <th>A&ccedil;&atilde;o</th>
                        </thead>
                        <tbody>
                        @forelse($documents as $document)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            <span class='glyphicon glyphicon-cog'></span> <span class="caret"></span>
                                        </button>
                                        @if($document->status)
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="{{ route('checklist.company.download', [
                                                        'entityGroup' => $document->entityGroup,
                                                        'entityId' => $document->entityId,
                                                        'documentId' => $document->documentId,
                                                        'referenceDate' => DateFormat::to($document->referenceDate, 'm-Y')
                                                        ]) }}">Baixar</a>
                                                </li>
                                                @can('onlyAdmin')
                                                    <li>
                                                        <a href="">Aprovar</a>
                                                    </li>
                                                    <li>
                                                        <a href="" rev="{{ $document->id }}" data-toggle="modal"
                                                           data-target="#description">Reprovar</a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        @endif
                                    </div>
                                </td>
                                <td width="30%">
                                    {{ $document->name }}
                                </td>
                                <td>
                                    <input class="form-control referenceDate" id="referenceDate{{ $document->id }}"
                                           name="referenceDate"
                                           title="M&ecirc;s e ano"
                                           value="{{ DateFormat::to($document->referenceDate, 'm/Y') }}"
                                           placeholder="mm/aaaa">
                                </td>
                                <td>
                                    <input class="form-control" id="validity{{ $document->id }}" name="validity"
                                           title="Em dias"
                                           style="text-align: center; width: 50%;" value="{{ $document->validity }}">
                                </td>
                                <td width="25%">
                                    @if($document->status)
                                        <strong>{{ $status[$document->status] }}</strong>
                                        <a href="" class="btn-read-more" title="Leia mais">
                                            <span class="glyphicon glyphicon-info-sign"></span>
                                        </a>
                                        <p class="text-read-more" style="display: none;">
                                            <br/>
                                            Arquivo: <strong>{{ $document->originalFileName }}</strong><br/>
                                            Enviado em :
                                            <strong>{{ DateFormat::to($document->sentAt, 'd/m/Y H:i') }}</strong><br/>
                                            Reprovado em :
                                            <strong>{{ DateFormat::to($document->reusedAt, 'd/m/Y H:i') }}</strong><br/>
                                            Reenviado em :
                                            <strong>{{ DateFormat::to($document->resentAt, 'd/m/Y H:i') }}</strong><br/>
                                            Aprovado em :
                                            <strong>{{ DateFormat::to($document->approvedAt, 'd/m/Y H:i') }}</strong><br/>
                                            <br/>
                                            <strong>Obs: </strong> {{ $document->description }}
                                        </p>
                                    @else
                                        <strong>Aguardando envio</strong>
                                    @endif
                                </td>
                                <td>
                                    @if($document->status)
                                        <a href="{{ route('checklist.company.store') }}"
                                           class="btn btn-warning btn-md modal-document-upload"
                                           rel="{{ $document->id }}"
                                           title="Reenviar documento">Reenviar
                                        </a>
                                    @else
                                        <a href="{{ route('checklist.company.store') }}"
                                           class="btn btn-success btn-md modal-document-upload"
                                           rel="{{ $document->id }}"
                                           title="Enviar documento">Enviar
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center">Nenhum documento foi encontrado.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
