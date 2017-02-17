@extends('panel.layout')

@section('title', 'Lista de usu&aacute;rios')

@section('content')
<!-- page content -->

<div class="right_col" role="main">

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2>Usu&aacute;rios
                    <span class="text-primary">Cadastrados</span>
                </h2>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-6">
                <form action="#" method="get">
                    <div class="input-group">
                        <input class="form-control" id="system-search" name="q" placeholder="Buscar por" required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                    </div>
                </form>
            </div>

            <div class="col-md-6">
                <a class="btn btn-success" href="{{ url('user-create') }}"> Cadastrar novo usu&aacute;rio +</a>
            </div>

            <!--
            <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
            <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
            -->
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="users-table" class="table table-bordred table-striped">
                        <thead>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>N&iacute;vel de acesso</th>
                        <th>Fone</th>
                        <th>Cadastrado em</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <a href="#">Teste 1</a>
                            </td>
                            <td>test1@gmail.com</td>
                            <td>Inativo</td>
                            <td>Administrador</td>
                            <td>11 90000-0000</td>
                            <td>12/01/2017</td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Editar">
                                    <a href="{{ url('user-edit') }}/1" class="btn btn-primary btn-xs"><span
                                                class="glyphicon glyphicon-pencil"></span></a>
                                </p>
                            </td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Excluir">
                                    <button class="btn btn-danger btn-xs" data-title="Excluir" data-toggle="modal"
                                            data-target="#delete"><span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#">Teste 1</a>
                            </td>
                            <td>test2@gmail.com</td>
                            <td>Ativo</td>
                            <td>Super Administrador</td>
                            <td>11 90000-0000</td>
                            <td>12/01/2017</td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Editar">
                                    <a href="{{ url('user-edit') }}/2" class="btn btn-primary btn-xs"><span
                                                class="glyphicon glyphicon-pencil"></span></a>
                                </p>
                            </td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Excluir">
                                    <button class="btn btn-danger btn-xs" data-title="Excluir" data-toggle="modal"
                                            data-target="#delete"><span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </p>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                    <div class="clearfix"></div>
                    <ul class="pagination pull-right">
                        <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Aten&ccedil;&atilde;o</h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Tem certeza de
                    que deseja excluir este registro?
                </div>

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Sim
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                            class="glyphicon glyphicon-remove"></span> N&atilde;o
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /page content -->
@endsection
