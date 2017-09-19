@extends('layouts.panel')

@section('title', 'Gest&atilde;o de tipos de documentos')

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

                        <div style="padding: 10px 0px 20px 10px">
                            <strong>Atenção : </strong>todos os campos com o s&iacute;mbolo * s&atilde;o obrigat&oacute;rios.
                        </div>

                        @include('includes.form-validate')

                        <form id="company-form" method="post" action="{{ route($route, $parameters) }}">

                            {!! method_field($method) !!}
                            {!! csrf_field() !!}

                            <div class="form-group col-xs-8">
                                <label for="name">Nome* :</label>
                                <input type="text" id="name" name="name" value="{{ $company->name or old('name') }}"
                                       class="form-control">
                            </div>

                            <div class="clearfix"></div>
                            <div class="control-group" style="margin: 30px 0px 0px 12px;">
                                <button type="submit" class="btn btn-success" id="btn-company-form">Salvar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection
