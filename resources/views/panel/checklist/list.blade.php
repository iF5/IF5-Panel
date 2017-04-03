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
                        <div class="col-md-12" style="margin-top: 20px;">
                            <table id="users-table" class="table table-bordred table-striped">
                                <thead>
                                <th>Nome</th>
                                <th>Cnpj</th>
                                <th>Ramo de Atividade</th>
                                <th>Telefone</th>
                                <th>Usu&aacute;rios</th>
                                <th>Prestadores de servi&ccedil;os</th>
                                <th></th>
                                <th></th>
                                </thead>
                                <tbody>
                                @forelse($companies as $company)

                                    <tr>
                                        <td>
                                            <a href="{{ route('company.show', ['id' => $company->id]) }}">{{ $company->name }}</a>
                                        </td>
                                        <td>{{ $company->cnpj }}</td>
                                        <td>{{ $company->activityBranch }}</td>
                                        <td>{{ $company->phone }}</td>
                                        <td>
                                            <a href="{{ route('user-company.identify', $company->id) }}"
                                               class="btn btn-primary btn-xs" title="Usu&aacute;rios"><span
                                                        class="glyphicon glyphicon-user"></span></a>
                                            {{--
                                                <p data-placement="top" data-toggle="tooltip" title="Visualizar">
                                                    <a href="{{ route('user-company.identify', $company->id) }}"
                                                       class="btn btn-success btn-xs"><span
                                                                class="glyphicon glyphicon-user"></span></a>
                                                </p>
                                             --}}
                                        </td>
                                        <td>
                                            <a href="{{ route('provider.identify', $company->id) }}"
                                               class="btn btn-warning btn-xs" title="Prestadores de servi&ccedil;os"><span
                                                        class="glyphicon glyphicon-briefcase"></span></a>
                                        </td>


                                        <td>
                                            <a href="{{ route('company.edit', $company->id) }}"
                                               class="btn btn-success btn-xs" title="Editar"><span
                                                        class="glyphicon glyphicon-pencil"></span></a>

                                        </td>
                                        <td>
                                            <a href="#"
                                               class="btn btn-danger btn-xs modal-delete" title="Excluir"
                                               data-toggle="modal"
                                               data-target="#delete"
                                               rel="{{ route('company.destroy', $company->id) }}"><span
                                                        class="glyphicon glyphicon-trash"></span></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" align="center">Nenhuma empresa foi encontrada.</td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>

                            <div class="clearfix"></div>
                            <!-- Paginacao -->
                            @if($keyword)
                                {!! $companies->appends(['keyword' => $keyword])->links() !!}
                            @else
                                {!! $companies->links() !!}
                            @endif
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
