@extends('panel.layout')

@section('content')


    <!-- page content -->
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Checklist
                            <small>Upload de arquivos</small>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Ana Oliveira</th>
                                <th>Status</th>
                                <th>Envio</th>
                                <th>Processado</th>
                                <th>Validado</th>
                                <th>A&ccedil;&otilde;es</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Documento A</td>
                                <td>Enviado</td>
                                <td>01/01/2001</td>
                                <td>02/01/2001</td>
                                <td>Sim</td>
                                <td>Baixar</td>
                            </tr>
                            <tr>
                                <td>Documento B</td>
                                <td>Pendente</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Enviar</td>
                            </tr>
                            <tr>
                                <td>Documento C</td>
                                <td>Reenviar</td>
                                <td>01/01/2001</td>
                                <td>02/01/2001</td>
                                <td>N&atilde;o</td>
                                <td>Enviar</td>
                            </tr>
                            <tr>
                                <td>Documento D</td>
                                <td>Enviado</td>
                                <td>01/01/2001</td>
                                <td>02/01/2001</td>
                                <td>Sim</td>
                                <td>Baixar</td>
                            </tr>
                            <tr>
                                <td>Documento E</td>
                                <td>Enviado</td>
                                <td>01/01/2001</td>
                                <td>02/01/2001</td>
                                <td>Sim</td>
                                <td>Baixar</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

@endsection