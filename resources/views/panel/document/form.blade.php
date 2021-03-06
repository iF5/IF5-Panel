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

                    <form class="v-form" method="post" action="{{ route($route, $parameters) }}">
                        {!! method_field($method) !!}
                        {!! csrf_field() !!}

                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="name">Nome* :</label>
                                <input type="text" id="name" name="name" value="{{ $document->name or old('name') }}"
                                       class="form-control v-void">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-2">
                                <label for="cpf">Validade em dias* :</label>
                                <input type="text" id="validity" name="validity"
                                       value="{{ $document->validity or old('validity') }}"
                                       class="form-control col-sm-1 v-number" placeholder="Apenas n&uacute;meros">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="documentTypeId">Tipo de documento* :</label>
                                <select type="text" id="documentTypeId" name="documentTypeId" class="form-control">
                                    @foreach($documentTypes as $row)
                                        <option value="{{ $row->id }}"
                                                @if($document->documentTypeId === $row->id) selected @endif>{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <br />
                                @foreach($periodicities as $key => $value)
                                    <label class="radio-inline">
                                        <input type="radio" name="periodicity" value="{{ $key }}"
                                               @if($document->periodicity === $key) checked @endif>{{ $value }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <br />
                                @foreach($status as $key => $value)
                                    <label class="radio-inline">
                                        <input type="radio" name="isActive" value="{{ $key }}"
                                               @if($document->isActive === $key) checked @endif>{{ $value }}
                                    </label>
                                @endforeach
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
