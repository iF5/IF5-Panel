@extends('layouts.panel')

@section('title', 'Gest&atilde;o de documentos')

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
                    <a class="btn btn-success" href="{{ route($route) }}"> Cadastrar novo documento +</a>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <table id="users-table" class="table table-bordred table-striped">
                        <thead>
                        <th></th>
                        <th>Name</th>
                        <th>Periodicidade</th>
                        <th>Validade</th>
                        <th>Cadastrado em</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @forelse($documents as $document)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            <span class='glyphicon glyphicon-cog'></span> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="{{ route('document-types.show', ['id' => $document->id]) }}">Abrir</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{{ $document->name }}</td>
                                <td>{{ $document->periodicity }}</td>
                                <td>{{ $document->validity }} dias</td>
                                <td>{{ \Carbon\Carbon::parse($document->createdAt)->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('document-types.edit', $document->id) }}"
                                       class="btn btn-success btn-xs" title="Editar"><span
                                                class="glyphicon glyphicon-pencil"></span></a>
                                    <a href="#"
                                       class="btn btn-danger btn-xs modal-delete" title="Excluir"
                                       data-toggle="modal"
                                       data-target="#delete"
                                       rel="{{ route('document-types.destroy', $document->id) }}"><span
                                                class="glyphicon glyphicon-trash"></span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center">Nenhum documento foi encontrado.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="clearfix"></div>
                    <!-- Paginacao -->
                    @if($keyword)
                        {!! $documents->appends(['keyword' => $keyword])->links() !!}
                    @else
                        {!! $documents->links() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- /page content -->
@endsection
