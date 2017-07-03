@extends('layouts.panel')

@section('title', 'Gest&atilde;o de log')

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
                    <form class="form-inline" action="{{ route('log.index') }}" method="get">
                        <div class="form-group">
                            <input type="text" class="form-control dateMask" name="date"
                                   value="{{ $searchData['date'] }}" size="8">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="verb">
                                @foreach($verbs as $key => $value)
                                    <option value="{{ $key }}"
                                            @if($searchData['verb'] === $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </form>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <table id="logs-table" class="table table-bordred table-striped">
                        <thead>
                        <th></th>
                        <th>A&ccedil;&atilde;o</th>
                        <th>Tit&uacute;lo</th>
                        <th><strong>Usu&aacute;rio</th>
                        <th>Gerado em</th>
                        </thead>
                        <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>
                                    <a href="{{ route('log.show', $log->id) }}"
                                       class="btn btn-warning btn-xs" title="Visualizar"><span
                                                class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                </td>
                                <td>{{ $verbs[$log->method] }}</td>
                                <td>{{ $log->title }}</td>
                                <td>{{ $log->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($log->createdAt)->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" align="center">Nenhum log foi encontrado.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    <div class="clearfix"></div>
                    <!-- Paginacao -->
                    {!! $logs->appends($searchData)->links() !!}
                </div>
            </div>
        </div>
    </div>


    <!-- /page content -->
@endsection
