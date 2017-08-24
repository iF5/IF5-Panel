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
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            <div style="width: 200px; text-align: center;">Documentos</div>
                        </th>
                        @foreach($employees as $employee)
                            <th>
                                <div style="width: 200px; text-align: center;">
                                    {{ $employee->employeeName }}
                                </div>
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($documents as $key => $document)
                        <tr>
                            <td>
                                <strong>{{ $key }}</strong>
                            </td>
                            @foreach($document as  $value)
                                <td style="text-align: center;">
                                    @if($value['documentQuantity'] > 0)
                                        <i class="fa fa-check"></i>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
