@extends('panel.layout')

@section('title', 'Lista de empresas')

@section('content')
    <!-- page content -->

    <div class="right_col" role="main">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Gest&atilde;o de
                        <span class="text-primary">empresas</span>
                    </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-6">
                    <form action="{{ route('company.index') }}" method="get">
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
                    <a class="btn btn-success" href="{{ route('company.create') }}"> Cadastrar nova empresa +</a>
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
                            <th>Cnpj</th>
                            <th>Usu&aacute;rios</th>
                            <th>Prestadores de servi&ccedil;os</th>
                            </thead>
                            <tbody>

                            @forelse($companies as $company)

                                <tr>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->cnpj }}</td>
                                    <td>
                                        <a href="{{ route('user-company.identify', $company->id) }}">Visualizar</a>
                                    </td>
                                    <td>
                                        <a href="#">Visualizar</a>
                                    </td>
                                    <td>
                                        <p data-placement="top" data-toggle="tooltip" title="Editar">
                                            <a href="{{ route('company.edit', $company->id) }}"
                                               class="btn btn-primary btn-xs"><span
                                                        class="glyphicon glyphicon-pencil"></span></a>
                                        </p>
                                    </td>
                                    <td>
                                        <p data-placement="top" data-toggle="tooltip" title="Excluir">
                                        <form method="post" action="{{ route('company.destroy', $company->id)  }}">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger btn-xs" type="submit"><span
                                                        class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </form>

                                    <!--
                                            <button class="btn btn-danger btn-xs" data-title="Excluir" data-toggle="modal"
                                                    data-target="#delete" value=""><span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                            -->
                                        </p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" align="center">Nenhuma empresa foi encontrada.</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>

                        <div class="clearfix"></div>
                        <ul class="pagination pull-right">
                            <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a>
                            </li>
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

                    <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Tem certeza
                        de
                        que deseja excluir este registro?
                    </div>

                </div>
                <div class="modal-footer ">
                    <a href="" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Sim
                    </a>
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
