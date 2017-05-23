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
                        @foreach($documentsTitle as $documents)
                            <th>
                                <div style="width: 200px; text-align: center;">
                                    {{ $documents->name }}
                                </div>
                            </th>
                        @endforeach




                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($documentsTitle as $documents)
                            <td>
                                {{ $documents->name }} {{ $total }}
                            </td>
                        @endforeach
                    </tr>
                </table>
            </div>

        </div>
    </div>

    <!-- /page content -->
@endsection
