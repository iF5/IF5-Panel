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
                        <input class="form-control" type="text" id="referenceDateSearch" name="reference-date" placeholder="Buscar pelo o m&ecirc;s e ano de refer&ecirc;ncia"
                               value="{{ $referenceDate }}" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                    </div>
                </form>
            </div>

            <div class="col-md-8">
                <a class="btn btn-success" href="{{ route('report.index') }}"> Cadastrar novo
                    relátorio +</a>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                <table id="provider-table" class="table table-bordred table-striped">
                    <thead>
                    <th>Nome</th>
                    <th>Data de refer&ecirc;ncia</th>
                    <th>Cadastrado em</th>
                    <th>Enviado em</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    </thead>
                    <tbody>

                    @forelse($reports as $report)
                        <tr>
                            <td>
                                <a>{{ $report->name }}</a>
                            </td>
                            <td>{{ $report->referenceDate }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($report->createdAt)->format('d/m/Y H:i:s') }}
                            </td>
                            <td>
                                @if($report->sentAt)
                                    {{ \Carbon\Carbon::parse($report->sentAt)->format('d/m/Y H:i:s') }}
                                @endif
                            </td>
                            <td>
                                <a href=""
                                   class="btn btn-primary btn-xs"><span
                                            class="glyphicon glyphicon glyphicon-cloud-upload"></span></a>
                            </td>
                            <td>
                                <a href=""
                                   class="btn btn-primary btn-xs"><span
                                            class="glyphicon glyphicon glyphicon-cloud-download"></span></a>
                            </td>
                            <td>
                                <a href="{{ route('provider.edit', $report->id) }}"
                                   class="btn btn-success btn-xs"><span
                                            class="glyphicon glyphicon-pencil"></span></a>

                            </td>
                            <td>
                                <a href="#"
                                   class="btn btn-danger btn-xs modal-delete" data-title="Excluir"
                                   data-toggle="modal"
                                   data-target="#delete"
                                   rel="{{ route('provider.destroy', $report->id) }}"><span
                                            class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" align="center">Nenhum relat&oacute;rio foi encontrado.</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

                <div class="clearfix"></div>
                <!-- Paginacao -->
                @if($referenceDate)
                    {!! $reports->appends(['reference-date' => $referenceDate])->links() !!}
                @else

                @endif
            </div>
        </div>
    </div>
</div>


<!-- /page content -->
@endsection
