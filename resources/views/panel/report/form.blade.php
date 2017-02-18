@extends('panel.layout')

@section('title', 'Formul&aacute;rio de empresa')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Relatórios
                        <span class="text-primary">Upload</span>
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div class="col-md-6">
                            <form action="#" method="post">
                                <div class="input-group">
                                    <input class="form-control" id="system-search" name="company"
                                           placeholder="Pesquisar empresa"
                                           required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                                </div>
                            </form>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <form action="#" method="post">
                                <div class="input-group">
                                    <textarea class="form-control" id="system-search" name="company"
                                           placeholder="Upload relatório"
                                           required></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12" style="margin-top: 20px;"> <a class="btn btn-primary" href="#"> Upload</a></div>
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table id="employee-table" class="table table-bordred table-striped">
                                <thead>
                                    <tr>
                                        <td colspan="10">Arquivos carregados</td>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="round round-lg hollow ">
                                                    <span class="glyphicon glyphicon-file"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /page content -->
@endsection