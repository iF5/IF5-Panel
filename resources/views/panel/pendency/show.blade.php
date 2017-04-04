@extends('layouts.panel')

@section('title', 'Gest&atilde;o de prestador de servi&ccedil;os')

@section('content')
        <!-- page content -->

<div class="right_col" role="main">

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <!-- menu breadcrumb -->
                @include('includes.breadcrumb')
            </div>

            <ul class="list-group">
                @foreach($data as $key => $value)
                    <li class="list-group-item"><strong>{{ $key }} : </strong> {{ $value }}</li>
                @endforeach
                <li class="list-group-item">
                    <a href="#"
                       class="btn btn-success btn-md modal-update" title="Aprovar"
                       data-toggle="modal"
                       data-target="#update"
                       rel="{{ route('pendency.approve', ['companyId' => $companyId, 'id' => $id, 'source' => $source]) }}"
                       rev="Tem certeza que deseja aprovar este registro?"><span
                                class="glyphicon glyphicon-check"></span></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
