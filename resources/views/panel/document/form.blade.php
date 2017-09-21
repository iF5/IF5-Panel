@extends('layouts.panel')

@section('title', 'Gest&atilde;o de documentos')

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

                    <form id="document-form" method="post" action="{{ route($route, $parameters) }}">

                        {!! method_field($method) !!}
                        {!! csrf_field() !!}

                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="name">Nome* :</label>
                                <input type="text" id="name" name="name" value="{{ $document->name or old('name') }}"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="periodicity">Per&iacute;odicidade* :</label>
                                <select type="text" id="periodicity" name="periodicity" class="form-control">
                                    <option value="0">periodicity</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-2">
                                <label for="cpf">Validade * :</label>
                                <input type="text" id="validity" name="validity"
                                       value="{{ $document->validity or old('validity') }}"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="documentTypeId">Per&iacute;odicidade* :</label>
                                <select type="text" id="documentTypeId" name="documentTypeId" class="form-control">
                                    <option value="0">documentTypeId</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="control-group" style="margin: 20px 0px 0px 12px;">
                                <button type="submit" class="btn btn-success" id="btn-user-form">Salvar</button>
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
