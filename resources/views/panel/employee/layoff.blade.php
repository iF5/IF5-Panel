@extends('layouts.panel')

@section('title', 'Gest&atilde;o de funcion&aacute;rios')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <!-- menu breadcrumb -->
                    {{-- @include('includes.breadcrumb') --}}
                </div>

                <div class="col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li @if($layoffType === 1) class="active" @endif>
                            <a href="{{ route('employee.layoff', [$employeeId, 1]) }}">Demissão</a>
                        </li>
                        <li @if($layoffType === 2) class="active" @endif>
                            <a href="{{ route('employee.layoff', [$employeeId, 2]) }}">Afastamento</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-12">

                    <div style="padding: 10px 0px 20px 10px">
                        <strong>Atenção : </strong>todos os campos com o s&iacute;mbolo * s&atilde;o obrigat&oacute;rios.
                    </div>

                    @include('includes.form-validate')

                    <form class="v-form" method="post" action="">
                        <div class="row">
                            {!! method_field('POST') !!}
                            {!! csrf_field() !!}

                            <div class="form-group col-xs-12">
                                <h2>{{ $employeeName }}</h2>
                            </div>
                            <input type="hidden" name="layoffType" value="{{ $layoffType }}">
                            <input type="hidden" name="employeeId" value="{{ $employeeId }}">

                            <div class="form-group col-xs-2">
                                <label for="name">Data de {{ $label }} * :</label>
                                <input type="text" id="date" name="date"
                                       value=""
                                       class="form-control v-void dateMask">
                            </div>
                            @if($layoffType === 2)
                                <div class="form-group col-xs-2">
                                    <label for="name">Quantos dias afastado? </label>
                                    <input type="text" id="days" name="days"
                                           value=""
                                           class="form-control v-number">
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="control-group col-xs-4" style="margin-top: 30px;">
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
