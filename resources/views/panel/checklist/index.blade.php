@extends('layouts.panel')

@section('title', 'Empresa/Prestador')

@section('content')
        <!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2>Checklist
                    <span class="text-primary">Upload/Download de documentos</span>
                </h2>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-16">

                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="{{$activeMontly}}"><a href="{{route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>1])}}">Mensal</a></li>
                        <li role="presentation" class="{{$activeYearly}}"><a href="{{route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>2])}}">Anual</a></li>
                        <li role="presentation" class="{{$activeSolicited}}"><a href="{{route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>3])}}">Quando solicitado</a></li>
                        <li role="presentation" class="{{$activeHomologated}}"><a href="{{route('checklist.index', ['id'=>$employee->id, 'docTypeId'=>4])}}">Homologaçao</a></li>
                    </ul>
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
                                    <th>Validado</th>
                                    <th>A&ccedil;&otilde;es</th>
                                    </thead>
                                    <tbody>
                                    @foreach($documents as $docs)
                                        <tr>
                                            <td>{{$docs->name}}</td>
                                            <td>
                                                @if ($docs->status == 1)
                                                    Enviado
                                                @elseif ($docs->status == 2)
                                                    Reenviar
                                                @else
                                                    Pendente
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs->referenceDate)
                                                    {{date('d/m/Y', strtotime($docs->referenceDate))}}
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
                                                @if ($docs->validated == 1)
                                                    Sim
                                                @else
                                                    Nao
                                                @endif
                                            </td>
                                            <td>

                                                @if ($docs->validated == 1)
                                                    Baixar
                                                @else
                                                    Enviar
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
