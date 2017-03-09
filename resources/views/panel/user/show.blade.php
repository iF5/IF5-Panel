@extends('layouts.panel')

@section('title', 'Gest&atilde;o de usu&aacute;rios')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            <a href="{{ route($routePrefix .'.index') }}" title="Voltar">
                                <span class="glyphicon glyphicon-circle-arrow-left"></span>
                            </a>
                            Gest&atilde;o de
                            <span class="text-primary">usu&aacute;rios</span>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table style="width: 100%;" border="0">
                            <tr>
                                <td>
                                    Nome :
                                </td>
                                <td align="left">
                                    {{ $user->name }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    E-mail :
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                            </tr>

                            <tr>
                                <td style="height: 100px;">
                                    <div class="control-group">
                                        <div class="controls">
                                            <a href="{{ route($routePrefix .'.edit', $user->id) }}"
                                               class="btn btn-success">Editar</a>
                                            <a href="{{ route($routePrefix .'.index') }}"
                                               class="btn btn-primary">Cancelar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /page content -->
@endsection