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

            <div class="col-md-6"></div>

            <div class="col-md-12" style="overflow-x: auto; min-height: 350px;">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            <div>Documentos</div>
                        </th>
                        @foreach($providers as $provider)
                            <th>
                                <div style="width: 200px; text-align: center;">
                                    <a href="{{ route('dashboard.employee', ["providerId" => $provider['providerId']]) }}">
                                        {{ $provider['providerName'] }}
                                    </a>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $key => $value)
                            <tr>
                            <td>
                                {{ $key }}
                            </td>
                            @foreach($value as $val)
                            <td>
                                {{ $val['documentQuantity'] }}/{{  $val['employeeQuantity'] }}
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
