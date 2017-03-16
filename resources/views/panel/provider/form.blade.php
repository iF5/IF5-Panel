@extends('layouts.panel')

@section('title', 'Gest&atilde;o de prestadores de servi&ccedil;os')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            <a href="{{ route('provider.index') }}" title="Voltar">
                                <span class="glyphicon glyphicon-circle-arrow-left"></span>
                            </a>
                            Gest&atilde;o de
                            <span class="text-primary">prestadores de servi&ccedil;os</span>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br/>

                        <form id="provider-form" method="post" action="{{ route($route, $parameters) }}"
                              data-parsley-validate class="form-horizontal form-label-left">

                            {{ method_field($method) }}
                            {{ csrf_field() }}

                            <table style="width: 100%;" border="0">
                                <tr>
                                    <td>
                                        {!! Session::has('success') ? Session::get("success") : '' !!}
                                        <div class="control-group">
                                            <label class="control-label" for="name">Nome *</label>
                                            <div class="controls">
                                                <input id="name" name="name" value="{{ $provider->name }}" type="text"
                                                       placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="cnpj">CNPJ *</label>
                                            <div class="controls">
                                                <input id="cnpj" name="cnpj" value="{{ $provider->cnpj }}" type="text"
                                                       placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="height: 100px;">
                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" class="btn btn-success">Salvar</button>
                                                <button class="btn btn-primary" type="reset">Limpar</button>
                                                <a href="{{ route('provider.index') }}"
                                                   class="btn btn-primary">Cancelar</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>

                            </table>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /page content -->
@endsection