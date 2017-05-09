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
                    <th>Razão Social</th>
                    <th>Nome Fantasia</th>
                    <th>Cnpj</th>
                    <th>Telefone</th>
                    <th>Usu&aacute;rios</th>
                    <th>Prestadores de servi&ccedil;os</th>
                    <th>Relat&oacute;rios</th>
                    <th></th>
                    <th></th>
                    </thead>
                    <tbody>
                    @forelse($companies as $company)

                        <tr>
                            <td>
                                <a href="{{ route('company.show', ['id' => $company->id]) }}">{{ $company->name }}</a>
                            </td>
                            <td>{{ $company->fantasyName }}</td>
                            <td>{{ $company->cnpj }}</td>
                            <td>{{ $company->phone }}</td>
                            <td>
                                <a href="{{ route('user-company.identify', $company->id) }}"
                                   class="btn btn-primary btn-xs" title="Usu&aacute;rios"><span
                                            class="glyphicon glyphicon-user"></span></a>
                                {{--
                                    <p data-placement="top" data-toggle="tooltip" titl:e="Visualizar">
                                        <a href="{{ route('user-company.identify', $company->id) }}"
                                           class="btn btn-success btn-xs"><span
                                                    class="glyphicon glyphicon-user"></span></a>
                                    </p>
                                 --}}
                            </td>
                            <td>
                                <a href="{{ route('provider.identify', $company->id) }}"
                                   class="btn btn-primary btn-xs" title="Prestadores de servi&ccedil;os"><span
                                            class="glyphicon glyphicon-briefcase"></span></a>
                            </td>
                            <td>
                                <a href="{{ route('report.identify', $company->id) }}"
                                   class="btn btn-primary btn-xs" title="Relat&oacute;rios"><span
                                            class="glyphicon glyphicon-signal"></span></a>
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
                            <td colspan="9" align="center">Nenhum cliente foi encontrado.</td>
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
