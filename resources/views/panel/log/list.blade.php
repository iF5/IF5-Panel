@extends('layouts.panel')

@section('title', 'Gest&atilde;o de cliente')

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
                <form action="{{ route('log.index') }}" method="get">
                    <div class="input-group">
                        @if($keyword)
                            <span class="input-group-addon">
                                <a href="{{ route(\Route::getCurrentRoute()->getName()) }}" title="Limpar busca">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </span>
                        @endif
                        <input class="form-control" type="text" id="keyword" name="keyword" placeholder="Buscar por"
                               value="{{ $keyword }}" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                    </div>
                </form>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                <table id="logs-table" class="table table-bordred table-striped">
                    <thead>
                    <th></th>
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
                            <td>{{ $log->userName }}</td>
                            <td>{{ \Carbon\Carbon::parse($log->createdAt)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" align="center">Nenhum log foi encontrado.</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

                <div class="clearfix"></div>
                <!-- Paginacao -->
                @if($keyword)
                    {!! $logs->appends(['keyword' => $keyword])->links() !!}
                @else
                    {!! $logs->links() !!}
                @endif
            </div>
        </div>
    </div>
</div>


<!-- /page content -->
@endsection
