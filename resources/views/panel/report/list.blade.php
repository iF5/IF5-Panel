@extends('layouts.panel')

@section('title', 'Gest&atilde;o de relat&oacute;rios')

@section('content')
    <!-- page content -->

    <div class="right_col" role="main">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <!-- menu breadcrumb -->
                    @include('includes.breadcrumb')
                </div>

                <div class="col-md-4">
                    <form action="{{ route('report.index') }}" method="get">
                        <div class="input-group">
                            @if($referenceDate)
                                <span class="input-group-addon">
                                <a href="{{ route('report.index') }}" title="Limpar busca">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </span>
                            @endif
                            <input class="form-control" type="text" id="referenceDateSearch" name="reference-date"
                                   placeholder="mm/aaaa"
                                   value="{{ $referenceDate }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default" id="btn-search-report"><i
                                            class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>

                <div class="col-md-8">
                    @can('onlyAdmin')
                        <a class="btn btn-success" href="{{ route('report.create') }}"> Cadastrar novo
                            rel&aacute;torio +</a>
                    @endcan
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <table id="report-table" class="table table-bordred table-striped">
                        <thead>
                        <th></th>
                        <th>Nome</th>
                        <th>Data de refer&ecirc;ncia</th>
                        <th>Cadastrado em</th>
                        <th>Arquivo</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                            <span class='glyphicon glyphicon-cog'></span> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            @can('onlyAdmin')
                                                <li>
                                                    <a href="{{ route('report.upload', $report->id) }}">Enviar
                                                        arquivo</a>
                                                </li>
                                            @endcan
                                            @if($report->fileOriginalName)
                                                <li>
                                                    <a href="{{ route('report.download', $report->id) }}">Baixar
                                                        arquivo</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                                <td>{{ $report->name }}</td>
                                <td>{{ $report->referenceDate }}</td>
                                <td>{{ \Carbon\Carbon::parse($report->createdAt)->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    @if($report->sentAt)
                                        {{ $report->fileOriginalName }} -
                                        {{ \Carbon\Carbon::parse($report->sentAt)->format('d/m/Y H:i:s') }}
                                    @endif
                                </td>
                                <td>
                                    @can('onlyAdmin')
                                        <a href="{{ route('report.edit', $report->id) }}"
                                           class="btn btn-success btn-xs" title="Editar"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>

                                        <a href="#"
                                           class="btn btn-danger btn-xs modal-delete" title="Excluir"
                                           data-toggle="modal"
                                           data-target="#delete"
                                           rel="{{ route('report.destroy', $report->id) }}"><span
                                                    class="glyphicon glyphicon-trash"></span></a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center">Nenhum relat&oacute;rio foi encontrado.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="clearfix"></div>
                    <!-- Paginacao -->
                    @if($referenceDate)
                        {!! $reports->appends(['reference-date' => $referenceDate])->links() !!}
                    @else
                        {!! $reports->links() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- /page content -->
@endsection
