@extends('layouts.panel')

@section('title', 'Gest&atilde;o de cliente')

@section('content')
    <!-- page content -->

    <div class="right_col" role="main">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <!-- menu breadcrumb -->
                    @include('includes.breadcrumb')
                </div>

                <div class="col-md-6">
                    <!-- form the search -->
                    @include('includes.form-search')
                </div>

                <div class="col-md-6">
                    <a class="btn btn-success" href="{{ route('company.create') }}"> Cadastrar novo cliente +</a>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <table id="users-table" class="table table-bordred table-striped">
                        <thead>
                        <th></th>
                        <th>Razão Social</th>
                        <th>Nome Fantasia</th>
                        <th>CNPJ</th>
                        <th>Telefone</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @forelse($companies as $company)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            <span class='glyphicon glyphicon-cog'></span> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="{{ route('company.show', ['id' => $company->id]) }}">Abrir</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('checklist.company.identify', $company->id) }}">Documentos</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('report.identify', $company->id) }}">Relat&oacute;rios</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('provider.identify', $company->id) }}">Prestadores de
                                                    servi&ccedil;os</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('user-company.identify', $company->id) }}">Usu&aacute;rios</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->fantasyName }}</td>
                                <td>{{ $company->cnpj }}</td>
                                <td>{{ $company->phone }}</td>
                                <td>
                                    <a href="{{ route('company.edit', $company->id) }}"
                                       class="btn btn-success btn-xs" title="Editar"><span
                                                class="glyphicon glyphicon-pencil"></span></a>

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
                                <td colspan="6" align="center">Nenhum cliente foi encontrado.</td>
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
            </div>
        </div>
    </div>


    <!-- /page content -->
@endsection
