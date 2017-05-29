@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
        <!-- page content -->

<div class="right_col" role="main">
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <!-- menu breadcrumb -->
                @include('includes.breadcrumb')
            </div>

            <div class="col-md-12" style="overflow-x: auto; min-height: 350px;">
                <table class="table table-bordered" style="width:auto;">
                    <thead>
                    <tr>
                        <th>
                            <div style="width: 200px; text-align: center;">Funcion&aacute;rio</div>
                        </th>
                        @foreach($documents as $document)
                            <th>
                                <div style="width: 200px; text-align: center;">
                                    {{ $document->name }}
                                </div>
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td style="text-align: center;">
                                <strong>{{ $employee['name'] }}</strong>
                            </td>
                            @foreach($employee['documents'] as $key => $value)
                                <td style="text-align: center;">
                                    @if($value)
                                        <i class="fa fa-check"></i>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $totalDocuments + 1 }}">Nenhum relat&oacute;rio de funcion&aacute;rio foi encontrado.</td>
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
