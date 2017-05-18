@extends('layouts.panel')

@section('title', 'Home')

@section('content')
        <!-- page content -->

<div class="right_col" role="main">
    <div class="row">
        <!--<h2>Home temporária use o menu lateral para navegação!</h2>-->

        <div class="col-md-12" style="overflow-x: auto">
            <table class="table table-bordered" style="width:auto">
                <thead>
                <tr>
                    @foreach($documentsTitle as $documents)
                        <th style="float: none; width: 500px;">{{ $documents->name }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr>   
            </table>
        </div>

    </div>
</div>

<!-- /page content -->
@endsection
