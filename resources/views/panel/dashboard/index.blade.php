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

            <div class="col-md-6">
                <!-- form the search -->
                @include('includes.form-search')
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
                                    {{ $provider['name'] }}
                                </div>
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($providers as $provider)


                            @foreach($provider['documents'] as $key => $value)
                                <tr>
                                <td>
                                    {{ $value['name'] }}
                                </td>
                                <td>
                                    {{ $value['total'] }}/{{  $provider['employeeQuantity'] }}
                                </td>
                                </tr>
                            @endforeach


                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
