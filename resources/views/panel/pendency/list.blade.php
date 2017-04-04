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

            <div class="col-md-6">
                <!-- menu form-search -->
                @include('includes.form-search')
            </div>

            <div class="col-md-6"></div>

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
                                            class="glyphicon glyphicon-check"></span></a>
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
                @if($keyword)
                    {!! $data->appends(['keyword' => $keyword])->links() !!}
                @else
                    {!! $data->links() !!}
                @endif
            </div>
        </div>
    </div>
</div>


<!-- /page content -->
@endsection
