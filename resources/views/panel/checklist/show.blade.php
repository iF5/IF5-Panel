@extends('layouts.panel')

@section('title', 'Checklist de documentos')

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

                <div class="row">
                    <object data="{{ $pdf }}" type="application/pdf" width="100%" height="800px">
                        <embed src="{{ $pdf }}" type="application/pdf" width="100%" height="800px"></embed>
                    </object>
                </div>
                <div class="row" style="float: left; margin: 50px 0px;">
                    <a href="{{ route('checklist.company.approve') }}"
                       class="btn btn-success btn-lg checklist-approve" title="Aprovar"
                       rel="0"><span
                                class="glyphicon glyphicon-thumbs-up"></span></a>

                    <a href="{{ route('checklist.company.disapprove') }}"
                       class="btn btn-danger btn-lg checklist-disapprove" title="Reprovar"
                       rel="0"><span
                                class="glyphicon glyphicon-thumbs-down"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
