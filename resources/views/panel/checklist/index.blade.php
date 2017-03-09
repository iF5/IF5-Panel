@extends('layouts.panel')

@section('title', 'Empresa/Prestador')

@section('content')
        <!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2>Checklist
                    <span class="text-primary">Upload/Download de arquivos</span>
                </h2>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <div class="col-md-4">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input class="form-control" id="system-search" name="company"
                                       placeholder="Buscar por empresa"
                                       required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input class="form-control" id="system-search" name="company"
                                       placeholder="Buscar por funcion&aacute;rio"
                                       required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input class="form-control" id="system-search" name="company"
                                       placeholder="Buscar por funcion&aacute;rios"
                                       required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                            </div>
                        </form>
                    </div>

                    <div class="clearfix" style="height: 60px;"></div>
                    <div class="table-responsive">
                        <table id="checklist-table" class="table table-bordred table-striped">
                            <thead>
                            <th>Ana Oliveira</th>
                            <th>Status</th>
                            <th>Envio</th>
                            <th>Processado</th>
                            <th>Validado</th>
                            <th>A&ccedill;&otilde;es</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Documento A</td>
                                <td>Enviado</td>
                                <td>01/01/2001</td>
                                <td>01/01/2001</td>
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
                                <td>01/01/2001</td>
                                <td>Nao</td>
                                <td>Enviar</td>
                            </tr>
                            <tr>
                                <td>Documento D</td>
                                <td>Enviado</td>
                                <td>01/01/2001</td>
                                <td>01/01/2001</td>
                                <td>Sim</td>
                                <td>Baixar</td>
                            </tr>
                            <tr>
                                <td>Documento E</td>
                                <td>Enviado</td>
                                <td>01/01/2001</td>
                                <td>01/01/2001</td>
                                <td>Sim</td>
                                <td>Baixar</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-12">As ações abaixo agendarão a compactação dos arquivos e deixará disponivel no
                        repositório para download.
                    </div>
                    <div class="col-md-12" style="margin-top: 20px;">Baixar todos os documentos da Ana <a
                                class="btn btn-primary" href="#"> Baixar tudo</a></div>
                    <div class="col-md-12" style="margin-top: 20px;">Baixar os documentos de todos funcionários <a
                                class="btn btn-primary" href="#"> Baixar tudo</a></div>


                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
