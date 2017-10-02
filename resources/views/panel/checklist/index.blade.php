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
                        @if($referenceDate)
                            <span class="input-group-addon">
                                <a href="{{ route('checklist.company.index', ['periodicity' => $periodicity]) }}"
                                   title="Limpar busca">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </span>
                        @endif
                        <input class="form-control" type="text" id="referenceDate" name="referenceDate"
                               title="Data Referencia - Mes e Ano" placeholder="mm/yyyy"
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
                        <li @if($key === $periodicity) class="active" @endif>
                            <a href="{{route('checklist.company.index', ['periodicity' => $key])}}">{{ $value }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-16">

                <!-- Tab panes -->
                <table id="checklist-table" class="table table-bordred table-striped">
                    <thead>
                    <th></th>
                    <th>Documento</th>
                    <th>Data de refer&ecirc;ncia</th>
                    <th>Validade</th>
                    <th>Status</th>
                    <th>A&ccedil;&otilde;es</th>
                    </thead>
                    <tbody>
                    @forelse($documents as $document)
                        <tr>

                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <span class='glyphicon glyphicon-info-sign'></span> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" style="min-width: 180px;">
                                        <li style="padding: 5px;">
                                            Enviado em : <strong> 08/10/2017</strong>
                                        </li>
                                        <li style="padding: 5px;">
                                            Reenviado em : <strong> 08/10/2017</strong>
                                        </li>
                                        <li style="padding: 5px;">
                                            Reprovado em :
                                        </li>
                                        <li style="padding: 5px;">
                                            Aprovado em : <strong> 08/10/2017</strong>
                                        </li>
                                    </ul>
                                </div>
                            </td>


                            <td width="30%">
                                {{ $document->name }}
                            </td>

                            <!--  Enviado -->
                            <!-- Reenviar -->
                            <!--  Pendente -->

                            <td>
                                <input class=""
                                       name="referenceDate"
                                       title="M&ecirc;s e Ano"
                                       style="text-align: center; width: 30%;"
                                       value="">
                            </td>
                            <td>
                                <input class=""
                                       name="validity"
                                       title="M&ecirc;s e Ano"
                                       style="text-align: center; width: 30%;"
                                       value="">
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

<!-- /page content -->
@endsection
