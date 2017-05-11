@extends('layouts.panel')

@section('title', 'Gest&atilde;o de relat&oacute;rios')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <!-- menu breadcrumb -->
                        @include('includes.breadcrumb')
                    </div>
                    <div class="x_content">

                        <div style="padding: 10px 0px 20px 0px">
                            <strong>Atenção : </strong>todos os campos com o s&iacute;mbolo * s&atilde;o obrigat&oacute;rios.
                        </div>

                        <!-- form validate -->
                        @include('includes.form-validate')

                        <form id="report-form" method="post" action="{{ route($route, $parameters) }}">

                            {{ method_field($method) }}
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="form-group col-sm-5">
                                    <label for="name">Nome* :</label>
                                    <input type="text" id="name" name="name" value="{{ $report->name or old('name') }}"
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-2">
                                    <label for="referenceDateSearch">Data de refer&ecirc;ncia * :</label>
                                    <input type="text" id="referenceDateSearch" name="referenceDate"
                                           value="{{ $report->referenceDate or old('referenceDate') }}"
                                           class="form-control" required placeholder="mm/aaaa">
                                </div>
                            </div>
                            <div class="row">
                                <div class="control-group" style="margin: 20px 0px 0px 12px;">
                                    <button type="submit" class="btn btn-success">Salvar</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection
