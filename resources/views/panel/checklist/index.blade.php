@extends('layouts.panel')

@section('title', 'Empresa/Prestador')

@section('content')
        <!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <!-- menu breadcrumb -->
                @include('includes.breadcrumb')
            </div>

            <div class="col-md-3">
                <form action=""
                      method="get">
                    <div class="input-group">

                            <span class="input-group-addon">
                                <a href=""
                                   title="Limpar busca">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </span>

                        <input class="form-control" type="text" id="referenceDateSearch" name="referenceDateSearch"
                               title="Data Referencia - Mes e Ano" placeholder="__/____"
                               value="" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-12">
                <div class="clearfix"></div>
            </div>

            <div class="col-md-16">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    @foreach($periodicities as $key => $value)
                        <li @if($key === $periodicityId) class="active" @endif>
                            <a href="{{route('checklist.company', ['periodicityId' => $key])}}">{{ $value }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-16">

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="montly">
                        <div class="table-responsive">
                            <table id="checklist-table" class="table table-bordred table-striped">
                                <thead>
                                <th>Documento</th>
                                <th>Status</th>
                                <th>Referencia</th>
                                <th>Envio</th>
                                <th>Processado</th>
                                <th>Status</th>
                                <th>A&ccedil;&otilde;es</th>
                                </thead>
                                <tbody>
                                @forelse($documents as $document)
                                    <tr>
                                        <td>{{ $document->name }}</td>
                                        <td>
                                            Enviado
                                            <!-- Reenviar -->
                                            <!--  Pendente -->
                                        </td>
                                        <td>
                                            <input class="referenceDateField"
                                                   data-date-format="mm/yyyy"
                                                   name="date"
                                                   title="Mes e Ano"
                                                   style="width: 100px;"
                                                   value="2017-09-29"
                                                   id="referenceDateField-1">

                                            <!-- <input class="referenceDateField"
                                                    data-date-format="mm/yyyy"
                                                    name="date"
                                                    title="Mes e Ano"
                                                    style="width: 100px;"
                                                    id="referenceDateField-1"> -->
                                        </td>
                                        <td>

                                            2017-09-29

                                        </td>
                                        <td>

                                            2017-09-29

                                        </td>
                                        <td>
                                            <!-- Validado -->
                                            Invalidado

                                            <form class="document-validated-form" name="document-validated-form"
                                                  id="document-validated-form-1">

                                                <a href=""
                                                   class="btn btn-warning btn-md modal-document-validated"
                                                   title="Validar Documento">Validar
                                                </a>

                                                <input class="employeeId" type="hidden" name="employeeId"
                                                       value="1">
                                                <input class="documentId" type="hidden" name="documentId"
                                                       value="1">
                                                <input class="referenceDate" type="hidden" name="referenceDate"
                                                       value="1">
                                                <input class="finalFileName" type="hidden" name="finalFileName"
                                                       value="1">
                                            </form>
                                            <!-- END ONLY ADMIN -->

                                        </td>
                                        <td>

                                            <a href=""
                                               class="btn btn-success btn-md modal-document-download"
                                               title="Download documento"
                                               id="modal-document-download-1">
                                                Baixar
                                            </a>


                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" align="center">Nenhum documento foi encontrado.</td>
                                    </tr>
                                @endforelse

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
