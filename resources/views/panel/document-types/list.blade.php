@extends('layouts.panel')

@section('title', 'Gest&atilde;o de tipos de documentos')

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
                    <a class="btn btn-success" href="{{ route('document-types.create') }}"> Cadastrar novo tipo de documento +</a>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <table id="users-table" class="table table-bordred table-striped">
                        <thead>
                        <th>Name</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @forelse($documentTypes as $document)
                            <tr>
                                <td>{{ $document->name }}</td>
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
                                <td colspan="2" align="center">Nenhum tipo de documento foi encontrado.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="clearfix"></div>
                    <!-- Paginacao -->
                    @if($keyword)
                        {!! $documentTypes->appends(['keyword' => $keyword])->links() !!}
                    @else
                        {!! $documentTypes->links() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- /page content -->
@endsection
