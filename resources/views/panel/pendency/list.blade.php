@extends('layouts.panel')

@section('title', 'Gest&atilde;o de pend&ecirc;ncias')

@section('content')
        <!-- page content -->

<div class="right_col" role="main">

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <!-- menu breadcrumb -->
                @include('includes.breadcrumb')
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
                <table id="provider-table" class="table table-bordred table-striped">
                    <thead>
                    <th>Nome</th>
                    <th>Aprovar</th>
                    </thead>
                    <tbody>

                    @forelse($data as $row)
                        <tr class="line-light-red">
                            <td>
                                <a href="{{ route('pendency.show', ['companyId' => $row->companyId, 'id' => $row->id, 'source' => $source]) }}">{{ $row->name }}</a>
                            </td>
                            <td>
                                <a href="#"
                                   class="btn btn-success btn-xs modal-update" title="Aprovar"
                                   data-toggle="modal"
                                   data-target="#update"
                                   rel="{{ route('pendency.approve', ['companyId' => $row->companyId, 'id' => $row->id, 'source' => $source]) }}"
                                   rev="Tem certeza que deseja aprovar este registro?"><span
                                            class="glyphicon glyphicon-thumbs-up"></span></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" align="center">Nenhuma pend&ecirc;ncia foi encontrada.</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

                <div class="clearfix"></div>
                <!-- Paginacao -->
                {!! $data->links() !!}
            </div>
        </div>
    </div>
</div>


<!-- /page content -->
@endsection
