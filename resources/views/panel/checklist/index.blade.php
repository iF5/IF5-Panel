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
                <form action="{{ route('checklist.index', ['id'=>$employee->id,'docTypeId'=>$docTypeId]) }}"
                      method="get">
                    <div class="input-group">
                        @if($referenceDate)
                            <span class="input-group-addon">
                                <a href="{{ route('checklist.index', ['id'=>$employee->id,'docTypeId'=>$docTypeId]) }}"
                                   title="Limpar busca">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </span>
                        @endif
                        <input class="form-control" type="text" id="referenceDateSearch" name="referenceDateSearch"
                               title="Data Referencia - Mes e Ano" placeholder="__/____"
                               value="{{$referenceDate}}" required>
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
                <ul class="nav nav-tabs" role="tablist">
                    @if ($referenceDate)
                        <li role="presentation" class="{{$activeMontly}}"><a
                                    href="{{route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>1])}}?referenceDate={{$referenceDate}}">Mensal</a>
                        </li>
                    @else
                        <li role="presentation" class="{{$activeMontly}}"><a
                                    href="{{route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>1])}}">Mensal</a>
                        </li>
                    @endif

                    @if ($referenceDate)
                        <li role="presentation" class="{{$activeYearly}}"><a
                                    href="{{route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>2])}}?referenceDate={{$referenceDate}}">Anual</a>
                        </li>
                    @else
                        <li role="presentation" class="{{$activeYearly}}"><a
                                    href="{{route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>2])}}">Anual</a>
                        </li>
                    @endif

                    @if ($referenceDate)
                        <li role="presentation" class="{{$activeSolicited}}"><a
                                    href="{{route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>3])}}?referenceDate={{$referenceDate}}">Quando
                                solicitado</a></li>
                    @else
                        <li role="presentation" class="{{$activeSolicited}}"><a
                                    href="{{route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>3])}}">Quando
                                solicitado</a></li>
                    @endif

                    @if ($referenceDate)
                        <li role="presentation" class="{{$activeHomologated}}"><a
                                    href="{{route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>4])}}?referenceDate={{$referenceDate}}">Homologaçao</a>
                        </li>
                    @else
                        <li role="presentation" class="{{$activeHomologated}}"><a
                                    href="{{route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>4])}}">Homologaçao</a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="col-md-16">

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="montly">
                        <div class="table-responsive">
                            <table id="checklist-table" class="table table-bordred table-striped">
                                <thead>
                                <th>{{ucfirst($employee->name)}}</th>
                                <th>Status</th>
                                <th>Referencia</th>
                                <th>Envio</th>
                                <th>Processado</th>
                                <th>Status</th>
                                <th>A&ccedil;&otilde;es</th>
                                </thead>
                                <tbody>
                                @foreach($documents as $docs)
                                    <tr>
                                        <td>{{$docs->name}}</td>
                                        <td>
                                            @if ($docs->status == 1 and $docs->validated == 1)
                                                Enviado
                                            @elseif ($docs->status == 2 and $docs->validated == 0)
                                                Reenviar
                                            @else
                                                Pendente
                                            @endif
                                        </td>
                                        <td>
                                            @if ($docs->referenceDate)
                                                <input class="referenceDateField"
                                                       data-date-format="mm/yyyy"
                                                       name="date"
                                                       title="Mes e Ano"
                                                       style="width: 100px;"
                                                       value="{{date('m/Y', strtotime($docs->referenceDate))}}"
                                                       id="referenceDateField-{{$docs->id}}">
                                            @else
                                                <input class="referenceDateField"
                                                       data-date-format="mm/yyyy"
                                                       name="date"
                                                       title="Mes e Ano"
                                                       style="width: 100px;"
                                                       id="referenceDateField-{{$docs->id}}">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($docs->sendDate)
                                                {{date('d/m/Y H:i', strtotime($docs->sendDate))}}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($docs->receivedDate)
                                                {{date('d/m/Y H:i', strtotime($docs->receivedDate))}}
                                            @endif
                                        </td>
                                        <td>
                                            @can('onlyProvider')
                                                @if ($docs->validated == 1 and $docs->status == 1)
                                                    Validado
                                                @endif
                                                @if ($docs->validated == 0 and $docs->status == 1 and $docs->receivedDate)
                                                    Invalidado
                                                @endif
                                            @endcan

                                                @can('onlyAdmin')
                                                    <!-- BEGIN ONLY ADMIN -->
                                                    <form class="document-validated-form" name="document-validated-form"
                                                          id="document-validated-form-{{$docs->id}}">

                                                        @if ($docs->validated == 0 and $docs->status == 1)
                                                            <a href="{{ route('checklist.update', [
                                                            'employeeId' => $docs->employeeId,
                                                            'documentId' => $docs->documentId,
                                                            'referenceDate' => $docs->referenceDate,
                                                            'status' => 1 ]) }}"
                                                               class="btn btn-warning btn-md modal-document-validated"
                                                               title="Validar Documento">Validar
                                                            </a>
                                                        @elseif($docs->validated == 1 and $docs->status == 1)
                                                            <a href="{{ route('checklist.update', [
                                                            'employeeId' => $docs->employeeId,
                                                            'documentId' => $docs->documentId,
                                                            'referenceDate' => $docs->referenceDate,
                                                            'status' => 0 ]) }}"
                                                               class="btn btn-danger btn-md modal-document-invalidated"
                                                               title="Invalidar Documento">Invalidar
                                                            </a>
                                                        @endif

                                                        <input class="employeeId" type="hidden" name="employeeId"
                                                               value="{{$docs->employeeId}}">
                                                        <input class="documentId" type="hidden" name="documentId"
                                                               value="{{$docs->documentId}}">
                                                        <input class="referenceDate" type="hidden" name="referenceDate"
                                                               value="{{$docs->referenceDate}}">
                                                        <input class="finalFileName" type="hidden" name="finalFileName"
                                                               value="{{$docs->finalFileName}}">
                                                    </form>
                                                    <!-- END ONLY ADMIN -->
                                                @endcan
                                        </td>
                                        <td>
                                            @if ($docs->validated == 1 and $docs->status == 1)
                                                <a href="{{ route('checklist.download', [
                                                        'employeeId' => $docs->employeeId,
                                                        'documentId' => $docs->documentId,
                                                        'referenceDate' => $docs->referenceDate,
                                                        'finalFileName' => $docs->finalFileName ]) }}"
                                                   class="btn btn-success btn-md modal-document-download"
                                                   title="Download documento"
                                                   id="modal-document-download-{{$docs->id}}">
                                                    Baixar
                                                </a>
                                            @else
                                                @can('onlyProvider')
                                                    <a href=""
                                                       class="btn btn-primary btn-md modal-document-upload"
                                                       title="Enviar documento" data-toggle="modal"
                                                       data-target="#upload"
                                                       rel="{{ route('checklist.upload', ['documentId'=>$docs->id, 'referenceDate'=>'']) }}"
                                                       id="modal-document-upload-{{$docs->id}}">
                                                        Enviar
                                                    </a>
                                                @endcan
                                                @can('onlyAdmin')
                                                @if ($docs->status == 1)
                                                    <a href="{{ route('checklist.download', [
                                                        'employeeId' => $docs->employeeId,
                                                        'documentId' => $docs->documentId,
                                                        'referenceDate' => $docs->referenceDate,
                                                        'finalFileName' => $docs->finalFileName ]) }}"
                                                       class="btn btn-success btn-md modal-document-download"
                                                       title="Download documento"
                                                       id="modal-document-download-{{$docs->id}}">
                                                        Baixar
                                                    </a>
                                                @else
                                                    <a href=""
                                                       class="btn btn-primary btn-md modal-document-upload"
                                                       title="Enviar documento" data-toggle="modal"
                                                       data-target="#upload"
                                                       rel="{{ route('checklist.upload', ['documentId'=>$docs->id, 'referenceDate'=>'']) }}"
                                                       id="modal-document-upload-{{$docs->id}}">
                                                        Enviar
                                                    </a>
                                                @endif
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
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
