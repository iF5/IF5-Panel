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

            <div class="col-md-6">
                <form class="v-form" action="" method="get">
                    <div class="input-group">
                        @if($year and $month)
                            <span class="input-group-addon">
                                <a href="{{ route(sprintf('checklist.%s.index', $entityName), [$periodicity]) }}"
                                   title="Limpar busca">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </span>
                        @endif
                        <select class="form-control v-void" id="month" name="month" style="width: 60%">
                            <option value="">M&ecirc;s</option>
                            @foreach(Period::getMonths() as $key => $value)
                                <option value="{{ $key }}"
                                        @if($key == $month) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        <select class="form-control v-void" id="year" name="year" style="width: 40%">
                            <option value="">Ano</option>
                            @foreach(Period::getYears() as $value)
                                <option value="{{ $value }}"
                                        @if($year == $value) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
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
                            <a href="{{route(sprintf('checklist.%s.index', $entityName), [$key, 'year' => $year, 'month' => $month])}}">{{ $value }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-16">

                <form>
                    <input type="hidden" id="periodicity" value="{{ $periodicity }}"/>

                    <!-- Tab panes -->
                    <table id="checklist-table" class="table table-bordred table-striped">
                        <thead>
                        <th></th>
                        <th>Documento</th>
                        <th colspan="2">Data refer&ecirc;ncia (M&ecirc;s/Ano)*</th>
                        <th>Validade *</th>
                        <th>Status</th>
                        <th>A&ccedil;&atilde;o</th>
                        </thead>
                        <tbody>
                        @forelse($documents as $document)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm dropdown-toggle"
                                                data-toggle="dropdown">
                                            <span class='glyphicon glyphicon-cog'></span> <span
                                                    class="caret"></span>
                                        </button>
                                        @if($document->status)
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="{{ route(sprintf('checklist.%s.show.pdf', $entityName), [
                                                        $document->documentId,
                                                        $document->referenceDate,
                                                        $periodicity
                                                        ]) }}">Visualizar</a>
                                                </li>
                                                <li>
                                                    <a href="{{ $pathFile . $document->fileName }}" download>Baixar</a>
                                                </li>
                                            </ul>
                                        @endif
                                    </div>
                                </td>
                                <td width="30%">
                                    {{ $document->name }}
                                </td>
                                <td width="12%">
                                    <select class="form-control" id="month{{ $document->id }}">
                                        <option value="">M&ecirc;s</option>
                                        @foreach(Period::getMonths() as $key => $value)
                                            <option value="{{ $key }}"
                                                    @if($key == Period::format($document->referenceDate, 'm')) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td width="9%">
                                    <select class="form-control" id="year{{ $document->id }}">
                                        @foreach(Period::getYears() as $year)
                                            <option value="{{ $year }}"
                                                    @if($year == Period::format($document->referenceDate, 'Y')) selected @endif>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" id="validity{{ $document->id }}" name="validity"
                                           title="Em dias"
                                           style="text-align: center; width: 50%;"
                                           value="{{ $document->validity }}">
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
                                            <strong>{{ Period::format($document->sentAt, 'd/m/Y H:i') }}</strong><br/>
                                            Reenviado em :
                                            <strong>{{ Period::format($document->resentAt, 'd/m/Y H:i') }}</strong><br/>
                                            Aprovado em :
                                            <strong>{{ Period::format($document->approvedAt, 'd/m/Y H:i') }}</strong><br/>
                                            @if($document->status === 3)
                                                Reprovado em :
                                                <strong>{{ Period::format($document->reusedAt, 'd/m/Y H:i') }}</strong>
                                                <br/>
                                                Observa&ccedil;&atilde;o:
                                                <font color="#FF4500"> {{ $document->observation }}</font>
                                            @endif
                                        </p>
                                    @else
                                        <strong>Aguardando envio</strong>
                                    @endif
                                </td>
                                <td>
                                    @if($document->status === 2)
                                        <span class="glyphicon glyphicon glyphicon-ok"></span>
                                    @else
                                        <a href="{{ route(sprintf('checklist.%s.store', $entityName)) }}"
                                           class="btn btn-warning btn-md modal-document-upload"
                                           title="Enviar documento"
                                           rel="{{ $document->id }}"
                                        ><span class="glyphicon glyphicon-cloud-upload"></span></a>
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" align="center">Nenhum documento foi encontrado.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
