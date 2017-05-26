@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
        <!-- page content -->

<div class="right_col" role="main">
    <div class="row">

        <div class="col-md-12" style="overflow-x: auto">
            <table class="table table-bordered" style="width:auto">
                <thead>
                <tr>
                    <th>
                        <div style="width: 200px; text-align: center;">Prestador</div>
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
                @foreach($providers as $provider)
                    <tr>
                        <td style="text-align: center;">
                            {{ $provider['name'] }}
                        </td>
                        @foreach($provider['documents'] as $key => $value)
                            <td style="text-align: center;">
                                {{ $value }}/{{  $provider['employeeQuantity'] }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>

    </div>
</div>

<!-- /page content -->
@endsection
